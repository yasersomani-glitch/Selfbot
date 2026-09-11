import sqlite3
from config import DB_PATH

def connect():
    db = sqlite3.connect(DB_PATH)
    db.row_factory = sqlite3.Row
    return db

def init_db():
    with connect() as db:
        db.executescript("""
        CREATE TABLE IF NOT EXISTS users(
            user_id INTEGER PRIMARY KEY,
            first_name TEXT DEFAULT '',
            username TEXT DEFAULT '',
            balance INTEGER DEFAULT 0,
            created_bots INTEGER DEFAULT 0,
            deleted_bots INTEGER DEFAULT 0,
            blocked INTEGER DEFAULT 0,
            referred_by INTEGER,
            referral_rewarded INTEGER DEFAULT 0
        );
        CREATE TABLE IF NOT EXISTS bots(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            owner_id INTEGER NOT NULL,
            bot_id INTEGER,
            username TEXT,
            token TEXT NOT NULL,
            status INTEGER DEFAULT 1,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS balance_requests(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            amount INTEGER NOT NULL,
            status TEXT DEFAULT 'pending',
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS support_messages(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            message_id INTEGER NOT NULL,
            status TEXT DEFAULT 'pending',
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS settings(
            key TEXT PRIMARY KEY,
            value TEXT NOT NULL
        );
        """)
        db.execute("INSERT OR IGNORE INTO settings(key,value) VALUES('parent_enabled','1')")
        db.commit()

def upsert_user(user_id, first_name="", username=""):
    with connect() as db:
        db.execute("""INSERT INTO users(user_id,first_name,username) VALUES(?,?,?)
        ON CONFLICT(user_id) DO UPDATE SET first_name=excluded.first_name, username=excluded.username""",
        (user_id, first_name or "", username or ""))
        db.commit()

def get_user(user_id):
    with connect() as db:
        return db.execute("SELECT * FROM users WHERE user_id=?", (user_id,)).fetchone()

def change_balance(user_id, amount):
    with connect() as db:
        db.execute("UPDATE users SET balance=balance+? WHERE user_id=?", (amount, user_id))
        db.commit()

def mark_created(user_id):
    with connect() as db:
        db.execute("UPDATE users SET created_bots=created_bots+1 WHERE user_id=?", (user_id,))
        db.commit()

def mark_deleted(user_id):
    with connect() as db:
        db.execute("UPDATE users SET deleted_bots=deleted_bots+1 WHERE user_id=?", (user_id,))
        db.commit()

def add_bot(owner_id, bot_id, username, token):
    with connect() as db:
        cur = db.execute("INSERT INTO bots(owner_id,bot_id,username,token) VALUES(?,?,?,?)",
                         (owner_id, bot_id, username, token))
        db.commit()
        return cur.lastrowid

def get_bots(owner_id):
    with connect() as db:
        return db.execute("SELECT * FROM bots WHERE owner_id=? ORDER BY id DESC", (owner_id,)).fetchall()

def get_bot(bot_db_id):
    with connect() as db:
        return db.execute("SELECT * FROM bots WHERE id=?", (bot_db_id,)).fetchone()

def get_bot_by_username(username):
    username = username.lstrip("@").lower()
    with connect() as db:
        return db.execute("SELECT * FROM bots WHERE lower(username)=?", (username,)).fetchone()

def all_bots():
    with connect() as db:
        return db.execute("SELECT * FROM bots ORDER BY id DESC").fetchall()

def set_bot_status(bot_db_id, status):
    with connect() as db:
        db.execute("UPDATE bots SET status=? WHERE id=?", (status, bot_db_id))
        db.commit()

def delete_bot_record(bot_db_id):
    with connect() as db:
        row = db.execute("SELECT * FROM bots WHERE id=?", (bot_db_id,)).fetchone()
        db.execute("DELETE FROM bots WHERE id=?", (bot_db_id,))
        db.commit()
        return row

def create_balance_request(user_id, amount):
    with connect() as db:
        cur = db.execute("INSERT INTO balance_requests(user_id,amount) VALUES(?,?)", (user_id, amount))
        db.commit()
        return cur.lastrowid

def get_balance_request(req_id):
    with connect() as db:
        return db.execute("SELECT * FROM balance_requests WHERE id=?", (req_id,)).fetchone()

def set_balance_request_status(req_id, status):
    with connect() as db:
        db.execute("UPDATE balance_requests SET status=? WHERE id=?", (status, req_id))
        db.commit()

def create_support(user_id, message_id):
    with connect() as db:
        cur = db.execute("INSERT INTO support_messages(user_id,message_id) VALUES(?,?)", (user_id,message_id))
        db.commit()
        return cur.lastrowid

def get_support(req_id):
    with connect() as db:
        return db.execute("SELECT * FROM support_messages WHERE id=?", (req_id,)).fetchone()

def set_support_status(req_id, status):
    with connect() as db:
        db.execute("UPDATE support_messages SET status=? WHERE id=?", (status, req_id))
        db.commit()

def setting(key, default=""):
    with connect() as db:
        row = db.execute("SELECT value FROM settings WHERE key=?", (key,)).fetchone()
        return row["value"] if row else default

def set_setting(key, value):
    with connect() as db:
        db.execute("""INSERT INTO settings(key,value) VALUES(?,?)
        ON CONFLICT(key) DO UPDATE SET value=excluded.value""", (key, str(value)))
        db.commit()

def user_count():
    with connect() as db:
        return db.execute("SELECT COUNT(*) FROM users").fetchone()[0]

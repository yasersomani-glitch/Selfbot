<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';


/*
|--------------------------------------------------------------------------
| اتصال به SQLite
|--------------------------------------------------------------------------
*/

function databaseConnection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $databasePath = DATABASE_PATH;

    $directory = dirname($databasePath);

    if (!is_dir($directory)) {
        mkdir(
            $directory,
            0777,
            true
        );
    }

    $pdo = new PDO(
        'sqlite:' . $databasePath
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

    $pdo->exec(
        'PRAGMA foreign_keys = ON'
    );

    $pdo->exec(
        'PRAGMA journal_mode = WAL'
    );

    return $pdo;
}


/*
|--------------------------------------------------------------------------
| اجرای Query
|--------------------------------------------------------------------------
*/

function databaseQuery(
    string $sql,
    array $params = []
): PDOStatement {

    $stmt = databaseConnection()->prepare($sql);

    $stmt->execute($params);

    return $stmt;
}


/*
|--------------------------------------------------------------------------
| ساخت دیتابیس
|--------------------------------------------------------------------------
*/

function installDatabase(): void
{
    /*
    |--------------------------------------------------------------------------
    | کاربران
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS users (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            telegram_id INTEGER UNIQUE NOT NULL,

            first_name TEXT DEFAULT "",

            last_name TEXT DEFAULT "",

            username TEXT DEFAULT "",

            diamonds INTEGER DEFAULT 0,

            build_limit INTEGER DEFAULT 0,

            created_bots INTEGER DEFAULT 0,

            blocked INTEGER DEFAULT 0,

            referral_id INTEGER DEFAULT NULL,

            referral_rewarded INTEGER DEFAULT 0,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | ربات‌های فرزند
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS child_bots (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            owner_id INTEGER NOT NULL,

            bot_id INTEGER UNIQUE NOT NULL,

            token TEXT UNIQUE NOT NULL,

            username TEXT DEFAULT "",

            first_name TEXT DEFAULT "",

            active INTEGER DEFAULT 1,

            language_default TEXT DEFAULT "fa",

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY(owner_id)
            REFERENCES users(telegram_id)
            ON DELETE CASCADE

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | زبان کاربران ربات فرزند
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS child_user_languages (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            bot_id INTEGER NOT NULL,

            user_id INTEGER NOT NULL,

            language TEXT DEFAULT "fa",

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            UNIQUE(bot_id, user_id)

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | وضعیت ربات پدر
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS parent_states (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            user_id INTEGER UNIQUE NOT NULL,

            state TEXT DEFAULT "",

            data TEXT DEFAULT "{}",

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | وضعیت ربات فرزند
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS child_states (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            bot_id INTEGER NOT NULL,

            user_id INTEGER NOT NULL,

            state TEXT DEFAULT "",

            data TEXT DEFAULT "{}",

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            UNIQUE(bot_id, user_id)

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | وضعیت ادمین
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS admin_states (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            user_id INTEGER UNIQUE NOT NULL,

            state TEXT DEFAULT "",

            data TEXT DEFAULT "{}",

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | زیرمجموعه
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS referrals (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            referrer_id INTEGER NOT NULL,

            referred_id INTEGER UNIQUE NOT NULL,

            reward INTEGER DEFAULT 1,

            rewarded INTEGER DEFAULT 1,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | نتایج موزیک
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS music_results (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            bot_id INTEGER NOT NULL,

            user_id INTEGER NOT NULL,

            result_index INTEGER NOT NULL,

            title TEXT DEFAULT "",

            artist TEXT DEFAULT "",

            audio_url TEXT DEFAULT "",

            cover_url TEXT DEFAULT "",

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            UNIQUE(
                bot_id,
                user_id,
                result_index
            )

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | لاگ ساخت ربات
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS bot_creation_logs (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            user_id INTEGER NOT NULL,

            bot_id INTEGER DEFAULT 0,

            cost INTEGER DEFAULT 5,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | تنظیمات
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE TABLE IF NOT EXISTS settings (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            setting_key TEXT UNIQUE NOT NULL,

            setting_value TEXT DEFAULT "",

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

        )
        '
    );


    /*
    |--------------------------------------------------------------------------
    | ایندکس‌ها
    |--------------------------------------------------------------------------
    */

    databaseQuery(
        '
        CREATE INDEX IF NOT EXISTS
        idx_users_telegram_id
        ON users(telegram_id)
        '
    );

    databaseQuery(
        '
        CREATE INDEX IF NOT EXISTS
        idx_child_bots_owner
        ON child_bots(owner_id)
        '
    );

    databaseQuery(
        '
        CREATE INDEX IF NOT EXISTS
        idx_child_states_bot_user
        ON child_states(bot_id, user_id)
        '
    );

    databaseQuery(
        '
        CREATE INDEX IF NOT EXISTS
        idx_music_results_bot_user
        ON music_results(bot_id, user_id)
        '
    );
}


/*
|--------------------------------------------------------------------------
| نصب خودکار دیتابیس
|--------------------------------------------------------------------------
*/

try {

    installDatabase();

} catch (Throwable $e) {

    error_log(
        'DATABASE ERROR: ' .
        $e->getMessage()
    );
}

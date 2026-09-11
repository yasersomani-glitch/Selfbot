from telegram import InlineKeyboardButton, InlineKeyboardMarkup
from config import PURCHASE_AMOUNTS, LANGUAGES

def main_menu():
    return InlineKeyboardMarkup([
        [InlineKeyboardButton("🤖 ساخت ربات", callback_data="create")],
        [InlineKeyboardButton("🤖 ربات‌های من", callback_data="mybots"),
         InlineKeyboardButton("👤 حساب کاربری", callback_data="account")],
        [InlineKeyboardButton("💳 خرید موجودی", callback_data="buy"),
         InlineKeyboardButton("🎧 پشتیبان فنی", callback_data="support")],
        [InlineKeyboardButton("🔴 زیرمجموعه", callback_data="referral")],
    ])

def back():
    return InlineKeyboardMarkup([[InlineKeyboardButton("↩️ بازگشت", callback_data="home")]])

def buy_menu():
    rows = []
    for i in range(0, len(PURCHASE_AMOUNTS), 3):
        rows.append([
            InlineKeyboardButton(f"💰 {x:,} تومان", callback_data=f"amount:{x}")
            for x in PURCHASE_AMOUNTS[i:i+3]
        ])
    rows.append([InlineKeyboardButton("↩️ بازگشت", callback_data="home")])
    return InlineKeyboardMarkup(rows)

def admin_request(req_id):
    return InlineKeyboardMarkup([[
        InlineKeyboardButton("✅ تأیید", callback_data=f"payok:{req_id}"),
        InlineKeyboardButton("❌ رد", callback_data=f"payno:{req_id}")
    ]])

def admin_support(req_id):
    return InlineKeyboardMarkup([[
        InlineKeyboardButton("💬 پاسخ", callback_data=f"supyes:{req_id}"),
        InlineKeyboardButton("❌ رد", callback_data=f"supno:{req_id}")
    ]])

def admin_menu():
    return InlineKeyboardMarkup([
        [InlineKeyboardButton("📊 آمار", callback_data="a:stats"),
         InlineKeyboardButton("💰 افزایش/کسر موجودی", callback_data="a:balance")],
        [InlineKeyboardButton("🤖 ساخت هر کاربر", callback_data="a:builds"),
         InlineKeyboardButton("👥 کاربران", callback_data="a:users")],
        [InlineKeyboardButton("🔒 بلاک/آنبلاک", callback_data="a:block")],
        [InlineKeyboardButton("🤖 ربات‌های ساخته‌شده", callback_data="a:bots")],
        [InlineKeyboardButton("⏯ خاموش/روشن پدر", callback_data="a:parent")],
        [InlineKeyboardButton("🗑 حذف ربات فرزند", callback_data="a:deletebot")],
        [InlineKeyboardButton("🔌 روشن/خاموش فرزند", callback_data="a:child")],
    ])

def child_languages():
    items = list(LANGUAGES.items())
    rows = []
    for i in range(0, len(items), 2):
        rows.append([
            InlineKeyboardButton(v, callback_data=f"lang:{k}")
            for k,v in items[i:i+2]
        ])
    return InlineKeyboardMarkup(rows)

def child_menu():
    return InlineKeyboardMarkup([[
        InlineKeyboardButton("🎵 جستجوی آهنگ", callback_data="music"),
        InlineKeyboardButton("📸 دانلود از اینستاگرام", callback_data="instagram")
    ]])

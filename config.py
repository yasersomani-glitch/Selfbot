import os

# =========================
# تنظیمات اصلی ربات
# =========================

BOT_TOKEN = "8954370347:AAFO-C7sv2ahDuLHXQEaEygX4RFNd8Q7SIQ"

ADMIN_ID = 8650091524

BOT_USERNAME = "Vsgtabot"

DB_PATH = os.path.join(os.path.dirname(__file__), "bot_data.db")

# قیمت ساخت هر ربات فرزند
CREATE_PRICE = 500

# پاداش زیرمجموعه
REFERRAL_REWARD = 50

# مبالغ خرید موجودی
PURCHASE_AMOUNTS = [
    1000,
    2000,
    5000,
    10000,
    20000,
    50000,
    100000,
    200000,
    500000,
]

# زبان‌های ربات فرزند
LANGUAGES = {
    "fa": "🇮🇷 فارسی",
    "en": "🇬🇧 English",
    "ar": "🇸🇦 العربية",
    "tr": "🇹🇷 Türkçe",
    "ru": "🇷🇺 Русский",
    "de": "🇩🇪 Deutsch",
    "fr": "🇫🇷 Français",
    "es": "🇪🇸 Español",
    "pt": "🇵🇹 Português",
    "hi": "🇮🇳 हिन्दी",
}

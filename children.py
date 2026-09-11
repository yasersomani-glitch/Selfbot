import asyncio
from telegram.ext import Application, CommandHandler, CallbackQueryHandler, MessageHandler, filters
from telegram import InlineKeyboardButton, InlineKeyboardMarkup
from keyboards import child_languages, child_menu
from services import search_music, download_audio

class ChildManager:
    def __init__(self):
        self.apps = {}
        self.user_modes = {}
        self.user_lang = {}

    async def start(self, row):
        if row["id"] in self.apps:
            return
        app = Application.builder().token(row["token"]).build()
        app.add_handler(CommandHandler("start", self.start_cmd))
        app.add_handler(CallbackQueryHandler(self.callback))
        app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, self.text))
        await app.initialize()
        await app.start()
        await app.updater.start_polling(allowed_updates=["message","callback_query"])
        self.apps[row["id"]] = app

    async def stop(self, bot_db_id):
        app = self.apps.pop(bot_db_id, None)
        if not app:
            return
        if app.updater.running:
            await app.updater.stop()
        await app.stop()
        await app.shutdown()

    def child_id(self, update):
        bot_id = update.get_bot().id
        for dbid, app in self.apps.items():
            if app.bot.id == bot_id:
                return dbid
        return None

    async def start_cmd(self, update, context):
        await update.message.reply_text("🌍 زبان خود را انتخاب کنید:", reply_markup=child_languages())

    async def callback(self, update, context):
        q = update.callback_query
        await q.answer()
        dbid = self.child_id(update)
        uid = q.from_user.id
        data = q.data

        if data.startswith("lang:"):
            self.user_lang[(dbid,uid)] = data.split(":",1)[1]
            await q.edit_message_text("✅ زبان انتخاب شد.\nیکی از خدمات را انتخاب کنید:", reply_markup=child_menu())
            return

        if data == "music":
            self.user_modes[(dbid,uid)] = "music"
            await q.edit_message_text("🎵 نام آهنگ یا خواننده را بفرستید:", reply_markup=child_menu())
            return

        if data == "instagram":
            self.user_modes[(dbid,uid)] = "instagram"
            await q.edit_message_text("📸 لینک پست یا ریل اینستاگرام را بفرستید:", reply_markup=child_menu())
            return

        if data.startswith("pick:"):
            await self.send_audio(q, data[5:])

    async def text(self, update, context):
        dbid = self.child_id(update)
        uid = update.effective_user.id
        mode = self.user_modes.get((dbid,uid))
        if not mode:
            return

        if mode == "music":
            await update.message.reply_text("🔎 در حال جستجو...")
            try:
                results = await search_music(update.message.text.strip(), 10)
                if not results:
                    await update.message.reply_text("❌ نتیجه‌ای پیدا نشد.")
                    return
                buttons = [[InlineKeyboardButton(t[:55], callback_data=f"pick:{url}")]
                           for t,url in results]
                await update.message.reply_text("🎶 ۱۰ نتیجه:", reply_markup=InlineKeyboardMarkup(buttons))
            except Exception:
                await update.message.reply_text("❌ جستجو انجام نشد.")
            return

        if mode == "instagram":
            await update.message.reply_text("⏳ در حال آماده‌سازی فایل صوتی...")
            try:
                path, title = await download_audio(update.message.text.strip())
                with open(path, "rb") as f:
                    await update.message.reply_audio(f, title=title)
            except Exception:
                await update.message.reply_text("❌ دانلود این لینک در حال حاضر ممکن نشد.")

    async def send_audio(self, q, url):
        await q.edit_message_text("⏳ در حال دانلود آهنگ...")
        try:
            path, title = await download_audio(url)
            with open(path, "rb") as f:
                await q.message.reply_audio(f, title=title)
        except Exception:
            await q.message.reply_text("❌ دانلود انجام نشد.")

manager = ChildManager()

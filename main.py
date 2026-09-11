import asyncio, logging
from telegram import Update, InlineKeyboardButton, InlineKeyboardMarkup, Bot
from telegram.ext import Application, CommandHandler, CallbackQueryHandler, MessageHandler, filters, ContextTypes

import database as db
from config import BOT_TOKEN, ADMIN_ID, BOT_USERNAME, CREATE_PRICE, REFERRAL_REWARD
from keyboards import main_menu, back, buy_menu, admin_request, admin_support, admin_menu
from children import manager

logging.basicConfig(level=logging.INFO, format="%(asctime)s | %(levelname)s | %(message)s")
modes = {}

def ensure(update):
    u = update.effective_user
    db.upsert_user(u.id, u.first_name, u.username)

def is_blocked(uid):
    u = db.get_user(uid)
    return bool(u and u["blocked"])

async def edit_or_send(update, text, markup):
    if update.callback_query:
        try:
            await update.callback_query.edit_message_text(text, reply_markup=markup)
        except Exception:
            await update.callback_query.message.reply_text(text, reply_markup=markup)
    else:
        await update.message.reply_text(text, reply_markup=markup)

async def start(update, context):
    ensure(update)
    uid = update.effective_user.id
    if context.args and context.args[0].startswith("ref_"):
        try:
            ref = int(context.args[0][4:])
            if ref != uid:
                with db.connect() as c:
                    row = c.execute("SELECT referred_by FROM users WHERE user_id=?", (uid,)).fetchone()
                    if row and row["referred_by"] is None:
                        c.execute("UPDATE users SET referred_by=? WHERE user_id=?", (ref, uid))
                        c.execute("UPDATE users SET balance=balance+? WHERE user_id=? AND referred_by IS NULL",
                                  (REFERRAL_REWARD, ref))
                        c.execute("UPDATE users SET referral_rewarded=1 WHERE user_id=?", (uid,))
                        c.commit()
                        try:
                            await context.bot.send_message(ref, f"🎉 رفرال جدید! {REFERRAL_REWARD:,} تومان به موجودی شما اضافه شد.")
                        except Exception:
                            pass
        except Exception:
            pass

    if is_blocked(uid) and uid != ADMIN_ID:
        return await update.message.reply_text("🚫 حساب شما مسدود است.")
    if db.setting("parent_enabled","1") != "1" and uid != ADMIN_ID:
        return await update.message.reply_text("⛔ ربات پدر موقتاً خاموش است.")
    await update.message.reply_text("🔥 پنل اصلی ربات‌ساز\n\nهمه امکانات از همین صفحه مدیریت می‌شود.", reply_markup=main_menu())

async def panel(update, context):
    ensure(update)
    if update.effective_user.id != ADMIN_ID:
        return await update.message.reply_text("⛔ دسترسی ندارید.")
    await update.message.reply_text("🛡 پنل مدیریت ربات پدر", reply_markup=admin_menu())

async def callbacks(update, context):
    q = update.callback_query
    await q.answer()
    ensure(update)
    uid = q.from_user.id
    data = q.data

    if is_blocked(uid) and uid != ADMIN_ID:
        return await q.edit_message_text("🚫 حساب شما مسدود است.")

    if data == "home":
        return await q.edit_message_text("🔥 پنل اصلی ربات‌ساز", reply_markup=main_menu())

    if data == "create":
        u = db.get_user(uid)
        if u["balance"] < CREATE_PRICE:
            return await q.edit_message_text(
                f"❌ موجودی شما کافی نیست.\n\n💰 موجودی: {u['balance']:,} تومان\n💳 هزینه ساخت: {CREATE_PRICE:,} تومان",
                reply_markup=InlineKeyboardMarkup([
                    [InlineKeyboardButton("💳 خرید موجودی", callback_data="buy")],
                    [InlineKeyboardButton("↩️ بازگشت", callback_data="home")]
                ]))
        modes[uid] = "token"
        return await q.edit_message_text(
            "🤖 ساخت ربات فرزند\n\n🔐 توکن رباتی که از @BotFather گرفته‌اید را ارسال کنید.\n\nپس از اعتبارسنجی، ۵۰۰ تومان از موجودی کسر و ربات فعال می‌شود.",
            reply_markup=back())

    if data == "account":
        u = db.get_user(uid)
        bots = db.get_bots(uid)
        return await q.edit_message_text(
            f"👤 حساب کاربری\n\n🆔 آیدی عددی: {u['user_id']}\n👤 نام: {u['first_name']}\n🔹 یوزرنیم: @{u['username'] or 'ندارد'}\n💰 موجودی: {u['balance']:,} تومان\n🤖 تعداد ربات ساخته‌شده: {u['created_bots']}\n🗑 ربات حذف‌شده: {u['deleted_bots']}\n📦 ربات ثبت‌شده: {len(bots)}",
            reply_markup=back())

    if data == "buy":
        return await q.edit_message_text("💳 مبلغ موجودی را انتخاب کنید:", reply_markup=buy_menu())

    if data.startswith("amount:"):
        amount = int(data.split(":")[1])
        rid = db.create_balance_request(uid, amount)
        await q.edit_message_text(
            f"💰 درخواست شارژ {amount:,} تومان ثبت شد.\n\nبعد از تأیید ادمین موجودی اضافه می‌شود.",
            reply_markup=back())
        await context.bot.send_message(
            ADMIN_ID,
            f"💳 درخواست خرید موجودی #{rid}\n👤 کاربر: {uid}\n💰 مبلغ: {amount:,} تومان",
            reply_markup=admin_request(rid))
        return

    if data == "mybots":
        bots = db.get_bots(uid)
        if not bots:
            return await q.edit_message_text("📦 شما تا حالا رباتی نساخته‌اید.", reply_markup=back())
        text = "🤖 ربات‌های من\n\n" + "\n".join(
            f"• @{b['username'] or 'بدون یوزرنیم'} — {'🟢 فعال' if b['status'] else '🔴 خاموش'}"
            for b in bots)
        return await q.edit_message_text(text, reply_markup=InlineKeyboardMarkup([
            [InlineKeyboardButton("🗑 حذف ربات", callback_data="botdelete")],
            [InlineKeyboardButton("🔄 آپدیت ربات", callback_data="botupdate"),
             InlineKeyboardButton("↩️ بازگشت", callback_data="home")]
        ]))

    if data == "botdelete":
        modes[uid] = "delete_own_bot"
        return await q.edit_message_text("🗑 یوزرنیم رباتی که می‌خواهید حذف شود را بفرستید:", reply_markup=back())

    if data == "botupdate":
        return await q.edit_message_text(
            "🔄 ربات با موفقیت در وضعیت آخرین نسخه قرار گرفت.\n\nبرای ربات‌های در حال اجرا، نسخه فعلی کد همین پروژه استفاده می‌شود.",
            reply_markup=back())

    if data == "support":
        modes[uid] = "support"
        return await q.edit_message_text("🎧 پیام خود را برای پشتیبان فنی ارسال کنید:", reply_markup=back())

    if data == "referral":
        link = f"https://t.me/{BOT_USERNAME}?start=ref_{uid}" if BOT_USERNAME else f"/start ref_{uid}"
        return await q.edit_message_text(
            f"👥 زیرمجموعه\n\n🎁 پاداش هر رفرال: {REFERRAL_REWARD:,} تومان\n\n🔗 لینک شما:\n{link}\n\nهر کاربر فقط یک بار برای معرف پاداش ایجاد می‌کند.",
            reply_markup=back())

    if uid == ADMIN_ID and data.startswith("pay"):
        rid = int(data.split(":")[1])
        req = db.get_balance_request(rid)
        if not req or req["status"] != "pending":
            return await q.edit_message_text("این درخواست قبلاً بررسی شده است.")
        if data.startswith("payok"):
            db.change_balance(req["user_id"], req["amount"])
            db.set_balance_request_status(rid, "approved")
            await context.bot.send_message(req["user_id"], f"✅ شارژ تأیید شد.\n💰 {req['amount']:,} تومان به موجودی شما اضافه شد.")
            return await q.edit_message_text("✅ درخواست تأیید شد.")
        db.set_balance_request_status(rid, "rejected")
        await context.bot.send_message(req["user_id"], "❌ درخواست شارژ شما رد شد.")
        return await q.edit_message_text("❌ درخواست رد شد.")

    if uid == ADMIN_ID and data.startswith("sup"):
        rid = int(data.split(":")[1])
        req = db.get_support(rid)
        if not req:
            return await q.edit_message_text("درخواست پیدا نشد.")
        if data.startswith("supno"):
            db.set_support_status(rid, "rejected")
            await context.bot.send_message(req["user_id"], "❌ پیام شما توسط پشتیبان رد شد.")
            return await q.edit_message_text("❌ درخواست رد شد.")
        modes[ADMIN_ID] = f"reply:{req['user_id']}:{rid}"
        return await q.edit_message_text("💬 پاسخ خود را ارسال کنید:", reply_markup=back())

    if uid == ADMIN_ID and data.startswith("a:"):
        action = data[2:]
        if action == "stats":
            return await q.edit_message_text(
                f"📊 آمار\n\n👥 کاربران: {db.user_count()}\n🤖 ربات‌های ثبت‌شده: {len(db.all_bots())}\n⚙️ پدر: {'روشن' if db.setting('parent_enabled','1')=='1' else 'خاموش'}",
                reply_markup=admin_menu())
        if action == "parent":
            new = "0" if db.setting("parent_enabled","1") == "1" else "1"
            db.set_setting("parent_enabled", new)
            return await q.edit_message_text(f"⏯ ربات پدر {'روشن' if new=='1' else 'خاموش'} شد.", reply_markup=admin_menu())

        prompts = {
            "balance":"آیدی و مقدار را بفرستید. مثال: 123456789 5000 یا 123456789 -5000",
            "block":"آیدی کاربر را بفرستید.",
            "deletebot":"یوزرنیم ربات فرزند را بفرستید.",
            "child":"یوزرنیم و وضعیت را بفرستید. مثال: @MyBot on یا @MyBot off",
            "builds":"آیدی کاربر را بفرستید.",
        }
        if action == "users":
            with db.connect() as c:
                rows = c.execute("SELECT user_id,first_name,username,balance,created_bots,blocked FROM users ORDER BY user_id DESC LIMIT 50").fetchall()
            txt = "👥 کاربران\n\n" + "\n".join(
                f"{r['user_id']} | {r['first_name']} | @{r['username'] or '-'} | {r['balance']} | bots:{r['created_bots']} | {'BLOCK' if r['blocked'] else 'OK'}"
                for r in rows)
            return await q.edit_message_text(txt[:4000], reply_markup=admin_menu())
        if action == "bots":
            bots = db.all_bots()
            txt = "🤖 ربات‌های ساخته‌شده\n\n" + "\n".join(
                f"@{b['username'] or '-'} | مالک: {b['owner_id']} | {'روشن' if b['status'] else 'خاموش'}"
                for b in bots) or "موردی نیست"
            return await q.edit_message_text(txt[:4000], reply_markup=admin_menu())
        if action in prompts:
            modes[ADMIN_ID] = "admin:" + action
            return await q.edit_message_text(prompts[action], reply_markup=back())

async def messages(update, context):
    ensure(update)
    uid = update.effective_user.id
    mode = modes.get(uid)
    if not mode:
        return

    if mode == "token":
        token = update.message.text.strip()
        try:
            temp = Bot(token)
            me = await temp.get_me()
            if not me.is_bot:
                raise ValueError()
            u = db.get_user(uid)
            if u["balance"] < CREATE_PRICE:
                modes.pop(uid, None)
                return await update.message.reply_text("❌ موجودی شما کافی نیست.", reply_markup=main_menu())

            # Reserve the database record before starting the child.
            bot_db_id = db.add_bot(uid, me.id, me.username or "", token)
            row = db.get_bot(bot_db_id)
            await manager.start(row)
            db.change_balance(uid, -CREATE_PRICE)
            db.mark_created(uid)
            modes.pop(uid, None)
            await update.message.reply_text(
                f"🎉 ربات با موفقیت ساخته و فعال شد!\n\n🤖 @{me.username or me.first_name}\n💰 {CREATE_PRICE:,} تومان کسر شد.",
                reply_markup=main_menu())
        except Exception:
            await update.message.reply_text("❌ توکن معتبر نیست یا راه‌اندازی ربات انجام نشد. توکن را دوباره ارسال کنید.", reply_markup=back())
        return

    if mode == "delete_own_bot":
        row = db.get_bot_by_username(update.message.text.strip())
        if not row or row["owner_id"] != uid:
            return await update.message.reply_text("❌ این ربات برای شما پیدا نشد.", reply_markup=back())
        await manager.stop(row["id"])
        db.delete_bot_record(row["id"])
        db.mark_deleted(uid)
        modes.pop(uid, None)
        return await update.message.reply_text("✅ ربات از سرور و لیست شما حذف شد.", reply_markup=main_menu())

    if mode == "support":
        rid = db.create_support(uid, update.message.message_id)
        await context.bot.send_message(
            ADMIN_ID,
            f"🎧 پیام پشتیبانی #{rid}\n👤 کاربر: {uid}\n\nپیام کاربر در پیام بعدی ارسال می‌شود.",
            reply_markup=admin_support(rid))
        await update.message.forward(ADMIN_ID)
        modes.pop(uid, None)
        return await update.message.reply_text("✅ پیام شما به ادمین ارسال شد. به‌زودی پاسخ داده می‌شود.", reply_markup=main_menu())

    if mode.startswith("reply:") and uid == ADMIN_ID:
        _, target, rid = mode.split(":")
        await context.bot.send_message(int(target), f"💬 پاسخ پشتیبانی:\n\n{update.message.text}")
        db.set_support_status(int(rid), "answered")
        modes.pop(uid, None)
        return await update.message.reply_text("✅ پاسخ برای کاربر ارسال شد.", reply_markup=admin_menu())

    if uid == ADMIN_ID and mode.startswith("admin:"):
        action = mode.split(":",1)[1]
        text = update.message.text.strip()
        try:
            if action == "balance":
                p = text.split()
                db.change_balance(int(p[0]), int(p[1]))
                await update.message.reply_text("✅ موجودی تغییر کرد.", reply_markup=admin_menu())
            elif action == "block":
                x = int(text)
                with db.connect() as c:
                    u = c.execute("SELECT blocked FROM users WHERE user_id=?", (x,)).fetchone()
                    if u:
                        c.execute("UPDATE users SET blocked=? WHERE user_id=?", (0 if u["blocked"] else 1, x))
                    c.commit()
                await update.message.reply_text("✅ وضعیت کاربر تغییر کرد.", reply_markup=admin_menu())
            elif action == "deletebot":
                row = db.get_bot_by_username(text)
                if not row:
                    return await update.message.reply_text("❌ ربات پیدا نشد.", reply_markup=admin_menu())
                await manager.stop(row["id"])
                db.delete_bot_record(row["id"])
                db.mark_deleted(row["owner_id"])
                await update.message.reply_text("✅ ربات حذف شد.", reply_markup=admin_menu())
            elif action == "child":
                p = text.split()
                row = db.get_bot_by_username(p[0])
                if not row:
                    return await update.message.reply_text("❌ ربات پیدا نشد.", reply_markup=admin_menu())
                st = 1 if p[1].lower() == "on" else 0
                db.set_bot_status(row["id"], st)
                if st: await manager.start(row)
                else: await manager.stop(row["id"])
                await update.message.reply_text("✅ وضعیت ربات تغییر کرد.", reply_markup=admin_menu())
            elif action == "builds":
                u = db.get_user(int(text))
                await update.message.reply_text(f"🤖 تعداد ساخت: {u['created_bots'] if u else 0}", reply_markup=admin_menu())
        except Exception:
            await update.message.reply_text("❌ فرمت یا عملیات نادرست است.", reply_markup=admin_menu())
        modes.pop(uid, None)

async def run():
    if not BOT_TOKEN or not ADMIN_ID:
        raise RuntimeError("BOT_TOKEN و ADMIN_ID را در .env تنظیم کنید.")
    db.init_db()

    for row in db.all_bots():
        if row["status"]:
            try:
                await manager.start(row)
            except Exception:
                logging.exception("Child startup failed: %s", row["username"])

    app = Application.builder().token(BOT_TOKEN).build()
    app.add_handler(CommandHandler("start", start))
    app.add_handler(CommandHandler("panel", panel))
    app.add_handler(CallbackQueryHandler(callbacks))
    app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, messages))
    await app.initialize()
    await app.start()
    await app.updater.start_polling()
    await asyncio.Event().wait()

if __name__ == "__main__":
    asyncio.run(run())

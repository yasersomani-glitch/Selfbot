<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/telegram.php';

/*
|--------------------------------------------------------------------------
| ADMIN.PHP
|--------------------------------------------------------------------------
| پنل مدیریت ربات پدر
|
| امکانات:
| - آمار
| - ارسال الماس
| - کسر الماس
| - ارسال پیام به کاربر
| - ارسال همگانی
| - بلاک
| - آنبلاک
| - تعیین تعداد ساخت ربات
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| بررسی ادمین
|--------------------------------------------------------------------------
*/

function isAdmin(int $userId): bool
{
    return $userId > 0 &&
           defined('OWNER_ID') &&
           (int)OWNER_ID === $userId;
}


/*
|--------------------------------------------------------------------------
| پنل اصلی مدیریت
|--------------------------------------------------------------------------
*/

function showAdminPanel(
    int $chatId,
    ?int $messageId = null
): void {

    $text =
        "👑 <b>پنل مدیریت</b>\n\n" .
        "از منوی زیر عملیات مورد نظر را انتخاب کنید:";

    $keyboard = [

        'inline_keyboard' => [

            [
                [
                    'text' => '📊 آمار ربات',
                    'callback_data' => 'admin_stats'
                ]
            ],

            [
                [
                    'text' => '💎 ارسال الماس',
                    'callback_data' => 'admin_add_diamond'
                ],

                [
                    'text' => '➖ کسر الماس',
                    'callback_data' => 'admin_remove_diamond'
                ]
            ],

            [
                [
                    'text' => '💬 ارسال به کاربر',
                    'callback_data' => 'admin_message_user'
                ]
            ],

            [
                [
                    'text' => '📢 ارسال همگانی',
                    'callback_data' => 'admin_broadcast'
                ]
            ],

            [
                [
                    'text' => '🚫 بلاک کاربر',
                    'callback_data' => 'admin_block'
                ],

                [
                    'text' => '✅ آنبلاک کاربر',
                    'callback_data' => 'admin_unblock'
                ]
            ],

            [
                [
                    'text' => '🔢 تعداد ساخت ربات',
                    'callback_data' => 'admin_build_limit'
                ]
            ]

        ]

    ];

    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            $keyboard
        );

        return;
    }

    sendMessage(
        $chatId,
        $text,
        $keyboard
    );
}


/*
|--------------------------------------------------------------------------
| منوی برگشت مدیریت
|--------------------------------------------------------------------------
*/

function adminBackKeyboard(): array
{
    return [

        'inline_keyboard' => [

            [
                [
                    'text' => '🔙 برگشت',
                    'callback_data' => 'admin_home'
                ]
            ]

        ]

    ];
}


/*
|--------------------------------------------------------------------------
| آمار
|--------------------------------------------------------------------------
*/

function showAdminStats(
    int $chatId,
    ?int $messageId = null
): void {

    $stats =
        getBotStatistics();

    $users =
        (int)($stats['users'] ?? 0);

    $bots =
        (int)($stats['bots'] ?? 0);

    $activeBots =
        (int)($stats['active_bots'] ?? 0);

    $blocked =
        (int)($stats['blocked'] ?? 0);

    $text =
        "📊 <b>آمار ربات</b>\n\n" .

        "👥 کاربران: <b>" .
        number_format($users) .
        "</b>\n\n" .

        "🤖 ربات‌های ساخته‌شده: <b>" .
        number_format($bots) .
        "</b>\n\n" .

        "🟢 ربات‌های فعال: <b>" .
        number_format($activeBots) .
        "</b>\n\n" .

        "🚫 کاربران بلاک‌شده: <b>" .
        number_format($blocked) .
        "</b>";

    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            adminBackKeyboard()
        );

        return;
    }

    sendMessage(
        $chatId,
        $text,
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| درخواست ID کاربر برای ارسال الماس
|--------------------------------------------------------------------------
*/

function adminAskAddDiamond(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'add_diamond'
    );

    sendMessage(
        $chatId,
        "💎 <b>ارسال الماس</b>\n\n" .
        "آیدی عددی کاربر را ارسال کنید:\n\n" .
        "مثال:\n" .
        "<code>123456789</code>",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| درخواست ID کاربر برای کسر الماس
|--------------------------------------------------------------------------
*/

function adminAskRemoveDiamond(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'remove_diamond'
    );

    sendMessage(
        $chatId,
        "➖ <b>کسر الماس</b>\n\n" .
        "آیدی عددی کاربر را ارسال کنید:",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| ارسال الماس
|--------------------------------------------------------------------------
*/

function adminAddDiamond(
    int $chatId,
    int $userId,
    int $amount
): void {

    if ($amount <= 0) {

        sendMessage(
            $chatId,
            "❌ مقدار الماس باید بیشتر از صفر باشد."
        );

        return;
    }

    if (
        !userExists($userId)
    ) {

        sendMessage(
            $chatId,
            "❌ کاربر پیدا نشد."
        );

        return;
    }

    addDiamonds(
        $userId,
        $amount
    );

    sendMessage(
        $chatId,
        "✅ با موفقیت انجام شد.\n\n" .
        "👤 کاربر: <code>{$userId}</code>\n" .
        "💎 مقدار اضافه‌شده: <b>{$amount}</b>"
    );
}


/*
|--------------------------------------------------------------------------
| کسر الماس
|--------------------------------------------------------------------------
*/

function adminRemoveDiamond(
    int $chatId,
    int $userId,
    int $amount
): void {

    if ($amount <= 0) {

        sendMessage(
            $chatId,
            "❌ مقدار الماس باید بیشتر از صفر باشد."
        );

        return;
    }

    if (
        !userExists($userId)
    ) {

        sendMessage(
            $chatId,
            "❌ کاربر پیدا نشد."
        );

        return;
    }

    $removed =
        removeDiamonds(
            $userId,
            $amount
        );

    if (!$removed) {

        sendMessage(
            $chatId,
            "❌ موجودی کاربر کافی نیست."
        );

        return;
    }

    sendMessage(
        $chatId,
        "✅ با موفقیت انجام شد.\n\n" .
        "👤 کاربر: <code>{$userId}</code>\n" .
        "➖ مقدار کسرشده: <b>{$amount}</b>"
    );
}


/*
|--------------------------------------------------------------------------
| ارسال پیام به کاربر
|--------------------------------------------------------------------------
*/

function adminAskMessageUser(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'message_user'
    );

    sendMessage(
        $chatId,
        "💬 <b>ارسال پیام به کاربر</b>\n\n" .
        "اول آیدی عددی کاربر را ارسال کنید.",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| ارسال پیام
|--------------------------------------------------------------------------
*/

function adminSendMessageToUser(
    int $adminChatId,
    int $userId,
    string $text
): void {

    if (
        !userExists($userId)
    ) {

        sendMessage(
            $adminChatId,
            "❌ کاربر پیدا نشد."
        );

        return;
    }

    $result =
        sendMessage(
            $userId,
            $text
        );

    if ($result !== null) {

        sendMessage(
            $adminChatId,
            "✅ پیام با موفقیت ارسال شد."
        );

    } else {

        sendMessage(
            $adminChatId,
            "❌ ارسال پیام ناموفق بود."
        );
    }
}


/*
|--------------------------------------------------------------------------
| ارسال همگانی
|--------------------------------------------------------------------------
*/

function adminStartBroadcast(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'broadcast'
    );

    sendMessage(
        $chatId,
        "📢 <b>ارسال همگانی</b>\n\n" .
        "متنی را که می‌خواهید برای همه کاربران ارسال شود بفرستید.",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| انجام Broadcast
|--------------------------------------------------------------------------
*/

function adminBroadcast(
    int $adminChatId,
    string $text
): void {

    $users =
        getAllUserIds();

    if (
        count($users) === 0
    ) {

        sendMessage(
            $adminChatId,
            "❌ کاربری برای ارسال وجود ندارد."
        );

        return;
    }

    $success = 0;

    $failed = 0;

    foreach (
        $users as $userId
    ) {

        $result =
            sendMessage(
                (int)$userId,
                $text
            );

        if ($result !== null) {

            $success++;

        } else {

            $failed++;
        }

        /*
        | جلوگیری از فشار بیش از حد
        */

        usleep(60000);
    }

    sendMessage(
        $adminChatId,
        "📢 <b>ارسال همگانی تمام شد.</b>\n\n" .
        "✅ موفق: <b>{$success}</b>\n" .
        "❌ ناموفق: <b>{$failed}</b>"
    );
}


/*
|--------------------------------------------------------------------------
| بلاک
|--------------------------------------------------------------------------
*/

function adminAskBlock(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'block_user'
    );

    sendMessage(
        $chatId,
        "🚫 <b>بلاک کاربر</b>\n\n" .
        "آیدی عددی کاربر را ارسال کنید.",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| انجام بلاک
|--------------------------------------------------------------------------
*/

function adminBlockUser(
    int $adminChatId,
    int $userId
): void {

    if (
        $userId === (int)OWNER_ID
    ) {

        sendMessage(
            $adminChatId,
            "❌ نمی‌توان مالک ربات را بلاک کرد."
        );

        return;
    }

    blockUser(
        $userId
    );

    sendMessage(
        $adminChatId,
        "🚫 کاربر بلاک شد.\n\n" .
        "ID: <code>{$userId}</code>"
    );
}


/*
|--------------------------------------------------------------------------
| آنبلاک
|--------------------------------------------------------------------------
*/

function adminAskUnblock(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'unblock_user'
    );

    sendMessage(
        $chatId,
        "✅ <b>آنبلاک کاربر</b>\n\n" .
        "آیدی عددی کاربر را ارسال کنید.",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| انجام آنبلاک
|--------------------------------------------------------------------------
*/

function adminUnblockUser(
    int $adminChatId,
    int $userId
): void {

    unblockUser(
        $userId
    );

    sendMessage(
        $adminChatId,
        "✅ کاربر آنبلاک شد.\n\n" .
        "ID: <code>{$userId}</code>"
    );
}


/*
|--------------------------------------------------------------------------
| تعیین تعداد دفعات ساخت ربات
|--------------------------------------------------------------------------
*/

function adminAskBuildLimit(
    int $chatId
): void {

    setAdminState(
        $chatId,
        'build_limit'
    );

    sendMessage(
        $chatId,
        "🔢 <b>تعداد دفعات ساخت ربات</b>\n\n" .
        "آیدی کاربر را ارسال کنید:",
        adminBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| تنظیم تعداد ساخت
|--------------------------------------------------------------------------
*/

function adminSetBuildLimit(
    int $adminChatId,
    int $userId,
    int $limit
): void {

    if ($limit < 0) {

        sendMessage(
            $adminChatId,
            "❌ مقدار نامعتبر است."
        );

        return;
    }

    if (
        !userExists($userId)
    ) {

        sendMessage(
            $adminChatId,
            "❌ کاربر پیدا نشد."
        );

        return;
    }

    setUserBuildLimit(
        $userId,
        $limit
    );

    sendMessage(
        $adminChatId,
        "✅ تعداد مجاز ساخت ربات تنظیم شد.\n\n" .
        "👤 ID: <code>{$userId}</code>\n" .
        "🔢 تعداد: <b>{$limit}</b>"
    );
}


/*
|--------------------------------------------------------------------------
| پردازش Callback پنل مدیریت
|--------------------------------------------------------------------------
*/

function handleAdminCallback(
    int $chatId,
    string $callbackId,
    string $data,
    int $messageId
): void {

    if (
        !isAdmin($chatId)
    ) {

        answerCallback(
            $callbackId,
            '🚫 دسترسی ندارید.',
            true
        );

        return;
    }

    answerCallback(
        $callbackId
    );

    switch ($data) {

        case 'admin_home':

            showAdminPanel(
                $chatId,
                $messageId
            );

            break;


        case 'admin_stats':

            showAdminStats(
                $chatId,
                $messageId
            );

            break;


        case 'admin_add_diamond':

            adminAskAddDiamond(
                $chatId
            );

            break;


        case 'admin_remove_diamond':

            adminAskRemoveDiamond(
                $chatId
            );

            break;


        case 'admin_message_user':

            adminAskMessageUser(
                $chatId
            );

            break;


        case 'admin_broadcast':

            adminStartBroadcast(
                $chatId
            );

            break;


        case 'admin_block':

            adminAskBlock(
                $chatId
            );

            break;


        case 'admin_unblock':

            adminAskUnblock(
                $chatId
            );

            break;


        case 'admin_build_limit':

            adminAskBuildLimit(
                $chatId
            );

            break;


        default:

            break;
    }
}


/*
|--------------------------------------------------------------------------
| پردازش پیام‌های پنل مدیریت
|--------------------------------------------------------------------------
*/

function handleAdminText(
    int $chatId,
    string $text
): void {

    if (
        !isAdmin($chatId)
    ) {

        return;
    }

    $text =
        trim($text);

    if ($text === '') {

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | پنل
    |--------------------------------------------------------------------------
    */

    if (
        $text === '/admin' ||
        $text === '/panel'
    ) {

        clearAdminState(
            $chatId
        );

        showAdminPanel(
            $chatId
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | وضعیت فعلی
    |--------------------------------------------------------------------------
    */

    $state =
        getAdminState(
            $chatId
        );

    if (!$state) {

        showAdminPanel(
            $chatId
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Add Diamond
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'add_diamond'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ فقط آیدی عددی ارسال کنید."
            );

            return;
        }

        setAdminState(
            $chatId,
            'add_diamond_amount',
            [
                'user_id' => (int)$text
            ]
        );

        sendMessage(
            $chatId,
            "💎 مقدار الماس را ارسال کنید:"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Add Diamond Amount
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'add_diamond_amount'
    ) {

        $data =
            getAdminStateData(
                $chatId
            );

        $userId =
            (int)($data['user_id'] ?? 0);

        $amount =
            (int)$text;

        adminAddDiamond(
            $chatId,
            $userId,
            $amount
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Diamond
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'remove_diamond'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ فقط آیدی عددی ارسال کنید."
            );

            return;
        }

        setAdminState(
            $chatId,
            'remove_diamond_amount',
            [
                'user_id' => (int)$text
            ]
        );

        sendMessage(
            $chatId,
            "➖ مقدار الماس برای کسر را ارسال کنید:"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Diamond Amount
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'remove_diamond_amount'
    ) {

        $data =
            getAdminStateData(
                $chatId
            );

        $userId =
            (int)($data['user_id'] ?? 0);

        $amount =
            (int)$text;

        adminRemoveDiamond(
            $chatId,
            $userId,
            $amount
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | پیام به کاربر
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'message_user'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ فقط آیدی عددی ارسال کنید."
            );

            return;
        }

        setAdminState(
            $chatId,
            'message_user_text',
            [
                'user_id' => (int)$text
            ]
        );

        sendMessage(
            $chatId,
            "💬 متن پیام را ارسال کنید:"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | متن پیام به کاربر
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'message_user_text'
    ) {

        $data =
            getAdminStateData(
                $chatId
            );

        $userId =
            (int)($data['user_id'] ?? 0);

        adminSendMessageToUser(
            $chatId,
            $userId,
            $text
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Broadcast
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'broadcast'
    ) {

        adminBroadcast(
            $chatId,
            $text
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Block
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'block_user'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی عددی معتبر ارسال کنید."
            );

            return;
        }

        adminBlockUser(
            $chatId,
            (int)$text
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Unblock
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'unblock_user'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی عددی معتبر ارسال کنید."
            );

            return;
        }

        adminUnblockUser(
            $chatId,
            (int)$text
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Build Limit
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'build_limit'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی عددی معتبر ارسال کنید."
            );

            return;
        }

        setAdminState(
            $chatId,
            'build_limit_value',
            [
                'user_id' => (int)$text
            ]
        );

        sendMessage(
            $chatId,
            "🔢 تعداد دفعات مجاز ساخت ربات را ارسال کنید:\n\n" .
            "مثلاً:\n" .
            "<code>5</code>"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Build Limit Value
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'build_limit_value'
    ) {

        $data =
            getAdminStateData(
                $chatId
            );

        $userId =
            (int)($data['user_id'] ?? 0);

        $limit =
            (int)$text;

        adminSetBuildLimit(
            $chatId,
            $userId,
            $limit
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | وضعیت ناشناخته
    |--------------------------------------------------------------------------
    */

    clearAdminState(
        $chatId
    );

    showAdminPanel(
        $chatId
    );
}
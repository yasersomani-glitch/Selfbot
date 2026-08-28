<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| ADMIN.PHP
|--------------------------------------------------------------------------
| پنل مدیریت ربات پدر
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| بررسی مالک
|--------------------------------------------------------------------------
*/

function isAdmin(
    int $userId
): bool {

    return
        defined('OWNER_ID') &&
        (int)OWNER_ID > 0 &&
        $userId === (int)OWNER_ID;
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
        "یکی از گزینه‌های زیر را انتخاب کنید:";

    $keyboard = [

        'inline_keyboard' => [

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
                    'text' => '📢 ارسال همگانی',
                    'callback_data' => 'admin_broadcast'
                ]
            ],

            [
                [
                    'text' => '👤 ارسال به کاربر',
                    'callback_data' => 'admin_message_user'
                ]
            ],

            [
                [
                    'text' => '📊 آمار ربات',
                    'callback_data' => 'admin_stats'
                ]
            ],

            [
                [
                    'text' => '🤖 تعداد ساخت ربات',
                    'callback_data' => 'admin_build_limit'
                ]
            ],

            [
                [
                    'text' => '🚫 بلاک کاربر',
                    'callback_data' => 'admin_block'
                ],
                [
                    'text' => '✅ آن‌بلاک کاربر',
                    'callback_data' => 'admin_unblock'
                ]
            ],

            [
                [
                    'text' => '🤖 ربات‌های فرزند',
                    'callback_data' => 'admin_child_bots'
                ]
            ]

        ]

    ];


    if (
        $messageId !== null
    ) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            $keyboard
        );

    } else {

        sendMessage(
            $chatId,
            $text,
            $keyboard
        );
    }
}


/*
|--------------------------------------------------------------------------
| وضعیت مدیریت
|--------------------------------------------------------------------------
*/

function getAdminState(
    int $userId
): string {

    $stmt =
        databaseQuery(
            '
            SELECT state
            FROM admin_states
            WHERE user_id = ?
            LIMIT 1
            ',
            [
                $userId
            ]
        );

    $row =
        $stmt->fetch();

    if (!$row) {
        return '';
    }

    return
        (string)(
            $row['state'] ?? ''
        );
}


/*
|--------------------------------------------------------------------------
| تنظیم وضعیت مدیریت
|--------------------------------------------------------------------------
*/

function setAdminState(
    int $userId,
    string $state
): void {

    databaseQuery(
        '
        INSERT INTO admin_states
        (
            user_id,
            state,
            data,
            updated_at
        )
        VALUES
        (
            ?,
            ?,
            "{}",
            CURRENT_TIMESTAMP
        )
        ON CONFLICT(user_id)
        DO UPDATE SET
            state = excluded.state,
            updated_at = CURRENT_TIMESTAMP
        ',
        [
            $userId,
            $state
        ]
    );
}


/*
|--------------------------------------------------------------------------
| حذف وضعیت مدیریت
|--------------------------------------------------------------------------
*/

function clearAdminState(
    int $userId
): void {

    databaseQuery(
        '
        DELETE FROM admin_states
        WHERE user_id = ?
        ',
        [
            $userId
        ]
    );
}


/*
|--------------------------------------------------------------------------
| افزودن الماس
|--------------------------------------------------------------------------
*/

function adminAddDiamonds(
    int $userId,
    int $amount
): bool {

    if (
        $amount <= 0
    ) {
        return false;
    }

    $stmt =
        databaseQuery(
            '
            UPDATE users
            SET diamonds = diamonds + ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = ?
            ',
            [
                $amount,
                $userId
            ]
        );

    return
        $stmt->rowCount() > 0;
}


/*
|--------------------------------------------------------------------------
| کسر الماس
|--------------------------------------------------------------------------
*/

function adminRemoveDiamonds(
    int $userId,
    int $amount
): bool {

    if (
        $amount <= 0
    ) {
        return false;
    }

    $stmt =
        databaseQuery(
            '
            UPDATE users
            SET diamonds =
                CASE
                    WHEN diamonds >= ?
                    THEN diamonds - ?
                    ELSE 0
                END,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = ?
            ',
            [
                $amount,
                $amount,
                $userId
            ]
        );

    return
        $stmt->rowCount() > 0;
}


/*
|--------------------------------------------------------------------------
| بلاک کاربر
|--------------------------------------------------------------------------
*/

function adminBlockUser(
    int $userId
): bool {

    $stmt =
        databaseQuery(
            '
            UPDATE users
            SET blocked = 1,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = ?
            ',
            [
                $userId
            ]
        );

    return
        $stmt->rowCount() > 0;
}


/*
|--------------------------------------------------------------------------
| آن‌بلاک کاربر
|--------------------------------------------------------------------------
*/

function adminUnblockUser(
    int $userId
): bool {

    $stmt =
        databaseQuery(
            '
            UPDATE users
            SET blocked = 0,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = ?
            ',
            [
                $userId
            ]
        );

    return
        $stmt->rowCount() > 0;
}


/*
|--------------------------------------------------------------------------
| تعیین محدودیت ساخت
|--------------------------------------------------------------------------
*/

function adminSetBuildLimit(
    int $userId,
    int $limit
): bool {

    if (
        $limit < 0
    ) {
        return false;
    }

    $stmt =
        databaseQuery(
            '
            UPDATE users
            SET build_limit = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = ?
            ',
            [
                $limit,
                $userId
            ]
        );

    return
        $stmt->rowCount() > 0;
}


/*
|--------------------------------------------------------------------------
| آمار ربات
|--------------------------------------------------------------------------
*/

function getAdminStats(): array
{

    $users =
        (int)(
            databaseQuery(
                'SELECT COUNT(*) AS c FROM users'
            )->fetch()['c'] ?? 0
        );


    $blocked =
        (int)(
            databaseQuery(
                '
                SELECT COUNT(*) AS c
                FROM users
                WHERE blocked = 1
                '
            )->fetch()['c'] ?? 0
        );


    $childBots =
        (int)(
            databaseQuery(
                '
                SELECT COUNT(*) AS c
                FROM child_bots
                '
            )->fetch()['c'] ?? 0
        );


    $diamonds =
        (int)(
            databaseQuery(
                '
                SELECT COALESCE(SUM(diamonds), 0) AS c
                FROM users
                '
            )->fetch()['c'] ?? 0
        );


    $createdBots =
        (int)(
            databaseQuery(
                '
                SELECT COALESCE(SUM(created_bots), 0) AS c
                FROM users
                '
            )->fetch()['c'] ?? 0
        );


    return [

        'users' =>
            $users,

        'blocked' =>
            $blocked,

        'child_bots' =>
            $childBots,

        'diamonds' =>
            $diamonds,

        'created_bots' =>
            $createdBots

    ];
}


/*
|--------------------------------------------------------------------------
| نمایش آمار
|--------------------------------------------------------------------------
*/

function showAdminStats(
    int $chatId,
    ?int $messageId = null
): void {

    $stats =
        getAdminStats();

    $text =
        "📊 <b>آمار ربات</b>\n\n" .

        "👤 کل کاربران: <b>" .
        $stats['users'] .
        "</b>\n\n" .

        "🚫 کاربران بلاک‌شده: <b>" .
        $stats['blocked'] .
        "</b>\n\n" .

        "🤖 ربات‌های فرزند: <b>" .
        $stats['child_bots'] .
        "</b>\n\n" .

        "🔢 مجموع ربات‌های ساخته‌شده: <b>" .
        $stats['created_bots'] .
        "</b>\n\n" .

        "💎 مجموع الماس کاربران: <b>" .
        $stats['diamonds'] .
        "</b>";


    $keyboard = [

        'inline_keyboard' => [

            [
                [
                    'text' => '🔙 پنل مدیریت',
                    'callback_data' => 'admin_home'
                ]
            ]

        ]

    ];


    if (
        $messageId !== null
    ) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            $keyboard
        );

    } else {

        sendMessage(
            $chatId,
            $text,
            $keyboard
        );
    }
}


/*
|--------------------------------------------------------------------------
| مدیریت Callback
|--------------------------------------------------------------------------
*/

function handleAdminCallback(
    int $chatId,
    string $callbackId,
    string $data,
    int $messageId
): void {

    $userId =
        $chatId;


    if (
        !isAdmin($userId)
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

            clearAdminState(
                $userId
            );

            showAdminPanel(
                $chatId,
                $messageId
            );

            break;


        case 'admin_stats':

            clearAdminState(
                $userId
            );

            showAdminStats(
                $chatId,
                $messageId
            );

            break;


        case 'admin_add_diamond':

            setAdminState(
                $userId,
                'add_diamond_user'
            );

            sendMessage(
                $chatId,
                "💎 <b>ارسال الماس</b>\n\n" .
                "ابتدا آیدی عددی کاربر را ارسال کنید.\n\n" .
                "مثال:\n" .
                "<code>123456789</code>",
                [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => '❌ لغو',
                                'callback_data' => 'admin_home'
                            ]
                        ]
                    ]
                ]
            );

            break;


        case 'admin_remove_diamond':

            setAdminState(
                $userId,
                'remove_diamond_user'
            );

            sendMessage(
                $chatId,
                "➖ <b>کسر الماس</b>\n\n" .
                "آیدی عددی کاربر را ارسال کنید."
            );

            break;


        case 'admin_block':

            setAdminState(
                $userId,
                'block_user'
            );

            sendMessage(
                $chatId,
                "🚫 <b>بلاک کاربر</b>\n\n" .
                "آیدی عددی کاربر را ارسال کنید."
            );

            break;


        case 'admin_unblock':

            setAdminState(
                $userId,
                'unblock_user'
            );

            sendMessage(
                $chatId,
                "✅ <b>آن‌بلاک کاربر</b>\n\n" .
                "آیدی عددی کاربر را ارسال کنید."
            );

            break;


        case 'admin_build_limit':

            setAdminState(
                $userId,
                'build_limit_user'
            );

            sendMessage(
                $chatId,
                "🤖 <b>تعداد ساخت ربات</b>\n\n" .
                "ابتدا آیدی عددی کاربر را ارسال کنید."
            );

            break;


        case 'admin_message_user':

            setAdminState(
                $userId,
                'message_user_id'
            );

            sendMessage(
                $chatId,
                "👤 <b>ارسال پیام به کاربر</b>\n\n" .
                "آیدی عددی کاربر را ارسال کنید."
            );

            break;


        case 'admin_broadcast':

            setAdminState(
                $userId,
                'broadcast'
            );

            sendMessage(
                $chatId,
                "📢 <b>ارسال همگانی</b>\n\n" .
                "متنی که می‌خواهید برای همه کاربران ارسال شود را بفرستید."
            );

            break;


        case 'admin_child_bots':

            showAdminChildBots(
                $chatId,
                $messageId
            );

            break;


        default:

            break;
    }
}


/*
|--------------------------------------------------------------------------
| ربات‌های فرزند
|--------------------------------------------------------------------------
*/

function showAdminChildBots(
    int $chatId,
    ?int $messageId = null
): void {

    $stmt =
        databaseQuery(
            '
            SELECT
                id,
                owner_id,
                bot_id,
                username,
                first_name,
                active
            FROM child_bots
            ORDER BY id DESC
            LIMIT 50
            '
        );

    $bots =
        $stmt->fetchAll();


    if (
        !$bots
    ) {

        $text =
            "🤖 <b>ربات‌های فرزند</b>\n\n" .
            "هنوز هیچ ربات فرزندی ساخته نشده است.";

    } else {

        $text =
            "🤖 <b>ربات‌های فرزند</b>\n\n";

        foreach (
            $bots as $bot
        ) {

            $status =
                ((int)$bot['active'] === 1)
                    ? '🟢 فعال'
                    : '🔴 غیرفعال';

            $username =
                trim(
                    (string)$bot['username']
                );

            $username =
                $username !== ''
                    ? '@' . $username
                    : 'بدون username';

            $text .=
                "━━━━━━━━━━━━━━\n" .

                "🆔 Bot ID: <code>" .
                (int)$bot['bot_id'] .
                "</code>\n" .

                "🤖 " .
                h(
                    (string)$bot['first_name']
                ) .
                "\n" .

                "👤 " .
                h($username) .
                "\n" .

                "👨‍💼 مالک: <code>" .
                (int)$bot['owner_id'] .
                "</code>\n" .

                "📌 وضعیت: {$status}\n";
        }
    }


    $keyboard = [

        'inline_keyboard' => [

            [
                [
                    'text' => '🔙 پنل مدیریت',
                    'callback_data' => 'admin_home'
                ]
            ]

        ]

    ];


    if (
        $messageId !== null
    ) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            $keyboard
        );

    } else {

        sendMessage(
            $chatId,
            $text,
            $keyboard
        );
    }
}


/*
|--------------------------------------------------------------------------
| پردازش متن پنل مدیریت
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


    $state =
        getAdminState(
            $chatId
        );


    /*
    |--------------------------------------------------------------------------
    | افزودن الماس - دریافت ID
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'add_diamond_user'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی عددی معتبر نیست."
            );

            return;
        }

        setAdminState(
            $chatId,
            'add_diamond_amount:' . $text
        );

        sendMessage(
            $chatId,
            "💎 مقدار الماس را ارسال کنید.\n\n" .
            "مثال: <code>10</code>"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | افزودن الماس - مقدار
    |--------------------------------------------------------------------------
    */

    if (
        str_starts_with(
            $state,
            'add_diamond_amount:'
        )
    ) {

        $targetId =
            (int)substr(
                $state,
                strlen('add_diamond_amount:')
            );

        $amount =
            (int)$text;

        if (
            $amount <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ مقدار نامعتبر است."
            );

            return;
        }

        if (
            adminAddDiamonds(
                $targetId,
                $amount
            )
        ) {

            $newBalance =
                getUserDiamonds(
                    $targetId
                );

            sendMessage(
                $chatId,
                "✅ انجام شد.\n\n" .
                "👤 کاربر: <code>{$targetId}</code>\n" .
                "💎 مقدار: <b>{$amount}</b>\n" .
                "💰 موجودی جدید: <b>{$newBalance}</b>"
            );

        } else {

            sendMessage(
                $chatId,
                "❌ کاربر پیدا نشد."
            );
        }

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | کسر الماس
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'remove_diamond_user'
    ) {

        if (
            !ctype_digit($text)
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی نامعتبر است."
            );

            return;
        }

        setAdminState(
            $chatId,
            'remove_diamond_amount:' . $text
        );

        sendMessage(
            $chatId,
            "➖ مقدار الماس برای کسر را ارسال کنید."
        );

        return;
    }


    if (
        str_starts_with(
            $state,
            'remove_diamond_amount:'
        )
    ) {

        $targetId =
            (int)substr(
                $state,
                strlen('remove_diamond_amount:')
            );

        $amount =
            (int)$text;

        if (
            $amount <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ مقدار نامعتبر است."
            );

            return;
        }

        adminRemoveDiamonds(
            $targetId,
            $amount
        );

        sendMessage(
            $chatId,
            "✅ عملیات کسر الماس انجام شد."
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | بلاک
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'block_user'
    ) {

        $targetId =
            (int)$text;

        if (
            $targetId <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی نامعتبر است."
            );

            return;
        }

        adminBlockUser(
            $targetId
        );

        sendMessage(
            $chatId,
            "🚫 کاربر بلاک شد."
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | آن‌بلاک
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'unblock_user'
    ) {

        $targetId =
            (int)$text;

        if (
            $targetId <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی نامعتبر است."
            );

            return;
        }

        adminUnblockUser(
            $targetId
        );

        sendMessage(
            $chatId,
            "✅ کاربر آن‌بلاک شد."
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | محدودیت ساخت ربات
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'build_limit_user'
    ) {

        $targetId =
            (int)$text;

        if (
            $targetId <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی نامعتبر است."
            );

            return;
        }

        setAdminState(
            $chatId,
            'build_limit_amount:' . $targetId
        );

        sendMessage(
            $chatId,
            "🤖 تعداد مجاز ساخت ربات را ارسال کنید.\n\n" .
            "مثال: <code>5</code>"
        );

        return;
    }


    if (
        str_starts_with(
            $state,
            'build_limit_amount:'
        )
    ) {

        $targetId =
            (int)substr(
                $state,
                strlen('build_limit_amount:')
            );

        $limit =
            (int)$text;

        if (
            $limit < 0
        ) {

            sendMessage(
                $chatId,
                "❌ مقدار نامعتبر است."
            );

            return;
        }

        adminSetBuildLimit(
            $targetId,
            $limit
        );

        sendMessage(
            $chatId,
            "✅ محدودیت ساخت ربات تنظیم شد.\n\n" .
            "👤 کاربر: <code>{$targetId}</code>\n" .
            "🤖 تعداد مجاز: <b>{$limit}</b>"
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | ارسال پیام به کاربر
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'message_user_id'
    ) {

        $targetId =
            (int)$text;

        if (
            $targetId <= 0
        ) {

            sendMessage(
                $chatId,
                "❌ آیدی نامعتبر است."
            );

            return;
        }

        setAdminState(
            $chatId,
            'message_user_text:' . $targetId
        );

        sendMessage(
            $chatId,
            "✉️ متن پیام را ارسال کنید."
        );

        return;
    }


    if (
        str_starts_with(
            $state,
            'message_user_text:'
        )
    ) {

        $targetId =
            (int)substr(
                $state,
                strlen('message_user_text:')
            );

        sendMessage(
            $targetId,
            $text
        );

        sendMessage(
            $chatId,
            "✅ پیام برای کاربر ارسال شد."
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | ارسال همگانی
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'broadcast'
    ) {

        $stmt =
            databaseQuery(
                '
                SELECT telegram_id
                FROM users
                WHERE blocked = 0
                '
            );

        $users =
            $stmt->fetchAll();

        $sent =
            0;

        foreach (
            $users as $user
        ) {

            $targetId =
                (int)$user['telegram_id'];

            $result =
                sendMessage(
                    $targetId,
                    $text
                );

            if (
                is_array($result) &&
                ($result['ok'] ?? false) === true
            ) {

                $sent++;
            }
        }

        sendMessage(
            $chatId,
            "📢 <b>ارسال همگانی تمام شد.</b>\n\n" .
            "✅ ارسال موفق: <b>{$sent}</b>"
        );

        clearAdminState(
            $chatId
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | اگر دستوری وجود ندارد
    |--------------------------------------------------------------------------
    */

    showAdminPanel(
        $chatId
    );
}

<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/admin.php';

/*
|--------------------------------------------------------------------------
| PARENT.PHP
|--------------------------------------------------------------------------
| ربات پدر
|
| امکانات:
| - ساخت ربات فرزند
| - هزینه ساخت: 5 الماس
| - حساب کاربری
| - زیرمجموعه
| - پشتیبانی
| - پنل مدیریت
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| کیبورد اصلی
|--------------------------------------------------------------------------
*/

function parentMainKeyboard(): array
{
    return [

        'inline_keyboard' => [

            [
                [
                    'text' => '🤖 ساخت ربات',
                    'callback_data' => 'parent_create_bot'
                ]
            ],

            [
                [
                    'text' => '👤 حساب کاربری',
                    'callback_data' => 'parent_account'
                ],

                [
                    'text' => '👥 زیرمجموعه',
                    'callback_data' => 'parent_referral'
                ]
            ],

            [
                [
                    'text' => '🎧 پشتیبانی',
                    'callback_data' => 'parent_support'
                ]
            ]

        ]

    ];
}


/*
|--------------------------------------------------------------------------
| منوی برگشت
|--------------------------------------------------------------------------
*/

function parentBackKeyboard(): array
{
    return [

        'inline_keyboard' => [

            [
                [
                    'text' => '🔙 برگشت',
                    'callback_data' => 'parent_home'
                ]
            ]

        ]

    ];
}


/*
|--------------------------------------------------------------------------
| نمایش صفحه اصلی
|--------------------------------------------------------------------------
*/

function showParentHome(
    int $chatId,
    ?int $messageId = null
): void {

    $text =
        "🤖 <b>به ربات ساز خوش آمدید</b>\n\n" .
        "با این ربات می‌توانید ربات موزیک خودتان را بسازید.\n\n" .
        "💎 هزینه ساخت هر ربات: <b>5 الماس</b>\n\n" .
        "یکی از گزینه‌های زیر را انتخاب کنید:";

    $keyboard =
        parentMainKeyboard();

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
| /start
|--------------------------------------------------------------------------
*/

function parentStart(
    int $chatId,
    array $from = [],
    string $startParameter = ''
): void {

    /*
    |--------------------------------------------------------------------------
    | ثبت کاربر
    |--------------------------------------------------------------------------
    */

    $firstName =
        (string)(
            $from['first_name'] ?? ''
        );

    $lastName =
        (string)(
            $from['last_name'] ?? ''
        );

    $username =
        (string)(
            $from['username'] ?? ''
        );

    createUser(
        $chatId,
        $firstName,
        $lastName,
        $username
    );


    /*
    |--------------------------------------------------------------------------
    | بررسی بلاک
    |--------------------------------------------------------------------------
    */

    if (
        isUserBlocked($chatId)
    ) {

        sendMessage(
            $chatId,
            "🚫 <b>حساب شما مسدود شده است.</b>"
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | سیستم زیرمجموعه
    |--------------------------------------------------------------------------
    */

    if (
        $startParameter !== ''
    ) {

        processReferral(
            $chatId,
            $startParameter
        );
    }


    /*
    |--------------------------------------------------------------------------
    | پنل مدیریت برای مالک
    |--------------------------------------------------------------------------
    */

    if (
        isAdmin($chatId)
    ) {

        sendMessage(
            $chatId,
            "👑 <b>پنل مدیریت</b>\n\n" .
            "برای ورود به پنل مدیریت از دستور زیر استفاده کنید:\n\n" .
            "<code>/admin</code>"
        );
    }


    showParentHome(
        $chatId
    );
}


/*
|--------------------------------------------------------------------------
| صفحه ساخت ربات
|--------------------------------------------------------------------------
*/

function showCreateBotPage(
    int $chatId,
    ?int $messageId = null
): void {

    $balance =
        getUserDiamonds(
            $chatId
        );

    $buildLimit =
        getUserBuildLimit(
            $chatId
        );

    $created =
        getUserCreatedBotsCount(
            $chatId
        );

    $text =
        "🤖 <b>ساخت ربات جدید</b>\n\n" .

        "💎 هزینه ساخت: <b>5 الماس</b>\n" .

        "💰 موجودی شما: <b>{$balance}</b> الماس\n\n" .

        "🔢 تعداد ربات ساخته‌شده: <b>{$created}</b>\n" .
        "📌 تعداد مجاز ساخت: <b>{$buildLimit}</b>\n\n";


    if ($balance < 5) {

        $text .=
            "❌ موجودی شما برای ساخت ربات کافی نیست.\n\n" .
            "حداقل موجودی مورد نیاز: <b>5 الماس</b>";

        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '🔙 برگشت',
                        'callback_data' => 'parent_home'
                    ]
                ]
            ]
        ];

    } elseif (
        $buildLimit > 0 &&
        $created >= $buildLimit
    ) {

        $text .=
            "❌ شما به سقف مجاز ساخت ربات رسیده‌اید.";

        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '🔙 برگشت',
                        'callback_data' => 'parent_home'
                    ]
                ]
            ]
        ];

    } else {

        $text .=
            "برای ساخت ربات ابتدا توکن ربات خود را از @BotFather دریافت کنید.";

        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '🤖 وارد کردن توکن',
                        'callback_data' => 'parent_enter_token'
                    ]
                ],
                [
                    [
                        'text' => '🔙 برگشت',
                        'callback_data' => 'parent_home'
                    ]
                ]
            ]
        ];
    }


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
| درخواست توکن
|--------------------------------------------------------------------------
*/

function askChildToken(
    int $chatId
): void {

    setParentState(
        $chatId,
        'waiting_child_token'
    );

    sendMessage(
        $chatId,
        "🤖 <b>توکن ربات فرزند را ارسال کنید.</b>\n\n" .
        "توکن را از @BotFather دریافت کنید.\n\n" .
        "مثال:\n" .
        "<code>123456789:AAxxxxxxxxxxxxxxxxxxxxxxxx</code>\n\n" .
        "⚠️ توکن را دقیق ارسال کنید.",
        [
            'inline_keyboard' => [
                [
                    [
                        'text' => '❌ لغو',
                        'callback_data' => 'parent_create_bot'
                    ]
                ]
            ]
        ]
    );
}


/*
|--------------------------------------------------------------------------
| اعتبارسنجی توکن
|--------------------------------------------------------------------------
*/

function validateBotToken(
    string $token
): ?array {

    $token =
        trim($token);

    if (
        !preg_match(
            '/^\d{6,15}:[A-Za-z0-9_-]{20,}$/',
            $token
        )
    ) {

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | دریافت اطلاعات ربات
    |--------------------------------------------------------------------------
    */

    $result =
        telegramRequestWithToken(
            $token,
            'getMe'
        );


    if (
        !is_array($result)
    ) {

        return null;
    }


    if (
        !isset($result['ok']) ||
        $result['ok'] !== true
    ) {

        return null;
    }


    return
        $result['result'] ?? null;
}


/*
|--------------------------------------------------------------------------
| ساخت ربات فرزند
|--------------------------------------------------------------------------
*/

function createChildBotFromToken(
    int $userId,
    string $token
): bool {

    /*
    |--------------------------------------------------------------------------
    | بررسی موجودی
    |--------------------------------------------------------------------------
    */

    $balance =
        getUserDiamonds(
            $userId
        );

    if (
        $balance < 5
    ) {

        sendMessage(
            $userId,
            "❌ موجودی شما کافی نیست.\n\n" .
            "💎 هزینه ساخت: <b>5</b>\n" .
            "💰 موجودی شما: <b>{$balance}</b>"
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی سقف ساخت
    |--------------------------------------------------------------------------
    */

    $limit =
        getUserBuildLimit(
            $userId
        );

    $created =
        getUserCreatedBotsCount(
            $userId
        );

    if (
        $limit > 0 &&
        $created >= $limit
    ) {

        sendMessage(
            $userId,
            "❌ شما به سقف مجاز ساخت ربات رسیده‌اید."
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی توکن
    |--------------------------------------------------------------------------
    */

    $botInfo =
        validateBotToken(
            $token
        );

    if (
        !$botInfo
    ) {

        sendMessage(
            $userId,
            "❌ توکن ربات معتبر نیست.\n\n" .
            "لطفاً توکن @BotFather را دوباره بررسی کنید."
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | جلوگیری از ثبت تکراری
    |--------------------------------------------------------------------------
    */

    $existing =
        findBotByToken(
            $token
        );

    if (
        $existing
    ) {

        sendMessage(
            $userId,
            "❌ این ربات قبلاً در سیستم ثبت شده است."
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | کسر 5 الماس
    |--------------------------------------------------------------------------
    */

    $removed =
        removeDiamonds(
            $userId,
            5
        );

    if (
        !$removed
    ) {

        sendMessage(
            $userId,
            "❌ کسر الماس انجام نشد."
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | ثبت ربات
    |--------------------------------------------------------------------------
    */

    $telegramId =
        (int)(
            $botInfo['id'] ?? 0
        );

    $username =
        (string)(
            $botInfo['username'] ?? ''
        );

    $firstName =
        (string)(
            $botInfo['first_name'] ?? ''
        );


    $botCreated =
        createChildBot(
            $userId,
            $token,
            $telegramId,
            $username,
            $firstName
        );


    /*
    |--------------------------------------------------------------------------
    | اگر ثبت ناموفق شد، الماس برگردان
    |--------------------------------------------------------------------------
    */

    if (
        !$botCreated
    ) {

        addDiamonds(
            $userId,
            5
        );

        sendMessage(
            $userId,
            "❌ ثبت ربات انجام نشد.\n\n" .
            "💎 5 الماس به موجودی شما برگشت داده شد."
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | تنظیم Webhook
    |--------------------------------------------------------------------------
    */

    $webhookResult =
        setChildBotWebhook(
            $token,
            $telegramId
        );


    /*
    |--------------------------------------------------------------------------
    | پیام موفقیت
    |--------------------------------------------------------------------------
    */

    $remaining =
        getUserDiamonds(
            $userId
        );

    $botUsername =
        $username !== ''
            ? '@' . $username
            : 'بدون username';


    $text =
        "🎉 <b>ربات شما با موفقیت ساخته شد!</b>\n\n" .

        "🤖 نام ربات: <b>" .
        h($firstName) .
        "</b>\n" .

        "👤 Username: <b>" .
        h($botUsername) .
        "</b>\n\n" .

        "💎 هزینه ساخت: <b>5</b>\n" .

        "💰 موجودی باقی‌مانده: <b>{$remaining}</b>\n\n";


    if (
        $webhookResult
    ) {

        $text .=
            "✅ ربات آماده استفاده است.\n\n" .
            "روی لینک زیر بزنید:\n" .
            "https://t.me/" .
            rawurlencode($username);

    } else {

        $text .=
            "⚠️ ربات ثبت شد، اما تنظیم Webhook انجام نشد.\n" .
            "تنظیمات Render را بررسی کنید.";
    }


    sendMessage(
        $userId,
        $text,
        [
            'inline_keyboard' => [
                [
                    [
                        'text' => '🤖 ورود به ربات',
                        'url' =>
                            'https://t.me/' .
                            rawurlencode($username)
                    ]
                ],
                [
                    [
                        'text' => '🏠 منوی اصلی',
                        'callback_data' => 'parent_home'
                    ]
                ]
            ]
        ]
    );


    return true;
}


/*
|--------------------------------------------------------------------------
| حساب کاربری
|--------------------------------------------------------------------------
*/

function showParentAccount(
    int $chatId,
    ?int $messageId = null
): void {

    $user =
        getUser(
            $chatId
        );

    if (
        !$user
    ) {

        createUser(
            $chatId
        );

        $user =
            getUser(
                $chatId
            );
    }


    $firstName =
        h(
            (string)(
                $user['first_name'] ?? ''
            )
        );

    $lastName =
        h(
            (string)(
                $user['last_name'] ?? ''
            )
        );

    $username =
        (string)(
            $user['username'] ?? ''
        );

    $usernameText =
        $username !== ''
            ? '@' . h($username)
            : 'ندارد';

    $diamonds =
        getUserDiamonds(
            $chatId
        );

    $created =
        getUserCreatedBotsCount(
            $chatId
        );

    $text =
        "👤 <b>حساب کاربری</b>\n\n" .

        "🆔 آیدی عددی:\n" .
        "<code>{$chatId}</code>\n\n" .

        "👤 نام:\n" .
        "<b>{$firstName} {$lastName}</b>\n\n" .

        "🔗 Username:\n" .
        "<b>{$usernameText}</b>\n\n" .

        "💎 موجودی:\n" .
        "<b>{$diamonds}</b> الماس\n\n" .

        "🤖 ربات‌های ساخته‌شده:\n" .
        "<b>{$created}</b>";


    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            parentBackKeyboard()
        );

        return;
    }

    sendMessage(
        $chatId,
        $text,
        parentBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| زیرمجموعه
|--------------------------------------------------------------------------
*/

function showParentReferral(
    int $chatId,
    ?int $messageId = null
): void {

    $count =
        getReferralCount(
            $chatId
        );

    $link =
        getReferralLink(
            $chatId
        );

    $text =
        "👥 <b>سیستم زیرمجموعه</b>\n\n" .

        "👤 تعداد زیرمجموعه‌ها: <b>{$count}</b>\n\n" .

        "💎 بابت هر زیرمجموعه فقط <b>1 الماس</b> دریافت می‌کنید.\n" .
        "⚠️ برای هر کاربر فقط یک بار پاداش داده می‌شود.\n\n" .

        "🔗 <b>لینک دعوت شما:</b>\n" .
        "<code>{$link}</code>";


    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $text,
            parentBackKeyboard()
        );

        return;
    }

    sendMessage(
        $chatId,
        $text,
        parentBackKeyboard()
    );
}


/*
|--------------------------------------------------------------------------
| پشتیبانی
|--------------------------------------------------------------------------
*/

function showParentSupport(
    int $chatId,
    ?int $messageId = null
): void {

    $support =
        trim(
            (string)SUPPORT_USERNAME
        );

    if (
        $support === ''
    ) {

        $text =
            "🎧 <b>پشتیبانی</b>\n\n" .
            "❌ پشتیبانی هنوز تنظیم نشده است.";

        $keyboard =
            parentBackKeyboard();

    } else {

        $support =
            ltrim(
                $support,
                '@'
            );

        $text =
            "🎧 <b>پشتیبانی</b>\n\n" .
            "برای ارتباط با پشتیبانی روی دکمه زیر کلیک کنید.";

        $keyboard = [

            'inline_keyboard' => [

                [
                    [
                        'text' => '💬 ارتباط با پشتیبانی',
                        'url' =>
                            'https://t.me/' .
                            $support
                    ]
                ],

                [
                    [
                        'text' => '🔙 برگشت',
                        'callback_data' => 'parent_home'
                    ]
                ]

            ]

        ];
    }


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
| پردازش Callback ربات پدر
|--------------------------------------------------------------------------
*/

function handleParentCallback(
    int $chatId,
    int $userId,
    string $callbackId,
    string $data,
    int $messageId
): void {

    if (
        isUserBlocked($userId)
    ) {

        answerCallback(
            $callbackId,
            '🚫 حساب شما مسدود است.',
            true
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | پنل مدیریت
    |--------------------------------------------------------------------------
    */

    if (
        str_starts_with(
            $data,
            'admin_'
        )
    ) {

        handleAdminCallback(
            $chatId,
            $callbackId,
            $data,
            $messageId
        );

        return;
    }


    answerCallback(
        $callbackId
    );


    switch ($data) {

        case 'parent_home':

            clearParentState(
                $chatId
            );

            showParentHome(
                $chatId,
                $messageId
            );

            break;


        case 'parent_create_bot':

            showCreateBotPage(
                $chatId,
                $messageId
            );

            break;


        case 'parent_enter_token':

            askChildToken(
                $chatId
            );

            break;


        case 'parent_account':

            showParentAccount(
                $chatId,
                $messageId
            );

            break;


        case 'parent_referral':

            showParentReferral(
                $chatId,
                $messageId
            );

            break;


        case 'parent_support':

            showParentSupport(
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
| پردازش پیام متنی ربات پدر
|--------------------------------------------------------------------------
*/

function handleParentText(
    int $chatId,
    int $userId,
    string $text,
    array $message = []
): void {

    $text =
        trim($text);


    /*
    |--------------------------------------------------------------------------
    | /admin
    |--------------------------------------------------------------------------
    */

    if (
        $text === '/admin' ||
        $text === '/panel'
    ) {

        if (
            isAdmin($userId)
        ) {

            clearParentState(
                $chatId
            );

            showAdminPanel(
                $chatId
            );

        } else {

            sendMessage(
                $chatId,
                "🚫 دسترسی ندارید."
            );
        }

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | /start
    |--------------------------------------------------------------------------
    */

    if (
        $text === '/start' ||
        str_starts_with(
            $text,
            '/start '
        )
    ) {

        $parameter = '';

        if (
            str_contains(
                $text,
                ' '
            )
        ) {

            $parts =
                explode(
                    ' ',
                    $text,
                    2
                );

            $parameter =
                trim(
                    $parts[1] ?? ''
                );
        }

        parentStart(
            $chatId,
            $message['from'] ?? [],
            $parameter
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | وضعیت کاربر
    |--------------------------------------------------------------------------
    */

    $state =
        getParentState(
            $chatId
        );


    /*
    |--------------------------------------------------------------------------
    | انتظار توکن ربات
    |--------------------------------------------------------------------------
    */

    if (
        $state === 'waiting_child_token'
    ) {

        $token =
            trim($text);

        if (
            $token === ''
        ) {

            sendMessage(
                $chatId,
                "❌ توکن را ارسال کنید."
            );

            return;
        }


        clearParentState(
            $chatId
        );


        createChildBotFromToken(
            $userId,
            $token
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | اگر وضعیت ندارد
    |--------------------------------------------------------------------------
    */

    showParentHome(
        $chatId
    );
}
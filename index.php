<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

echo "START<br>";

require_once __DIR__ . '/config.php';

echo "CONFIG LOADED<br>";

exit;

/*
|--------------------------------------------------------------------------
| INDEX.PHP
|--------------------------------------------------------------------------
| ورودی اصلی پروژه
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/parent.php';
require_once __DIR__ . '/child.php';


/*
|--------------------------------------------------------------------------
| پاسخ سریع به Render / Telegram
|--------------------------------------------------------------------------
*/

http_response_code(200);


/*
|--------------------------------------------------------------------------
| درخواست Telegram
|--------------------------------------------------------------------------
*/

$raw =
    file_get_contents(
        'php://input'
    );

if (
    $raw === false ||
    trim($raw) === ''
) {

    echo 'OK';

    exit;
}


$update =
    json_decode(
        $raw,
        true
    );


if (
    !is_array($update)
) {

    echo 'OK';

    exit;
}


/*
|--------------------------------------------------------------------------
| Callback Query
|--------------------------------------------------------------------------
*/

if (
    isset($update['callback_query'])
) {

    $callback =
        $update['callback_query'];

    $callbackId =
        (string)(
            $callback['id'] ?? ''
        );

    $data =
        (string)(
            $callback['data'] ?? ''
        );

    $message =
        $callback['message']
        ?? null;

    $from =
        $callback['from']
        ?? [];

    $chatId =
        (int)(
            $message['chat']['id']
            ?? $from['id']
            ?? 0
        );

    $userId =
        (int)(
            $from['id']
            ?? $chatId
        );

    $messageId =
        (int)(
            $message['message_id']
            ?? 0
        );


    if (
        $chatId <= 0
    ) {

        echo 'OK';

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | تشخیص ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot =
        findChildBotByWebhook();


    if (
        $childBot
    ) {

        handleChildCallback(
            $childBot,
            $callbackId,
            $chatId,
            $userId,
            $data,
            $messageId
        );

    } else {

        handleParentCallback(
            $chatId,
            $userId,
            $callbackId,
            $data,
            $messageId
        );
    }


    echo 'OK';

    exit;
}


/*
|--------------------------------------------------------------------------
| Message
|--------------------------------------------------------------------------
*/

if (
    isset($update['message'])
) {

    $message =
        $update['message'];

    $chat =
        $message['chat']
        ?? [];

    $from =
        $message['from']
        ?? [];

    $chatId =
        (int)(
            $chat['id']
            ?? 0
        );

    $userId =
        (int)(
            $from['id']
            ?? $chatId
        );

    $text =
        isset($message['text'])
            ? (string)$message['text']
            : '';


    if (
        $chatId <= 0
    ) {

        echo 'OK';

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | ثبت کاربر
    |--------------------------------------------------------------------------
    */

    createUser(
        $userId,
        (string)(
            $from['first_name']
            ?? ''
        ),
        (string)(
            $from['last_name']
            ?? ''
        ),
        (string)(
            $from['username']
            ?? ''
        )
    );


    /*
    |--------------------------------------------------------------------------
    | بررسی بلاک
    |--------------------------------------------------------------------------
    */

    if (
        isUserBlocked($userId)
    ) {

        sendMessage(
            $userId,
            "🚫 <b>حساب شما مسدود شده است.</b>\n\n" .
            "در صورت اشتباه با پشتیبانی تماس بگیرید."
        );

        echo 'OK';

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | تشخیص ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot =
        findChildBotByWebhook();


    if (
        $childBot
    ) {

        handleChildMessage(
            $childBot,
            $message,
            $chatId,
            $userId,
            $text
        );

    } else {

        handleParentText(
            $chatId,
            $userId,
            $text,
            $message
        );
    }


    echo 'OK';

    exit;
}


/*
|--------------------------------------------------------------------------
| سایر Updateها
|--------------------------------------------------------------------------
*/

echo 'OK';

exit;


/*
|--------------------------------------------------------------------------
| پیدا کردن ربات فرزند از روی Webhook
|--------------------------------------------------------------------------
*/

function findChildBotByWebhook(): ?array
{
    /*
    |--------------------------------------------------------------------------
    | روش اول: bot query
    |--------------------------------------------------------------------------
    |
    | برای URL:
    |
    | https://domain.com/index.php?bot=123456789
    |
    */

    $botId =
        isset($_GET['bot'])
            ? (int)$_GET['bot']
            : 0;


    if (
        $botId > 0
    ) {

        return findChildBotById(
            $botId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | روش دوم
    |--------------------------------------------------------------------------
    |
    | اگر bot_id در query وجود نداشت،
    | در اینجا ربات پدر استفاده می‌شود.
    */

    return null;
}

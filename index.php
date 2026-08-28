<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| INDEX.PHP
|--------------------------------------------------------------------------
| فایل اصلی Webhook ربات پدر و ربات‌های فرزند
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
| پاسخ HTTP
|--------------------------------------------------------------------------
*/

http_response_code(200);


/*
|--------------------------------------------------------------------------
| دریافت Update از Telegram
|--------------------------------------------------------------------------
*/

$input = file_get_contents('php://input');

if ($input === false || trim($input) === '') {
    echo 'OK';
    exit;
}


$update = json_decode($input, true);

if (!is_array($update)) {
    echo 'OK';
    exit;
}


/*
|--------------------------------------------------------------------------
| اطلاعات کاربر
|--------------------------------------------------------------------------
*/

$message = $update['message'] ?? null;

$callback = $update['callback_query'] ?? null;


/*
|--------------------------------------------------------------------------
| Callback Query
|--------------------------------------------------------------------------
*/

if (is_array($callback)) {

    $callbackId =
        (string)($callback['id'] ?? '');

    $from =
        $callback['from'] ?? [];

    $callbackMessage =
        $callback['message'] ?? [];

    $chatId =
        (int)(
            $callbackMessage['chat']['id']
            ?? $from['id']
            ?? 0
        );

    $userId =
        (int)(
            $from['id']
            ?? $chatId
        );

    $data =
        (string)($callback['data'] ?? '');

    $messageId =
        (int)(
            $callbackMessage['message_id']
            ?? 0
        );


    if ($chatId <= 0) {
        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی بلاک
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isUserBlocked') &&
        isUserBlocked($userId)
    ) {

        answerCallback(
            $callbackId,
            '🚫 حساب شما مسدود است.',
            true
        );

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | تشخیص ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot = null;

    if (isset($_GET['bot'])) {

        $childBot =
            findChildBotById(
                (int)$_GET['bot']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Callback ربات فرزند
    |--------------------------------------------------------------------------
    */

    if ($childBot !== null) {

        if (
            function_exists('handleChildCallback')
        ) {

            handleChildCallback(
                $childBot,
                $callbackId,
                $chatId,
                $userId,
                $data,
                $messageId
            );
        }

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Callback ربات پدر
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('handleParentCallback')
    ) {

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

if (is_array($message)) {

    $chat =
        $message['chat'] ?? [];

    $from =
        $message['from'] ?? [];

    $chatId =
        (int)(
            $chat['id'] ?? 0
        );

    $userId =
        (int)(
            $from['id']
            ?? $chatId
        );

    $text =
        (string)(
            $message['text']
            ?? ''
        );


    if ($chatId <= 0) {
        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | ثبت کاربر
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('createUser')
    ) {

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
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی بلاک
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isUserBlocked') &&
        isUserBlocked($userId)
    ) {

        sendMessage(
            $chatId,
            "🚫 <b>حساب شما مسدود شده است.</b>\n\n" .
            "برای پیگیری با پشتیبانی تماس بگیرید."
        );

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | تشخیص ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot = null;

    if (isset($_GET['bot'])) {

        $childBot =
            findChildBotById(
                (int)$_GET['bot']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Message ربات فرزند
    |--------------------------------------------------------------------------
    */

    if ($childBot !== null) {

        if (
            function_exists('handleChildMessage')
        ) {

            handleChildMessage(
                $childBot,
                $message,
                $chatId,
                $userId,
                $text
            );
        }

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی پنل مدیریت
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isAdmin') &&
        isAdmin($userId)
    ) {

        $adminState = '';

        if (
            function_exists('getAdminState')
        ) {

            $adminState =
                getAdminState($userId);
        }


        /*
        | /admin
        */

        if (
            strtolower(trim($text)) === '/admin' ||
            strtolower(trim($text)) === '/panel'
        ) {

            showAdminPanel(
                $chatId
            );

            echo 'OK';
            exit;
        }


        /*
        | پردازش متن پنل
        */

        if (
            $adminState !== ''
        ) {

            handleAdminText(
                $chatId,
                $text
            );

            echo 'OK';
            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Message ربات پدر
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('handleParentText')
    ) {

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
| Update ناشناخته
|--------------------------------------------------------------------------
*/

echo 'OK';
exit;


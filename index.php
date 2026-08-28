<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/parent.php';
require_once __DIR__ . '/child.php';


http_response_code(200);


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
| Callback Query
|--------------------------------------------------------------------------
*/

if (isset($update['callback_query'])) {

    $callback = $update['callback_query'];

    $callbackId = (string)($callback['id'] ?? '');

    $from = $callback['from'] ?? [];

    $message = $callback['message'] ?? [];

    $chatId = (int)(
        $message['chat']['id']
        ?? $from['id']
        ?? 0
    );

    $userId = (int)(
        $from['id']
        ?? $chatId
    );

    $data = (string)(
        $callback['data']
        ?? ''
    );

    $messageId = (int)(
        $message['message_id']
        ?? 0
    );


    if ($chatId <= 0) {
        echo 'OK';
        exit;
    }


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
    | پنل مدیریت
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isAdmin') &&
        isAdmin($userId)
    ) {

        if (
            function_exists('handleAdminCallback')
        ) {

            handleAdminCallback(
                $chatId,
                $callbackId,
                $data,
                $messageId
            );

            echo 'OK';
            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot = null;

    if (
        isset($_GET['bot']) &&
        function_exists('findChildBotById')
    ) {

        $childBot =
            findChildBotById(
                (int)$_GET['bot']
            );
    }


    if (
        $childBot !== null &&
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

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | ربات پدر
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

if (isset($update['message'])) {

    $message = $update['message'];

    $chat = $message['chat'] ?? [];

    $from = $message['from'] ?? [];

    $chatId = (int)(
        $chat['id']
        ?? 0
    );

    $userId = (int)(
        $from['id']
        ?? $chatId
    );

    $text = (string)(
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
    | بلاک
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isUserBlocked') &&
        isUserBlocked($userId)
    ) {

        sendMessage(
            $chatId,
            "🚫 <b>حساب شما مسدود شده است.</b>"
        );

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | پنل مدیریت
    |--------------------------------------------------------------------------
    */

    if (
        function_exists('isAdmin') &&
        isAdmin($userId)
    ) {

        $state = '';

        if (
            function_exists('getAdminState')
        ) {

            $state =
                getAdminState($userId);
        }


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


        if ($state !== '') {

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
    | ربات فرزند
    |--------------------------------------------------------------------------
    */

    $childBot = null;

    if (
        isset($_GET['bot']) &&
        function_exists('findChildBotById')
    ) {

        $childBot =
            findChildBotById(
                (int)$_GET['bot']
            );
    }


    if (
        $childBot !== null &&
        function_exists('handleChildMessage')
    ) {

        handleChildMessage(
            $childBot,
            $message,
            $chatId,
            $userId,
            $text
        );

        echo 'OK';
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | ربات پدر
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


echo 'OK';
exit;

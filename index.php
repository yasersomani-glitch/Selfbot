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
| CALLBACK QUERY
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
| MESSAGE
|--------------------------------------------------------------------------
*/

if (isset($update['message'])) {

    $message = $update['message'];

    $chat = $message['chat'] ?? [];

    $from = $message['from'] ?? [];

    $chatId = (int)(
        $chat['id'] ?? 0
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
    | ارسال پیام به parent.php
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

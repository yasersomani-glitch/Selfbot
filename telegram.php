<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/*
|--------------------------------------------------------------------------
| Telegram API
|--------------------------------------------------------------------------
*/

function telegram(
    string $method,
    array $data = []
): array {

    if (BOT_TOKEN === '') {
        return [
            'ok' => false,
            'error' => 'BOT_TOKEN تنظیم نشده است.'
        ];
    }

    $url = TELEGRAM_API . $method;

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $response = curl_exec($ch);

    if ($response === false) {

        $error = curl_error($ch);

        curl_close($ch);

        error_log(
            'Telegram CURL Error: ' . $error
        );

        return [
            'ok' => false,
            'error' => $error
        ];
    }

    $httpCode = curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );

    curl_close($ch);

    $result = json_decode(
        $response,
        true
    );

    if (!is_array($result)) {

        return [
            'ok' => false,
            'error' => 'پاسخ Telegram نامعتبر است.',
            'http_code' => $httpCode
        ];
    }

    return $result;
}

/*
|--------------------------------------------------------------------------
| دریافت اطلاعات ربات
|--------------------------------------------------------------------------
*/

function telegramGetMe(): array
{
    return telegram('getMe');
}

/*
|--------------------------------------------------------------------------
| ارسال پیام
|--------------------------------------------------------------------------
*/

function sendMessage(
    int|string $chatId,
    string $text,
    ?array $keyboard = null,
    ?string $parseMode = 'HTML'
): array {

    $data = [
        'chat_id' => $chatId,
        'text' => $text
    ];

    if ($parseMode !== null) {
        $data['parse_mode'] = $parseMode;
    }

    if ($keyboard !== null) {

        $data['reply_markup'] =
            json_encode(
                $keyboard,
                JSON_UNESCAPED_UNICODE
            );
    }

    return telegram(
        'sendMessage',
        $data
    );
}

/*
|--------------------------------------------------------------------------
| ویرایش متن پیام
|--------------------------------------------------------------------------
*/

function editMessageText(
    int|string $chatId,
    int $messageId,
    string $text,
    ?array $keyboard = null
): array {

    $data = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];

    if ($keyboard !== null) {

        $data['reply_markup'] =
            json_encode(
                $keyboard,
                JSON_UNESCAPED_UNICODE
            );
    }

    return telegram(
        'editMessageText',
        $data
    );
}

/*
|--------------------------------------------------------------------------
| پاسخ به Callback Query
|--------------------------------------------------------------------------
*/

function answerCallback(
    string $callbackId,
    string $text = '',
    bool $showAlert = false
): array {

    return telegram(
        'answerCallbackQuery',
        [
            'callback_query_id' => $callbackId,
            'text' => $text,
            'show_alert' => $showAlert
        ]
    );
}

/*
|--------------------------------------------------------------------------
| حذف پیام
|--------------------------------------------------------------------------
*/

function deleteMessage(
    int|string $chatId,
    int $messageId
): array {

    return telegram(
        'deleteMessage',
        [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ]
    );
}

/*
|--------------------------------------------------------------------------
| ارسال Audio
|--------------------------------------------------------------------------
*/

function sendAudio(
    int|string $chatId,
    string $audio,
    string $caption = ''
): array {

    $data = [
        'chat_id' => $chatId,
        'audio' => $audio
    ];

    if ($caption !== '') {
        $data['caption'] = $caption;
    }

    return telegram(
        'sendAudio',
        $data
    );
}

/*
|--------------------------------------------------------------------------
| ارسال Document
|--------------------------------------------------------------------------
*/

function sendDocument(
    int|string $chatId,
    string $document,
    string $caption = ''
): array {

    $data = [
        'chat_id' => $chatId,
        'document' => $document
    ];

    if ($caption !== '') {
        $data['caption'] = $caption;
    }

    return telegram(
        'sendDocument',
        $data
    );
}

/*
|--------------------------------------------------------------------------
| دریافت اطلاعات یک ربات با توکن مشخص
|--------------------------------------------------------------------------
|
| این تابع برای بررسی توکن ربات فرزند استفاده می‌شود.
|
*/

function telegramGetMeByToken(
    string $token
): array {

    $url =
        'https://api.telegram.org/bot' .
        $token .
        '/getMe';

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $response = curl_exec($ch);

    if ($response === false) {

        $error = curl_error($ch);

        curl_close($ch);

        return [
            'ok' => false,
            'error' => $error
        ];
    }

    curl_close($ch);

    $result = json_decode(
        $response,
        true
    );

    return is_array($result)
        ? $result
        : [
            'ok' => false,
            'error' => 'Invalid Telegram response'
        ];
}

/*
|--------------------------------------------------------------------------
| تنظیم Webhook برای ربات
|--------------------------------------------------------------------------
*/

function setWebhook(
    string $token,
    string $url,
    string $secret = ''
): array {

    $api =
        'https://api.telegram.org/bot' .
        $token .
        '/setWebhook';

    $data = [
        'url' => $url
    ];

    if ($secret !== '') {
        $data['secret_token'] = $secret;
    }

    $ch = curl_init($api);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $response = curl_exec($ch);

    if ($response === false) {

        $error = curl_error($ch);

        curl_close($ch);

        return [
            'ok' => false,
            'error' => $error
        ];
    }

    curl_close($ch);

    $result = json_decode(
        $response,
        true
    );

    return is_array($result)
        ? $result
        : [
            'ok' => false,
            'error' => 'Invalid Telegram response'
        ];
}

/*
|--------------------------------------------------------------------------
| حذف Webhook
|--------------------------------------------------------------------------
*/

function deleteWebhook(
    string $token
): array {

    $api =
        'https://api.telegram.org/bot' .
        $token .
        '/deleteWebhook';

    $ch = curl_init($api);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);

    if ($response === false) {

        $error = curl_error($ch);

        curl_close($ch);

        return [
            'ok' => false,
            'error' => $error
        ];
    }

    curl_close($ch);

    $result = json_decode(
        $response,
        true
    );

    return is_array($result)
        ? $result
        : [
            'ok' => false,
            'error' => 'Invalid Telegram response'
        ];
}

/*
|--------------------------------------------------------------------------
| دریافت اطلاعات Webhook
|--------------------------------------------------------------------------
*/

function getWebhookInfo(
    string $token
): array {

    $api =
        'https://api.telegram.org/bot' .
        $token .
        '/getWebhookInfo';

    $ch = curl_init($api);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $response = curl_exec($ch);

    if ($response === false) {

        $error = curl_error($ch);

        curl_close($ch);

        return [
            'ok' => false,
            'error' => $error
        ];
    }

    curl_close($ch);

    $result = json_decode(
        $response,
        true
    );

    return is_array($result)
        ? $result
        : [
            'ok' => false,
            'error' => 'Invalid Telegram response'
        ];
}
<?php

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

/*
|--------------------------------------------------------------------------
| MUSIC.PHP
|--------------------------------------------------------------------------
| جستجوی موزیک و نمایش نتایج
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| تعداد نتایج
|--------------------------------------------------------------------------
*/

if (!defined('MUSIC_RESULTS_LIMIT')) {
    define('MUSIC_RESULTS_LIMIT', 8);
}


/*
|--------------------------------------------------------------------------
| جستجوی موزیک
|--------------------------------------------------------------------------
*/

function searchMusic(
    int $chatId,
    int $childBotId,
    string $query
): void {

    $query = trim($query);

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        ) ?? 'fa';

    $t =
        childTexts($language);

    if ($query === '') {

        sendMessage(
            $chatId,
            $t['send_music_name']
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | پیام جستجو
    |--------------------------------------------------------------------------
    */

    $searchMessage =
        sendMessage(
            $chatId,
            $t['searching']
        );

    /*
    |--------------------------------------------------------------------------
    | ذخیره عبارت جستجو
    |--------------------------------------------------------------------------
    */

    setUserState(
        'child',
        $childBotId,
        $chatId,
        'music_results',
        [
            'query' => $query
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | جستجوی API
    |--------------------------------------------------------------------------
    */

    $results =
        musicSearchProvider(
            $query
        );

    if (
        !is_array($results) ||
        count($results) === 0
    ) {

        sendMessage(
            $chatId,
            $t['not_found']
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | محدود کردن نتایج
    |--------------------------------------------------------------------------
    */

    $results =
        array_slice(
            $results,
            0,
            MUSIC_RESULTS_LIMIT
        );

    /*
    |--------------------------------------------------------------------------
    | ذخیره نتایج برای callback
    |--------------------------------------------------------------------------
    */

    saveMusicResults(
        $childBotId,
        $chatId,
        $results
    );

    /*
    |--------------------------------------------------------------------------
    | ساخت دکمه‌ها
    |--------------------------------------------------------------------------
    */

    $keyboard = [
        'inline_keyboard' => []
    ];

    foreach (
        $results as $index => $song
    ) {

        $title =
            trim(
                (string)(
                    $song['title'] ?? 'Unknown'
                )
            );

        $artist =
            trim(
                (string)(
                    $song['artist'] ?? ''
                )
            );

        if ($artist !== '') {

            $buttonText =
                '🎵 ' .
                $artist .
                ' - ' .
                $title;

        } else {

            $buttonText =
                '🎵 ' .
                $title;
        }

        /*
        |--------------------------------------------------------------------------
        | محدودیت طول callback
        |--------------------------------------------------------------------------
        */

        $keyboard['inline_keyboard'][] = [

            [
                'text' =>
                    mb_substr(
                        $buttonText,
                        0,
                        55
                    ),

                'callback_data' =>
                    'music_song_' .
                    (int)$index
            ]

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | دکمه برگشت
    |--------------------------------------------------------------------------
    */

    $keyboard['inline_keyboard'][] = [

        [
            'text' => $t['back'],
            'callback_data' => 'child_home'
        ]

    ];

    /*
    |--------------------------------------------------------------------------
    | نمایش نتایج
    |--------------------------------------------------------------------------
    */

    sendMessage(
        $chatId,
        $t['results'],
        $keyboard
    );
}


/*
|--------------------------------------------------------------------------
| Provider جستجوی موزیک
|--------------------------------------------------------------------------
|
| این قسمت طوری نوشته شده که بعداً می‌توان API واقعی موزیک
| را در همین تابع قرار داد.
|
|--------------------------------------------------------------------------
*/

function musicSearchProvider(
    string $query
): array {

    /*
    |--------------------------------------------------------------------------
    | اگر API موزیک در config تعریف شده باشد
    |--------------------------------------------------------------------------
    */

    if (
        defined('MUSIC_API_URL') &&
        MUSIC_API_URL !== ''
    ) {

        $url =
            MUSIC_API_URL .
            '?q=' .
            urlencode($query);

        $response =
            httpGetJson(
                $url
            );

        if (
            is_array($response)
        ) {

            /*
            | حالت‌های متداول API
            */

            if (
                isset(
                    $response['results']
                ) &&
                is_array(
                    $response['results']
                )
            ) {

                return normalizeMusicResults(
                    $response['results']
                );
            }

            if (
                isset(
                    $response['data']
                ) &&
                is_array(
                    $response['data']
                )
            ) {

                return normalizeMusicResults(
                    $response['data']
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | اگر API تنظیم نشده باشد
    |--------------------------------------------------------------------------
    */

    return [];
}


/*
|--------------------------------------------------------------------------
| تبدیل نتایج API به فرمت استاندارد
|--------------------------------------------------------------------------
*/

function normalizeMusicResults(
    array $results
): array {

    $output = [];

    foreach (
        $results as $item
    ) {

        if (
            !is_array($item)
        ) {
            continue;
        }

        $title =
            $item['title']
            ?? $item['name']
            ?? '';

        $artist =
            $item['artist']
            ?? $item['author']
            ?? $item['singer']
            ?? '';

        $audioUrl =
            $item['audio']
            ?? $item['audio_url']
            ?? $item['url']
            ?? '';

        $cover =
            $item['cover']
            ?? $item['thumbnail']
            ?? $item['image']
            ?? '';

        if (
            trim((string)$title) === ''
        ) {
            continue;
        }

        $output[] = [

            'title' =>
                (string)$title,

            'artist' =>
                (string)$artist,

            'audio_url' =>
                (string)$audioUrl,

            'cover' =>
                (string)$cover

        ];
    }

    return $output;
}


/*
|--------------------------------------------------------------------------
| ذخیره نتایج جستجو
|--------------------------------------------------------------------------
*/

function saveMusicResults(
    int $childBotId,
    int $chatId,
    array $results
): void {

    setUserState(
        'child',
        $childBotId,
        $chatId,
        'music_results',
        [
            'results' => $results
        ]
    );
}


/*
|--------------------------------------------------------------------------
| دریافت نتایج ذخیره شده
|--------------------------------------------------------------------------
*/

function getMusicResults(
    int $childBotId,
    int $chatId
): array {

    $state =
        getUserState(
            'child',
            $childBotId,
            $chatId
        );

    if (
        !$state ||
        empty($state['data'])
    ) {
        return [];
    }

    $data =
        $state['data'];

    if (
        is_string($data)
    ) {

        $decoded =
            json_decode(
                $data,
                true
            );

        if (
            is_array($decoded)
        ) {
            $data = $decoded;
        }
    }

    if (
        !is_array($data)
    ) {
        return [];
    }

    return
        isset($data['results']) &&
        is_array($data['results'])
            ? $data['results']
            : [];
}


/*
|--------------------------------------------------------------------------
| Callback انتخاب آهنگ
|--------------------------------------------------------------------------
*/

function handleMusicCallback(
    int $chatId,
    int $childBotId,
    string $callbackId,
    string $data,
    int $messageId
): void {

    if (
        !preg_match(
            '/^music_song_(\d+)$/',
            $data,
            $matches
        )
    ) {

        answerCallback(
            $callbackId,
            '❌ آهنگ نامعتبر است.',
            true
        );

        return;
    }

    $index =
        (int)$matches[1];

    $results =
        getMusicResults(
            $childBotId,
            $chatId
        );

    if (
        !isset(
            $results[$index]
        )
    ) {

        answerCallback(
            $callbackId,
            '❌ این نتیجه دیگر موجود نیست.',
            true
        );

        return;
    }

    $song =
        $results[$index];

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        ) ?? 'fa';

    $t =
        childTexts($language);

    answerCallback(
        $callbackId
    );

    $title =
        trim(
            (string)(
                $song['title'] ?? ''
            )
        );

    $artist =
        trim(
            (string)(
                $song['artist'] ?? ''
            )
        );

    /*
    |--------------------------------------------------------------------------
    | اطلاعات آهنگ
    |--------------------------------------------------------------------------
    */

    $caption =
        "🎵 <b>" .
        h($title) .
        "</b>";

    if (
        $artist !== ''
    ) {

        $caption .=
            "\n👤 " .
            h($artist);
    }

    /*
    |--------------------------------------------------------------------------
    | URL فایل صوتی
    |--------------------------------------------------------------------------
    */

    $audioUrl =
        trim(
            (string)(
                $song['audio_url'] ?? ''
            )
        );

    /*
    |--------------------------------------------------------------------------
    | اگر URL صوتی آماده باشد
    |--------------------------------------------------------------------------
    */

    if (
        $audioUrl !== ''
    ) {

        sendAudio(
            $chatId,
            $audioUrl,
            $caption
        );

        clearUserState(
            'child',
            $childBotId,
            $chatId
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | اگر URL مستقیم آهنگ وجود نداشته باشد
    |--------------------------------------------------------------------------
    */

    sendMessage(
        $chatId,
        $t['error'] .
        "\n\n" .
        "⚠️ برای این نتیجه فایل صوتی مستقیم پیدا نشد."
    );
}


/*
|--------------------------------------------------------------------------
| HTTP GET JSON
|--------------------------------------------------------------------------
*/

function httpGetJson(
    string $url
): ?array {

    if (
        function_exists('curl_init')
    ) {

        $ch =
            curl_init($url);

        curl_setopt_array(
            $ch,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json'
                ]
            ]
        );

        $response =
            curl_exec($ch);

        curl_close($ch);

    } else {

        $context =
            stream_context_create(
                [
                    'http' => [
                        'timeout' => 30
                    ]
                ]
            );

        $response =
            @file_get_contents(
                $url,
                false,
                $context
            );
    }

    if (
        !is_string($response) ||
        $response === ''
    ) {
        return null;
    }

    $data =
        json_decode(
            $response,
            true
        );

    return
        is_array($data)
            ? $data
            : null;
}


/*
|--------------------------------------------------------------------------
| ارسال Audio
|--------------------------------------------------------------------------
*/

function sendAudio(
    int $chatId,
    string $audio,
    string $caption = ''
): ?array {

    /*
    |--------------------------------------------------------------------------
    | این تابع از تابع عمومی Telegram استفاده می‌کند.
    |--------------------------------------------------------------------------
    */

    if (
        function_exists(
            'telegramRequest'
        )
    ) {

        return telegramRequest(
            'sendAudio',
            [
                'chat_id' => $chatId,
                'audio' => $audio,
                'caption' => $caption,
                'parse_mode' => 'HTML'
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | اگر telegramRequest وجود نداشت
    |--------------------------------------------------------------------------
    */

    if (
        function_exists(
            'bot'
        )
    ) {

        return bot(
            'sendAudio',
            [
                'chat_id' => $chatId,
                'audio' => $audio,
                'caption' => $caption,
                'parse_mode' => 'HTML'
            ]
        );
    }

    return null;
}
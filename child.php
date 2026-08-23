<?php

declare(strict_types=1);

require_once __DIR__ . '/functions.php';

/*
|--------------------------------------------------------------------------
| CHILD BOT
|--------------------------------------------------------------------------
| مدیریت ربات‌های فرزند:
| - /start
| - انتخاب زبان
| - منوی اصلی
| - جستجوی موزیک
| - پشتیبانی
| - تغییر زبان
| - مدیریت وضعیت کاربر
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| زبان‌های ربات
|--------------------------------------------------------------------------
*/

function childTexts(string $language): array
{
    $languages = [

        'fa' => [

            'choose_language' =>
                "🌐 <b>زبان خود را انتخاب کنید:</b>",

            'welcome' =>
                "🎵 <b>به ربات موزیک یاب خوش آمدید</b>\n\n" .
                "از منوی زیر گزینه مورد نظر خود را انتخاب کنید.",

            'search_music' =>
                "🎵 جستجوی موزیک",

            'change_language' =>
                "🌐 تغییر زبان",

            'support' =>
                "🎧 پشتیبانی",

            'send_music_name' =>
                "🎵 <b>نام آهنگ یا خواننده را ارسال کنید:</b>\n\n" .
                "مثال:\n" .
                "<code>Shadmehr Aghili</code>",

            'searching' =>
                "🔎 <b>در حال جستجو...</b>\n\n" .
                "لطفاً کمی صبر کنید.",

            'results' =>
                "🎵 <b>نتایج جستجو</b>\n\n" .
                "یکی از آهنگ‌های زیر را انتخاب کنید:",

            'not_found' =>
                "❌ <b>نتیجه‌ای پیدا نشد.</b>\n\n" .
                "لطفاً نام دیگری را امتحان کنید.",

            'downloading' =>
                "⏳ <b>در حال آماده‌سازی آهنگ...</b>\n\n" .
                "لطفاً صبر کنید.",

            'error' =>
                "❌ هنگام دریافت آهنگ خطایی رخ داد.\n" .
                "لطفاً دوباره تلاش کنید.",

            'support_text' =>
                "🎧 <b>پشتیبانی</b>\n\n" .
                "برای ارتباط با پشتیبانی روی دکمه زیر کلیک کنید.",

            'support_not_set' =>
                "❌ پشتیبانی هنوز تنظیم نشده است.",

            'back' =>
                "🔙 برگشت",

            'language_changed' =>
                "✅ زبان با موفقیت تغییر کرد."
        ],

        'en' => [

            'choose_language' =>
                "🌐 <b>Select your language:</b>",

            'welcome' =>
                "🎵 <b>Welcome to Music Finder</b>\n\n" .
                "Choose an option from the menu below.",

            'search_music' =>
                "🎵 Search Music",

            'change_language' =>
                "🌐 Change Language",

            'support' =>
                "🎧 Support",

            'send_music_name' =>
                "🎵 <b>Send the song or artist name:</b>\n\n" .
                "Example:\n" .
                "<code>Shadmehr Aghili</code>",

            'searching' =>
                "🔎 <b>Searching...</b>\n\n" .
                "Please wait.",

            'results' =>
                "🎵 <b>Search Results</b>\n\n" .
                "Choose a song:",

            'not_found' =>
                "❌ <b>No results found.</b>\n\n" .
                "Please try another search.",

            'downloading' =>
                "⏳ <b>Preparing your song...</b>\n\n" .
                "Please wait.",

            'error' =>
                "❌ An error occurred while getting the song.\n" .
                "Please try again.",

            'support_text' =>
                "🎧 <b>Support</b>\n\n" .
                "Click the button below to contact support.",

            'support_not_set' =>
                "❌ Support has not been configured yet.",

            'back' =>
                "🔙 Back",

            'language_changed' =>
                "✅ Language changed successfully."
        ],

        'ar' => [

            'choose_language' =>
                "🌐 <b>اختر لغتك:</b>",

            'welcome' =>
                "🎵 <b>مرحباً بك في بوت البحث عن الموسيقى</b>\n\n" .
                "اختر أحد الخيارات من القائمة.",

            'search_music' =>
                "🎵 البحث عن الموسيقى",

            'change_language' =>
                "🌐 تغيير اللغة",

            'support' =>
                "🎧 الدعم",

            'send_music_name' =>
                "🎵 <b>أرسل اسم الأغنية أو الفنان:</b>\n\n" .
                "مثال:\n" .
                "<code>Shadmehr Aghili</code>",

            'searching' =>
                "🔎 <b>جاري البحث...</b>\n\n" .
                "يرجى الانتظار.",

            'results' =>
                "🎵 <b>نتائج البحث</b>\n\n" .
                "اختر أغنية:",

            'not_found' =>
                "❌ <b>لم يتم العثور على نتائج.</b>\n\n" .
                "حاول البحث مرة أخرى.",

            'downloading' =>
                "⏳ <b>جاري تجهيز الأغنية...</b>\n\n" .
                "يرجى الانتظار.",

            'error' =>
                "❌ حدث خطأ أثناء الحصول على الأغنية.\n" .
                "حاول مرة أخرى.",

            'support_text' =>
                "🎧 <b>الدعم</b>\n\n" .
                "اضغط على الزر أدناه للتواصل مع الدعم.",

            'support_not_set' =>
                "❌ لم يتم إعداد الدعم بعد.",

            'back' =>
                "🔙 رجوع",

            'language_changed' =>
                "✅ تم تغيير اللغة بنجاح."
        ]
    ];

    return $languages[$language] ?? $languages['fa'];
}


/*
|--------------------------------------------------------------------------
| زبان پیش‌فرض
|--------------------------------------------------------------------------
*/

function childDefaultLanguage(): string
{
    return 'fa';
}


/*
|--------------------------------------------------------------------------
| کیبورد زبان
|--------------------------------------------------------------------------
*/

function childLanguageKeyboard(): array
{
    return [

        'inline_keyboard' => [

            [
                [
                    'text' => '🇦🇫 فارسی',
                    'callback_data' => 'child_lang_fa'
                ],

                [
                    'text' => '🇬🇧 English',
                    'callback_data' => 'child_lang_en'
                ]
            ],

            [
                [
                    'text' => '🇸🇦 العربية',
                    'callback_data' => 'child_lang_ar'
                ]
            ]

        ]

    ];
}


/*
|--------------------------------------------------------------------------
| کیبورد اصلی
|--------------------------------------------------------------------------
*/

function childMainKeyboard(string $language): array
{
    $t = childTexts($language);

    return [

        'inline_keyboard' => [

            [
                [
                    'text' => $t['search_music'],
                    'callback_data' => 'child_search_music'
                ]
            ],

            [
                [
                    'text' => $t['change_language'],
                    'callback_data' => 'child_change_language'
                ]
            ],

            [
                [
                    'text' => $t['support'],
                    'callback_data' => 'child_support'
                ]
            ]

        ]

    ];
}


/*
|--------------------------------------------------------------------------
| نمایش انتخاب زبان
|--------------------------------------------------------------------------
*/

function showChildLanguage(
    int $chatId,
    ?int $messageId = null
): void {

    $text =
        childTexts('fa')['choose_language'];

    $keyboard =
        childLanguageKeyboard();

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
| نمایش منوی اصلی
|--------------------------------------------------------------------------
*/

function showChildMain(
    int $chatId,
    int $childBotId,
    ?int $messageId = null
): void {

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        );

    if (
        !$language ||
        !in_array(
            $language,
            ['fa', 'en', 'ar'],
            true
        )
    ) {

        showChildLanguage(
            $chatId,
            $messageId
        );

        return;
    }

    $t =
        childTexts($language);

    $keyboard =
        childMainKeyboard($language);

    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $t['welcome'],
            $keyboard
        );

        return;
    }

    sendMessage(
        $chatId,
        $t['welcome'],
        $keyboard
    );
}


/*
|--------------------------------------------------------------------------
| شروع ربات فرزند
|--------------------------------------------------------------------------
*/

function childStart(
    int $chatId,
    int $childBotId,
    array $from = []
): void {

    if (isUserBlocked($chatId)) {

        sendMessage(
            $chatId,
            "🚫 <b>حساب شما مسدود شده است.</b>"
        );

        return;
    }

    /*
    | اطلاعات کاربر
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

    /*
    | ثبت کاربر
    */

    createUser(
        $chatId,
        $firstName,
        $lastName,
        $username
    );

    /*
    | بررسی اینکه زبان قبلاً انتخاب شده یا نه
    */

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        );

    if (
        !$language
    ) {

        showChildLanguage(
            $chatId
        );

        return;
    }

    showChildMain(
        $chatId,
        $childBotId
    );
}


/*
|--------------------------------------------------------------------------
| انتخاب زبان کاربر
|--------------------------------------------------------------------------
*/

function handleChildLanguage(
    int $chatId,
    int $childBotId,
    string $language,
    string $callbackId,
    int $messageId
): void {

    if (
        !in_array(
            $language,
            ['fa', 'en', 'ar'],
            true
        )
    ) {

        answerCallback(
            $callbackId,
            '❌ Invalid language.',
            true
        );

        return;
    }

    setUserLanguage(
        $childBotId,
        $chatId,
        $language
    );

    clearUserState(
        'child',
        $childBotId,
        $chatId
    );

    answerCallback(
        $callbackId,
        childTexts($language)['language_changed']
    );

    showChildMain(
        $chatId,
        $childBotId,
        $messageId
    );
}


/*
|--------------------------------------------------------------------------
| شروع جستجوی موزیک
|--------------------------------------------------------------------------
*/

function startMusicSearch(
    int $chatId,
    int $childBotId,
    ?int $messageId = null
): void {

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        ) ?? childDefaultLanguage();

    $t =
        childTexts($language);

    /*
    | وضعیت کاربر
    */

    setUserState(
        'child',
        $childBotId,
        $chatId,
        'waiting_music_search'
    );

    $keyboard = [

        'inline_keyboard' => [

            [
                [
                    'text' => $t['back'],
                    'callback_data' => 'child_home'
                ]
            ]

        ]

    ];

    if ($messageId !== null) {

        editMessageText(
            $chatId,
            $messageId,
            $t['send_music_name'],
            $keyboard
        );

        return;
    }

    sendMessage(
        $chatId,
        $t['send_music_name'],
        $keyboard
    );
}


/*
|--------------------------------------------------------------------------
| تغییر زبان
|--------------------------------------------------------------------------
*/

function changeChildLanguage(
    int $chatId,
    int $childBotId,
    ?int $messageId = null
): void {

    clearUserState(
        'child',
        $childBotId,
        $chatId
    );

    showChildLanguage(
        $chatId,
        $messageId
    );
}


/*
|--------------------------------------------------------------------------
| پشتیبانی
|--------------------------------------------------------------------------
*/

function showChildSupport(
    int $chatId,
    int $childBotId,
    ?int $messageId = null
): void {

    $language =
        getUserLanguage(
            $childBotId,
            $chatId
        ) ?? childDefaultLanguage();

    $t =
        childTexts($language);

    $support =
        trim(
            (string)SUPPORT_USERNAME
        );

    if ($support === '') {

        $text =
            $t['support_not_set'];

        $keyboard = [

            'inline_keyboard' => [

                [
                    [
                        'text' => $t['back'],
                        'callback_data' => 'child_home'
                    ]
                ]

            ]

        ];

    } else {

        $support =
            ltrim(
                $support,
                '@'
            );

        $text =
            $t['support_text'];

        $keyboard = [

            'inline_keyboard' => [

                [
                    [
                        'text' => '💬 ' . $t['support'],
                        'url' =>
                            'https://t.me/' .
                            $support
                    ]
                ],

                [
                    [
                        'text' => $t['back'],
                        'callback_data' => 'child_home'
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
| پردازش Callback ربات فرزند
|--------------------------------------------------------------------------
*/

function handleChildCallback(
    int $chatId,
    int $childBotId,
    string $callbackId,
    string $data,
    int $messageId
): void {

    if (
        isUserBlocked($chatId)
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
    | انتخاب زبان
    |--------------------------------------------------------------------------
    */

    if (
        preg_match(
            '/^child_lang_(fa|en|ar)$/',
            $data,
            $matches
        )
    ) {

        handleChildLanguage(
            $chatId,
            $childBotId,
            $matches[1],
            $callbackId,
            $messageId
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | دکمه‌های آهنگ
    |--------------------------------------------------------------------------
    */

    if (
        str_starts_with(
            $data,
            'music_song_'
        )
    ) {

        if (
            function_exists(
                'handleMusicCallback'
            )
        ) {

            handleMusicCallback(
                $chatId,
                $childBotId,
                $callbackId,
                $data,
                $messageId
            );

        } else {

            answerCallback(
                $callbackId,
                '⏳ بخش موزیک هنوز نصب نشده است.',
                true
            );
        }

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | پاسخ Callback
    |--------------------------------------------------------------------------
    */

    answerCallback(
        $callbackId
    );

    /*
    |--------------------------------------------------------------------------
    | منوی اصلی
    |--------------------------------------------------------------------------
    */

    switch ($data) {

        case 'child_home':

            clearUserState(
                'child',
                $childBotId,
                $chatId
            );

            showChildMain(
                $chatId,
                $childBotId,
                $messageId
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | جستجوی موزیک
        |--------------------------------------------------------------------------
        */

        case 'child_search_music':

            startMusicSearch(
                $chatId,
                $childBotId,
                $messageId
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | تغییر زبان
        |--------------------------------------------------------------------------
        */

        case 'child_change_language':

            changeChildLanguage(
                $chatId,
                $childBotId,
                $messageId
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | پشتیبانی
        |--------------------------------------------------------------------------
        */

        case 'child_support':

            showChildSupport(
                $chatId,
                $childBotId,
                $messageId
            );

            break;


        default:

            break;
    }
}


/*
|--------------------------------------------------------------------------
| پردازش پیام متنی
|--------------------------------------------------------------------------
*/

function handleChildText(
    int $chatId,
    int $childBotId,
    string $text
): void {

    $text =
        trim($text);

    if ($text === '') {
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

        childStart(
            $chatId,
            $childBotId,
            [
                'id' => $chatId
            ]
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | /cancel
    |--------------------------------------------------------------------------
    */

    if (
        strtolower($text) === '/cancel'
    ) {

        clearUserState(
            'child',
            $childBotId,
            $chatId
        );

        showChildMain(
            $chatId,
            $childBotId
        );

        return;
    }

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
    | دریافت وضعیت فعلی
    |--------------------------------------------------------------------------
    */

    $state =
        getUserState(
            'child',
            $childBotId,
            $chatId
        );

    /*
    |--------------------------------------------------------------------------
    | اگر وضعیت ندارد
    |--------------------------------------------------------------------------
    */

    if (
        !$state ||
        empty($state['state'])
    ) {

        showChildMain(
            $chatId,
            $childBotId
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | پردازش وضعیت
    |--------------------------------------------------------------------------
    */

    switch (
        $state['state']
    ) {

        /*
        |--------------------------------------------------------------------------
        | کاربر در حال جستجوی موزیک است
        |--------------------------------------------------------------------------
        */

        case 'waiting_music_search':

            /*
            | تابع اصلی جستجو در music.php قرار می‌گیرد.
            */

            if (
                function_exists(
                    'searchMusic'
                )
            ) {

                searchMusic(
                    $chatId,
                    $childBotId,
                    $text
                );

            } else {

                $language =
                    getUserLanguage(
                        $childBotId,
                        $chatId
                    ) ?? 'fa';

                $t =
                    childTexts($language);

                sendMessage(
                    $chatId,
                    $t['searching']
                );
            }

            break;


        /*
        |--------------------------------------------------------------------------
        | وضعیت ناشناخته
        |--------------------------------------------------------------------------
        */

        default:

            clearUserState(
                'child',
                $childBotId,
                $chatId
            );

            showChildMain(
                $chatId,
                $childBotId
            );

            break;
    }
}
<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/*
|--------------------------------------------------------------------------
| اتصال به PostgreSQL
|--------------------------------------------------------------------------
*/

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    if (DATABASE_URL === '') {
        throw new RuntimeException(
            'DATABASE_URL تنظیم نشده است.'
        );
    }

    $url = parse_url(DATABASE_URL);

    if ($url === false) {
        throw new RuntimeException(
            'DATABASE_URL نامعتبر است.'
        );
    }

    $host = $url['host'] ?? '';
    $port = $url['port'] ?? 5432;
    $user = $url['user'] ?? '';
    $pass = $url['pass'] ?? '';
    $dbName = isset($url['path'])
        ? ltrim($url['path'], '/')
        : '';

    if ($host === '' || $user === '' || $dbName === '') {
        throw new RuntimeException(
            'اطلاعات DATABASE_URL ناقص است.'
        );
    }

    $dsn =
        'pgsql:host=' . $host .
        ';port=' . $port .
        ';dbname=' . $dbName;

    $pdo = new PDO(
        $dsn,
        urldecode($user),
        urldecode($pass),
        [
            PDO::ATTR_ERRMODE =>
                PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE =>
                PDO::FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES =>
                false
        ]
    );

    return $pdo;
}

/*
|--------------------------------------------------------------------------
| اجرای Query
|--------------------------------------------------------------------------
*/

function dbQuery(
    string $sql,
    array $params = []
): PDOStatement
{
    $stmt = db()->prepare($sql);

    $stmt->execute($params);

    return $stmt;
}

/*
|--------------------------------------------------------------------------
| دریافت یک رکورد
|--------------------------------------------------------------------------
*/

function dbOne(
    string $sql,
    array $params = []
): ?array
{
    $stmt = dbQuery($sql, $params);

    $row = $stmt->fetch();

    return $row ?: null;
}

/*
|--------------------------------------------------------------------------
| دریافت چند رکورد
|--------------------------------------------------------------------------
*/

function dbAll(
    string $sql,
    array $params = []
): array
{
    return dbQuery(
        $sql,
        $params
    )->fetchAll();
}

/*
|--------------------------------------------------------------------------
| ایجاد جدول‌ها
|--------------------------------------------------------------------------
*/

function initializeDatabase(): void
{
    $pdo = db();

    /*
    |--------------------------------------------------------------------------
    | کاربران
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id BIGSERIAL PRIMARY KEY,

            telegram_id BIGINT UNIQUE NOT NULL,

            first_name TEXT DEFAULT '',
            last_name TEXT DEFAULT '',
            username TEXT DEFAULT '',

            coins INTEGER NOT NULL DEFAULT 0,

            is_blocked BOOLEAN NOT NULL DEFAULT FALSE,

            allowed_create_count INTEGER NOT NULL DEFAULT 0,

            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | زیرمجموعه‌ها
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS referrals (
            id BIGSERIAL PRIMARY KEY,

            referrer_id BIGINT NOT NULL,
            referred_id BIGINT UNIQUE NOT NULL,

            reward INTEGER NOT NULL DEFAULT 1,

            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | ربات‌های فرزند
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS child_bots (
            id BIGSERIAL PRIMARY KEY,

            owner_telegram_id BIGINT NOT NULL,

            bot_id BIGINT DEFAULT NULL,

            bot_username TEXT DEFAULT '',
            bot_name TEXT DEFAULT '',

            bot_token TEXT NOT NULL,

            is_active BOOLEAN NOT NULL DEFAULT TRUE,

            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | زبان کاربران ربات‌های فرزند
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_languages (
            id BIGSERIAL PRIMARY KEY,

            child_bot_id BIGINT NOT NULL,
            telegram_id BIGINT NOT NULL,

            language VARCHAR(10) NOT NULL DEFAULT 'fa',

            UNIQUE(child_bot_id, telegram_id)
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | وضعیت مکالمه کاربران
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_states (
            id BIGSERIAL PRIMARY KEY,

            bot_type VARCHAR(20) NOT NULL,
            bot_id BIGINT DEFAULT 0,
            telegram_id BIGINT NOT NULL,

            state VARCHAR(100) DEFAULT '',
            data TEXT DEFAULT '',

            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

            UNIQUE(bot_type, bot_id, telegram_id)
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | تنظیمات
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS settings (
            id BIGSERIAL PRIMARY KEY,

            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT DEFAULT ''
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | لاگ مدیریت
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admin_logs (
            id BIGSERIAL PRIMARY KEY,

            admin_id BIGINT NOT NULL,

            action VARCHAR(100) NOT NULL,
            target_id BIGINT DEFAULT NULL,

            details TEXT DEFAULT '',

            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");

    /*
    |--------------------------------------------------------------------------
    | پیام‌های همگانی
    |--------------------------------------------------------------------------
    */

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS broadcasts (
            id BIGSERIAL PRIMARY KEY,

            admin_id BIGINT NOT NULL,

            message_id BIGINT DEFAULT NULL,

            total_users INTEGER NOT NULL DEFAULT 0,
            sent_count INTEGER NOT NULL DEFAULT 0,
            failed_count INTEGER NOT NULL DEFAULT 0,

            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

/*
|--------------------------------------------------------------------------
| ایجاد دیتابیس در اولین اجرا
|--------------------------------------------------------------------------
*/

try {
    initializeDatabase();
} catch (Throwable $e) {

    error_log(
        'DATABASE ERROR: ' . $e->getMessage()
    );
}
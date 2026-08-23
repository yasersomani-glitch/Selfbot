<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/telegram.php';

/*
|--------------------------------------------------------------------------
| ابزارهای عمومی
|--------------------------------------------------------------------------
*/

function h(?string $value): string
{
    return htmlspecialchars(
        $value ?? '',
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function isAdmin(int $telegramId): bool
{
    return $telegramId === OWNER_ID;
}

/*
|--------------------------------------------------------------------------
| کاربران
|--------------------------------------------------------------------------
*/

function getUser(int $telegramId): ?array
{
    return dbOne(
        "
        SELECT *
        FROM users
        WHERE telegram_id = :telegram_id
        LIMIT 1
        ",
        [
            ':telegram_id' => $telegramId
        ]
    );
}

function createUser(
    int $telegramId,
    string $firstName = '',
    string $lastName = '',
    string $username = ''
): array {

    $existing = getUser($telegramId);

    if ($existing !== null) {

        dbQuery(
            "
            UPDATE users
            SET
                first_name = :first_name,
                last_name = :last_name,
                username = :username,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = :telegram_id
            ",
            [
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':username' => $username,
                ':telegram_id' => $telegramId
            ]
        );

        return getUser($telegramId) ?? $existing;
    }

    dbQuery(
        "
        INSERT INTO users
        (
            telegram_id,
            first_name,
            last_name,
            username
        )
        VALUES
        (
            :telegram_id,
            :first_name,
            :last_name,
            :username
        )
        ",
        [
            ':telegram_id' => $telegramId,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':username' => $username
        ]
    );

    return getUser($telegramId) ?? [];
}

function updateUserInfo(
    int $telegramId,
    string $firstName,
    string $lastName,
    string $username
): void {

    dbQuery(
        "
        UPDATE users
        SET
            first_name = :first_name,
            last_name = :last_name,
            username = :username,
            updated_at = CURRENT_TIMESTAMP
        WHERE telegram_id = :telegram_id
        ",
        [
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':username' => $username,
            ':telegram_id' => $telegramId
        ]
    );
}

/*
|--------------------------------------------------------------------------
| سکه
|--------------------------------------------------------------------------
*/

function getCoins(int $telegramId): int
{
    $user = getUser($telegramId);

    return (int)($user['coins'] ?? 0);
}

function addCoins(
    int $telegramId,
    int $amount
): bool {

    if ($amount <= 0) {
        return false;
    }

    dbQuery(
        "
        UPDATE users
        SET
            coins = coins + :amount,
            updated_at = CURRENT_TIMESTAMP
        WHERE telegram_id = :telegram_id
        ",
        [
            ':amount' => $amount,
            ':telegram_id' => $telegramId
        ]
    );

    return true;
}

function removeCoins(
    int $telegramId,
    int $amount
): bool {

    if ($amount <= 0) {
        return false;
    }

    $pdo = db();

    try {

        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            "
            SELECT coins
            FROM users
            WHERE telegram_id = :telegram_id
            FOR UPDATE
            "
        );

        $stmt->execute([
            ':telegram_id' => $telegramId
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            $pdo->rollBack();
            return false;
        }

        $coins = (int)$user['coins'];

        if ($coins < $amount) {
            $pdo->rollBack();
            return false;
        }

        $stmt = $pdo->prepare(
            "
            UPDATE users
            SET
                coins = coins - :amount,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = :telegram_id
            "
        );

        $stmt->execute([
            ':amount' => $amount,
            ':telegram_id' => $telegramId
        ]);

        $pdo->commit();

        return true;

    } catch (Throwable $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log(
            'REMOVE COINS ERROR: ' . $e->getMessage()
        );

        return false;
    }
}

/*
|--------------------------------------------------------------------------
| بلاک / آنبلاک
|--------------------------------------------------------------------------
*/

function isUserBlocked(int $telegramId): bool
{
    $user = getUser($telegramId);

    return (bool)($user['is_blocked'] ?? false);
}

function blockUser(int $telegramId): bool
{
    dbQuery(
        "
        UPDATE users
        SET
            is_blocked = TRUE,
            updated_at = CURRENT_TIMESTAMP
        WHERE telegram_id = :telegram_id
        ",
        [
            ':telegram_id' => $telegramId
        ]
    );

    return true;
}

function unblockUser(int $telegramId): bool
{
    dbQuery(
        "
        UPDATE users
        SET
            is_blocked = FALSE,
            updated_at = CURRENT_TIMESTAMP
        WHERE telegram_id = :telegram_id
        ",
        [
            ':telegram_id' => $telegramId
        ]
    );

    return true;
}

/*
|--------------------------------------------------------------------------
| تعداد دفعات مجاز برای ساخت ربات
|--------------------------------------------------------------------------
*/

function getCreateBotAllowance(int $telegramId): int
{
    $user = getUser($telegramId);

    return (int)(
        $user['allowed_create_count'] ?? 0
    );
}

function addCreateBotAllowance(
    int $telegramId,
    int $count = 1
): bool {

    if ($count <= 0) {
        return false;
    }

    dbQuery(
        "
        UPDATE users
        SET
            allowed_create_count =
                allowed_create_count + :count,
            updated_at = CURRENT_TIMESTAMP
        WHERE telegram_id = :telegram_id
        ",
        [
            ':count' => $count,
            ':telegram_id' => $telegramId
        ]
    );

    return true;
}

function useCreateBotAllowance(
    int $telegramId
): bool {

    $pdo = db();

    try {

        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            "
            SELECT allowed_create_count
            FROM users
            WHERE telegram_id = :telegram_id
            FOR UPDATE
            "
        );

        $stmt->execute([
            ':telegram_id' => $telegramId
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            $pdo->rollBack();
            return false;
        }

        $count = (int)$user['allowed_create_count'];

        if ($count <= 0) {
            $pdo->rollBack();
            return false;
        }

        $stmt = $pdo->prepare(
            "
            UPDATE users
            SET
                allowed_create_count =
                    allowed_create_count - 1,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = :telegram_id
            "
        );

        $stmt->execute([
            ':telegram_id' => $telegramId
        ]);

        $pdo->commit();

        return true;

    } catch (Throwable $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log(
            'ALLOWANCE ERROR: ' . $e->getMessage()
        );

        return false;
    }
}

/*
|--------------------------------------------------------------------------
| زیرمجموعه
|--------------------------------------------------------------------------
*/

function getReferralByReferred(
    int $referredId
): ?array {

    return dbOne(
        "
        SELECT *
        FROM referrals
        WHERE referred_id = :referred_id
        LIMIT 1
        ",
        [
            ':referred_id' => $referredId
        ]
    );
}

function processReferral(
    int $referrerId,
    int $newUserId
): bool {

    if ($referrerId <= 0) {
        return false;
    }

    if ($referrerId === $newUserId) {
        return false;
    }

    if (getUser($referrerId) === null) {
        return false;
    }

    if (getUser($newUserId) === null) {
        return false;
    }

    /*
    | اگر قبلاً برای این کاربر ثبت شده باشد،
    | دوباره سکه داده نمی‌شود.
    */

    if (
        getReferralByReferred($newUserId)
        !== null
    ) {
        return false;
    }

    $pdo = db();

    try {

        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            "
            INSERT INTO referrals
            (
                referrer_id,
                referred_id,
                reward
            )
            VALUES
            (
                :referrer_id,
                :referred_id,
                :reward
            )
            "
        );

        $stmt->execute([
            ':referrer_id' => $referrerId,
            ':referred_id' => $newUserId,
            ':reward' => REFERRAL_REWARD
        ]);

        $stmt = $pdo->prepare(
            "
            UPDATE users
            SET
                coins = coins + :reward,
                updated_at = CURRENT_TIMESTAMP
            WHERE telegram_id = :referrer_id
            "
        );

        $stmt->execute([
            ':reward' => REFERRAL_REWARD,
            ':referrer_id' => $referrerId
        ]);

        $pdo->commit();

        return true;

    } catch (Throwable $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        error_log(
            'REFERRAL ERROR: ' . $e->getMessage()
        );

        return false;
    }
}

function getReferralCount(
    int $telegramId
): int {

    $row = dbOne(
        "
        SELECT COUNT(*) AS total
        FROM referrals
        WHERE referrer_id = :telegram_id
        ",
        [
            ':telegram_id' => $telegramId
        ]
    );

    return (int)($row['total'] ?? 0);
}

/*
|--------------------------------------------------------------------------
| وضعیت مکالمه
|--------------------------------------------------------------------------
*/

function setUserState(
    string $botType,
    int $botId,
    int $telegramId,
    string $state,
    array $data = []
): void {

    dbQuery(
        "
        INSERT INTO user_states
        (
            bot_type,
            bot_id,
            telegram_id,
            state,
            data,
            updated_at
        )
        VALUES
        (
            :bot_type,
            :bot_id,
            :telegram_id,
            :state,
            :data,
            CURRENT_TIMESTAMP
        )
        ON CONFLICT
        (
            bot_type,
            bot_id,
            telegram_id
        )
        DO UPDATE SET
            state = EXCLUDED.state,
            data = EXCLUDED.data,
            updated_at = CURRENT_TIMESTAMP
        ",
        [
            ':bot_type' => $botType,
            ':bot_id' => $botId,
            ':telegram_id' => $telegramId,
            ':state' => $state,
            ':data' => json_encode(
                $data,
                JSON_UNESCAPED_UNICODE
            )
        ]
    );
}

function getUserState(
    string $botType,
    int $botId,
    int $telegramId
): ?array {

    $row = dbOne(
        "
        SELECT *
        FROM user_states
        WHERE
            bot_type = :bot_type
            AND bot_id = :bot_id
            AND telegram_id = :telegram_id
        LIMIT 1
        ",
        [
            ':bot_type' => $botType,
            ':bot_id' => $botId,
            ':telegram_id' => $telegramId
        ]
    );

    if (!$row) {
        return null;
    }

    $data = [];

    if (!empty($row['data'])) {

        $decoded = json_decode(
            $row['data'],
            true
        );

        if (is_array($decoded)) {
            $data = $decoded;
        }
    }

    $row['data_array'] = $data;

    return $row;
}

function clearUserState(
    string $botType,
    int $botId,
    int $telegramId
): void {

    dbQuery(
        "
        DELETE FROM user_states
        WHERE
            bot_type = :bot_type
            AND bot_id = :bot_id
            AND telegram_id = :telegram_id
        ",
        [
            ':bot_type' => $botType,
            ':bot_id' => $botId,
            ':telegram_id' => $telegramId
        ]
    );
}

/*
|--------------------------------------------------------------------------
| ربات‌های فرزند
|--------------------------------------------------------------------------
*/

function createChildBot(
    int $ownerTelegramId,
    string $botToken,
    int $botId,
    string $botUsername,
    string $botName
): bool {

    dbQuery(
        "
        INSERT INTO child_bots
        (
            owner_telegram_id,
            bot_id,
            bot_username,
            bot_name,
            bot_token
        )
        VALUES
        (
            :owner_telegram_id,
            :bot_id,
            :bot_username,
            :bot_name,
            :bot_token
        )
        ",
        [
            ':owner_telegram_id' => $ownerTelegramId,
            ':bot_id' => $botId,
            ':bot_username' => $botUsername,
            ':bot_name' => $botName,
            ':bot_token' => $botToken
        ]
    );

    return true;
}

function getChildBotById(
    int $childBotId
): ?array {

    return dbOne(
        "
        SELECT *
        FROM child_bots
        WHERE id = :id
        LIMIT 1
        ",
        [
            ':id' => $childBotId
        ]
    );
}

function getChildBotByTelegramBotId(
    int $botId
): ?array {

    return dbOne(
        "
        SELECT *
        FROM child_bots
        WHERE bot_id = :bot_id
        LIMIT 1
        ",
        [
            ':bot_id' => $botId
        ]
    );
}

function getChildBotByToken(
    string $token
): ?array {

    return dbOne(
        "
        SELECT *
        FROM child_bots
        WHERE bot_token = :bot_token
        LIMIT 1
        ",
        [
            ':bot_token' => $token
        ]
    );
}

function getUserChildBots(
    int $ownerTelegramId
): array {

    return dbAll(
        "
        SELECT *
        FROM child_bots
        WHERE owner_telegram_id = :owner_id
        ORDER BY id DESC
        ",
        [
            ':owner_id' => $ownerTelegramId
        ]
    );
}

function getChildBotCount(
    int $ownerTelegramId
): int {

    $row = dbOne(
        "
        SELECT COUNT(*) AS total
        FROM child_bots
        WHERE owner_telegram_id = :owner_id
        ",
        [
            ':owner_id' => $ownerTelegramId
        ]
    );

    return (int)($row['total'] ?? 0);
}

function setChildBotActive(
    int $childBotId,
    bool $active
): bool {

    dbQuery(
        "
        UPDATE child_bots
        SET is_active = :active
        WHERE id = :id
        ",
        [
            ':active' => $active,
            ':id' => $childBotId
        ]
    );

    return true;
}

/*
|--------------------------------------------------------------------------
| زبان کاربران ربات فرزند
|--------------------------------------------------------------------------
*/

function setUserLanguage(
    int $childBotId,
    int $telegramId,
    string $language
): void {

    dbQuery(
        "
        INSERT INTO user_languages
        (
            child_bot_id,
            telegram_id,
            language
        )
        VALUES
        (
            :child_bot_id,
            :telegram_id,
            :language
        )
        ON CONFLICT
        (
            child_bot_id,
            telegram_id
        )
        DO UPDATE SET
            language = EXCLUDED.language
        ",
        [
            ':child_bot_id' => $childBotId,
            ':telegram_id' => $telegramId,
            ':language' => $language
        ]
    );
}

function getUserLanguage(
    int $childBotId,
    int $telegramId
): ?string {

    $row = dbOne(
        "
        SELECT language
        FROM user_languages
        WHERE
            child_bot_id = :child_bot_id
            AND telegram_id = :telegram_id
        LIMIT 1
        ",
        [
            ':child_bot_id' => $childBotId,
            ':telegram_id' => $telegramId
        ]
    );

    return $row['language'] ?? null;
}

/*
|--------------------------------------------------------------------------
| آمار
|--------------------------------------------------------------------------
*/

function getTotalUsers(): int
{
    $row = dbOne(
        "SELECT COUNT(*) AS total FROM users"
    );

    return (int)($row['total'] ?? 0);
}

function getBlockedUsers(): int
{
    $row = dbOne(
        "
        SELECT COUNT(*) AS total
        FROM users
        WHERE is_blocked = TRUE
        "
    );

    return (int)($row['total'] ?? 0);
}

function getTotalChildBots(): int
{
    $row = dbOne(
        "
        SELECT COUNT(*) AS total
        FROM child_bots
        "
    );

    return (int)($row['total'] ?? 0);
}

function getTotalCoins(): int
{
    $row = dbOne(
        "
        SELECT COALESCE(SUM(coins), 0) AS total
        FROM users
        "
    );

    return (int)($row['total'] ?? 0);
}

/*
|--------------------------------------------------------------------------
| لاگ مدیریت
|--------------------------------------------------------------------------
*/

function adminLog(
    int $adminId,
    string $action,
    ?int $targetId = null,
    string $details = ''
): void {

    dbQuery(
        "
        INSERT INTO admin_logs
        (
            admin_id,
            action,
            target_id,
            details
        )
        VALUES
        (
            :admin_id,
            :action,
            :target_id,
            :details
        )
        ",
        [
            ':admin_id' => $adminId,
            ':action' => $action,
            ':target_id' => $targetId,
            ':details' => $details
        ]
    );
}

/*
|--------------------------------------------------------------------------
| لیست کاربران برای Broadcast
|--------------------------------------------------------------------------
*/

function getAllUserIds(): array
{
    $rows = dbAll(
        "
        SELECT telegram_id
        FROM users
        WHERE is_blocked = FALSE
        ORDER BY id ASC
        "
    );

    return array_map(
        static fn(array $row): int =>
            (int)$row['telegram_id'],
        $rows
    );
}
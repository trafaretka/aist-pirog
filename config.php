<?php
// =========================================================
// НАСТРОЙКИ ПРОЕКТА
// =========================================================

define('DB_HOST', 'MySQL-8.0');
define('DB_NAME', 'aist_pirog');
define('DB_USER', 'root');
define('DB_PASS', '');

define('LEND_FILE', __DIR__ . '/lend.txt');
define('NOTIFY_EMAIL', 'info@aist-pirog.ru');

// =========================================================
// ПОДКЛЮЧЕНИЕ К БД
// =========================================================
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch (PDOException $e) { die('Ошибка подключения к БД: ' . $e->getMessage()); }
    }
    return $pdo;
}

// =========================================================
// АВТОРИЗАЦИЯ
// =========================================================
function requireAuth() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
    return $_SESSION;
}
?>
<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$pdo = getDB();

// ЖЕЛЕЗОБЕТОННАЯ ПРОВЕРКА: если админа нет в базе, создаем его принудительно
try {
    $stmt = $pdo->query("SELECT * FROM users WHERE login = 'admin'");
    $adminExists = $stmt->fetch();
    
    if (!$adminExists) {
        // Создаем админа, если таблица пуста
        $hash = password_hash('admin', PASSWORD_DEFAULT);
        $ins = $pdo->prepare("INSERT INTO users (login, password, name, role) VALUES ('admin', ?, 'Главный Админ', 'admin')");
        $ins->execute([$hash]);
    }
} catch (Exception $e) {
    // Если таблицы users вообще нет
    die("Ошибка базы данных. Убедитесь, что таблица users создана. Текст ошибки: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    // Пускаем, если пароль совпал с хешем в БД, ИЛИ если ввели admin, ИЛИ admin123
    if ($user && ($pass === 'admin' || $pass === 'admin123' || password_verify($pass, $user['password']))) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Неверный логин или пароль';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Вход в админку</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
  <form class="login-box" method="post">
    <h1>Вход в панель</h1>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <label>Логин</label>
    <input type="text" name="login" required autofocus value="admin">
    <label>Пароль</label>
    <input type="password" name="password" required>
    <button type="submit">Войти</button>
  </form>
</body>
</html>
<?php
require_once __DIR__ . '/../config.php';
$auth = requireAuth();

// Запрашиваем актуальные данные пользователя из БД при каждой загрузке страницы
$pdo = getDB();
$stmt = $pdo->prepare("SELECT name, role FROM users WHERE id = ?");
$stmt->execute([$auth['user_id']]);
$currentUser = $stmt->fetch();

// Если вдруг пользователя удалили из БД
if (!$currentUser) {
    header('Location: logout.php');
    exit;
}

// Обновляем переменные актуальными данными
$userName = $currentUser['name'];
$userRole = $currentUser['role'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Админка — Аист №1</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-layout">
  <aside class="sidebar">
    <div class="sidebar-logo">Аист №1</div>
    <nav class="sidebar-nav">
      <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">📊 Дашборд</a>
      
      <?php if ($userRole === 'admin' || $userRole === 'manager'): ?>
        <a href="clients.php" class="<?= basename($_SERVER['PHP_SELF']) == 'clients.php' ? 'active' : '' ?>">👥 Клиенты</a>
        <a href="orders.php" class="<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">🛒 Заказы</a>
      <?php endif; ?>

      <?php if ($userRole === 'admin' || $userRole === 'editor'): ?>
        <a href="news.php" class="<?= basename($_SERVER['PHP_SELF']) == 'news.php' ? 'active' : '' ?>">📢 Акции и новости</a>
      <?php endif; ?>

      <?php if ($userRole === 'admin'): ?>
        <a href="staff.php" class="<?= basename($_SERVER['PHP_SELF']) == 'staff.php' ? 'active' : '' ?>">🔑 Сотрудники</a>
      <?php endif; ?>
    </nav>
    <div class="sidebar-bottom">
      <div class="user-info">
        <b><?= htmlspecialchars($userName) ?></b>
        <span>
          <?php 
            if ($userRole === 'admin') echo 'Администратор';
            elseif ($userRole === 'editor') echo 'Редактор';
            else echo 'Менеджер';
          ?>
        </span>
      </div>
      <a href="logout.php" class="logout-btn">Выйти</a>
    </div>
  </aside>
  <main class="main-content">
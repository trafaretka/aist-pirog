<?php include 'header.php'; ?>

<div class="page-header">
  <h1>Дашборд</h1>
  <p>Общая статистика по работе пекарни</p>
</div>

<?php
$pdo = getDB();
$todayOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total) FROM orders WHERE status != 'cancelled'")->fetchColumn() ?: 0;
$newOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'new'")->fetchColumn();
$clientsCount = $pdo->query("SELECT COUNT(DISTINCT phone) FROM orders")->fetchColumn();
?>

<div class="stats-grid">
  <div class="stat-card">
    <span class="stat-title">Заказов сегодня</span>
    <b class="stat-value"><?= $todayOrders ?></b>
  </div>
  <div class="stat-card">
    <span class="stat-title">Общая выручка</span>
    <b class="stat-value"><?= number_format($totalRevenue, 0, '', ' ') ?> ₽</b>
  </div>
  <div class="stat-card">
    <span class="stat-title">Новых заказов</span>
    <b class="stat-value text-blue"><?= $newOrders ?></b>
  </div>
  <div class="stat-card">
    <span class="stat-title">Уникальных клиентов</span>
    <b class="stat-value"><?= $clientsCount ?></b>
  </div>
</div>

<div class="card">
  <h2>Последние 5 заказов</h2>
  <?php $recent = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll(); ?>
  <?php if($recent): ?>
    <table class="table">
      <tr><th>ID</th><th>Клиент</th><th>Сумма</th><th>Дата</th><th>Статус</th></tr>
      <?php foreach($recent as $r): ?>
      <tr>
        <td>#<?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['last_name'] . ' ' . $r['first_name']) ?></td>
        <td><?= $r['total'] ?> ₽</td>
        <td><?= date('d.m.Y H:i', strtotime($r['created_at'])) ?></td>
        <td><span class="badge badge-<?= $r['status'] ?>"><?= $r['status'] ?></span></td>
      </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>Заказов пока нет.</p>
  <?php endif; ?>
</div>

</main></div></body></html>
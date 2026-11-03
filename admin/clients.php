<?php include 'header.php'; ?>

<div class="page-header">
  <h1>База клиентов</h1>
  <p>Все клиенты, когда-либо оформлявшие заказы</p>
</div>

<?php
$pdo = getDB();
$clients = $pdo->query("
    SELECT phone, 
           MAX(last_name) as last_name, 
           MAX(first_name) as first_name, 
           MAX(address) as address,
           COUNT(*) as orders_count, 
           SUM(total) as total_spent,
           MAX(created_at) as last_order
    FROM orders 
    GROUP BY phone 
    ORDER BY last_order DESC
")->fetchAll();
?>

<div class="card">
  <?php if($clients): ?>
    <table class="table">
      <thead>
        <tr>
          <th>Клиент</th>
          <th>Телефон</th>
          <th>Адрес</th>
          <th>Заказов</th>
          <th>Потрачено</th>
          <th>Последний заказ</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($clients as $c): ?>
        <tr>
          <td><b><?= htmlspecialchars($c['last_name'] . ' ' . $c['first_name']) ?></b></td>
          <td><a href="tel:<?= $c['phone'] ?>" class="phone-link"><?= htmlspecialchars($c['phone']) ?></a></td>
          <td><?= htmlspecialchars($c['address']) ?></td>
          <td><?= $c['orders_count'] ?></td>
          <td><?= $c['total_spent'] ?> ₽</td>
          <td><?= date('d.m.Y', strtotime($c['last_order'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="empty">Пока нет ни одного клиента.</p>
  <?php endif; ?>
</div>

</main></div></body></html>
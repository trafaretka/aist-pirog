<?php 
// 1. Сначала только логика и проверки, без вывода HTML
require_once __DIR__ . '/../config.php';
$auth = requireAuth();

$pdo = getDB();

// 2. Обработка смены статуса ДО вывода шапки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $allowed = ['new', 'processing', 'done', 'cancelled'];
    if (in_array($_POST['status'], $allowed, true)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], (int)$_POST['order_id']]);
    }
    header('Location: orders.php'); 
    exit;
}

// 3. Только теперь подключаем шапку
include 'header.php'; 

$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
?>

<div class="page-header">
  <h1>Управление заказами</h1>
</div>

<?php foreach($orders as $o): ?>
<div class="card order-card status-<?= $o['status'] ?>">
  <div class="order-head">
    <div>
      <h2>Заказ #<?= $o['id'] ?> <small><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></small></h2>
      <p><b>Клиент:</b> <?= htmlspecialchars($o['last_name'].' '.$o['first_name']) ?> | <b>Тел:</b> <a href="tel:<?= $o['phone'] ?>"><?= $o['phone'] ?></a></p>
      <p><b>Адрес:</b> <?= htmlspecialchars($o['address']) ?></p>
    </div>
    
    <!-- Форма смены статуса -->
    <form method="post" class="status-form">
      <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
      <select name="status" onchange="this.form.submit()">
        <option value="new" <?= $o['status']=='new'?'selected':'' ?>>🆕 Новый</option>
        <option value="processing" <?= $o['status']=='processing'?'selected':'' ?>>⏳ В работе</option>
        <option value="done" <?= $o['status']=='done'?'selected':'' ?>>✅ Выполнен</option>
        <option value="cancelled" <?= $o['status']=='cancelled'?'selected':'' ?>>❌ Отменён</option>
      </select>
    </form>
    
  </div>
  <div class="order-body">
    <div class="items-list">
      <?php 
      $items = json_decode($o['items_json'], true) ?: [];
      foreach($items as $it): ?>
        <div class="item-row">
          <span><?= htmlspecialchars($it['title']) ?> (<?= $it['size'] ?>) x <?= $it['qty'] ?> шт.</span>
          <b><?= ($it['price'] * $it['qty']) ?> ₽</b>
        </div>
      <?php endforeach; ?>
      <div class="total-row">Итого: <b><?= $o['total'] ?> ₽</b></div>
    </div>
  </div>
</div>
<?php endforeach; ?>

</main></div></body></html>
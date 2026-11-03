<?php 
// 1. Сначала только логика и проверки, без вывода HTML
require_once __DIR__ . '/../config.php';
$auth = requireAuth();

// Доступ только для админа и редактора
if ($auth['user_role'] !== 'admin' && $auth['user_role'] !== 'editor') { 
    die('Доступ запрещен. Только для редакторов.'); 
}

$pdo = getDB();

// 2. Обрабатываем действия ДО вывода шапки
// Удаление акции
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM promotions WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: news.php'); 
    exit;
}

// Включение/выключение видимости
if (isset($_GET['toggle'])) {
    $stmt = $pdo->prepare("UPDATE promotions SET is_active = NOT is_active WHERE id = ?");
    $stmt->execute([(int)$_GET['toggle']]);
    header('Location: news.php'); 
    exit;
}

// Добавление новой акции
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_promo'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $img = trim($_POST['image_url']);
    
    if ($title && $desc) {
        $stmt = $pdo->prepare("INSERT INTO promotions (title, description, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$title, $desc, $img]);
        header('Location: news.php'); 
        exit;
    }
}

// 3. Только теперь подключаем шапку и выводим данные
include 'header.php'; 

$promos = $pdo->query("SELECT * FROM promotions ORDER BY created_at DESC")->fetchAll();
?>

<div class="page-header">
  <h1>Акции и новости</h1>
  <p>Управление баннерами и скидками на главной странице</p>
</div>

<div class="grid-2">
  <div class="card">
    <h2>Добавить новую акцию</h2>
    <form method="post" class="simple-form">
      <input type="hidden" name="add_promo" value="1">
      <label>Заголовок (например: Скидка 20% на все пироги)</label>
      <input type="text" name="title" required>
      <label>Описание</label>
      <textarea name="description" rows="3" required style="padding: 10px; border: 1.5px solid #eadfd0; border-radius: 8px; font-family: inherit;"></textarea>
      <label>Ссылка на картинку (необязательно)</label>
      <input type="text" name="image_url" placeholder="img/promo1.jpg">
      <button type="submit" class="btn-primary">Опубликовать</button>
    </form>
  </div>
  
  <div class="card">
    <h2>Список акций</h2>
    <div class="promo-grid" style="grid-template-columns: 1fr;">
      <?php if($promos): foreach($promos as $p): ?>
        <div class="promo-card" style="<?= !$p['is_active'] ? 'opacity: 0.6;' : '' ?>">
          <?php if($p['image_url']): ?>
            <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="Промо">
          <?php endif; ?>
          <div class="promo-card-content" style="display: flex; flex-direction: column; flex: 1;">
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
            <div class="promo-actions" style="margin-top: auto;">
              <form method="get" class="toggle-form" style="display:inline;">
                <input type="hidden" name="toggle" value="<?= $p['id'] ?>">
                <button type="submit"><?= $p['is_active'] ? '🙈 Скрыть' : '👁 Показать' ?></button>
              </form>
              <a href="?delete=<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('Удалить эту акцию?')">Удалить</a>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <p class="empty">Акций пока нет.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

</main></div></body></html>
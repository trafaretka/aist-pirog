<?php 
// 1. Сначала только логика и проверки, без вывода HTML
require_once __DIR__ . '/../config.php';
$auth = requireAuth();

if ($auth['user_role'] !== 'admin') { 
    die('Доступ запрещен.'); 
}

$pdo = getDB();
$error = '';

// 2. Обработка удаления сотрудника
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    
    // Запрещаем удалять самого себя
    if ($deleteId === (int)$auth['user_id']) {
        $error = "Вы не можете удалить самого себя!";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$deleteId]);
        header('Location: staff.php'); 
        exit;
    }
}

// 3. Обработка добавления сотрудника
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $login = trim($_POST['login']);
    $name = trim($_POST['name']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // берем роль из формы
    
    // Проверка на допустимые роли
    if (!in_array($role, ['admin', 'manager', 'editor'])) {
        $role = 'manager';
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users (login, password, name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$login, $pass, $name, $role]);
        header('Location: staff.php'); 
        exit;
    } catch(Exception $e) { 
        $error = "Ошибка: логин уже существует"; 
    }
}

// 4. Только теперь выводим HTML-шапку
include 'header.php'; 

$users = $pdo->query("SELECT * FROM users ORDER BY role, name")->fetchAll();
?>

<div class="page-header"><h1>Сотрудники и роли</h1></div>

<?php if($error): ?><div class="alert-error"><?= $error ?></div><?php endif; ?>

<div class="grid-2">
  <div class="card">
    <h2>Добавить сотрудника</h2>
    <form method="post" class="simple-form">
      <input type="hidden" name="add_user" value="1">
      <label>Имя</label>
      <input type="text" name="name" required>
      <label>Логин</label>
      <input type="text" name="login" required>
      <label>Пароль</label>
      <input type="text" name="password" required>
      <label>Роль</label>
      <select name="role">
        <option value="manager">Менеджер (только заказы и клиенты)</option>
        <option value="editor">Редактор (только акции и новости)</option>
        <option value="admin">Администратор (полный доступ)</option>
      </select>
      <button type="submit" class="btn-primary">Создать</button>
    </form>
  </div>
  
  <div class="card">
    <h2>Список сотрудников</h2>
    <table class="table">
      <tr>
        <th>Имя</th>
        <th>Логин</th>
        <th>Роль</th>
        <th>Действие</th>
      </tr>
      <?php foreach($users as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['login']) ?></td>
        <td><b>
          <?php 
            if ($u['role'] === 'admin') echo '👑 Админ';
            elseif ($u['role'] === 'editor') echo '✍️ Редактор';
            else echo '👤 Менеджер'; 
          ?>
        </b></td>
        <td>
          <?php if ($u['id'] == $auth['user_id']): ?>
            <span style="color: #999; font-size: 12px;">(Это вы)</span>
          <?php else: ?>
            <a href="?delete_id=<?= $u['id'] ?>" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить сотрудника <?= htmlspecialchars($u['name']) ?>? Он больше не сможет войти в админку.');">Удалить</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

</main></div></body></html>
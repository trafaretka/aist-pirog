<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    $data = $_POST;
}

$lastName  = trim($data['lastName']  ?? '');
$firstName = trim($data['firstName'] ?? '');
$phone     = trim($data['phone']     ?? '');
$address   = trim($data['address']   ?? '');
$comment   = trim($data['comment']   ?? '');
$items     = $data['items']          ?? [];
$total     = (int)($data['total']    ?? 0);
$agreePd   = !empty($data['agreePd']);

$errors = [];
if ($lastName === '')  $errors[] = 'Не указана фамилия';
if ($firstName === '') $errors[] = 'Не указано имя';
if (!preg_match('/^[\d\s\+\-\(\)]{7,25}$/', $phone)) $errors[] = 'Некорректный телефон';
if ($address === '')   $errors[] = 'Не указан адрес';
if (!is_array($items) || count($items) === 0) $errors[] = 'Корзина пуста';
if (!$agreePd)         $errors[] = 'Нет согласия на обработку ПД';

if ($errors) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? null;
$ua = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
$itemsJson = json_encode($items, JSON_UNESCAPED_UNICODE);

try {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO orders
            (last_name, first_name, phone, address, comment, items_json, total, ip, user_agent)
        VALUES
            (:ln, :fn, :ph, :ad, :cm, :it, :tot, :ip, :ua)
    ");
    $stmt->execute([
        ':ln'  => $lastName,
        ':fn'  => $firstName,
        ':ph'  => $phone,
        ':ad'  => $address,
        ':cm'  => $comment,
        ':it'  => $itemsJson,
        ':tot' => $total,
        ':ip'  => $ip,
        ':ua'  => $ua,
    ]);
    $orderId = $pdo->lastInsertId();
} catch (Exception $e) {
    $orderId = 0;
}

$logLine = sprintf(
    "[%s] #%s | %s %s | %s | %s | Сумма: %d ₽ | IP: %s\n",
    date('Y-m-d H:i:s'),
    $orderId,
    $lastName,
    $firstName,
    $phone,
    $address,
    $total,
    $ip
);
@file_put_contents(LEND_FILE, $logLine, FILE_APPEND | LOCK_EX);

if (NOTIFY_EMAIL) {
    $subject = "Новый заказ #$orderId на сайте Аист №1";
    $message = "Имя: $lastName $firstName\n";
    $message .= "Телефон: $phone\n";
    $message .= "Адрес: $address\n";
    if ($comment) $message .= "Комментарий: $comment\n";
    $message .= "Сумма: $total ₽\n\n";
    $message .= "Состав:\n";
    foreach ($items as $it) {
        $message .= "• " . ($it['title'] ?? '—') . " (" . ($it['size'] ?? '—') . ") × "
                  . ($it['qty'] ?? 0) . " = " . (($it['price'] ?? 0) * ($it['qty'] ?? 0)) . " ₽\n";
    }
    @mail(NOTIFY_EMAIL, $subject, $message, "From: no-reply@aist-pirog.ru\r\nContent-Type: text/plain; charset=utf-8");
}

echo json_encode([
    'ok' => true,
    'orderId' => $orderId,
    'message' => 'Спасибо! Мы вам перезвоним в течение 5 минут.'
], JSON_UNESCAPED_UNICODE);
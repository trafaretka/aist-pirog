<?php
require_once __DIR__ . '/config.php';
$promos = getDB()->query("SELECT * FROM promotions WHERE is_active = 1 ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Осетинские пироги — Аист №1</title>
<meta name="description" content="Настоящие осетинские пироги. Доставка за 30 минут." />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ШАПКА -->
<header class="header">
  <div class="container header-inner">
    <a href="#" class="logo">
      <div class="logo-mark">А</div>
      <div class="logo-text">
        <b>Аист №1</b>
        <span>Осетинская пекарня</span>
      </div>
    </a>
    <nav class="nav">
      <a href="#menu">Меню</a>
      <a href="#how">Доставка</a>
      <a href="#order">Контакты</a>
    </nav>
    <div class="header-actions">
      <a href="tel:+74956607793" class="phone">+7 (495) 660-77-93</a>
      <button class="cart-btn" onclick="openCart()">
        🛒 Корзина <span class="cart-count" id="cart-count">0</span>
      </button>
    </div>
  </div>
</header>

<!-- ГЕРОЙ-БЛОК -->
<section class="hero">
  <div class="container hero-grid">
    <div class="hero-content">
      <span class="eyebrow"><span class="dot"></span> Доставим за 30 минут</span>
      <h1>Осетинские пироги <br><i>нового поколения</i></h1>
      <p class="lead">Традиционный рецепт, осетинский сыр и современный подход к доставке. Горячий пирог у вашей двери.</p>
      <div class="hero-cta">
        <a href="#menu" class="btn btn-primary">Выбрать пирог</a>
      </div>
      <div class="hero-stats">
        <div class="stat"><b>30 мин</b><span>экспресс-доставка</span></div>
        <div class="stat"><b>12+</b><span>видов начинок</span></div>
        <div class="stat"><b>4.9 ★</b><span>рейтинг</span></div>
      </div>
    </div>
    <div class="hero-visual glass">
      <img src="img/3.jpg" alt="Пирог" />
    </div>
  </div>
</section>

<!-- МЕНЮ -->
<section class="menu" id="menu">
  <div class="container">
    <div class="section-head">
      <h2>Наши пироги</h2>
      <p>Выберите размер: S (22 см), M (28 см) или L (35 см).</p>
    </div>

    <div class="products">
      <!-- Товар 1 -->
      <article class="card glass" data-id="1" data-title="Уалибах" data-img="img/1.jpg">
        <div class="card-media"><img src="img/1.jpg" alt="Уалибах"></div>
        <div class="card-body">
          <h3>Уалибах</h3>
          <p class="card-desc">С осетинским сыром — классика.</p>
          <div class="sizes">
            <div class="size" data-price="490">S</div>
            <div class="size active" data-price="590">M</div>
            <div class="size" data-price="790">L</div>
          </div>
          <div class="card-foot">
            <div class="price">590 ₽</div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>
      <!-- Товар 2 -->
      <article class="card glass" data-id="2" data-title="Картофджын" data-img="img/2.jpg">
        <div class="card-media"><img src="img/2.jpg" alt="Картофджын"></div>
        <div class="card-body">
          <h3>Картофджын</h3>
          <p class="card-desc">Картофель, сыр и масло.</p>
          <div class="sizes">
            <div class="size" data-price="450">S</div>
            <div class="size active" data-price="550">M</div>
            <div class="size" data-price="750">L</div>
          </div>
          <div class="card-foot">
            <div class="price">550 ₽</div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>
      <!-- Товар 3 -->
      <article class="card glass" data-id="3" data-title="Сагджын" data-img="img/5.jpg">
        <div class="card-media"><img src="img/5.jpg" alt="Сагджын"></div>
        <div class="card-body">
          <h3>Сагджын</h3>
          <p class="card-desc">Сочная говядина с луком.</p>
          <div class="sizes">
            <div class="size" data-price="590">S</div>
            <div class="size active" data-price="690">M</div>
            <div class="size" data-price="890">L</div>
          </div>
          <div class="card-foot">
            <div class="price">690 ₽</div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>
      <!-- Товар 4 -->
      <article class="card glass" data-id="4" data-title="Балджын" data-img="img/4.jpg">
        <div class="card-media"><img src="img/4.jpg" alt="Балджын"></div>
        <div class="card-body">
          <h3>Балджын</h3>
          <p class="card-desc">Вишня с сахаром.</p>
          <div class="sizes">
            <div class="size" data-price="450">S</div>
            <div class="size active" data-price="550">M</div>
            <div class="size" data-price="750">L</div>
          </div>
          <div class="card-foot">
            <div class="price">550 ₽</div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- АКЦИИ -->
<?php if (!empty($promos)): ?>
<section class="menu" style="padding-top:0;">
  <div class="container">
    <div class="section-head"><h2>Акции</h2></div>
    <div class="products">
      <?php foreach ($promos as $p): ?>
        <article class="card glass">
          <?php if($p['image_url']): ?>
            <div class="card-media"><img src="<?= htmlspecialchars($p['image_url']) ?>" alt="Акция"></div>
          <?php endif; ?>
          <div class="card-body">
            <h3 style="color: #00f2fe;"><?= htmlspecialchars($p['title']) ?></h3>
            <p class="card-desc"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ФУТЕР -->
<footer class="footer" id="order">
  <div class="container footer-inner">
    <div>© 2026 Пекарня «Аист №1».</div>
    <div>Сделано с любовью к традициям.</div>
  </div>
</footer>

<!-- КОРЗИНА (Функционал) -->
<div class="cart-overlay" id="cart-overlay" onclick="closeCart()"></div>
<div class="cart-sidebar glass" id="cart-sidebar">
  <div class="cart-header">
    <h3>Ваша корзина</h3>
    <button class="cart-close" onclick="closeCart()">&times;</button>
  </div>
  <div class="cart-items" id="cart-items"></div>
  <div class="cart-footer">
    <div class="cart-total">Итого: <span id="cart-total">0 ₽</span></div>
    <button class="btn btn-primary" onclick="openCheckout()" style="width:100%;">Оформить заказ</button>
  </div>
</div>

<!-- ОФОРМЛЕНИЕ (Функционал) -->
<div class="checkout-overlay" id="checkout-overlay" onclick="closeCheckout(event)">
  <div class="checkout-modal glass">
    <div class="checkout-header">
      <h3>Оформление заказа</h3>
      <button class="checkout-close" onclick="closeCheckout()">&times;</button>
    </div>
    <form class="checkout-form" id="checkout-form" onsubmit="return submitOrder(event);">
      <div class="checkout-body">
        <div class="form-row">
          <div class="form-group"><label>Фамилия *</label><input type="text" id="co-lastname" required></div>
          <div class="form-group"><label>Имя *</label><input type="text" id="co-firstname" required></div>
        </div>
        <div class="form-group"><label>Телефон *</label><input type="tel" id="co-phone" required></div>
        <div class="form-group"><label>Адрес *</label><textarea id="co-address" required rows="2"></textarea></div>
        <div class="form-group"><label>Комментарий</label><textarea id="co-comment" rows="2"></textarea></div>
        <div class="checkout-summary">Сумма: <b id="checkout-total">0 ₽</b></div>
        <label class="pd-consent">
          <input type="checkbox" id="co-pd-checkbox" required>
          <span>Я согласен с <a href="#">политикой</a></span>
        </label>
        <div class="pd-error" id="co-error">Подтвердите согласие</div>
      </div>
      <div class="checkout-footer">
        <button type="submit" class="btn btn-primary checkout-submit">Подтвердить</button>
      </div>
    </form>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
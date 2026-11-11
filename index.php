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

<style>
/* ВСТРОЕННЫЕ СТИЛИ */
:root {
    --bg: #0a0b10; --text: #ffffff; --text-muted: #8b92a5;
    --neon: #00f2fe; --neon-dark: #4facfe;
    --glass: rgba(255, 255, 255, 0.03); --glass-border: rgba(255, 255, 255, 0.08);
    --red: #ff4b4b;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: var(--bg); color: var(--text); font-family: 'Manrope', sans-serif;
    background-image: radial-gradient(circle at 15% 50%, rgba(0, 242, 254, 0.05), transparent 25%),
                      radial-gradient(circle at 85% 30%, rgba(255, 75, 75, 0.05), transparent 25%);
    min-height: 100vh; overflow-x: hidden;
}
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.glass {
    background: var(--glass); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border: 1px solid var(--glass-border); border-radius: 24px;
}
/* Шапка */
.header { padding: 20px 0; position: sticky; top: 0; z-index: 100; background: rgba(10, 11, 16, 0.8); backdrop-filter: blur(10px); border-bottom: 1px solid var(--glass-border); }
.header-inner { display: flex; justify-content: space-between; align-items: center; }
.logo { display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; }
.logo-mark { width: 40px; height: 40px; background: var(--neon); color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 20px; }
.logo-text b { display: block; font-size: 18px; }
.logo-text span { font-size: 12px; color: var(--text-muted); }
.nav a { color: var(--text-muted); text-decoration: none; margin: 0 15px; font-weight: 500; transition: color 0.3s; }
.nav a:hover { color: var(--neon); }
.header-actions { display: flex; align-items: center; gap: 20px; }
.phone { color: var(--text); text-decoration: none; font-weight: 600; }
.cart-btn { background: var(--glass); border: 1px solid var(--glass-border); color: #fff; padding: 10px 20px; border-radius: 50px; cursor: pointer; display: flex; align-items: center; gap: 10px; font-family: inherit; font-weight: 600; transition: all 0.3s; }
.cart-btn:hover { border-color: var(--neon); }
.cart-count { background: var(--neon); color: #000; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
/* Герой */
.hero { padding: 80px 0; }
.hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
.eyebrow { color: var(--neon); font-weight: 600; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
.eyebrow .dot { width: 8px; height: 8px; background: var(--neon); border-radius: 50%; box-shadow: 0 0 10px var(--neon); }
h1 { font-family: 'Playfair Display', serif; font-size: 64px; line-height: 1.1; margin-bottom: 20px; }
h1 i { color: var(--neon); font-style: italic; }
.lead { color: var(--text-muted); font-size: 18px; line-height: 1.6; margin-bottom: 30px; max-width: 80%; }
.btn { display: inline-block; padding: 16px 32px; border-radius: 50px; font-weight: 700; text-decoration: none; transition: all 0.3s; border: none; cursor: pointer; font-family: inherit; font-size: 16px; }
.btn-primary { background: linear-gradient(135deg, var(--neon), var(--neon-dark)); color: #000; box-shadow: 0 10px 30px rgba(0, 242, 254, 0.2); }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(0, 242, 254, 0.4); }
.hero-stats { display: flex; gap: 40px; margin-top: 40px; }
.stat b { display: block; font-size: 24px; color: var(--neon); }
.stat span { font-size: 14px; color: var(--text-muted); }
.hero-visual { padding: 20px; }
.hero-visual img { width: 100%; border-radius: 16px; display: block; object-fit: cover; aspect-ratio: 1; }
/* Меню */
.menu { padding: 60px 0; }
.section-head { margin-bottom: 40px; }
.section-head h2 { font-family: 'Playfair Display', serif; font-size: 42px; margin-bottom: 10px; }
.section-head p { color: var(--text-muted); font-size: 18px; }
.products { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
.card { display: flex; flex-direction: column; overflow: hidden; transition: transform 0.3s; }
.card:hover { transform: translateY(-5px); border-color: rgba(0, 242, 254, 0.3); }
.card-media img { width: 100%; height: 200px; object-fit: cover; }
.card-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
.card-body h3 { font-size: 22px; margin-bottom: 8px; font-family: 'Playfair Display', serif; }
.card-desc { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; flex-grow: 1; }
.sizes { display: flex; gap: 10px; margin-bottom: 20px; }
.size { flex: 1; text-align: center; padding: 10px; background: rgba(255, 255, 255, 0.05); border-radius: 10px; cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.2s; border: 1px solid transparent; }
.size:hover { background: rgba(255, 255, 255, 0.1); }
.size.active { background: var(--neon); color: #000; }
.card-foot { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
.price { font-size: 24px; font-weight: 800; }
.add { background: transparent; border: 1px solid var(--neon); color: var(--neon); padding: 10px 20px; border-radius: 50px; cursor: pointer; font-weight: 600; transition: all 0.3s; font-family: inherit; }
.add:hover { background: var(--neon); color: #000; }
/* Футер */
.footer { padding: 40px 0; border-top: 1px solid var(--glass-border); color: var(--text-muted); margin-top: 60px; }
.footer-inner { display: flex; justify-content: space-between; }
/* Корзина */
.cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 900; opacity: 0; visibility: hidden; transition: all 0.3s; }
.cart-overlay.active { opacity: 1; visibility: visible; }
.cart-sidebar { position: fixed; top: 0; right: -400px; width: 400px; height: 100vh; background: var(--bg); z-index: 1000; border-left: 1px solid var(--glass-border); transition: right 0.3s; display: flex; flex-direction: column; border-radius: 0; }
.cart-sidebar.active { right: 0; }
.cart-header { padding: 20px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; }
.cart-header h3 { font-family: 'Playfair Display', serif; font-size: 24px; }
.cart-close { background: none; border: none; color: #fff; font-size: 30px; cursor: pointer; }
.cart-items { flex-grow: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 15px; }
.cart-item { display: flex; gap: 15px; align-items: center; border-bottom: 1px solid var(--glass-border); padding-bottom: 15px; }
.cart-item img { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; }
.cart-item-info { flex-grow: 1; }
.cart-item-info h4 { font-size: 16px; margin-bottom: 5px; }
.cart-item-info div { font-size: 14px; color: var(--text-muted); }
.cart-footer { padding: 20px; border-top: 1px solid var(--glass-border); }
.cart-total { font-size: 20px; font-weight: 700; margin-bottom: 15px; display: flex; justify-content: space-between; }
/* Модалка оформления */
.checkout-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 1100; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.3s; padding: 20px; }
.checkout-overlay.active { opacity: 1; visibility: visible; }
.checkout-modal { width: 100%; max-width: 500px; background: var(--bg); display: flex; flex-direction: column; border-radius: 24px; overflow: hidden; }
.checkout-header { padding: 20px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; }
.checkout-close { background: none; border: none; color: #fff; font-size: 30px; cursor: pointer; }
.checkout-body { padding: 20px; overflow-y: auto; max-height: 70vh; display: flex; flex-direction: column; gap: 15px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group label { font-size: 14px; color: var(--text-muted); }
.form-group input, .form-group textarea { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid var(--glass-border); background: rgba(0,0,0,0.3); color: #fff; font-family: inherit; }
.form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--neon); }
.checkout-footer { padding: 20px; border-top: 1px solid var(--glass-border); }
/* Блок Обратной связи */
.contact-section { padding: 60px 0; }
.contact-form-container { max-width: 600px; margin: 0 auto; padding: 40px; }
.contact-form-container h2 { font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 10px; text-align: center; }
.contact-form-container p { color: var(--text-muted); text-align: center; margin-bottom: 30px; }
.contact-form { display: flex; flex-direction: column; gap: 15px; }
/* Стили для ссылок (политика) */
.pd-consent a, .privacy-link {
    color: var(--neon); text-decoration: none; font-weight: 500; transition: opacity 0.3s; border-bottom: 1px solid transparent;
}
.pd-consent a:hover, .privacy-link:hover {
    opacity: 0.8; border-bottom-color: var(--neon);
}

/* Блок ДОСТАВКА */
.delivery-section { padding: 80px 0; background: rgba(0, 0, 0, 0.2); }
.delivery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px; }
.delivery-card { padding: 30px; }
.delivery-card h3 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 20px; color: var(--neon); display: flex; align-items: center; gap: 10px; }
.delivery-list { list-style: none; display: flex; flex-direction: column; gap: 15px; }
.delivery-list li { display: flex; align-items: flex-start; gap: 15px; font-size: 16px; line-height: 1.5; }
.delivery-list li span.icon { font-size: 20px; }
.delivery-list li b { color: #fff; }
.delivery-list li p { color: var(--text-muted); margin-top: 4px; font-size: 14px; }
/* Уведомления (Тосты) */
.toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
.toast { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-left: 4px solid var(--neon); color: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); transform: translateX(120%); transition: transform 0.3s; display: flex; align-items: center; gap: 10px; }
.toast.show { transform: translateX(0); }
.toast.success { border-left-color: #00f2fe; }
.toast.error { border-left-color: var(--red); }

/* Адаптив для мобильных */
@media (max-width: 768px) {
    .hero-grid, .delivery-grid { grid-template-columns: 1fr; }
    h1 { font-size: 48px; }
    .nav { display: none; }
}
</style>
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
      <a href="#delivery">Доставка</a>
      <a href="#feedback">Обратная связь</a>
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
      <!-- Заменил на .webp и добавил loading="lazy" -->
      <img src="img/3.webp" alt="Пирог" loading="lazy" />
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
      <article class="card glass" data-id="1" data-title="Уалибах" data-img="img/1.webp">
        <div class="card-media"><img src="img/1.webp" alt="Уалибах" loading="lazy"></div>
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
      <article class="card glass" data-id="2" data-title="Картофджын" data-img="img/2.webp">
        <div class="card-media"><img src="img/2.webp" alt="Картофджын" loading="lazy"></div>
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
      <article class="card glass" data-id="3" data-title="Сагджын" data-img="img/5.webp">
        <div class="card-media"><img src="img/5.webp" alt="Сагджын" loading="lazy"></div>
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
      <article class="card glass" data-id="4" data-title="Балджын" data-img="img/4.webp">
        <div class="card-media"><img src="img/4.webp" alt="Балджын" loading="lazy"></div>
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

      <!-- Товар 5 -->
      <article class="card glass" data-id="5" data-title="Фиджин" data-img="img/1.webp">
        <div class="card-media"><img src="img/1.webp" alt="Фиджин" loading="lazy"></div>
        <div class="card-body">
          <h3>Фиджин</h3>
          <p class="card-desc">Свинина и говядина с луком.</p>
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

      <!-- Товар 6 -->
      <article class="card glass" data-id="6" data-title="Цахараджын" data-img="img/2.webp">
        <div class="card-media"><img src="img/2.webp" alt="Цахараджын" loading="lazy"></div>
        <div class="card-body">
          <h3>Цахараджын</h3>
          <p class="card-desc">Свекольная ботва и сыр.</p>
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

      <!-- Товар 7 -->
      <article class="card glass" data-id="7" data-title="Куба" data-img="img/5.webp">
        <div class="card-media"><img src="img/5.webp" alt="Куба" loading="lazy"></div>
        <div class="card-body">
          <h3>Куба</h3>
          <p class="card-desc">С сыром и яйцом.</p>
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

      <!-- Товар 8 -->
      <article class="card glass" data-id="8" data-title="Давонджын" data-img="img/4.webp">
        <div class="card-media"><img src="img/4.webp" alt="Давонджын" loading="lazy"></div>
        <div class="card-body">
          <h3>Давонджын</h3>
          <p class="card-desc">Черемша и осетинский сыр.</p>
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
    </div>
  </div>
</section>

<!-- АКЦИИ (из базы) -->
<?php if (!empty($promos)): ?>
<section class="menu" style="padding-top:0;">
  <div class="container">
    <div class="section-head"><h2>Акции</h2></div>
    <div class="products">
      <?php foreach ($promos as $p): ?>
        <article class="card glass">
          <?php if(!empty($p['image_url'])): ?>
            <!-- Для акций из базы тоже добавляем lazy load -->
            <div class="card-media"><img src="<?= htmlspecialchars($p['image_url']) ?>" alt="Акция" loading="lazy"></div>
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

<!-- ДОСТАВКА И ОПЛАТА -->
<section class="delivery-section" id="delivery">
  <div class="container">
    <div class="section-head" style="text-align: center;">
      <h2>Доставка и оплата</h2>
      <p>Горячие пироги прямо к вашей двери</p>
    </div>
    
    <div class="delivery-grid">
      <!-- Карточка 1: Условия доставки -->
      <div class="delivery-card glass">
        <h3>🚚 Условия доставки</h3>
        <ul class="delivery-list">
          <li>
            <span class="icon">⚡</span>
            <div>
              <b>Экспресс-доставка</b>
              <p>Привезем в течение 30 минут после подтверждения заказа.</p>
            </div>
          </li>
          <li>
            <span class="icon">💰</span>
            <div>
              <b>Бесплатная доставка</b>
              <p>При заказе на сумму от 1500 ₽ доставка по городу бесплатна.</p>
            </div>
          </li>
          <li>
            <span class="icon">📍</span>
            <div>
              <b>Зона доставки</b>
              <p>Доставляем по всему городу. За городом — по договоренности.</p>
            </div>
          </li>
        </ul>
      </div>

      <!-- Карточка 2: Оплата -->
      <div class="delivery-card glass">
        <h3>💳 Способы оплаты</h3>
        <ul class="delivery-list">
          <li>
            <span class="icon">💵</span>
            <div>
              <b>Наличными курьеру</b>
              <p>Оплачивайте заказ наличными при получении.</p>
            </div>
          </li>
          <li>
            <span class="icon">💳</span>
            <div>
              <b>Картой онлайн</b>
              <p>Ссылка на оплату придет в SMS после подтверждения заказа.</p>
            </div>
          </li>
          <li>
            <span class="icon">📱</span>
            <div>
              <b>СБП (Система быстрых платежей)</b>
              <p>Быстрый перевод по QR-коду. Мгновенное зачисление.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ОБРАТНАЯ СВЯЗЬ -->
<section class="contact-section" id="feedback">
  <div class="container">
    <div class="contact-form-container glass">
      <h2>Обратная связь</h2>
      <p>Оставьте свой вопрос или пожелание, и мы обязательно свяжемся с вами.</p>
      
      <form class="contact-form" id="feedback-form" onsubmit="submitFeedback(event)">
        <div class="form-group">
          <label>Ваше имя</label>
          <input type="text" id="fb-name" required placeholder="Как к вам обращаться?">
        </div>
        <div class="form-group">
          <label>Телефон или Email</label>
          <input type="text" id="fb-contact" required placeholder="+7 (___) ___-__-__">
        </div>
        <div class="form-group">
          <label>Сообщение</label>
          <textarea id="fb-message" required rows="4" placeholder="Ваш вопрос..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Отправить сообщение</button>
      </form>
    </div>
  </div>
</section>

<!-- ФУТЕР -->
<footer class="footer" id="order">
  <div class="container footer-inner">
    <div>© 2026 Пекарня «Аист №1».</div>
    <div><a href="privacy.php" class="privacy-link">Политика конфиденциальности</a></div>
  </div>
</footer>

<!-- КОРЗИНА -->
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

<!-- ОФОРМЛЕНИЕ -->
<div class="checkout-overlay" id="checkout-overlay" onclick="closeCheckout(event)">
  <div class="checkout-modal glass">
    <div class="checkout-header">
      <h3>Оформление заказа</h3>
      <button class="checkout-close" onclick="closeCheckout()">&times;</button>
    </div>
    <form class="checkout-form" id="checkout-form" onsubmit="submitOrder(event);">
      <div class="checkout-body">
        <div class="form-row">
          <div class="form-group"><label>Фамилия *</label><input type="text" id="co-lastname" required></div>
          <div class="form-group"><label>Имя *</label><input type="text" id="co-firstname" required></div>
        </div>
        <div class="form-group"><label>Телефон *</label><input type="tel" id="co-phone" required></div>
        <div class="form-group"><label>Адрес *</label><textarea id="co-address" required rows="2"></textarea></div>
        <div class="form-group"><label>Комментарий</label><textarea id="co-comment" rows="2"></textarea></div>
        <div class="cart-total">Сумма: <b id="checkout-total">0 ₽</b></div>
        <label class="pd-consent" style="font-size:14px; display:flex; align-items:center; gap:10px; margin-top: 10px;">
          <input type="checkbox" id="co-pd-checkbox" required>
          <span>Я согласен с <a href="privacy.php" target="_blank">политикой</a></span>
        </label>
      </div>
      <div class="checkout-footer">
        <button type="submit" class="btn btn-primary" style="width:100%;">Подтвердить заказ</button>
      </div>
    </form>
  </div>
</div>

<!-- Контейнер для всплывающих уведомлений -->
<div class="toast-container" id="toast-container"></div>

<script>
// ЛОГИКА КОРЗИНЫ
let cart = [];

function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `<span>${type === 'success' ? '✅' : '⚠️'}</span> <span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Выбор размера
document.querySelectorAll('.sizes').forEach(sizesContainer => {
    sizesContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('size')) {
            sizesContainer.querySelectorAll('.size').forEach(s => s.classList.remove('active'));
            e.target.classList.add('active');
            const card = sizesContainer.closest('.card');
            card.querySelector('.price').textContent = e.target.dataset.price + ' ₽';
        }
    });
});

// Добавление в корзину
document.querySelectorAll('.add').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = e.target.closest('.card');
        const id = card.dataset.id;
        const title = card.dataset.title;
        const img = card.dataset.img;
        const activeSize = card.querySelector('.size.active').textContent;
        const price = parseInt(card.querySelector('.size.active').dataset.price);
        
        const existing = cart.find(item => item.id === id && item.size === activeSize);
        if (existing) { existing.qty++; } else { cart.push({ id, title, img, size: activeSize, price, qty: 1 }); }
        
        updateCartUI();
        showToast(`«${title}» (${activeSize}) добавлен в корзину!`, 'success');
    });
});

function updateCartUI() {
    const count = cart.reduce((sum, item) => sum + item.qty, 0);
    document.getElementById('cart-count').textContent = count;
    
    const itemsContainer = document.getElementById('cart-items');
    const totalContainer = document.getElementById('cart-total');
    const checkoutTotal = document.getElementById('checkout-total');
    
    if (cart.length === 0) {
        itemsContainer.innerHTML = '<p style="color:var(--text-muted); text-align:center; margin-top:20px;">Корзина пуста</p>';
        totalContainer.textContent = '0 ₽';
        checkoutTotal.textContent = '0 ₽';
        return;
    }
    
    let html = ''; let total = 0;
    cart.forEach(item => {
        total += item.price * item.qty;
        html += `
            <div class="cart-item">
                <img src="${item.img}" alt="${item.title}">
                <div class="cart-item-info">
                    <h4>${item.title}</h4>
                    <div>Размер: ${item.size} | ${item.qty} шт.</div>
                </div>
                <div style="font-weight:700;">${item.price * item.qty} ₽</div>
            </div>
        `;
    });
    itemsContainer.innerHTML = html;
    totalContainer.textContent = total + ' ₽';
    checkoutTotal.textContent = total + ' ₽';
}

function openCart() { document.getElementById('cart-sidebar').classList.add('active'); document.getElementById('cart-overlay').classList.add('active'); }
function closeCart() { document.getElementById('cart-sidebar').classList.remove('active'); document.getElementById('cart-overlay').classList.remove('active'); }

function openCheckout() {
    if (cart.length === 0) { showToast('Сначала добавьте пироги в корзину!', 'error'); return; }
    closeCart();
    document.getElementById('checkout-overlay').classList.add('active');
}
function closeCheckout(e) {
    if (e && e.target !== e.currentTarget) return;
    document.getElementById('checkout-overlay').classList.remove('active');
}

function submitOrder(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    const originalText = btn.textContent;
    btn.textContent = 'Отправка...'; btn.style.opacity = '0.7'; btn.disabled = true;
    
    setTimeout(() => {
        btn.textContent = originalText; btn.style.opacity = '1'; btn.disabled = false;
        closeCheckout();
        showToast('Спасибо! Ваш заказ принят. Мы перезвоним.', 'success');
        cart = []; updateCartUI(); e.target.reset();
    }, 1500);
}

// Отправка формы обратной связи
function submitFeedback(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    const originalText = btn.textContent;
    
    btn.textContent = 'Отправка...'; btn.style.opacity = '0.7'; btn.disabled = true;
    
    setTimeout(() => {
        btn.textContent = originalText; btn.style.opacity = '1'; btn.disabled = false;
        showToast('Ваше сообщение отправлено! Мы скоро свяжемся с вами.', 'success');
        e.target.reset(); 
    }, 1500);
}
</script>
</body>
</html>
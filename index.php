<?php
require_once __DIR__ . '/config.php';
$promos = getDB()->query("SELECT * FROM promotions WHERE is_active = 1 ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Осетинские пироги в Москве с доставкой — пекарня «Аист №1»</title>
<meta name="description" content="Настоящие осетинские пироги с осетинским сыром. Бесплатная доставка по Москве за 30 минут, скидка 10% на первый заказ. ☎ +7 (495) 660-77-93" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- =========================================================
     ШАПКА САЙТА
     ========================================================= -->
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
      <a href="#about">О пекарне</a>
      <a href="#contacts">Контакты</a>
    </nav>

    <div class="header-actions">
      <a href="tel:+74956607793" class="phone">+7 (495) 660-77-93</a>
      <button class="cart-btn" onclick="openCart()">
        🛒 Корзина <span class="cart-count" id="cart-count">0</span>
      </button>
      <a href="#order" class="btn btn-primary">Заказать</a>
    </div>
  </div>
</header>

<!-- =========================================================
     HERO — первый экран
     ========================================================= -->
<section class="hero">
  <div class="container hero-grid">
    <div>
      <span class="eyebrow"><span class="dot"></span> Доставим за 30 минут</span>
      <h1>Настоящие осетинские пироги — прямо к вашему столу</h1>
      <p class="lead">Печём по традиционному рецепту на осетинском сыре. Бесплатная доставка по Москве и <b>−10%</b> на первый заказ.</p>

      <div class="hero-cta">
        <a href="#menu" class="btn btn-primary">Выбрать пирог</a>
        <a href="#how" class="btn btn-ghost">Как мы доставляем</a>
      </div>

      <div class="hero-stats">
        <div class="stat"><b>30 мин</b><span>экспресс-доставка</span></div>
        <div class="stat"><b>12+</b><span>видов начинок</span></div>
        <div class="stat"><b>4.9 ★</b><span>рейтинг гостей</span></div>
      </div>
    </div>

    <div class="hero-visual">
      <img src="img/3.jpg" alt="Свежий осетинский пирог" />
    </div>
  </div>
</section>

<!-- =========================================================
     FEATURES — 4 преимущества
     ========================================================= -->
<section class="features">
  <div class="container features-grid">
    <div class="feature">
      <div class="icon">🚚</div>
      <h3>Доставка за 30 минут</h3>
      <p>Экспресс-курьеры в пределах МКАД — пирог приедет горячим.</p>
    </div>
    <div class="feature">
      <div class="icon">🧀</div>
      <h3>Осетинский сыр</h3>
      <p>Привозим сыр прямо из Северной Осетии. Никаких заменителей.</p>
    </div>
    <div class="feature">
      <div class="icon">🔥</div>
      <h3>Печём под заказ</h3>
      <p>Каждый пирог отправляется в печь после оформления заказа.</p>
    </div>
    <div class="feature">
      <div class="icon">💳</div>
      <h3>Удобная оплата</h3>
      <p>Наличные, карта или перевод — на выбор при получении.</p>
    </div>
  </div>
</section>

<!-- =========================================================
     MENU — карточки пирогов
     ========================================================= -->
<section class="menu" id="menu">
  <div class="container">
    <div class="section-head">
      <div>
        <h2>Наши пироги</h2>
        <p>Тонкое тесто, много начинки. Выберите размер S (22 см), M (28 см) или L (35 см).</p>
      </div>
    </div>

    <div class="products">
      <!-- Карточка 1: Уалибах -->
      <article class="card" data-id="1" data-title="Уалибах" data-img="img/1.jpg">
        <div class="card-media">
          <span class="card-badge">Хит</span>
          <img src="img/1.jpg" alt="Осетинский пирог Уалибах с сыром" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Уалибах</h3>
          <p class="card-desc">С осетинским сыром — классика, с которой всё начинается.</p>
          <div class="sizes">
            <div class="size" data-price="490">S</div>
            <div class="size active" data-price="590">M</div>
            <div class="size" data-price="790">L</div>
          </div>
          <div class="card-foot">
            <div class="price">590 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>

      <!-- Карточка 2: Картофджын -->
      <article class="card" data-id="2" data-title="Картофджын" data-img="img/2.jpg">
        <div class="card-media">
          <img src="img/2.jpg" alt="Осетинский пирог Картофджын с картофелем" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Картофджын</h3>
          <p class="card-desc">Картофель, осетинский сыр и сливочное масло.</p>
          <div class="sizes">
            <div class="size" data-price="450">S</div>
            <div class="size active" data-price="550">M</div>
            <div class="size" data-price="750">L</div>
          </div>
          <div class="card-foot">
            <div class="price">550 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>

      <!-- Карточка 3: Сагджын -->
      <article class="card" data-id="3" data-title="Сагджын" data-img="img/5.jpg">
        <div class="card-media">
          <span class="card-badge">Хит</span>
          <img src="img/5.jpg" alt="Осетинский пирог Сагджын с мясом" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Сагджын</h3>
          <p class="card-desc">Сочная говядина с луком, специями и бульоном.</p>
          <div class="sizes">
            <div class="size" data-price="590">S</div>
            <div class="size active" data-price="690">M</div>
            <div class="size" data-price="890">L</div>
          </div>
          <div class="card-foot">
            <div class="price">690 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>

      <!-- Карточка 4: Балджын -->
      <article class="card" data-id="4" data-title="Балджын" data-img="img/4.jpg">
        <div class="card-media">
          <span class="card-badge">Новинка</span>
          <img src="img/4.jpg" alt="Сладкий осетинский пирог с ягодами" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Балджын</h3>
          <p class="card-desc">Вишня с сахаром. Сладкая классика осетинского стола.</p>
          <div class="sizes">
            <div class="size" data-price="450">S</div>
            <div class="size active" data-price="550">M</div>
            <div class="size" data-price="750">L</div>
          </div>
          <div class="card-foot">
            <div class="price">550 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>

      <!-- Карточка 5: Фыдджын -->
      <article class="card" data-id="5" data-title="Фыдджын" data-img="img/6.jpg">
        <div class="card-media">
          <img src="img/6.jpg" alt="Осетинский пирог с мясом в разрезе" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Фыдджын</h3>
          <p class="card-desc">Говядина с картофелем и луком — сытный, «мужской».</p>
          <div class="sizes">
            <div class="size" data-price="620">S</div>
            <div class="size active" data-price="720">M</div>
            <div class="size" data-price="920">L</div>
          </div>
          <div class="card-foot">
            <div class="price">720 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>

      <!-- Карточка 6: Цахараджын -->
      <article class="card" data-id="6" data-title="Цахараджын" data-img="img/3.jpg">
        <div class="card-media">
          <img src="img/3.jpg" alt="Осетинский пирог с сыром и травами" loading="lazy">
        </div>
        <div class="card-body">
          <h3>Цахараджын</h3>
          <p class="card-desc">Свежая ботва свёклы и осетинский сыр. Лёгкий и ароматный.</p>
          <div class="sizes">
            <div class="size" data-price="420">S</div>
            <div class="size active" data-price="520">M</div>
            <div class="size" data-price="720">L</div>
          </div>
          <div class="card-foot">
            <div class="price">520 ₽ <small>/ M</small></div>
            <button class="add">В корзину</button>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================
     STEPS — «Как это работает»
     ========================================================= -->
<section class="steps" id="how">
  <div class="container">
    <h2>Как это работает</h2>
    <div class="steps-grid">
      <div class="step">
        <div class="num">1</div>
        <h3>Выбираете пирог</h3>
        <p>Открываете меню, выбираете начинку и размер. Добавляете в корзину.</p>
      </div>
      <div class="step">
        <div class="num">2</div>
        <h3>Мы печём</h3>
        <p>Пирог отправляется в печь сразу после оформления заказа — не раньше.</p>
      </div>
      <div class="step">
        <div class="num">3</div>
        <h3>Курьер у двери</h3>
        <p>30 минут в пределах МКАД, 60 минут — за МКАД. Оплата на месте.</p>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================
     CTA — форма заказа со скидкой
     ========================================================= -->
<section class="cta" id="order">
  <div class="container">
    <div class="cta-card">
      <div>
        <h2>Закажите первый пирог со скидкой 10%</h2>
        <p>Оставьте номер — перезвоним в течение 5 минут, поможем с выбором и оформим доставку.</p>

        <form class="cta-form" id="lead-form" onsubmit="return handleLeadSubmit(event);">
          <input type="tel" required placeholder="+7 (___) ___-__-__" />
          <button class="btn btn-primary" type="submit">Получить скидку</button>

          <label class="pd-consent">
            <input type="checkbox" id="pd-checkbox" required>
            <span>
              Я согласен с
              <a href="#" onclick="openPolicy('privacy'); return false;">Политикой конфиденциальности</a>,
              <a href="#" onclick="openPolicy('terms'); return false;">Пользовательским соглашением</a>
              и
              <a href="#" onclick="openPolicy('pd'); return false;">обработкой персональных данных</a>
            </span>
          </label>
        </form>
      </div>

      <div class="cta-info">
        <div>
          <span>📞</span>
          <div><b>+7 (495) 660-77-93</b><span>Ежедневно с 9:00 до 22:00</span></div>
        </div>
        <div>
          <span>📍</span>
          <div><b>Москва и область</b><span>Доставка по МКАД и за МКАД</span></div>
        </div>
        <div>
          <span>💬</span>
          <div><b>WhatsApp / Telegram</b><span>Заказ в один клик</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================
     АКЦИИ И НОВОСТИ (Вывод из БД)
     ========================================================= -->
<?php if (!empty($promos)): ?>
<section class="menu" style="padding-bottom: 20px;">
  <div class="container">
    <div class="section-head">
      <div>
        <h2>Акции и новости</h2>
        <p>Специальные предложения от нашей пекарни</p>
      </div>
    </div>
    <div class="products" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
      <?php foreach ($promos as $p): ?>
        <article class="card" style="display: flex; flex-direction: column;">
          <?php if($p['image_url']): ?>
            <div class="card-media">
              <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
          <?php endif; ?>
          <div class="card-body">
            <h3 style="color: var(--brand); font-size: 18px;"><?= htmlspecialchars($p['title']) ?></h3>
            <p style="margin: 0; font-size: 14px; color: var(--ink-soft); line-height: 1.5;"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- =========================================================
     FOOTER
     ========================================================= -->
<footer class="footer" id="contacts">
  <div class="container footer-inner">
    <div>© 2026 Эко-пекарня «Аист №1». Осетинские пироги с доставкой по Москве.</div>
    <div>ИНН 0000000000 · info@aist-pirog.ru</div>
  </div>
</footer>

<a class="fab" href="tel:+74956607793" aria-label="Позвонить">📞</a>

<!-- =========================================================
     КОРЗИНА
     ========================================================= -->
<div class="cart-overlay" id="cart-overlay" onclick="closeCart()"></div>

<div class="cart-sidebar" id="cart-sidebar">
  <div class="cart-header">
    <h3>Ваша корзина</h3>
    <button class="cart-close" onclick="closeCart()">&times;</button>
  </div>

  <div class="cart-items" id="cart-items">
    <div class="cart-empty">Корзина пока пуста</div>
  </div>

  <div class="cart-footer">
    <div class="cart-total">Итого: <span id="cart-total">0 ₽</span></div>
    <button class="btn btn-primary" onclick="openCheckout()">Оформить заказ</button>
  </div>
</div>

<!-- =========================================================
     МОДАЛКА ОФОРМЛЕНИЯ ЗАКАЗА
     ========================================================= -->
<div class="checkout-overlay" id="checkout-overlay" onclick="closeCheckout(event)">
  <div class="checkout-modal">
    <div class="checkout-header">
      <h3>Оформление заказа</h3>
      <button class="checkout-close" onclick="closeCheckout()" aria-label="Закрыть">&times;</button>
    </div>

    <form class="checkout-form" id="checkout-form" onsubmit="return submitOrder(event);">
      <div class="checkout-body">
        <div class="form-row">
          <div class="form-group">
            <label for="co-lastname">Фамилия *</label>
            <input type="text" id="co-lastname" required placeholder="Иванов">
          </div>
          <div class="form-group">
            <label for="co-firstname">Имя *</label>
            <input type="text" id="co-firstname" required placeholder="Иван">
          </div>
        </div>

        <div class="form-group">
          <label for="co-phone">Телефон *</label>
          <input type="tel" id="co-phone" required placeholder="+7 (___) ___-__-__">
        </div>

        <div class="form-group">
          <label for="co-address">Адрес доставки *</label>
          <textarea id="co-address" required rows="2" placeholder="Улица, дом, квартира, подъезд, этаж"></textarea>
        </div>

        <div class="form-group">
          <label for="co-comment">Комментарий к заказу</label>
          <textarea id="co-comment" rows="2" placeholder="Например: позвонить за 10 минут"></textarea>
        </div>

        <div class="checkout-summary">
          <span>Сумма заказа:</span>
          <b id="checkout-total">0 ₽</b>
        </div>

        <label class="pd-consent checkout-consent">
          <input type="checkbox" id="co-pd-checkbox" required>
          <span>
            Я согласен с
            <a href="#" onclick="openPolicy('privacy'); return false;">Политикой конфиденциальности</a>,
            <a href="#" onclick="openPolicy('terms'); return false;">Пользовательским соглашением</a>
            и
            <a href="#" onclick="openPolicy('pd'); return false;">обработкой персональных данных</a>
          </span>
        </label>
        <div class="pd-error" id="co-error">Пожалуйста, подтвердите согласие на обработку персональных данных.</div>
      </div>

      <div class="checkout-footer">
        <button type="submit" class="btn btn-primary checkout-submit">Подтвердить заказ</button>
      </div>
    </form>
  </div>
</div>

<!-- ============================================================
     МОДАЛЬНЫЕ ОКНА: ПОЛИТИКИ И СОГЛАСИЯ
     ============================================================ -->
<div class="pd-modal-overlay" id="pd-modal-privacy" onclick="closePolicy(event)">
  <div class="pd-modal">
    <div class="pd-modal-header">
      <h3>Политика конфиденциальности</h3>
      <button class="pd-modal-close" onclick="closePolicy()" aria-label="Закрыть">&times;</button>
    </div>
    <div class="pd-modal-body">
      <p><em>Дата последнего обновления: 01.01.2026</em></p>
      <h4>1. Общие положения</h4>
      <p>Настоящая Политика конфиденциальности определяет порядок обработки и защиты персональных данных пользователей сайта пекарни «Аист №1» (далее — Оператор).</p>
      <p>Используя сайт и отправляя свои данные через формы, вы соглашаетесь с условиями настоящей Политики.</p>
      <h4>2. Какие данные мы собираем</h4>
      <ul>
        <li>Имя (если указано в форме заказа);</li>
        <li>Номер телефона;</li>
        <li>Адрес доставки (при оформлении заказа);</li>
        <li>Адрес электронной почты (при указании);</li>
        <li>Техническая информация: IP, тип браузера, cookie.</li>
      </ul>
      <h4>3. Цели обработки данных</h4>
      <ul>
        <li>Обработка и исполнение заказов;</li>
        <li>Связь с пользователем по вопросам заказа;</li>
        <li>Улучшение качества обслуживания;</li>
        <li>Отправка информационных сообщений (только с согласия).</li>
      </ul>
      <h4>4. Передача данных третьим лицам</h4>
      <p>Оператор не передаёт персональные данные третьим лицам, за исключением случаев, предусмотренных законодательством РФ, и случаев, когда это необходимо для исполнения заказа (например, курьерской службе).</p>
      <h4>5. Хранение и защита данных</h4>
      <p>Данные хранятся на защищённых серверах. Срок хранения — не более 3 лет с момента последнего обращения пользователя, если иное не предусмотрено законом.</p>
      <h4>6. Права пользователя</h4>
      <p>Вы вправе в любой момент запросить удаление своих персональных данных, направив запрос на <a href="mailto:info@aist-pirog.ru">info@aist-pirog.ru</a>.</p>
      <h4>7. Cookies</h4>
      <p>Сайт использует cookies для корректной работы корзины и анализа статистики. Вы можете отключить cookies в настройках браузера.</p>
      <h4>8. Изменения политики</h4>
      <p>Оператор вправе изменять настоящую Политику. Актуальная версия всегда размещена на этой странице.</p>
    </div>
  </div>
</div>

<div class="pd-modal-overlay" id="pd-modal-terms" onclick="closePolicy(event)">
  <div class="pd-modal">
    <div class="pd-modal-header">
      <h3>Пользовательское соглашение</h3>
      <button class="pd-modal-close" onclick="closePolicy()" aria-label="Закрыть">&times;</button>
    </div>
    <div class="pd-modal-body">
      <p><em>Дата последнего обновления: 01.01.2026</em></p>
      <h4>1. Предмет соглашения</h4>
      <p>Настоящее Соглашение регулирует отношения между пекарней «Аист №1» (далее — Исполнитель) и пользователем сайта (далее — Пользователь) при заказе и доставке продукции.</p>
      <h4>2. Оформление заказа</h4>
      <p>Пользователь оформляет заказ через сайт или по телефону. После подтверждения заказа Пользователем и Исполнителем договор считается заключённым.</p>
      <h4>3. Оплата</h4>
      <p>Оплата производится наличными, банковской картой или переводом при получении заказа либо онлайн, если такая возможность предусмотрена.</p>
      <h4>4. Доставка</h4>
      <p>Сроки доставки указаны на сайте и могут изменяться в зависимости от загруженности. Исполнитель обязуется уведомить Пользователя о задержке.</p>
      <h4>5. Возврат и отказ от заказа</h4>
      <p>Пользователь вправе отказаться от заказа до момента его передачи в доставку. После передачи в доставку возврат готовой продукции не осуществляется в соответствии с законодательством РФ.</p>
      <h4>6. Ответственность сторон</h4>
      <p>Исполнитель несёт ответственность за качество продукции. Пользователь несёт ответственность за достоверность предоставленных данных.</p>
      <h4>7. Прочие условия</h4>
      <p>Все споры решаются путём переговоров. При недостижении согласия — в судебном порядке в соответствии с законодательством РФ.</p>
    </div>
  </div>
</div>

<div class="pd-modal-overlay" id="pd-modal-pd" onclick="closePolicy(event)">
  <div class="pd-modal">
    <div class="pd-modal-header">
      <h3>Согласие на обработку персональных данных</h3>
      <button class="pd-modal-close" onclick="closePolicy()" aria-label="Закрыть">&times;</button>
    </div>
    <div class="pd-modal-body">
      <p><em>Дата последнего обновления: 01.01.2026</em></p>
      <h4>1. Предмет согласия</h4>
      <p>Настоящим я, субъект персональных данных (Пользователь сайта), свободно, своей волей и в своём интересе даю согласие пекарне «Аист №1» (далее — Оператор) на обработку моих персональных данных в соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ «О персональных данных».</p>
      <h4>2. Перечень данных</h4>
      <ul>
        <li>Фамилия, имя (при указании);</li>
        <li>Номер телефона;</li>
        <li>Адрес доставки;</li>
        <li>Адрес электронной почты.</li>
      </ul>
      <h4>3. Цели обработки</h4>
      <p>Обработка персональных данных осуществляется в целях: оформления и исполнения заказа, связи с Пользователем, улучшения качества обслуживания.</p>
      <h4>4. Действия с данными</h4>
      <p>Оператор вправе совершать следующие действия: сбор, запись, систематизация, накопление, хранение, уточнение, извлечение, использование, передача (в случаях, необходимых для исполнения заказа), обезличивание, блокирование, удаление, уничтожение.</p>
      <h4>5. Срок действия согласия</h4>
      <p>Согласие действует до момента его отзыва Пользователем. Отзыв осуществляется путём направления письменного заявления на адрес <a href="mailto:info@aist-pirog.ru">info@aist-pirog.ru</a>.</p>
      <h4>6. Права субъекта ПД</h4>
      <p>Пользователь имеет право на доступ к своим персональным данным, их уточнение, блокирование или уничтожение в случае их неполноты, неточности или неправомерной обработки.</p>
      <h4>7. Подтверждение</h4>
      <p>Устанавливая галочку в чекбоксе и отправляя форму, Пользователь подтверждает, что ознакомлен с настоящим Согласием, Политикой конфиденциальности и Пользовательским соглашением, и принимает их условия в полном объёме.</p>
    </div>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
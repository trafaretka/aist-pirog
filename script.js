// =========================================================
// 1. ВЫБОР РАЗМЕРА И ЦЕНЫ
// =========================================================
document.querySelectorAll('.sizes').forEach(group => {
  group.addEventListener('click', e => {
    if(!e.target.classList.contains('size')) return;
    group.querySelectorAll('.size').forEach(s => s.classList.remove('active'));
    e.target.classList.add('active');

    const card = group.closest('.card');
    const newPrice = e.target.getAttribute('data-price');
    const sizeLabel = e.target.textContent;
    card.querySelector('.price').innerHTML = `${newPrice} ₽ <small>/ ${sizeLabel}</small>`;
  });
});

// =========================================================
// 2. КОРЗИНА — ХРАНИЛИЩЕ
// =========================================================
let cart = [];

const overlay = document.getElementById('cart-overlay');
const sidebar = document.getElementById('cart-sidebar');

function openCart() {
  overlay.classList.add('active');
  sidebar.classList.add('active');
}

function closeCart() {
  overlay.classList.remove('active');
  sidebar.classList.remove('active');
}

// =========================================================
// 3. ДОБАВЛЕНИЕ В КОРЗИНУ
// =========================================================
document.querySelectorAll('.add').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.card');
    const id = card.getAttribute('data-id');
    const title = card.getAttribute('data-title');
    const img = card.getAttribute('data-img');

    const activeSize = card.querySelector('.size.active');
    const size = activeSize.textContent;
    const price = parseInt(activeSize.getAttribute('data-price'));

    const existing = cart.find(item => item.id === id && item.size === size);
    if (existing) {
      existing.qty++;
    } else {
      cart.push({ id, title, img, size, price, qty: 1 });
    }

    btn.textContent = 'Добавлено ✓';
    btn.style.background = '#5b7c5b';
    setTimeout(() => { btn.textContent = 'В корзину'; btn.style.background = ''; }, 1000);

    updateCartUI();
  });
});

// =========================================================
// 4. ИЗМЕНЕНИЕ КОЛИЧЕСТВА И УДАЛЕНИЕ
// =========================================================
function changeQty(id, size, delta) {
  const item = cart.find(i => i.id === id && i.size === size);
  if (!item) return;

  item.qty += delta;
  if (item.qty <= 0) {
    cart = cart.filter(i => !(i.id === id && i.size === size));
  }
  updateCartUI();
}

function removeItem(id, size) {
  cart = cart.filter(i => !(i.id === id && i.size === size));
  updateCartUI();
}

// =========================================================
// 5. ОТРИСОВКА КОРЗИНЫ
// =========================================================
function updateCartUI() {
  const container = document.getElementById('cart-items');
  const totalEl = document.getElementById('cart-total');
  const countEl = document.getElementById('cart-count');

  const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
  countEl.textContent = totalQty;

  if (cart.length === 0) {
    container.innerHTML = '<div class="cart-empty">Корзина пока пуста</div>';
  } else {
    container.innerHTML = cart.map(item => `
      <div class="cart-item">
        <img src="${item.img}" alt="${item.title}" class="cart-item-img">
        <div class="cart-item-info">
          <p class="cart-item-title">${item.title}</p>
          <p class="cart-item-meta">Размер: ${item.size}</p>
          <div class="cart-item-price">${item.price * item.qty} ₽</div>
        </div>
        <div class="cart-qty">
          <button onclick="changeQty('${item.id}', '${item.size}', -1)">−</button>
          <span>${item.qty}</span>
          <button onclick="changeQty('${item.id}', '${item.size}', 1)">+</button>
        </div>
        <button class="cart-remove" onclick="removeItem('${item.id}', '${item.size}')">&times;</button>
      </div>
    `).join('');
  }

  const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  totalEl.textContent = total + ' ₽';
}

// =========================================================
// 6. ОФОРМЛЕНИЕ ЗАКАЗА (открытие модалки)
// =========================================================
function openCheckout() {
  if (cart.length === 0) {
    alert('Ваша корзина пуста');
    return;
  }

  const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  document.getElementById('checkout-total').textContent = total + ' ₽';

  closeCart();
  document.getElementById('checkout-overlay').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeCheckout(event) {
  if (event && event.target !== event.currentTarget) return;

  document.getElementById('checkout-overlay').classList.remove('active');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeCheckout();
    closePolicy();
  }
});

// =========================================================
// 7. ОТПРАВКА ЗАКАЗА НА СЕРВЕР
// =========================================================
function submitOrder(event) {
  event.preventDefault();

  const checkbox = document.getElementById('co-pd-checkbox');
  const errorEl = document.getElementById('co-error');

  if (!checkbox.checked) {
    errorEl.classList.add('show');
    return false;
  }
  errorEl.classList.remove('show');

  const order = {
    lastName: document.getElementById('co-lastname').value.trim(),
    firstName: document.getElementById('co-firstname').value.trim(),
    phone: document.getElementById('co-phone').value.trim(),
    address: document.getElementById('co-address').value.trim(),
    comment: document.getElementById('co-comment').value.trim(),
    items: cart.map(item => ({
      title: item.title,
      size: item.size,
      qty: item.qty,
      price: item.price
    })),
    total: cart.reduce((sum, item) => sum + (item.price * item.qty), 0),
    agreePd: true
  };

  const submitBtn = document.querySelector('.checkout-submit');
  const originalText = submitBtn.textContent;
  submitBtn.disabled = true;
  submitBtn.textContent = 'Отправляем...';

  fetch('send.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(order)
  })
    .then(r => r.json())
    .then(res => {
      if (!res.ok) {
        throw new Error((res.errors || [res.error || 'Ошибка']).join('\n'));
      }

      cart = [];
      updateCartUI();
      closeCheckout();
      document.getElementById('checkout-form').reset();

      showSuccessMessage('Спасибо! Ваш заказ №' + res.orderId + ' принят. Мы перезвоним в течение 5 минут.');
    })
    .catch(err => {
      alert('Не удалось отправить заказ:\n' + err.message);
    })
    .finally(() => {
      submitBtn.disabled = false;
      submitBtn.textContent = originalText;
    });

  return false;
}

function showSuccessMessage(text) {
  const overlay = document.createElement('div');
  overlay.className = 'pd-modal-overlay active';
  overlay.innerHTML = `
    <div class="pd-modal" style="max-width:420px;text-align:center">
      <div class="pd-modal-body" style="padding:40px 24px">
        <div style="font-size:56px;margin-bottom:16px">✅</div>
        <h3 style="font-family:Manrope,sans-serif;margin:0 0 12px">Заказ принят!</h3>
        <p style="margin:0;color:#6d5c4b">${text}</p>
        <button class="btn btn-primary" style="margin-top:24px" onclick="this.closest('.pd-modal-overlay').remove()">Отлично</button>
      </div>
    </div>
  `;
  document.body.appendChild(overlay);
}

// =========================================================
// 8. МОДАЛКИ ПОЛИТИК
// =========================================================
function openPolicy(type) {
  const id = 'pd-modal-' + type;
  const el = document.getElementById(id);
  if (el) el.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closePolicy(event) {
  if (event && event.target !== event.currentTarget) return;

  document.querySelectorAll('.pd-modal-overlay').forEach(el => {
    el.classList.remove('active');
  });

  const checkoutOpen = document.getElementById('checkout-overlay').classList.contains('active');
  if (!checkoutOpen) document.body.style.overflow = '';
}

// =========================================================
// 9. ОБРАБОТКА ФОРМЫ НА САЙТЕ (заявка на скидку)
// =========================================================
function handleLeadSubmit(event) {
  event.preventDefault();

  const checkbox = document.getElementById('pd-checkbox');
  const form = document.getElementById('lead-form');
  const phoneInput = form.querySelector('input[type="tel"]');

  if (!checkbox.checked) {
    let error = form.querySelector('.pd-error');
    if (!error) {
      error = document.createElement('div');
      error.className = 'pd-error show';
      error.textContent = 'Пожалуйста, подтвердите согласие на обработку персональных данных.';
      checkbox.closest('.pd-consent').after(error);
    } else {
      error.classList.add('show');
    }
    return false;
  }

  fetch('send.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      lastName: '—',
      firstName: '—',
      phone: phoneInput.value.trim(),
      address: '—',
      comment: 'Быстрая заявка на скидку',
      items: [{ title: 'Заявка на скидку', size: '—', qty: 1, price: 0 }],
      total: 0,
      agreePd: true
    })
  })
    .then(r => r.json())
    .then(res => {
      if (!res.ok) throw new Error('Ошибка отправки');
      form.innerHTML = '<p style="color:#f0c98c;font-weight:700;font-size:18px;margin:0">Спасибо! Мы вам перезвоним в течение 5 минут.</p>';
    })
    .catch(() => {
      alert('Не удалось отправить заявку. Попробуйте позвонить: +7 (495) 660-77-93');
    });

  return false;
}
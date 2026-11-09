document.querySelectorAll('.sizes').forEach(group => {
  group.addEventListener('click', e => {
    if(!e.target.classList.contains('size')) return;
    group.querySelectorAll('.size').forEach(s => s.classList.remove('active'));
    e.target.classList.add('active');
    const card = group.closest('.card');
    const newPrice = e.target.getAttribute('data-price');
    card.querySelector('.price').textContent = `${newPrice} ₽`;
  });
});

let cart = [];
const overlay = document.getElementById('cart-overlay');
const sidebar = document.getElementById('cart-sidebar');

function openCart() { overlay.classList.add('active'); sidebar.classList.add('active'); }
function closeCart() { overlay.classList.remove('active'); sidebar.classList.remove('active'); }

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
    if (existing) existing.qty++;
    else cart.push({ id, title, img, size, price, qty: 1 });

    btn.textContent = 'Добавлено ✓';
    btn.style.background = '#00f2fe';
    btn.style.color = '#000';
    setTimeout(() => { btn.textContent = 'В корзину'; btn.style.background = ''; btn.style.color = ''; }, 1000);

    updateCartUI();
  });
});

function changeQty(id, size, delta) {
  const item = cart.find(i => i.id === id && i.size === size);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) cart = cart.filter(i => !(i.id === id && i.size === size));
  updateCartUI();
}

function removeItem(id, size) {
  cart = cart.filter(i => !(i.id === id && i.size === size));
  updateCartUI();
}

function updateCartUI() {
  const container = document.getElementById('cart-items');
  const totalEl = document.getElementById('cart-total');
  const countEl = document.getElementById('cart-count');
  const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
  countEl.textContent = totalQty;

  if (cart.length === 0) {
    container.innerHTML = '<p style="color:#a0aabf;text-align:center;margin-top:40px;">Корзина пуста</p>';
  } else {
    container.innerHTML = cart.map(item => `
      <div class="cart-item">
        <img src="${item.img}" class="cart-item-img">
        <div class="cart-item-info">
          <p style="font-weight:700;margin:0 0 4px;">${item.title}</p>
          <p style="font-size:12px;color:#a0aabf;margin:0 0 6px;">Размер: ${item.size}</p>
          <div style="color:#00f2fe;font-weight:800;">${item.price * item.qty} ₽</div>
        </div>
        <div class="cart-qty">
          <button onclick="changeQty('${item.id}', '${item.size}', -1)">−</button>
          <span>${item.qty}</span>
          <button onclick="changeQty('${item.id}', '${item.size}', 1)">+</button>
        </div>
      </div>
    `).join('');
  }
  const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  totalEl.textContent = total + ' ₽';
}

function openCheckout() {
  if (cart.length === 0) return alert('Корзина пуста');
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

function submitOrder(event) {
  event.preventDefault();
  const checkbox = document.getElementById('co-pd-checkbox');
  const errorEl = document.getElementById('co-error');
  if (!checkbox.checked) { errorEl.style.display = 'block'; return false; }
  errorEl.style.display = 'none';

  const order = {
    lastName: document.getElementById('co-lastname').value.trim(),
    firstName: document.getElementById('co-firstname').value.trim(),
    phone: document.getElementById('co-phone').value.trim(),
    address: document.getElementById('co-address').value.trim(),
    comment: document.getElementById('co-comment').value.trim(),
    items: cart.map(i => ({ title: i.title, size: i.size, qty: i.qty, price: i.price })),
    total: cart.reduce((sum, item) => sum + (item.price * item.qty), 0),
    agreePd: true
  };

  const btn = document.querySelector('.checkout-submit');
  btn.disabled = true; btn.textContent = 'Отправка...';

  fetch('send.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(order)
  })
  .then(r => r.json())
  .then(res => {
    if (!res.ok) throw new Error(res.error || 'Ошибка');
    cart = [];
    updateCartUI();
    closeCheckout();
    document.getElementById('checkout-form').reset();
    
    // Красивое уведомление
    const msg = document.createElement('div');
    msg.style.cssText = 'position:fixed;bottom:20px;right:20px;background:#00f2fe;color:#000;padding:16px 24px;border-radius:12px;font-weight:700;z-index:999;box-shadow:0 10px 30px rgba(0,242,254,0.4);';
    msg.textContent = 'Заказ №' + res.orderId + ' принят!';
    document.body.appendChild(msg);
    setTimeout(() => msg.remove(), 4000);
  })
  .catch(err => alert('Ошибка: ' + err.message))
  .finally(() => { btn.disabled = false; btn.textContent = 'Подтвердить'; });
  return false;
}
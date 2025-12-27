import { API_BASE, getToken, logout } from './config.js';
import { toast } from './ui.js';

if (!getToken()) logout();
document.getElementById('logoutBtn').onclick = logout;

const tbody = document.querySelector('#tbl tbody');
const searchInput = document.getElementById('search');

let items = [];
let timer = null;
searchInput.addEventListener('input', () => {
  clearTimeout(timer);
  timer = setTimeout(() => render(searchInput.value), 250);
});

async function fetchFines() {
  tbody.innerHTML = `<tr><td colspan="5">Loading...</td></tr>`;

  const res = await fetch(`${API_BASE}/my-fines`, {
    headers: { Authorization: `Bearer ${getToken()}` }
  });

  const json = await res.json().catch(() => null);
  if (!res.ok || !json) {
    tbody.innerHTML = `<tr><td colspan="5">Failed to load fines</td></tr>`;
    toast('Failed to load fines.', 'error', 'Error');
    return;
  }

  items = json.data?.data ?? json.data ?? [];
  render();
}

async function payFine(id) {
  const res = await fetch(`${API_BASE}/pay-fine/${id}`, {
    method: 'POST',
    headers: { Authorization: `Bearer ${getToken()}` }
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    alert( 'Payment failed', 'error', 'Payment');
    return;
  }

  alert( 'Fine paid', 'success', 'Payment');
  fetchFines();
}

function statusBadge(status) {
  const s = String(status ?? '').toLowerCase();
  if (s === 'paid') return `<span class="badge" style="background:rgba(6,95,70,.12);color:#065f46">Paid</span>`;
  return `<span class="badge" style="background:rgba(127,29,29,.12);color:#7f1d1d">Unpaid</span>`;
}

function render(keyword = '') {
  tbody.innerHTML = '';

  const kw = keyword.trim().toLowerCase();
  const filtered = kw
    ? items.filter(x => (x.borrowing?.book?.title ?? '').toLowerCase().includes(kw))
    : items;

  if (filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5">No fines found</td></tr>`;
    return;
  }

  filtered.forEach(f => {
    const title = f.borrowing?.book?.title ?? '-';
    const paid = String(f.status).toLowerCase() === 'paid';

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <div style="font-weight:800">${escapeHtml(title)}</div>
        <div style="color:#6b7280;font-size:12px;margin-top:4px">
          ${f.borrowing?.book?.category?.name ? `<span class="badge">${escapeHtml(f.borrowing.book.category.name)}</span>` : ''}
        </div>
      </td>
      <td><b>Rp ${Number(f.amount ?? 0).toLocaleString('id-ID')}</b></td>
      <td>${statusBadge(f.status)}</td>
      <td>${escapeHtml(f.paid_at ?? '-')}</td>
      <td>
        ${paid ? `<span style="color:#6b7280">—</span>` : `<button class="payBtn" style="width:120px">Pay</button>`}
      </td>
    `;

    const btn = tr.querySelector('.payBtn');
    if (btn) btn.onclick = () => payFine(f.id);

    tbody.appendChild(tr);
  });
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
  }[s]));
}

fetchFines();

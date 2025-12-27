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

async function fetchBorrowings() {
  tbody.innerHTML = `<tr><td colspan="5">Loading...</td></tr>`;

  const res = await fetch(`${API_BASE}/borrowings`, {
    headers: { Authorization: `Bearer ${getToken()}` }
  });

  const json = await res.json().catch(() => null);
  if (!res.ok || !json) {
    tbody.innerHTML = `<tr><td colspan="5">Failed to load borrowings</td></tr>`;
    toast('Failed to load borrowings.', 'error', 'Error');
    return;
  }

  items = json.data?.data ?? json.data ?? [];
  render();
}

function badge(status) {
  const s = String(status ?? '').toLowerCase();
  if (s === 'returned') return `<span class="badge" style="background:rgba(6,95,70,.12);color:#065f46">Returned</span>`;
  if (s === 'overdue') return `<span class="badge" style="background:rgba(127,29,29,.12);color:#7f1d1d">Overdue</span>`;
  return `<span class="badge">Borrowed</span>`;
}

function render(keyword = '') {
  tbody.innerHTML = '';

  const kw = keyword.trim().toLowerCase();
  const filtered = kw
    ? items.filter(x => (x.book?.title ?? '').toLowerCase().includes(kw))
    : items;

  if (filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5">No borrowings found</td></tr>`;
    return;
  }

  filtered.forEach(b => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <div style="font-weight:800">${escapeHtml(b.book?.title ?? '-')}</div>
        <div style="color:#6b7280;font-size:12px;margin-top:4px">
          ${b.book?.category?.name ? `<span class="badge">${escapeHtml(b.book.category.name)}</span>` : ''}
        </div>
      </td>
      <td>${badge(b.status)}</td>
      <td>${escapeHtml(b.borrow_date ?? '-')}</td>
      <td><b>${escapeHtml(b.due_date ?? '-')}</b></td>
      <td>${escapeHtml(b.return_date ?? '-')}</td>
    `;
    tbody.appendChild(tr);
  });
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
  }[s]));
}

fetchBorrowings();

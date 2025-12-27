import { API_BASE, getToken, logout } from './config.js';
import { toast } from './ui.js';

if (!getToken()) logout();

document.getElementById('logoutBtn').onclick = logout;

const tbody = document.querySelector('#booksTable tbody');
const searchInput = document.getElementById('search');

let allBooks = [];

// Modal refs
const modalBackdrop = document.getElementById('modalBackdrop');
const modalBody = document.getElementById('modalBody');
const modalCloseBtn = document.getElementById('modalCloseBtn');

modalCloseBtn.onclick = closeModal;
modalBackdrop.addEventListener('click', (e) => {
  if (e.target === modalBackdrop) closeModal();
});
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeModal();
});

let timer = null;
searchInput.addEventListener('input', () => {
  clearTimeout(timer);
  timer = setTimeout(() => renderBooks(searchInput.value), 250);
});

async function fetchBooks() {
  tbody.innerHTML = `<tr><td colspan="4">Loading...</td></tr>`;

  const res = await fetch(`${API_BASE}/books`, {
    headers: { Authorization: `Bearer ${getToken()}` }
  });

  const json = await res.json().catch(() => null);
  if (!res.ok || !json) {
    tbody.innerHTML = `<tr><td colspan="4">Failed to load books</td></tr>`;
    toast('Cannot load books. Check API/CORS.', 'error', 'Error');
    return;
  }

  // paginate or plain array
  allBooks = json.data?.data ?? json.data ?? [];
  renderBooks();
}

function renderBooks(keyword = '') {
  tbody.innerHTML = '';

  const kw = keyword.trim().toLowerCase();
  const filtered = kw
    ? allBooks.filter(b =>
        (b.title ?? '').toLowerCase().includes(kw) ||
        (b.author ?? '').toLowerCase().includes(kw) ||
        (b.isbn ?? '').toLowerCase().includes(kw)
      )
    : allBooks;

  if (filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="4">No books found</td></tr>`;
    return;
  }

  filtered.forEach(b => {
    const tr = document.createElement('tr');

    const stock = Number(b.stock ?? 0);
    const borrowDisabled = stock <= 0;

    tr.innerHTML = `
      <td>
        <div style="font-weight:700">${escapeHtml(b.title)}</div>
        <div style="color:#6b7280;font-size:12px;margin-top:4px">
          ${b.category?.name ? `<span class="badge">${escapeHtml(b.category.name)}</span>` : ``}
          ${b.isbn ? ` <span style="margin-left:8px">ISBN: ${escapeHtml(b.isbn)}</span>` : ``}
        </div>
      </td>
      <td>${escapeHtml(b.author ?? '-')}</td>
      <td><b>${stock}</b></td>
      <td style="display:flex;gap:8px">
        <button class="btn-detail" style="background:#111827">Detail</button>
        <button class="btn-borrow" ${borrowDisabled ? 'disabled' : ''}>Borrow</button>
      </td>
    `;

    tr.querySelector('.btn-detail').onclick = () => openDetail(b.id);
    tr.querySelector('.btn-borrow').onclick = () => borrowBook(b.id);

    tbody.appendChild(tr);
  });
}

async function openDetail(bookId) {
  modalBody.innerHTML = 'Loading detail...';
  openModal();

  const res = await fetch(`${API_BASE}/books/${bookId}`, {
    headers: { Authorization: `Bearer ${getToken()}` }
  });
  const json = await res.json().catch(() => null);

  if (!res.ok || !json) {
    modalBody.innerHTML = 'Failed to load detail.';
    toast('Failed to load book detail.', 'error', 'Error');
    return;
  }

  const b = json.data ?? json; // depending on your controller response
  modalBody.innerHTML = `
    <div class="modal-grid">
      <div>
        <div style="font-size:20px;font-weight:800">${escapeHtml(b.title)}</div>
        <div style="margin-top:8px;color:#6b7280">
          ${b.category?.name ? `<span class="badge">${escapeHtml(b.category.name)}</span>` : ''}
        </div>

        <div class="kv">
          <div>Author</div><div><b>${escapeHtml(b.author ?? '-')}</b></div>
          <div>ISBN</div><div>${escapeHtml(b.isbn ?? '-')}</div>
          <div>Publisher</div><div>${escapeHtml(b.publisher ?? '-')}</div>
          <div>Year</div><div>${escapeHtml(b.publication_year ?? '-')}</div>
        </div>

        <hr>

        <div style="color:#6b7280;font-size:13px;margin-bottom:6px">Description</div>
        <div style="line-height:1.6">
          ${escapeHtml(b.description ?? 'No description.')}
        </div>
      </div>

      <div>
        <div class="card" style="box-shadow:none;border:1px solid #eee">
          <div style="color:#6b7280;font-size:12px">Availability</div>
          <div style="font-size:28px;font-weight:900;margin:6px 0">${escapeHtml(String(b.stock ?? 0))}</div>
          <div style="color:#6b7280;font-size:12px">stock remaining</div>

          <div style="margin-top:14px">
            <button id="modalBorrowBtn" style="width:100%" ${Number(b.stock ?? 0) <= 0 ? 'disabled' : ''}>
              Borrow this book
            </button>
            <button id="modalCloseBtn2" style="width:100%;margin-top:10px;background:#111827">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  `;

  document.getElementById('modalCloseBtn2').onclick = closeModal;
  const mb = document.getElementById('modalBorrowBtn');
  if (mb) mb.onclick = async () => { await borrowBook(bookId); closeModal(); };
}

async function borrowBook(bookId) {
  const res = await fetch(`${API_BASE}/borrow/${bookId}`, {
    method: 'POST',
    headers: { Authorization: `Bearer ${getToken()}` }
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    alert( 'Borrow failed', 'error', 'Borrow');
    return;
  }

  alert('Borrow success');

  await fetchBooks();
}

function openModal() {
  modalBackdrop.classList.add('show');
  modalBackdrop.setAttribute('aria-hidden', 'false');
}

function closeModal() {
  modalBackdrop.classList.remove('show');
  modalBackdrop.setAttribute('aria-hidden', 'true');
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
  }[s]));
}

fetchBooks();

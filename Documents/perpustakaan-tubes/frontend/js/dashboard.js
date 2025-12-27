import { API_BASE, getToken, logout } from './config.js';

if (!getToken()) logout();
logoutBtn.onclick = logout;

const books = await fetch(`${API_BASE}/books`, {
  headers: { Authorization: `Bearer ${getToken()}` }
}).then(r => r.json());

document.getElementById('totalBooks').innerText = books.data.total;

const bor = await fetch(`${API_BASE}/borrowings`, {
  headers: { Authorization: `Bearer ${getToken()}` }
}).then(r => r.json());

document.getElementById('totalBorrowings').innerText = bor.data.total;

const fines = await fetch(`${API_BASE}/my-fines`, {
  headers: { Authorization: `Bearer ${getToken()}` }
}).then(r => r.json());

document.getElementById('totalFines').innerText =
  fines.data.data.filter(f => f.status === 'unpaid').length;

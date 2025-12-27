import { API_BASE, setToken } from './config.js';

const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

function extractToken(payload) {
  // dukung beberapa format response
  return payload?.token || payload?.data?.token || payload?.access_token || payload?.data?.access_token || null;
}

if (loginForm) {
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = loginForm.querySelector('button');
    btn.disabled = true;
    btn.innerText = 'Logging in...';

    try {
      const res = await fetch(`${API_BASE}/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
          email: document.getElementById('email').value,
          password: document.getElementById('password').value
        })
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        alert(data.message || `Login failed (${res.status})`);
        return;
      }

      const token = extractToken(data);
      if (!token) {
        alert('Login success but token not found in response. Check backend response format.');
        console.log('Login response:', data);
        return;
      }

      setToken(token);

      // Redirect (pilih salah satu)
      window.location.href = 'dashboard.html'; // kalau file dashboard.html ada
      // window.location.href = 'books.html';   // kalau belum punya dashboard
    } catch (err) {
      alert('Network error. Pastikan backend jalan di http://127.0.0.1:8000');
      console.error(err);
    } finally {
      btn.disabled = false;
      btn.innerText = 'Login';
    }
  });
}

if (registerForm) {
  registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = registerForm.querySelector('button');
    btn.disabled = true;
    btn.innerText = 'Registering...';

    try {
      const res = await fetch(`${API_BASE}/auth/register`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
          name: document.getElementById('name').value,
          email: document.getElementById('email').value,
          password: document.getElementById('password').value
        })
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        alert(data.message || `Register failed (${res.status})`);
        return;
      }

      alert(data.message || 'Register success. Please login.');
      window.location.href = 'login.html';
    } catch (err) {
      alert('Network error. Pastikan backend jalan di http://127.0.0.1:8000');
      console.error(err);
    } finally {
      btn.disabled = false;
      btn.innerText = 'Register';
    }
  });
}

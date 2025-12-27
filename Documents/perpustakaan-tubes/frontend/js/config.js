export const API_BASE = "http://127.0.0.1:8000/api";
export const TOKEN_KEY = "dl_token";

export function getToken() {
    return localStorage.getItem(TOKEN_KEY);
}

export function setToken(token) {
    localStorage.setItem(TOKEN_KEY, token);
}

export function logout() {
    localStorage.removeItem(TOKEN_KEY);
    window.location.href = "login.html";
}

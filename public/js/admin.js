// ---------- helper ----------
const $    = (id) => document.getElementById(id);
const list = (d) => Array.isArray(d) ? d : (d?.data ?? []);
const esc  = (v) => v == null ? '' : String(v).replace(/[&<>"']/g,
    (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));

function badge(s) {
    if (!s) return '-';
    const v = String(s).toLowerCase();
    const cls = ['aktif', 'active'].includes(v) ? 'bg-success'
        : ['nonaktif', 'inactive'].includes(v) ? 'bg-danger' : 'bg-secondary';
    return `<span class="badge ${cls}">${esc(s)}</span>`;
}

// heads = judul kolom, rows = array of array (isi sel berupa HTML yang sudah di-esc)
function tabel(heads, rows) {
    if (!rows.length) return '<div class="text-secondary">Belum ada data.</div>';
    return `<table class="table table-hover mb-0">
        <thead><tr>${heads.map(h => `<th>${h}</th>`).join('')}</tr></thead>
        <tbody>${rows.map(r => `<tr>${r.map(c => `<td>${c}</td>`).join('')}</tr>`).join('')}</tbody>
    </table>`;
}

// isi elemen dengan hasil fn(); kalau gagal tampilkan pesan error
async function isi(id, fn) {
    try { $(id).innerHTML = await fn(); }
    catch (e) { $(id).innerHTML = `<div class="text-danger">Gagal memuat: ${esc(e.message)}</div>`; }
}

// ---------- autentikasi ----------
const token = localStorage.getItem('token');
let me = null;
try { me = JSON.parse(localStorage.getItem('user')); } catch (e) {}
const roleName = typeof me?.role === 'object' ? me.role?.nma_role : me?.role;

function keLogin() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    location.href = '/admin/login';
}
if (!(token && me?.admin && String(roleName || '').toLowerCase() === 'admin')) keLogin();

const headers = () => ({
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Authorization': 'Bearer ' + token
});

async function request(url, opt = {}) {
    const res = await fetch(url, { ...opt, headers: headers() });
    if (res.status === 401) { keLogin(); throw new Error('Sesi berakhir, silakan login lagi'); }

    let data = null;
    try { data = await res.json(); } catch (e) {}
    if (!res.ok) throw new Error(data?.message || 'Terjadi kesalahan pada server.');
    return data;
}

const api   = (path, opt) => request('/api/admin' + path, opt);
const kirim = (path, method, body) => api(path, { method, body: JSON.stringify(body) });

// ---------- logout + auto logout 15 menit (NFR-01) ----------
async function logout() {
    try { await fetch('/api/logout', { method: 'POST', headers: headers() }); } catch (e) {}
    keLogin();
}

let idle;
const resetIdle = () => { clearTimeout(idle); idle = setTimeout(logout, 15 * 60 * 1000); };
['click', 'keydown', 'mousemove', 'touchstart', 'scroll']
    .forEach(ev => addEventListener(ev, resetIdle, { passive: true }));
resetIdle();

// ---------- hak akses ----------
let perm = {};

// Hanya untuk tampilan. Server tetap memeriksa lewat middleware "akses".
const can = (fitur, aksi) => !Object.keys(perm).length || !!perm[fitur]?.[aksi];

async function muatAkses() {
    try {
        list(await request('/api/me/hak-akses'))
            .forEach(r => { (perm[r.nm_fitur] ??= {})[r.aksi] = true; });
    } catch (e) {
        console.error('Gagal memuat hak akses:', e);
    }
}

// ---------- menu sidebar ----------
const MENU = [
    { fitur: 'dashboard',      label: 'Dashboard',        icon: 'bi-speedometer2', href: '/admin/dashboard' },
    { fitur: 'manajemen_user', label: 'Manajemen user',   icon: 'bi-people',       href: '/admin/user' },
    { fitur: 'role_hak_akses', label: 'Role & hak akses', icon: 'bi-shield-lock',  href: '/admin/role' },
    { fitur: 'konfigurasi_sistem', label: 'Konfigurasi sistem', icon: 'bi-gear',              href: '/admin/konfigurasi' },
    { fitur: 'laporan',            label: 'Laporan',            icon: 'bi-file-earmark-text', href: '/admin/laporan' },
    { fitur: 'audit_log',      label: 'Audit log',        icon: 'bi-journal-text', href: '/admin/audit-log' },
];

// dipanggil tiap halaman: boot(async () => { ...isi halaman... })
async function boot(jalankan) {
    const fitur = document.body.dataset.menu;
    const nama  = me?.admin?.nm_admin || me?.identifier || 'Admin';

    $('topUserName').textContent = nama;
    $('dropdownUserName').textContent = nama;
    $('btnLogout').onclick = logout;

    await muatAkses();

    $('menu').innerHTML = MENU.filter(m => can(m.fitur, 'lihat')).map(m => `
        <a class="sidebar-link text-decoration-none d-flex align-items-center px-3 py-2 ${m.fitur === fitur ? 'active' : ''}"
           href="${m.href}">
            <i class="bi ${m.icon} me-2"></i><span>${m.label}</span>
        </a>`).join('');

    if (!can(fitur, 'lihat')) {
        $('konten').innerHTML = '<div class="alert alert-warning">Anda tidak memiliki hak akses ke halaman ini.</div>';
        return;
    }

    try { await jalankan(); }
    catch (e) { $('konten').innerHTML = `<div class="alert alert-danger">${esc(e.message)}</div>`; }
}
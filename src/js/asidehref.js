const beranda = document.getElementById('sidebar-beranda');
const transaksi = document.getElementById('sidebar-transaksi');
const buku = document.getElementById('sidebar-buku');
const petugas = document.getElementById('sidebar-petugas');
const anggota = document.getElementById('sidebar-anggota');
const pengunjung = document.getElementById('sidebar-pengunjung');
const pengaturan = document.getElementById('sidebar-pengaturan');

beranda.addEventListener('click', () => {
    window.location.href = 'dasbor.php';
});

transaksi.addEventListener('click', () => {
    window.location.href = 'transaksi.html';
});

buku.addEventListener('click', () => {
    window.location.href = 'data-buku.html';
});

petugas.addEventListener('click', () => {
    window.location.href = 'data-petugas.html';
});

anggota.addEventListener('click', () => {
    window.location.href = 'data-anggota.html';
});

pengunjung.addEventListener('click', () => {
    window.location.href = 'pengunjung.html';
});

pengaturan.addEventListener('click', () => {
    window.location.href = 'pengaturan.html';
});

const beranda = document.getElementById('sidebar-beranda');
const transaksi = document.getElementById('sidebar-transaksi');
const buku = document.getElementById('sidebar-buku');
const petugas = document.getElementById('sidebar-petugas');
const anggota = document.getElementById('sidebar-anggota');

beranda.addEventListener('click', () => {
    window.location.href = 'dasbor.php';
});

transaksi.addEventListener('click', () => {
    window.location.href = 'transaksi.php';
});

buku.addEventListener('click', () => {
    window.location.href = 'data-buku.php';
});

petugas.addEventListener('click', () => {
    window.location.href = 'data-petugas.php';
});

anggota.addEventListener('click', () => {
    window.location.href = 'data-anggota.php';
});


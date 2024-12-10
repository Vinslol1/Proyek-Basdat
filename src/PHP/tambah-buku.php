<?php 
include 'connect.php';
// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun-terbit'];
    $kota = $_POST['kota-terbit'];
    $kategori = $_POST['genre'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Validasi sederhana
    if (empty($isbn) || empty($judul) || empty($pengarang) || empty($penerbit) || empty($tahun) || empty($kota) || empty($kategori) || empty($harga) || empty($stok)) {
        echo "<script>alert('Harap isi semua bidang!'); window.history.back();</script>";
        exit;
    }

    // Query untuk menambahkan data buku
    $sql = "INSERT INTO buku (isbn, judul, pengarang, penerbit, tahun_terbit, kota_terbit, kategori, harga, stok) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $isbn);
    $stmt->bindParam(2, $judul);
    $stmt->bindParam(3, $pengarang);
    $stmt->bindParam(4, $penerbit);
    $stmt->bindParam(5, $tahun);
    $stmt->bindParam(6, $kota);
    $stmt->bindParam(7, $kategori);
    $stmt->bindParam(8, $harga);
    $stmt->bindParam(9, $stok);
 
    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location.href = 'data-buku.html';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->errorInfo()[2] . "'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Perpus</title>
    <link rel="stylesheet" href="../style/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    #icon-logo {
        font-size: 2.5rem; 
    }
    #icon-profil {
        font-size: 2.5rem; 
    }
    #isi-dasbor .fi {
        font-size: 4rem;
    }    
    .active {
        background-color: #003566;
        border-radius: 0.375rem;
    }
    #akhir-tabel{
        margin-top: 3rem;
    }
</style>

<body class="bg-white flex flex-row font-sand w-screen min-h-screen overflow-x-hidden">
    <section id="sidebar" class="flex flex-col bg-biru_sidebar px-4 py-20 w-1/6">
        <div class="flex flex-row justify-center items-center w-full bg-abu1 p-2 rounded-lg space-x-5 text-lg mb-12 text-biru_text">
            <i id="icon-logo" class="fi fi-ts-book-open-reader"></i>
            <span>SATU PERPUS</span>
        </div>
        <div class="flex flex-col w-full font-sand rounded-lg text-xl text-white space-y-2 px-4">
            <div id="sidebar-beranda" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Beranda</p>
            </div>
            <div id="sidebar-transaksi" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Transaksi</p>
            </div>
            <div id="sidebar-buku" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Buku</p>
            </div>
            <div id="sidebar-petugas" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Petugas</p>
            </div>
            <div id="sidebar-anggota" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
                <p>Data Anggota</p>
            </div>
            <div id="sidebar-pengunjung" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Pengunjung</p>
            </div>
            <div id="sidebar-pengaturan" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Pengaturan</p>
            </div>
        </div>        
    </section>
    <!-- main -->
    <section class="flex flex-col bg-abu2 w-full">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-8 px-12 text-2xl font-semibold">
            <p>Data Anggota</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white ">
            <p class="font-bold text-2xl">Tambah Buku</p>
            <form class="space-y-6 text-xl p-6">
                <div class="flex flex-row gap-8">
                    <label for="isbn-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">ISBN</label>
                    <input type="text" id="isbn-buku" name="isbn-buku" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="judul-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Judul Buku</label>
                    <input type="text" id="judul-buku" name="judul-buku" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="pengarang-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Pengarang</label>
                    <input type="text" id="pengarang-buku" name="pengarang-buku" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="penerbit-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Penerbit</label>
                    <input type="text" id="penerbit-buku" name="penerbit-buku" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="tahun-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Tahun Terbit</label>
                    <input type="number" id="tahun-buku" name="tahun-buku" min="1900" max="2100" step="1" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="kota-terbit" class="block text-gray-700 font-bold md:w-1/6 text-right">Kota Terbit</label>
                    <input type="text" id="kota-terbit" name="kota-terbit" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="genre" class="block text-gray-700 font-bold md:w-1/6 text-right">Kategori</label>
                    <input type="text" id="genre" name="genre" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="harga-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Harga</label>
                    <input type="number" id="harga-buku" name="harga-buku" min="0" step="0.01" class="w-full border border-gray-300 max-w-8xl rounded-md p-2">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="stok-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Jumlah</label>
                    <input type="number" id="stok-buku" name="stok-buku" min="0" step="1" class="w-full border border-gray-300 max-w-8xl rounded-md p-2">
                </div>
            </form>            
            <div class="flex justify-end gap-4 mt-4 font-medium text-white text-xl">
                <button id="tombol-simpan" class="bg-biru_button px-8 py-2 rounded-xl hover:opacity-80">Simpan</button>
            </div>
        </div>
    </section>

    <script src="../js/asidehref.js"> </script>    
    <script>
        const tombolSimpan = document.getElementById('tombol-simpan');

        tombolSimpan.addEventListener('click', () => {
            const isbn = document.getElementById('isbn-buku').value;
            const judul = document.getElementById('judul-buku').value;
            const pengarang = document.getElementById('pengarang-buku').value;
            const penerbit = document.getElementById('penerbit-buku').value;
            const tahun = document.getElementById('tahun-buku').value;
            const kota = document.getElementById('kota-terbit').value;
            const genre = document.getElementById('genre').value;
            const harga = document.getElementById('harga-buku').value;
            const stok = document.getElementById('stok-buku').value;

            if (!isbn || !judul || !pengarang || !penerbit || !tahun || !kota || !genre || !harga || !stok) {
                alert('Harap isi semua bidang!');
                return;
            }

            const data = {
                isbn,
                judul,
                pengarang,
                penerbit,
                tahun,
                kota,
                genre,
                harga,
                stok
            };

            fetch('tambah-buku.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat menambahkan buku.');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    alert('Buku berhasil ditambahkan!');
                    window.location.href = 'data-buku.html';
                } else {
                    alert(`Gagal: ${result.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data.');
            });
        });
    </script>  
</body>
</html>

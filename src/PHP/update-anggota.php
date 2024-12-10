<?php
include 'connect.php';

// Pastikan ID anggota yang akan diupdate tersedia
if (!isset($_GET['id'])) {
    die("ID anggota tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data anggota berdasarkan ID
$query = "SELECT * FROM anggota WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data anggota tidak ditemukan.");
}

// Proses update data jika form di-submit
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];

    $updateQuery = "UPDATE anggota SET nama = :nama, telepon = :telepon WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute(['nama' => $nama, 'telepon' => $telepon, 'id' => $id]);

    header("Location: data-anggota.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Anggota</title>
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

<body class="bg-white flex flex-row font-sand w-screen min-h-screen">
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
        </div>        
    </section>

<!-- Main Section -->
    <section class="flex flex-col bg-abu2 w-full">
    <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div  class="flex my-8 px-12 text-3xl font-semibold">
            <p>Update Data Anggota</p>
        </div>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <form method="POST" class="flex flex-col space-y-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
                <div>
                    <label for="nama" class="block text-xl font-medium text-gray-700">Nama:</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="border border-solid border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="telepon" class="block text-xl font-medium text-gray-700">Telepon:</label>
                    <input type="text" id="telepon" name="telepon" value="<?= htmlspecialchars($data['telepon']); ?>" class="border border-solid border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="text-white font-medium space-x-3 flex items-end justify-end">
                    <button id="tombol-kembali" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">sebelumnya</button>
                    <button type="submit" name="update" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">Update</button>
                </div>
                
            </form>
        </div>
    </section>

    <script>
        const beranda = document.getElementById('sidebar-beranda');
        const transaksi = document.getElementById('sidebar-transaksi');
        const buku = document.getElementById('sidebar-buku');
        const petugas = document.getElementById('sidebar-petugas');
        const anggota = document.getElementById('sidebar-anggota');
        const tambahAnggota = document.getElementById('tambah-anggota');
        
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
            window.location.href = 'data-anggota.php';
        });

        tambahAnggota.addEventListener('click', () => {
            window.location.href = 'tambah-anggota.php';
        });
        
        const tombolKembali = document.getElementById('tombol-kembali');
        tombolKembali.addEventListener('click', () => {
            window.history.back();
        });
    </script>
</body>
</html>

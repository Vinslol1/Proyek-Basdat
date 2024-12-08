<?php
include 'connect.php';

$limit = 10; // menampilkan 10 data(maximal di selectnya)
if (isset($_POST['limit'])) {
    $limit = $_POST['limit'];
}
$sql = "SELECT * FROM anggota";
$stmt = $conn->prepare($sql);
$stmt->execute();

// nyimpen hasil query dalam array
$anggota = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalSql = "SELECT COUNT(*) as total FROM anggota";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->execute();
$totalData = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
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
        <button id="tambah-anggota" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
            <i class="fi fi-tr-add flex justify-center"></i>
            <p>Tambah Anggota</p>
        </button>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Anggota Perpustakaan</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
                <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                    <span class="text-xl">Menampilkan</span>
                    <select class="border border-solid border-black  px-2 py-2 rounded-md focus:outline-none">
                        <option value="1">1</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                    <span class="text-xl">Data</span>
                </div>
                <div class="flex flex-row justify-centerbitems-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl">
                    <input type="text" class="bg-transparent border-none focus:outline-none" placeholder="cari">
                    <i class="fi fi-rr-search"></i>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                <thead class="bg-white border border-collapse border-abu_border">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2">
                            <div class="flex justify-between items-center">
                                <span>#</span>
                                <i class="fi fi-tr-sort-amount-down-alt cursor-pointer"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>ID</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="nama-anggota">Nama Anggota</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="telepon">Telepon</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="denda">Denda</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Aksi</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                    </tr>
                </thead>                  
                    <tbody class="bg-abu1 border border-collapse border-abu1 overflow-y-scroll text-lg">
                    <?php foreach ($anggota as $index => $data) : ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center border border-right border-abu_border"><?= $index + 1; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['id']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['nama']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['telepon']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border">0</td>
                            <td class="px-4 py-2 space-x-5 border border-right border-abu_border">
                                <i class="fi fi-tr-overview cursor-pointer"></i>
                                <i class="fi fi-tr-floppy-disk-pen cursor-pointer" onclick="window.location.href='update.php?id=<?= $data['id']; ?>'"></i>
                                <i id="hapus-data" class="fi fi-tr-trash-xmark cursor-pointer"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="akhir-tabel" class="flex flex-row justify-between items-center text-lg">
                <div>
                    <p class="text-black">Menampilkan <?= $limit ?> dari <?= $totalData ?> data anggota</p>
                </div>
                <div class="text-white font-medium space-x-3">
                    <button id="tombol-kembali "class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">sebelumnya</button>
                    <button id="tombol-selanjutnya" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">Selanjutnya</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        const beranda = document.getElementById('sidebar-beranda');
        const transaksi = document.getElementById('sidebar-transaksi');
        const buku = document.getElementById('sidebar-buku');
        const petugas = document.getElementById('sidebar-petugas');
        const anggota = document.getElementById('sidebar-anggota');
        const pengunjung = document.getElementById('sidebar-pengunjung');
        const pengaturan = document.getElementById('sidebar-pengaturan');
        const tambahAnggota = document.getElementById('tambah-anggota');
        
        beranda.addEventListener('click', () => {
            window.location.href = 'dasbor.html';
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

        tambahAnggota.addEventListener('click', () => {
            window.location.href = 'tambah-anggota.html';
        });
    </script>    
</body>
</html>

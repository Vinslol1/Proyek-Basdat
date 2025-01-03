<?php 
    include 'connect.php';

    try {
        // Query untuk menghitung total anggota
        $queryAnggota = "SELECT COUNT(*) AS total FROM anggota";
        $stmtAnggota = $conn->prepare($queryAnggota);
        $stmtAnggota->execute();
        $resultAnggota = $stmtAnggota->fetch(PDO::FETCH_ASSOC);
        $totalAnggota = $resultAnggota['total'];

        // Query untuk menghitung total buku berdasarkan stok
        $queryBuku = "SELECT SUM(stok) AS total FROM buku";
        $stmtBuku = $conn->prepare($queryBuku);
        $stmtBuku->execute();
        $resultBuku = $stmtBuku->fetch(PDO::FETCH_ASSOC);
        $totalBuku = $resultBuku['total'] ?? 0; // Berikan nilai 0 jika hasil null

        // Query untuk menghitung total data peminjaman
        $queryPeminjaman = "SELECT COUNT(*) AS total FROM peminjaman";
        $stmtPeminjaman = $conn->prepare($queryPeminjaman);
        $stmtPeminjaman->execute();
        $resultPeminjaman = $stmtPeminjaman->fetch(PDO::FETCH_ASSOC);
        $totalPeminjaman = $resultPeminjaman['total'];

        // Query untuk menghitung total data pengembalian
        $queryPengembalian = "SELECT COUNT(*) AS total FROM pengembalian";
        $stmtPengembalian = $conn->prepare($queryPengembalian);
        $stmtPengembalian->execute();
        $resultPengembalian = $stmtPengembalian->fetch(PDO::FETCH_ASSOC);
        $totalPengembalian = $resultPengembalian['total'];

        // Query untuk menghitung jumlah denda > 0
        $queryDenda = "SELECT SUM(denda) AS total FROM pengembalian WHERE denda > 0";
        $stmtDenda = $conn->prepare($queryDenda);
        $stmtDenda->execute();
        $resultDenda = $stmtDenda->fetch(PDO::FETCH_ASSOC);
        $totalDenda = $resultDenda['total'] ?? 0; // Berikan nilai 0 jika hasil null

        // Hitung jumlah buku tersedia (total buku - total peminjaman)
        $bukuTersedia = $totalBuku - $totalPeminjaman;
    } 
    catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Satu Perpus</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="../style/style2.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
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
    <section id="sidebar" class="fixed top-0 left-0 h-screen w-1/6 bg-biru_sidebar flex flex-col px-4 py-20 z-50">
        <div class="flex flex-row justify-center items-center w-full bg-abu1 p-2 rounded-lg space-x-5 text-lg mb-12 text-biru_text">
            <i id="icon-logo" class="fi fi-ts-book-open-reader"></i>
            <span>SATU PERPUS</span>
        </div>
        <div class="flex flex-col w-full font-sand rounded-lg text-xl text-white space-y-2 px-4">
            <div id="sidebar-beranda" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
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
            <div id="sidebar-anggota" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Anggota</p>
            </div>
        </div>        
    </section>

    <section class="flex flex-col bg-abu2 w-5/6 ml-[16.67%] min-h-screen top-0 overflow-x-hidden">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-8 px-12 text-3xl font-semibold">
            <p>Beranda</p>
        </div>
        <div id="isi-dasbor" class="grid grid-cols-3 gap-8 px-8 justify-center">
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
                <i class="fi fi-tr-users-alt"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Anggota</p>
                    <p id="total-anggota" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalAnggota); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
            <i class="fi fi-ts-book-arrow-up"></i>
            <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Peminjaman</p>
                    <p id="total-peminjaman" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalPeminjaman); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
            <i class="fi fi-tr-restock"></i>
            <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Pengembalian</p>
                    <p id="total-pengembalian" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalPengembalian); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
                <i class="fi fi-tr-books"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Total Buku</p>
                    <p id="total-buku" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalBuku); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
                <i class="fi fi-tr-book-open-cover"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Buku Tersedia</p>
                    <p id="total-tersedia" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($bukuTersedia); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 w-2/3 space-x-10">
                <i class="fi fi-tr-money-check-edit"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-xl">Denda</p>
                    <p id="total-denda" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalDenda); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/asidehref.js"></script>
</body>
</html>

<?php 
    include 'connect.php';

    $totalAnggota = 0;
    try {
        // untuk ngitung total anggota
        $query = "SELECT COUNT(*) AS total FROM anggota";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // di simpan ke variabel
        $totalAnggota = $result['total'];
    } 
    catch (PDOException $e){
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
    <section id="sidebar" class="flex flex-col bg-biru_sidebar px-4 py-20 w-1/6">
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
            <div id="sidebar-anggota" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer ">
                <p>Data Anggota</p>
            </div>
        </div>        
    </section>

    <section class="flex flex-col bg-abu2 w-full">
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
                    <p class="flex justify-center text-2xl">Anggota</p>
                    <p id="total-anggota" class="flex justify-center text-2xl font-semibold">
                        <?= htmlspecialchars($totalAnggota); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 space-x-10 w-2/3 ">
                <i class="fi fi-ts-book-arrow-up"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-2xl">Peminjaman</p>
                    <p class="flex text-2xl font-semibold justify-center">1</p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 space-x-10 w-2/3">
                <i class="fi fi-tr-restock"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-2xl">Pengembalian</p>
                    <p class="flex justify-center text-2xl font-semibold">1</p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 space-x-10 w-2/3 ">
                <i class="fi fi-tr-books"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-2xl">Total Buku</p>
                    <p class="flex justify-center text-2xl font-semibold">1</p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 space-x-10 w-2/3 ">
                <i class="fi fi-tr-book-open-cover"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-2xl">Buku Tersedia</p>
                    <p class="flex justify-center text-2xl font-semibold">1</p>
                </div>
            </div>
            <div class="flex flex-row items-center justify-center bg-biru_sidebar text-white rounded-2xl p-6 space-x-10 w-2/3 ">
                <i class="fi fi-tr-money-check-edit"></i>
                <div class="flex flex-col w-1/2">
                    <p class="flex justify-center text-2xl">Denda</p>
                    <p class="flex justify-center text-2xl font-semibold">1</p>
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
            window.location.href = 'petugas.html';
        });

        anggota.addEventListener('click', () => {
            window.location.href = 'data-anggota.html';
        });
    </script>    
</body>
</html>

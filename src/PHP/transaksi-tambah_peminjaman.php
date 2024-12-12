<?php
include 'connect.php';

// Fungsi untuk menambah peminjaman
if (isset($_POST['tambah_peminjaman'])) {
    $id_anggota = $_POST['id_anggota'];
    $id_petugas = $_POST['id_petugas'];
    $isbn = $_POST['isbn'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+14 days'));  // 2 minggu setelah tanggal pinjam

    $sql = "INSERT INTO peminjaman (id_anggota, id_petugas, isbn, tanggal_pinjam, tanggal_kembali)
            VALUES (:id_anggota, :id_petugas, :isbn, :tanggal_pinjam, :tanggal_kembali)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id_anggota', $id_anggota);
    $stmt->bindParam(':id_petugas', $id_petugas);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':tanggal_pinjam', $tanggal_pinjam);
    $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);

    if ($stmt->execute()) {
        header('Location: transaksi-tambah_peminjaman2.php');
        exit();
    } else {
        echo "<script>document.getElementById('error').classList.remove('hidden');</script>";
    }
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
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
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
</head>
<body class="bg-white flex flex-row h-screen font-sand w-screen">
    <section id="sidebar" class="fixed top-0 left-0 h-screen w-1/6 bg-biru_sidebar flex flex-col px-4 py-20 z-50">
        <div class="flex flex-row justify-center items-center w-full bg-abu1 p-2 rounded-lg space-x-5 text-lg mb-12 text-biru_text">
            <i id="icon-logo" class="fi fi-ts-book-open-reader"></i>
            <span>SATU PERPUS</span>
        </div>
        <div class="flex flex-col w-full font-sand rounded-lg text-2xl text-white space-y-4 px-4">
            <div id="sidebar-beranda" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Beranda</p>
            </div>
            <div id="sidebar-transaksi" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
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
            <div id="sidebar-pengunjung" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Pengunjung</p>
            </div>
            <div id="sidebar-pengaturan" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Pengaturan</p>
            </div>
        </div>        
    </section>
    <section class="bg-white flex flex-row h-screen font-sand w-screen">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-8 px-12 text-3xl font-semibold">
            <p>Transaksi</p>
        </div>
        <div id="error" class="flex-col mx-12 p-4 rounded-lg shadow-md bg-red-600 mb-4 hidden">
            <p class="text-2xl font-bold text-white">Terjadi kesalahan. Silakan coba lagi.</p>
        </div>
        <div class="flex flex-col mx-12 p-4 rounded-lg shadow-md bg-white">
            <p class="text-2xl font-bold">Tambah Peminjaman</p>
            <div class="p-4 m-5 justify-center items-center flex flex-col">
            <form action="" method="POST">
                <div class="grid grid-cols-2 m-2 items-center gap-4">
                    <p class="text-right min-w-32">ISBN</p>
                        <div class="flex items-center">
                            <div class="relative flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <img src="../../img/icon_nobuku.svg" alt="Ikon Nomor Buku" class="border-r-2 w-10 h-10 px-2">
                                <input input type="text" name="isbn" class="flex-grow w-64 px-3 py-2 outline-none" required>
                            </div>
                        </div>
                </div>
                <div class="grid grid-cols-2 m-2 items-center gap-4">
                    <p class="text-right min-w-32">Nomor Anggota</p>
                        <div class="flex items-center">
                            <div class="relative flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <img src="../../img/icon_noanggota.svg" alt="Ikon Nomor Anggota" class="border-r-2 w-10 h-10 px-2">
                                <input input type="text" name="id_anggota" class="flex-grow w-64 px-3 py-2 outline-none" required>
                            </div>
                        </div>
                </div>  
                <div class="grid grid-cols-2 m-2 items-center gap-4">
                    <p class="text-right min-w-32">Nomor Petugas</p>
                        <div class="flex items-center">
                            <div class="relative flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <img src="../../img/icon_noanggota.svg" alt="Ikon Nomor Anggota" class="border-r-2 w-10 h-10 px-2">
                                <input input type="text" name="id_petugas" class="flex-grow w-64 px-3 py-2 outline-none" required>
                            </div>
                        </div>
                </div>      
            </div>
            <div class="flex flex-row-reverse p-1">
                <button type="submit" name="tambah_peminjaman" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-5 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
                    <p>Selesai</p>
                </button>
                <button id="kembali-transaksi" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-5 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
                    <p>Kembali</p>
                </button>
            </div>
            </form>
        </div>
    </section>
    <script src="../js/asidehref.js"></script>
    <script>
        const kembali = document.getElementById('kembali-transaksi');
        kembali.addEventListener('click', () => {
            window.location.href = 'transaksi.php';    
        });
    </script>

</body>
</html>
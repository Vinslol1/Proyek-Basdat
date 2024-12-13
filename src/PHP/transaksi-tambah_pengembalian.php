<?php
include 'connect.php';

if (isset($_POST['tambah_pengembalian'])) {
    $id = $_POST['id']; // ID Pengembalian
    $kondisi = $_POST['kondisi'];
    $tanggal_kembali = date('Y-m-d');
    $sql = "SELECT id_petugas, id_anggota, isbn, tanggal_kembali AS tanggal_batas, tanggal_pinjam 
            FROM peminjaman 
            WHERE id = :id LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $id_petugas = $row['id_petugas'];
        $id_anggota = $row['id_anggota'];
        $tanggal_pinjam = $row['tanggal_pinjam'];
        $isbn = $row['isbn'];
        $tanggal_batas = $row['tanggal_batas'];

        // Hitung denda
        $denda = 0;
        if ($tanggal_batas < $tanggal_kembali) {
            $denda = (strtotime($tanggal_kembali) - strtotime($tanggal_batas)) / (60 * 60 * 24) * 5000;  // Denda per hari
        }

        $sql_pengembalian = "INSERT INTO pengembalian (id_anggota, id_petugas, isbn, tanggal_kembali, kondisi, denda, tanggal_pinjam)
                             VALUES (:id_anggota, :id_petugas, :isbn, :tanggal_kembali, :kondisi, :denda, :tanggal_pinjam)";

        $stmt_pengembalian = $conn->prepare($sql_pengembalian);
        $stmt_pengembalian->bindParam(':id_anggota', $id_anggota);
        $stmt_pengembalian->bindParam(':id_petugas', $id_petugas);
        $stmt_pengembalian->bindParam(':isbn', $isbn);
        $stmt_pengembalian->bindParam(':tanggal_kembali', $tanggal_kembali);
        $stmt_pengembalian->bindParam(':kondisi', $kondisi);
        $stmt_pengembalian->bindParam(':denda', $denda);
        $stmt_pengembalian->bindParam(':tanggal_pinjam', $tanggal_pinjam);


        if ($stmt_pengembalian->execute()) {
            $sql_delete = "DELETE FROM peminjaman WHERE id = :id";

            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_delete->execute();

            $sql_update_stok = "UPDATE buku SET stok = stok + 1 WHERE isbn = :isbn";
            $stmt_update_stok = $conn->prepare($sql_update_stok);
            $stmt_update_stok->bindParam(':isbn', $isbn);
            $stmt_update_stok->execute();
            
            header('Location: transaksi-tambah_pengembalian2.php');
            exit();
        } else {
            echo "<script>document.getElementById('error').classList.remove('hidden');</script>";
        }
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
        <div class="flex flex-row justify-center items-center w-full bg-abu1 px-4 py-2 rounded-lg space-x-5 text-2xl mb-12 text-biru_text">
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
    <section class="flex flex-col bg-abu2 w-5/6 ml-[16.67%] min-h-screen top-0 overflow-x-hidden">
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
                    <p class="text-right min-w-32">Nomor Peminjaman</p>
                        <div class="flex items-center">
                            <div class="relative flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <img src="../../img/icon_noanggota.svg" alt="Ikon Nomor Anggota" class="border-r-2 w-10 h-10 px-2">
                                <input input type="text" name="id" id="id" class="flex-grow w-64 px-3 py-2 outline-none" required>
                            </div>
                        </div>
                </div>      

                <div class="grid grid-cols-2 m-2 items-center gap-4">
                    <p class="text-right min-w-32">Kondisi Buku</p>
                        <div class="flex items-center">
                            <div class="relative flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <img src="../../img/icon_nobuku.svg" alt="Ikon Nomor Buku" class="border-r-2 w-10 h-10 px-2">
                                <input input type="text" name="kondisi" id="kondisi" class="flex-grow w-64 px-3 py-2 outline-none" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="flex flex-row-reverse p-1">
                <button type="submit" name="tambah_pengembalian" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-5 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
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
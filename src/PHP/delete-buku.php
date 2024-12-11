<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    try {
        // Validasi input untuk memastikan ISBN ada
        if (empty($isbn)) {
            die("ISBN harus diisi!");
        }

        // Query untuk menghapus data buku berdasarkan ISBN
        $sql = "DELETE FROM buku WHERE isbn = :isbn";
        $stmt = $conn->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':isbn', $isbn);

        // Eksekusi query
        $stmt->execute();

        // Memberikan notifikasi sukses dan redirect
        echo "<script>alert('Data buku berhasil dihapus!'); window.location.href='data-buku.php';</script>";
    } 
    catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Perpus - Hapus Buku</title>
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
</style>

<body class="bg-white flex flex-row font-sand w-screen overflow-x-hidden overflow-y-auto">
<section id="sidebar" class="fixed top-0 left-0 h-screen w-1/6 bg-biru_sidebar flex flex-col px-4 py-20 z-50">
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
            <div id="sidebar-anggota" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Anggota</p>
            </div>
        </div>        
    </section>
    <section class="flex flex-col bg-abu2 w-5/6 ml-[16.67%] min-h-screen top-0">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-4 px-12 text-2xl font-semibold">
            <p>Hapus Buku</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white ">
            <p class="font-bold text-2xl">Konfirmasi Hapus Buku</p>
            <form class="space-y-6 text-xl p-6" method="GET" action="delete-buku.php">
                <div class="flex flex-row gap-8">
                    <label for="isbn-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">ISBN</label>
                    <input type="text" id="isbn-buku" name="isbn" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex justify-end gap-4 mt-4 font-medium text-white text-xl">
                    <button type="submit" id="tombol-hapus" class="bg-red-800 px-8 py-2 rounded-xl hover:opacity-80">Hapus</button>
                </div>
            </form>            
        </div>
    </section>

    <script src="../js/asidehref.js"> </script>    
    <script>
        document.getElementById("tombol-hapus").addEventListener("click", function (event) {
        const confirmDelete = confirm("Apakah Anda yakin ingin menghapus buku ini?");
        if (!confirmDelete) {
            event.preventDefault(); 
        }
        });
    </script>  
</body>
</html>

<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $kontak = $_POST["kontak"];
    $email = $_POST["email"];
    $is_admin = isset($_POST["is_admin"]) ? 1 : 0;

    try {
        // Validasi input untuk memastikan tidak ada field yang kosong
        if (empty($nama) || empty($kontak) || empty($email)) {
            die("Semua field harus diisi!");
        }

        // Query untuk memasukkan data petugas
        $sql = "INSERT INTO petugas (nama, kontak, email, is_admin) VALUES (:nama, :kontak, :email, :is_admin)";
        $stmt = $conn->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kontak', $kontak);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':is_admin', $is_admin);

        // Eksekusi query
        $stmt->execute();

        // Memberikan notifikasi sukses dan redirect
        echo "<script>alert('Data petugas berhasil disimpan!'); window.location.href='data-petugas.php';</script>";
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas</title>
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
    .active {
        background-color: #003566;
        border-radius: 0.375rem;
    }
</style>
<body class="bg-white flex flex-row font-sand w-screen overflow-x-hidden overflow-y-auto">
    <section id="sidebar" class="fixed top-0 left-0 h-screen w-1/6 bg-biru_sidebar flex flex-col px-4 py-20">
        <div class="flex flex-row justify-center items-center w-full bg-abu1 p-2 rounded-lg space-x-5 text-lg mb-12 text-biru_text">
            <i id="icon-logo" class="fi fi-ts-book-open-reader"></i>
            <span>SATU PERPUS</span>
        </div>
        <div class="flex flex-col w-full rounded-lg text-xl text-white space-y-2 px-4">
            <div class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Beranda</p>
            </div>
            <div class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Buku</p>
            </div>
            <div class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
                <p>Data Petugas</p>
            </div>
            <div class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
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
            <p>Data Petugas</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Tambah Petugas</p>
            <form class="space-y-6 text-xl p-6" method="POST" action="tambah-petugas.php">
                <div class="flex flex-row gap-8">
                    <label for="nama-petugas" class="block text-gray-700 font-bold md:w-1/6 text-right">Nama</label>
                    <input type="text" id="nama-petugas" name="nama" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="kontak-petugas" class="block text-gray-700 font-bold md:w-1/6 text-right">Telepon</label>
                    <input type="text" id="kontak-petugas" name="kontak" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="email-petugas" class="block text-gray-700 font-bold md:w-1/6 text-right">Email</label>
                    <input type="email" id="email-petugas" name="email" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8 items-center">
                    <label for="is-admin" class="block text-gray-700 font-bold md:w-1/6 text-right">Admin</label>
                    <input type="checkbox" id="is-admin" name="is_admin" class="h-5 w-5 border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end gap-4 mt-4 font-medium text-white text-xl">
                    <button type="submit" id="tombol-simpan" class="bg-biru_button px-8 py-2 rounded-xl hover:opacity-80">Simpan</button>
                </div>
            </form>
        </div>
    </section>
    <script src="../js/asidehref.js"> </script>    
    <script>
        document.getElementById("tombol-simpan").addEventListener("click", function (event) {
        const confirmSave = confirm("Apakah Anda yakin ingin menyimpan data?");
        if (!confirmSave) {
            event.preventDefault(); // membatalkan submit form kalo pengguna memilih batal
        }
        });
    </script>  
</body>
</html>

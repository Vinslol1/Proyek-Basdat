<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama-anggota"];
    $tempat_lahir = $_POST["tempat-lahir"];
    $tanggal_lahir = $_POST["tanggal-lahir"];
    $jenis_kelamin = $_POST["jenis-kelamin"];
    $telepon = $_POST["telepon"];
    $nik = $_POST["nik"];
    $pekerjaan = $_POST["pekerjaan"];
    $alamat = $_POST["alamat"];
    $member = true; 

    try {
        // buat masukin datanya ke tabel
        $sql = "INSERT INTO anggota (nama, tempat_lahir, tanggal_lahir, jenis_kelamin, telepon, nik, alamat, member) 
                VALUES (:nama, :tempat_lahir, :tanggal_lahir, :jenis_kelamin, :telepon, :nik, :alamat, :member)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':tempat_lahir', $tempat_lahir);
        $stmt->bindParam(':tanggal_lahir', $tanggal_lahir);
        $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
        $stmt->bindParam(':telepon', $telepon);
        $stmt->bindParam(':nik', $nik);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':member', $member, PDO::PARAM_BOOL);

        if (empty($nama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($jenis_kelamin) || empty($telepon) || empty($nik) || empty($pekerjaan) || empty($alamat)) {
            die("Semua field harus diisi!");
        }
        
        $stmt->execute();
        echo "<script>alert('Data anggota berhasil disimpan!'); window.location.href='data_anggota.php';</script>";

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
    <title>Satu Perpus</title>
    <link rel="stylesheet" href="../style/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
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
    <!-- main -->
    <section class="flex flex-col bg-abu2 w-full">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-8 px-12 text-3xl font-semibold">
            <p>Tambah Anggota</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white ">
            <form class="space-y-6 text-xl p-6" method="POST">
                <div class="flex flex-row gap-8">
                    <label for="nama-anggota" class="block text-gray-700 font-bold md:w-1/6 text-right">Nama Anggota</label>
                    <input type="text" id="nama-anggota" name="nama-anggota" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="tempat-lahir" class="block text-gray-700 font-bold md:w-1/6 text-right">Tempat Lahir</label>
                    <input type="text" id="tempat-lahir" name="tempat-lahir" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="tanggal-lahir" class="block text-gray-700 font-bold md:w-1/6 text-right">Tanggal Lahir</label>
                    <input type="date" id="tanggal-lahir" name="tanggal-lahir" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="jenis-kelamin" class="block text-gray-700 font-bold md:w-1/6 text-right">Jenis Kelamin</label>
                    <select id="jenis-kelamin" name="jenis-kelamin" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="flex flex-row gap-8">
                    <label for="telepon" class="block text-gray-700 font-bold md:w-1/6 text-right">Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="nik" class="block text-gray-700 font-bold md:w-1/6 text-right">NIK</label>
                    <input type="text" id="nik" name="nik" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="pekerjaan" class="block text-gray-700 font-bold md:w-1/6 text-right">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="w-full border border-gray-300 max-w-8xl rounded-md p-2 ">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="alamat" class="block text-gray-700 font-bold md:w-1/6 text-right">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="4" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl max-h-20"></textarea>
                </div>
                <div class="flex justify-end gap-4 mt-4 font-medium text-white text-xl">
                    <button type="submit" id="tombol-selanjutnya" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">Simpan</button>
                </div>
            </form>
                
        </div>
    </section>
    <script src="../js/asidehref.js"></script>
    <script>
        document.getElementById("tombol-selanjutnya").addEventListener("click", function (event) {
        const confirmSave = confirm("Apakah Anda yakin ingin menyimpan data?");
        if (!confirmSave) {
            event.preventDefault(); // membatalkan submit form kalo pengguna memilih batal
        }
        });
    </script>  
</body>
</html>

<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST["isbn"];
    $judul = $_POST["judul"];
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $tahun_terbit = $_POST["tahun_terbit"];
    $kota_terbit = $_POST["kota_terbit"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    try {
        // Validasi input untuk memastikan tidak ada field yang kosong
        if (empty($isbn)|| empty($judul) || empty($pengarang) || empty($penerbit) || empty($tahun_terbit) || empty($kota_terbit) || empty($kategori) || empty($harga) || empty($stok)) {
            die("Semua field harus diisi!");
        }

        // Query untuk memasukkan data buku
        $sql = "INSERT INTO buku (isbn, judul, pengarang, penerbit, tahun_terbit, kota_terbit, kategori, harga, stok) 
                VALUES (:isbn, :judul, :pengarang, :penerbit, :tahun_terbit, :kota_terbit, :kategori, :harga, :stok)";
        $stmt = $conn->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':pengarang', $pengarang);
        $stmt->bindParam(':penerbit', $penerbit);
        $stmt->bindParam(':tahun_terbit', $tahun_terbit);
        $stmt->bindParam(':kota_terbit', $kota_terbit);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);

        // Eksekusi query
        $stmt->execute();

        // Memberikan notifikasi sukses dan redirect
        echo "<script>alert('Data buku berhasil disimpan!'); window.location.href='data-buku.php';</script>";
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
            <div id="sidebar-buku" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
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
            <p>Data Buku</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Tambah Buku</p>
            <form class="space-y-6 text-xl p-6" method="POST" action="tambah-buku.php">
                <div class="flex flex-row gap-8">
                    <label for="isbn-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">ISBN</label>
                    <input type="text" id="isbn-buku" name="isbn" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="judul-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Judul Buku</label>
                    <input type="text" id="judul-buku" name="judul" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="pengarang-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Pengarang</label>
                    <input type="text" id="pengarang-buku" name="pengarang" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="penerbit-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Penerbit</label>
                    <input type="text" id="penerbit-buku" name="penerbit" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="tahun-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Tahun Terbit</label>
                    <input type="number" id="tahun-buku" name="tahun_terbit" min="1900" max="2100" step="1" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="kota-terbit" class="block text-gray-700 font-bold md:w-1/6 text-right">Kota Terbit</label>
                    <input type="text" id="kota-terbit" name="kota_terbit" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="kategori" class="block text-gray-700 font-bold md:w-1/6 text-right">Kategori</label>
                    <input type="text" id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md p-2 max-w-8xl">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="harga-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Harga</label>
                    <input type="number" id="harga-buku" name="harga" min="0" step="0.01" class="w-full border border-gray-300 max-w-8xl rounded-md p-2">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="stok-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Jumlah</label>
                    <input type="number" id="stok-buku" name="stok" min="0" step="1" class="w-full border border-gray-300 max-w-8xl rounded-md p-2">
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

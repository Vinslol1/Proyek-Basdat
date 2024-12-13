<?php
include 'connect.php';

try {
    $sql = "
        SELECT 
            b.judul, p.id AS id_pengembalian, b.isbn,
            a.id AS id_anggota, a.nama AS nama_anggota, a.alamat,
            g.id AS id_petugas, g.nama AS nama_petugas,
            p.denda, p.tanggal_pinjam, p.tanggal_kembali,
            TO_CHAR(p.tanggal_pinjam + INTERVAL '14 days', 'YYYY-MM-DD') AS tanggal_batas
        FROM pengembalian p
        JOIN anggota a ON p.id_anggota = a.id
        JOIN buku b ON p.isbn = b.isbn
        JOIN petugas g ON p.id_petugas = g.id
        ORDER BY p.id DESC
        LIMIT 1"; // Ambil data pengembalian terbaru

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
<body class="bg-white flex flex-row font-sand">
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
            <p>Tambah Peminjaman</p>
        </div>
        <div class="flex flex-col mx-12 p-4 rounded-lg shadow-md bg-green-500 mb-4">
            <p class="text-2xl font-bold text-white">Sistem:</p>
            <p class="text-2xl text-white">Data ditemukan.</p>
        </div>

        <div class="flex flex-col mx-12 p-4 rounded-lg shadow-md bg-white">
            <div>
                <div class="flex border-b-2 p-2 gap-5">
                    <img src="../../img/Group.svg" alt="Informasi Pustaka">
                    <h2 class="text-2xl font-bold">Informasi Peminjaman</h2>
                </div>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <table class="border-collapse mt-2 w-full">
                    <tr>
                      <td class="bg-abu1 font-bold w-1/2">Nomor Pengembalian</td>
                      <td class="bg-abu1"><?= $row['id_pengembalian'] ?></td>
                    </tr>
                    <tr>
                      <td class="font-bold w-1/2">ISBN</td>
                      <td><?= $row['isbn'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-abu1 font-bold w-1/2">Judul</td>
                      <td class="bg-abu1"><?= $row['judul'] ?></td>
                    </tr>
                    <tr>
                      <td class="font-bold w-1/2">Nomor Anggota</td>
                      <td><?= $row['id_anggota'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-abu1 font-bold w-1/2">Nama</td>
                      <td class="bg-abu1"><?= $row['nama_anggota'] ?></td>
                    </tr>
                    <tr>
                      <td class="font-bold w-1/2">Tanggal Pinjam</td>
                      <td><?= $row['tanggal_pinjam'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-abu1 font-bold w-1/2">Batas Pengembalian</td>
                      <td class="bg-abu1"><?= $row['tanggal_batas'] ?></td>
                    </tr>
                  </table>
        </div>
        <div>
                <div class="flex justify-between border-b-2 p-2 mt-2">
                  <div class="flex gap-5">
                    <img src="../../img/Group.svg" alt="Informasi Pustaka">
                    <h2 class="text-2xl font-bold">Informasi Pengembalian</h2>
                  </div>
                </div>
                <table class="border-collapse mt-2 w-full">
                    <tr>
                      <td class=" bg-abu1 font-bold w-1/2">Nama</td>
                      <td class="bg-abu1"><?= $row['nama_petugas'] ?></td>
                    </tr>
                    <tr>
                      <td class="font-bold w-1/2">Nomor Petugas</td>
                      <td><?= $row['id_petugas'] ?></td>
                    </tr>
                    <tr>
                      <td class="bg-abu1 font-bold w-1/2">Tanggal Kembali</td>
                      <td class="bg-abu1"><?= $row['tanggal_kembali'] ?></td>
                    </tr>
                    <tr>
                      <td class="font-bold w-1/2">Denda</td>
                      <td><?= $row['denda'] ?></td>
                    </tr>
                    <?php } ?>
                  </table>
        </div>
            <div class="flex flex-row-reverse p-1">
                <button id="selesai-transaksi" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-5 text-2xl font-medium rounded-xl space-x-4 text-white p-2 w-1/6">
                    <p>Data Sudah Benar</p>
                </button>
                <button id="kembali-transaksi" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-5 text-2xl font-medium rounded-xl space-x-4 text-white p-2 w-1/6">
                    <p>Kembali</p>
                </button>
            </div>

        </div>
    </section>
    <script src="../js/asidehref.js"></script>
    <script>
        const kembali = document.getElementById('kembali-transaksi');
        const selesai = document.getElementById('selesai-transaksi');
        kembali.addEventListener('click', () => {
            window.location.href = 'transaksi-tambah_pengembalian.php';    
        });
        selesai.addEventListener('click', () => {
            window.location.href = 'transaksi.php';    
        });

    </script>

</body>
</html>
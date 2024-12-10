<?php
// Include koneksi database
include 'connect.php';

// Logika sorting
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'isbn';
$orderDir = isset($_GET['orderDir']) && $_GET['orderDir'] === 'desc' ? 'DESC' : 'ASC';

// Logika pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk menampilkan data dengan pencarian dan sorting
$sql = "SELECT * FROM buku WHERE judul LIKE :search ORDER BY $orderBy $orderDir";
$stmt = $conn->prepare($sql);
$searchParam = "%$search%";
$stmt->bindValue(':search', $searchParam);
$stmt->execute();
$result = $stmt->fetchAll();

// Query untuk jumlah data
$countSql = "SELECT COUNT(*) AS total FROM buku WHERE judul LIKE :search";
$countStmt = $conn->prepare($countSql);
$countStmt->bindValue(':search', $searchParam);
$countStmt->execute();
$totalData = $countStmt->fetch()['total'];

// Ambil jumlah data yang dipilih dari query string atau setel default ke 5
$selected_value = isset($_GET['data_count']) ? (int) $_GET['data_count'] : 5;
// Menentukan halaman saat ini (default 1 jika tidak ada)
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$startLimit = ($currentPage - 1) * $selected_value; // Menentukan offset berdasarkan halaman saat ini

// Query untuk menampilkan data dengan pagination (limit dan offset)
$sql = "SELECT * FROM buku WHERE judul LIKE :search ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':search', $searchParam);
$stmt->bindValue(':limit', $selected_value, PDO::PARAM_INT);
$stmt->bindValue(':offset', $startLimit, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();
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
    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead, tbody {
        display: block;
    }

    tbody {
        max-height: 400px;
        overflow-y: auto;
    }
    thead {
        background-color: #f2f2f2; /* Ganti dengan warna yang sesuai */
    }

    tbody tr {
        display: table; /* Pastikan baris dalam tbody ditampilkan sebagai tabel */
        width: 100%; /* Pastikan baris mengambil lebar penuh */
    }
    tbody th {
        display: table; /* Pastikan baris dalam tbody ditampilkan sebagai tabel */
        width: 100%; /* Pastikan baris mengambil lebar penuh */
    }
  </style>
</head>
<body class="bg-white flex flex-row h-screen font-sand w-screen">
    <section id="sidebar" class="flex flex-col bg-biru_sidebar px-4 py-20 w-1/6 h-screen">
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
    <section class="flex flex-col bg-abu2 w-full">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-8 px-12 text-2xl font-semibold">
            <p>Data Buku</p>
        </div>
        <button id="tambah-anggota" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
            <i class="fi fi-tr-add flex justify-center"></i>
            <p>Tambah Buku</p>
        </button>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Data Buku</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
            <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                <span class="text-xl">Menampilkan</span>
                <form method="GET" action="">
                    <select 
                        name="data_count" 
                        class="border border-solid border-black px-2 py-2 rounded-md focus:outline-none"
                        onchange="this.form.submit()">
                        <option value="5" <?= $selected_value === 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $selected_value === 10 ? 'selected' : '' ?>>10</option>
                        <option value="15" <?= $selected_value === 15 ? 'selected' : '' ?>>15</option>
                    </select>
                    <noscript>
                        <button type="submit" class="hidden">Submit</button>
                    </noscript>
                </form>
                <span class="text-xl">Data</span>
            </div>
                <div class="flex flex-row justify-centerbitems-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl">
                    <input type="text" class="bg-transparent border-none focus:outline-none" placeholder="cari">
                    <i class="fi fi-rr-search"></i>
                </div>
            </div>
            <div class="w-full">
            <table class="border-collapse table-auto">
                <thead class="bg-white">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2 border border-abu_border">
                            <span>#</span>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-auto">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>ISBN</span>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-[20%]">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Judul Buku</span>
                                <a href="?orderBy=judul&orderDir=<?= $orderDir === 'asc' ? 'desc' : 'asc' ?>"><i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-[20%]">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Pengarang</span>
                                <a href="?orderBy=pengarang&orderDir=<?= $orderDir === 'asc' ? 'desc' : 'asc' ?>"><i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-auto">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Tahun</span>
                                <a href="?orderBy=tahun_terbit&orderDir=<?= $orderDir === 'asc' ? 'desc' : 'asc' ?>"><i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-auto">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Kategori</span>
                                <a href="?orderBy=kategori&orderDir=<?= $orderDir === 'asc' ? 'desc' : 'asc' ?>"><i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-auto">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Stok</span>
                                <a href="?orderBy=stok&orderDir=<?= $orderDir === 'asc' ? 'desc' : 'asc' ?>"><i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-abu_border w-auto">
                            <div class="flex justify-center items-center">
                                <span>Aksi</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-abu1">
                    <?php
                    $counter = 1;
                    foreach ($result as $row) {
                        echo '<tr>';
                        echo '<td class="px-4 py-2 text-center border border-abu_border w-[5%]">' . $counter++ . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[15%]">' . htmlspecialchars($row['isbn']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[20%]">' . htmlspecialchars($row['judul']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[20%]">' . htmlspecialchars($row['pengarang']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['tahun_terbit']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['kategori']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['stok']) . '</td>';
                        echo '<td class="px-4 py-2 text-center border border-abu_border w-[10%]">
                                <i class="fi fi-tr-overview cursor-pointer" aria-label="View"></i>
                                <i class="fi fi-tr-floppy-disk-pen cursor-pointer" aria-label="Edit"></i>
                                <i class="fi fi-tr-trash-xmark cursor-pointer" aria-label="Delete"></i>
                            </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <div id="akhir-tabel" class="flex flex-row justify-between items-center text-lg">
                <div>
                    <p>Menampilkan 
                        <?= count($result) ?> 
                        dari 
                        <?= $totalData ?> 
                        data
                    </p>
                </div>
                <div class="text-white font-medium space-x-3">
                    <button id="tombol-kembali "class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">Sebelumnya</button>
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
    </script>    
</body>
</html>
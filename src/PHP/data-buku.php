<?php
// Include koneksi database
include 'connect.php';

// Variabel awal
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$orderBy = isset($_GET['orderBy']) && in_array($_GET['orderBy'], ['judul', 'pengarang', 'tahun_terbit', 'kategori', 'stok']) ? $_GET['orderBy'] : 'judul';
$orderDir = isset($_GET['orderDir']) && $_GET['orderDir'] === 'DESC' ? 'DESC' : 'ASC';
$selected_value = isset($_GET['data_count']) && in_array($_GET['data_count'], ['5', '10']) ? $_GET['data_count'] : '10';
$currentPage = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = (int)$selected_value;
$startLimit = ($currentPage - 1) * $limit;
$searchParam = "%" . $search . "%";

// Query menghitung total data
$countQuery = $conn->prepare("SELECT COUNT(*) FROM buku WHERE judul LIKE :search");
$countQuery->bindValue(':search', $searchParam, PDO::PARAM_STR);
$countQuery->execute();
$totalData = (int) $countQuery->fetchColumn();

// Query data buku
$sql = "SELECT * FROM buku WHERE judul LIKE :search ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $startLimit, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total halaman
$totalPages = ceil($totalData / $limit);

// Navigasi halaman
$previousPage = $currentPage > 1 ? $currentPage - 1 : null;
$nextPage = $currentPage < $totalPages ? $currentPage + 1 : null;

$counter = $startLimit + 1;
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
        <button id="tambah-buku" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
            <i class="fi fi-tr-add flex justify-center"></i>
            <p>Tambah Buku</p>
        </button>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Data Buku</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
            <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                <span class="text-xl">Menampilkan</span>
                <form method="GET" action="">
                <select name="data_count" onchange="this.form.submit()" class="px-2 py-1 border rounded">
                    <option value="5" <?= $selected_value === '5' ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= $selected_value === '10' ? 'selected' : '' ?>>10</option>
                </select>
                    <noscript>
                        <button type="submit" class="hidden">Submit</button>
                    </noscript>
                </form>
                <span class="text-xl">Data</span>
            </div>
            <form class="flex flex-row justify-centerbitems-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl" method="GET" action="">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="bg-transparent border-none focus:outline-none" placeholder="Cari judul buku...">
                    <button type="submit"><i class="fi fi-rr-search cursor-pointer"></i></button>
                </form>
            </div>
            <div class="w-full">
            <table class="border-collapse table-auto w-full">
                <thead class="bg-white">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2 border border-abu_border text-center">
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
                    <?php if ($result): ?>
                        <?php foreach ($result as $row): ?>
                        <?php
                        echo '<tr>';
                        echo '<td class="px-4 py-2 text-center border border-abu_border w-[5%]">' . $counter++ . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[15%]">' . htmlspecialchars($row['isbn']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[20%]">' . htmlspecialchars($row['judul']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[20%]">' . htmlspecialchars($row['pengarang']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['tahun_terbit']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['kategori']) . '</td>';
                        echo '<td class="px-4 py-2 border border-abu_border w-[10%]">' . htmlspecialchars($row['stok']) . '</td>';
                        echo '<td class="px-4 py-2 text-center border border-abu_border w-[10%] space-x-7">
                                <a href="edit-buku.php?isbn=' . htmlspecialchars($row['isbn']) . '"><i class="fi fi-tr-floppy-disk-pen cursor-pointer" aria-label="Edit"></i></a>
                                <i class="fi fi-tr-trash-xmark cursor-pointer" aria-label="Delete"></i>
                                </td>';
                        echo '</tr>';
                        ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                        <td colspan="8" class="text-center text-gray-500 px-4 py-2">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
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
                <div class="space-x-2">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?= $currentPage - 1 ?>&data_count=<?= $selected_value ?>&search=<?= $search ?>&orderBy=<?= $orderBy ?>&orderDir=<?= $orderDir ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Sebelumnya</a>
                    <?php endif; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?= $currentPage + 1 ?>&data_count=<?= $selected_value ?>&search=<?= $search ?>&orderBy=<?= $orderBy ?>&orderDir=<?= $orderDir ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Selanjutnya</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/asidehref.js"> </script>
    <script>
        const tambahBuku = document.getElementById('tambah-buku');
        const edit = document.querySelectorAll('.fi-tr-floppy-disk-pen');
        const del = document.querySelectorAll('.fi-tr-trash-xmark');
        edit.forEach((e) => {
            e.addEventListener('click', () => {
                window.location.href = 'edit-buku.php';
            });
        });
        tambahBuku.addEventListener('click', () => {
            window.location.href = 'tambah-buku.php';
        });
        del.forEach((d) => {
            d.addEventListener('click', () => {
                window.location.href = 'delete-buku.php';
            });
        });
    </script>    
</body>
</html>
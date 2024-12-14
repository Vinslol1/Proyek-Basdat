<?php 
include 'connect.php';

// untuk peminjaman
$searchPinjam = isset($_GET['search_pinjam']) ? trim($_GET['search_pinjam']) : '';
$orderByPinjam = isset($_GET['orderBy_pinjam']) && in_array($_GET['orderBy_pinjam'], ['id', 'tanggal_pinjam', 'nama', 'judul']) ? $_GET['orderBy_pinjam'] : 'tanggal_pinjam';
$orderDirPinjam = isset($_GET['orderDir_pinjam']) && $_GET['orderDir_pinjam'] === 'DESC' ? 'DESC' : 'ASC';
$selected_valuePinjam = isset($_GET['data_count_pinjam']) && in_array($_GET['data_count_pinjam'], ['5', '10']) ? $_GET['data_count_pinjam'] : '10';
$currentPagePinjam = isset($_GET['page_pinjam']) && ctype_digit($_GET['page_pinjam']) ? (int)$_GET['page_pinjam'] : 1;

$limitPinjam = (int)$selected_valuePinjam;
$startLimitPinjam = ($currentPagePinjam - 1) * $limitPinjam;
$searchParamPinjam = "%" . $searchPinjam . "%";

$countQueryPinjam = $conn->prepare("
    SELECT COUNT(*) 
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.isbn = b.isbn
    WHERE a.nama LIKE :search OR b.judul LIKE :search
");
$countQueryPinjam->bindValue(':search', $searchParamPinjam, PDO::PARAM_STR);
$countQueryPinjam->execute();
$totalDataPinjam = (int) $countQueryPinjam->fetchColumn();

$queryPinjam = $conn->prepare("
    SELECT p.id, p.tanggal_pinjam, a.nama, b.judul
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.isbn = b.isbn
    WHERE a.nama LIKE :search OR b.judul LIKE :search OR CAST(p.tanggal_pinjam AS TEXT) LIKE :search OR CAST(p.id AS TEXT) LIKE :search
    ORDER BY $orderByPinjam $orderDirPinjam
    LIMIT :limit OFFSET :offset
");
$queryPinjam->bindValue(':search', $searchParamPinjam, PDO::PARAM_STR);
$queryPinjam->bindValue(':limit', $limitPinjam, PDO::PARAM_INT);
$queryPinjam->bindValue(':offset', $startLimitPinjam, PDO::PARAM_INT);
$queryPinjam->execute();
$resultPinjam = $queryPinjam->fetchAll(PDO::FETCH_ASSOC);

$totalPagesPinjam = ceil($totalDataPinjam / $limitPinjam);
$previousPagePinjam = $currentPagePinjam > 1 ? $currentPagePinjam - 1 : null;
$nextPagePinjam = $currentPagePinjam < $totalPagesPinjam ? $currentPagePinjam + 1 : null;
$counterPinjam = $startLimitPinjam + 1;



// untuk pengembalian
$searchKembali = isset($_GET['search_kembali']) ? trim($_GET['search_kembali']) : '';
$orderByKembali = isset($_GET['orderBy_kembali']) && in_array($_GET['orderBy_kembali'], ['id', 'tanggal_kembali', 'nama', 'judul', 'denda']) ? $_GET['orderBy_kembali'] : 'tanggal_kembali';
$orderDirKembali = isset($_GET['orderDir_kembali']) && $_GET['orderDir_kembali'] === 'DESC' ? 'DESC' : 'ASC';
$selected_valueKembali = isset($_GET['data_count_kembali']) && in_array($_GET['data_count_kembali'], ['5', '10']) ? $_GET['data_count_kembali'] : '10';
$currentPageKembali = isset($_GET['page_kembali']) && ctype_digit($_GET['page_kembali']) ? (int)$_GET['page_kembali'] : 1;

$limitKembali = (int)$selected_valueKembali;
$startLimitKembali = ($currentPageKembali - 1) * $limitKembali;
$searchParamKembali = "%" . $searchKembali . "%";

$countQueryKembali= $conn->prepare("
    SELECT COUNT(*) 
    FROM pengembalian p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.isbn = b.isbn
    WHERE a.nama LIKE :search OR b.judul LIKE :search
");
$countQueryKembali->bindValue(':search', $searchParamKembali, PDO::PARAM_STR);
$countQueryKembali->execute();
$totalDataKembali = (int) $countQueryKembali->fetchColumn();

$queryKembali = $conn->prepare("
    SELECT p.id, p.tanggal_kembali, a.nama, b.judul, p.denda
    FROM pengembalian p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku b ON p.isbn = b.isbn
    WHERE a.nama LIKE :search OR b.judul LIKE :search OR CAST(p.denda AS TEXT) LIKE :search OR CAST(p.tanggal_kembali AS TEXT) LIKE :search OR CAST(p.id AS TEXT) LIKE :search
    ORDER BY $orderByKembali $orderDirKembali
    LIMIT :limit OFFSET :offset
");
$queryKembali->bindValue(':search', $searchParamKembali, PDO::PARAM_STR);
$queryKembali->bindValue(':limit', $limitKembali, PDO::PARAM_INT);
$queryKembali->bindValue(':offset', $startLimitKembali, PDO::PARAM_INT);
$queryKembali->execute();
$resultKembali = $queryKembali->fetchAll(PDO::FETCH_ASSOC);

$totalPagesKembali = ceil($totalDataKembali / $limitKembali);
$previousPageKembali = $currentPageKembali > 1 ? $currentPageKembali - 1 : null;
$nextPageKembali = $currentPageKembali < $totalPagesKembali ? $currentPageKembali + 1 : null;
$counterKembali = $startLimitKembali + 1;


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
        <div class="flex space-x-2">
            <button id="tambah_peminjaman" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/5 h-14 rounded-xl space-x-4 text-white">
                <i class="fi fi-ts-inbox-out"></i>
                <p>Tambah Peminjaman</p>
            </button>
            <button id="tambah_pengembalian" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/5 h-14 rounded-xl space-x-4 text-white">
                <i class="fi fi-ts-inbox-in"></i>
                <p>Tambah Pengembalian</p>
            </button>
        </div>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Transaksi Peminjaman</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
                <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                    <span class="text-xl">Menampilkan</span>
                    <form action="" method="get">
                        <select name="data_count_pinjam" onchange="this.form.submit()" class="border border-solid border-black  px-2 py-2 rounded-md focus:outline-none">
                            <option value="5" <?= $selected_valuePinjam === '5' ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= $selected_valuePinjam === '10' ? 'selected' : '' ?>>10</option>
                        </select>
                    <noscript>
                        <button type="submit" class="hidden">Submit</button>
                    </noscript>
                    </form>
                    <span class="text-xl">Data</span>
                </div>
                <form class="flex flex-row justify-centerbitems-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl">
                    <input type="text" name="search_pinjam" value="<?= htmlspecialchars($searchPinjam) ?>" class="bg-transparent border-none focus:outline-none" placeholder="Cari peminjaman">
                    <button type="submit"><i class="fi fi-rr-search cursor-pointer"></i></button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                <thead class="bg-white border border-collapse border-abu_border">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2">
                            <div class="flex justify-between items-center">
                                <span>No</span>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Tanggal Peminjaman</span>
                                <a href="?orderBy_pinjam=tanggal_pinjam&orderDir_pinjam=<?= $orderDirPinjam === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>ID</span>
                                <a href="?orderBy_pinjam=id&orderDir_pinjam=<?= $orderDirPinjam === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Nama Anggota</span>
                                <a href="?orderBy_pinjam=nama&orderDir_pinjam=<?= $orderDirPinjam === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Judul Buku</span>
                                <a href="?orderBy_pinjam=judul&orderDir_pinjam=<?= $orderDirPinjam === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                    </tr>
                </thead>                  
                    <tbody class="bg-abu1 border border-collapse border-abu1 overflow-y-scroll text-lg">
                    <?php if ($resultPinjam): ?>
                    <?php foreach ($resultPinjam as $row): ?>                        
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center border border-right border-abu_border"><?= $counterPinjam++ ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['tanggal_pinjam'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['id'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['nama'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['judul'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                        <td colspan="5" class="text-center text-gray-500 px-4 py-2 border-abu_border">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="akhir-tabel" class="flex flex-row justify-between items-center text-lg">
                <div>
                    <p>Menampilkan 
                        <?= count($resultPinjam) ?> 
                        dari 
                        <?= $totalDataPinjam ?> 
                        data
                    </p>
                </div>
                <div class="text-white font-medium space-x-3">
                    <?php if ($currentPagePinjam > 1): ?>
                        <a href="?page_pinjam=<?= $currentPagePinjam - 1 ?>&data_count_pinjam=<?= $selected_valuePinjam ?>&search_pinjam=<?= $searchPinjam ?>&orderBy_pinjam=<?= $orderByPinjam ?>&orderDir_pinjam=<?= $orderDirPinjam ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Sebelumnya</a>
                    <?php endif; ?>
                    <?php if ($currentPagePinjam < $totalPagesPinjam): ?>
                        <a href="?page_pinjam=<?= $currentPagePinjam + 1 ?>&data_count_pinjam=<?= $selected_valuePinjam ?>&search_pinjam=<?= $searchPinjam ?>&orderBy_pinjam=<?= $orderByPinjam ?>&orderDir_pinjam=<?= $orderDirPinjam ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Selanjutnya</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Transaksi Pengembalian</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
                <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                    <span class="text-xl">Menampilkan</span>
                    <form action="" method="get">
                        <select name="data_count_kembali" onchange="this.form.submit()" class="border border-solid border-black  px-2 py-2 rounded-md focus:outline-none">
                            <option value="5" <?= $selected_valueKembali === '5' ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= $selected_valueKembali === '10' ? 'selected' : '' ?>>10</option>
                        </select>
                    <noscript>
                        <button type="submit" class="hidden">Submit</button>
                    </noscript>
                    </form>
                    <span class="text-xl">Data</span>
                </div>
                <form class="flex flex-row justify-centerbitems-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl">
                    <input type="text" name="search_kembali" value="<?= htmlspecialchars($searchKembali) ?>" class="bg-transparent border-none focus:outline-none" placeholder="Cari pengembalian">
                    <button type="submit"><i class="fi fi-rr-search cursor-pointer"></i></button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                <thead class="bg-white border border-collapse border-abu_border">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2">
                            <div class="flex justify-between items-center">
                                <span>No</span>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Tanggal Pengembalian</span>
                                <a href="?orderBy_kembali=tanggal_kembali&orderDir_kembali=<?= $orderDirKembali === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>ID</span>
                                <a href="?orderBy_kembali=id&orderDir_kembali=<?= $orderDirKembali === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Nama Anggota</span>
                                <a href="?orderBy_kembali=nama&orderDir_kembali=<?= $orderDirKembali === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Judul Buku</span>
                                <a href="?orderBy_kembali=judul&orderDir_kembali=<?= $orderDirKembali === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Denda</span>
                                <a href="?orderBy_kembali=denda&orderDir_kembali=<?= $orderDirKembali === 'ASC' ? 'DESC' : 'ASC' ?>">
                                <i class="fi fi-tr-sort-alt"></i></a>
                            </div>
                        </th>

                    </tr>
                </thead>                  
                    <tbody class="bg-abu1 border border-collapse border-abu1 overflow-y-scroll text-lg">
                    <?php if ($resultKembali): ?>
                    <?php foreach ($resultKembali as $row): ?>                        
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center border border-right border-abu_border"><?= $counterKembali++ ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['tanggal_kembali'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['id'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['nama'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['judul'] ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $row['denda'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 px-4 py-2 border-abu_border">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="akhir-tabel" class="flex flex-row justify-between items-center text-lg">
                <div>
                    <p>Menampilkan 
                        <?= count($resultKembali) ?> 
                        dari 
                        <?= $totalDataKembali ?> 
                        data
                    </p>
                </div>
                <div class="text-white font-medium space-x-3">
                    <?php if ($currentPageKembali > 1): ?>
                        <a href="?page_kembali=<?= $currentPageKembali - 1 ?>&data_count_kembali=<?= $selected_valueKembali ?>&search_kembali=<?= $searchKembali ?>&orderBy_kembali=<?= $orderByKembali ?>&orderDir_kembali=<?= $orderDirKembali ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Sebelumnya</a>
                    <?php endif; ?>
                    <?php if ($currentPageKembali < $totalPagesKembali): ?>
                        <a href="?page_kembali=<?= $currentPageKembali + 1 ?>&data_count_kembali=<?= $selected_valueKembali ?>&search_kembali=<?= $searchKembali ?>&orderBy_kembali=<?= $orderByKembali ?>&orderDir_kembali=<?= $orderDirKembali ?>" class="bg-biru_button px-5 py-2 rounded-xl hover:opacity-80 text-white font-medium">Selanjutnya</a>
                    <?php endif; ?>
                </div>
            </div>
    </section>
    <script src="../js/asidehref.js"> </script>    
    <script>
        const tambah_peminjaman = document.getElementById('tambah_peminjaman');
        const tambah_pengembalian = document.getElementById('tambah_pengembalian');
        tambah_peminjaman.addEventListener('click', () => {
            window.location.href = 'transaksi-tambah_peminjaman.php';    
        });
        tambah_pengembalian.addEventListener('click', () => {
            window.location.href = 'transaksi-tambah_pengembalian.php';    
        });

    </script>
</body>
</html>

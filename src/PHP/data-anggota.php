<?php
    include 'connect.php';

    $limit = 10; 
    $search = ''; 
    $whereClause = '';

    // buat kalo ada input jumlah limit dari pengguna
    if (isset($_POST['limit'])) {
        $limit = (int)$_POST['limit'];
    }

    // utk fitur cari data
    if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
        $search = trim($_POST['search']);
        $whereClause = "WHERE nama LIKE :search OR telepon LIKE :search";
    }

    // buat nampilkan total data
    $totalSql = "SELECT COUNT(*) as total FROM anggota $whereClause";
    $totalStmt = $conn->prepare($totalSql);

    if (!empty($whereClause)) {
        $totalStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }

    $totalStmt->execute();
    $totalData = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    $sql = "SELECT * FROM anggota $whereClause LIMIT :limit";
    $stmt = $conn->prepare($sql);

    // bind parameter untuk pencarian jika ada
    if (!empty($whereClause)) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();
    $anggota = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <p>Data Anggota</p>
        </div>
        <button id="tambah-anggota" class="bg-biru_button hover:opacity-90 flex justify-center items-center mx-12 text-2xl font-medium w-1/6 h-14 rounded-xl space-x-4 text-white">
            <i class="fi fi-tr-add flex justify-center"></i>
            <p>Tambah Anggota</p>
        </button>
        <div class="flex flex-col mx-12 mt-8 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Anggota Perpustakaan</p>
            <div class="flex flex-row justify-between items-center p-4 rounded-t-lg">
                <div class="flex flex-row items-center space-x-2 text-xl font-medium text-black opacity-75">
                    <span class="text-xl">Menampilkan</span>
                    <form method="POST" class="flex items-center space-x-2">
                        <select name="limit" class="border border-solid border-black px-2 py-2 rounded-md focus:outline-none" onchange="this.form.submit()">
                            <option value="1" <?= $limit == 1 ? 'selected' : ''; ?>>1</option>
                            <option value="5" <?= $limit == 5 ? 'selected' : ''; ?>>5</option>
                            <option value="10" <?= $limit == 10 ? 'selected' : ''; ?>>10</option>
                        </select>
                        <span class="text-xl">Data</span>
                    </form>
                </div>
                <form method="POST" class="flex flex-row items-center space-x-2 border border-solid border-abu_border px-2 py-2 rounded-xl">
                    <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="bg-transparent border-none focus:outline-none" placeholder="Cari anggota...">
                    <button type="submit">
                        <i class="fi fi-rr-search"></i>
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                <thead class="bg-white border border-collapse border-abu_border">
                    <tr class="text-gray-600 font-medium text-xl">
                        <th class="px-4 py-2">
                            <div class="flex justify-between items-center">
                                <span>#</span>
                                <i class="fi fi-tr-sort-amount-down-alt cursor-pointer"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>ID</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="nama-anggota">Nama Anggota</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="telepon">Telepon</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span id="denda">Denda</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                        <th class="px-4 py-2 border border-solid border-abu_border">
                            <div class="flex justify-between items-center cursor-pointer">
                                <span>Aksi</span>
                                <i class="fi fi-tr-sort-alt"></i>
                            </div>
                        </th>
                    </tr>
                </thead>                  
                    <tbody class="bg-abu1 border border-collapse border-abu1 overflow-y-scroll text-lg">
                    <?php foreach ($anggota as $index => $data) : ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center border border-right border-abu_border"><?= $index + 1; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['id']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['nama']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border"><?= $data['telepon']; ?></td>
                            <td class="px-4 py-2 border border-right border-abu_border">0</td>
                            <td class="px-4 py-2 space-x-5 border border-right border-abu_border">
                                <i class="fi fi-tr-floppy-disk-pen cursor-pointer" onclick="window.location.href='update-anggota.php?id=<?= $data['id']; ?>'"></i>
                                <i class="fi fi-tr-trash-xmark cursor-pointer" data-id="<?= $data['id']; ?>" onclick="confirmDelete(this)"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="akhir-tabel" class="flex flex-row justify-between items-center text-lg">
                <?php if (empty($anggota)) : ?>
                    <p class="text-red-600">Tidak ada data yang cocok dengan pencarian.</p>
                <?php else : ?>
                    <div>
                        <p class="text-black">Menampilkan <?= count($anggota) ?> dari <?= $totalData ?> data anggota</p>
                    </div>
                    <div class="text-white font-medium space-x-3">
                        <button id="tombol-kembali" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">sebelumnya</button>
                        <button id="tombol-selanjutnya" class="bg-biru_button px-5 py-1 rounded-xl hover:opacity-80">Selanjutnya</button>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
    <script>
        const beranda = document.getElementById('sidebar-beranda');
        const transaksi = document.getElementById('sidebar-transaksi');
        const buku = document.getElementById('sidebar-buku');
        const petugas = document.getElementById('sidebar-petugas');
        const anggota = document.getElementById('sidebar-anggota');
        const tambahAnggota = document.getElementById('tambah-anggota');
        
        beranda.addEventListener('click', () => {
            window.location.href = 'dasbor.php';
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
            window.location.href = 'data-anggota.php';
        });

        tambahAnggota.addEventListener('click', () => {
            window.location.href = 'tambah-anggota.php';
        });

        function confirmDelete(element) {
            const id = element.getAttribute('data-id');
            const confirmed = confirm("Apakah Anda yakin ingin menghapus data anggota dengan ID " + id + "?");
            if (confirmed) {
                window.location.href = 'delete-anggota.php?id=' + id;
            }
        }

    </script>    
</body>
</html>

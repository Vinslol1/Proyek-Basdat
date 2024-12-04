<?php
include '../connect.php';

// Inisialisasi variabel
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$data_count = isset($_GET['data_count']) ? (int)$_GET['data_count'] : 10;

// Hitung total data
$total_query = "SELECT COUNT(*) AS total FROM buku";
$total_stmt = $conn->query($total_query);
$total_data = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil data dengan pagination
$offset = ($page - 1) * $data_count;
$query = "SELECT * FROM buku LIMIT :data_count OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindValue(':data_count', $data_count, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Perpus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="../../style_buku.css">
</head>
<body>
    <header class="main-header">
        <img src="../../img/Group 16.svg" alt="Satu Perpus Logo" class="logo" style="padding-left: 50px;" />
        <div class="user-info">
            <span>aska skata</span>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </header>
    <div class="page-layout">
        <div class="sidebar">
            <div class="profile-section">
                <div class="profile-picture">
                <span class="material-symbols-outlined">account_circle</span>
                </div>
                <p class="username">aska skata</p>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="transaksi.html">Transaksi</a></li>
                    <li><a href="Data_buku.html">Data Buku</a></li>
                    <li><a href="data_anggota.html">Data Anggota</a></li>
                    <li><a href="data_pengunjung.html">Data Pengunjung</a></li>
                    <li><a href="pengaturan.html">Pengaturan</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div class="h2_class">
                <h2 style="margin: 15px 0 0 0;">Data Buku</h2>
                <h3 style="padding-top: 20px; padding-right: 33px;">Beranda > Data Buku</h3>
            </div>
            <div class="button-container" style="padding-right: 48px;">
                <button class="custom-button">
                    <img class="icon" src="../../img/icon_plus.svg" alt="">
                    Tambah Data Buku
                </button>
                <button class="custom-button" style="justify-content: center;">
                    Laporan Data Buku
                </button>
            </div>
            <div class="content">
                <div class="recent-loans-section">
                    <div class="topofcontent">
                        <h2>Data Buku</h2>
                        <div class="search-box">
                            <div class="display-data">
                                <span>Menampilkan</span>
                                <select id="data-count" class="dropdown" onchange="window.location.href='?page=1&data_count=' + this.value;">
                                    <option value="5" <?= $data_count == 5 ? 'selected' : '' ?>>5</option>
                                    <option value="10" <?= $data_count == 10 ? 'selected' : '' ?>>10</option>
                                    <option value="20" <?= $data_count == 20 ? 'selected' : '' ?>>20</option>
                                </select>
                                <span>Data</span>
                            </div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Tahun</th>
                                <th>Klasifikasi</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($stmt->rowCount() > 0): ?>
                                <?php $counter = $offset + 1; ?>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= $counter++; ?>.</td>
                                        <td><?= $row['isbn']; ?></td>
                                        <td><?= $row['judul']; ?></td>
                                        <td><?= $row['pengarang']; ?></td>
                                        <td><?= $row['tahun_terbit']; ?></td>
                                        <td><?= $row['kategori']; ?></td>
                                        <td><?= $row['jumlah']; ?></td>
                                        <td class="td_icon">
                                            <img src="img/logo_mata.svg" alt="">
                                            <img src="img/icon_edit.svg" alt="">
                                            <img src="img/icon_trash.svg" alt="">
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="content-button">
                        <p>Menampilkan <?= min($page * $data_count, $total_data); ?> dari <?= $total_data; ?> data</p>
                        <div style="display: flex; gap: 20px;">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1; ?>&data_count=<?= $data_count; ?>" class="custom-button">Sebelumnya</a>
                            <?php endif; ?>
                            <?php if ($page * $data_count < $total_data): ?>
                                <a href="?page=<?= $page + 1; ?>&data_count=<?= $data_count; ?>" class="custom-button">Selanjutnya</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

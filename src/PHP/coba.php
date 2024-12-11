<?php
include 'connect.php'; 

// Fungsi untuk menambah peminjaman
if (isset($_POST['tambah_peminjaman'])) {
    $id_anggota = $_POST['id_anggota'];
    $isbn = $_POST['isbn'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+14 days'));  // 2 minggu setelah tanggal pinjam

    $sql = "INSERT INTO peminjaman (id_anggota, isbn, tanggal_pinjam, tanggal_kembali)
            VALUES (:id_anggota, :isbn, :tanggal_pinjam, :tanggal_kembali)";
    
    // Siapkan query
    $stmt = $pdo->prepare($sql);
    
    // Bind parameter
    $stmt->bindParam(':id_anggota', $id_anggota);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':tanggal_pinjam', $tanggal_pinjam);
    $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Peminjaman berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }
}

// Fungsi untuk menambah pengembalian
if (isset($_POST['tambah_pengembalian'])) {
    $id_anggota = $_POST['id_anggota'];
    $isbn = $_POST['isbn'];
    $tanggal_kembali = date('Y-m-d');
    $kondisi = $_POST['kondisi'];

    // Hitung denda (selisih tanggal pengembalian dengan tanggal kembali)
    $sql = "SELECT tanggal_kembali FROM peminjaman WHERE id_anggota = :id_anggota AND isbn = :isbn LIMIT 1";
    
    // Siapkan query
    $stmt = $pdo->prepare($sql);
    
    // Bind parameter
    $stmt->bindParam(':id_anggota', $id_anggota);
    $stmt->bindParam(':isbn', $isbn);
    
    // Eksekusi query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $tanggal_batas = $row['tanggal_kembali'];

    $denda = 0;
    if ($tanggal_batas < $tanggal_kembali) {
        $denda = (strtotime($tanggal_kembali) - strtotime($tanggal_batas)) / (60 * 60 * 24) * 1000;  // Denda per hari
    }

    // Masukkan data pengembalian
    $sql_pengembalian = "INSERT INTO pengembalian (id_anggota, isbn, tanggal_kembali, kondisi, denda)
                         VALUES (:id_anggota, :isbn, :tanggal_kembali, :kondisi, :denda)";
    
    // Siapkan query
    $stmt_pengembalian = $pdo->prepare($sql_pengembalian);
    
    // Bind parameter
    $stmt_pengembalian->bindParam(':id_anggota', $id_anggota);
    $stmt_pengembalian->bindParam(':isbn', $isbn);
    $stmt_pengembalian->bindParam(':tanggal_kembali', $tanggal_kembali);
    $stmt_pengembalian->bindParam(':kondisi', $kondisi);
    $stmt_pengembalian->bindParam(':denda', $denda);

    // Eksekusi query
    if ($stmt_pengembalian->execute()) {
        // Update status peminjaman menjadi selesai
        $sql_update = "DELETE FROM peminjaman WHERE id_anggota = :id_anggota AND isbn = :isbn AND tanggal_kembali = :tanggal_batas";
        
        // Siapkan query untuk update
        $stmt_update = $pdo->prepare($sql_update);
        
        // Bind parameter
        $stmt_update->bindParam(':id_anggota', $id_anggota);
        $stmt_update->bindParam(':isbn', $isbn);
        $stmt_update->bindParam(':tanggal_batas', $tanggal_batas);
        
        // Eksekusi query
        $stmt_update->execute();

        echo "<script>alert('Pengembalian berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }
}

// Tampilkan data peminjaman yang ada
$sql_peminjaman = "SELECT p.id, p.id_anggota, p.isbn, p.tanggal_pinjam, p.tanggal_kembali, a.nama, b.judul 
                   FROM peminjaman p
                   JOIN anggota a ON p.id_anggota = a.id
                   JOIN buku b ON p.isbn = b.isbn";

$stmt_peminjaman = $conn->prepare($sql_peminjaman);
$stmt_peminjaman->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto p-6">
        <!-- Form Peminjaman -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Peminjaman</h2>
            <form action="" method="POST" class="space-y-4">
                <input type="text" name="id_anggota" placeholder="ID Anggota" class="input" required>
                <input type="text" name="isbn" placeholder="ISBN Buku" class="input" required>
                <button type="submit" name="tambah_peminjaman" class="btn">Tambah Peminjaman</button>
            </form>
        </div>

        <!-- Form Pengembalian -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Pengembalian</h2>
            <form action="" method="POST" class="space-y-4">
                <input type="text" name="id_anggota" placeholder="ID Anggota" class="input" required>
                <input type="text" name="isbn" placeholder="ISBN Buku" class="input" required>
                <input type="text" name="kondisi" placeholder="Kondisi Buku" class="input" required>
                <button type="submit" name="tambah_pengembalian" class="btn">Tambah Pengembalian</button>
            </form>
        </div>

        <!-- Tabel Peminjaman yang Ada -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Daftar Peminjaman</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border">ID Anggota</th>
                        <th class="py-2 px-4 border">Nama Anggota</th>
                        <th class="py-2 px-4 border">ISBN</th>
                        <th class="py-2 px-4 border">Judul Buku</th>
                        <th class="py-2 px-4 border">Tanggal Pinjam</th>
                        <th class="py-2 px-4 border">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt_peminjaman->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td class="py-2 px-4 border"><?= $row['id_anggota'] ?></td>
                            <td class="py-2 px-4 border"><?= $row['nama'] ?></td>
                            <td class="py-2 px-4 border"><?= $row['isbn'] ?></td>
                            <td class="py-2 px-4 border"><?= $row['judul'] ?></td>
                            <td class="py-2 px-4 border"><?= $row['tanggal_pinjam'] ?></td>
                            <td class="py-2 px-4 border"><?= $row['tanggal_kembali'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TailwindCSS classes -->
    <style>
        .input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</body>
</html>

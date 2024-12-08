<?php
include 'connect.php';

// Cek apakah ada ID yang diberikan melalui query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data berdasarkan ID
    $query = "SELECT * FROM anggota WHERE id = :id";
    $stmt = $pdo->prepare($query); // Siapkan query
    $stmt->execute(['id' => $id]); // Eksekusi query dengan parameter
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // Ambil hasil query

    if ($data) {
        // Tampilkan form edit dengan data yang ada
        echo '<form method="POST" action="edit.php">';
        echo '<input type="hidden" name="id" value="' . $data['id'] . '">';
        echo 'Nama: <input type="text" name="nama" value="' . $data['nama'] . '"><br>';
        echo 'Telepon: <input type="text" name="telepon" value="' . $data['telepon'] . '"><br>';
        echo '<button type="submit" name="update">Update</button>';
        echo '</form>';
    } else {
        echo 'Data tidak ditemukan.';
    }
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];

    $updateQuery = "UPDATE anggota SET nama = :nama, telepon = :telepon WHERE id = :id";
    $stmt = $pdo->prepare($updateQuery); // Pastikan menggunakan objek $pdo yang benar
    $stmt->execute(['nama' => $nama, 'telepon' => $telepon, 'id' => $id]); // Eksekusi query

    echo 'Data berhasil diupdate!';
}
?>

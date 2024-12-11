<?php
include 'connect.php';  

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Menggunakan prepared statement dengan PDO
    $query = "DELETE FROM anggota WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // routing setelah berhasil menghapus data
        header('Location: data-anggota.php');
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data.";
    }
} else {
    echo "ID tidak valid.";
}
?>

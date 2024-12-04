<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun = $_POST['tahun'];
    $klasifikasi = $_POST['klasifikasi'];
    $jumlah = $_POST['jumlah'];

    $sql = "INSERT INTO buku (judul, pengarang, tahun, klasifikasi, jumlah) VALUES ('$judul', '$pengarang', '$tahun', '$klasifikasi', $jumlah)";
    if ($conn->query($sql) === TRUE) {
        header('Location: data_buku.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

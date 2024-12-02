<?php
include 'connect.php';

$id_anggota = $_POST['id_anggota'];
$ISBN = $_POST['isbn'];
$tanggal_pinjam = date('Y-m-d'); // Tanggal waktu input buku nya
$tanggal_kembali = // kapan ngembaliin buku nya

$query = "INSERT INTO peminjaman (id_anggota, isbn, tanggal_pinjam, id) VALUES ($1, $2, $3, //id petugas//)";
$result = pg_query_params($conn, $query, array($user_id, $book_id, $loan_date));

if ($result) {
    echo "Peminjaman berhasil!";
} else {
    echo "Error: " . pg_last_error();
}

pg_close($conn);
?>

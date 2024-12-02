<!-- <?php
include 'connect.php';

$id_anggota = $_POST['id_anggota'];
$ISBN = $_POST['isbn'];
$tanggal_pinjam = date('Y-m-d'); // Tanggal waktu input buku nya
$tanggal_kembali = // kapan ngembaliin buku nya

$query = "UPDATE Loans SET return_date = $1 WHERE id = $2";
$result = pg_query_params($conn, $query, array($return_date, $loan_id));

if ($result) {
    echo "Pengembalian berhasil!";
} else {
    echo "Error: " . pg_last_error();
}

pg_close($conn);
?> -->


// menu nya gimana? apa aja yang mau ditampilkan 

<?php
$host = 'aws-0-ap-southeast-1.pooler.supabase.com';
$user = 'postgres.mxpemqqtdliobzoehtqa';
$password = 'SatuPerpusdb';
$port = '6543';
$dbname = 'postgres';

<<<<<<< HEAD:php/connect.php
try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
=======
// String koneksi
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Membuka koneksi
$conn = pg_connect($conn_string);

// Perika koneksi
if (!$conn) {
    echo "Koneksi ke PostgreSQL gagal";
} 
>>>>>>> 5d59d91c0fe64c3227faff7fe9f2b8728ceb2d2f:src/PHP/connect.php
?>
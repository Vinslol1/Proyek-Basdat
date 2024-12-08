<?php
$host = 'aws-0-ap-southeast-1.pooler.supabase.com';
$user = 'postgres.mxpemqqtdliobzoehtqa';
$password = 'SatuPerpusdb';
$port = '6543';
$dbname = 'postgres';

// String koneksi
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Membuka koneksi
$conn = pg_connect($conn_string);

// Perika koneksi
if (!$conn) {
    echo "Koneksi ke PostgreSQL gagal";
} 
?>
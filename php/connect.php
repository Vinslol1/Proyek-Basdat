<?php
$host = 'aws-0-ap-southeast-1.pooler.supabase.com';
$user = 'postgres.mxpemqqtdliobzoehtqa';
$password = 'SatuPerpusdb';
$port = '6543';
$dbname = 'postgres';

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
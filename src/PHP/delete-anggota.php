<?php
include 'connect.php';  

$id = $_GET['id'];
$query = "DELETE FROM activities WHERE id = $id";
pg_query($conn, $query);

header('Location: data-anggota.php');
?>
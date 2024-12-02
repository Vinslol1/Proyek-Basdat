<?php
include 'connect.php';

$query = "SELECT * FROM peminjaman";
$result = pg_query($conn, $query);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        echo "Loan ID: " . $row['id'] . " - User: " . $row['user_id'] . " - Book: " . $row['book_id'] . "<br>";
    }
} else {
    echo "Error: " . pg_last_error();
}

pg_close($conn);
?>

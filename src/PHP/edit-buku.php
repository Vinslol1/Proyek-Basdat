<?php 
include 'connect.php';

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun-terbit'];
    $kota = $_POST['kota-terbit'];
    $kategori = $_POST['genre'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Validasi sederhana
    if (empty($isbn) || empty($judul) || empty($pengarang) || empty($penerbit) || empty($tahun) || empty($kota) || empty($kategori) || empty($harga) || empty($stok)) {
        echo "<script>alert('Harap isi semua bidang!'); window.history.back();</script>";
        exit;
    }

    // Query untuk mengupdate data buku
    $sql = "UPDATE buku SET judul = ?, pengarang = ?, penerbit = ?, tahun_terbit = ?, kota_terbit = ?, kategori = ?, harga = ?, stok = ? WHERE isbn = ?";

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $judul);
    $stmt->bindParam(2, $pengarang);
    $stmt->bindParam(3, $penerbit);
    $stmt->bindParam(4, $tahun);
    $stmt->bindParam(5, $kota);
    $stmt->bindParam(6, $kategori);
    $stmt->bindParam(7, $harga);
    $stmt->bindParam(8, $stok);
    $stmt->bindParam(9, $isbn);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil diupdate!'); window.location.href = 'data-buku.html';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->errorInfo()[2] . "'); window.history.back();</script>";
    }
}

// Ambil data buku berdasarkan ISBN untuk ditampilkan di form edit
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];
    $sql = "SELECT * FROM buku WHERE isbn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $isbn);
    $stmt->execute();
    $buku = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$buku) {
        echo "<script>alert('Buku tidak ditemukan!'); window.location.href = 'data-buku.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('ISBN tidak disediakan!'); window.location.href = 'data-buku.html';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../style/style2.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex flex-row font-sand w-screen min-h-screen overflow-x-hidden">
    <section class="flex flex-col bg-abu2 w-full">
        <div class="flex my-8 px-12 text-2xl font-semibold">
            <p>Edit Buku</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white">
            <p class="font-bold text-2xl">Edit Buku</p>
            <form method="POST" class="space-y-6 text-xl p-6">
                <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($buku['isbn']); ?>">
                <div class="flex flex-row gap-8">
                    <label for="judul-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Judul Buku</label>
                    <input type="text" id="judul-buku" name="judul" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['judul']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="pengarang-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Pengarang</label>
                    <input type="text" id="pengarang-buku" name="pengarang" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['pengarang']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="penerbit-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Penerbit</label>
                    <input type="text" id="penerbit-buku" name="penerbit" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['penerbit']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="tahun-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Tahun Terbit</label>
                    <input type="number" id="tahun-buku" name="tahun-terbit" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['tahun_terbit']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="kota-terbit" class="block text-gray-700 font-bold md:w-1/6 text-right">Kota Terbit</label>
                    <input type="text" id="kota-terbit" name="kota-terbit" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['kota_terbit']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="genre" class="block text-gray-700 font-bold md:w-1/6 text-right">Kategori</label>
                    <input type="text" id="genre" name="genre" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['kategori']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="harga-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Harga</label>
                    <input type="number" id="harga-buku" name="harga" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['harga']); ?>">
                </div>
                <div class="flex flex-row gap-8">
                    <label for="stok-buku" class="block text-gray-700 font-bold md:w-1/6 text-right">Jumlah</label>
                    <input type="number" id="stok-buku" name="stok" class="w-full border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($buku['stok']); ?>">
                </div>
                <div class="flex justify-end gap-4 mt-4 font-medium text-white text-xl">
                    <button type="submit" class="bg-biru_button px-8 py-2 rounded-xl hover:opacity-80">Update</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
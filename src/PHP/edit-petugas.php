<?php
include 'connect.php';

// Pastikan ID petugas yang akan diupdate tersedia
if (!isset($_GET['id'])) {
    die("ID petugas tidak ditemukan.");
}

// Retrieve ID from the URL
$id = $_GET['id'];

// Query to get the petugas data
$query = "SELECT * FROM petugas WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// If no data is found for the given ID
if (!$data) {
    die("Data petugas tidak ditemukan.");
}

// Proses update data jika form di-submit
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Update data petugas
    $updateQuery = "UPDATE petugas SET nama = :nama, kontak = :kontak, email = :email, is_admin = :is_admin WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([
        'nama' => $nama,
        'kontak' => $kontak,
        'email' => $email,
        'is_admin' => $is_admin,
        'id' => $id
    ]);

    header("Location: data-petugas.php?updated=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Satu Perpus</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="../style/style2.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-straight/css/uicons-thin-straight.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <style>
    #icon-logo {
        font-size: 2.5rem; 
    }
    #icon-profil {
        font-size: 2.5rem; 
    }
    #isi-dasbor .fi {
        font-size: 4rem;
    }    
    .active {
        background-color: #003566;
        border-radius: 0.375rem;
    }
  </style>
</head>
<body class="bg-white flex flex-row font-sand w-screen overflow-x-hidden">
    <section id="sidebar" class="fixed top-0 left-0 h-screen w-1/6 bg-biru_sidebar flex flex-col px-4 py-20 z-50">
        <div class="flex flex-row justify-center items-center w-full bg-abu1 p-2 rounded-lg space-x-5 text-lg mb-12 text-biru_text">
            <i id="icon-logo" class="fi fi-ts-book-open-reader"></i>
            <span>SATU PERPUS</span>
        </div>
        <div class="flex flex-col w-full font-sand rounded-lg text-xl text-white space-y-2 px-4">
            <div id="sidebar-beranda" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Beranda</p>
            </div>
            <div id="sidebar-transaksi" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Transaksi</p>
            </div>
            <div id="sidebar-buku" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer active">
                <p>Data Buku</p>
            </div>
            <div id="sidebar-petugas" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Petugas</p>
            </div>
            <div id="sidebar-anggota" class="hover:bg-biru_hover -ml-4 p-3 hover:rounded-md cursor-pointer">
                <p>Data Anggota</p>
            </div>
        </div>        
    </section>
    <section class="flex flex-col bg-abu2 w-5/6 ml-[16.67%] min-h-screen top-0">
        <div id="profil-pengguna" class="flex flex-row justify-end items-center p-8 space-x-3 text-biru_text font-medium">
            <span class="flex items-center text-2xl">aska skata</span>
            <span id="icon-profil" class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="flex my-4 px-12 text-2xl font-semibold">
            <p>Data Petugas</p>
        </div>
        <div class="flex flex-col mx-12 my-4 p-4 rounded-lg shadow-md bg-white ">
            <p class="font-bold text-2xl">Edit Petugas</p>
            <form method="POST" class="flex flex-col space-y-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
                <div>
                    <label for="nama" class="block text-xl font-medium text-gray-700">Nama:</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="border border-solid border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="kontak" class="block text-xl font-medium text-gray-700">Kontak:</label>
                    <input type="text" id="kontak" name="kontak" value="<?= htmlspecialchars($data['kontak']); ?>" class="border border-solid border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-xl font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" class="border border-solid border-gray-300 px-4 py-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="is_admin" class="block text-xl font-medium text-gray-700">Is Admin:</label>
                    <input type="checkbox" id="is_admin" name="is_admin" <?= $data['is_admin'] ? 'checked' : ''; ?> class="focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="text-white font-medium space-x-3 flex items-end justify-end">
                    <button type="button" class="bg-gray-500 px-8 py-2 rounded-xl hover:opacity-80"" onclick="window.history.back()">Kembali</button>
                    <button type="submit" name="update" class="bg-biru_button px-8 py-2 rounded-xl hover:opacity-80">Update</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const tombolKembali = document.getElementById('tombol-kembali');
        tombolKembali.addEventListener('click', () => {
            window.history.back();
        });
    </script>
</body>
</html>


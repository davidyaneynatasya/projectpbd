<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Memanggil Navbar / Menu Garis Tiga -->
    <?php include 'header.php'; ?>

    <!-- Konten Dashboard Utama -->
    <div class="container text-center my-5 text-white">
        <h1 class="fw-bold display-4">Selamat Datang di Toko Davidya</h1>
        <p class="lead mt-3">Sistem Inventaris dan Manajemen Barang</p>
        <div class="mt-4">
            <a href="barang.php" class="btn btn-light btn-lg fw-bold px-4 shadow-sm" style="color: #0052D4;">
                Kelola Data Barang
            </a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
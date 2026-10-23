<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Mengubah warna background seluruh halaman */
        body {
            background-color: #6495ED; /* Warna background latar belakang halaman */
        }

        /* Mengubah warna latar belakang Navbar */
        .custom-navbar {
            background-color: #276cd3 !important;
        }

        /* Mengubah warna teks dan brand pada Navbar */
        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color: #ffffff !important; /* Warna teks putih */
        }

        .custom-navbar .nav-link:hover {
            color: #e0e0e0 !important; /* Warna teks saat kursor di-hover */
        }
    </style>
</head>
<body>

<!-- Navbar dengan class custom warna -->
<nav class="navbar navbar-expand-lg custom-navbar mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Toko Davidya</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Data Barang</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
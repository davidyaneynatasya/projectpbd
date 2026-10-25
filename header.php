<!-- Di dalam file header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Navbar / Bagian Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent px-4 py-3">
        <div class="container-fluid">
            <!-- Kosongkan atau biarkan brand jika perlu -->
            <a class="navbar-brand fw-bold" href="index.php"></a>

            <!-- Tombol Ikon Garis Tiga di Pojok Kanan Atas -->
            <button class="btn btn-light shadow-sm border p-2 ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuSidebar" aria-controls="menuSidebar" title="Menu Master Data">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list text-secondary" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Komponen Sidebar (Offcanvas) Pilihan Tabel Master -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="menuSidebar" aria-labelledby="menuSidebarLabel">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title fw-bold" id="menuSidebarLabel">Menu Master Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="text-muted small mb-3">Pilih tabel master yang ingin dikelola:</p>
            <div class="list-group list-group-flush">
                <a href="barang.php" class="list-group-item list-group-item-action py-2">📦 Barang</a>
                <a href="satuan.php" class="list-group-item list-group-item-action py-2">📏  Satuan</a>
                <a href="jenis.php" class="list-group-item list-group-item-action py-2">🏷️ Jenis / Kategori</a>
                <a href="vendor.php" class="list-group-item list-group-item-action py-2">🤝  Vendor</a>
                <a href="user.php" class="list-group-item list-group-item-action py-2">👤 User</a>
                <a href="role.php" class="list-group-item list-group-item-action py-2">👤 Role</a>
                <a href="margin.php" class="list-group-item list-group-item-action py-2">👤 Margin Penjualan</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
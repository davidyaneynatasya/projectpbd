<?php
include 'koneksi.php';

// 1. PROSES UPDATE / SIMPAN PERUBAHAN MARGIN
if (isset($_POST['simpan'])) {
    $persen = $_POST['persen'];
    $iduser = $_POST['iduser']; // Mengambil ID user yang sedang mengubah

    // Cek apakah data margin sudah pernah diisi sebelumnya
    $cek = mysqli_query($koneksi, "SELECT * FROM margin_penjualan LIMIT 1");
    
    if (mysqli_num_rows($cek) > 0) {
        // Jika sudah ada, lakukan UPDATE pada baris pertama
        $row_lama = mysqli_fetch_assoc($cek);
        $id_margin = $row_lama['idmargin_penjualan'];
        
        $query = "UPDATE margin_penjualan SET 
                    persen = '$persen', 
                    iduser = '$iduser', 
                    updated_at = NOW() 
                  WHERE idmargin_penjualan = '$id_margin'";
    } else {
        // Jika belum ada sama sekali, lakukan INSERT baru
        $query = "INSERT INTO margin_penjualan (persen, status, iduser, created_at, updated_at) 
                  VALUES ('$persen', '1', '$iduser', NOW(), NOW())";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Margin penjualan berhasil diperbarui!'); window.location=window.location.href;</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui margin: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 2. AMBIL DATA MARGIN YANG AKTIF SAAT INI
$query_tampil = mysqli_query($koneksi, "SELECT * FROM margin_penjualan LIMIT 1");
$data_margin = mysqli_fetch_assoc($query_tampil);

$persen_aktif = $data_margin ? $data_margin['persen'] : '';
$iduser_aktif = $data_margin ? $data_margin['iduser'] : '';
$updated_at   = $data_margin ? $data_margin['updated_at'] : 'Belum pernah diatur';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Margin Penjualan - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Memanggil Navbar / Menu Garis Tiga -->
    <?php include 'header.php'; ?>

    <!-- Judul Halaman -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Pengaturan Margin Penjualan</h2>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4 p-4">
                    <h3 class="fw-bold mb-3 text-center text-dark">Update Persentase Keuntungan</h3>
                    <p class="text-muted text-center mb-4">Atur persentase margin penjualan toko yang berlaku secara sistem.</p>
                    
                    <form action="margin_penjualan.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Persen Margin (%)</label>
                            <input type="number" step="0.01" name="persen" class="form-control form-control-lg" value="<?= htmlspecialchars($persen_aktif); ?>" placeholder="Contoh: 10 atau 15.5" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ID User (Admin yang Mengubah)</label>
                            <input type="number" name="iduser" class="form-control" value="<?= htmlspecialchars($iduser_aktif); ?>" placeholder="Contoh: 1" required>
                        </div>

                        <div class="mb-4 text-muted small">
                            <em>Terakhir diperbarui: <?= $updated_at; ?></em>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name="simpan" class="btn text-white fw-bold py-2 shadow-sm" style="background-color: #20B2AA; font-size: 1.1rem;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
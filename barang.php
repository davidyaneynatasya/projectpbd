<?php
include 'koneksi.php';

// Menangkap aksi dari URL (default-nya 'view' untuk menampilkan tabel)
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'view';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

// 1. PROSES SIMPAN (UNTUK TAMBAH BARU ATAU UPDATE EDIT)
if (isset($_POST['simpan'])) {
    $idbarang = $_POST['idbarang']; // Jika terisi berarti edit, kosong berarti tambah
    $jenis    = $_POST['jenis'];
    $nama     = $_POST['nama'];
    $idsatuan = $_POST['idsatuan'];
    $harga    = $_POST['harga'];

    if ($idbarang != "") {
        // Query untuk Edit / Update data barang
        $query = "UPDATE barang SET 
                    jenis = '$jenis', 
                    nama = '$nama', 
                    idsatuan = '$idsatuan', 
                    harga = '$harga' 
                  WHERE idbarang = '$idbarang'";
    } else {
        // Query untuk Tambah data barang baru (status otomatis '1')
        $query = "INSERT INTO barang (jenis, nama, idsatuan, status, harga) 
                  VALUES ('$jenis', '$nama', '$idsatuan', '1', '$harga')";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: barang.php");
        exit();
    } else {
        echo "<script>alert('Gagal memproses data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 2. PROSES HAPUS DATA BARANG
if ($aksi == 'hapus' && $id != "") {
    $query = "DELETE FROM barang WHERE idbarang = '$id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: barang.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Barang - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Memanggil Navbar / Menu Garis Tiga -->
    <?php include 'header.php'; ?>

    <!-- Judul Toko Davidya di Tengah -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Toko Davidya</h2>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">

            <?php if ($aksi == 'view'): ?>
                <!-- ================= 1. HALAMAN UTAMA: TABEL DATA BARANG ================= -->
                <div class="col-md-11">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            
                            <!-- Tombol Tambah & Judul Tabel -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0 text-dark">Data Stok Barang</h4>
                                <a href="barang.php?aksi=tambah" class="btn text-white fw-bold shadow-sm px-4" style="background-color: #20B2AA; border-radius: 6px;">
                                    + Tambah Barang
                                </a>
                            </div>

                            <!-- Tabel Data -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 10%;">ID Barang</th>
                                            <th style="width: 30%;">Nama Barang</th>
                                            <th style="width: 15%;">Jenis</th>
                                            <th style="width: 10%;">ID Satuan</th>
                                            <th style="width: 20%;">Harga</th>
                                            <th style="width: 10%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $result = mysqli_query($koneksi, "SELECT * FROM barang");
                                        while ($row = mysqli_fetch_assoc($result)) : 
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['idbarang']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['jenis']; ?></td>
                                            <td><?= $row['idsatuan']; ?></td>
                                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="barang.php?aksi=edit&id=<?= $row['idbarang']; ?>" class="btn btn-sm text-white px-3 me-1" style="background-color: #3a7bd5;">Edit</a>
                                                <a href="barang.php?aksi=hapus&id=<?= $row['idbarang']; ?>" class="btn btn-sm btn-danger px-3" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            <?php elseif ($aksi == 'tambah' || $aksi == 'edit'): ?>
                <!-- ================= 2. HALAMAN FORM: TAMBAH / EDIT BARANG ================= -->
                <?php
                $jenis_val    = "";
                $nama_val     = "";
                $idsatuan_val = "";
                $harga_val    = "";

                // Jika mode edit, ambil data lama berdasarkan ID dari URL
                if ($aksi == 'edit' && $id != "") {
                    $edit_data = mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang = '$id'");
                    $row_edit = mysqli_fetch_assoc($edit_data);
                    if ($row_edit) {
                        $jenis_val    = $row_edit['jenis'];
                        $nama_val     = $row_edit['nama'];
                        $idsatuan_val = $row_edit['idsatuan'];
                        $harga_val    = $row_edit['harga'];
                    }
                }
                ?>
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <h3 class="fw-bold mb-4 text-center text-dark">
                            <?= ($aksi == 'edit') ? 'Edit Data Barang' : 'Tambah Barang Baru'; ?>
                        </h3>
                        
                        <form action="barang.php" method="POST">
                            <!-- Input tersembunyi untuk membawa ID saat mode Edit -->
                            <input type="hidden" name="idbarang" value="<?= $id; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama_val); ?>" placeholder="Contoh: Kertas A4 80gr" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jenis</label>
                                    <input type="text" name="jenis" class="form-control" value="<?= htmlspecialchars($jenis_val); ?>" placeholder="Contoh: A" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">ID Satuan</label>
                                    <input type="number" name="idsatuan" class="form-control" value="<?= $idsatuan_val; ?>" placeholder="Contoh: 2" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="<?= $harga_val; ?>" placeholder="Contoh: 50000" required>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="barang.php" class="btn btn-secondary px-4">Kembali</a>
                                <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #20B2AA;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
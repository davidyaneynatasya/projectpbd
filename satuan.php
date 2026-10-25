<?php
include 'koneksi.php';
include 'header.php';

// Menangkap aksi dari URL (default-nya 'view' untuk menampilkan tabel)
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'view';
$idsatuan   = isset($_GET['id']) ? $_GET['id'] : '';

// 1. PROSES SIMPAN (UNTUK TAMBAH BARU ATAU UPDATE EDIT)

if (isset($_POST['simpan'])) {
    $nama_satuan = $_POST['nama_satuan'];
    $idsatuan   = $_POST['id_satuan']; // Jika terisi berarti edit, jika kosong berarti tambah

    if ($idsatuan != "") {
        // Query untuk Edit / Update data
        $query = "UPDATE satuan SET nama_satuan = '$nama_satuan' WHERE idsatuan = '$idsatuan'";
    } else {
        // Query untuk Tambah data baru
        $query = "INSERT INTO satuan (nama_satuan, status) VALUES ('$nama_satuan', '1')";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: satuan.php");
        exit();
    } else {
        echo "<script>alert('Gagal memproses data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 2. PROSES HAPUS DATA
if ($aksi == 'hapus' && $idsatuan != "") {
    $query = "DELETE FROM satuan WHERE idsatuan = '$idsatuan'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: satuan.php");
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
    <title>Manajemen Satuan - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Judul Toko Davidya di Tengah -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Toko Davidya</h2>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">

            <?php if ($aksi == 'view'): ?>
                <!-- ================= 1. HALAMAN UTAMA: TABEL DATA SATUAN ================= -->
                <div class="col-md-10">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            
                            <!-- Tombol Tambah & Judul Tabel -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0 text-dark">Data Satuan Barang</h4>
                                <a href="satuan.php?aksi=tambah" class="btn text-white fw-bold shadow-sm px-4" style="background-color: #20B2AA; border-radius: 6px;">
                                    + Tambah Satuan
                                </a>
                            </div>

                            <!-- Tabel Data -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 10%;">No</th>
                                            <th scope="col" style="width: 25%;">ID Satuan</th>
                                            <th scope="col" style="width: 45%;">Nama Satuan</th>
                                            <th scope="col" style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $result = mysqli_query($koneksi, "SELECT * FROM satuan");
                                        while ($row = mysqli_fetch_assoc($result)) : 
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['idsatuan']; ?></td>
                                            <td><?= $row['nama_satuan']; ?></td>
                                            <td class="text-center">
                                                <a href="satuan.php?aksi=edit&id=<?= $row['idsatuan']; ?>" class="btn btn-sm text-white px-3 me-1" style="background-color: #3a7bd5;">Edit</a>
                                                <a href="satuan.php?aksi=hapus&id=<?= $row['idsatuan']; ?>" class="btn btn-sm btn-danger px-3" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                <!-- ================= 2. HALAMAN FORM: TAMBAH / EDIT SATUAN ================= -->
                <?php
                $nama_satuan_val = "";
                // Jika mode edit, ambil data lama berdasarkan ID dari URL
                if ($aksi == 'edit' && $id != "") {
                    $edit_data = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan = '$id'");
                    $row_edit = mysqli_fetch_assoc($edit_data);
                    if ($row_edit) {
                        $nama_satuan_val = $row_edit['nama_satuan'];
                    }
                }
                ?>
                <div class="col-md-5">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <h3 class="fw-bold mb-4 text-center text-dark">
                            <?= ($aksi == 'edit') ? 'Edit Satuan Barang' : 'Tambah Satuan Barang'; ?>
                        </h3>
                        
                        <form action="satuan.php" method="POST">
                            <!-- Input tersembunyi untuk membawa ID saat mode Edit -->
                            <input type="hidden" name="idsatuan" value="<?= $id; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Satuan</label>
                                <input type="text" name="nama_satuan" class="form-control" value="<?= htmlspecialchars($nama_satuan_val); ?>" placeholder="Contoh: Pcs, Rim, Kg, Unit" required>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="satuan.php" class="btn btn-secondary px-4">Kembali</a>
                                <button type="submit" name="simpan" class="btn text-white px-4 fw-bold" style="background-color: #20B2AA;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Bootstrap JS Bundle (Penting untuk Dropdown / Offcanvas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
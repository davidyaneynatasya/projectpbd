<?php
include 'koneksi.php';
include 'header.php'; 

// Menangkap aksi dari URL (default-nya 'view' untuk menampilkan tabel)
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'view';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

// 1. PROSES SIMPAN (UNTUK TAMBAH BARU ATAU UPDATE EDIT)
if (isset($_POST['simpan'])) {
    $idrole    = $_POST['idrole']; // Jika terisi berarti edit, kosong berarti tambah
    $nama_role = $_POST['nama_role'];

    if ($idrole != "") {
        // Query untuk Edit / Update data role
        $query = "UPDATE role SET 
                    nama_role = '$nama_role' 
                  WHERE idrole = '$idrole'";
    } else {
        // Query untuk Tambah data role baru
        $query = "INSERT INTO role (nama_role) 
                  VALUES ('$nama_role')";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: role.php");
        exit();
    } else {
        echo "<script>alert('Gagal memproses data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 2. PROSES HAPUS DATA ROLE
if ($aksi == 'hapus' && $id != "") {
    $query = "DELETE FROM role WHERE idrole = '$id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: role.php");
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
    <title>Manajemen Role - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">


    <!-- Judul Halaman -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Manajemen Hak Akses (Role)</h2>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">

            <?php if ($aksi == 'view'): ?>
                <!-- ================= 1. HALAMAN UTAMA: TABEL DATA ROLE ================= -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            
                            <!-- Tombol Tambah & Judul Tabel -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0 text-dark">Daftar Role Pengguna</h4>
                                <a href="role.php?aksi=tambah" class="btn text-white fw-bold shadow-sm px-4" style="background-color: #20B2AA; border-radius: 6px;">
                                    + Tambah Role
                                </a>
                            </div>

                            <!-- Tabel Data -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 10%;">No</th>
                                            <th style="width: 20%;">ID Role</th>
                                            <th style="width: 50%;">Nama Role</th>
                                            <th style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $result = mysqli_query($koneksi, "SELECT * FROM role");
                                        while ($row = mysqli_fetch_assoc($result)) : 
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['idrole']; ?></td>
                                            <td><?= $row['nama_role']; ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="role.php?aksi=edit&id=<?= $row['idrole']; ?>" class="btn btn-sm text-white px-3 me-1" style="background-color: #3a7bd5;">Edit</a>
                                                <a href="role.php?aksi=hapus&id=<?= $row['idrole']; ?>" class="btn btn-sm btn-danger px-3" onclick="return confirm('Yakin ingin menghapus role ini?')">Hapus</a>
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
                <!-- ================= 2. HALAMAN FORM: TAMBAH / EDIT ROLE ================= -->
                <?php
                $nama_role_val = "";

                // Jika mode edit, ambil data lama berdasarkan ID dari URL
                if ($aksi == 'edit' && $id != "") {
                    $edit_data = mysqli_query($koneksi, "SELECT * FROM role WHERE idrole = '$id'");
                    $row_edit = mysqli_fetch_assoc($edit_data);
                    if ($row_edit) {
                        $nama_role_val = $row_edit['nama_role'];
                    }
                }
                ?>
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <h3 class="fw-bold mb-4 text-center text-dark">
                            <?= ($aksi == 'edit') ? 'Edit Data Role' : 'Tambah Role Baru'; ?>
                        </h3>
                        
                        <form action="role.php" method="POST">
                            <!-- Input tersembunyi untuk membawa ID saat mode Edit -->
                            <input type="hidden" name="idrole" value="<?= $id; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Role</label>
                                <input type="text" name="nama_role" class="form-control" value="<?= htmlspecialchars($nama_role_val); ?>" placeholder="Contoh: Admin / Kasir" required>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="role.php" class="btn btn-secondary px-4">Kembali</a>
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
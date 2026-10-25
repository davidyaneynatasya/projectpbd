<?php
include 'koneksi.php';

// Menangkap aksi dari URL (default-nya 'view' untuk menampilkan tabel)
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'view';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

// 1. PROSES SIMPAN (UNTUK TAMBAH BARU ATAU UPDATE EDIT)
if (isset($_POST['simpan'])) {
    $iduser   = $_POST['iduser']; // Jika terisi berarti edit, kosong berarti tambah
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idrole   = $_POST['idrole'];

    if ($iduser != "") {
        // Query untuk Edit / Update data user
        $query = "UPDATE user SET 
                    username = '$username', 
                    password = '$password', 
                    idrole = '$idrole' 
                  WHERE iduser = '$iduser'";
    } else {
        // Query untuk Tambah data user baru
        $query = "INSERT INTO user (username, password, idrole) 
                  VALUES ('$username', '$password', '$idrole')";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: user.php");
        exit();
    } else {
        echo "<script>alert('Gagal memproses data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 2. PROSES HAPUS DATA USER
if ($aksi == 'hapus' && $id != "") {
    $query = "DELETE FROM user WHERE iduser = '$id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: user.php");
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
    <title>Manajemen User - Toko Davidya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Memanggil Navbar / Menu Garis Tiga -->
    <?php include 'header.php'; ?>

    <!-- Judul Halaman -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Manajemen Pengguna (User)</h2>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">

            <?php if ($aksi == 'view'): ?>
                <!-- ================= 1. HALAMAN UTAMA: TABEL DATA USER ================= -->
                <div class="col-md-10">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            
                            <!-- Tombol Tambah & Judul Tabel -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0 text-dark">Daftar Akun Pengguna</h4>
                                <a href="user.php?aksi=tambah" class="btn text-white fw-bold shadow-sm px-4" style="background-color: #20B2AA; border-radius: 6px;">
                                    + Tambah User
                                </a>
                            </div>

                            <!-- Tabel Data -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 15%;">ID User</th>
                                            <th style="width: 35%;">Username</th>
                                            <th style="width: 15%;">ID Role</th>
                                            <th style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $result = mysqli_query($koneksi, "SELECT * FROM user");
                                        while ($row = mysqli_fetch_assoc($result)) : 
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['iduser']; ?></td>
                                            <td><?= $row['username']; ?></td>
                                            <td><?= $row['idrole']; ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="user.php?aksi=edit&id=<?= $row['iduser']; ?>" class="btn btn-sm text-white px-3 me-1" style="background-color: #3a7bd5;">Edit</a>
                                                <a href="user.php?aksi=hapus&id=<?= $row['iduser']; ?>" class="btn btn-sm btn-danger px-3" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
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
                <!-- ================= 2. HALAMAN FORM: TAMBAH / EDIT USER ================= -->
                <?php
                $username_val = "";
                $password_val = "";
                $idrole_val   = "";

                // Jika mode edit, ambil data lama berdasarkan ID dari URL
                if ($aksi == 'edit' && $id != "") {
                    $edit_data = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser = '$id'");
                    $row_edit = mysqli_fetch_assoc($edit_data);
                    if ($row_edit) {
                        $username_val = $row_edit['username'];
                        $password_val = $row_edit['password'];
                        $idrole_val   = $row_edit['idrole'];
                    }
                }
                ?>
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 p-4">
                        <h3 class="fw-bold mb-4 text-center text-dark">
                            <?= ($aksi == 'edit') ? 'Edit Data User' : 'Tambah User Baru'; ?>
                        </h3>
                        
                        <form action="user.php" method="POST">
                            <!-- Input tersembunyi untuk membawa ID saat mode Edit -->
                            <input type="hidden" name="iduser" value="<?= $id; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username_val); ?>" placeholder="Contoh: admin" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($password_val); ?>" placeholder="Masukkan password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">ID Role</label>
                                <input type="number" name="idrole" class="form-control" value="<?= $idrole_val; ?>" placeholder="Contoh: 1" required>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="user.php" class="btn btn-secondary px-4">Kembali</a>
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
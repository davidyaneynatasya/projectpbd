<?php
include 'koneksi.php';
include 'header.php';
// Query untuk mengambil data dari tabel satuan
$query = "SELECT * FROM vendor";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Satuan - Toko Davidya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to bottom, #0052D4, #4364F7, #6FB1FC); min-height: 100vh; background-attachment: fixed;">

    <!-- Judul Toko Davidya di tengah -->
    <div class="text-center my-4">
        <h2 class="fw-bold text-white">Toko Davidya</h2>
    </div>

    <div class="container pb-5">
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body p-4">
                
                <!-- Tombol Tambah Satuan di Kanan -->
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <a href="tambah_satuan.php" class="btn text-white fw-bold shadow-sm px-4" style="background-color: #20B2AA; border-radius: 6px;">
                        + Tambah Satuan
                    </a>
                </div>

                <!-- Tabel Data Satuan -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 10%;">No</th>
                                <th scope="col" style="width: 25%;">ID vendor</th>
                                <th scope="col" style="width: 45%;">Nama vendor</th>
                                <th scope="col" style="width: 45%;">Badan Hukum</th>
                                <th scope="col" style="width: 20%;" class="text-center">status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) : 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['idvendor']; ?></td>
                                <td><?= $row['nama_vendor']; ?></td>
                                <td><?= $row['badan_hukum']; ?></td>
                                <td class="text-center text-nowrap">
                                    <a href="edit_vendor.php?id=<?= $row['idvendor']; ?>" class="btn btn-sm text-white px-3 me-1" style="background-color: #3a7bd5;">Edit</a>
                                    <a href="hapus_vendor.php?id=<?= $row['idvendor']; ?>" class="btn btn-sm btn-danger px-3" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
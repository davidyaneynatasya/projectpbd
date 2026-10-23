<?php
include 'koneksi.php';
include 'header.php';
?>

<!-- Container Utama dengan Card berpenampilan rapi -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0" style="background-color: #ffffff; border-radius: 10px;">
            <div class="card-body">
                
                <!-- Judul dan Tombol Tambah -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold" style="color: #333333;">Data Barang</h3>
                    <!-- Tombol dengan warna kustom (contoh: hijau mint / #20B2AA) -->
                    <a href="tambah.php" class="btn text-white fw-bold shadow-sm" style="background-color: #20B2AA; border-radius: 6px;">
                        + Tambah Barang
                    </a>
                </div>

                <hr style="border-color: #e0e0e0;">

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <!-- Header Tabel dengan warna kustom -->
                        <thead style="background-color: #6495ED; color: #ffffff;">
                            <tr>
                                <th class="py-3 px-3">No</th>
                                <th class="py-3">id barang</th>
                                <th class="py-3">jenis</th>
                                <th class="py-3">nama</th>
                                <th class="py-3">id satuan</th>
                                <th class="py-3">status</th>
                                <th class="py-3 text-center">harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data dari database (tabel barang)
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM barang");
                            
                            // Cek jika data kosong
                            if (mysqli_num_rows($query) > 0) {
                                while ($data = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                    <td class="px-3"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data['idbarang']); ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($data['jenis']); ?></td>
                                    <td><span class="badge" style="background-color: #e9ecef; color: #495057;"><?= htmlspecialchars($data['nama']); ?></span></td>
                                    <td>Rp <?= number_format($data['idsatuan'], 0, ',', '.'); ?></td>
                                    <td><?= $data['status']; ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Edit -->
                                        <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-sm text-white px-2 py-1" style="background-color: #FFA500;" title="Edit">
                                            Edit
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <a href="hapus.php?id=<?= $data['id']; ?>" class="btn btn-sm text-white px-2 py-1" style="background-color: #DC3545;" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data barang yang tersimpan.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
// Panggil footer
include 'footer.php'; 
?>
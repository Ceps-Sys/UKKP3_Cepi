<?php
$ID_PENGADUAN = $_GET['id'];

// Ambil detail pengaduan spesifik
$query_detail = "SELECT p.*, m.nama, m.telp FROM tbl_pengaduan p 
                 JOIN tbl_masyarakat m ON p.nik = m.nik 
                 WHERE p.id_pengaduan = '$ID_PENGADUAN'";
$detail = tampil($query_detail)[0];

if (isset($_POST['SimpanTanggapan'])) {
    if (berikan_tanggapan($_POST) > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ icon: 'success', title: 'Tanggapan Tersimpan', confirmButtonColor: '#435ebe' })
                .then(function() { window.location.href = '?pages=data_pengaduan'; });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tanggapan gagal disimpan!', confirmButtonColor: '#435ebe' });
            });
        </script>";
    }
}
?>

<div class="page-heading">
    <h3>Review Pengaduan</h3>
    <p class="text-subtitle text-muted">Detail keluhan dari <?= $detail['nama']; ?></p>
</div>

<div class="page-content">
    <section class="row">
        <!-- Data Keluhan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Bukti Laporan</h4></div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <?php if (!empty($detail['foto'])) : ?>
                            <img src="../images/pengaduan/<?= $detail['foto']; ?>" alt="Bukti" class="img-fluid rounded border" style="max-height: 250px;">
                        <?php else : ?>
                            <p class="text-danger"><i>Tidak ada foto bukti.</i></p>
                        <?php endif; ?>
                    </div>
                    <p><strong>NIK:</strong> <?= $detail['nik']; ?></p>
                    <p><strong>Tanggal:</strong> <?= date('d-m-Y', strtotime($detail['tgl_pengaduan'])); ?></p>
                    <p><strong>Laporan:</strong><br><?= $detail['isi_laporan']; ?></p>
                </div>
            </div>
        </div>

        <!-- Form Tanggapan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Beri Tanggapan</h4></div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id_pengaduan" value="<?= $detail['id_pengaduan']; ?>">
                        
                        <div class="form-group mb-3">
                            <label>Status Laporan</label>
                            <select class="form-select" name="status" required>
                                <option value="0" <?= ($detail['status'] == '0') ? 'selected' : ''; ?>>Belum Diproses</option>
                                <option value="proses" <?= ($detail['status'] == 'proses') ? 'selected' : ''; ?>>Proses (Sedang dikerjakan)</option>
                                <option value="selesai" <?= ($detail['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Isi Tanggapan (Balasan)</label>
                            <textarea class="form-control" name="tanggapan" rows="5" required></textarea>
                        </div>
                        <button type="submit" name="SimpanTanggapan" class="btn btn-primary">Simpan Tanggapan</button>
                        <a href="?pages=data_pengaduan" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
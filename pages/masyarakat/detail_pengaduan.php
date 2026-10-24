<?php
// Pastikan hanya masyarakat yang bisa mengakses
if ($_SESSION['role'] !== 'masyarakat') {
    echo "<script>window.location.href='?pages=dashboard_masyarakat';</script>";
    exit;
}

$id_pengaduan = $_GET['id'] ?? '';
$nik = $_SESSION['nik'];

// Ambil data pengaduan milik warga yang bersangkutan
$query_cek = "SELECT * FROM tbl_pengaduan WHERE id_pengaduan = '$id_pengaduan' AND nik = '$nik'";
$cek_data = tampil($query_cek);

if (empty($cek_data)) {
    echo "<script>alert('Data tidak ditemukan atau bukan milik Anda!'); window.location.href='?pages=dashboard_masyarakat';</script>";
    exit;
}
$pengaduan = $cek_data[0];

// Ambil data tanggapan dari petugas (jika ada)
$query_tanggapan = "SELECT t.*, p.nama_petugas FROM tbl_tanggapan t 
                    JOIN tbl_petugas p ON t.id_petugas = p.id_petugas 
                    WHERE t.id_pengaduan = '$id_pengaduan'";
$tanggapan = tampil($query_tanggapan);
?>

<div class="page-heading">
    <h3>Detail Laporan & Tanggapan</h3>
    <p class="text-subtitle text-muted">Lihat status dan respons petugas terhadap laporan Anda.</p>
</div>

<div class="page-content">
    <section class="row">
        <!-- Informasi Laporan Warga -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Laporan Anda</h4></div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <?php if (!empty($pengaduan['foto'])) : ?>
                            <img src="../images/pengaduan/<?= $pengaduan['foto']; ?>" alt="Bukti" class="img-fluid rounded border" style="max-height: 250px;">
                        <?php else : ?>
                            <p class="text-danger"><i>Tidak ada foto bukti.</i></p>
                        <?php endif; ?>
                    </div>
                    <p><strong>Tanggal Lapor:</strong> <?= date('d-m-Y', strtotime($pengaduan['tgl_pengaduan'])); ?></p>
                    <p><strong>Status:</strong> 
                        <?php 
                        if ($pengaduan['status'] == '0') echo '<span class="badge bg-danger">Belum Diproses</span>';
                        elseif ($pengaduan['status'] == 'proses') echo '<span class="badge bg-warning">Sedang Diproses</span>';
                        else echo '<span class="badge bg-success">Selesai</span>';
                        ?>
                    </p>
                    <p><strong>Isi Laporan:</strong><br><?= $pengaduan['isi_laporan']; ?></p>
                </div>
            </div>
        </div>

        <!-- Tanggapan dari Petugas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Respon Petugas</h4></div>
                <div class="card-body">
                    <?php if (empty($tanggapan)) : ?>
                        <div class="alert alert-light-secondary color-secondary">
                            <i class="bi bi-info-circle"></i> Laporan Anda belum ditanggapi oleh petugas. Silakan cek secara berkala.
                        </div>
                    <?php else : ?>
                        <?php foreach ($tanggapan as $resp) : ?>
                            <div class="border-bottom pb-3 mb-3">
                                <p class="mb-1"><strong>Petugas:</strong> <?= $resp['nama_petugas']; ?></p>
                                <p class="mb-1 text-muted small"><i class="bi bi-calendar"></i> Tanggal Tanggapan: <?= date('d-m-Y', strtotime($resp['tgl_tanggapan'])); ?></p>
                                <div class="alert alert-light-primary mt-2">
                                    <strong>Isi Tanggapan:</strong><br>
                                    <?= $resp['tanggapan']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="mt-4">
                        <a href="?pages=dashboard_masyarakat" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
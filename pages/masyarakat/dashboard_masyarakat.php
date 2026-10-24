<?php
// Pastikan hanya masyarakat yang bisa akses, atau berikan nilai default jika kosong
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'masyarakat') {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}

$NIK = $_SESSION['nik'] ?? '-';
$NAMA = $_SESSION['nama'] ?? 'Warga';

// Mengambil data pengaduan khusus milik user
$riwayat_pengaduan = tampil("SELECT * FROM tbl_pengaduan WHERE nik = '$NIK' ORDER BY tgl_pengaduan DESC");
?>

<div class="page-heading">
    <h3>Selamat Datang, <?= $NAMA; ?>!</h3>
    <p class="text-subtitle text-muted">Pantau riwayat pengaduan Anda di sini.</p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Riwayat Pengaduan</h5>
                <a href="?pages=buat_pengaduan" class="btn btn-primary"><i class="bi bi-plus"></i> Buat Laporan</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Isi Laporan</th>
            <th>Foto Bukti</th>
            <th>Status</th>
            <th>Aksi</th> 
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach ($riwayat_pengaduan as $row) : ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])); ?></td>
            <td><?= substr($row['isi_laporan'], 0, 40); ?>...</td>
            <td>
                <?php if (!empty($row['foto'])) : ?>
                    <img src="../images/pengaduan/<?= $row['foto']; ?>" alt="Bukti" width="80" class="rounded">
                <?php else : ?>
                    <span class="badge bg-secondary">Tidak ada foto</span>
                <?php endif; ?>
            </td>
            <td>
                <?php 
                if ($row['status'] == '0') echo '<span class="badge bg-danger">Belum Diproses</span>';
                elseif ($row['status'] == 'proses') echo '<span class="badge bg-warning">Sedang Diproses</span>';
                else echo '<span class="badge bg-success">Selesai</span>';
                ?>
            </td>
            <td>
                <!-- Tombol untuk melihat respons tanggapan petugas -->
                <a href="?pages=detail_pengaduan&id=<?= $row['id_pengaduan']; ?>" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> Lihat Respon
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            </div>
        </div>
    </section>
</div>
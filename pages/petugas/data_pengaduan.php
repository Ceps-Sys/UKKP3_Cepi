<?php
// Mengambil data pengaduan digabung dengan data masyarakat berdasarkan NIK
$query = "SELECT p.*, m.nama FROM tbl_pengaduan p 
          JOIN tbl_masyarakat m ON p.nik = m.nik 
          ORDER BY p.tgl_pengaduan DESC";
$semua_pengaduan = tampil($query);
?>

<div class="page-heading">
    <h3>Data Pengaduan Masuk</h3>
    <p class="text-subtitle text-muted">Daftar seluruh laporan keluhan dari masyarakat.</p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Tabel Pengaduan</h5>
                <!-- Tombol Cetak (Membuka tab baru ke file cetak) -->
                <a href="../pages/petugas/cetak.php" target="_blank" class="btn btn-danger">
                    <i class="bi bi-printer"></i> Cetak Laporan PDF
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($semua_pengaduan as$row) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])); ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= substr($row['isi_laporan'], 0, 40); ?>...</td>
                            <td>
                                <?php if ($row['status'] == '0') : ?>
                                    <span class="badge bg-danger">Belum Diproses</span>
                                <?php elseif ($row['status'] == 'proses') : ?>
                                    <span class="badge bg-warning">Proses</span>
                                <?php else : ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?pages=tanggapan&id=<?= $row['id_pengaduan']; ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-chat-dots"></i> Review
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
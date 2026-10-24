<?php
// Hanya admin yang boleh mengakses
if ($_SESSION['role'] !== 'admin') {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}
$data_masyarakat = tampil("SELECT * FROM tbl_masyarakat");
?>
<div class="page-heading">
    <h3>Data Masyarakat</h3>
    <p class="text-subtitle text-muted">Daftar seluruh warga yang terdaftar sebagai pelapor.</p>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dapat Dilihat & Dipantau oleh Admin</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>No. Telp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_masyarakat as $row) : ?>
                        <tr>
                            <td><?= $row['nik'] ?? '-'; ?></td>
                            <td><?= $row['nama'] ?? '-'; ?></td>
                            <td><?= $row['username'] ?? '-'; ?></td>
                            <!-- Menggunakan pengecekan ganda 'telp' atau 'telepon' agar tidak error -->
                            <td><?= $row['telp'] ?? $row['telepon'] ?? '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
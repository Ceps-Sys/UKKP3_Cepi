<?php
if ($_SESSION['role'] !== 'admin') {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}

// Proses Hapus Data
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    if (hapus_petugas($id) > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({icon: 'success', title: 'Terhapus!', text: 'Data petugas berhasil dihapus.'})
                .then(function() { window.location.href = '?pages=data_petugas'; });
            });
        </script>";
    }
}

$data_petugas = tampil("SELECT * FROM tbl_petugas");
?>
<div class="page-heading">
    <h3>Data Petugas & Admin</h3>
    <p class="text-subtitle text-muted">Kelola akun petugas dan administrator sistem.</p>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Petugas Terdaftar</h4>
                <a href="?pages=tambah_petugas" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Petugas</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>No. Telp</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($data_petugas as $row) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['nama_petugas']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['telepon'] ?? '-'; ?></td>
                            <td><span class="badge bg-primary"><?= strtoupper($row['level']); ?></span></td>
                            <td>
                                <a href="?pages=edit_petugas&id=<?= $row['id_petugas']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="?pages=data_petugas&aksi=hapus&id=<?= $row['id_petugas']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus petugas ini?')"><i class="bi bi-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
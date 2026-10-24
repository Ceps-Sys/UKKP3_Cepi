<?php
if ($_SESSION['role'] !== 'admin') {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}

$id = $_GET['id'];
$petugas = tampil("SELECT * FROM tbl_petugas WHERE id_petugas = '$id'")[0];

if (isset($_POST['Update'])) {
    if (ubah_petugas($_POST) > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({icon: 'success', title: 'Berhasil', text: 'Data petugas berhasil diperbarui!'})
                .then(function() { window.location.href = '?pages=data_petugas'; });
            });
        </script>";
    }
}
?>
<div class="page-heading">
    <h3>Edit Data Petugas</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" name="id_petugas" value="<?= $petugas['id_petugas']; ?>">
                    <div class="form-group mb-3">
                        <label>Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" value="<?= $petugas['nama_petugas']; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $petugas['username']; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= $petugas['telepon']; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Level Akses</label>
                        <select name="level" class="form-select" required>
                            <option value="petugas" <?= ($petugas['level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                            <option value="admin" <?= ($petugas['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="Update" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="?pages=data_petugas" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
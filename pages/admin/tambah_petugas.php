<?php
if ($_SESSION['role'] !== 'admin') {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}

if (isset($_POST['Simpan'])) {
    if (tambah_petugas($_POST)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({icon: 'success', title: 'Berhasil', text: 'Petugas baru berhasil ditambahkan!'})
                .then(function() { window.location.href = '?pages=data_petugas'; });
            });
        </script>";
    }
}
?>
<div class="page-heading">
    <h3>Tambah Petugas Baru</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group mb-3">
                        <label>Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Level Akses</label>
                        <select name="level" class="form-select" required>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="Simpan" class="btn btn-primary">Simpan Petugas</button>
                    <a href="?pages=data_petugas" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
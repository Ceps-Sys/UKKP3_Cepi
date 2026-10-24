<?php
if (isset($_POST['Kirim'])) {
    if (tambah_pengaduan($_POST, $_FILES) > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success', title: 'Berhasil', text: 'Laporan Anda berhasil dikirim!', confirmButtonColor: '#435ebe'
                }).then(function() { window.location.href = '?pages=dashboard_masyarakat'; });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Laporan gagal dikirim!', confirmButtonColor: '#435ebe' });
            });
        </script>";
    }
}
?>

<div class="page-heading">
    <h3>Tulis Laporan Pengaduan</h3>
    <p class="text-subtitle text-muted">Sampaikan keluhan Anda dengan jelas beserta bukti foto.</p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="isi_laporan" class="form-label">Isi Laporan</label>
                        <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="5" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="foto" class="form-label">Upload Foto Bukti</label>
                        <input class="form-control" type="file" id="foto" name="foto" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="Kirim" class="btn btn-primary"><i class="bi bi-send"></i> Kirim Laporan</button>
                        <a href="?pages=dashboard_masyarakat" class="btn btn-light-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
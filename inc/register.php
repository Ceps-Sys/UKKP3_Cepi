<?php
session_start();
require_once 'function.php';

// Cek session[cite: 6]
if (isset($_SESSION['role'])) {
    header("location: dashboard_masyarakat.php");
    exit;
} 

if (isset($_POST["Registrasi"])) { // Mengirim formulir registrasi[cite: 6]
    if (registrasi($_POST) > 0) { // Memanggil fungsi registrasi[cite: 6]
        // Alert dipindah ke dalam function.php
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Pengaduan Masyarakat</title>
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/auth.css">
</head>
<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <h1 class="auth-title">Daftar.</h1>
                    <p class="auth-subtitle mb-5">Masukkan data diri Anda untuk membuat akun pelapor.</p>

                    <form action="" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nik" class="form-control form-control-xl" placeholder="NIK (16 Digit)" maxlength="16" required>
                            <div class="form-control-icon"><i class="bi bi-card-text"></i></div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nama" class="form-control form-control-xl" placeholder="Nama Lengkap" required>
                            <div class="form-control-icon"><i class="bi bi-person-badge"></i></div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" required>
                            <div class="form-control-icon"><i class="bi bi-person"></i></div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="telp" class="form-control form-control-xl" placeholder="Nomor Telepon" required>
                            <div class="form-control-icon"><i class="bi bi-telephone"></i></div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="confirm_password" class="form-control form-control-xl" placeholder="Confirm Password" required>
                            <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="Registrasi">Daftar</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Sudah punya akun? <a href="login.php" class="font-bold">Log in</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
    <script src="../assets/extensions/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>
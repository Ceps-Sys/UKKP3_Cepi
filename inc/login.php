<?php
session_start();
require_once 'function.php';

// Cek jika sudah login, arahkan ke dashboard masing-masing
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'masyarakat') {
        header("location: ../pages/index.php?pages=dashboard_masyarakat");
        exit; 
    } elseif ($_SESSION['role'] == 'petugas' || $_SESSION['role'] == 'admin') {
        header("location: ../pages/index.php?pages=dashboard");
        exit; 
    }
}

if (isset($_POST['Login'])) {
    $USERNAME = mysqli_real_escape_string($KONEKSI, $_POST['username']);
    $PASSWORD = $_POST['password'];

    // Cek di tabel masyarakat
    $cek_masyarakat = mysqli_query($KONEKSI, "SELECT * FROM tbl_masyarakat WHERE username = '$USERNAME'");
    if (mysqli_num_rows($cek_masyarakat) === 1) {
        $row = mysqli_fetch_assoc($cek_masyarakat);
        if (password_verify($PASSWORD, $row['password'])) {
            $_SESSION['nik'] = $row['nik'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = 'masyarakat';
            header("location: ../pages/index.php?pages=dashboard_masyarakat");
            exit;
        }
    }

    // Cek di tabel petugas
    $cek_petugas = mysqli_query($KONEKSI, "SELECT * FROM tbl_petugas WHERE username = '$USERNAME'");
    if (mysqli_num_rows($cek_petugas) === 1) {
        $row = mysqli_fetch_assoc($cek_petugas);
        if (password_verify($PASSWORD, $row['password'])) {
            $_SESSION['id_petugas'] = $row['id_petugas'];
            $_SESSION['nama_petugas'] = $row['nama_petugas'];
            $_SESSION['level'] = $row['level']; 
            
            // SERAGAMKAN MENJADI HURUF KECIL AGAR TIDAK BERUBAH SAAT RELOAD
            $_SESSION['role'] = strtolower($row['level']); // Menghasilkan 'admin' atau 'petugas'
            
            header("location: ../pages/index.php?pages=dashboard");
            exit;
        }
    }

    // Jika gagal
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: 'Username atau Password salah!',
            confirmButtonColor: '#435ebe'
        }).then(function() {
            window.location.href = 'login.php';
        });
    });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Masyarakat</title>
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
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Masukan akun Anda untuk masuk ke sistem pengaduan.</p>

                    <form action="" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" name="Login" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Belum punya akun? <a href="register.php" class="font-bold">Daftar Warga</a>.</p>
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
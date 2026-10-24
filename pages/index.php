<?php
session_start();
require_once '../inc/function.php'; // <-- TAMBAHKAN BARIS INI
// Proteksi jika belum login, tendang kembali ke halaman login
if (!isset($_SESSION['role'])) {
    header("Location: ../inc/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Masyarakat</title>
    
    <!-- CSS Template Mazer -->
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    
    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" crossorigin href="../assets/extensions/sweetalert2/sweetalert2.min.css">
</head>
<body>
    <script src="../assets/static/js/initTheme.js"></script>
    
    <div id="app">
        <!-- 1. Panggil Sidebar Dinamis -->
        <?php include '../inc/sidebar.php'; ?>
        
        <div id="main">
            <!-- Header Toggle (Untuk tampilan HP/Mobile) -->
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            <!-- 2. Area Konten Dinamis (Dipanggil melalui sistem routing menu.php) -->
            <?php include '../inc/menu.php'; ?>
            
            <!-- 3. Footer Aplikasi -->
            <footer>
                <div class="footer clearfix mb-0 text-muted mt-5">
                    <div class="float-start">
                        <p>2026 &copy; Uji Kompetensi Keahlian RPL</p>
                    </div>
                    <div class="float-end">
                        <p>Dibuat dengan <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> untuk Serkom</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Tambahkan script dark.js ini -->
    <script src="../assets/static/js/components/dark.js"></script>
    
    <!-- Script bawaan yang sudah ada -->
    <script src="../assets/compiled/js/app.js"></script>
    <script src="../assets/extensions/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>
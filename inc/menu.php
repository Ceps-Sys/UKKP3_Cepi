<?php 
// inc/menu.php
$PAGE = $_GET['pages'] ?? 'dashboard';

switch ($PAGE) {
    // ==========================================
    // 1. MODUL MASYARAKAT
    // ==========================================
    case 'dashboard_masyarakat':
        $PATH = __DIR__ . '/../pages/masyarakat/dashboard_masyarakat.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'buat_pengaduan':
        $PATH = __DIR__ . '/../pages/masyarakat/buat_pengaduan.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'detail_pengaduan':
        $PATH = __DIR__ . '/../pages/masyarakat/detail_pengaduan.php';
        if (file_exists($PATH)) include $PATH;
        break;

    // ==========================================
    // 2. MODUL PETUGAS & ADMIN
    // ==========================================
    case 'data_pengaduan':
        $PATH = __DIR__ . '/../pages/petugas/data_pengaduan.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'tanggapan':
        $PATH = __DIR__ . '/../pages/petugas/tanggapan.php';
        if (file_exists($PATH)) include $PATH;
        break;

    // ==========================================
    // 3. DASHBOARD DEFAULT ADMIN/PETUGAS
    // ==========================================
    case 'dashboard':
    default:
        $PATH = __DIR__ . '/../pages/dashboard.php';
        if (file_exists($PATH)) include $PATH;
        break;

    // ==========================================
    // 4. MODUL MASTER DATA (KHUSUS ADMIN)
    // ==========================================
    case 'data_petugas':
        $PATH = __DIR__ . '/../pages/admin/data_petugas.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'data_masyarakat':
        $PATH = __DIR__ . '/../pages/admin/data_masyarakat.php';
        if (file_exists($PATH)) include $PATH;
        break;

        case 'tambah_petugas':
        $PATH = __DIR__ . '/../pages/admin/tambah_petugas.php';
        if (file_exists($PATH)) include $PATH;
        break;

    case 'edit_petugas':
        $PATH = __DIR__ . '/../pages/admin/edit_petugas.php';
        if (file_exists($PATH)) include $PATH;
        break;
}
?>
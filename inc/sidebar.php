<?php
$role = strtolower(trim($_SESSION['role'] ?? ''));
$page = $_GET['pages'] ?? 'dashboard'; 
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="?pages=<?= ($role == 'masyarakat') ? 'dashboard_masyarakat' : 'dashboard' ?>">
                        <i class="bi bi-megaphone-fill"></i> SUARA
                        <i class="bi bi-mic-fill">WARGA</i> 
                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path><g transform="translate(-210 -1)"><path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path><circle cx="220.5" cy="11.5" r="4"></circle><path d="M214 11.5h2m13 0h2m-13 7.5l-1.5-1.5m14.5 1.5l-1.5-1.5"></path></g></g></svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Utama</li>

                <!-- 1. MENU MASYARAKAT -->
                <?php if ($role == 'masyarakat') : ?>
                    <li class="sidebar-item <?= ($page == 'dashboard_masyarakat') ? 'active' : '' ?>">
                        <a href="?pages=dashboard_masyarakat" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard Warga</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= ($page == 'buat_pengaduan') ? 'active' : '' ?>">
                        <a href="?pages=buat_pengaduan" class='sidebar-link'>
                            <i class="bi bi-pen-fill"></i>
                            <span>Buat Laporan</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- 2. MENU PETUGAS -->
                <?php if ($role == 'petugas') : ?>
                    <li class="sidebar-item <?= ($page == 'dashboard' || $page == '') ? 'active' : '' ?>">
                        <a href="?pages=dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard Petugas</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= ($page == 'data_pengaduan' || $page == 'tanggapan') ? 'active' : '' ?>">
                        <a href="?pages=data_pengaduan" class='sidebar-link'>
                            <i class="bi bi-inbox-fill"></i>
                            <span>Validasi & Tanggapan</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- 3. MENU ADMIN (Punya Hak Akses Penuh + Master Data) -->
                <?php if ($role == 'admin') : ?>
                    <li class="sidebar-item <?= ($page == 'dashboard' || $page == '') ? 'active' : '' ?>">
                        <a href="?pages=dashboard" class='sidebar-link'>
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= ($page == 'data_pengaduan' || $page == 'tanggapan') ? 'active' : '' ?>">
                        <a href="?pages=data_pengaduan" class='sidebar-link'>
                            <i class="bi bi-inbox-fill"></i>
                            <span>Data Laporan Masuk</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Master Data & Manajemen</li>
                    <li class="sidebar-item <?= ($page == 'data_petugas') ? 'active' : '' ?>">
                        <a href="?pages=data_petugas" class='sidebar-link'>
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Kelola Petugas</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= ($page == 'data_masyarakat') ? 'active' : '' ?>">
                        <a href="?pages=data_masyarakat" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Data Masyarakat</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- MENU SISTEM (BERLAKU SEMUA) -->
                <li class="sidebar-title">Sistem</li>
                <li class="sidebar-item">
                    <a href="../inc/logout.php" class='sidebar-link text-danger'>
                        <i class="bi bi-box-arrow-left text-danger"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
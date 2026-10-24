<?php
session_start();
// Pastikan path ini benar mengarah ke folder inc
require_once '../../inc/function.php'; 

// Proteksi: Hanya admin atau petugas yang boleh mencetak
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    die("Akses Ditolak! Anda tidak memiliki izin untuk melihat halaman ini.");
}

// Mengambil semua data pengaduan digabung dengan data pelapor
$query = "SELECT p.*, m.nama FROM tbl_pengaduan p 
          JOIN tbl_masyarakat m ON p.nik = m.nik 
          ORDER BY p.tgl_pengaduan DESC";
$data = tampil($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengaduan</title>
    <!-- Menggunakan Bootstrap 5 untuk merapikan tabel saat diprint -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: black;
        }
        /* Class no-print untuk menyembunyikan tombol saat kertas diprint */
        @media print {
            .no-print { display: none !important; }
        }
        .kop-surat {
            border-bottom: 3px solid black;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
    </style>
</head>
<!-- onload="window.print()" akan otomatis memunculkan dialog print saat halaman dibuka -->
<body onload="window.print()">
    <div class="container mt-4">
        
        <!-- Kop Surat -->
        <div class="text-center kop-surat">
            <h3 class="mb-1 fw-bold">PEMERINTAH KABUPATEN BANDUNG</h3>
            <h4 class="mb-1 fw-bold">SISTEM INFORMASI PENGADUAN MASYARAKAT</h4>
            <p class="mb-0">Jl. Raya Bandung, Jawa Barat</p>
        </div>
        
        <h5 class="text-center mb-4 fw-bold text-decoration-underline">REKAPITULASI DATA PENGADUAN</h5>
        
        <!-- Tabel Data -->
        <table class="table table-bordered border-dark">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">NIK</th>
                    <th width="20%">Nama Pelapor</th>
                    <th width="35%">Isi Laporan</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1; 
                if (empty($data)) {
                    echo "<tr><td colspan='6' class='text-center'>Belum ada data laporan masuk.</td></tr>";
                } else {
                    foreach ($data as $row) : 
                ?>
                <tr>
                    <td class="text-center"><?= $i++; ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])); ?></td>
                    <td class="text-center"><?= $row['nik']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['isi_laporan']; ?></td>
                    <td class="text-center">
                        <?php 
                            if ($row['status'] == '0') echo 'Belum Diproses';
                            elseif ($row['status'] == 'proses') echo 'Proses';
                            else echo 'Selesai';
                        ?>
                    </td>
                </tr>
                <?php 
                    endforeach; 
                }
                ?>
            </tbody>
        </table>
        
        <!-- Bagian Tanda Tangan -->
        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-0">Bandung, <?= date('d F Y'); ?></p>
                <p class="mb-5">Admin / Petugas,</p>
                <br><br>
                <p class="fw-bold mb-0 text-decoration-underline">
                    <?= isset($_SESSION['nama_petugas']) ? $_SESSION['nama_petugas'] : 'Administrator'; ?>
                </p>
            </div>
        </div>

        <!-- Tombol Aksi (Akan hilang saat diprint karena class no-print) -->
        <div class="no-print mt-5 text-center">
            <button onclick="window.print()" class="btn btn-primary me-2">Cetak Sekarang</button>
            <button onclick="window.close()" class="btn btn-secondary">Tutup Tab</button>
        </div>
        
    </div>
</body>
</html>
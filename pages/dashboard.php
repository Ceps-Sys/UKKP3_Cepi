<?php
// pages/dashboard.php

// Ambil statistik jumlah data
$total_laporan = mysqli_num_rows(mysqli_query($KONEKSI, "SELECT * FROM tbl_pengaduan"));
$belum_proses = mysqli_num_rows(mysqli_query($KONEKSI, "SELECT * FROM tbl_pengaduan WHERE status='0'"));
$sedang_proses = mysqli_num_rows(mysqli_query($KONEKSI, "SELECT * FROM tbl_pengaduan WHERE status='proses'"));
$selesai = mysqli_num_rows(mysqli_query($KONEKSI, "SELECT * FROM tbl_pengaduan WHERE status='selesai'"));
?>

<div class="page-heading">
    <h3>Dashboard Petugas</h3>
    <p class="text-subtitle text-muted">Ringkasan data sistem pengaduan masyarakat.</p>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <!-- Card Total Laporan -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi bi-folder2-open"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Laporan</h6>
                                    <h6 class="font-extrabold mb-0"><?= $total_laporan; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Belum Diproses -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-x-circle"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Belum Diproses</h6>
                                    <h6 class="font-extrabold mb-0"><?= $belum_proses; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Sedang Diproses -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon orange mb-2">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Sedang Diproses</h6>
                                    <h6 class="font-extrabold mb-0"><?= $sedang_proses; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Selesai -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Selesai</h6>
                                    <h6 class="font-extrabold mb-0"><?= $selesai; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
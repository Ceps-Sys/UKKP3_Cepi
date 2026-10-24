<?php
session_start(); // Memulai koneksi ke sesi aktif[cite: 4]
$_SESSION = []; // Mengosongkan seluruh data variabel array sesi[cite: 4]
session_unset(); // Menghapus seluruh variabel sesi yang terdaftar[cite: 4]
session_destroy(); // Menghancurkan secara permanen data sesi[cite: 4]
header("location: login.php"); // Mengarahkan kembali ke halaman login[cite: 4]
exit; // Menghentikan eksekusi[cite: 4]
?>
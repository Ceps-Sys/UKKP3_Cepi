<?php
//+=+=========================================+=+
// Aplikasi Pengaduan Masyarakat
// File fungsi utama yang disesuaikan dari base Bank Mini
//+=+=========================================+=+

//+=+=========================================+=+
// 1. PENGATURAN WAKTU APLIKASI
//+=+=========================================+=+

// Mengatur zona waktu standar aplikasi ke WIB (Asia/Jakarta)
date_default_timezone_set('Asia/Jakarta');
// Menyimpan format tanggal dan waktu saat ini (YYYY-MM-DD HH:MM:SS) ke variabel global
$WAKTU_SEKARANG = date('Y-m-d H:i:s');


//+=+=========================================+=+
// 2. KONEKSI DATABASE
//+=+=========================================+=+

// Menentukan konfigurasi server dan database
$SERVERNAME = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DBNAME = "db_pengaduan"; // Disesuaikan dengan nama database baru

// Membuka koneksi baru ke server database MySQL menggunakan driver mysqli
$KONEKSI = mysqli_connect($SERVERNAME, $USERNAME, $PASSWORD, $DBNAME);

// Memeriksa apakah koneksi database gagal terhubung[cite: 2]
if (!$KONEKSI) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


//+=+=========================================+=+
// 3. FUNGSI TAMPIL DATA (QUERY SELECT)
//+=+=========================================+=+

/**
 * Mengambil kumpulan data dari database berdasarkan string query SQL yang diberikan.[cite: 2]
 */
function tampil($QUERY_STRING)
{
    global $KONEKSI; 

    $QUERY = mysqli_query($KONEKSI, $QUERY_STRING) or die('Error: ' . mysqli_error($KONEKSI));
    $HASIL_DATA = []; 

    while ($ROW = mysqli_fetch_assoc($QUERY)) {
        $HASIL_DATA[] = $ROW; 
    }

    return $HASIL_DATA; 
}


//+=+=========================================+=+
// 4. FUNGSI REGISTRASI MASYARAKAT
//+=+=========================================+=+

/**
 * Memproses pendaftaran akun baru langsung ke tbl_masyarakat.
 */
function registrasi($DATA) {
    global $KONEKSI;

    // Sanitasi input data
    $NIK = htmlspecialchars(stripslashes($DATA["nik"]));
    $NAMA = htmlspecialchars(stripslashes($DATA["nama"]));
    $USERNAME = htmlspecialchars(stripslashes($DATA["username"]));
    $TELP = htmlspecialchars(stripslashes($DATA["telp"]));
    $PASSWORD = mysqli_real_escape_string($KONEKSI, $DATA["password"]);
    $CONFIRM_PASSWORD = mysqli_real_escape_string($KONEKSI, $DATA["confirm_password"]);

    // Cek duplikasi NIK atau Username
    $RESULT = mysqli_query($KONEKSI, "SELECT nik FROM tbl_masyarakat WHERE nik = '$NIK' OR username = '$USERNAME'") or die('Error: ' . mysqli_error($KONEKSI));
    if (mysqli_fetch_assoc($RESULT)) {
        echo "<script>alert('NIK atau Username sudah terdaftar!');</script>";
        return false;
    }

    // Validasi kesesuaian password[cite: 2]
    if ($PASSWORD !== $CONFIRM_PASSWORD) {
        echo "<script>alert('Password dan Confirm Password tidak sama! cek lagi gih');</script>";
        return false;
    }

    // Hashing password[cite: 2]
    $PASSWORD_HASH = password_hash($PASSWORD, PASSWORD_DEFAULT);

    // Simpan data ke tabel tbl_masyarakat
    $QUERY = "INSERT INTO tbl_masyarakat (nik, nama, username, password, telp) 
              VALUES ('$NIK', '$NAMA', '$USERNAME', '$PASSWORD_HASH', '$TELP')";
              
    mysqli_query($KONEKSI, $QUERY) or die ('Gagal simpan data di tbl_masyarakat : ' . mysqli_error($KONEKSI));

   echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Silakan login menggunakan akun Anda.',
        confirmButtonColor: '#435ebe'
    }).then(function() {
        window.location.href = 'login.php';
    });
});
</script>";

    return mysqli_affected_rows($KONEKSI);
}


//+=+=========================================+=+
// 5. FUNGSI UPLOAD BERKAS / FOTO PENGADUAN
//+=+=========================================+=+

/**
 * Menangani pengunggahan berkas file ke server dengan validasi tipe dan ukuran.[cite: 2]
 */
function upload_files($FILE_INPUT, $IDENTIFIER, $TARGET_FOLDER = '../images/pengaduan', $OPTION = [])
{
    $DEFAULT = [
        'max_size' => 2 * 1024 * 1024, 
        'allowed_types' => ['jpg', 'jpeg', 'png'], 
        'create_folder' => true, 
        'prefix' => 'BUKTI'           
    ];

    $OPTIONS = array_merge($DEFAULT, $OPTION);

    if (!isset($FILE_INPUT['error']) || !isset($FILE_INPUT['tmp_name'])) {
        return ['success' => false, 'message' => 'File tidak valid.'];
    }

    $ERRORS = $FILE_INPUT['error']; 
    $TMP_NAME = $FILE_INPUT['tmp_name']; 
    $NAMA_ASLI = $FILE_INPUT['name']; 
    $UKURAN_FILE = $FILE_INPUT['size']; 

    if ($ERRORS === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'message' => 'Tidak ada file yang diupload.'];
    }

    if ($ERRORS !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Terjadi kesalahan saat mengupload file.'];
    }

    $EKSTENSI_FILE = strtolower(pathinfo($NAMA_ASLI, PATHINFO_EXTENSION)); 

    if (!in_array($EKSTENSI_FILE, $OPTIONS['allowed_types'])) {
        return ['success' => false, 'message' => "Ekstensi file tidak diizinkan."];
    }

    if ($UKURAN_FILE > $OPTIONS['max_size']) {
        return ['success' => false, 'message' => "Ukuran file melebihi batas maksimal."];
    }

    $PREFIX = $OPTIONS['prefix'] ? $OPTIONS['prefix'] . '_' : ''; 
    $UNIQUE_ID = uniqid(); 
    $TIMESTAMP = date('Ymd_His'); 
    $NAMA_FILE_BARU = $PREFIX . $IDENTIFIER . '_' . $TIMESTAMP . '_' . $UNIQUE_ID . '.' . $EKSTENSI_FILE; 
    $FILE_PATH = rtrim($TARGET_FOLDER, '/') . '/' . $NAMA_FILE_BARU;

    if (move_uploaded_file($TMP_NAME, $FILE_PATH)) {
        return [
            'success' => true,                   
            'Filename_tersimpan' => $NAMA_FILE_BARU
        ];
    } else {
        return ['success' => false, 'message' => 'Gagal memindahkan file.'];
    }
}


//+=+=========================================+=+
// 6. FUNGSI TAMBAH PETUGAS / ADMIN
//+=+=========================================+=+

/**
 * Menambahkan data akun petugas atau admin baru ke tbl_petugas.
 */
function tambah_petugas($DATA)
{
    global $KONEKSI; 

    $NAMA_PETUGAS = htmlspecialchars(trim($DATA["nama_petugas"]));
    $USERNAME     = htmlspecialchars(trim($DATA["username"]));
    $PASSWORD     = htmlspecialchars(trim($DATA["password"]));
    $PASSWORD2    = htmlspecialchars(trim($DATA["confirm_password"]));
    // Diubah dari 'telp' ke 'telepon' agar sesuai dengan struktur database dan fungsi ubah
    $TELEPON      = htmlspecialchars(trim($DATA["telepon"]));
    $LEVEL        = htmlspecialchars(trim($DATA["level"])); // 'admin' atau 'petugas'

    if ($PASSWORD !== $PASSWORD2) {
        $_SESSION['Sess_FormErrors'] = ["Password dan Konfirmasi Password tidak sama."]; 
        return false; 
    }

    $RESULT = mysqli_query($KONEKSI, "SELECT username FROM tbl_petugas WHERE username ='$USERNAME'");
    if (mysqli_fetch_assoc($RESULT)) {
        $_SESSION['Sess_FormErrors'] = ["Username sudah terdaftar."]; 
        return false; 
    }

    $PASSWORD_HASH = password_hash($PASSWORD, PASSWORD_DEFAULT);

    $SQL = "INSERT INTO tbl_petugas (nama_petugas, username, password, telepon, level) 
            VALUES ('$NAMA_PETUGAS', '$USERNAME', '$PASSWORD_HASH', '$TELEPON', '$LEVEL')";

    if (mysqli_query($KONEKSI, $SQL)) {
        $_SESSION['Sess_SuccessMessage'] = "Data Petugas berhasil ditambahkan!";
        return true;
    } else {
        $_SESSION['Sess_FormErrors'] = ["Gagal menambahkan petugas: " . mysqli_error($KONEKSI)];
        return false;
    }
}

//+=+=========================================+=+
// 7. FUNGSI TAMBAH PENGADUAN (OLEH MASYARAKAT)
//+=+=========================================+=+

function tambah_pengaduan($DATA, $FILES) {
    global $KONEKSI;

    // Cek apakah session nik ada
    if (!isset($_SESSION['nik'])) {
        echo "<script>alert('Sesi anda habis atau anda bukan masyarakat. Silakan login ulang!'); window.location.href='../inc/login.php';</script>";
        return false;
    }

    $NIK = $_SESSION['nik']; 
    $ISI_LAPORAN = htmlspecialchars(stripslashes($DATA['isi_laporan']));
    $TGL_PENGADUAN = date('Y-m-d'); 
    $STATUS = '0'; 

    $FOTO = "";

    if (isset($FILES['foto']) && $FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        $UPLOAD = upload_files($FILES['foto'], $NIK); 

        if ($UPLOAD['success']) {
            $FOTO = $UPLOAD['Filename_tersimpan'];
        } else {
            echo "<script>alert('Gagal upload foto: " . $UPLOAD['message'] . "');</script>";
            return false;
        }
    }

    $QUERY = "INSERT INTO tbl_pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status) 
              VALUES ('$TGL_PENGADUAN', '$NIK', '$ISI_LAPORAN', '$FOTO', '$STATUS')";

    mysqli_query($KONEKSI, $QUERY) or die('Gagal tambah pengaduan: ' . mysqli_error($KONEKSI));

    return mysqli_affected_rows($KONEKSI);
}

//+=+=========================================+=+
// 8. FUNGSI MEMBERIKAN TANGGAPAN (OLEH ADMIN)
//+=+=========================================+=+

function berikan_tanggapan($DATA) {
    global $KONEKSI;

    $ID_PENGADUAN = htmlspecialchars($DATA['id_pengaduan']);
    $TANGGAPAN = htmlspecialchars($DATA['tanggapan']);
    $STATUS = htmlspecialchars($DATA['status']);
    $ID_PETUGAS = $_SESSION['id_petugas']; // Diambil dari session admin yang sedang login
    $TGL_TANGGAPAN = date('Y-m-d');

    // 1. Simpan balasan ke tabel tanggapan
    $query_tanggapan = "INSERT INTO tbl_tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                        VALUES ('$ID_PENGADUAN', '$TGL_TANGGAPAN', '$TANGGAPAN', '$ID_PETUGAS')";
    mysqli_query($KONEKSI, $query_tanggapan) or die(mysqli_error($KONEKSI));

    // 2. Update status pengaduan menjadi 'proses' atau 'selesai'
    $query_update = "UPDATE tbl_pengaduan SET status = '$STATUS' WHERE id_pengaduan = '$ID_PENGADUAN'";
    mysqli_query($KONEKSI, $query_update) or die(mysqli_error($KONEKSI));

    return mysqli_affected_rows($KONEKSI);
}

// 9. FUNGSI UBAH / EDIT PETUGAS
function ubah_petugas($DATA) {
    global $KONEKSI;
    $ID = $DATA['id_petugas'];
    $NAMA = htmlspecialchars(trim($DATA['nama_petugas']));
    $USERNAME = htmlspecialchars(trim($DATA['username']));
    $TELEPON = htmlspecialchars(trim($DATA['telepon']));
    $LEVEL = htmlspecialchars(trim($DATA['level']));

    // Cek apakah password diisi atau kosong (jika kosong, jangan ubah password)
    if (!empty($DATA['password'])) {
        $PASSWORD_HASH = password_hash($DATA['password'], PASSWORD_DEFAULT);
        $SQL = "UPDATE tbl_petugas SET nama_petugas='$NAMA', username='$USERNAME', password='$PASSWORD_HASH', telepon='$TELEPON', level='$LEVEL' WHERE id_petugas='$ID'";
    } else {
        $SQL = "UPDATE tbl_petugas SET nama_petugas='$NAMA', username='$USERNAME', telepon='$TELEPON', level='$LEVEL' WHERE id_petugas='$ID'";
    }

    mysqli_query($KONEKSI, $SQL) or die(mysqli_error($KONEKSI));
    return mysqli_affected_rows($KONEKSI);
}

// 10. FUNGSI HAPUS PETUGAS
function hapus_petugas($ID) {
    global $KONEKSI;
    mysqli_query($KONEKSI, "DELETE FROM tbl_petugas WHERE id_petugas = '$ID'") or die(mysqli_error($KONEKSI));
    return mysqli_affected_rows($KONEKSI);
}
?>
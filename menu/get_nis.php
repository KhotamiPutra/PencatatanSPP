<?php
// Koneksi ke database (ganti dengan konfigurasi koneksi yang sesuai)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan nama siswa dari permintaan AJAX
$nama = $_POST['nama'];

// Mencari NIS dari nama siswa dalam database
$sql = "SELECT nis FROM data_siswa WHERE nama = '$nama'";
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
if ($result->num_rows > 0) {
    // Output NIS jika ditemukan
    $row = $result->fetch_assoc();
    echo $row['nis'];
} else {
    // Output pesan jika nama siswa tidak ditemukan
    echo "NIS tidak ditemukan";
}

$conn->close();
?>

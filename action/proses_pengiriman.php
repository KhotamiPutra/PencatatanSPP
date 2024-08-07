<?php
// proses_pengiriman.php

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_jurusan = $_POST['nama_jurusan'];

// Query untuk cek apakah nama jurusan sudah ada
$check_query = "SELECT * FROM jurusan WHERE nama_jurusan = '$nama_jurusan'";
$check_result = $conn->query($check_query);

if ($check_result->num_rows > 0) {
    echo "<script>alert('Nama jurusan sudah ada, silakan masukkan nama jurusan lain');window.location.assign('../menu/menu-jurusan.php');</script>";
} else {
    // Query untuk menyimpan data ke tabel jurusan
    $sql = "INSERT INTO jurusan (nama_jurusan) VALUES ('$nama_jurusan')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan');window.location.assign('../menu/menu-jurusan.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<?php
$servername = "localhost";
$username = "root";
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "spp";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari formulir
$nis = $_POST['nis'];
$nama = $_POST['nama'];
$tgl = $_POST['tgl'];
$harga = $_POST['harga'];
$id_spp = $_POST['id_spp'];

// Menyiapkan dan mengeksekusi query SQL untuk update data pembayaran
$sql = "UPDATE pembayaran SET nama='$nama', tgl='$tgl', harga='$harga', id_spp='$id_spp' WHERE nis='$nis'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Berhasil dirubah');window.location.assign('../menu/riwayat.php');</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>

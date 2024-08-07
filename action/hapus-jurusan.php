<?php
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

// Mendapatkan ID jurusan dari URL
$id_jurusan = $_GET['id'];

// Menghapus data jurusan berdasarkan ID
$sql = "DELETE FROM jurusan WHERE id_jurusan='$id_jurusan'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data jurusan berhasil dihapus');window.location.assign('../menu/menu-jurusan.php');</script>";
} else {
    $message = "Error: " . $sql . " - " . $conn->error;
}

$conn->close();

header("Location: ../menu/menu-jurusan.php");
?>

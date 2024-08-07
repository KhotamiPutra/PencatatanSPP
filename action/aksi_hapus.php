<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah ada parameter id yang dikirim dari URL
if(isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Query untuk menghapus data siswa berdasarkan NIS
    $sql_delete = "DELETE FROM data_siswa WHERE nis='$id_siswa'";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Data dihapus');window.location.assign('../menu/data_siswa.php');</script>";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
} else {
    echo "Parameter id tidak ditemukan.";
}

$conn->close();
?>

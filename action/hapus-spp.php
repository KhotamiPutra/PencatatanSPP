<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_spp = $_GET['id'];

$sql = "DELETE FROM spp WHERE id_spp='$id_spp'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data SPP berhasil dihapus');window.location.assign('../menu/spp.php');</script>";
} else {
    $message = "Error: " . $sql . " - " . $conn->error;
}

$conn->close();

header("Location: ../menu/spp.php");
?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_kelas = $_GET['id'];

// Hapus data siswa yang berhubungan di tabel 'data_siswa' terlebih dahulu
$delete_data_siswa_sql = "DELETE FROM data_siswa WHERE id_kelas='$id_kelas'";
if ($conn->query($delete_data_siswa_sql) !== TRUE) {
    echo "Error: " . $delete_data_siswa_sql . " - " . $conn->error;
    exit;
}

// Hapus data akun siswa yang berhubungan di tabel 'akun'
$delete_akun_sql = "DELETE FROM akun WHERE nis IN (SELECT nis FROM data_siswa WHERE id_kelas = '$id_kelas')";
if ($conn->query($delete_akun_sql) !== TRUE) {
    echo "Error: " . $delete_akun_sql . " - " . $conn->error;
    exit;
}

// Baru kemudian hapus data di tabel 'kelas'
$sql = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data kelas berhasil dihapus');window.location.assign('../menu/kelas.php');</script>";
} else {
    echo "Error: " . $sql . " - " . $conn->error;
}

$conn->close();
?>

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
$harga = $_POST['harga'];
$tgl = $_POST['tgl'];
$id_spp = $_POST['id_spp'];

// Cek apakah siswa sudah membayar pada bulan yang sama
$sql_cek = "SELECT * FROM pembayaran WHERE nis = '$nis' AND MONTH(tgl) = MONTH('$tgl') AND YEAR(tgl) = YEAR('$tgl')";
$result_cek = $conn->query($sql_cek);

if ($result_cek->num_rows > 0) {
    echo "<script>alert('Siswa ini Sudah melakukan pembayaran pada bulan ini');window.location.assign('../menu/data_siswa.php');</script>";
} else {
    // Menyiapkan dan mengeksekusi query SQL
    $sql = "INSERT INTO pembayaran (nis, nama, harga, tgl, id_spp) VALUES ('$nis', '$nama', '$harga', '$tgl', '$id_spp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pembayaran Berhasil');window.location.assign('../menu/riwayat.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi
$conn->close();
?>

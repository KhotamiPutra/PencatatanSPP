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

// Proses tambah data kelas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tingkat = $_POST['tingkat'];
    $nama_kelas = $_POST['nama_kelas'];

    // Query untuk memeriksa apakah kelas sudah ada
    $check_sql = "SELECT * FROM kelas WHERE tingkat='$tingkat' AND nama_kelas='$nama_kelas'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Kelas sudah ada, silakan masukkan kelas lain.');window.location.assign('../menu/kelas.php');</script>";
    } else {
        $sql = "INSERT INTO kelas (tingkat, nama_kelas) VALUES ('$tingkat', '$nama_kelas')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data kelas berhasil ditambahkan');window.location.assign('../menu/kelas.php');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

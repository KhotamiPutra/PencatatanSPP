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

// Mengambil data jurusan berdasarkan ID
$sql = "SELECT * FROM jurusan WHERE id_jurusan='$id_jurusan'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_jurusan = $row['nama_jurusan'];
} else {
    echo "Jurusan tidak ditemukan";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_jurusan = $_POST['nama_jurusan'];

    // Update data jurusan
    $sql = "UPDATE jurusan SET nama_jurusan='$nama_jurusan' WHERE id_jurusan='$id_jurusan'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data jurusan berhasil diupdate');window.location.assign('../menu/menu-jurusan.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: ../menu/menu-jurusan.php");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jurusan</title>
</head>
<body>
    <h2>Edit Jurusan</h2>
    <form action="" method="post">
        <label for="nama_jurusan">Nama Jurusan:</label>
        <input type="text" id="nama_jurusan" name="nama_jurusan" value="<?php echo $nama_jurusan; ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>

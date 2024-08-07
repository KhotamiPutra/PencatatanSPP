// proses-spp.php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tingkat = $_POST['tingkat'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    // Query untuk memeriksa apakah tingkat sudah ada di database
    $check_query = "SELECT * FROM spp WHERE tingkat = '$tingkat'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "<script>alert('Tingkat sudah ada di dalam data.');window.location.assign('../menu/spp.php');</script>";
    } else {
        // Query untuk menambahkan data SPP ke database
        $sql = "INSERT INTO spp (tingkat, tahun, nominal) VALUES ('$tingkat', '$tahun', '$nominal')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data SPP berhasil ditambahkan');window.location.assign('../menu/spp.php');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>


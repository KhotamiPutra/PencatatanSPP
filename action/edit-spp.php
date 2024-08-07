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

$sql = "SELECT * FROM spp WHERE id_spp='$id_spp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tingkat = $row['tingkat'];
    $tahun = $row['tahun'];
    $nominal = $row['nominal'];
} else {
    echo "Data SPP tidak ditemukan";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tingkat = $_POST['tingkat'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $sql = "UPDATE spp SET tingkat='$tingkat', tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data SPP berhasil diupdate');window.location.assign('../menu/spp.php');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: ../menu/spp.php");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SPP</title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap");
    body {
    font-family: "Quicksand", sans-serif;
    margin: 0;
    padding: 50px;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input{
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}
</style>
<body>
    <h2>Edit SPP</h2>
    <form action="" method="post">
        <label for="tingkat">Tingkat:</label>
        <input type="text" id="tingkat" name="tingkat" value="<?php echo $tingkat; ?>"><br><br>
        
        <label for="tahun">Tahun:</label>
        <input type="text" id="tahun" name="tahun" value="<?php echo $tahun; ?>"><br><br>
        
        <label for="nominal">Nominal:</label>
        <input type="text" id="nominal" name="nominal" value="<?php echo $nominal; ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>


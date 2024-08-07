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

// Proses update data kelas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tingkat = $_POST['tingkat'];
    $nama_kelas = $_POST['nama_kelas'];

    $sql = "UPDATE kelas SET tingkat='$tingkat', nama_kelas='$nama_kelas' WHERE id_kelas='$id_kelas'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data kelas berhasil diupdate');window.location.assign('../menu/kelas.php');</script>";
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch data for the selected class
$sql = "SELECT * FROM kelas WHERE id_kelas='$id_kelas'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tingkat = $row['tingkat'];
    $nama_kelas = $row['nama_kelas'];
} else {
    echo "Kelas tidak ditemukan";
    exit;
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
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

select, input[type="submit"] {
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
.error {
    color: red;
    margin-top: 10px;
}

</style>
<body>
    <h2>Edit Kelas</h2>
    <form action="edit-kelas.php?id=<?php echo $id_kelas; ?>" method="post">
        <label for="tingkat">Tingkat:</label>
        <select id="tingkat" name="tingkat" required>
            <option value="10" <?php if ($tingkat == '10') echo 'selected'; ?>>10</option>
            <option value="11" <?php if ($tingkat == '11') echo 'selected'; ?>>11</option>
            <option value="12" <?php if ($tingkat == '12') echo 'selected'; ?>>12</option>
        </select><br><br>

        <label for="nama_kelas">Nama Kelas:</label>
        <select id="nama_kelas" name="nama_kelas" required>
            <?php
            foreach (range('A', 'Z') as $char) {
                echo "<option value='$char'" . ($nama_kelas == $char ? ' selected' : '') . ">$char</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>

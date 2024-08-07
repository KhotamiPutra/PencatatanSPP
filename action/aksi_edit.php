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

    // Query untuk mengambil data siswa berdasarkan NIS
    $sql = "SELECT * FROM data_siswa WHERE nis='$id_siswa'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Data siswa ditemukan, tampilkan formulir edit
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

body {
    font-family: 'Quicksand', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background-color: #fff;
    padding: 20px 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
    font-weight: 600;
    color: #555;
}

input[type="text"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #3D8DBE;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
    </style>
</head>

<body>
    <form action="aksi_edit.php?id=<?php echo $id_siswa; ?>" method="post">
        <label for="nis">NIS:</label>
        <input type="text" id="nis" name="nis" value="<?php echo $row['nis']; ?>" readonly><br><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required><br><br>

        <label for="kelas">Kelas:</label>
        <select id="id_kelas" name="id_kelas" required>
            <option value="">Pilih Kelas</option>
            <?php
            // Query untuk menampilkan kelas dari database
            $kelas_sql = "SELECT k.id_kelas, k.nama_kelas, k.tingkat FROM kelas k ORDER BY k.tingkat, k.nama_kelas";
            $kelas_result = $conn->query($kelas_sql);
            if ($kelas_result->num_rows > 0) {
                while($kelas_row = $kelas_result->fetch_assoc()) {
                    $selected = ($kelas_row['id_kelas'] == $row['id_kelas']) ? 'selected' : '';
                    echo "<option value='" . $kelas_row['id_kelas'] . "' $selected>" . $kelas_row['tingkat'] . " - " . $kelas_row['nama_kelas'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="jurusan">Jurusan:</label>
        <select id="id_jurusan" name="id_jurusan" required>
            <option value="">Pilih Jurusan</option>
            <?php
            // Query untuk menampilkan jurusan dari database
            $jurusan_sql = "SELECT id_jurusan, nama_jurusan FROM jurusan";
            $jurusan_result = $conn->query($jurusan_sql);
            if ($jurusan_result->num_rows > 0) {
                while($jurusan_row = $jurusan_result->fetch_assoc()) {
                    $selected = ($jurusan_row['id_jurusan'] == $row['id_jurusan']) ? 'selected' : '';
                    echo "<option value='" . $jurusan_row['id_jurusan'] . "' $selected>" . $jurusan_row['nama_jurusan'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
</body>

</html>
<?php
        // Cek apakah ada data POST yang dikirim (setelah formulir di-submit)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = $_POST['nama'];
            $id_kelas = $_POST['id_kelas'];
            $id_jurusan = $_POST['id_jurusan'];

            // Query untuk update data siswa
            $sql_update = "UPDATE data_siswa SET nama='$nama', id_kelas='$id_kelas', id_jurusan='$id_jurusan' WHERE nis='$id_siswa'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Data siswa berhasil diperbarui.";
                // Redirect ke halaman data siswa setelah berhasil diperbarui
                header("Location: ../menu/data_siswa.php");
                exit;
            } else {
                echo "Error: " . $sql_update . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Siswa tidak ditemukan.";
    }
} else {
    echo "Parameter id tidak ditemukan.";
}

$conn->close();
?>

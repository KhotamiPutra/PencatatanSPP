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

// Ambil data kelas dari database
$sql_kelas = "SELECT * FROM kelas";
$result_kelas = $conn->query($sql_kelas);

// Ambil data jurusan dari database
$sql_jurusan = "SELECT * FROM jurusan";
$result_jurusan = $conn->query($sql_jurusan);

$sql_spp = "SELECT * FROM spp";
$result_spp = $conn->query($sql_spp);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="../style/add_siswa.css">
</head>

<body>
    <div class="sidebar">
        <div class="sb-head">
            <img src="../asset/ti.png" alt="" srcset="">
        </div>
        <ul>
            <a href="../dashboard/dashboard_admin.php">
                <li><img src="../asset/home.png" alt="" srcset="">Dashboard</li>
            </a>
            <a href="../menu/add_akun.php">
                <li><img src="../asset/add-user.png" alt="" srcset="">Akun</li>
            </a>
            <a href="../menu/data_siswa.php">
                <li><img src="../asset/siswa.png" alt="" srcset="">Data Siswa</li>
            </a>
            <a href="../menu/add_siswa.php">
                <li><img src="../asset/add-group.png" alt="" srcset="">+Data Siswa</li>
            </a>
            <!-- <a href="../menu/pembayaran.php">
                <li><img src="../asset/file.png" alt="" srcset="">Pembayaran SPP</li>
            </a> -->
            <a href="../menu/riwayat.php">
                <li><img src="../asset/history.png" alt="" srcset="">Riwayat Pembayaran</li>
            </a>
            <hr>
            <a href="../menu/menu-jurusan.php">
                <li><img src="../asset/future.png" alt="" srcset="">Jurusan</li>
            </a>

            <a href="../menu/kelas.php">
                <li><img src="../asset/group-class.png" alt="" srcset="">Kelas</li>
            </a>

            <a href="../menu/spp.php">
                <li><img src="../asset/wallet.png" alt="" srcset="">SPP</li>
            </a>
        </ul>
    </div>
    <main>
        <form action="" method="post">
            <label for="nis">NIS:</label><br>
            <input type="text" id="nis" name="nis" required><br><br>

            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="id_kelas">Kelas:</label><br>
            <select id="id_kelas" name="id_kelas" required>
            <option value="">Pilih Kelas</option>
            <?php
    if ($result_kelas->num_rows > 0) {
        while($row = $result_kelas->fetch_assoc()) {
            echo "<option value='" . $row["id_kelas"] . "'>Tingkat " . $row["tingkat"] . " - " . $row["nama_kelas"] . "</option>";
        }
    } else {
        echo "<option value=''>Kelas tidak tersedia</option>";
    }
    ?>
            </select><br><br>
            </select><br><br>

            <label for="id_jurusan">Jurusan:</label><br>
            <select id="id_jurusan" name="id_jurusan" required>
                <option value="">Pilih Kelas</option>
                <?php
                if ($result_jurusan->num_rows > 0) {
                    while($row = $result_jurusan->fetch_assoc()) {
                        echo "<option value='" . $row["id_jurusan"] . "'>" . $row["nama_jurusan"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Jurusan tidak tersedia</option>";
                }
                ?>
            </select><br><br>

            <label for="id_spp">SPP:</label>
            <select name="id_spp" id="id_spp" required>
                <option value="">SPP</option>
                <?php
                if ($result_spp->num_rows > 0) {
                    while($row = $result_spp->fetch_assoc()) {
                        echo "<option value='" . $row['id_spp'] . "'>Tingkat: " . $row['tingkat'] . ", Tahun: " . $row['tahun'] . ", Nominal: " . $row['nominal'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Jurusan tidak tersedia</option>";
                }
                ?>
            </select>

            <button type="submit">Tambah Siswa</button>
        </form>
    </main>
</body>

</html>

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

// Proses tambah data siswa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $id_jurusan = $_POST['id_jurusan'];
    $id_spp = $_POST['id_spp'];

    // Query untuk memeriksa apakah siswa sudah ada
    $check_sql = "SELECT * FROM data_siswa WHERE nis='$nis'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Siswa dengan NIS tersebut sudah terdaftar.');window.location.assign('../menu/add_siswa.php');</script>";
    } else {
        // Query untuk menyimpan data siswa ke dalam tabel
        $sql = "INSERT INTO data_siswa (nis, nama, id_kelas, id_jurusan, id_spp) VALUES ('$nis', '$nama', '$id_kelas', '$id_jurusan' , '$id_spp')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data siswa berhasil ditambahkan');window.location.assign('../menu/data_siswa.php');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

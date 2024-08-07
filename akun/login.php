<?php
session_start(); // Mulai session

// Sambungkan ke database
$host = "localhost";
$user = "root";
$pw = "";
$db = "spp";
$koneksi = mysqli_connect($host, $user, $pw, $db);

// Memeriksa koneksi berhasil atau tidak
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pesan kesalahan default
$errorMessage = "";

// Cek jika form login dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Terima data dari form login
    $id = $_POST['id'];
    $nis = $_POST['nis'];
    $password = $_POST['password'];

    // Query untuk memeriksa kredensial pengguna
    $query = "SELECT * FROM akun WHERE id='$id' AND nis='$nis' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah ada baris data yang sesuai
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hak_akses = $row['hak_akses'];
        $nis = $row['nis'];

        // Query untuk mendapatkan nama dari tabel data_siswa
        $queryNama = "SELECT nama FROM data_siswa WHERE nis='$nis'";
        $resultNama = mysqli_query($koneksi, $queryNama);
        if ($namaRow = mysqli_fetch_assoc($resultNama)) {
            $nama = $namaRow['nama'];
        } else {
            $nama = "Nama tidak ditemukan"; // Jika NIS tidak ada di tabel data_siswa
        }

        // Set nilai session
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['hak_akses'] = $hak_akses;
        $_SESSION['nis'] = $nis;
        $_SESSION['nama'] = $nama; // Menyimpan nama di session

        // Redirect ke halaman dashboard sesuai hak akses
        if ($hak_akses === 'admin') {
            header("Location: ../dashboard/dashboard_admin.php");
            exit();
        } elseif ($hak_akses === 'pengguna') {
            header("Location: ../dashboard/dashboard_pengguna.php");
            exit();
        }
    } else {
        // Kredensial salah, set pesan kesalahan
        $errorMessage = "Akun yang Anda masukkan tidak valid. Silakan coba lagi.";
    }
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a href="login-admin.php" class="apawe">Login Admin</a>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Login </h2>
            <!-- <h2 class="inactive underlineHover">Sign Up </h2> -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="../asset/ti.png" id="icon" alt="User Icon" />
            </div>

            <!-- Pesan Kesalahan -->
            <?php if (isset($errorMessage)) : ?>
            <p class="error"><?= $errorMessage ?></p>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="post">
                <input type="text" id="id" class="fadeIn second" name="id" placeholder="ID" required>
                <input type="text" id="nis" class="fadeIn third" name="nis" placeholder="NIS" required>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password"
                    required>
                <input type="submit" class="fadeIn fourth" value="Login">
            </form>


        </div>
    </div>
</body>

</html>
</html>
</html>
</html>

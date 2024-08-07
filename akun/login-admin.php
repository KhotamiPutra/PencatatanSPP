<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Mengambil username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menghindari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Query untuk memeriksa apakah akun admin tersedia di tabel
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah hasil query menghasilkan baris atau tidak
    if (mysqli_num_rows($result) == 1) {
        // Jika admin ditemukan, set session dan redirect ke dashboard_admin.php
        $_SESSION['username'] = $username;
        header("location: ../dashboard/dashboard_admin.php");
    } else {
        // Jika admin tidak ditemukan, tampilkan pesan kesalahan
        $errorMessage = "Username atau Password salah.";
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}
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
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Login Admin </h2>
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
                <input type="text" id="username" class="fadeIn third" name="username" placeholder="username" required>
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

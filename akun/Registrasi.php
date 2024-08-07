    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <h2 class="active"> Registrasi </h2>
                <!-- <h2 class="inactive underlineHover">Sign In </h2> -->

                <!-- Icon -->
                <div class="fadeIn first">
                    <img src="../asset/logo-removebg-preview.png" id="icon" alt="User Icon" />
                </div>

                <!-- Login Form -->
                <form action="" method="post">
                    <input type="text" id="nik" class="fadeIn second" name="nik" placeholder="NIK" required>

                    <input type="text" id="nama" class="fadeIn third" name="nama" placeholder="nama"required>

                    <input type="password" id="password" class="fadeIn second" name="password" placeholder="Password"required>

                    <input type="submit" class="fadeIn fourth" value="Register">
                </form>

                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="login.php">Halaman Login</a>
                </div>

            </div>
        </div>
    </body>

    </html>



    <?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "spp";

$koneksi = mysqli_connect($host, $user, $password, $db_name);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = isset($_POST['nik']) ? $_POST['nik'] : "";
    $nama = isset($_POST['nama']) ? $_POST['nama'] : "";
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : "";

    $query = "INSERT INTO pengguna (nik, nama, password) VALUES ('$nik', '$nama', '$password')";
    mysqli_query($koneksi, $query);

    header("Location: login.php");
    exit();
}

?>
<?php
session_start();
// Memeriksa apakah form telah disubmit
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

    // Mengambil data yang dipost dari formulir
    $id = $_POST['ID'];
    $nis = $_POST['NIS'];
    $password = $_POST['password'];
    $hak_akses = $_POST['hak_akses'];

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO akun (id, nis, password, hak_akses) VALUES ('$id', '$nis', '$password', '$hak_akses')";
    
    // Memeriksa apakah query berhasil dieksekusi
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Akun ditambahkan";
    } else {
        $_SESSION['pesan'] = "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }

    // Tutup koneksi database
    mysqli_close($koneksi);

    header("Location: ../menu/add_akun.php");
    exit();
}
?>

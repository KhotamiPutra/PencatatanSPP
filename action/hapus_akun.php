<?php
// Ambil ID akun yang akan dihapus dari parameter URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

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

    // Query untuk menghapus akun berdasarkan ID
    $query = "DELETE FROM akun WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    // Tutup koneksi database
    mysqli_close($koneksi);

    // Redirect kembali ke halaman sebelumnya
    header("Location: ../menu/add_akun.php");
    exit();
}
?>


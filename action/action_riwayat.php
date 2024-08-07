<?php
session_start();
$host = "localhost";
$user = "root";
$pw = "";
$db = "spp";
$koneksi = mysqli_connect($host, $user, $pw, $db);

// Memeriksa koneksi berhasil atau tidak
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Memeriksa apakah ID pembayaran dikirim melalui metode POST
if (isset($_POST['id_pembayaran'])) {
    // Mengambil ID pembayaran yang akan dihapus
    $id_pembayaran = $_POST['id_pembayaran'];

    // Query untuk menghapus data pembayaran berdasarkan ID
    $query = "DELETE FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data pembayaran berhasil dihapus";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    echo "ID pembayaran tidak ditemukan.";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

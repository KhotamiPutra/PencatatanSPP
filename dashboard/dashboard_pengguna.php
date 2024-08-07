<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran</title>
    <link rel="stylesheet" href="style_pengguna.css">
</head>
<body>
<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
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

    // Mendapatkan NIS pengguna dari sesi
    $nis_pengguna = $_SESSION['nis'];

    // Query untuk mendapatkan nama pengguna berdasarkan NIS
    $query_info_pengguna = "SELECT nama FROM data_siswa WHERE nis='$nis_pengguna'";
    $result_info_pengguna = mysqli_query($koneksi, $query_info_pengguna);
    $row_info_pengguna = mysqli_fetch_assoc($result_info_pengguna);
    $nama_pengguna = $row_info_pengguna['nama'];

    // Tutup koneksi database
    mysqli_close($koneksi);
?>
    <div class="navbar">
        <div>
            Selamat datang, <?php echo $nama_pengguna; ?> (NIS: <?php echo $nis_pengguna; ?>)
        </div>
        <div>
            <img src="../asset/ti.png" alt="Logo">
        </div>
    </div>
<main>
<h2>Riwayat Pembayaran</h2>
    <table border='1'>
        <tr>
            <th>ID Pembayaran</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <!-- <th>Cetak</th> -->
        </tr>
        <?php
        // Query untuk mendapatkan riwayat pembayaran pengguna
        $koneksi = mysqli_connect($host, $user, $pw, $db); // Sambungkan kembali ke database
        $query_riwayat_pembayaran = "SELECT * FROM pembayaran WHERE nis='$nis_pengguna'";
        $result_riwayat_pembayaran = mysqli_query($koneksi, $query_riwayat_pembayaran);

        // Menampilkan riwayat pembayaran pengguna
        while ($row = mysqli_fetch_assoc($result_riwayat_pembayaran)) {
            echo "<tr>";
            echo "<td>" . $row['id_pembayaran'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['harga'] . "</td>";
            echo "<td>" . $row['tgl'] . "</td>";
            // echo "<td><button onclick=\"cetakKuitansi('{$row['id_pembayaran']}', '{$row['nama']}', '{$row['tgl']}', '{$row['harga']}')\"><img src='../asset/printing.png' alt='Cetak' class='small-icon'></button></td>";
            echo "</tr>";
        }
        mysqli_close($koneksi); // Tutup koneksi database kembali
        ?>
    </table>
</main>
    
<?php
} else {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: ../login.php");
    exit();
}
?>
<script>
function cetakKuitansi(idPembayaran, nama, tanggal, harga) {
    var url = `cetak_kuitansi.php?idPembayaran=${idPembayaran}&nama=${nama}&tanggal=${tanggal}&harga=${harga}`;
    window.open(url, '_blank');
}
</script>
</body>
</html>

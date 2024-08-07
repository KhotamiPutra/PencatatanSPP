<?php
session_start(); // Memulai session
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin SPP</title>
    <link rel="stylesheet" href="style_dashboard.css">
</head>

<body>
    <?php

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

// Query untuk menghitung jumlah siswa yang sudah membayar pada bulan sekarang
$query_sudah_bayar_bulan_ini = "SELECT COUNT(*) AS total FROM pembayaran WHERE MONTH(tgl) = MONTH(CURRENT_DATE())";
$result_sudah_bayar_bulan_ini = mysqli_query($koneksi, $query_sudah_bayar_bulan_ini);
$row_sudah_bayar_bulan_ini = mysqli_fetch_assoc($result_sudah_bayar_bulan_ini);
$jumlah_sudah_bayar_bulan_ini = $row_sudah_bayar_bulan_ini['total'];

// Query untuk menghitung jumlah siswa yang belum membayar pada bulan sekarang
$query_belum_bayar_bulan_ini = "SELECT COUNT(*) AS total FROM data_siswa WHERE nis NOT IN (SELECT nis FROM pembayaran WHERE MONTH(tgl) = MONTH(CURRENT_DATE()))";
$result_belum_bayar_bulan_ini = mysqli_query($koneksi, $query_belum_bayar_bulan_ini);
$row_belum_bayar_bulan_ini = mysqli_fetch_assoc($result_belum_bayar_bulan_ini);
$jumlah_belum_bayar_bulan_ini = $row_belum_bayar_bulan_ini['total'];

// Query untuk menghitung jumlah seluruh siswa
$query_total_siswa = "SELECT COUNT(*) AS total FROM data_siswa";
$result_total_siswa = mysqli_query($koneksi, $query_total_siswa);
$row_total_siswa = mysqli_fetch_assoc($result_total_siswa);
$jumlah_total_siswa = $row_total_siswa['total'];

// Ambil nama bulan sekarang
$nama_bulan_sekarang = date('F');

// Query untuk mendapatkan 5 riwayat pembayaran terbaru
$query_riwayat_pembayaran = "SELECT * FROM pembayaran ORDER BY tgl DESC LIMIT 5";
$result_riwayat_pembayaran = mysqli_query($koneksi, $query_riwayat_pembayaran);

// Query untuk menghitung total uang yang sudah masuk
$query_total_uang = "SELECT SUM(harga) AS total_uang FROM pembayaran";
$result_total_uang = mysqli_query($koneksi, $query_total_uang);
$data_total_uang = mysqli_fetch_assoc($result_total_uang);
$total_uang = $data_total_uang['total_uang'];

// Query untuk menghitung total uang yang sudah masuk pada bulan ini
$query_uang_bulan_ini = "SELECT SUM(harga) AS uang_bulan_ini FROM pembayaran WHERE MONTH(tgl) = MONTH(CURRENT_DATE())";
$result_uang_bulan_ini = mysqli_query($koneksi, $query_uang_bulan_ini);
$data_uang_bulan_ini = mysqli_fetch_assoc($result_uang_bulan_ini);
$uang_bulan_ini = $data_uang_bulan_ini['uang_bulan_ini'];

// Tutup koneksi database
mysqli_close($koneksi);
?>
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
            <div class="container">
                <div class="summary">
                <div class="summary-header">
                    <?php
                    // Array untuk nama hari dalam bahasa Indonesia
                    $hariIndonesia = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

                    // Array untuk nama bulan dalam bahasa Indonesia
                    $bulanIndonesia = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

                    // Mendapatkan hari, tanggal, dan bulan saat ini
                    $hari = $hariIndonesia[date('w')]; // w adalah representasi numerik hari dalam seminggu
                    $tanggal = date('d');
                    $bulan = $bulanIndonesia[date('n')]; // n adalah representasi numerik bulan tanpa leading zeros
                    $tahun = date('Y');

                    // Menampilkan tanggal dalam bahasa Indonesia
                    echo "<p> $hari, $tanggal $bulan $tahun | <span id='jam'></span></p>";
                    ?>
                </div>
                    <div class="child-summary">
                        <img src="../asset/school.png" alt="" class="img-school">
                        <h4>SMK TIP</h4>
                    </div>
                    <div class="child-summary">
                        <img src="../asset/student.png" alt="" class="img-student">
                        <h4>Jumlah Seluruh Siswa: <?= $jumlah_total_siswa ?></h4>
                    </div>
                    <div class="child-summary">
                        <img src="../asset/contract.png" alt="" class="img-contract">
                        <h4> Sudah Membayar: <?= $jumlah_sudah_bayar_bulan_ini ?></li></h4> |
                            <h4> Belum Membayar: <?= $jumlah_belum_bayar_bulan_ini ?> siswa</h4>
                    </div>
                    <div class="child-summary">
                        <img src="../asset/money-warna.png" alt="" class="img-money">
                        <?php
                        // Menampilkan data keuangan
                        echo "<h4>Total Masuk: Rp. " . number_format($total_uang, 0, ',', '.') . "</h4>";
                        echo "|";
                        echo "<h4>Bulan Ini: Rp. " . number_format($uang_bulan_ini, 0, ',', '.') . "</h4>";
                        ?>
                    </div>
                </div>

                <!-- Riwayat Pembayaran Terbaru -->
                <div class="payment-history">
                    <h3>Riwayat Pembayaran Terbaru</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Jumlah Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_riwayat_pembayaran)) : ?>
                            <tr class="payment-item">
                                <td><?= $row['nis'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['tgl'] ?></td>
                                <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <br>
                    <a href="../menu/riwayat.php">Lihat Semua Data</a>
                </div>
            </div>
    </main>

<script>
function updateJam() {
    var now = new Date();
    var jam = now.getHours();
    var menit = now.getMinutes();
    var detik = now.getSeconds();
    menit = checkTime(menit);
    detik = checkTime(detik);
    document.getElementById('jam').innerHTML = jam + ":" + menit + ":" + detik;
    setTimeout(updateJam, 1000);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // tambahkan nol di depan angka < 10
    return i;
}

window.onload = updateJam; // Memulai fungsi saat halaman dimuat
</script>

</body>

</html>
</html>
</html>



<?php
session_start();

if (isset($_SESSION['pesan'])) {
   echo "<div id='pesan' class='pesan'>" . $_SESSION['pesan'] . "</div>";
   echo "<script>
           setTimeout(function() {
               var pesan = document.getElementById('pesan');
               pesan.style.display = 'none';
           }, 3000);
       </script>";

    unset($_SESSION['pesan']);
}
$host = "localhost";
$user = "root";
$pw = "";
$db = "spp";
$koneksi = mysqli_connect($host, $user, $pw, $db);

// Memeriksa koneksi berhasil atau tidak
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Inisialisasi variabel bulan dengan nilai default
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Query untuk mendapatkan riwayat pembayaran dari database berdasarkan bulan yang dipilih
$query = "SELECT * FROM pembayaran WHERE MONTH(tgl) = '$bulan'";
$result = mysqli_query($koneksi, $query);

// Inisialisasi variabel untuk menyimpan riwayat pembayaran
$riwayat_pembayaran = [];

// Ambil data riwayat pembayaran
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $riwayat_pembayaran[] = $row;
    }
}

// Balik urutan riwayat pembayaran
$riwayat_pembayaran = array_reverse($riwayat_pembayaran);

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran SPP</title>
    <link rel="stylesheet" href="../style/riwayat.css">
</head>

<body>
    <div class="navigation">
        <ul>
            <a href="../dashboard/dashboard_admin.php">
                <img src="../asset/back.png" alt="" srcset="">
            </a>
            <li><a href="?bulan=01">Januari</a></li>
            <li><a href="?bulan=02">Februari</a></li>
            <li><a href="?bulan=03">Maret</a></li>
            <li><a href="?bulan=04">April</a></li>
            <li><a href="?bulan=05">Mei</a></li>
            <li><a href="?bulan=06">Juni</a></li>
            <li><a href="?bulan=07">Juli</a></li>
            <li><a href="?bulan=08">Agustus</a></li>
            <li><a href="?bulan=09">September</a></li>
            <li><a href="?bulan=10">Oktober</a></li>
            <li><a href="?bulan=11">November</a></li>
            <li><a href="?bulan=12">Desember</a></li>
        </ul>
    </div>

    <div class="container">
        <?php
        // Menyimpan nama bulan sesuai dengan nilai bulan yang dipilih dalam Bahasa Indonesia
        $nama_bulan_indonesia = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $nama_bulan = $nama_bulan_indonesia[$bulan];
        ?>
        <h2>Riwayat Pembayaran SPP Bulan <?= $nama_bulan ?></h2>
        <?php if (empty($riwayat_pembayaran)) : ?>
        <p>Belum ada riwayat pembayaran untuk bulan ini.</p>
        <?php else : ?>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari nama siswa..." class="cari">
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat_pembayaran as $index => $pembayaran) : ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $pembayaran['nis'] ?></td>
                    <td><?= $pembayaran['nama'] ?></td>
                    <td><?= $pembayaran['tgl'] ?></td>
                    <td><?= $pembayaran['harga'] ?></td>
                    <td>
                        <button class="hapus-btn" data-id="<?= $pembayaran['id_pembayaran'] ?>">
                            <img src="../asset/recycle-bin.png" alt="" class="small-icon">
                        </button>
                        |
                        <button class="cetak-btn" onclick="cetakKuitansi('<?= $pembayaran['nis'] ?>', '<?= $pembayaran['nama'] ?>', '<?= $pembayaran['tgl'] ?>', '<?= $pembayaran['harga'] ?>')">
                            <img src="../asset/printing.png" alt="" class="small-icon">
                        </button>
                        |
                        <a href='../menu/edit_pembayaran.php?nis=<?= $pembayaran['nis'] ?>&nama=<?= $pembayaran['nama'] ?>&tgl=<?= $pembayaran['tgl'] ?>&harga=<?= $pembayaran['harga'] ?>&id_spp=<?= $pembayaran['id_spp'] ?>' class='edit'><img src='../asset/edit.png'></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var filter = this.value.toUpperCase();
    var table = document.querySelector('table tbody');
    var rows = table.getElementsByTagName('tr');

    // Iterasi setiap baris tabel, sembunyikan yang tidak cocok dengan pencarian
    for (var i = 0; i < rows.length; i++) {
        var namaCol = rows[i].getElementsByTagName('td')[2]; // Kolom nama siswa
        if (namaCol) {
            var namaValue = namaCol.textContent || namaCol.innerText;
            if (namaValue.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
});
var buttons = document.querySelectorAll('.hapus-btn');

buttons.forEach(function(button) {
    button.addEventListener('click', function() {
        var idPembayaran = this.getAttribute('data-id');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../action/action_riwayat.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Refresh halaman setelah penghapusan data
                window.location.reload();
            }
        };
        xhr.send('id_pembayaran=' + idPembayaran);
    });
});

function cetakKuitansi(nis, nama, tanggal, jumlah) {
    var url = `cetak_kuitansi.php?nis=${nis}&nama=${nama}&tanggal=${tanggal}&jumlah=${jumlah}`;
    window.open(url, '_blank');
}
</script>

</html>
</html>

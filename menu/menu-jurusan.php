<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/jurusan.css">
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
    <form action="../action/proses_pengiriman.php" method="post">
        <label for="nama_jurusan">Nama Jurusan:</label>
        <input type="text" id="nama_jurusan" name="nama_jurusan" required><br><br>
        
        <input type="submit" value="Tambahkan">
    </form>

    <?php

    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "spp";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data dari tabel jurusan
    $sql = "SELECT * FROM jurusan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nama Jurusan</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["nama_jurusan"]."</td>";
            // Aksi untuk tombol Edit
            echo "<td><a href='../action/edit-jurusan.php?id=".$row["id_jurusan"]."' class='edit'><img src='../asset/edit.png'></a>";

            // Aksi untuk tombol Hapus
            echo " | <a href='../action/hapus-jurusan.php?id=".$row["id_jurusan"]."' class='hapus'><img src='../asset/recycle-bin.png'></a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data jurusan";
    }

    $conn->close();
    ?>
</body>
    </main>
</html>
</html>

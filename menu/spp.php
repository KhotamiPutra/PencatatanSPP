<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data SPP</title>
    <link rel="stylesheet" href="../style/spp.css">
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
<h2>Form Data SPP</h2>
    <form action="../action/proses-spp.php" method="post">
        <label for="tingkat">Tingkat:</label>
        <!-- <input type="text" id="tingkat" name="tingkat" required><br><br> -->
        <select name="tingkat" id="tingkat" required>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        
        <label for="tahun">Tahun:</label>
        <input type="text" id="tahun" name="tahun" required><br><br>
        
        <label for="nominal">Nominal:</label>
        <input type="text" id="nominal" name="nominal" required><br><br>
        
        <input type="submit" value="Tambah Data SPP">
    </form>

    <h2>Data SPP</h2>
    <table>
        <tr>
            <!-- <th>ID SPP</th> -->
            <th>Tingkat</th>
            <th>Tahun</th>
            <th>Nominal</th>
            <th>Aksi</th>
        </tr>
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
        // Query untuk menampilkan data SPP dari database
        $sql = "SELECT * FROM spp";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                    // echo "<td>" . $row["id_spp"]. "</td>";
                echo "<td>" . $row["tingkat"]. "</td>";
                echo "<td>" . $row["tahun"]. "</td>";
                echo "<td>" . $row["nominal"]. "</td>";
                echo "<td><a href='../action/edit-spp.php?id=".$row["id_spp"]."' class='edit'><img src='../asset/edit.png'></a> | 
                <a href='../action/hapus-spp.php?id=".$row["id_spp"]."' class='hapus'><img src='../asset/recycle-bin.png'></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
</main>
</body>
</html>


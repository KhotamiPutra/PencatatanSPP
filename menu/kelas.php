<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas</title>
    <link rel="stylesheet" href="../style/kelas.css">
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
    <!-- Form untuk mengirim data -->
    <form action="../action/proses-kelas.php" method="post">
        <select name="tingkat" required>
            <option value="">Pilih Tingkat</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        
        <select name="nama_kelas" required>
            <option value="">Pilih Nama Kelas</option>
            <?php
            foreach(range('A', 'Z') as $char) {
                echo "<option value='$char'>$char</option>";
            }
            ?>
        </select>

        <button type="submit">Tambah Kelas</button>
    </form>
    <table>
        <tr>
            <th>Tingkat</th>
            <th>Nama Kelas</th>
            <th>Action</th>
        </tr>
        <?php
            // Query untuk menampilkan data kelas dari database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "spp";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            $sql = "SELECT tingkat, nama_kelas, id_kelas FROM kelas";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["tingkat"]. "</td>";
                    echo "<td>" . $row["nama_kelas"]. "</td>";
                    echo "<td> <a href='../action/edit-kelas.php?id=".$row["id_kelas"]."' class='edit'><img src='../asset/edit.png'></a>";
                    echo " | <a href='../action/hapus-kelas.php?id=".$row["id_kelas"]."' class='hapus'><img src='../asset/recycle-bin.png'></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>0 results</td></tr>";
            }
            $conn->close();
        ?>
    </table>
</main>
    
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="../style/style_data_siswa.css">
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
    <h2>Data Siswa</h2>
    <form method="GET">
        <label for="search">Cari Siswa:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Cari</button>
    </form>
    <table>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tingkat</th>
            <th>Kelas</th>
            <th>Jurusan</th>
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

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mengambil data siswa beserta kelas, tingkat, dan jurusan
        $sql = "SELECT data_siswa.nis, data_siswa.nama, kelas.nama_kelas, kelas.tingkat, jurusan.nama_jurusan, spp.nominal, data_siswa.id_spp
        FROM data_siswa
        INNER JOIN kelas ON data_siswa.id_kelas = kelas.id_kelas
        INNER JOIN jurusan ON data_siswa.id_jurusan = jurusan.id_jurusan
        INNER JOIN spp ON data_siswa.id_spp = spp.id_spp";
        $result = $conn->query($sql);

        if(isset($_GET['search'])) {
            $search = $_GET['search'];
            // Query untuk mencari siswa berdasarkan nama
            $sql_search = "SELECT data_siswa.nis, data_siswa.nama, kelas.nama_kelas, kelas.tingkat, jurusan.nama_jurusan, spp.nominal, data_siswa.id_spp
                            FROM data_siswa
                            INNER JOIN kelas ON data_siswa.id_kelas = kelas.id_kelas
                            INNER JOIN jurusan ON data_siswa.id_jurusan = jurusan.id_jurusan
                            INNER JOIN spp ON data_siswa.id_spp = spp.id_spp
                            WHERE data_siswa.nama LIKE '%$search%'";
            $result_search = $conn->query($sql_search);

            if ($result_search->num_rows > 0) {
                // Output data siswa hasil pencarian
                while($row_search = $result_search->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_search["nis"] . "</td>";
                    echo "<td>" . $row_search["nama"] . "</td>";
                    echo "<td>" . $row_search["tingkat"] . "</td>";
                    echo "<td>" . $row_search["nama_kelas"] . "</td>";
                    echo "<td>" . $row_search["tingkat"] . " " . $row_search["nama_jurusan"] . "</td>";
                    echo "<td>" . $row_search["nominal"] . "</td>";
                    echo "<td><a href='../action/aksi_edit.php?id=" . $row_search["nis"] . "' class='edit'><img src='../asset/edit.png'></a> | <a href='../action/aksi_hapus.php?id=" . $row_search["nis"] . "' class='hapus'><img src='../asset/recycle-bin.png'></a> | <a href='../menu/pembayaran.php?nis=" . $row_search["nis"] . "&nama=" . $row_search["nama"] . "&id_spp=" . $row_search["id_spp"] . "' class='bayar'><img src='../asset/save-money.png'></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ditemukan siswa dengan nama '$search'</td></tr>";
            }
        } else {
            if ($result->num_rows > 0) {
                // Output data dari setiap baris hasil query
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nis"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["tingkat"] . "</td>";
                    echo "<td>" . $row["nama_kelas"] . "</td>";
                    echo "<td>" . $row["tingkat"] . " " . $row["nama_jurusan"] . "</td>";
                    echo "<td>" . $row["nominal"] . "</td>";
                    echo "<td><a href='../action/aksi_edit.php?id=" . $row["nis"] . "' class='edit'><img src='../asset/edit.png'></a> | <a href='../action/aksi_hapus.php?id=" . $row["nis"] . "' class='hapus'><img src='../asset/recycle-bin.png'></a> | <a href='../menu/pembayaran.php?nis=" . $row["nis"] . "&nama=" . $row["nama"] . "&id_spp=" . $row["id_spp"] . "' class='bayar'><img src='../asset/save-money.png'></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data siswa</td></tr>";
            }
        }
        $conn->close();
        ?>
    </table>
</main>
</body>
</html>

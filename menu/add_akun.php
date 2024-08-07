<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun</title>
    <link rel="stylesheet" href="../style/style-akun.css">
    <script>
        window.onload = function() {
            setTimeout(function() {
                var pesan = document.getElementById('pesan');
                if (pesan) {
                    pesan.style.display = 'none';
                }
            }, 2000);
        };
    </script>
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
    <div class="container">
        <h2>Tambah Akun</h2>
        <?php
        if (isset($_SESSION['pesan'])) {
            echo "<div id='pesan' class='pesan'>" . $_SESSION['pesan'] . "</div>";
            unset($_SESSION['pesan']);
        }
        ?>
        <form action="../action/process_add_akun.php" method="post">
            <label for="ID">ID:</label>
            <input type="text" id="ID" name="ID" required>
            <br>
            <label for="NIS">NIS:</label>
            <select name="NIS" id="NIS" required>
                <option value="">Pilih NIS</option>
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

                // Query untuk mendapatkan NIS yang sudah terdaftar di tabel data_siswa
                $query_nis = "SELECT nis FROM data_siswa";
                $result_nis = mysqli_query($koneksi, $query_nis);
                $nis_list = array();

                // Memasukkan NIS ke dalam array
                while ($row_nis = mysqli_fetch_assoc($result_nis)) {
                    $nis_list[] = $row_nis['nis'];
                }

                // Query untuk mendapatkan NIS yang sudah terdaftar di tabel akun
                $query_akun_nis = "SELECT nis FROM akun";
                $result_akun_nis = mysqli_query($koneksi, $query_akun_nis);
                $akun_nis_list = array();

                // Memasukkan NIS yang sudah terdaftar di akun ke dalam array
                while ($row_akun_nis = mysqli_fetch_assoc($result_akun_nis)) {
                    $akun_nis_list[] = $row_akun_nis['nis'];
                }

                // Loop melalui setiap NIS yang sudah ada di tabel data_siswa
                foreach ($nis_list as $nis) {
                    // Jika NIS belum terdaftar di tabel akun, tampilkan sebagai opsi
                    if (!in_array($nis, $akun_nis_list)) {
                        echo "<option value='$nis'>$nis</option>";
                    } else {
                        // Jika NIS sudah terdaftar di tabel akun, tandai sebagai disabled
                        echo "<option value='$nis' disabled>$nis (Sudah Terdaftar)</option>";
                    }
                }
                ?>
            </select>

            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required>
            <br>
            <label for="hak_akses">Hak Akses:</label>
            <select name="hak_akses" id="hak_akses">
                <option value="admin">Admin</option>
                <option value="pengguna">Pengguna</option>
            </select>
            <br>
            <input type="submit" value="Tambah Akun">
        </form>
        
        <h2>Akun yang Sudah Ada</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIS</th>
                    <th>Password</th>
                    <th>Hak Akses</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch and display existing accounts -->
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

                // Query untuk mendapatkan akun yang sudah ada
                $query = "SELECT * FROM akun";
                $result = mysqli_query($koneksi, $query);

                // Menampilkan hasil query
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nis'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>" . $row['hak_akses'] . "</td>";
                    echo "<td><a href='../action/hapus_akun.php?id=" . $row['id'] . "'><img src='../asset/recycle-bin.png' alt='Hapus'></a></td>";
                    echo "</tr>";
                }

                // Tutup koneksi database
                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Pembayaran</title>
    <script>
        function updateHarga() {
            const sppData = <?php echo json_encode($spp_data); ?>;
            const idSpp = document.getElementById("id_spp").value;
            const harga = sppData[idSpp];
            document.getElementById("harga").value = harga ? harga.nominal : '';
        }
    </script>
    <link rel="stylesheet" href="../style/pembayaran.css">
</head>
<body>
    <form action="../action/aksi_edit_pembayaran.php" method="post">
        <?php
        $nis = $_GET['nis'];
        $nama = $_GET['nama'];
        $tgl = $_GET['tgl'];
        $harga = $_GET['harga'];
        $id_spp = $_GET['id_spp'];
        ?>
        <label for="nis">NIS:</label>
        <input type="text" id="nis" name="nis" value="<?php echo $nis; ?>" required><br><br>
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required><br><br>
        
        <!-- <label for="harga">Harga:</label> -->
        <input type="hidden" id="harga" name="harga" value="<?php echo $harga; ?>" required readonly><br><br>
        
        <label for="id_spp">ID SPP:</label>
        <select id="id_spp" name="id_spp" required onchange="updateHarga()">
            <option value="">Pilih SPP</option>
            <?php
            // Koneksi ke database
            $servername = "localhost";
            $username = "root";
            $password = ""; // Sesuaikan dengan password database Anda
            $dbname = "spp";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Mengambil data dari tabel spp
            $sql = "SELECT id_spp, tingkat, tahun, nominal FROM spp";
            $result = $conn->query($sql);
            $spp_data = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_spp'] . "'>Tingkat: " . $row['tingkat'] . ", Tahun: " . $row['tahun'] . ", Nominal: " . $row['nominal'] . "</option>";
                    $spp_data[$row['id_spp']] = $row;
                }
            } else {
                echo "<option value=''>No SPP available</option>";
            }

            $conn->close();
            ?>
        </select><br><br>
        <label for="tgl">Tanggal (YYYY-MM-DD):</label>
        <input type="date" id="tgl" name="tgl" value="<?php echo $tgl; ?>" required><br><br>
        
        
        <input type="submit" value="edit">
        <br>
        <a href="riwayat.php">Cek Riwayat</a>
    </form>
    <script>
        const sppData = <?php echo json_encode($spp_data); ?>;
        function updateHarga() {
            const idSpp = document.getElementById("id_spp").value;
            const harga = sppData[idSpp] ? sppData[idSpp]['nominal'] : '';
            document.getElementById("harga").value = harga;
        }
    </script>
</body>
</html>



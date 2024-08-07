<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Pembayaran</title>
    <link rel="stylesheet" href="../style/pembayaran.css">
</head>
<body>
    <form action="../action/proses_pencatatan.php" method="post">
        <?php
        $nis = isset($_GET['nis']) ? $_GET['nis'] : '';
        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';
        $id_spp = isset($_GET['id_spp']) ? $_GET['id_spp'] : '';
        ?>
        <label for="nis">NIS:</label>
        <input type="text" id="nis" name="nis" value="<?php echo htmlspecialchars($nis); ?>" required readonly><br><br>
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required readonly><br><br>
        
        <!-- <label for="id_spp">SPP:</label> -->
        <input type="hidden" id="id_spp" name="id_spp" value="<?php echo htmlspecialchars($id_spp); ?>" required readonly><br><br>
        
        <label for="harga">Harga:</label>
        <input type="text" id="harga" name="harga" required readonly><br><br>
        
        <label for="tgl">Tanggal:</label>
        <input type="date" id="tgl" name="tgl" required><br><br>
        
        <input type="submit" value="Submit">
        <br>
        <a href="riwayat.php">Cek Riwayat</a>
    </form>
    <script>
        const sppData = <?php
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
                $spp_data[$row['id_spp']] = $row;
            }
        }

        echo json_encode($spp_data);
        $conn->close();
        ?>;
        
        document.addEventListener("DOMContentLoaded", function() {
            const idSpp = "<?php echo htmlspecialchars($id_spp); ?>";
            if (sppData[idSpp]) {
                document.getElementById("harga").value = sppData[idSpp]['nominal'];
            }
        });
    </script>
</body>
</html>

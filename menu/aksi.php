<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="../style/aksi-style.css">
</head>

<body>
    <?php
        // Periksa apakah parameter 'nis' ada di URL
        if (isset($_GET['nis'])) {
            // Lakukan koneksi ke database
            $host = "localhost";
            $user = "root";
            $pw = "";
            $db = "spp";
            $koneksi = mysqli_connect($host, $user, $pw, $db);

            // Periksa apakah koneksi berhasil
            if (!$koneksi) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }

            // Ambil nilai NIS dari URL
            $nis = $_GET['nis'];

            // Query untuk mendapatkan data siswa berdasarkan NIS
            $sql = "SELECT * FROM data_siswa WHERE nis = '$nis'";

            // Eksekusi query dan ambil hasilnya
            $result = mysqli_query($koneksi, $sql);

            // Cek apakah data siswa ditemukan
            if (mysqli_num_rows($result) == 1) {
                // Ambil data siswa dari hasil query
                $row = mysqli_fetch_assoc($result);
                $nama = $row['nama'];
                $kelas = $row['kelas'];
                $jurusan = $row['jurusan'];

                // Tampilkan form untuk mengedit data siswa
        ?>
    <div class="group">
        <form action="../action/aksi_edit.php" method="POST">
            <h2>Detail Siswa</h2>
            <input type="hidden" name="old_nis" value="<?php echo $nis; ?>" readonly>
            <!-- Input tersembunyi untuk menyimpan NIS lama -->
            <label for="nis">NIS:</label><br>
            <input type="text" id="nis" name="nis" value="<?php echo $nis; ?>" readonly><br><br>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>"><br><br>
            <label for="kelas">Kelas:</label><br>
            <input type="text" id="kelas" name="kelas" value="<?php echo $kelas; ?>"><br><br>
            <label for="jurusan">Jurusan:</label><br>
            <select id="jurusan" name="jurusan">
                <option value="Rekayasa Perangkat Lunak"
                    <?php if ($jurusan == 'Rekayasa Perangkat Lunak') echo 'selected'; ?>>Rekayasa Perangkat Lunak
                </option>
                <option value="Teknik Komputer dan Jaringan"
                    <?php if ($jurusan == 'Teknik Komputer dan Jaringan') echo 'selected'; ?>>Teknik Komputer dan
                    Jaringan
                </option>
                <option value="Teknik Elektronika Industri"
                    <?php if ($jurusan == 'Teknik Elektronika Industri') echo 'selected'; ?>>Teknik Elektronika Industri
                </option>
                <option value="Teknik Pendingin dan Tata Udara"
                    <?php if ($jurusan == 'Teknik Pendingin dan Tata Udara') echo 'selected'; ?>>Teknik Pendingin dan
                    Tata
                    Udara</option>
            </select><br><br>
            <div class="button">

                <input type="submit" name="edit" value="Simpan">
        </form>


        <form action="../action/aksi_hapus.php" method="POST">
            <input type="hidden" name="nis" value="<?php echo $nis; ?>">
            <input type="submit" name="hapus" value="Hapus">
        </form>
    </div>
    </div>

    <?php
            } else {
                echo "Data siswa tidak ditemukan.";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
        }
?>

</body>

</html>
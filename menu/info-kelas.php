<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../action/simpan-data-siswa.php" method="post">
        <input type="text" name="nis" placeholder="NIS" required>
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="hidden" name="id_kelas" value="<?php echo $row['id_kelas']; ?>">
        <input type="hidden" name="id_jurusan" value="<?php echo $row['id_jurusan']; ?>">
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
</html>
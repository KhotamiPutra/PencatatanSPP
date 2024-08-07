<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pw = "";
$db = "spp";
$koneksi = mysqli_connect($host, $user, $pw, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari URL
$idPembayaran = $_GET['idPembayaran'];

// Query untuk mendapatkan data pembayaran
$query = "SELECT * FROM pembayaran WHERE id_pembayaran='$idPembayaran'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            background: #f9f9f9;
            color: #333;
        }
        .container {
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #444;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kuitansi Pembayaran SPP</h1>
        <p><strong>ID Pembayaran:</strong> <?= $data['id_pembayaran'] ?></p>
        <p><strong>NIS:</strong> <?= $data['nis'] ?></p>
        <p><strong>Nama:</strong> <?= $data['nama'] ?></p>
        <p><strong>Tanggal Pembayaran:</strong> <?= $data['tgl'] ?></p>
        <p><strong>Jumlah Pembayaran:</strong> Rp<?= number_format($data['harga'], 2, ',', '.') ?></p>
        <div class="footer">
            Terima kasih telah melakukan pembayaran tepat waktu.
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
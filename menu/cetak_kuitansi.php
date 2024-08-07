<?php
// Ambil data dari URL
$nis = $_GET['nis'];
$nama = $_GET['nama'];
$tanggal = $_GET['tanggal'];
$jumlah = $_GET['jumlah'];
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
        <p><strong>NIS:</strong> <?= $nis ?></p>
        <p><strong>Nama:</strong> <?= $nama ?></p>
        <p><strong>Tanggal Pembayaran:</strong> <?= $tanggal ?></p>
        <p><strong>Jumlah Pembayaran:</strong> Rp<?= number_format($jumlah, 2, ',', '.') ?></p>
        <div class="footer">
            Terima kasih telah melakukan pembayaran tepat waktu.
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>



<?php
// Buat koneksi ke database
$host = "localhost";
$user = "root";
$pw = "";
$db = "spp";
$koneksi = mysqli_connect($host, $user, $pw, $db);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Terima data kelas yang dikirim dari halaman web
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Pastikan kelas tidak kosong
if (!empty($kelas)) {
    // Query untuk mengambil nama dan NIS siswa berdasarkan kelas menggunakan prepared statement
    $sql = "SELECT nama, nis FROM data_siswa WHERE kelas = ?";
    
    // Persiapkan pernyataan SQL menggunakan prepared statement
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // Bind parameter kelas ke pernyataan SQL
        mysqli_stmt_bind_param($stmt, "s", $kelas);

        // Eksekusi pernyataan SQL
        mysqli_stmt_execute($stmt);

        // Ambil hasil query
        $result = mysqli_stmt_get_result($stmt);

        // Buat array untuk menampung data siswa (nama dan NIS)
        $siswa = array();

        // Masukkan data siswa ke dalam array
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($siswa, $row);
            }
        }

        // Kembalikan hasil dalam format JSON
        echo json_encode($siswa);

        // Tutup pernyataan
        mysqli_stmt_close($stmt);
    } else {
        // Jika gagal membuat pernyataan, kembalikan pesan error
        echo json_encode(array('error' => 'Gagal membuat pernyataan SQL'));
    }
} else {
    // Jika kelas kosong, kembalikan pesan error
    echo json_encode(array('error' => 'Kelas tidak boleh kosong'));
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>

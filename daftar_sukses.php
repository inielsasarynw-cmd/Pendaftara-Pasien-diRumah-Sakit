<?php
include "koneksi.php"; // file koneksi ke database

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    // Ambil pasien berdasarkan NIK
    $query_pasien = mysqli_query($koneksi, "SELECT * FROM pasien WHERE nik='$nik'");
    $data_pasien = mysqli_fetch_assoc($query_pasien);
} else {
    // Ambil pasien terakhir yang baru didaftarkan
    $query_pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id DESC LIMIT 1");
    $data_pasien = mysqli_fetch_assoc($query_pasien);
    $nik = $data_pasien['nik'];
}

// Ambil nama dan alamat dari riwayat kunjungan berdasarkan NIK
$query_riwayat = mysqli_query($koneksi, "SELECT p.nama, p.alamat FROM kunjungan1 k JOIN pasien p ON k.id_pasien = p.id WHERE p.nik = '$nik' ORDER BY k.id DESC LIMIT 1");
if (mysqli_num_rows($query_riwayat) > 0) {
    $data_riwayat = mysqli_fetch_assoc($query_riwayat);
    $nama = $data_riwayat['nama'];
    $alamat = $data_riwayat['alamat'];
} else {
    $nama = $data_pasien['nama'];
    $alamat = $data_pasien['alamat'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #91bff8;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }
        h2 {
            text-align: center;
            color: green;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        td {
            padding: 8px;
        }
        td:first-child {
            font-weight: bold;
            width: 35%;
        }
        .kembali-ke-menu-utama {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .kembali-ke-menu-utama a {
            background: #16d66cff;
            color: black;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Pendaftaran Berhasil!</h2>
        <p>Data pasien berhasil disimpan. Berikut detailnya:</p>
        <table>
            <tr><td>No. RM</td><td><?php echo $data_pasien['no_rm']; ?></td></tr>
            <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
            <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
            <tr><td>Tanggal Daftar</td><td><?php echo date('Y-m-d'); ?></td></tr>
        </table>
        <button onclick="copyNoRM()">Simpan No RM</button>
        <script>
            function copyNoRM() {
                const noRM = "<?php echo $data_pasien['no_rm']; ?>";
                navigator.clipboard.writeText(noRM).then(function() {
                    alert('No RM berhasil disimpan ke clipboard: ' + noRM);
                }, function(err) {
                    alert('Gagal menyalin No RM');
                });
            }
        </script>
        <div class="kembali-ke-menu-utama">
            <a href="index.php">Kembali ke menu utama</a>
        </div>
    </div>
</body>
</html
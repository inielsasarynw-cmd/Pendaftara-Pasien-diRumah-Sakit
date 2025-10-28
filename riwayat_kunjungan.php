<?php
include 'koneksi.php';
// Ambil tanggal hari ini
$tanggal_hari_ini = date('Y-m-d');

// Query untuk mengambil data berdasarkan tanggal hari ini dari tabel kunjungan1
$query = "SELECT ROW_NUMBER() OVER (ORDER BY d.id) as no_dokter, d.id as id_dokter, d.nama_dokter, p.nama as nama_pasien, po.nama_poli as poli, k.tgl_kunjungan as tanggal
          FROM kunjungan1 k
          JOIN pasien p ON k.id_pasien = p.id
          JOIN dokter d ON k.id_dokter = d.id
          JOIN poli po ON d.id_poli = po.id
          WHERE DATE(k.tgl_kunjungan) = '$tanggal_hari_ini'";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kunjungan Dokter Hari Ini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6f9;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Data Riwayat Kunjungan Dokter Hari Ini (<?= $tanggal_hari_ini ?>)</h2>

    <table>
        <tr>
            <th>NO</th>
            <th>Nama Dokter</th>
            <th>Nama Pasien</th>
            <th>Poli</th>
            <th>Tanggal</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$data['no_dokter']}</td>
                        <td>{$data['nama_dokter']}</td>
                        <td>{$data['nama_pasien']}</td>
                        <td>{$data['poli']}</td>
                        <td>{$data['tanggal']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data kunjungan hari ini.</td></tr>";
        }
        ?>
    </table>
    <center>
    <p><a href="admin_dashboard.php">Kembali ke Halaman Sebelumnya</a></p>
    <center>
</body>
</html>
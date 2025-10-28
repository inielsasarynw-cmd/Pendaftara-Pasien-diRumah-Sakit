<?php
session_start();
include "koneksi.php";

// Cek apakah sudah login
if (!isset($_SESSION['no_rm'])) {
    header("Location: index.php");
    exit;
}

$no_rm = $_SESSION['no_rm'];

// Ambil data pasien sesuai nomor RM
$query = mysqli_query($koneksi, "SELECT * FROM pasien WHERE no_rm='$no_rm'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data pasien tidak ditemukan!'); window.location='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #99c9f8ff;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            text-align: center;
            color: #151515ff;
        }
        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #2bcf5cff;
        }
        td:first-child {
            font-weight: bold;
            width: 35%;
        }
        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            background: #17d123ff;
            color: black;
            padding: 15px 25px;
            border-radius: 12px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Selamat Datang, <?php echo $data['nama']; ?>!</h2>
        <p>Berikut detail data Anda:</p>
        <table>
            <tr><td>No. RM</td><td><?php echo $data['no_rm']; ?></td></tr>
            <tr><td>NIK</td><td><?php echo $data['nik']; ?></td></tr>
            <tr><td>Nama</td><td><?php echo $data['nama']; ?></td></tr>
            <tr><td>Alamat</td><td><?php echo $data['alamat']; ?></td></tr>
            <tr><td>Tanggal Daftar</td><td><?php echo $data['tgl_daftar']; ?></td></tr>
        </table>
        <div class="logout">
            <a href="pilih_dokter.php">SELANJUTNYA</a>
        </div>
    </div>
</body>
</html>
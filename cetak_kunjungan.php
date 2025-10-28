<?php
session_start();
include "koneksi.php";

$id = intval($_GET['id_kunjungan'] ?? 0);
if ($id <= 0) {
    echo "Data tidak ditemukan!";
    exit();
}

$query = mysqli_query($koneksi, "SELECT k.*, p.nama as nama_pasien, p.nik, p.alamat, d.nama_dokter, po.nama_poli FROM kunjungan1 k JOIN pasien p ON k.id_pasien = p.id JOIN dokter d ON k.id_dokter = d.id JOIN poli po ON d.id_poli = po.id WHERE k.id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit();
}

if (isset($_POST['selesai'])) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Kunjungan</title>
    <style>
        body { font-family: Arial, sans-serif; margin:40px; background-color: #fff; }
        h2 { text-align:center; color: #e74f4fff; margin-bottom: 20px; }
        table { width:100%; border-collapse:collapse; margin-top:20px; border: 2px solid #000; }
        td { padding:10px; border:1px solid #000; }
        td:first-child { background-color: #97d598ff; font-weight: bold; width: 30%; }
        td:nth-child(2) { background-color: #e8e6e6ff; }
    </style>
</head>
<body onload="window.print()">
    <h2>Bukti Pendaftaran Kunjungan</h2>
    <table>
        <tr><td><b>No RM</b></td><td><?php echo $data['no_rm']; ?></td></tr>
        <tr><td><b>NIK</b></td><td><?php echo $data['nik']; ?></td></tr>
        <tr><td><b>Nama</b></td><td><?php echo $data['nama_pasien']; ?></td></tr>
        <tr><td><b>Alamat</b></td><td><?php echo $data['alamat']; ?></td></tr>
        <tr><td><b>Poli</b></td><td><?php echo $data['nama_poli']; ?></td></tr>
        <tr><td><b>Dokter</b></td><td><?php echo $data['nama_dokter']; ?></td></tr>
        <tr><td><b>Tanggal Daftar</b></td><td><?php echo date("Y-m-d H:i:s", strtotime($data['tgl_kunjungan'])); ?></td></tr>
    </table>
    <form method="post" style="text-align: center; margin-top: 20px;">
        <button type="submit" name="selesai" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background-color: #4CAF50; color: white; border: none; border-radius: 4px;">Selesai</button>
    </form>
</body>

</html>

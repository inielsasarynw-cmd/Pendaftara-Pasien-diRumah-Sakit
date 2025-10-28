<?php
session_start();
include "koneksi.php";

$id = intval($_GET['id_kunjungan'] ?? 0);
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT k.*, p.nama as nama_pasien, p.nik, p.alamat, d.nama_dokter, po.nama_poli FROM kunjungan1 k JOIN pasien p ON k.id_pasien = p.id JOIN dokter d ON k.id_dokter = d.id JOIN poli po ON d.id_poli = po.id WHERE k.id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit();
}

// tombol kembali ditekan
if (isset($_POST['kembali'])) {
    header("Location: dashboard.php");
    exit();
}

// tombol edit ditekan
if (isset($_POST['edit'])) {
    header("Location: pilih_dokter.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Kunjungan</title>
    <style>
        body {font-family: Arial, sans-serif; background: #76a1e2ff; padding: 30px;}
        .container {
            max-width: 650px; margin:auto; background:white; padding:25px;
            border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {color:#292b2eff; text-align:center;}
        .data {margin:15px 0;}
        .data p {margin:7px 0; font-size:20px;}
        .btn {
            padding:15px 15px; border:none; border-radius:8px; cursor:pointer;
            font-weight:800; margin:20px; color:white;
        }
        .btn-edit {background:#ff9800;}
        .btn-kembali {background:#28a745;}
        .btn-cetak {background:#007bff;}
    </style>
</head>
<body>
<div class="container">
    <h2>Konfirmasi Data Kunjungan</h2>
    <div class="data">
        <p><strong>No RM:</strong> <?php echo htmlspecialchars($data['no_rm']); ?></p>
        <p><strong>NIK:</strong> <?php echo htmlspecialchars($data['nik']); ?></p>
        <p><strong>Nama:</strong> <?php echo htmlspecialchars($data['nama_pasien']); ?></p>
        <p><strong>Alamat:</strong> <?php echo htmlspecialchars($data['alamat']); ?></p>
        <p><strong>Poli:</strong> <?php echo htmlspecialchars($data['nama_poli']); ?></p>
        <p><strong>Dokter:</strong> <?php echo htmlspecialchars($data['nama_dokter']); ?></p>
        <p><strong>Tanggal Daftar:</strong> <?php echo date("Y-m-d H:i:s", strtotime($data['tgl_kunjungan'])); ?></p>
    </div>
    <form method="post">
        <button type="submit" name="edit" class="btn btn-edit">Batal</button>
        <button type="submit" name="kembali" class="btn btn-kembali">Kembali</button>
        <a href="cetak_kunjungan.php?id_kunjungan=<?= $data['id'] ?>" class="btn btn-cetak" target="_blank">Cetak</a>
    </form>
</div>
</body>
</html>
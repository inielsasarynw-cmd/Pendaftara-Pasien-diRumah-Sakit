<?php
session_start();
include "koneksi.php";

// Cek apakah sudah login
if (!isset($_SESSION['no_rm'])) {
    header("Location: index.php");
    exit;
}

$no_rm = $_SESSION['no_rm'];

// Ambil data pasien
$query_pasien = mysqli_query($koneksi, "SELECT id FROM pasien WHERE no_rm='$no_rm'");
$data_pasien = mysqli_fetch_assoc($query_pasien);
$id_pasien = $data_pasien['id'];

// Ambil data dari form
$id_dokter = $_POST['id_dokter'];

// Validasi
if (empty($id_dokter)) {
    echo "<script>alert('Dokter belum dipilih!'); window.location='kinformasi.php';</script>";
    exit;
}

// Simpan ke tabel kunjungan1
$query = "INSERT INTO kunjungan1 (no_rm, id_dokter, id_pasien, tgl_kunjungan) 
          VALUES ('$no_rm', '$id_dokter', '$id_pasien', NOW())";

$insert = mysqli_query($koneksi, $query);

if ($insert) {
    $id_kunjungan = mysqli_insert_id($koneksi);
    $_SESSION['id_kunjungan'] = $id_kunjungan;

    // Redirect ndengan GET supaya bisa dipakai di halaman konfirmasi
    header("Location: kinformasi.php?id_kunjungan=" . $id_kunjungan);
    exit;
} else {
    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>
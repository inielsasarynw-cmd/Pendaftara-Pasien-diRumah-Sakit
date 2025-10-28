<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login_admin.php'); exit; }
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: admin_dashboard.php'); exit; }

$id = intval($_POST['id'] ?? 0);
$nama_dokter = trim($_POST['nama_dokter'] ?? '');
$id_poli = intval($_POST['id_poli'] ?? 0);

if ($id <= 0 || $nama_dokter === '' || $id_poli <= 0) {
    echo "Data tidak valid."; exit;
}

$stmt = $koneksi->prepare("UPDATE dokter SET nama_dokter = ?, id_poli = ? WHERE id = ?");
$stmt->bind_param('sii', $nama_dokter, $id_poli, $id);
if ($stmt->execute()) {
    header('Location: admin_dashboard.php?msg=updated');
    exit;
} else {
    echo "Error: " . $stmt->error;
}
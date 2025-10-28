<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login_admin.php'); exit; }
include 'koneksi.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_dokter = trim($_POST['nama_dokter']);
    $id_poli = intval($_POST['id_poli']);

    if (!empty($nama_dokter) && $id_poli > 0) {
        $stmt = $koneksi->prepare("INSERT INTO dokter (nama_dokter, id_poli) VALUES (?, ?)");
        $stmt->bind_param("si", $nama_dokter, $id_poli);
        if ($stmt->execute()) {
            $message = "Dokter berhasil ditambahkan.";
        } else {
            $message = "Gagal menambahkan dokter.";
        }
        $stmt->close();
    } else {
        $message = "Nama dokter dan poli harus diisi.";
    }
}

// ambil list poli
$polires = $koneksi->query("SELECT id, nama_poli FROM poli ORDER BY nama_poli");
?>
<h2>Tambah Dokter Baru</h2>
<?php if ($message): ?>
    <p><?=$message?></p>
<?php endif; ?>
<form method="post">
  <label>Nama Dokter:</label><br>
  <input name="nama_dokter" required><br><br>

  <label>Poli:</label><br>
  <select name="id_poli" required>
    <option value="">Pilih Poli</option>
    <?php while ($p = $polires->fetch_assoc()): ?>
      <option value="<?= $p['id'] ?>">
        <?= htmlspecialchars($p['nama_poli']) ?>
      </option>
    <?php endwhile; ?>
  </select><br><br>

  <button type="submit">Tambah Dokter</button>
</form>
<a href="admin_dashboard.php">Kembali ke Dashboard</a>

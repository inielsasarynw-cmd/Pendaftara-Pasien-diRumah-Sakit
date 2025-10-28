<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login_admin.php'); exit; }
include 'koneksi.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID dokter tidak valid."; exit; }

// ambil data dokter & list poli
$stmt = $koneksi->prepare("SELECT id, nama_dokter, id_poli FROM dokter WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$dokter = $res->fetch_assoc();
if (!$dokter) { echo "Dokter tidak ditemukan."; exit; }

$polires = $koneksi->query("SELECT id, nama_poli FROM poli ORDER BY nama_poli");
?>
<form method="post" action="update_dokter.php">
  <input type="hidden" name="id" value="<?= $dokter['id'] ?>">
  <label>Nama Dokter:</label><br>
  <input name="nama_dokter" value="<?= htmlspecialchars($dokter['nama_dokter']) ?>" required><br><br>

  <label>Poli:</label><br>
  <select name="id_poli" required>
    <?php while ($p = $polires->fetch_assoc()): ?>
      <option value="<?= $p['id'] ?>" <?= $p['id']==$dokter['id_poli']?'selected':'' ?>>
        <?= htmlspecialchars($p['nama_poli']) ?>
      </option>
    <?php endwhile; ?>
  </select><br><br>

  <button type="submit">Simpan Perubahan</button>
</form>
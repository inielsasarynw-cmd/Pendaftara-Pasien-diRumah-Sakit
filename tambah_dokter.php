
<?php
session_start();
include 'koneksi.php';

// Ambil list poli untuk dropdown
$polires = $koneksi->query("SELECT id, nama_poli FROM poli ORDER BY nama_poli");

// Handle penambahan dokter
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_dokter'])) {
    $nama_dokter = trim($_POST['nama_dokter']);
    $id_poli = intval($_POST['id_poli']);

    if (!empty($nama_dokter) && $id_poli > 0) {
        $stmt = $koneksi->prepare("INSERT INTO dokter (nama_dokter, id_poli) VALUES (?, ?)");
        $stmt->bind_param("si", $nama_dokter, $id_poli);
        if ($stmt->execute()) {
            $message = '<div class="message success">Dokter berhasil ditambahkan.</div>';
        } else {
            $message = '<div class="message error">Gagal menambahkan dokter.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="message error">Nama dokter dan poli harus diisi.</div>';
    }
}
?>
<link rel="stylesheet" href="admin_dashboard.css">
<h2>Halo, <?=htmlspecialchars($_SESSION['admin_nama'])?></h2>

<?php
if (isset($_SESSION['success'])) {
    echo '<div class="message success">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="message error">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="form-tambah">
  <h3>Tambah Dokter Baru</h3>
  <?php if ($message): echo $message; endif; ?>
  <form method="post">
    <input type="hidden" name="add_dokter" value="1">
    <label>Nama Dokter:</label>
    <input name="nama_dokter" required>

    <label>Poli:</label>
    <select name="id_poli" required>
      <option value="">Pilih Poli</option>
      <?php while ($p = $polires->fetch_assoc()): ?>
        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_poli']) ?></option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Tambah Dokter</button>
  </form>
</div>

<center>
  <a href="admin_dashboard.php">Kembali ke Halaman Utama</a>
</center>

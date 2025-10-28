<?php
// admin_dashboard.php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login_admin.php'); exit; }
include 'koneksi.php';

// Handle delete dokter
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($id > 0) {
        $stmt = $koneksi->prepare("DELETE FROM dokter WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success'] = "Dokter berhasil dihapus.";
                } else {
                    $_SESSION['error'] = "Dokter tidak ditemukan.";
                }
            } else {
                $_SESSION['error'] = "Gagal menghapus dokter.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Gagal mempersiapkan query.";
        }
    } else {
        $_SESSION['error'] = "ID tidak valid.";
    }
    header('Location: admin_dashboard.php');
    exit;
}



// Handle add dokter
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


// ambil daftar dokter beserta poli
$sql = "SELECT d.id, d.nama_dokter, p.nama_poli FROM dokter d JOIN poli p ON d.id_poli = p.id ORDER BY d.id";
$res = $koneksi->query($sql);

// ambil list poli
$polires = $koneksi->query("SELECT id, nama_poli FROM poli ORDER BY nama_poli");

// ambil daftar poli
$poli_sql = "SELECT id, nama_poli FROM poli ORDER BY id";
$poli_res = $koneksi->query($poli_sql);
?>
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

<h3>Daftar Dokter & Poli</h3>
<table border="1" cellpadding="6">
  <tr><th>NO</th><th>Nama Dokter</th><th>Poli</th><th>Aksi</th></tr>
  <?php $no = 1; while ($row = $res->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nama_dokter']) ?></td>
      <td><?= htmlspecialchars($row['nama_poli']) ?></td>
      <td><a href="edit_dokter.php?id=<?= $row['id'] ?>">Edit</a> | <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">Hapus</a></td>
    </tr>
  <?php endwhile; ?>
</table>

<style>
/* Merged CSS for admin_dashboard.php to match blue theme */

body {
    font-family: Arial, sans-serif;
    background-color: #f0f4f9ff; /* Light blue background matching index.php */
    margin: 0;
    padding: 20px;
    color: #333;
}

h2, h3 {
    color: #070808ff; /* Blue color matching dashboard.php h2 */
    text-align: center;
}

table {
    border-collapse: collapse;
    width: 90%;
    margin: 20px auto;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

table th {
    background: #0d6efd; /* Blue header matching riwayat_kunjungan.php */
    color: white;
    padding: 10px;
    border: 1px solid #ccc;
}

table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

a {
    color: #1a2027ff; /* Dark link color matching index.php */
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.btn-kembali {
    display: block;
    text-align: center;
    margin-top: 20px;
    background: #5fd871ff; /* Green button matching index.php */
    color: black;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
}

.btn-kembali:hover {
    background: #2ee149ff; /* Darker green on hover */
}

/* Form styles adjusted to fit theme */
.form-tambah {
    background-color: white !important;
    border: 1px solid #252dffff !important;
    border-radius: 8px !important;
    padding: 20px !important;
    max-width: 400px !important;
    margin: 20px auto !important;
    box-shadow: 0 2px 8px rgba(38, 31, 217, 0.1) !important;
}

.form-tambah h3 {
    color: #15181cff !important; /* Blue */
    margin-top: 0 !important;
}

.form-tambah label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-tambah input, .form-tambah select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-tambah button {
    background-color: #5fd871ff !important; /* Green */
    color: black !important;
    padding: 10px 15px !important;
    border: none !important;
    border-radius: 4px !important;
    cursor: pointer !important;
}

.form-tambah button:hover {
    background-color: #2ee149ff !important; /* Darker green */
}

/* Messages */
.message {
    margin-bottom: 10px !important;
    padding: 10px !important;
    border-radius: 4px !important;
}

.success {
    background-color: #d4edda !important;
    color: #155724 !important;
    border: 1px solid #c3e6cb !important;
}

.error {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    border: 1px solid #f5c6cb !important;
}
</style>

   <a href="tambah_dokter.php" <button type="submit">Tambah Dokter</button>
  </form>
</div>

<center>
  <a href="riwayat_kunjungan.php" <button type="submit">Riwayat Kunjungan</button></a>
<center>
  
<center>
<a href="index.php">Kembali ke Halaman Utama</a>
<center>

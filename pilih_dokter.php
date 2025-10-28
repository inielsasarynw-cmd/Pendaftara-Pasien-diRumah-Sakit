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

if (isset($_POST['pilih'])) {
    // Ambil data dari form
    $id_dokter = $_POST['dokter'];

    // Validasi
    if (empty($id_dokter)) {
        echo "<script>alert('Dokter belum dipilih!'); window.location='pilih_dokter.php';</script>";
        exit;
    }

    // Simpan ke tabel kunjungan1
    $query = "INSERT INTO kunjungan1 (no_rm, id_dokter, id_pasien, tgl_kunjungan) 
              VALUES ('$no_rm', '$id_dokter', '$id_pasien', NOW())";

    $insert = mysqli_query($koneksi, $query);

    if ($insert) {
        $id_kunjungan = mysqli_insert_id($koneksi);
        $_SESSION['id_kunjungan'] = $id_kunjungan;

        // Redirect ke halaman konfirmasi
        header("Location: kinformasi.php?id_kunjungan=" . $id_kunjungan);
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Dokter & Poli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #a0cefdff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(171, 83, 83, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #111519ff;
            margin-bottom: 35px;
        }
        select {
            width: 100%;
            padding: 20px;
            border: 1px solid #6dfd45ff;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: black;
            border: none;
            padding: 15px 0;
            width: 100%;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="container">
<h2>Pilih Dokter & Poli</h2>
<form method="post">
    <input type="hidden" name="pasien" value="<?php echo $id_pasien; ?>">
    Dokter-Poli:
    <select name="dokter" required>
        <option value="">-- Pilih Dokter & Poli --</option>
        <?php
        $q = mysqli_query($koneksi, "SELECT d.id, d.nama_dokter, p.nama_poli FROM dokter d JOIN poli p ON d.id_poli = p.id ORDER BY p.nama_poli, d.nama_dokter");
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<option value='{$row['id']}'>{$row['nama_dokter']} ({$row['nama_poli']})</option>";
        }
        ?>
    </select><br><br>
    <button type="submit" name="pilih">Pilih</button>
</form>
</div>
</body>
</html>

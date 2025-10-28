<?php
include "koneksi.php";

if (isset($_POST['daftar'])) {
    $nik    = $_POST['nik'];
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $poli   = $_POST['poli'];

    // generate no_rm sederhana: 4 digit terakhir NIK + timestamp
    $no_rm = substr($nik, -4) . time();

    // simpan data ke database
    mysqli_query($koneksi, "INSERT INTO pasien(no_rm, nik, nama, alamat, poli) 
                            VALUES('$no_rm', '$nik', '$nama', '$alamat', '$poli')");

    // redirect ke halaman sukses sambil kirim no_rm
    header("Location: daftar_sukses.php?no_rm=$no_rm");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Pasien Baru</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    text-align: center;
    margin: 20px;
}
h2 {
    color: #333;
}
form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 400px;
    margin: 0 auto;
    text-align: left;
}
input[type="text"], select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button:hover {
    background-color: #45a049;
}
.logout {
    text-align: center;
    margin-top: 20px;
}
.logout a {
    color: #4CAF50;
    text-decoration: none;
}
.logout a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<h2>Form Pendaftaran Pasien Baru</h2>
<form method="post">
    NIK: <input type="text" name="nik" required><br>
    Nama: <input type="text" name="nama" required><br>
    Alamat: <input type="text" name="alamat"><br>
    Poli: 
    <select name="poli">
        <?php
        $q = mysqli_query($koneksi, "SELECT * FROM poli");
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<option value='{$row['id']}'>{$row['nama_poli']}</option>";
        }
        ?>
    </select><br>

    <!-- Tombol submit yang benar -->
    <button type="submit" name="daftar">Daftar</button>
</form>

<div class="logout">
    <a href="daftar_sukses.php">Informasi Pendaftaran</a>
</div>

</body>
</html>

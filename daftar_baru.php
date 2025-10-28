<?php
include "koneksi.php";

$error = ""; // untuk menampung pesan error

if (isset($_POST['daftar'])) {
    $nik    = $_POST['nik'];
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];

    // validasi panjang NIK harus 16 digit
    if (strlen($nik) != 16 || !ctype_digit($nik)) {
        $error = "Pendaftaran gagal: NIK harus 16 digit angka.";
    } else {
        // cek apakah NIK sudah ada di database
        $cek = mysqli_query($koneksi, "SELECT * FROM pasien WHERE nik='$nik'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>
                    alert('Maaf, NIK sudah pernah didaftarkan.');
                    window.location.href='daftar_baru.php';
                  </script>";
            exit;
        }

        // generate no_rm sederhana: 4 digit terakhir NIK + timestamp
        $no_rm = substr($nik, -4) . time();

        // simpan data ke database
        mysqli_query($koneksi, "INSERT INTO pasien(no_rm, nik, nama, alamat) 
                                VALUES('$no_rm', '$nik', '$nama', '$alamat')");

        // redirect ke halaman sukses sambil kirim no_rm
        header("Location: daftar_sukses.php?no_rm=$no_rm");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Pasien Baru</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #91bff8;
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
    color: black;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button:hover {
    background-color: #45a049;
}
.error {
    color: red;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}
</style>
</head>
<body>
<h2>Form Pendaftaran Pasien Baru</h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    NIK: <input type="text" name="nik" maxlength="16" required><br>
    Nama: <input type="text" name="nama" required><br>
    Alamat: <input type="text" name="alamat"><br>

    <button type="submit" name="daftar">Daftar</button>
</form>

</body>
</html>
<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $no_rm = $_POST['no_rm'];

    // Check if admin login
    if ($no_rm === "123456789") {
        $_SESSION['admin_id'] = 1; // Set admin session id (can be improved)
        $_SESSION['admin_nama'] = 'Administrator';
        header("Location: admin_dashboard.php");
        exit;
    }

    $cek = mysqli_query($koneksi,"SELECT * FROM pasien WHERE no_rm='$no_rm'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['no_rm'] = $no_rm;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('No RM tidak ditemukan! Silakan daftar baru.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Pasien</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #91bff8ff;
    text-align: center;
}
h2 {
    color: #333;
}
form {
    margin: 60px auto;
    width: 600px;
    text-align: left;
}
input[type="text"] {
    padding: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 100%;
    box-sizing: border-box;
}
button {
    padding: 16px 24px;
    background-color: #5fd871ff;
    color: black;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}
button:hover {
    background-color: #2ee149ff;
}
a {
    color: #1a2027ff;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}
a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<h2>Login Pasien</h2>
<form method="post">
    No RM: <input type="text" name="no_rm" required>
    <button type="submit" name="login">Login</button>
</form>
<br>
<a href="daftar_baru.php">Daftar Pasien Baru</a>
</body>
</html>
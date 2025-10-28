<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $data  = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['admin_nama'] = $data['nama'];
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "<p style='color:red'>Username atau password salah!</p>";
    }
}
?>

<form method="post">
    <h2>Login Admin</h2>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
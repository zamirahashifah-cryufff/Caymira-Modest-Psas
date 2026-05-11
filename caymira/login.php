<?php
session_start();
include 'config/db.php';
$msg = '';
if (isset($_POST['login'])) {
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE
username='$username'");
if (mysqli_num_rows($result) === 1) {
$row = mysqli_fetch_assoc($result);
// Verifikasi kecocokan password yang dienkripsi
if (password_verify($password, $row['password'])) {
$_SESSION['user_id'] = $row['id'];
$_SESSION['username'] = $row['username'];
header("Location: index.html"); // Arahkan ke Beranda
exit;
} else {
$msg = "Password salah!";
}
} else {
$msg = "Username tidak ditemukan!";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - Caymira</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h2>Caymira Login</h2>
<?php if($msg != '') echo "<p style='color:red;'>$msg</p>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password"
required>
<button type="submit" name="login">MASUK</button>
</form>
<p>Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
</div>

</body>
</html>
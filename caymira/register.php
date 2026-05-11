<?php
include 'config/db.php';
$msg = '';
if (isset($_POST['register'])) {
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
// Hash password demi keamanan
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// Cek apakah username/email sudah dipakai
$cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'
OR email='$email'");
if (mysqli_num_rows($cek) > 0) {
$msg = "Username atau Email sudah terdaftar!";
} else {
$sql = "INSERT INTO users (username, email, password) VALUES
('$username', '$email', '$password')";
if (mysqli_query($conn, $sql)) {
echo "<script>alert('Registrasi Berhasil!');
window.location='login.php';</script>";
} else {
$msg = "Gagal mendaftar!";
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register - Caymira</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h2>Register</h2>
<?php if($msg != '') echo "<p style='color:red;'>$msg</p>"; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password"
required>
<button type="submit" name="register">DAFTAR SEKARANG</button>
</form>
<p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

</div>
</body>
</html>
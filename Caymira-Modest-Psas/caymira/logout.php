<?php
session_start();
// Menghancurkan sesi (menghapus data login dari browser)
session_destroy();
// Arahkan kembali ke halaman profil (yang sekarang akan mendeteksi user belum login)
header("Location: profile.php");
exit;
?>
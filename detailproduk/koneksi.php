<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "caymira_modest"; 

// Bikin koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi, kalau gagal langsung stop dan kasih tau errornya
if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}
?>
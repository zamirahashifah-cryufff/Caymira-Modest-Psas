<?php
$host     = "localhost";
$username = "root";      
$password = "";          
$database = "mbuh"; // Pastikan nama database-mu sama dengan yang di phpMyAdmin

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
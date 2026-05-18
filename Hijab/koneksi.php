<?php
$host     = "localhost";
$user     = "root"; 
$password = "";     
$db       = "caymira_modest"; 

$koneksi = mysqli_connect($host, $user, $password, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
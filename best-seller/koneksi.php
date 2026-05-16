<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "caymira_modest"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
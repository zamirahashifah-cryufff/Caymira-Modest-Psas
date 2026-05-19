<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "caymira_modest"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Gagal terhubung ke database"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data dari inputan
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $sql = "INSERT INTO contact (nama, email, subject, pesan) VALUES ('$nama', '$email', '$subject', '$pesan')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Terima kasih! Pesan Anda telah berhasil dikirim."]);
    } else {
        // Jika gagal
        echo json_encode(["status" => "error", "message" => "Maaf, terjadi kesalahan: " . mysqli_error($conn)]);
    }
}

mysqli_close($conn);
?>
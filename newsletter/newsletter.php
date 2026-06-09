<?php
header('Content-Type: application/json');

// KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "caymira_modest"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Cek apakah email sudah terdaftar
        $checkEmail = $conn->prepare("SELECT email FROM newsletter WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email ini sudah berlangganan!"]);
        } else {
            // Masukkan ke database
            $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Terima kasih telah berlangganan!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Terjadi kesalahan saat menyimpan."]);
            }
            $stmt->close();
        }
        $checkEmail->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Format email tidak valid."]);
    }
}
$conn->close();
?>
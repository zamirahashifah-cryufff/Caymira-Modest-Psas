<?php
error_reporting(0);
header('Content-Type: application/json');

// 1. Koneksi Database
$conn = new mysqli('localhost', 'root', '', 'mbuh'); // Sesuaikan nama DB-mu
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

// 2. Tangkap Order ID dari data form
$order_id = isset($_POST['order_id']) ? $conn->real_escape_string($_POST['order_id']) : '';

if (empty($order_id) || !isset($_FILES['bukti'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap atau gambar belum dipilih!']);
    exit;
}

$file = $_FILES['bukti'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];

// 3. Validasi Ekstensi Gambar
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'pdf'];

if (!in_array($fileExt, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Format file harus JPG, PNG, atau PDF!']);
    exit;
}

// 4. Validasi Ukuran File (Max 5MB)
if ($fileSize > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Ukuran file terlalu besar! Maksimal 5MB.']);
    exit;
}

// 5. Bikin Folder "uploads" kalau belum ada
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 6. Rename nama file biar unik (Contoh: bukti_CM-1715842900.jpg)
$newFileName = "bukti_" . $order_id . "." . $fileExt;
$fileDestination = $uploadDir . $newFileName;

// 7. Proses Pindahkan File & Update Database
if (move_uploaded_file($fileTmpName, $fileDestination)) {
    // Update nama file ke kolom bukti_pembayaran dan ubah status transaksi
    $sql = "UPDATE orders SET bukti_pembayaran = '$newFileName', transaction_status = 'settlement' WHERE order_id_midtrans = '$order_id'";
    
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Bukti pembayaran berhasil diunggah!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupdate database: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memindahkan file ke server']);
}

$conn->close();
?>
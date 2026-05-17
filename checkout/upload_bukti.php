<?php
// Tampilkan error jika ada masalah (Jangan diubah jadi 0 dulu)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// 1. Koneksi Database
$conn = new mysqli('localhost', 'root', '', 'mbuh');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

// 2. Cek apakah ada file yang dikirim
if (!isset($_FILES['bukti'])) {
    echo json_encode(['success' => false, 'message' => 'File tidak terbaca oleh PHP! Pastikan ukuran gambar kecil.']);
    exit;
}

// Cek apakah ada error bawaan dari PHP saat upload
if ($_FILES['bukti']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => 'Error Kode PHP: ' . $_FILES['bukti']['error']]);
    exit;
}

// 3. Tangkap Order ID
$order_id = isset($_POST['order_id']) ? $conn->real_escape_string($_POST['order_id']) : '';
if (empty($order_id)) {
    echo json_encode(['success' => false, 'message' => 'Order ID tidak ditemukan!']);
    exit;
}

$file = $_FILES['bukti'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];

// 4. Validasi Ekstensi Gambar
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'pdf'];

if (!in_array($fileExt, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Format file harus JPG, PNG, atau PDF!']);
    exit;
}

// 5. Validasi Ukuran File (Max 5MB)
if ($fileSize > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Ukuran file terlalu besar! Maksimal 5MB.']);
    exit;
}


// 6. Bikin Folder "uploads" TETAP DI DALAM FOLDER CHECKOUT
$uploadDir = __DIR__ . '/uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 7. Rename nama file biar super unik dengan tambahan jam/detik
$newFileName = "bukti_" . $order_id . "_" . time() . "." . $fileExt;
$fileDestination = $uploadDir . $newFileName;

// 7. Rename nama file biar super unik dengan tambahan jam/detik
$newFileName = "bukti_" . $order_id . "_" . time() . "." . $fileExt;
$fileDestination = $uploadDir . $newFileName;

// 8. Proses Pindahkan File & Update Database (KODE YANG BENAR)
if (move_uploaded_file($fileTmpName, $fileDestination)) {
    
    // Update database
    $sql = "UPDATE orders SET bukti_pembayaran = '$newFileName', transaction_status = 'settlement' WHERE order_id_midtrans = '$order_id'";
    
    if ($conn->query($sql)) {
        // TAMPILKAN ALAMAT ASLI FOLDERNYA DI POP-UP
        $lokasiAsli = realpath($uploadDir);
        echo json_encode([
            'success' => true, 
            'message' => "BERHASIL! \nLokasi file aslimu ada di: \n" . $lokasiAsli . "\\" . $newFileName
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupdate database: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memindahkan file ke server folder uploads/']);
}

$conn->close();
?>
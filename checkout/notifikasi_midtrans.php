<?php
// Tangkap data yang dikirim oleh Midtrans
$json_result = file_get_contents('php://input');
$data = json_decode($json_result, true);

if (!$data) {
    exit; // Kalau tidak ada data, hentikan script
}

// ==========================================
// 1. PENGATURAN DATABASE & KEY
// ==========================================
$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '';     
$db_name = 'caymira_modest'; 

// SERVER KEY (Wajib sama dengan yang ada di proses_checkout.php)
$server_key = 'Mid-server--5pWdULYOML7ZVMv597RI_q8'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    exit;
}

// ==========================================
// 2. AMBIL DATA DARI NOTIFIKASI MIDTRANS
// ==========================================
$order_id           = $conn->real_escape_string($data['order_id']);
$transaction_status = $conn->real_escape_string($data['transaction_status']);
$payment_type       = $conn->real_escape_string($data['payment_type']);
$transaction_id     = $conn->real_escape_string($data['transaction_id']);
$transaction_time   = $conn->real_escape_string($data['transaction_time']);
$gross_amount       = $data['gross_amount'];
$status_code        = $data['status_code'];
$signature_key      = $data['signature_key'];

// ==========================================
// 3. KEAMANAN: CEK SIGNATURE KEY
// ==========================================
// Ini untuk memastikan bahwa yang kirim data benar-benar Midtrans, bukan hacker
$my_signature_key = hash('sha512', $order_id . $status_code . $gross_amount . $server_key);

if ($signature_key !== $my_signature_key) {
    echo "Palsu!";
    exit; // Berhenti kalau signature tidak cocok
}

// ==========================================
// 4. UPDATE STATUS DI DATABASE
// ==========================================
$status_pesanan = 'pending';

// Terjemahkan status dari Midtrans ke status toko kamu
if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
    $status_pesanan = 'lunas'; // Uang sudah masuk
} else if ($transaction_status == 'pending') {
    $status_pesanan = 'pending'; // Sedang nunggu bayar (misal di Indomaret/VA)
} else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
    $status_pesanan = 'batal'; // Gagal, kedaluwarsa, atau dibatalkan
}

// Update tabel orders
$sql_update_order = "UPDATE orders SET status = '$status_pesanan' WHERE order_id = '$order_id'";
$conn->query($sql_update_order);

// Simpan jejak/log ke tabel payment_logs
$sql_log = "INSERT INTO payment_logs (order_id, midtrans_transaction_id, payment_type, transaction_status, transaction_time) 
            VALUES ('$order_id', '$transaction_id', '$payment_type', '$transaction_status', '$transaction_time')";
$conn->query($sql_log);

// Kasih tahu Midtrans kalau kita sudah terima pesannya dengan baik
http_response_code(200);
echo "OK";

$conn->close();
?>
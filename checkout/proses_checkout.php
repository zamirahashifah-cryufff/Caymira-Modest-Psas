<?php
error_reporting(0);
// Izinkan akses dari frontend
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// ==========================================
// 1. PENGATURAN DATABASE & MIDTRANS
// ==========================================
$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '';     
$db_name = 'mbuh'; // Pastikan nama database-nya benar

// Masukkan SERVER KEY dari Midtrans Sandbox kamu di sini!
$server_key = 'Mid-server--5pWdULYOML7ZVMv597RI_q8'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Koneksi DB Gagal']);
    exit;
}

// ==========================================
// 2. TANGKAP DATA DARI HTML
// ==========================================
$json_input = file_get_contents('php://input');
$data = json_decode($json_input, true);

if (!$data) {
    echo json_encode(['error' => 'Data kosong']);
    exit;
}

// ==========================================
// 2. TANGKAP DATA DARI HTML (VERSI KEBAL ERROR)
// ==========================================
$json_input = file_get_contents('php://input');
$data = json_decode($json_input, true);

if (!$data) {
    echo json_encode(['error' => 'Data kosong']);
    exit;
}

// Tambahkan isset() supaya kalau data kosong, PHP nggak ngeluarin tulisan Warning
$nama     = isset($data['nama']) ? $conn->real_escape_string($data['nama']) : '';
$telepon  = isset($data['wa']) ? $conn->real_escape_string($data['wa']) : '';
$email    = isset($data['email']) ? $conn->real_escape_string($data['email']) : '';
$alamat   = isset($data['alamat']) ? $conn->real_escape_string($data['alamat']) : '';
$kota     = isset($data['kota']) ? $conn->real_escape_string($data['kota']) : '';
$kode_pos = isset($data['kodepos']) ? $conn->real_escape_string($data['kodepos']) : '';

$order_id_midtrans = 'CM-' . time(); 
// Ambil total harga yang dikirim dari JavaScript. Kalau tidak ada, default ke 0
$total = isset($data['total']) ? intval($data['total']) : 0;

// ==========================================
// 3. SIMPAN KE TABEL "orders" (Tabel Barumu)
// ==========================================
$sql = "INSERT INTO orders 
        (nama, email, telepon, alamat, kota, kode_pos, total, status_pembayaran, order_id_midtrans, transaction_status) 
        VALUES 
        ('$nama', '$email', '$telepon', '$alamat', '$kota', '$kode_pos', $total, 'Belum Dibayar', '$order_id_midtrans', 'pending')";

if (!$conn->query($sql)) {
    echo json_encode(['error' => 'Gagal simpan ke DB: ' . $conn->error]);
    exit;
}

// ==========================================
// 4. MINTA TOKEN KE MIDTRANS
// ==========================================
$payload = [
    'transaction_details' => [
        'order_id'     => $order_id_midtrans,
        'gross_amount' => $total,
    ],
    'customer_details' => [
        'first_name'       => $nama,
        'email'            => $email,
        'phone'            => $telepon,
        'shipping_address' => [
            'address'     => $alamat,
            'city'        => $kota,
            'postal_code' => $kode_pos
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode($server_key . ':')
]);

$response = curl_exec($ch);
curl_close($ch);

$midtrans_result = json_decode($response, true);

// ==========================================
// 5. KEMBALIKAN TOKEN & UPDATE DB
// ==========================================
if (isset($midtrans_result['token'])) {
    $snap_token = $midtrans_result['token'];
    
    // Simpan token ke database
    $conn->query("UPDATE orders SET snap_token = '$snap_token' WHERE order_id_midtrans = '$order_id_midtrans'");

    echo json_encode([
        'token' => $snap_token,
        'order_id' => $order_id_midtrans
    ]);
} else {
    echo json_encode(['error' => 'Gagal dapat token', 'detail' => $midtrans_result]);
}

$conn->close();
?>
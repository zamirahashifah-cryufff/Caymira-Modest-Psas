<?php
include 'koneksi.php';
header('Content-Type: application/json');

// Ambil data JSON yang dikirim oleh Javascript
$data = json_decode(file_get_contents("php://input"), true);

if($data) {
    $subtotal = $data['subtotal'];
    $diskon = $data['diskon'];
    $grandTotal = $data['grandTotal'];
    $cart = $data['cart']; 

    // 1. Simpan ke tabel 'pesanan' (Sesuai database kamu)
    $queryOrder = "INSERT INTO pesanan (total_belanja, diskon, grand_total) VALUES ('$subtotal', '$diskon', '$grandTotal')";
    
    if(mysqli_query($conn, $queryOrder)) {
        // Ambil ID pesanan yang baru saja dibuat
        $order_id = mysqli_insert_id($conn); 

        // 2. Simpan setiap produk ke tabel 'item_pesanan' (Sesuai database kamu)
        foreach($cart as $item) {
            $nama = mysqli_real_escape_string($conn, $item['name']);
            $harga = $item['price'];
            $qty = $item['quantity'];
            $subtotal_item = $harga * $qty;

            $queryItem = "INSERT INTO item_pesanan (order_id, nama_produk, harga, qty, subtotal)
                          VALUES ('$order_id', '$nama', '$harga', '$qty', '$subtotal_item')";
            mysqli_query($conn, $queryItem);
        }

        echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan pesanan: " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data keranjang kosong"]);
}
?>
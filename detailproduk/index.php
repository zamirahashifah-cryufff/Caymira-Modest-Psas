<?php
include '../detailproduk/koneksi.php'; 

$db_koneksi = isset($koneksi) ? $koneksi : (isset($conn) ? $conn : null);

if (!$db_koneksi) {
    die("Waduh, koneksi database gagal!");
}

$id_produk = isset($_GET['id']) ? mysqli_real_escape_string($db_koneksi, $_GET['id']) : '';
$kategori  = isset($_GET['kategori']) ? mysqli_real_escape_string($db_koneksi, $_GET['kategori']) : '';

// Data default jika gagal
$nama_produk = "Produk Tidak Ditemukan";
$harga_asli = 0;
$harga_diskon = 0;
$deskripsi = "Deskripsi produk belum tersedia.";
$spesifikasi = "Spesifikasi belum tersedia.";
$pengiriman = "Pengiriman dikirim dari gudang pusat Caymira. Estimasi 2-3 hari kerja.";
$info_ulasan = "Belum ada ulasan tertulis untuk produk ini.";
$gambar_utama = "default.png";
$ulasan = rand(50, 200);

// Tambahkan semua kemungkinan nama tabel
$tabel_valid = ['koko', 'gamis', 'hijab', 'jubah', 'bestseller', 'best-seller', 'best_seller'];

if (!empty($id_produk) && in_array($kategori, $tabel_valid)) {
    
    $result = false;
    
    // HELM PELINDUNG (TRY-CATCH)
    try {
        $query = "SELECT * FROM `$kategori` WHERE id_produk = '$id_produk'";
        $result = mysqli_query($db_koneksi, $query);
    } catch (Exception $e) {
        try {
            $query = "SELECT * FROM `$kategori` WHERE id = '$id_produk'";
            $result = mysqli_query($db_koneksi, $query);
        } catch (Exception $e2) {
            $result = false; 
        }
    }
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $nama_produk = isset($row['nama_produk']) ? $row['nama_produk'] : 'Produk Caymira';
        $harga_asli = isset($row['harga_asli']) ? $row['harga_asli'] : (isset($row['harga_coret']) ? $row['harga_coret'] : 0);
        $harga_diskon = isset($row['harga_diskon']) ? $row['harga_diskon'] : (isset($row['harga']) ? $row['harga'] : 0);
        
        // ========================================================
        // DI SINI TEMPATNYA BOS! (Penangkap data 4 Tab)
        // ========================================================
        $deskripsi = isset($row['deskripsi']) && !empty($row['deskripsi']) ? nl2br($row['deskripsi']) : "Deskripsi produk belum tersedia.";
        $spesifikasi = isset($row['spesifikasi']) && !empty($row['spesifikasi']) ? nl2br($row['spesifikasi']) : "Spesifikasi belum tersedia.";
        $pengiriman = isset($row['pengiriman']) && !empty($row['pengiriman']) ? nl2br($row['pengiriman']) : "Pengiriman dikirim dari gudang pusat Caymira. Estimasi 2-3 hari kerja.";
        $info_ulasan = isset($row['info_ulasan']) && !empty($row['info_ulasan']) ? nl2br($row['info_ulasan']) : "Belum ada ulasan tertulis untuk produk ini.";
        // ========================================================

        // JURUS PENCERAHAN (LANGSUNG TEMBAK KE RUMAH TETANGGA)
        if (isset($row['gambar'])) {
            $db_gambar = $row['gambar'];
            if (strpos($db_gambar, 'http') === 0) {
                $gambar_utama = $db_gambar;
            } elseif (strpos($db_gambar, 'gambar ') === 0) {
                $gambar_utama = '../best-seller/' . $db_gambar;
            } else {
                $gambar_utama = '../Beranda/Gambarberanda/' . $db_gambar;
            }
        }
        
        if(isset($row['total_ulasan'])) $ulasan = $row['total_ulasan'];
        if(isset($row['ulasan'])) $ulasan = $row['ulasan'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
/* === VARIABEL WARNA & FONT === */
:root {
    --navy: #0a1628;
    --navy-light: #0f1d35;
    --navy-lighter: #152238;
    --gold: #c9a84c;
    --gold-light: #d4b76a;
    --gold-dark: #b8963f;
    --gold-glow: rgba(201, 168, 76, 0.4);
    --text-light: #e8e8e8;
    --text-muted: #a0a0a0;
    --white: #ffffff;
    --bg-dark: #0a1118;
    --bg-card: #141e2a;
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Poppins', sans-serif;
}

/* === RESET & GLOBAL === */
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    background-color: var(--navy);
    color: var(--text-light);
    font-family: var(--font-body);
    line-height: 1.6;
    overflow-x: hidden;
}
a { text-decoration: none; color: inherit; transition: color 0.3s ease; }
img { max-width: 100%; height: auto; }
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Custom Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: var(--navy); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

/* === CUSTOM CURSOR === */
.custom-cursor {
    width: 20px;
    height: 20px;
    border: 2px solid var(--gold);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 99999;
    transition: transform 0.1s, background 0.3s;
    mix-blend-mode: difference;
}
.custom-cursor.hover {
    transform: scale(2);
    background: rgba(201, 168, 76, 0.2);
}
.cursor-dot {
    width: 6px;
    height: 6px;
    background: var(--gold);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 99999;
}

/* === LOADING SCREEN === */
.loader {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: var(--navy);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    transition: opacity 0.6s, visibility 0.6s;
}
.loader.hidden {
    opacity: 0;
    visibility: hidden;
}
.loader-text {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    color: var(--gold);
    animation: loaderPulse 1.5s ease-in-out infinite;
}
.loader-bar {
    width: 200px;
    height: 2px;
    background: rgba(201, 168, 76, 0.2);
    margin-top: 30px;
    border-radius: 2px;
    overflow: hidden;
}
.loader-progress {
    height: 100%;
    background: var(--gold);
    width: 0%;
    animation: loadProgress 2s ease forwards;
}
@keyframes loaderPulse {
    0%, 100% { opacity: 0.4; letter-spacing: 2px; }
    50% { opacity: 1; letter-spacing: 8px; }
}
@keyframes loadProgress {
    0% { width: 0%; }
    100% { width: 100%; }
}

/* === NAVBAR === */
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    height: 70px;
    padding: 0 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    background: rgba(7, 13, 23, 0.98);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(201, 168, 76, 0.6);
    transition: all 0.3s ease;
    overflow: visible;
}
.navbar.scrolled {
    padding: 0 60px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.logo-img {
    height: 75px;    
    width: auto;       
    object-fit: contain;
    transition: all 0.3s;
    margin-top: 5px;        
    position: relative;
    z-index: 1001;
}
.logo:hover .logo-img {
    transform: scale(1.05);
    filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.5));     
}
.nav-links {
    display: flex;
    gap: 45px;
    list-style: none;
}
.nav-links a {
    color: var(--text-light);
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    position: relative;
    padding: 5px 0;
    transition: color 0.3s;
}
.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--gold);
    transition: width 0.3s;
}
.nav-links a:hover, .nav-links a.active {
    color: var(--gold);
}
.nav-links a:hover::after, .nav-links a.active::after {
    width: 100%;
}
.nav-icons {
    display: flex;
    gap: 25px;
    align-items: center;
}
.nav-icons i {
    font-size: 18px;
    color: var(--text-light);
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
}
.nav-icons i:hover {
    color: var(--gold);
    transform: scale(1.2) rotate(5deg);
}
.cart-icon {
    position: relative;
    display: flex;
    align-items: center;
}
.cart-badge {
    position: absolute;
    top: -8px; right: -8px;
    background: var(--gold);
    color: var(--navy);
    font-size: 10px;
    font-weight: 700;
    width: 18px; height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Search Overlay */
.search-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(10, 22, 40, 0.98);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s;
}
.search-overlay.active {
    opacity: 1;
    visibility: visible;
}
.search-box {
    width: 60%;
    max-width: 600px;
    position: relative;
}
.search-box input {
    width: 100%;
    padding: 20px 60px 20px 0;
    background: transparent;
    border: none;
    border-bottom: 2px solid var(--gold);
    color: var(--gold);
    font-size: 32px;
    font-family: 'Playfair Display', serif;
    outline: none;
}
.search-box input::placeholder { color: rgba(201, 168, 76, 0.4); }
.search-close {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gold);
    font-size: 28px;
    cursor: pointer;
    transition: transform 0.3s;
}
.search-close:hover { transform: translateY(-50%) rotate(90deg); }

/* Mobile Menu */
.mobile-menu-btn {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    z-index: 1001;
    padding: 5px;
}
.mobile-menu-btn span {
    width: 24px;
    height: 2px;
    background: var(--gold);
    transition: all 0.3s;
    border-radius: 2px;
}
.mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}
.mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
    transform: translateX(-20px);
}
.mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* === BREADCRUMB === */
.breadcrumb {
    padding: 100px 0 20px;
    font-size: 13px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 10px;
}
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb i { font-size: 10px; color: var(--gold); }
.breadcrumb span:last-child { color: var(--gold); }

/* === PRODUCT DETAIL === */
.product-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    padding: 20px 0 80px;
}
.product-images {
    position: sticky;
    top: 90px;
    height: fit-content;
}
.main-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(201, 168, 76, 0.15);
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.03), rgba(201, 168, 76, 0.01));
    transition: all 0.5s ease;
}
.main-image-wrapper:hover {
    border-color: rgba(201, 168, 76, 0.3);
    box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 40px rgba(201, 168, 76, 0.1);
}
.main-image {
    width: 100%;
    height: 600px;
    object-fit: contain;
    padding: 40px;
    transition: transform 0.6s ease;
    cursor: zoom-in;
}
.main-image-wrapper:hover .main-image {
    transform: scale(1.05);
}
.image-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.3);
    animation: badgePulse 2s ease-in-out infinite;
}
@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.image-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    background: rgba(10, 22, 40, 0.7);
    border: 1px solid rgba(201, 168, 76, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    cursor: pointer;
    transition: all 0.3s;
    z-index: 2;
    backdrop-filter: blur(5px);
}
.image-nav:hover {
    background: var(--gold);
    color: var(--navy);
    transform: translateY(-50%) scale(1.1);
}
.image-nav.prev { left: 15px; }
.image-nav.next { right: 15px; }
.thumbnail-row {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    justify-content: center;
}
.thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    border: 2px solid transparent;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(201, 168, 76, 0.03);
    padding: 5px;
}
.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s;
}
.thumbnail:hover {
    border-color: rgba(201, 168, 76, 0.3);
    transform: translateY(-5px);
}
.thumbnail.active {
    border-color: var(--gold);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.2);
    transform: translateY(-5px);
}
.thumbnail.active img {
    transform: scale(1.1);
}

/* Product Info */
.product-info {
    padding-top: 10px;
}
.product-brand {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(201, 168, 76, 0.1);
    border: 1px solid rgba(201, 168, 76, 0.2);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
}
.product-brand i { font-size: 14px; }
.product-title {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--white);
    line-height: 1.2;
    margin-bottom: 15px;
    position: relative;
}
.product-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), transparent);
}
.rating-row {
    display: flex;
    align-items: center;
    gap: 15px;
    margin: 25px 0 30px;
}
.stars {
    color: var(--gold);
    font-size: 14px;
    display: flex;
    gap: 3px;
}
.rating-count {
    font-size: 13px;
    color: var(--text-muted);
}
.rating-count span { color: var(--gold); font-weight: 600; }
.review-link {
    font-size: 13px;
    color: var(--gold);
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: all 0.3s;
}
.review-link:hover { color: var(--gold-light); }

/* Price */
.price-section {
    margin: 30px 0;
    padding: 25px 0;
    border-top: 1px solid rgba(201, 168, 76, 0.1);
    border-bottom: 1px solid rgba(201, 168, 76, 0.1);
}
.price-main {
    font-size: 36px;
    font-weight: 700;
    color: var(--gold);
    display: flex;
    align-items: center;
    gap: 15px;
}
.price-main::before {
    content: '';
    width: 30px;
    height: 2px;
    background: var(--gold);
}
.price-original {
    font-size: 18px;
    color: var(--text-muted);
    text-decoration: line-through;
    margin-left: 10px;
    opacity: 0.6;
}
.price-discount {
    display: inline-block;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-left: 10px;
}

/* Guarantees */
.guarantee-row {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}
.guarantee-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(201, 168, 76, 0.05);
    border: 1px solid rgba(201, 168, 76, 0.1);
    padding: 12px 18px;
    border-radius: 12px;
    transition: all 0.3s;
    cursor: pointer;
}
.guarantee-item:hover {
    background: rgba(201, 168, 76, 0.1);
    border-color: rgba(201, 168, 76, 0.3);
    transform: translateY(-2px);
}
.guarantee-item i {
    font-size: 20px;
    color: var(--gold);
}
.guarantee-text {
    font-size: 12px;
    line-height: 1.4;
}
.guarantee-text strong {
    display: block;
    color: var(--white);
    font-weight: 600;
    font-size: 13px;
}
.guarantee-text span {
    color: var(--text-muted);
    font-size: 11px;
}

/* Color Selection */
.color-section {
    margin-bottom: 25px;
}
.section-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--white);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-label span {
    color: var(--text-muted);
    font-weight: 400;
}
.color-options {
    display: flex;
    gap: 12px;
}
.color-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 3px solid transparent;
    cursor: pointer;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}
.color-btn::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    border-radius: 50%;
    border: 2px solid transparent;
    transition: all 0.3s;
}
.color-btn:hover { transform: scale(1.15); }
.color-btn.active {
    border-color: var(--gold);
    box-shadow: 0 0 20px rgba(201, 168, 76, 0.4);
    transform: scale(1.1);
}
.color-btn.active::after {
    border-color: var(--navy);
}
.color-gradient {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

/* Size Selection */
.size-section {
    margin-bottom: 30px;
}
.size-options {
    display: flex;
    gap: 12px;
}
.size-btn {
    width: 50px;
    height: 50px;
    border: 2px solid rgba(201, 168, 76, 0.2);
    background: transparent;
    color: var(--text-light);
    border-radius: 12px;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.size-btn::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 0;
}
.size-btn span {
    position: relative;
    z-index: 1;
}
.size-btn:hover {
    border-color: var(--gold);
    color: var(--gold);
    transform: translateY(-3px);
}
.size-btn.active {
    border-color: var(--gold);
    color: var(--navy);
}
.size-btn.active::before {
    opacity: 1;
}
.size-btn.active:hover {
    color: var(--navy);
}

/* Quantity */
.quantity-section {
    margin-bottom: 30px;
}
.quantity-wrapper {
    display: inline-flex;
    align-items: center;
    border: 2px solid rgba(201, 168, 76, 0.2);
    border-radius: 12px;
    overflow: hidden;
    background: rgba(201, 168, 76, 0.03);
}
.qty-btn {
    width: 45px;
    height: 45px;
    background: transparent;
    border: none;
    color: var(--gold);
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.qty-btn:hover {
    background: rgba(201, 168, 76, 0.1);
}
.qty-input {
    width: 60px;
    height: 45px;
    background: transparent;
    border: none;
    color: var(--white);
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    outline: none;
    font-family: var(--font-body);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
}
.btn-cart, .btn-buy {
    flex: 1;
    padding: 18px 30px;
    border-radius: 30px;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
}
.btn-cart {
    background: transparent;
    border: 2px solid var(--gold);
    color: var(--gold);
}
.btn-cart::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.2), transparent);
    transition: left 0.5s;
}
.btn-cart:hover::before { left: 100%; }
.btn-cart:hover {
    background: rgba(201, 168, 76, 0.1);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(201, 168, 76, 0.2);
}
.btn-buy {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
}
.btn-buy::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.btn-buy:hover::before { left: 100%; }
.btn-buy:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
}

/* Wishlist & Share */
.wishlist-share {
    display: flex;
    gap: 20px;
    margin-bottom: 40px;
}
.wishlist-btn, .share-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    font-family: var(--font-body);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    padding: 8px 0;
}
.wishlist-btn:hover, .share-btn:hover {
    color: var(--gold);
}
.wishlist-btn i {
    font-size: 18px;
    transition: all 0.3s;
}
.wishlist-btn:hover i {
    transform: scale(1.2);
    color: #e74c3c;
}
.wishlist-btn.active i {
    color: #e74c3c;
}
.share-btn i { font-size: 16px; }

/* Tabs */
.product-tabs {
    margin-top: 40px;
    border-top: 1px solid rgba(201, 168, 76, 0.1);
    padding-top: 30px;
}
.tab-header {
    display: flex;
    gap: 30px;
    margin-bottom: 25px;
    border-bottom: 1px solid rgba(201, 168, 76, 0.1);
    padding-bottom: 15px;
}
.tab-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    padding: 5px 0;
    position: relative;
    transition: all 0.3s;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.tab-btn::after {
    content: '';
    position: absolute;
    bottom: -16px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--gold);
    transition: width 0.3s;
}
.tab-btn:hover { color: var(--gold); }
.tab-btn.active {
    color: var(--gold);
    font-weight: 600;
}
.tab-btn.active::after { width: 100%; }
.tab-content {
    display: none;
    animation: fadeIn 0.5s ease;
}
.tab-content.active { display: block; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.tab-content p {
    color: var(--text-muted);
    line-height: 1.8;
    font-size: 14px;
}
.tab-content ul {
    list-style: none;
    padding: 0;
}
.tab-content ul li {
    padding: 8px 0;
    color: var(--text-muted);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid rgba(201, 168, 76, 0.05);
}
.tab-content ul li i {
    color: var(--gold);
    font-size: 12px;
}


/* === RELATED PRODUCTS === */
.related-products {
    padding: 80px 0;
    position: relative;
}
.related-products::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.3), transparent);
}
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}
.section-header h3 {
    font-family: var(--font-heading);
    font-size: 32px;
    color: var(--gold);
    position: relative;
    display: inline-block;
}
.section-header h3::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 2px;
    background: var(--gold);
}
.view-all {
    color: var(--gold);
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}
.view-all:hover { gap: 12px; color: var(--gold-light); }
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
}
.product-card {
    background: rgba(201, 168, 76, 0.03);
    border: 1px solid rgba(201, 168, 76, 0.1);
    border-radius: 16px;
    padding: 25px;
    position: relative;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    cursor: pointer;
}
.product-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.08) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.5s;
}
.product-card:hover::before { opacity: 1; }
.product-card:hover {
    transform: translateY(-15px) scale(1.02);
    border-color: rgba(201, 168, 76, 0.3);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(201, 168, 76, 0.1);
}
.badge-new {
    position: absolute;
    top: 30px;
    left: 30px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    font-size: 10px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 20px;
    z-index: 2;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.3);
}
.product-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 25px;
}
.product-img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.6s ease;
}
.product-card:hover .product-img { transform: scale(1.08); }
.product-img-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 20px;
    background: linear-gradient(to top, rgba(10, 22, 40, 0.8), transparent);
    opacity: 0;
    transition: opacity 0.4s;
    display: flex;
    justify-content: center;
}
.product-card:hover .product-img-overlay { opacity: 1; }
.quick-view-btn {
    background: var(--gold);
    color: var(--navy);
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}
.quick-view-btn:hover {
    background: var(--gold-light);
    transform: scale(1.05);
}
.product-info h4 {
    font-size: 17px;
    margin-bottom: 10px;
    font-weight: 500;
    color: var(--text-light);
    transition: color 0.3s;
}
.product-card:hover .product-info h4 { color: var(--gold-light); }
.product-price {
    color: var(--gold);
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.product-price::before {
    content: '';
    width: 20px;
    height: 1px;
    background: var(--gold);
    opacity: 0.5;
}
.stars {
    color: var(--gold);
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.stars span {
    color: var(--text-muted);
    margin-left: 5px;
    font-size: 12px;
}

/* === FOOTER === */
.footer {
    background: #ffffff;
    border-top: 1px solid rgba(201, 168, 76, 0.15);
    padding: 50px 60px 30px;
    position: relative;
    margin-top: 50px;
}
.gold-branch-footer {
    position: absolute;
    left: -30px;
    top: -70px;
    width: 200px;
    opacity: 0.5;
    pointer-events: none;
}
.footer-content {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr;
    gap: 35px;
    max-width: 1300px;
    margin: 0 auto;
}
.footer-brand .logo-main {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: var(--gold);
    font-weight: 600;
    margin-bottom: 3px;
}
.footer-brand .logo-sub {
    font-size: 9px;
    color: var(--gold);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.footer-brand p {
    font-size: 12px;
    line-height: 1.8;
    color: #666;
    max-width: 230px;
}
.social-links {
    display: flex;
    gap: 12px;
    margin-top: 18px;
}
.social-links a {
    width: 36px;
    height: 36px;
    border: 1px solid rgba(201, 168, 76, 0.35);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    text-decoration: none;
    transition: all 0.3s;
    font-size: 14px;
    position: relative;
    overflow: hidden;
}
.social-links a::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: var(--gold);
    transform: scale(0);
    transition: transform 0.3s;
    border-radius: 50%;
}
.social-links a:hover::before { transform: scale(1); }
.social-links a:hover {
    color: var(--navy);
    transform: translateY(-3px);
}
.social-links a i {
    position: relative;
    z-index: 1;
}
.footer-title {
    color: var(--gold);
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 22px;
    position: relative;
    display: inline-block;
}
.footer-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 35px;
    height: 2px;
    background: var(--gold);
    transition: width 0.3s;
}
.footer-col:hover .footer-title::after { width: 100%; }
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a {
    color: #888;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.footer-links a::before {
    content: '->';
    color: var(--gold);
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s;
}
.footer-links a:hover {
    color: var(--gold);
    transform: translateX(4px);
}
.footer-links a:hover::before {
    opacity: 1;
    transform: translateX(0);
}
.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 15px;
    color: #888;
    font-size: 13px;
    transition: all 0.3s;
    cursor: pointer;
}
.contact-item:hover {
    color: var(--gold);
    transform: translateX(5px);
}
.contact-item i {
    color: var(--gold);
    margin-top: 3px;
    font-size: 14px;
    width: 18px;
    transition: transform 0.3s;
}
.contact-item:hover i { transform: scale(1.2); }
.newsletter-text {
    font-size: 12px;
    color: #888;
    line-height: 1.6;
    margin-bottom: 18px;
}
.newsletter-form {
    display: flex;
    border: 1px solid rgba(201, 168, 76, 0.25);
    border-radius: 4px;
    overflow: hidden;
    transition: all 0.3s;
    position: relative;
}
.newsletter-form:focus-within {
    border-color: var(--gold);
    box-shadow: 0 0 20px rgba(201, 168, 76, 0.2);
}
.newsletter-form input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 12px 14px;
    color: #333;
    font-size: 13px;
    outline: none;
}
.newsletter-form input::placeholder { color: #aaa; }
.newsletter-form button {
    background: var(--gold);
    border: none;
    padding: 0 20px;
    color: var(--navy);
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.newsletter-form button::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    width: 0; height: 0;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}
.newsletter-form button:hover::before {
    width: 300px; height: 300px;
}
.newsletter-form button:hover { background: var(--gold-light); }
.newsletter-form button i {
    font-size: 14px;
    position: relative;
    z-index: 1;
}
.footer-bottom {
    text-align: center;
    padding-top: 35px;
    margin-top: 35px;
    border-top: 1px solid rgba(201, 168, 76, 0.15);
    font-size: 12px;
    color: #ffffff;
    background-color: #000000;
    padding-bottom: 35px;
    margin-left: -60px;
    margin-right: -60px;
}

/* Toast */
.toast {
    position: fixed;
    bottom: 90px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: var(--gold);
    color: var(--navy);
    padding: 16px 32px;
    border-radius: 50px;
    font-weight: 500;
    font-size: 14px;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 10000;
    box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4);
    display: flex;
    align-items: center;
    gap: 10px;
}
.toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
.toast i { font-size: 18px; }

/* Scroll to top */
.scroll-top {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 45px;
    height: 45px;
    background: var(--gold);
    color: var(--navy);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    z-index: 999;
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4);
    font-size: 16px;
}
.scroll-top.visible { opacity: 1; visibility: visible; }
.scroll-top:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.5);
}

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive */
@media (max-width: 1024px) {
    .product-detail { grid-template-columns: 1fr; gap: 40px; }
    .product-images { position: relative; top: 0; }
    .main-image { height: 450px; }
    .product-grid { grid-template-columns: repeat(2, 1fr); }
    .footer-content { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
    .navbar { padding: 0 30px; }
    .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 75%;
        height: 100vh;
        background: var(--navy);
        flex-direction: column;
        padding: 100px 40px;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 1px solid rgba(201, 168, 76, 0.2);
        gap: 30px;
    }
    .nav-links.active { right: 0; }
    .mobile-menu-btn { display: flex; }
    .main-image { height: 350px; }
    .product-title { font-size: 28px; }
    .price-main { font-size: 28px; }
    .action-buttons { flex-direction: column; }
    .product-grid { grid-template-columns: 1fr; }
    .footer { padding: 35px 30px 25px; }
    .footer-content { grid-template-columns: 1fr; gap: 25px; }
    .footer-bottom { margin-left: -30px; margin-right: -30px; }
    .custom-cursor, .cursor-dot { display: none; }
    .guarantee-row { flex-direction: column; }
    .tab-header { gap: 15px; flex-wrap: wrap; }
}
    </style>
<base target="_blank">
</head>
<body>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari produk..." id="searchInput">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../Contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearch()"></i>
           <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
           <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="container">
        <div class="breadcrumb">
            <a href="../Beranda/beranda.php">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <span>Detail-Produk</span>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="container product-detail">
       <div class="main-image-wrapper">
                <span class="image-badge">Caymira</span>
               <img src="<?php echo $gambar_utama; ?>" id="mainImage" alt="<?php echo $nama_produk; ?>" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            
          <div class="product-info">
            <div class="product-brand">
                <i class="fas fa-certificate"></i>
                Caymira Original
            </div>

            <h1 class="product-title"><?php echo htmlspecialchars($nama_produk); ?></h1>

            <div class="rating-row">
                <div class="stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                
            </div>

            <div class="price-section">
                <div class="price-main">
                    Rp <?php echo number_format($harga_diskon, 0, ',', '.'); ?>
                    
                    <?php if($harga_asli > $harga_diskon): ?>
                        <span class="price-original">Rp <?php echo number_format($harga_asli, 0, ',', '.'); ?></span>
                        <?php 
                            // Hitung persentase diskon otomatis!
                            $persen = round((($harga_asli - $harga_diskon) / $harga_asli) * 100); 
                        ?>
                        <span class="price-discount">-<?php echo $persen; ?>%</span>
                    <?php endif; ?>
                </div>
            </div>
           

           

            <div class="guarantee-row">
                <div class="guarantee-item" onclick="showToast('✅ Garansi 100% Original Caymira')">
                    <i class="fas fa-shield-alt"></i>
                    <div class="guarantee-text">
                        <strong>100% Ori</strong>
                        <span>Uang kembali jika tidak ori</span>
                    </div>
                </div>
                <div class="guarantee-item" onclick="showToast('🔄 Bebas pengembalian dalam 7 hari')">
                    <i class="fas fa-undo"></i>
                    <div class="guarantee-text">
                        <strong>Return</strong>
                        <span>Bebas pengembalian</span>
                    </div>
                </div>
                <div class="guarantee-item" onclick="showToast('🛡️ Perlindungan kerusakan total hingga 6 bulan')">
                    <i class="fas fa-shield-halved"></i>
                    <div class="guarantee-text">
                        <strong>Proteksi</strong>
                        <span>Kerusakan total +6 bulan</span>
                    </div>
                </div>
                <div class="guarantee-item" onclick="showToast('🚚 Gratis Ongkir untuk pembelian minimal Rp500.000')">
                    <i class="fas fa-truck"></i>
                    <div class="guarantee-text">
                        <strong>Pengiriman</strong>
                        <span>Gratis ongkir</span>
                    </div>
                </div>
            </div>

            <!-- Color Selection -->
            <div class="color-section">
                <div class="section-label">Warna <span>- Gradasi Hitam Putih</span></div>
                <div class="color-options">
                    <div class="color-btn active" onclick="selectColor(this, 'Gradasi Hitam Putih')">
                        <div class="color-gradient" style="background: linear-gradient(135deg, #2a2a2a 50%, #e8e8e8 50%);"></div>
                    </div>
                    <div class="color-btn" onclick="selectColor(this, 'Navy Gold')">
                        <div class="color-gradient" style="background: linear-gradient(135deg, #0a1628 50%, #c9a84c 50%);"></div>
                    </div>
                    <div class="color-btn" onclick="selectColor(this, 'Full Black')">
                        <div class="color-gradient" style="background: #1a1a1a;"></div>
                    </div>
                    <div class="color-btn" onclick="selectColor(this, 'Cream')">
                        <div class="color-gradient" style="background: #f5e6cc;"></div>
                    </div>
                </div>
            </div>

            <!-- Size Selection -->
            <div class="size-section">
                <div class="section-label">Ukuran <span>- Pilih ukuran Anda</span></div>
                <div class="size-options">
                    <button class="size-btn" onclick="selectSize(this)"><span>S</span></button>
                    <button class="size-btn active" onclick="selectSize(this)"><span>M</span></button>
                    <button class="size-btn" onclick="selectSize(this)"><span>L</span></button>
                    <button class="size-btn" onclick="selectSize(this)"><span>XL</span></button>
                    <button class="size-btn" onclick="selectSize(this)"><span>XXL</span></button>
                </div>
            </div>

            <!-- Quantity -->
            <div class="quantity-section">
                <div class="section-label">Kuantitas</div>
                <div class="quantity-wrapper">
                    <button class="qty-btn" onclick="updateQty(-1)"><i class="fas fa-minus"></i></button>
                    <input type="text" class="qty-input" value="1" id="qtyInput" readonly>
                    <button class="qty-btn" onclick="updateQty(1)"><i class="fas fa-plus"></i></button>
                </div>
            </div>

            <!-- Action Buttons -->
    <?php 
    // Kita cek semua kemungkinan nama variabel harganya biar gak lolos!
    $harga_valid = 0;
    if (isset($row['harga_diskon']) && $row['harga_diskon'] > 0) {
        $harga_valid = $row['harga_diskon'];
    } elseif (isset($row['harga']) && $row['harga'] > 0) {
        $harga_valid = $row['harga'];
    } elseif (isset($harga_sekarang) && $harga_sekarang > 0) {
        $harga_valid = $harga_sekarang;
    }
?>

<button type="button" class="btn-buy" onclick="buyNow('<?php echo isset($row['id']) ? $row['id'] : (isset($id_produk) ? $id_produk : ''); ?>', '<?php echo isset($row['nama_produk']) ? addslashes($row['nama_produk']) : 'Produk Caymira'; ?>', <?php echo $harga_valid; ?>, '<?php echo isset($sumber_gambar) ? addslashes($sumber_gambar) : ''; ?>')">
    <i class=""></i> Beli Sekarang
</button>
            </div>

            <!-- Wishlist & Share -->
            <div class="wishlist-share">
                <button class="wishlist-btn" id="wishlistBtn" onclick="toggleWishlist()">
                    <i class="far fa-heart"></i>
                    <span>Favorit (0)</span>
                </button>
                <button class="share-btn" onclick="shareProduct()">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan</span>
                </button>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-header">
                    <button class="tab-btn active" onclick="switchTab(this, 'desc')">Deskripsi</button>
                    <button class="tab-btn" onclick="switchTab(this, 'spec')">Spesifikasi</button>
                    <button class="tab-btn" onclick="switchTab(this, 'shipping')">Pengiriman</button>
                    <button class="tab-btn" onclick="switchTab(this, 'review')">Ulasan</button>
                </div>
                
                <div class="tab-content active" id="desc">
                    <p><?php echo isset($deskripsi) ? $deskripsi : 'Deskripsi belum tersedia.'; ?></p>
                </div>
                
                <div class="tab-content" id="spec">
                    <p><?php echo isset($spesifikasi) ? $spesifikasi : 'Spesifikasi belum tersedia.'; ?></p>
                </div>
                
                <div class="tab-content" id="shipping">
                    <p><?php echo isset($pengiriman) ? $pengiriman : 'Pengiriman dikirim dari gudang pusat Caymira. Estimasi 2-3 hari kerja.'; ?></p>
                </div>
                
                <div class="tab-content" id="review">
                    <p><?php echo isset($info_ulasan) ? $info_ulasan : 'Belum ada ulasan tertulis untuk produk ini.'; ?></p>
                </div>
            </div>
    </section>

    <!-- Related Products -->
    
           

           
            

        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4"/>
            <circle cx="100" cy="30" r="2" fill="#c9a84c" opacity="0.6"/>
            <circle cx="110" cy="70" r="1.5" fill="#c9a84c" opacity="0.5"/>
            <circle cx="90" cy="110" r="2" fill="#c9a84c" opacity="0.7"/>
            <circle cx="105" cy="150" r="1.5" fill="#c9a84c" opacity="0.5"/>
            <circle cx="95" cy="190" r="2" fill="#c9a84c" opacity="0.6"/>
            <circle cx="115" cy="230" r="1.5" fill="#c9a84c" opacity="0.5"/>
            <circle cx="85" cy="270" r="2" fill="#c9a84c" opacity="0.7"/>
        </svg>

        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                   <img src="Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height: 60px;">
                 </div>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#" onclick="showToast('📸 Instagram: @caymiramodest')"><i class="fab fa-instagram"></i></a>
                    <a href="#" onclick="showToast('👥 Facebook: Caymira Modest')"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-D0408')"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="#collection">Collection</a></li>
                    <li><a href="../bestseller/bestseller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')">
                    <i class="far fa-clock"></i>
                    <div>
                        <div>Monday - Saturday</div>
                        <div>10.00 - 17.00 WIB</div>
                    </div>
                </div>
                <div class="contact-item" onclick="showToast('📞 Hubungi: 0895-7042-D0408')">
                    <i class="fas fa-phone"></i>
                    <div>0895-7042-D0408</div>
                </div>
                <div class="contact-item" onclick="showToast('📧 Email: caymiramodest@gmail.com')">
                    <i class="far fa-envelope"></i>
                    <div>caymiramodest@gmail.com</div>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Newsletter</h4>
                <p class="newsletter-text">Dapatkan info terbaru & promo menarik dari Caymira Modest.</p>
                <form class="newsletter-form" onsubmit="handleSubscribe(event)">
                    <input type="email" placeholder="Your email" required id="emailInput">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>

        // ===== LOADING SCREEN =====
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 2000);
        });

        // ===== CUSTOM CURSOR =====
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px';
            cursorDot.style.top = e.clientY - 3 + 'px';
        });

        document.querySelectorAll('a, button, i, .value-card, .contact-item, .category-item, .product-card, .feature-item, .btn-shop, .quick-view-btn, .thumbnail, .color-btn, .size-btn, .guarantee-item, .image-nav').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        // ===== NAVBAR SCROLL =====
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const scrollTop = document.getElementById('scrollTop');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                scrollTop.classList.add('visible');
            } else {
                navbar.classList.remove('scrolled');
                scrollTop.classList.remove('visible');
            }
        });

        // ===== MOBILE MENU =====
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            const menuBtn = document.getElementById('mobileMenuBtn');
            navLinks.classList.toggle('active');
            menuBtn.classList.toggle('active');
        }

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navLinks').classList.remove('active');
                document.getElementById('mobileMenuBtn').classList.remove('active');
            });
        });

        // ===== SEARCH OVERLAY =====
        function toggleSearch() {
            const overlay = document.getElementById('searchOverlay');
            overlay.classList.toggle('active');
            if (overlay.classList.contains('active')) {
                setTimeout(() => document.getElementById('searchInput').focus(), 400);
            }
        }

        document.getElementById('searchOverlay').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) toggleSearch();
        });

        // ===== TOAST =====
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toastText');
            toastText.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== NEWSLETTER =====
        function handleSubscribe(e) {
            e.preventDefault();
            const email = document.getElementById('emailInput').value;
            if (email) {
                showToast('✅ Terima kasih telah berlangganan newsletter Caymira!');
                document.getElementById('emailInput').value = '';
            }
        }

        // ===== SCROLL TO TOP =====
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // ===== ACTIVE NAV =====
        const sections = document.querySelectorAll('section, footer');
        const navItems = document.querySelectorAll('.nav-links a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                if (scrollY >= (section.offsetTop - 200)) {
                    current = section.getAttribute('id');
                }
            });
            navItems.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').slice(1) === current) {
                    link.classList.add('active');
                }
            });
        });

        // ===== IMAGE GALLERY =====
        const images = [
            'Gambarberanda/jubah_hasan.png',
            'Gambarberanda/jubah_hasan_2.png',
            'Gambarberanda/jubah_hasan_3.png',
            'Gambarberanda/jubah_hasan_4.png'
        ];
        let currentImage = 0;

        function setImage(index) {
            currentImage = index;
            document.getElementById('mainImage').src = images[index];
            document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }

        function changeImage(direction) {
            currentImage = (currentImage + direction + images.length) % images.length;
            setImage(currentImage);
        }

        // ===== COLOR SELECTION =====
        function selectColor(element, colorName) {
            document.querySelectorAll('.color-btn').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
            document.querySelector('.color-section .section-label span').textContent = '- ' + colorName;
            showToast('🎨 Warna dipilih: ' + colorName);
        }

        // ===== SIZE SELECTION =====
        function selectSize(element) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
            showToast('📏 Ukuran dipilih: ' + element.textContent.trim());
        }

        // ===== QUANTITY =====
        function updateQty(change) {
            const input = document.getElementById('qtyInput');
            let val = parseInt(input.value) + change;
            if (val < 1) val = 1;
            if (val > 10) val = 10;
            input.value = val;
        }
        // ===== SINKRONISASI ANGKA KERANJANG DI NAVBAR =====
        function updateCartBadgeGlobal() {
            // Buka brankas keranjang utama
            let cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            
            // Hitung total semua barang (qty)
            let totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            
            // Cari elemen bulatan merah di navbar
            let badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = totalItems;
                // Sembunyikan kalau 0, munculkan kalau ada isinya
                badge.style.display = totalItems > 0 ? 'flex' : 'none';
            }
        }

        // Jalankan otomatis setiap kali halaman ini dibuka
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadgeGlobal();
        });

       // ===== ADD TO CART (MASUKKAN KERANJANG) =====
       function addToCart(id, nama, harga, gambar) {
    // 1. Ambil keranjang lama
    let cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
    
    // 2. Cek apakah barang sudah ada
    let existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        // 3. Kalau belum ada, tambahkan sebagai barang baru
        cart.push({
            id: id,
            name: nama,
            price: parseInt(harga),
            quantity: 1,
            image: gambar
        });
    }
    
    // 4. Simpan kembali ke brankas
    localStorage.setItem('caymira_cart', JSON.stringify(cart));
    
    // 5. Update badge navbar (jika ada fungsinya)
    if (typeof updateCartBadge === 'function') {
        updateCartBadge();
    }
    
    // 6. Tampilkan notifikasi
    if (typeof showToast === 'function') {
        showToast('🛒 ' + nama + ' berhasil ditambahkan!');
    } else {
        alert('🛒 ' + nama + ' berhasil ditambahkan!');
    }
}
 

       // ===== BUY NOW (CHECKOUT) =====
       // ===== DETEKTIF CHECKOUT LANGSUNG =====
       // ===== FUNGSI BUY NOW (KHUSUS JALUR DETAIL PRODUK - TIDAK NYAMPUR KERANJANG) =====
      // ===== FUNGSI BUY NOW FINAL =====
        function buyNow(id, nama, harga, gambar) {
            try {
                if (!id || id === '') {
                    alert("Waduh, ID Produk kosong! Cek variabel PHP-nya Bos.");
                    return;
                }

                // Ambil qty
                let qtyVal = 1;
                const inputQty = document.getElementById('qtyInput');
                if (inputQty) {
                    qtyVal = parseInt(inputQty.value) || 1;
                }

                // Bungkus item
                let checkoutItems = [{
                    id: id,
                    name: nama,
                    price: parseInt(harga) || 0,
                    quantity: qtyVal,
                    image: gambar
                }];

                // Masuk ke laci Kasir Sementara
                sessionStorage.setItem('caymira_checkout_data', JSON.stringify(checkoutItems));
                sessionStorage.setItem('caymira_checkout_jalur', 'beli_langsung');

                if (typeof showToast === 'function') {
                    showToast('⚡ Meluncur ke kasir...');
                }

                // Pindah ke informasi.php
                setTimeout(() => {
                    window.location.href = '../checkout/informasi.php';
                }, 800);

            } catch (error) {
                alert("JavaScript Crash: " + error.message);
            }
        }
          

        // ===== WISHLIST =====
        function toggleWishlist() {
            const btn = document.getElementById('wishlistBtn');
            const icon = btn.querySelector('i');
            const text = btn.querySelector('span');
            btn.classList.toggle('active');
            if (btn.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                text.textContent = 'Favorit (1)';
                showToast('❤️ Ditambahkan ke favorit!');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                text.textContent = 'Favorit (0)';
                showToast('💔 Dihapus dari favorit');
            }
        }

        // ===== SHARE =====
        function shareProduct() {
            showToast('🔗 Link produk telah disalin!');
        }

        // ===== TABS =====
        function switchTab(element, tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            element.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        // ===== KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.getElementById('searchOverlay').classList.remove('active');
            }
            if (e.key === '/' && !e.target.matches('input')) {
                e.preventDefault();
                toggleSearch();
            }
        });
        // ===== BUY NOW (LANGSUNG CHECKOUT PAKAI BRANKAS) =====
       
    </script>
</body>
</html>
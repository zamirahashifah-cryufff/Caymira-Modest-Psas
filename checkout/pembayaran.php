<?php
// 1. Koneksi ke Database
$conn = new mysqli('localhost', 'root', '', 'caymira_modest'); // Sesuaikan nama DB-mu
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. Ambil order_id dari URL
$order_id = isset($_GET['order_id']) ? $conn->real_escape_string($_GET['order_id']) : '';

// 3. Tarik data lengkap pelanggan dari DB berdasarkan order_id
$nama = ''; $alamat = ''; $kota = ''; $kode_pos = ''; $total = 0;
if (!empty($order_id)) {
    $result = $conn->query("SELECT * FROM orders WHERE order_id_midtrans = '$order_id'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $kota = $row['kota'];
        $kode_pos = $row['kode_pos'];
        $total = $row['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
/* === VARIABEL === */
:root {
    --navy: #0a1628;
    --navy-light: #0f1d35;
    --gold: #c9a84c;
    --gold-light: #d4b76a;
    --gold-dark: #b8963f;
    --text-light: #e8e8e8;
    --text-muted: #a0a0a0;
    --bg-card: #141e2a;
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Poppins', sans-serif;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
    background-color: var(--navy);
    color: var(--text-light);
    font-family: var(--font-body);
    line-height: 1.6;
    overflow-x: hidden;
}
a { text-decoration: none; color: inherit; transition: var(--transition); }
img { max-width: 100%; height: auto; display: block; }
.container { width: 90%; max-width: 1200px; margin: 0 auto; }

/* Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: var(--navy); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

/* === CUSTOM CURSOR === */
.custom-cursor {
    width: 20px; height: 20px;
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
    width: 6px; height: 6px;
    background: var(--gold);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 99999;
}
@media (max-width: 768px) {
    .custom-cursor, .cursor-dot { display: none; }
}

/* === LOADER === */
.loader {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    background: var(--navy);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    z-index: 99999;
    transition: opacity 0.6s, visibility 0.6s;
}
.loader.hidden { opacity: 0; visibility: hidden; }
.loader-text {
    font-family: var(--font-heading);
    font-size: 42px; color: var(--gold);
    animation: loaderPulse 1.5s ease-in-out infinite;
}
.loader-bar {
    width: 200px; height: 2px;
    background: rgba(201,168,76,0.2);
    margin-top: 30px; border-radius: 2px;
    overflow: hidden;
}
.loader-progress {
    height: 100%; background: var(--gold);
    width: 0%; animation: loadProgress 2s ease forwards;
}
@keyframes loaderPulse {
    0%,100% { opacity: 0.4; letter-spacing: 2px; }
    50% { opacity: 1; letter-spacing: 8px; }
}
@keyframes loadProgress {
    0% { width: 0%; } 100% { width: 100%; }
}

/* === NAVBAR === */
.navbar {
    position: fixed; top: 0; width: 100%; height: 70px;
    padding: 0 60px; display: flex;
    justify-content: space-between; align-items: center;
    z-index: 1000;
    background: rgba(7,13,23,0.98);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(201,168,76,0.6);
    transition: var(--transition);
}
.navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
.logo-img { height: 75px; width: auto; object-fit: contain; transition: var(--transition); margin-top: 5px; position: relative; z-index: 1001; }
.logo:hover .logo-img { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201,168,76,0.5)); }
.nav-links { display: flex; gap: 45px; list-style: none; }
.nav-links a {
    color: var(--text-light); text-decoration: none;
    font-size: 12px; font-weight: 500;
    letter-spacing: 1.5px; text-transform: uppercase;
    position: relative; padding: 5px 0;
    transition: color 0.3s;
}
.nav-links a::after {
    content: ''; position: absolute; bottom: -4px; left: 0;
    width: 0; height: 2px; background: var(--gold);
    transition: width 0.3s;
}
.nav-links a:hover, .nav-links a.active { color: var(--gold); }
.nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
.nav-icons { display: flex; gap: 25px; align-items: center; }
.nav-icons i {
    font-size: 18px; color: var(--text-light);
    cursor: pointer; transition: var(--transition); position: relative;
}
.nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
.cart-icon { position: relative; display: flex; align-items: center; }
.cart-badge {
    position: absolute; top: -8px; right: -8px;
    background: var(--gold); color: var(--navy);
    font-size: 10px; font-weight: 700;
    width: 18px; height: 18px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
.mobile-menu-btn {
    display: none; flex-direction: column; gap: 5px;
    cursor: pointer; z-index: 1001; padding: 5px;
}
.mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: var(--transition); border-radius: 2px; }
.mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
.mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
.mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

/* === HEADER === */
.payment-header {
    margin-top: 70px; padding: 60px 0 30px;
    text-align: center; position: relative; overflow: hidden;
}
.payment-header::before {
    content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at 50% 0%, rgba(201,168,76,0.08) 0%, transparent 60%);
    pointer-events: none;
}
.payment-header h1 {
    font-family: var(--font-heading); font-size: 42px;
    color: var(--gold); margin-bottom: 10px; position: relative; z-index: 1;
}
.payment-header p { color: var(--text-muted); font-size: 15px; position: relative; z-index: 1; }
.order-id {
    display: inline-flex; align-items: center; gap: 10px;
    margin-top: 20px; padding: 10px 24px;
    background: rgba(201,168,76,0.1);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 50px; font-size: 14px;
    position: relative; z-index: 1;
}
.order-id span { color: var(--text-muted); }
.order-id strong { color: var(--gold); font-weight: 600; letter-spacing: 1px; }

/* === PROGRESS === */
.progress-steps {
    display: flex; justify-content: center; align-items: center;
    gap: 0; margin-bottom: 50px; position: relative; z-index: 1;
}
.step { display: flex; flex-direction: column; align-items: center; gap: 10px; position: relative; }
.step-circle {
    width: 44px; height: 44px; border-radius: 50%;
    border: 2px solid rgba(201,168,76,0.3);
    display: flex; align-items: center; justify-content: center;
    font-weight: 600; font-size: 14px; color: var(--text-muted);
    background: var(--navy); transition: var(--transition); position: relative; z-index: 2;
}
.step.active .step-circle {
    border-color: var(--gold); background: var(--gold); color: var(--navy);
    box-shadow: 0 0 20px rgba(201,168,76,0.4);
}
.step.completed .step-circle {
    border-color: var(--gold); background: var(--gold); color: var(--navy);
}
.step-label {
    font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px;
    color: var(--text-muted); font-weight: 500; transition: var(--transition);
}
.step.active .step-label { color: var(--gold); }
.step.completed .step-label { color: var(--gold-light); }
.step-line {
    width: 100px; height: 2px; background: rgba(201,168,76,0.2);
    margin: 0 15px; position: relative; top: -22px; transition: var(--transition);
}
.step-line.completed { background: var(--gold); }
@media (max-width: 768px) {
    .step-line { width: 40px; margin: 0 8px; }
    .payment-header h1 { font-size: 28px; }
}

/* === MAIN LAYOUT === */
.payment-main { padding-bottom: 80px; }
.payment-grid {
    display: grid; grid-template-columns: 1fr 420px;
    gap: 40px; align-items: start;
}
@media (max-width: 1024px) {
    .payment-grid { grid-template-columns: 1fr; }
}

/* === CARD === */
.payment-card {
    background: var(--bg-card);
    border: 1px solid rgba(201,168,76,0.12);
    border-radius: 20px; padding: 35px;
    transition: var(--transition); position: relative; overflow: hidden;
    margin-bottom: 30px;
}
.payment-card::before {
    content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201,168,76,0.05) 0%, transparent 60%);
    opacity: 0; transition: opacity 0.5s; pointer-events: none;
}
.payment-card:hover::before { opacity: 1; }
.payment-card:hover {
    border-color: rgba(201,168,76,0.25);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}
.card-title {
    font-family: var(--font-heading); font-size: 22px;
    color: var(--gold); margin-bottom: 25px;
    display: flex; align-items: center; gap: 12px;
    position: relative; z-index: 1;
}
.card-title i { font-size: 18px; color: var(--gold); opacity: 0.8; }
.card-title::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, rgba(201,168,76,0.3), transparent);
    margin-left: 10px;
}

/* === TIMER === */
.timer-box {
    background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
    border: 1.5px solid rgba(201,168,76,0.3);
    border-radius: 16px; padding: 25px;
    text-align: center; margin-bottom: 30px;
    position: relative; z-index: 1;
}
.timer-label {
    font-size: 13px; text-transform: uppercase;
    letter-spacing: 2px; color: var(--text-muted);
    margin-bottom: 12px;
}
.timer-display {
    font-family: var(--font-heading); font-size: 42px;
    color: var(--gold); font-weight: 700;
    letter-spacing: 4px; display: flex;
    justify-content: center; gap: 8px;
}
.timer-unit {
    display: flex; flex-direction: column; align-items: center;
}
.timer-unit span:first-child { font-size: 42px; line-height: 1; }
.timer-unit span:last-child {
    font-size: 11px; text-transform: uppercase;
    letter-spacing: 1px; color: var(--text-muted);
    margin-top: 4px; font-family: var(--font-body);
}
.timer-separator { font-size: 36px; color: var(--gold); opacity: 0.6; margin-top: -5px; }
.timer-urgent { color: #e74c3c !important; animation: blink 1s infinite; }
@keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }

/* === PAYMENT DETAIL === */
.payment-method-display {
    display: flex; align-items: center; gap: 15px;
    padding: 18px; background: rgba(201,168,76,0.08);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 14px; margin-bottom: 25px;
    position: relative; z-index: 1;
}
.payment-method-icon {
    width: 50px; height: 50px; border-radius: 12px;
    background: rgba(201,168,76,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--gold);
}
.payment-method-info { flex: 1; }
.payment-method-name { font-size: 16px; font-weight: 600; color: var(--text-light); margin-bottom: 3px; }
.payment-method-desc { font-size: 13px; color: var(--text-muted); }

/* === BANK DETAILS === */
.bank-detail {
    background: rgba(10,22,40,0.6);
    border: 1px solid rgba(201,168,76,0.15);
    border-radius: 14px; padding: 22px;
    margin-bottom: 15px; position: relative; z-index: 1;
    transition: var(--transition);
}
.bank-detail:hover {
    border-color: rgba(201,168,76,0.3);
    transform: translateX(5px);
}
.bank-name {
    display: flex; align-items: center; gap: 10px;
    font-size: 14px; font-weight: 600;
    color: var(--text-light); margin-bottom: 12px;
}
.bank-name img {
    width: 28px; height: 28px; border-radius: 6px;
    object-fit: cover; background: white;
}
.account-row {
    display: flex; justify-content: space-between; align-items: center;
    gap: 15px;
}
.account-number {
    font-family: 'Courier New', monospace;
    font-size: 20px; font-weight: 700;
    color: var(--gold); letter-spacing: 2px;
}
.account-name { font-size: 13px; color: var(--text-muted); margin-top: 4px; }
.btn-copy {
    padding: 8px 16px; background: rgba(201,168,76,0.15);
    border: 1.5px solid rgba(201,168,76,0.3);
    border-radius: 8px; color: var(--gold);
    font-size: 12px; font-weight: 600;
    cursor: pointer; transition: var(--transition);
    display: flex; align-items: center; gap: 6px;
    white-space: nowrap;
}
.btn-copy:hover {
    background: var(--gold); color: var(--navy);
    border-color: var(--gold);
}
.btn-copy.copied {
    background: #27ae60; border-color: #27ae60; color: white;
}

/* === QRIS === */
.qris-box {
    text-align: center; padding: 20px;
    background: rgba(201,168,76,0.05);
    border: 1.5px dashed rgba(201,168,76,0.3);
    border-radius: 16px; position: relative; z-index: 1;
}
.qris-code {
    width: 220px; height: 220px;
    margin: 0 auto 15px;
    background: white; border-radius: 12px;
    padding: 15px; display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
}
.qris-code::before {
    content: '\f029'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
    font-size: 120px; color: var(--navy); opacity: 0.9;
}
.qris-label { font-size: 13px; color: var(--text-muted); }

/* === COD === */
.cod-box {
    background: rgba(39,174,96,0.1);
    border: 1.5px solid rgba(39,174,96,0.3);
    border-radius: 16px; padding: 25px;
    text-align: center; position: relative; z-index: 1;
}
.cod-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(39,174,96,0.2);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 15px; font-size: 24px; color: #27ae60;
}
.cod-title { font-size: 18px; font-weight: 600; color: #27ae60; margin-bottom: 8px; }
.cod-desc { font-size: 14px; color: var(--text-muted); line-height: 1.7; }

/* === UPLOAD AREA === */
.upload-area {
    border: 2px dashed rgba(201,168,76,0.3);
    border-radius: 16px; padding: 40px 30px;
    text-align: center; cursor: pointer;
    transition: var(--transition); position: relative; z-index: 1;
    background: rgba(201,168,76,0.03);
}
.upload-area:hover {
    border-color: var(--gold);
    background: rgba(201,168,76,0.08);
}
.upload-area.dragover {
    border-color: var(--gold); background: rgba(201,168,76,0.12);
    transform: scale(1.02);
}
.upload-area.has-file {
    border-style: solid; border-color: var(--gold);
    background: rgba(201,168,76,0.1);
}
.upload-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(201,168,76,0.1);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 15px; font-size: 24px; color: var(--gold);
    transition: var(--transition);
}
.upload-area:hover .upload-icon {
    transform: scale(1.1);
    background: rgba(201,168,76,0.2);
}
.upload-text { font-size: 15px; color: var(--text-light); margin-bottom: 6px; }
.upload-subtext { font-size: 12px; color: var(--text-muted); }
.upload-preview {
    max-width: 200px; max-height: 200px;
    border-radius: 12px; margin: 15px auto 0;
    border: 2px solid var(--gold); display: none;
}
.upload-preview.show { display: block; }

/* === BUTTONS === */
.btn-primary {
    width: 100%; padding: 16px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    border: none; border-radius: 14px; color: var(--navy);
    font-family: var(--font-body); font-size: 15px;
    font-weight: 600; text-transform: uppercase;
    letter-spacing: 1.5px; cursor: pointer;
    transition: var(--transition); margin-top: 20px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-primary::before {
    content: ''; position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.btn-primary:hover::before { left: 100%; }
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(201,168,76,0.4);
}
.btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.btn-secondary {
    width: 100%; padding: 14px;
    background: transparent; border: 1.5px solid rgba(201,168,76,0.3);
    border-radius: 14px; color: var(--text-muted);
    font-family: var(--font-body); font-size: 14px;
    font-weight: 500; cursor: pointer;
    transition: var(--transition); margin-top: 12px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-secondary:hover {
    border-color: #e74c3c; color: #e74c3c;
    background: rgba(231,76,60,0.1);
}

/* === STATUS === */
.status-badge {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 18px; border-radius: 50px;
    font-size: 13px; font-weight: 600;
    margin-bottom: 20px; position: relative; z-index: 1;
}
.status-pending {
    background: rgba(201,168,76,0.15);
    border: 1px solid rgba(201,168,76,0.3);
    color: var(--gold);
}
.status-success {
    background: rgba(39,174,96,0.15);
    border: 1px solid rgba(39,174,96,0.3);
    color: #27ae60;
}
.status-badge i { font-size: 14px; }

/* === ORDER ITEM === */
.order-item {
    display: flex; gap: 15px; padding: 15px 0;
    border-bottom: 1px solid rgba(201,168,76,0.1);
    position: relative; z-index: 1;
}
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.order-item:first-child { padding-top: 0; }
.order-img { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1px solid rgba(201,168,76,0.2); flex-shrink: 0; }
.order-details { flex: 1; }
.order-name { font-size: 14px; font-weight: 500; color: var(--text-light); margin-bottom: 3px; }
.order-variant { font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }
.order-price { font-size: 14px; font-weight: 600; color: var(--gold); }

/* === PRICING === */
.pricing-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; font-size: 14px; position: relative; z-index: 1;
}
.pricing-row:not(:last-child) { border-bottom: 1px dashed rgba(201,168,76,0.15); }
.pricing-label { color: var(--text-muted); }
.pricing-value { color: var(--text-light); font-weight: 500; }
.pricing-value.gold { color: var(--gold); font-weight: 600; }
.pricing-divider {
    height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.3), transparent);
    margin: 12px 0;
}
.pricing-total {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 12px; position: relative; z-index: 1;
}
.pricing-total-label { font-size: 16px; font-weight: 600; color: var(--text-light); }
.pricing-total-value {
    font-family: var(--font-heading); font-size: 24px;
    color: var(--gold); font-weight: 700;
}

/* === SHIPPING INFO === */
.shipping-info { margin-top: 20px; }
.shipping-row {
    display: flex; gap: 12px; padding: 10px 0;
    font-size: 13px; color: var(--text-muted);
    position: relative; z-index: 1;
}
.shipping-row i { color: var(--gold); width: 18px; margin-top: 2px; }
.shipping-row div { line-height: 1.5; }
.shipping-row strong { color: var(--text-light); font-weight: 500; }

/* === CONFETTI === */
.confetti-container {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none; z-index: 99998;
    overflow: hidden; display: none;
}
.confetti-container.active { display: block; }
.confetti {
    position: absolute; width: 10px; height: 10px;
    background: var(--gold); top: -10px;
    animation: confettiFall 3s ease-out forwards;
}
@keyframes confettiFall {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}

/* === FOOTER === */
.footer {
    background: #ffffff; border-top: 1px solid rgba(201,168,76,0.15);
    padding: 50px 60px 30px; position: relative; margin-top: 50px;
}
.gold-branch-footer {
    position: absolute; left: -30px; top: -70px;
    width: 200px; opacity: 0.5; pointer-events: none;
}
.footer-content {
    display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr;
    gap: 35px; max-width: 1300px; margin: 0 auto;
}
.footer-brand .logo-main {
    font-family: var(--font-heading); font-size: 22px;
    color: var(--gold); font-weight: 600; margin-bottom: 3px;
}
.footer-brand .logo-sub {
    font-size: 9px; color: var(--gold);
    letter-spacing: 3px; text-transform: uppercase; margin-bottom: 18px;
}
.footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
.social-links { display: flex; gap: 12px; margin-top: 18px; }
.social-links a {
    width: 36px; height: 36px; border: 1px solid rgba(201,168,76,0.35);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: var(--gold); text-decoration: none; transition: var(--transition);
    font-size: 14px; position: relative; overflow: hidden;
}
.social-links a::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 100%; height: 100%; background: var(--gold);
    transform: scale(0); transition: transform 0.3s; border-radius: 50%;
}
.social-links a:hover::before { transform: scale(1); }
.social-links a:hover { color: var(--navy); transform: translateY(-3px); }
.social-links a i { position: relative; z-index: 1; }
.footer-title {
    color: var(--gold); font-size: 13px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 22px; position: relative; display: inline-block;
}
.footer-title::after {
    content: ''; position: absolute; bottom: -8px; left: 0;
    width: 35px; height: 2px; background: var(--gold);
    transition: width 0.3s;
}
.footer-col:hover .footer-title::after { width: 100%; }
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a {
    color: #888; text-decoration: none; font-size: 13px;
    transition: var(--transition); display: inline-flex;
    align-items: center; gap: 8px;
}
.footer-links a::before {
    content: '→'; color: var(--gold); opacity: 0;
    transform: translateX(-10px); transition: var(--transition);
}
.footer-links a:hover { color: var(--gold); transform: translateX(4px); }
.footer-links a:hover::before { opacity: 1; transform: translateX(0); }
.contact-item {
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 15px; color: #888; font-size: 13px;
    transition: var(--transition); cursor: pointer;
}
.contact-item:hover { color: var(--gold); transform: translateX(5px); }
.contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; transition: transform 0.3s; }
.contact-item:hover i { transform: scale(1.2); }
.newsletter-text { font-size: 12px; color: #888; line-height: 1.6; margin-bottom: 18px; }
.newsletter-form {
    display: flex; border: 1px solid rgba(201,168,76,0.25);
    border-radius: 4px; overflow: hidden;
    transition: var(--transition); position: relative;
}
.newsletter-form:focus-within { border-color: var(--gold); box-shadow: 0 0 20px rgba(201,168,76,0.2); }
.newsletter-form input { flex: 1; background: transparent; border: none; padding: 12px 14px; color: #333; font-size: 13px; outline: none; }
.newsletter-form input::placeholder { color: #aaa; }
.newsletter-form button { background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: var(--transition); position: relative; overflow: hidden; }
.newsletter-form button::before { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: rgba(255,255,255,0.3); border-radius: 50%; transform: translate(-50%,-50%); transition: width 0.6s, height 0.6s; }
.newsletter-form button:hover::before { width: 300px; height: 300px; }
.newsletter-form button:hover { background: var(--gold-light); }
.newsletter-form button i { font-size: 14px; position: relative; z-index: 1; }
.footer-bottom {
    text-align: center; padding-top: 35px; margin-top: 35px;
    border-top: 1px solid rgba(201,168,76,0.15); font-size: 12px;
    color: #ffffff; background-color: #000000;
    padding-bottom: 35px; margin-left: -60px; margin-right: -60px;
}

/* === SCROLL TOP === */
.scroll-top {
    position: fixed; bottom: 25px; right: 25px;
    width: 45px; height: 45px; background: var(--gold);
    color: var(--navy); border: none; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: var(--transition);
    z-index: 999; box-shadow: 0 4px 15px rgba(201,168,76,0.4); font-size: 16px;
}
.scroll-top.visible { opacity: 1; visibility: visible; }
.scroll-top:hover { transform: translateY(-5px) scale(1.1); box-shadow: 0 8px 25px rgba(201,168,76,0.5); }

/* === TOAST === */
.toast {
    position: fixed; bottom: 90px; left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: var(--gold); color: var(--navy);
    padding: 16px 32px; border-radius: 50px;
    font-weight: 500; font-size: 14px; opacity: 0;
    transition: all 0.4s cubic-bezier(0.68,-0.55,0.265,1.55);
    z-index: 10000; box-shadow: 0 8px 30px rgba(201,168,76,0.4);
    display: flex; align-items: center; gap: 10px;
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.toast i { font-size: 18px; }

/* === RESPONSIVE === */
@media (max-width: 1024px) {
    .payment-grid { grid-template-columns: 1fr; }
    .footer-content { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
    .navbar { padding: 0 30px; }
    .nav-links {
        position: fixed; top: 0; right: -100%; width: 75%; height: 100vh;
        background: var(--navy); flex-direction: column;
        padding: 100px 40px; transition: right 0.4s cubic-bezier(0.4,0,0.2,1);
        border-left: 1px solid rgba(201,168,76,0.2); gap: 30px;
    }
    .nav-links.active { right: 0; }
    .mobile-menu-btn { display: flex; }
    .footer { padding: 35px 30px 25px; }
    .footer-content { grid-template-columns: 1fr; gap: 25px; }
    .footer-bottom { margin-left: -30px; margin-right: -30px; }
    .payment-card { padding: 25px; }
    .timer-display { font-size: 32px; }
    .timer-unit span:first-child { font-size: 32px; }
    .account-number { font-size: 16px; }
}
    </style>
<base target="_blank">
</head>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-LuLZAuQLGy6vcv4o"></script>
<body>
    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Confetti -->
    <div class="confetti-container" id="confetti"></div>

    
    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.html'">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search" onclick="showToast('🔍 Fitur pencarian segera hadir')"></i>
            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
             <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Payment Header -->
    <header class="payment-header">
        <div class="container">
            <h1>Pembayaran</h1>
            <p>Selesaikan pembayaran Anda sebelum batas waktu habis</p>
            <div class="order-id">
                <span>No. Pesanan:</span>
                <strong>CM-250516-8842</strong>
                <i class="fas fa-copy" style="color: var(--gold); cursor: pointer;" onclick="copyOrderId()"></i>
            </div>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="container">
        <div class="progress-steps">
            <div class="step completed" id="step1">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <span class="step-label">Informasi</span>
            </div>
            <div class="step-line completed" id="line1"></div>
            <div class="step active" id="step2">
                <div class="step-circle">2</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="step" id="step3">
                <div class="step-circle">3</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>

    <!-- Main Payment -->
    <main class="payment-main container">
        <div class="payment-grid">
            <!-- Left: Payment Details -->
            <div class="payment-left">
                <!-- Timer -->
                <div class="payment-card">
                    <div class="timer-box">
                        <div class="timer-label"><i class="fas fa-clock" style="margin-right: 6px;"></i> Selesaikan Pembayaran Dalam</div>
                        <div class="timer-display" id="timerDisplay">
                            <div class="timer-unit"><span id="hours">23</span><span>Jam</span></div>
                            <div class="timer-separator">:</div>
                            <div class="timer-unit"><span id="minutes">59</span><span>Menit</span></div>
                            <div class="timer-separator">:</div>
                            <div class="timer-unit"><span id="seconds">59</span><span>Detik</span></div>
                        </div>
                    </div>

                    <div class="status-badge status-pending" id="statusBadge">
                        <i class="fas fa-hourglass-half"></i> Menunggu Pembayaran
                    </div>

                    <h2 class="card-title"><i class="fas fa-university"></i> Detail Pembayaran</h2>

                    <div class="payment-method-display">
                        <div class="payment-method-icon"><i class="fas fa-university"></i></div>
                        <div class="payment-method-info">
                            <div class="payment-method-name">Transfer Bank</div>
                            <div class="payment-method-desc">Silakan transfer ke salah satu rekening di bawah</div>
                        </div>
                    </div>

                    <!-- Bank BCA -->
                    <div class="bank-detail">
                        <div class="bank-name">
                            <div style="width:28px;height:28px;border-radius:6px;background:linear-gradient(135deg,#0066ae,#00a2e0);display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;">BCA</div>
                            Bank BCA
                        </div>
                        <div class="account-row">
                            <div>
                                <div class="account-number" id="rekBCA">8842 0152 99</div>
                                <div class="account-name">a.n. PT. Caymira Modest</div>
                            </div>
                            <button class="btn-copy" onclick="copyRekening('rekBCA', this)">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </div>
                    </div>

                    <!-- Bank Mandiri -->
                    <div class="bank-detail">
                        <div class="bank-name">
                            <div style="width:28px;height:28px;border-radius:6px;background:linear-gradient(135deg,#003d79,#0054a4);display:flex;align-items:center;justify-content:center;color:white;font-size:9px;font-weight:700;">MANDIRI</div>
                            Bank Mandiri
                        </div>
                        <div class="account-row">
                            <div>
                                <div class="account-number" id="rekMandiri">1420 0088 4255 1</div>
                                <div class="account-name">a.n. PT. Caymira Modest</div>
                            </div>
                            <button class="btn-copy" onclick="copyRekening('rekMandiri', this)">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </div>
                    </div>

                    <!-- Total Transfer -->
                    <div style="background: rgba(201,168,76,0.1); border: 1.5px solid rgba(201,168,76,0.3); border-radius: 14px; padding: 20px; text-align: center; margin-top: 10px; position: relative; z-index: 1;">
                        <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1.5px;">Total yang Harus Ditransfer</div>
<h2 style="color: #d4af37; font-size: 32px; margin: 10px 0;">
    Rp <?php echo number_format($total, 0, ',', '.'); ?>
</h2>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">Pastikan nominal sesuai hingga digit terakhir</div>
                    </div>
                </div>

                <!-- Upload Proof -->
                <div class="payment-card">
                    <h2 class="card-title"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h2>
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="upload-text">Klik atau seret file ke sini</div>
                        <div class="upload-subtext">Format: JPG, PNG, PDF (Max 5MB)</div>
                        <img class="upload-preview" id="uploadPreview" alt="Preview">
                    </div>
                    <input type="file" id="fileInput" accept="image/*,.pdf" style="display:none;" onchange="handleFileSelect(event)">
                    <button class="btn-primary" id="btnConfirm" onclick="kirimBuktiPembayaran()">
                        <i class="fas fa-check-circle"></i> Saya Sudah Bayar
                    </button>
                    <button class="btn-secondary" onclick="cancelOrder()">
                        <i class="fas fa-times"></i> Batalkan Pesanan
                    </button>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="payment-right">
                <div class="payment-card" style="position: sticky; top: 90px;">
                    <h2 class="card-title"><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h2>

                    <div id="paymentItemsList" style="max-height: 350px; overflow-y: auto; padding-right: 5px;"></div>

                    <div class="pricing-divider" style="margin: 15px 0; border-top: 1px dashed rgba(255,255,255,0.1);"></div>

                    <div class="pricing-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span class="pricing-label" style="color: #888;">Subtotal</span>
                        <span id="textSubtotal" style="color: #fff; font-weight: bold;">Rp 0</span>
                    </div>
                    <div class="pricing-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span class="pricing-label" style="color: #888;">Ongkir (JNE Reguler)</span>
                        <span class="pricing-value gold" style="color: #c9a84c; font-weight: bold;">Rp 32.000</span>
                    </div>
                    <div class="pricing-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span class="pricing-label" style="color: #888;">Diskon</span>
                        <span id="textDiscount" style="color:#27ae60; font-weight: bold;">- Rp 0</span>
                    </div>

                    <div class="pricing-divider" style="margin: 15px 0; border-top: 1px solid rgba(255,255,255,0.1);"></div>

                    <div class="pricing-total" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="pricing-total-label" style="font-size: 16px; font-weight: bold;">Total Akhir</span>
                        <h3 class="total-price" id="textTotal" style="color: #c9a84c; margin: 0; font-size: 22px;">Rp 0</h3>
                    </div>

                    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(201,168,76,0.15);">
                        <h3 style="font-family: var(--font-heading); font-size: 16px; color: var(--gold); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-truck" style="font-size: 14px;"></i> Pengiriman
                        </h3>
                        <div class="shipping-info">
                            <div class="shipping-row" style="display: flex; gap: 10px; margin-bottom: 10px; color: #ddd;">
                                <i class="fas fa-user" style="color: #c9a84c; margin-top: 4px;"></i>
                                <span id="textNamaPenerima">Memuat...</span>
                            </div>
                            <div class="shipping-row" style="display: flex; gap: 10px; color: #ddd;">
                                <i class="fas fa-map-marker-alt" style="color: #c9a84c; margin-top: 4px;"></i>
                                <span id="textAlamatPenerima">Memuat alamat...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</main>

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
                <div class="logo" onclick="window.scrollTo({top:0,behavior:'smooth'})">
                    <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height:60px;margin-top:0;">
                </div>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#" onclick="showToast('📸 Instagram: @caymiramodest')"><i class="fab fa-instagram"></i></a>
                    <a href="#" onclick="showToast('👥 Facebook: Caymira Modest')"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-0408')"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Home</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../Beranda/beranda.php#collection">Collection</a></li>
                    <li><a href="../Beranda/beranda.php#bestseller">Best Seller</a></li>
                    <li><a href="../login_register/contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')">
                    <i class="far fa-clock"></i>
                    <div><div>Monday - Saturday</div><div>10.00 - 17.00 WIB</div></div>
                </div>
                <div class="contact-item" onclick="showToast('📞 Hubungi: 0895-7042-0408')">
                    <i class="fas fa-phone"></i>
                    <div>0895-7042-0408</div>
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
        document.querySelectorAll('a, button, i, .bank-detail, .btn-copy, .upload-area, .payment-card, .order-item').forEach(el => {
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
        // Fungsi otomatis jalan pas halaman pembayaran.php kebuka
    window.addEventListener('DOMContentLoaded', () => {
        // 1. Ambil data token dan order_id dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const snapToken = urlParams.get('token');
        const orderId = urlParams.get('order_id');

        // 2. Kalau tokennya ada, langsung panggil pop-up Midtrans otomatis
        if (snapToken) {
            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    alert('🎉 Pembayaran Sukses!');
                    window.location.href = 'selesai.php?order_id=' + orderId;
                },
                onPending: function(result){
                    alert('⏳ Pembayaran Pending, Silahkan selesaikan transfer Anda.');
                    // Tetap di halaman ini karena mereka butuh lihat kode VA / info bayar
                },
                onError: function(result){
                    alert('❌ Pembayaran Gagal!');
                },
                onClose: function(){
                    alert('⚠️ Anda menutup pop-up pembayaran. Silahkan klik tombol bayar ulang jika ingin melanjutkan.');
                }
            });
        } else {
            alert('❌ Token pembayaran tidak ditemukan!');
        }
    });

    // Opsional: Bikin tombol di halaman pembayaran.php buat panggil ulang pop-up kalau gak sengaja ke-silang
    function bayarUlang() {
        const urlParams = new URLSearchParams(window.location.search);
        const snapToken = urlParams.get('token');
        if (snapToken) {
            window.snap.pay(snapToken);
        }
    }


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

        // ===== COPY REKENING =====
        function copyRekening(elementId, btn) {
            const text = document.getElementById(elementId).textContent.replace(/\s/g, '');
            navigator.clipboard.writeText(text).then(() => {
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
                showToast('✅ Nomor rekening berhasil disalin!');
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<i class="fas fa-copy"></i> Salin';
                }, 2500);
            });
        }

        // ===== COPY ORDER ID =====
        function copyOrderId() {
            navigator.clipboard.writeText('CM-250516-8842').then(() => {
                showToast('✅ No. Pesanan disalin ke clipboard');
            });
        }

        // ===== COUNTDOWN TIMER =====
        let timeLeft = 24 * 60 * 60 - 1; // 23:59:59
        const timerInterval = setInterval(() => {
            const h = Math.floor(timeLeft / 3600);
            const m = Math.floor((timeLeft % 3600) / 60);
            const s = timeLeft % 60;

            document.getElementById('hours').textContent = String(h).padStart(2, '0');
            document.getElementById('minutes').textContent = String(m).padStart(2, '0');
            document.getElementById('seconds').textContent = String(s).padStart(2, '0');

            // Urgent style under 1 hour
            if (timeLeft < 3600) {
                document.getElementById('timerDisplay').classList.add('timer-urgent');
            }

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timerDisplay').innerHTML = '<div style="font-size:24px;color:#e74c3c;">Waktu Habis</div>';
                showToast('⚠️ Batas waktu pembayaran telah habis');
            }
            timeLeft--;
        }, 1000);

// ===== FILE UPLOAD (VERSI ASLI + UPDATE DATABASE) =====
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const uploadPreview = document.getElementById('uploadPreview');

        // Drag & Drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length) handleFile(files[0]);
        });

        // Supaya input file bawaan kamu sinkron saat diklik manual
        if (fileInput) {
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) handleFile(file);
            });
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) handleFile(file);
        }

        function handleFile(file) {
            if (file.size > 5 * 1024 * 1024) {
                showToast('❌ File terlalu besar. Maksimal 5MB');
                return;
            }
            if (!file.type.match(/image.*|application\/pdf/)) {
                showToast('❌ Format file tidak didukung');
                return;
            }

            if (file.type.match(/image.*/)) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    uploadPreview.src = e.target.result;
                    uploadPreview.classList.add('show');
                    uploadArea.classList.add('has-file');
                    uploadArea.querySelector('.upload-icon').innerHTML = '<i class="fas fa-image"></i>';
                    uploadArea.querySelector('.upload-text').textContent = file.name;
                    uploadArea.querySelector('.upload-subtext').textContent = 'Klik untuk ganti file';
                };
                reader.readAsDataURL(file);
            } else {
                uploadPreview.classList.remove('show');
                uploadArea.classList.add('has-file');
                uploadArea.querySelector('.upload-icon').innerHTML = '<i class="fas fa-file-pdf"></i>';
                uploadArea.querySelector('.upload-text').textContent = file.name;
                uploadArea.querySelector('.upload-subtext').textContent = 'Klik untuk ganti file';
            }
            showToast('✅ File berhasil dipilih');
        }


        // UPDATE FUNGSI: Langsung Meluncur ke selesai.php
        // =======================================================
        async function kirimBuktiPembayaran() {
            const fileInput = document.getElementById('fileInput'); 
            const btn = document.getElementById('btnConfirm');      

            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('order_id');

            if (!fileInput || fileInput.files.length === 0) {
                alert('⚠️ Silakan pilih atau seret foto bukti pembayaran terlebih dahulu!');
                return;
            }

            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
            }

            const formData = new FormData();
            formData.append('bukti', fileInput.files[0]);
            formData.append('order_id', orderId);

            try {
                const response = await fetch('upload_bukti.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

              if (result.success) {
                    // 1. Ubah tampilan tombol jadi sukses & warna hijau murni
                    btn.disabled = false; // Kita hidupkan lagi biar bisa diklik buat halaman selanjutnya
                    btn.innerHTML = '<i class="fas fa-check"></i> Bukti Terkirim!';
                    btn.style.background = 'linear-gradient(135deg, #27ae60, #2ecc71)';
                    btn.style.color = '#ffffff';

                    // 2. Munculkan Toast sukses biar keren
                    showToast('🎉 Bukti transfer berhasil diunggah!');

                    // 3. Jalankan efek confetti (kalau fungsi launchConfetti-mu ada di bawah)
                    if (typeof launchConfetti === 'function') {
                        launchConfetti();
                    }

                    // 4. UBAH AKSI KLIK TOMBOL: Pas diklik lagi, baru jalan ke selesai.php
                    btn.onclick = function() {
                        window.location.href = 'selesai.php?order_id=' + orderId;
                    };
                    
                    // Atau kalau mau teks tombolnya berubah otomatis jadi "Halaman Selanjutnya" setelah 2 detik:
                    setTimeout(() => {
                        btn.innerHTML = 'Halaman Selanjutnya <i class="fas fa-arrow-right"></i>';
                    }, 2000);
                } else {
                    alert('❌ Gagal: ' + result.message);
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-check-circle"></i> SAYA SUDAH BAYAR';
                    }
                }
            } catch (error) {
                console.error(error);
                alert('❌ Terjadi kesalahan jaringan server.');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> SAYA SUDAH BAYAR';
                }
            }
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

        // 2. Kalau tokennya ada, langsung panggil pop-up Midtrans otomatis
        if (snapToken) {
            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    // Redirect ke selesai.php udah DIMUSNAHKAN dari sini
                    // Diganti jadi notif dan layar otomatis geser ke area Upload Bukti
                    showToast('🎉 Pembayaran di Midtrans Sukses! Silakan unggah bukti transfer Anda.');
                    document.getElementById('uploadArea').scrollIntoView({ behavior: 'smooth', block: 'center' });
                },
                onPending: function(result){
                    showToast('⏳ Menunggu pembayaran. Selesaikan transfer lalu unggah bukti.');
                },
                onError: function(result){
                    showToast('❌ Pembayaran Gagal di Midtrans!');
                },
                onClose: function(){
                    showToast('⚠️ Pop-up ditutup. Jangan lupa unggah bukti jika sudah transfer.');
                }
            });
        } else 

            // ... (biarkan sisa kodingan di bawahnya tetap sama)
        // ===== CONFIRM PAYMENT =====
        function confirmPayment() {
            const btn = document.getElementById('btnConfirm');
            const uploadArea = document.getElementById('uploadArea');

            // Check if file uploaded (simulate)
            const hasFile = uploadArea.classList.contains('has-file');
            if (!hasFile) {
                showToast('⚠️ Harap upload bukti pembayaran terlebih dahulu');
                uploadArea.style.borderColor = '#e74c3c';
                setTimeout(() => {
                    uploadArea.style.borderColor = '';
                }, 2000);
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';

            // Simulate verification
            setTimeout(() => {
                // Success state
                btn.innerHTML = '<i class="fas fa-check"></i> Pembayaran Terverifikasi';
                btn.style.background = 'linear-gradient(135deg, #27ae60, #2ecc71)';

                // Update status badge
                const badge = document.getElementById('statusBadge');
                badge.className = 'status-badge status-success';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Pembayaran Berhasil';

                // Update stepper
                document.getElementById('step2').classList.remove('active');
                document.getElementById('step2').classList.add('completed');
                document.getElementById('step2').querySelector('.step-circle').innerHTML = '<i class="fas fa-check"></i>';
                document.getElementById('line2').classList.add('completed');
                document.getElementById('step3').classList.add('active');
                document.getElementById('step3').querySelector('.step-circle').innerHTML = '<i class="fas fa-check"></i>';

                // Confetti
                launchConfetti();

                showToast('🎉 Pembayaran berhasil! Pesanan Anda akan segera diproses');

                // Change button action
                setTimeout(() => {
                    btn.innerHTML = 'Halaman Selanjutnya <i class="fas fa-arrow-right"></i>';
                    btn.disabled = false;
                    btn.onclick = () => window.location.href = '../checkout/selesai.php';
                }, 2000);
            }, 2500);
        }

        // ===== CANCEL ORDER =====
        function cancelOrder() {
            if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                showToast('❌ Pesanan telah dibatalkan');
                setTimeout(() => {
                    window.location.href = '../checkout/selesai.php';
                }, 1500);
            }
        }
        // Fungsi untuk memunculkan nama file saat user selesai memilih gambar
function previewFile() {
    const fileInput = document.getElementById('fileBukti');
    const statusText = document.getElementById('uploadStatus');
    if (fileInput.files.length > 0) {
        statusText.innerHTML = `✅ File terpilih: <b>${fileInput.files[0].name}</b>`;
    }
}

// Fungsi utama saat tombol "SAYA SUDAH BAYAR" diklik


        // ===== CONFETTI =====
        function launchConfetti() {
            const container = document.getElementById('confetti');
            container.classList.add('active');
            const colors = ['#c9a84c', '#d4b76a', '#ffffff', '#27ae60', '#f1c40f'];
            for (let i = 0; i < 60; i++) {
                const conf = document.createElement('div');
                conf.className = 'confetti';
                conf.style.left = Math.random() * 100 + '%';
                conf.style.background = colors[Math.floor(Math.random() * colors.length)];
                conf.style.width = (6 + Math.random() * 8) + 'px';
                conf.style.height = (6 + Math.random() * 8) + 'px';
                conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                conf.style.animationDuration = (2 + Math.random() * 2) + 's';
                conf.style.animationDelay = (Math.random() * 0.5) + 's';
                container.appendChild(conf);
            }
            setTimeout(() => {
                container.classList.remove('active');
                container.innerHTML = '';
            }, 4000);
        }

        // ===== SCROLL REVEAL =====
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.payment-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.transitionDelay = (index * 0.15) + 's';
            revealObserver.observe(card);
        });
        // ===== BACA DATA DARI INFORMASI.PHP (SINKRONISASI MUTLAK) =====
        function renderPaymentSummary() {
            const container = document.getElementById('paymentItemsList');
            if (!container) return;

            // 1. Ambil data dari Meja Kasir (Jalur apapun yang masuk dari informasi.php)
            let checkoutItems = JSON.parse(sessionStorage.getItem('caymira_checkout_data')) || [];
            
            if (checkoutItems.length === 0) {
                container.innerHTML = '<p style="color:#888; text-align:center; padding: 20px 0;">Tidak ada data pesanan.</p>';
                return;
            }

            let subtotal = 0;
            let itemsHTML = '';

            checkoutItems.forEach((item) => {
                let itemPrice = parseInt(item.price) || 0;
                let itemQty = parseInt(item.quantity) || 1;
                subtotal += (itemPrice * itemQty);

               // === JURUS HYBRID DETEKSI GAMBAR 2 DIMENSI (DB + CODINGAN) ===
                let imgPath = item.image || '';
                
                if (imgPath === '') {
                    imgPath = 'https://via.placeholder.com/60x60/0a1628/c9a84c?text=Foto'; 
                } else if (!imgPath.includes('http') && !imgPath.includes('../')) {
                    // JALUR 1: Jika data dari DB sudah membawa folder (contoh: "gambar all product/...")
                    if (imgPath.startsWith('gambar ')) {
                        imgPath = '../best-seller/' + imgPath;
                    } 
                    // JALUR 2: Jika murni cuma nama file gambar saja (contoh: "hasan.png")
                    else {
                        let namaBaju = item.name.toLowerCase();
                        if (namaBaju.includes('gamis')) imgPath = '../Gamis/' + imgPath;
                        else if (namaBaju.includes('koko')) imgPath = '../Koko/' + imgPath;
                        else if (namaBaju.includes('hijab') || namaBaju.includes('kerudung')) imgPath = '../hijab/' + imgPath; 
                        else if (namaBaju.includes('jubah')) imgPath = '../Jubah/' + imgPath;   
                        else imgPath = '../Beranda/Gambarberanda/' + imgPath; // Jalur cadangan terakhir
                    }
                }

                itemsHTML += `
                    <div class="order-item" style="display: flex; align-items: center; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                        <img src="${imgPath}" alt="${item.name}" onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60/0a1628/c9a84c?text=Foto';" style="width: 60px; height: 60px; border-radius: 8px; margin-right: 15px; object-fit: cover;">
                        <div class="order-details" style="flex: 1;">
                            <div style="font-weight: bold; color: #fff; font-size: 14px;">${item.name}</div>
                            <div style="color: #bbb; font-size: 13px; margin-top: 4px;">
                                Qty: <strong style="color: #d4af37;">x${itemQty}</strong>
                            </div>
                            <div style="color: #d4af37; font-weight: bold; margin-top: 4px; font-size: 13px;">
                                Rp ${itemPrice.toLocaleString('id-ID')}
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = itemsHTML;

            // 2. Hitung Total & Ongkir persis seperti di informasi.php
            const ongkir = 32000;
            let voucherDiscount = 0;
            if (sessionStorage.getItem('caymira_checkout_jalur') === 'dari_keranjang') {
                voucherDiscount = parseInt(localStorage.getItem('caymira_discount')) || 0;
            }

            const totalAkhir = (subtotal - voucherDiscount) + ongkir;
            
            document.getElementById('textSubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('textDiscount').innerText = '- Rp ' + voucherDiscount.toLocaleString('id-ID');
            document.getElementById('textTotal').innerText = 'Rp ' + totalAkhir.toLocaleString('id-ID');

            // Sinkronkan juga nominal raksasa "Total yang Harus Ditransfer" di kolom kiri!
            const h2TotalTransfer = document.querySelector('.payment-left h2');
            if (h2TotalTransfer) {
                h2TotalTransfer.innerText = 'Rp ' + totalAkhir.toLocaleString('id-ID');
            }

            // 3. Tampilkan Nama & Alamat Pengiriman dari form informasi.php
            const namaPenerima = localStorage.getItem('caymira_cust_nama') || 'Aisyah Putri';
            const alamatPenerima = localStorage.getItem('caymira_cust_alamat') || '';
            const kotaPenerima = localStorage.getItem('caymira_cust_kota') || '';
            const kodeposPenerima = localStorage.getItem('caymira_cust_kodepos') || '';
            
            document.getElementById('textNamaPenerima').innerText = namaPenerima;
            document.getElementById('textAlamatPenerima').innerText = alamatPenerima + ', ' + kotaPenerima + ' ' + kodeposPenerima;
        }

        // Jalankan fungsi ini otomatis pas halaman dibuka
        document.addEventListener('DOMContentLoaded', () => {
            renderPaymentSummary();
        });
    </script>
</body>
</html>
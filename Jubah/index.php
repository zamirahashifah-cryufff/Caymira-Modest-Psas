<?php 
include 'koneksi.php'; 

// Ambil parameter search dari URL
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Build query dasar
$sql = "SELECT * FROM jubah";

// Tambahkan logika Pencarian (Search) jika ada
if (!empty($search)) {
    $sql .= " WHERE nama_produk LIKE '%$search%'";
}

$query = mysqli_query($koneksi, $sql);
$total_produk = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jubah - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
img { max-width: 100%; height: auto; display: block; }
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

/* === PARTICLES === */
.particles {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 1;
    overflow: hidden;
}
.particle {
    position: absolute;
    width: 3px; height: 3px;
    background: var(--gold);
    border-radius: 50%;
    opacity: 0;
    animation: float 12s infinite;
}
@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10% { opacity: 0.4; }
    90% { opacity: 0.4; }
    100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
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

/* === JUBAH HERO SECTION === */
.jubah-hero {
    position: relative;
    width: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    margin-top: 70px;
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 40%, var(--navy-lighter) 100%);
}

.jubah-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: 
        radial-gradient(circle at 30% 50%, rgba(201, 168, 76, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 70% 20%, rgba(201, 168, 76, 0.08) 0%, transparent 40%);
    z-index: 1;
    pointer-events: none;
}

.jubah-hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a84c' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    z-index: 0;
    opacity: 0.5;
}

.jubah-hero-wrapper {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 0;
    gap: 60px;
}

.jubah-hero-text {
    flex: 1;
    max-width: 550px;
}

.jubah-hero-text .subtitle {
    font-family: var(--font-heading);
    font-style: italic;
    font-weight: 400;
    font-size: 22px;
    margin-bottom: 15px;
    color: var(--gold-light);
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.3s forwards;
}

.jubah-hero-text h1 {
    font-family: var(--font-heading);
    font-size: 58px;
    line-height: 1.1;
    margin-bottom: 20px;
    color: var(--white);
    font-weight: 700;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.5s forwards;
    letter-spacing: 2px;
}

.jubah-hero-text h1 span {
    display: block;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, var(--gold) 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shine 3s linear infinite;
}

@keyframes shine {
    to { background-position: 200% center; }
}

.jubah-hero-text .description {
    color: var(--text-light);
    font-size: 15px;
    line-height: 1.9;
    margin-bottom: 35px;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.7s forwards;
}

.jubah-hero-text .description span {
    color: var(--gold);
    font-weight: 500;
}

.jubah-hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    padding: 16px 36px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.4s ease;
    cursor: pointer;
    border: none;
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.9s forwards;
}

.jubah-hero-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.jubah-hero-cta:hover::before {
    left: 100%;
}

.jubah-hero-cta:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
}

.jubah-hero-cta i {
    transition: transform 0.3s;
}

.jubah-hero-cta:hover i {
    transform: translateX(5px);
}

/* Hero Image */
.jubah-hero-images {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    position: relative;
    perspective: 1000px;
}

.jubah-hero-img {
    width: 240px;
    height: 420px;
    object-fit: cover;
    border-radius: 20px;
    border: 2px solid rgba(201, 168, 76, 0.3);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateY(50px) rotateY(-10deg);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
}

.jubah-hero-img:nth-child(1) {
    animation: fadeInUp3D 1s ease 0.5s forwards;
    margin-right: -60px;
    z-index: 1;
    transform-origin: right center;
}

.jubah-hero-img:nth-child(2) {
    animation: fadeInUp3D 1s ease 0.7s forwards;
    margin-left: -60px;
    z-index: 2;
    transform-origin: left center;
}

.jubah-hero-img:hover {
    transform: translateY(-15px) scale(1.05) rotateY(0deg);
    border-color: var(--gold);
    box-shadow: 0 30px 60px rgba(201, 168, 76, 0.25);
    z-index: 10;
}

@keyframes fadeInUp3D {
    from { opacity: 0; transform: translateY(50px) rotateY(-10deg); }
    to { opacity: 1; transform: translateY(0) rotateY(-5deg); }
}

/* Decorative elements */
.hero-deco-circle {
    position: absolute;
    border: 1px solid rgba(201, 168, 76, 0.15);
    border-radius: 50%;
    pointer-events: none;
}

.hero-deco-1 { width: 350px; height: 350px; top: -80px; right: -100px; animation: rotate 25s linear infinite; }
.hero-deco-2 { width: 200px; height: 200px; bottom: 20px; right: 250px; animation: rotate 20s linear infinite reverse; }
.hero-deco-3 { width: 120px; height: 120px; top: 40%; left: -60px; animation: rotate 18s linear infinite; }

@keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* === MARQUEE BANNER === */
.marquee-banner {
    background: linear-gradient(90deg, var(--navy), var(--navy-light), var(--navy));
    padding: 15px 0; overflow: hidden; position: relative;
    border-top: 1px solid rgba(201, 168, 76, 0.2);
    border-bottom: 1px solid rgba(201, 168, 76, 0.2);
}

.marquee-content {
    display: flex; animation: marqueeScroll 20s linear infinite; white-space: nowrap;
}

.marquee-item {
    display: inline-flex; align-items: center; gap: 15px; padding: 0 40px;
    color: var(--gold); font-size: 13px; letter-spacing: 2px; text-transform: uppercase;
}

.marquee-item i { color: var(--gold); font-size: 14px; }

@keyframes marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* === FILTER BAR === */
.filter-bar {
    background: rgba(15, 29, 53, 0.95);
    backdrop-filter: blur(10px);
    padding: 25px 0;
    position: sticky;
    top: 70px;
    z-index: 100;
    border-bottom: 1px solid rgba(201, 168, 76, 0.15);
}

.filter-wrapper { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
.filter-categories { display: flex; gap: 15px; flex-wrap: wrap; }
.filter-btn {
    background: transparent; border: 1px solid rgba(201, 168, 76, 0.3);
    color: var(--text-light); padding: 10px 24px; border-radius: 25px;
    font-size: 13px; font-weight: 500; letter-spacing: 1px;
    text-transform: uppercase; cursor: pointer; transition: all 0.4s ease;
}
.filter-btn:hover, .filter-btn.active {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy); border-color: var(--gold);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3); transform: translateY(-2px);
}
.filter-sort { display: flex; align-items: center; gap: 10px; }
.filter-sort select {
    background: rgba(201, 168, 76, 0.1); border: 1px solid rgba(201, 168, 76, 0.2);
    color: var(--gold); padding: 10px 20px; border-radius: 25px; font-size: 13px;
    cursor: pointer; outline: none; transition: all 0.3s;
}

/* === SECTION HEADER === */
.section-header { text-align: center; margin-bottom: 60px; position: relative; z-index: 1; }
.section-header h2 { font-family: var(--font-heading); font-size: 42px; color: var(--gold); margin-bottom: 15px; text-transform: uppercase; }
.section-header p { color: var(--text-muted); font-size: 16px; font-style: italic; }

/* === PRODUCT GRID === */
.jubah-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; position: relative; z-index: 1;
}
.jubah-card {
    background: rgba(201, 168, 76, 0.03); border: 1px solid rgba(201, 168, 76, 0.1);
    border-radius: 20px; padding: 20px; position: relative;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden;
    opacity: 0; transform: translateY(50px); cursor: pointer;
}
.jubah-card.visible { opacity: 1; transform: translateY(0); }

.jubah-badge {
    position: absolute; top: 30px; left: 30px; z-index: 2; font-size: 10px;
    font-weight: 700; padding: 6px 14px; border-radius: 20px;
    letter-spacing: 1px; text-transform: uppercase;
}
.jubah-badge.new { background: var(--gold); color: var(--navy); }
.jubah-badge.best { background: #e74c3c; color: var(--white); }

.jubah-img-wrapper { position: relative; overflow: hidden; border-radius: 14px; margin-bottom: 20px; }
.jubah-img {
    width: 100%; height: 320px; object-fit: cover; border-radius: 14px; transition: transform 0.6s ease;
}
.jubah-card:hover .jubah-img { transform: scale(1.08); }
.jubah-img-overlay {
    position: absolute; bottom: 0; left: 0; width: 100%; padding: 25px 15px 15px;
    background: linear-gradient(to top, rgba(10, 22, 40, 0.9), transparent);
    opacity: 0; transition: all 0.4s; transform: translateY(20px);
}
.jubah-card:hover .jubah-img-overlay { opacity: 1; transform: translateY(0); }

.jubah-price { color: var(--gold); font-size: 18px; font-weight: 700; margin-bottom: 10px; }
.jubah-rating { display: flex; align-items: center; gap: 8px; font-size: 12px; }
.stars { color: var(--gold); }

.no-products {
    grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);
}
.no-products i { font-size: 48px; color: var(--gold); margin-bottom: 20px; display: block; }

/* === FOOTER === */
.footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; position: relative; }
.footer-bottom {
    text-align: center; padding-top: 35px; margin-top: 35px;
    border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px; color: #ffffff;             
    background-color: #000000; padding-bottom: 35px; margin-left: -60px; margin-right: -60px;
}

/* Scroll to top */
.scroll-top {
    position: fixed; bottom: 25px; right: 25px; width: 45px; height: 45px;
    background: var(--gold); color: var(--navy); border: none; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999;
}
.scroll-top.visible { opacity: 1; visibility: visible; }

/* Toast */
.toast {
    position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%) translateY(100px);
    background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px;
    font-weight: 500; font-size: 14px; opacity: 0; transition: all 0.4s;
    z-index: 10000; display: flex; align-items: center; gap: 10px;
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

/* Animations */
@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

/* Responsive */
@media (max-width: 768px) {
    .navbar { padding: 15px 30px; }
    .logo-img { height: 30px; }
    .nav-links {
        position: fixed; top: 0; right: -100%; width: 75%; height: 100vh;
        background: var(--navy); flex-direction: column; padding: 100px 40px;
        transition: right 0.4s; border-left: 1px solid rgba(201, 168, 76, 0.2); gap: 30px;
    }
    .nav-links.active { right: 0; }
    .mobile-menu-btn { display: flex; }
    .jubah-grid { grid-template-columns: repeat(2, 1fr); }
    .jubah-hero h1 { font-size: 32px; }
    .custom-cursor, .cursor-dot { display: none; }
}
    </style>
</head>

<body>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari jubah..." id="searchInput" value="<?php echo htmlspecialchars($search); ?>">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" onerror="this.src='https://via.placeholder.com/150x50/0a1628/c9a84c?text=Caymira'">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearch()"></i>
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

    <!-- Jubah Hero Section -->
    <section class="jubah-hero">
        <div class="hero-deco-circle hero-deco-1"></div>
        <div class="hero-deco-circle hero-deco-2"></div>
        <div class="hero-deco-circle hero-deco-3"></div>
    
        <div class="jubah-hero-wrapper">
            <div class="jubah-hero-text">
                <p class="subtitle">Stylish & Elegan</p>
                <h1>JUBAH <span>PREMIUM</span></h1>
                <p class="description">
                    Koleksi jubah stylish dan elegan. Paduan sempurna antara <span>syariat dan kemodernan</span>. 
                    Bahan yang ringan dan potongan rapi, memberikan kesan dewasa yang berkhasan namun tetap 
                    menarik di setiap kesempatan ibadah.
                </p>
                <button class="jubah-hero-cta" onclick="document.querySelector('.jubah-collection').scrollIntoView({behavior: 'smooth'})">
                    Belanja Sekarang <i class="fas fa-arrow-right"></i>
                </button>
            </div>

             <div class="jubah-hero-images">
                <img src="gambarjubah/jubah1.png" alt="Jubah Model 1" class="jubah-hero-img">
                <img src="gambarjubah/jubah2.png" alt="Jubah Model 2" class="jubah-hero-img">
            </div>
        </div>
    </section>

    <!-- Marquee Banner -->
    <div class="marquee-banner">
        <div class="marquee-content">
            <div class="marquee-item"><i class="fas fa-star"></i> Gratis Ongkir Minimal Rp 500.000</div>
            <div class="marquee-item"><i class="fas fa-shield-alt"></i> Garansi Kualitas Terbaik</div>
            <div class="marquee-item"><i class="fas fa-truck"></i> Pengiriman Cepat 1-3 Hari</div>
            <div class="marquee-item"><i class="fas fa-headset"></i> Customer Service 24/7</div>
            <div class="marquee-item"><i class="fas fa-gift"></i> Diskon 20% Pembelian Pertama</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="container filter-wrapper">
            <div class="filter-categories">
                <button class="filter-btn active" onclick="filterJubah('all', this)">Semua</button>
                <button class="filter-btn" onclick="filterJubah('new', this)">Terbaru</button>
                <button class="filter-btn" onclick="filterJubah('best', this)">Best Seller</button>
            </div>
            <div class="filter-sort">
                <label>Urutkan:</label>
                <select onchange="sortJubah(this.value)">
                    <option value="popular">Paling Populer</option>
                    <option value="newest">Terbaru</option>
                    <option value="price-low">Harga: Rendah - Tinggi</option>
                    <option value="price-high">Harga: Tinggi - Rendah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Jubah Collection -->
    <section class="container jubah-collection" id="collection">
        <div class="section-header">
            <?php if(!empty($search)): ?>
                <h2>Hasil Pencarian: "<?php echo htmlspecialchars($search); ?>"</h2>
                <p><?php echo $total_produk; ?> Produk ditemukan. <a href="?" style="color: var(--gold); text-decoration: underline; margin-left: 10px;">Hapus Pencarian</a></p>
            <?php else: ?>
                <h2>JUBAH LAKI-LAKI</h2>
                <p>Koleksi jubah stylish dan elegan untuk laki-laki dewasa</p>
            <?php endif; ?>
        </div>

        <div class="jubah-grid" id="jubahGrid">
            <?php 
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) { 
                    $label = isset($row['label']) ? $row['label'] : '';
                    $category_lbl = strtolower($label); 
                    $ulasan = isset($row['total_ulasan']) ? $row['total_ulasan'] : rand(40, 150);
                    $harga_sekarang = isset($row['harga_diskon']) ? $row['harga_diskon'] : $row['harga'];
                    $harga_coret = isset($row['harga_asli']) ? $row['harga_asli'] : 0;
                    $sumber_gambar = $row['gambar']; 
                    $nama_aman = htmlspecialchars($row['nama_produk'], ENT_QUOTES);
            ?>
            <div class="jubah-card visible" data-category="<?php echo $category_lbl; ?>" data-price="<?php echo $harga_sekarang; ?>">
                <?php if(!empty($label)): ?>
                    <span class="jubah-badge <?php echo $category_lbl; ?>"><?php echo $label; ?></span>
                <?php endif; ?>

                <div class="jubah-img-wrapper">
                    <a href="../detailproduk/index.php?id=<?php echo $row['id']; ?>&kategori=jubah" style="display: block;">
                        <img src="<?php echo $sumber_gambar; ?>" alt="<?php echo $nama_aman; ?>" class="jubah-img">
                    </a>
                    <div class="jubah-img-overlay">
                        <button type="button" class="overlay-btn" onclick="addToCart('<?php echo $row['id']; ?>', '<?php echo $nama_aman; ?>', <?php echo $harga_sekarang; ?>, '<?php echo $sumber_gambar; ?>')">
                            <i class="fas fa-cart-plus"></i> Tambah 
                        </button>
                    </div>
                </div>

                <div class="jubah-info">
                    <h3><?php echo $row['nama_produk']; ?></h3>
                    <p class="jubah-price">
                        Rp <?php echo number_format($harga_sekarang, 0, ',', '.'); ?>
                        <?php if($harga_coret > $harga_sekarang): ?>
                            <span class="old-price">Rp <?php echo number_format($harga_coret, 0, ',', '.'); ?></span>
                        <?php endif; ?>
                    </p>
                    <div class="jubah-rating">
                        <span class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
                        <span class="review-count">(<?php echo $ulasan; ?>)</span>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else {
                echo "<div class='no-products'><i class='fas fa-search'></i><h3>Pencarian Tidak Ditemukan</h3><p>Maaf, jubah yang Anda cari tidak tersedia.</p></div>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-brand">
                 <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                   <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
                 </div>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                   <li><a href="../Beranda/beranda.php">Beranda</a></li>
                   <li><a href="../About-us/aboutus.php">About Us</a></li>
                   <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                   <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Contact</h4>
                <div class="contact-item"><i class="fas fa-phone"></i> 0895-7042-D0408</div>
                <div class="contact-item"><i class="far fa-envelope"></i> caymiramodest@gmail.com</div>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Newsletter</h4>
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

    <button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Custom Cursor
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px';
            cursorDot.style.top = e.clientY - 3 + 'px';
        });

        // Search Overlay
        function toggleSearch() {
            const overlay = document.getElementById('searchOverlay');
            overlay.classList.toggle('active');
            if(overlay.classList.contains('active')) {
                setTimeout(() => document.getElementById('searchInput').focus(), 100);
            }
        }

        // Enter untuk Search (Scroll ke Collection)
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const term = this.value.trim();
                if (term !== "") {
                    window.location.href = '?search=' + encodeURIComponent(term) + '#collection';
                } else {
                    window.location.href = '?#collection';
                }
            }
        });

        function toggleMobileMenu() {
            document.getElementById('mobileMenuBtn').classList.toggle('active');
            document.getElementById('navLinks').classList.toggle('active');
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastText').innerText = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const scrollTopBtn = document.getElementById('scrollTop');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                scrollTopBtn.classList.add('visible');
            } else {
                navbar.classList.remove('scrolled');
                scrollTopBtn.classList.remove('visible');
            }
        });

        // ===================== LOGIKA KERANJANG =====================
        function getCart() { return JSON.parse(localStorage.getItem('caymira_cart')) || []; }
        function saveCart(cart) { localStorage.setItem('caymira_cart', JSON.stringify(cart)); }
        function updateCartBadge() {
            const cart = getCart();
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = totalItems;
                badge.style.display = totalItems > 0 ? 'flex' : 'none';
            }
        }
        function addToCart(id, name, price, image) {
            let cart = getCart();
            let existingItem = cart.find(item => item.id === id);
            if (existingItem) { existingItem.quantity += 1; } 
            else { cart.push({ id, name, price, image, quantity: 1 }); }
            saveCart(cart); 
            updateCartBadge(); 
            showToast(name + ' berhasil ditambahkan!');
        }

        document.addEventListener("DOMContentLoaded", updateCartBadge);
    </script>
</body>
</html>
<?php
// Memanggil koneksi database
include 'koneksi.php'; 

// Ambil parameter search dari URL
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Build query dasar
$query = "SELECT * FROM hijab";

// Tambahkan logika Pencarian (Search) jika ada
if (!empty($search)) {
    $query .= " WHERE nama_produk LIKE '%$search%'";
}

$result = mysqli_query($koneksi, $query);
$total_produk = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Hijab - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --navy: #0a1628;
            --navy-light: #0f1d35;
            --navy-lighter: #152238;
            --gold: #c9a84c;
            --gold-light: #d4b76a;
            --gold-dark: #b8963f;
            --text-light: #e8e8e8;
            --text-muted: #a0a0a0;
            --white: #ffffff;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--navy);
            color: var(--text-light);
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

        /* ===================== CUSTOM CURSOR ===================== */
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
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
        }

        /* ===================== PARTICLES ===================== */
        .particles {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 1; overflow: hidden;
        }
        .particle {
            position: absolute; width: 3px; height: 3px;
            background: var(--gold); border-radius: 50%; opacity: 0;
            animation: float 12s infinite;
        }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }

        /* ===================== NAVBAR ===================== */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 1000;
            background: rgba(7, 13, 23, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.6);
            transition: all 0.3s ease;
            overflow: visible;
        }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .logo-img {
            height: 75px; width: auto; object-fit: contain;
            transition: all 0.3s; margin-top: 5px; position: relative; z-index: 1001; cursor: pointer;
        }
        .logo:hover .logo-img {
            transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.5));    
        }
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a {
            color: var(--text-light); text-decoration: none; font-size: 12px;
            font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase;
            position: relative; padding: 5px 0; transition: color 0.3s;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -4px; left: 0;
            width: 0; height: 2px; background: var(--gold); transition: width 0.3s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
        
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; transition: all 0.3s; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
        
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge {
            position: absolute; top: -8px; right: -8px;
            background: var(--gold); color: var(--navy); font-size: 10px;
            font-weight: 700; width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }

        /* Mobile Menu Btn */
        .mobile-menu-btn { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; padding: 5px; }
        .mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: all 0.3s; border-radius: 2px; }
        .mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
        .mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        /* ===================== SEARCH OVERLAY ===================== */
        .search-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 22, 40, 0.98); z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.4s;
        }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input {
            width: 100%; padding: 20px 60px 20px 0; background: transparent;
            border: none; border-bottom: 2px solid var(--gold);
            color: var(--gold); font-size: 32px; font-family: var(--font-heading); outline: none;
        }
        .search-box input::placeholder { color: rgba(201, 168, 76, 0.4); }
        .search-close {
            position: absolute; right: 0; top: 50%; transform: translateY(-50%);
            color: var(--gold); font-size: 28px; cursor: pointer; transition: transform 0.3s;
        }
        .search-close:hover { transform: translateY(-50%) rotate(90deg); }

        /* ===================== HERO SECTION HIJAB ===================== */
        .hero-hijab {
            width: 100%;
            position: relative;
            z-index: 2;
            /* GARIS PEMBATAS FULL SCREEN & TIPIS */
            border-bottom: 1px solid var(--gold);
        }
        
        /* Wrapper untuk konten hero agar tetap di tengah */
        .hero-wrapper {
            display: flex; 
            align-items: center;
            justify-content: space-between; 
            padding: 150px 0 80px;
        }

        .hero-hijab::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 70% 50%, rgba(201, 168, 76, 0.1) 0%, transparent 60%);
            pointer-events: none; z-index: -1;
        }
        .hero-text { flex: 1; padding-right: 50px; z-index: 2; animation: fadeInLeft 1s ease; }
        .hero-text h1 {
            font-family: var(--font-heading); font-size: 56px; color: var(--gold);
            margin-bottom: 20px; text-transform: uppercase; letter-spacing: 3px;
        }
        .hero-text p {
            font-size: 15px; line-height: 1.8; color: var(--text-light);
            margin-bottom: 40px; max-width: 500px;
        }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--navy); padding: 14px 35px; border-radius: 30px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;
            border: none; cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(201, 168, 76, 0.2);
        }
        .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(201, 168, 76, 0.4); }

        .hero-images {
            flex: 1; position: relative; height: 450px; display: flex;
            justify-content: center; align-items: center; animation: fadeInRight 1s ease;
        }
        .hero-img { position: absolute; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); transition: 0.5s; }
        .img-back {
            width: 280px; height: 380px; object-fit: cover;
            right: 10%; top: 10%; opacity: 0.7; filter: brightness(0.8);
            animation: floatImg 6s ease-in-out infinite;
        }
        .img-front {
            width: 320px; height: 420px; object-fit: cover;
            left: 10%; bottom: -5%; border: 2px solid rgba(201, 168, 76, 0.3); z-index: 2;
            animation: floatImg 8s ease-in-out infinite reverse;
        }
        @keyframes floatImg { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }

        /* ===================== TITLE SECTION ===================== */
        .section-header { text-align: center; padding: 80px 0 40px; position: relative; z-index: 2;}
        .section-header h2 {
            font-family: var(--font-heading); font-size: 42px; color: var(--gold);
            margin-bottom: 15px; text-transform: uppercase; letter-spacing: 3px;
        }
        .section-header p { font-size: 14px; color: var(--text-muted); max-width: 600px; margin: 0 auto; }

        /* ===================== PRODUCT GRID HIJAB ===================== */
        .product-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 30px; padding-bottom: 60px; position: relative; z-index: 2;
        }
        .product-card {
            background: rgba(20, 35, 58, 0.4);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 16px; overflow: hidden; position: relative;
            transition: all 0.4s ease; text-align: center; cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-10px); border-color: var(--gold);
            box-shadow: 0 15px 30px rgba(0,0,0,0.4), 0 0 20px rgba(201,168,76,0.1);
            background: rgba(20, 35, 58, 0.8);
        }
        .img-wrapper { width: 100%; height: 320px; overflow: hidden; position: relative; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .product-card:hover .img-wrapper img { transform: scale(1.1); }
        .action-overlay {
            position: absolute; bottom: -50px; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to top, rgba(10,22,40,0.9), transparent);
            display: flex; align-items: flex-end; justify-content: center;
            padding-bottom: 20px; opacity: 0; transition: all 0.4s ease;
        }
        .product-card:hover .action-overlay { bottom: 0; opacity: 1; }
        .btn-action {
            background: var(--gold); color: var(--navy); border: none;
            padding: 10px 20px; border-radius: 20px; font-size: 12px; font-weight: 600;
            display: flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.3s;
        }
        .btn-action:hover { background: var(--white); transform: scale(1.05); }
        .product-info { padding: 20px 15px; position: relative; }
        .product-info h3 {
            font-size: 14px; font-weight: 500; letter-spacing: 1px;
            text-transform: uppercase; margin-bottom: 8px; color: var(--text-light); transition: color 0.3s;
        }
        .product-card:hover .product-info h3 { color: var(--gold-light); }
        .product-info p { color: var(--gold); font-weight: 600; font-size: 16px; }

        /* ===================== FOOTER ===================== */
        .footer {
            background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15);
            padding: 50px 60px 30px; position: relative; z-index: 2;
        }
        .gold-branch-footer { position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: var(--text-muted); max-width: 230px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a {
            width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; color: var(--gold);
            text-decoration: none; transition: all 0.3s; font-size: 14px; position: relative; overflow: hidden;
        }
        .social-links a::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: var(--gold); transform: scale(0); transition: transform 0.3s; border-radius: 50%;
        }
        .social-links a:hover::before { transform: scale(1); }
        .social-links a:hover { color: var(--navy); transform: translateY(-3px); }
        .social-links a i { position: relative; z-index: 1; }
        .footer-title {
            color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px;
            text-transform: uppercase; margin-bottom: 22px; position: relative; display: inline-block;
        }
        .footer-title::after {
            content: ''; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px;
            background: var(--gold); transition: width 0.3s;
        }
        .footer-col:hover .footer-title::after { width: 100%; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            color: var(--text-muted); text-decoration: none; font-size: 13px; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .footer-links a::before { content: '→'; color: var(--gold); opacity: 0; transform: translateX(-10px); transition: all 0.3s; }
        .footer-links a:hover { color: var(--gold); transform: translateX(4px); }
        .footer-links a:hover::before { opacity: 1; transform: translateX(0); }
        .contact-item {
            display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px; color: var(--text-muted);
            font-size: 13px; transition: all 0.3s; cursor: pointer;
        }
        .contact-item:hover { color: var(--gold); transform: translateX(5px); }
        .contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; transition: transform 0.3s; }
        .contact-item:hover i { transform: scale(1.2); }
        .newsletter-text { font-size: 12px; color: var(--text-muted); line-height: 1.6; margin-bottom: 18px; }
        .newsletter-form {
            display: flex; border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 4px;
            overflow: hidden; transition: all 0.3s; position: relative;
        }
        .newsletter-form:focus-within { border-color: var(--gold); box-shadow: 0 0 20px rgba(201, 168, 76, 0.2); }
        .newsletter-form input {
            flex: 1; background: transparent; border: none; padding: 12px 14px;
            color: #333; font-size: 13px; outline: none;
        }
        .newsletter-form button {
            background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: all 0.3s;
        }
        .newsletter-form button:hover { background: var(--gold-light); }
        .footer-bottom {
            text-align: center; padding-top: 35px; margin-top: 35px; border-top: 1px solid rgba(201, 168, 76, 0.15);
            font-size: 12px; color: #ffffff; background-color: #000000; padding-bottom: 35px;
            margin-left: -60px; margin-right: -60px;
        }

        /* ===================== TOAST & SCROLL TOP ===================== */
        .toast {
            position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%) translateY(100px);
            background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px;
            font-weight: 500; font-size: 14px; opacity: 0; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 10000; box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4); display: flex; align-items: center; gap: 10px;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        .scroll-top {
            position: fixed; bottom: 25px; right: 25px; width: 45px; height: 45px; background: var(--gold);
            color: var(--navy); border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center;
            justify-content: center; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999;
            box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4); font-size: 16px;
        }
        .scroll-top.visible { opacity: 1; visibility: visible; }
        .scroll-top:hover { transform: translateY(-5px) scale(1.1); box-shadow: 0 8px 25px rgba(201, 168, 76, 0.5); }

        /* No Results Section */
        .no-products {
            grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);
        }
        .no-products i { font-size: 48px; color: var(--gold); margin-bottom: 20px; display: block; }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 1024px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
            .hero-text h1 { font-size: 42px; }
            .footer-content { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 15px 30px; }
            .logo-img { height: 30px; }
            .nav-links {
                position: fixed; top: 0; right: -100%; width: 75%; height: 100vh;
                background: var(--navy); flex-direction: column; padding: 100px 40px;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border-left: 1px solid rgba(201, 168, 76, 0.2); gap: 30px;
            }
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
            .hero-wrapper { flex-direction: column; padding-top: 120px; text-align: center; }
            .hero-text { padding-right: 0; }
            .hero-images { margin-top: 40px; width: 100%; height: 350px; }
            .img-front { left: 50%; transform: translateX(-50%); width: 250px; height: 320px; }
            .img-back { display: none; }
            .product-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .custom-cursor, .cursor-dot { display: none; }
        }
        @media (max-width: 480px) {
            .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari produk kerudung..." id="searchInput" value="<?= htmlspecialchars($search) ?>">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
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

    <!-- Hero Section Hijab (Width Full Screen untuk Garis) -->
    <section class="hero-hijab">
        <div class="container hero-wrapper">
            <div class="hero-text">
                <h1>Kerudung</h1>
                <p>Koleksi kerudung terbaru dengan sentuhan modern dan elegan, dirancang untuk memberikan kenyamanan sekaligus tampilan yang menawan dalam setiap aktivitas Anda.</p>
                <button class="btn-gold" onclick="document.getElementById('koleksi').scrollIntoView({behavior: 'smooth'})">
                    Belanja Sekarang <i class="fas fa-arrow-down" style="margin-left:8px;"></i>
                </button>
            </div>
            <div class="hero-images">
                <img src="gambarhijab/gambar_hero_1.png" alt="Model Hijab 1" class="hero-img img-front">
            </div>
        </div>
    </section>

    <!-- Header Grid Produk -->
    <section class="container section-header" id="koleksi">
        <?php if(!empty($search)): ?>
            <h2>Hasil Pencarian: "<?= htmlspecialchars($search) ?>"</h2>
            <p><?= $total_produk ?> Produk ditemukan. <a href="?" style="color: var(--gold); text-decoration: underline; margin-left: 10px;">Hapus Pencarian</a></p>
        <?php else: ?>
            <h2>Koleksi Kerudung</h2>
            <p>Beragam model kerudung terbaru dengan kualitas terbaik, siap melengkapi gaya muslimah yang modis dan elegan.</p>
        <?php endif; ?>
    </section>

    <!-- Grid Produk (Dinamis dari Database) -->
    <section class="container product-grid">
        
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $harga_format = "Rp " . number_format($row['harga'], 0, ',', '.');
        ?>
        
        <div class="product-card">
            <div class="img-wrapper">
                <img src="<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>">
                
                <div class="action-overlay">
                    <button class="btn-action" onclick="addToCart('<?= $row['id'] ?>', '<?= htmlspecialchars($row['nama_produk'], ENT_QUOTES) ?>', <?= $row['harga'] ?>, '<?= $row['gambar'] ?>'); event.stopPropagation();">
                        <i class="fas fa-cart-plus"></i> Tambah
                    </button>
                </div>
                
            </div>
            <div class="product-info">
                <h3><?= $row['nama_produk'] ?></h3>
                <p><?= $harga_format ?></p>
            </div>
        </div>

        <?php 
            }
        } else {
            echo "<div class='no-products'><i class='fas fa-search'></i><h3>Produk tidak ditemukan</h3><p>Coba gunakan kata kunci lain.</p></div>";
        }
        ?>

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
                    <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" onerror="this.src='https://via.placeholder.com/150x50/0a1628/c9a84c?text=Caymira'">
                </div>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#" onclick="showToast('📸 Instagram: @caymiramodest')"><i class="fab fa-instagram"></i></a>
                    <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-D0408')"><i class="fab fa-whatsapp"></i></a>
                </div>
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
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')">
                    <i class="far fa-clock"></i>
                    <div><div>Monday - Saturday</div><div>10.00 - 17.00 WIB</div></div>
                </div>
                <div class="contact-item" onclick="showToast('📞 Hubungi: 0895-7042-D0408')">
                    <i class="fas fa-phone"></i><div>0895-7042-D0408</div>
                </div>
                <div class="contact-item" onclick="showToast('📧 Email: caymiramodest@gmail.com')">
                    <i class="far fa-envelope"></i><div>caymiramodest@gmail.com</div>
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

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            updateCartBadge();
        });

        // Custom Cursor
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px'; cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px'; cursorDot.style.top = e.clientY - 3 + 'px';
        });
        document.querySelectorAll('a, button, .product-card, .logo-img').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        // Particles
        const particlesContainer = document.getElementById('particles');
        for(let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 12 + 's';
            particle.style.animationDuration = (8 + Math.random() * 8) + 's';
            particlesContainer.appendChild(particle);
        }

        // Search Overlay
        function toggleSearch() { 
            const overlay = document.getElementById('searchOverlay');
            overlay.classList.toggle('active');
            if (overlay.classList.contains('active')) {
                setTimeout(() => document.getElementById('searchInput').focus(), 300);
            }
        }

        // Logika Enter untuk Search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm !== "") {
                    window.location.href = '?search=' + encodeURIComponent(searchTerm) + '#koleksi';
                } else {
                    window.location.href = '?#koleksi';
                }
            }
        });

        // Mobile Menu
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('active');
            document.getElementById('mobileMenuBtn').classList.toggle('active');
        }

        // Toast
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastText').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Scroll to Top
        const scrollTopBtn = document.createElement('button');
        scrollTopBtn.className = 'scroll-top';
        scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        document.body.appendChild(scrollTopBtn);

        window.addEventListener('scroll', () => {
            if(window.scrollY > 500) scrollTopBtn.classList.add('visible');
            else scrollTopBtn.classList.remove('visible');
            
            const navbar = document.getElementById('navbar');
            if(window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        scrollTopBtn.addEventListener('click', () => { window.scrollTo({top: 0, behavior: 'smooth'}); });

        function handleSubscribe(e) {
            e.preventDefault();
            const email = document.getElementById('emailInput').value;
            showToast('📧 Terima kasih! ' + email + ' telah berlangganan.');
            document.getElementById('emailInput').value = '';
        }

        // ===================== LOGIKA KERANJANG BELANJA =====================
        function getCart() {
            return JSON.parse(localStorage.getItem('caymira_cart')) || [];
        }

        function saveCart(cart) {
            localStorage.setItem('caymira_cart', JSON.stringify(cart));
        }

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
            
            if (existingItem) {
                  existingItem.quantity += 1; 
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    quantity: 1
                });
            }

            saveCart(cart); 
            updateCartBadge(); 
            
            showToast('🛒 ' + name + ' berhasil ditambahkan!');
        }
    </script>
</body>
</html>
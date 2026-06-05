<?php
session_start();

// Jika user mencoba masuk ke beranda tapi belum login, lempar ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_register/auth.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA & FONT (SYNCHRONIZED) === */
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background-color: var(--navy);
            color: var(--text-light);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

        /* Cursor (Identical) */
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

        /* Particles */
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

        /* === NAVBAR (COPIED FROM BERANDA) === */
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
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
        
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i {
            font-size: 18px;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
        
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge {
            position: absolute;
            top: -8px; right: -8px;
            background: var(--gold);
            color: var(--navy);
            font-size: 10px;
            font-weight: 700;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }

        /* Search Overlay */
        .search-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 22, 40, 0.98); z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.4s;
        }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input {
            width: 100%; padding: 20px 60px 20px 0;
            background: transparent; border: none;
            border-bottom: 2px solid var(--gold); color: var(--gold);
            font-size: 32px; font-family: var(--font-heading); outline: none;
        }
        .search-close { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 28px; cursor: pointer; }

        /* Mobile Menu Btn */
        .mobile-menu-btn { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; }
        .mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: 0.3s; }

        /* =========================================
           HERO SECTION (BREAD TALE STYLE) - KEPT
           ========================================= */
        .about-hero-modern {
            margin-top: 100px;
            padding: 60px;
            position: relative;
            z-index: 2;
        }
        .hero-header-text { text-align: center; margin-bottom: 60px; animation: fadeInUp 1s ease; }
        .modern-title { font-family: var(--font-heading); font-size: 64px; color: var(--gold); margin-bottom: 20px; letter-spacing: 2px; }
        .modern-subtitle { max-width: 700px; margin: 0 auto; color: var(--text-muted); font-size: 15px; line-height: 1.8; }
        
        .hero-banner-strip { display: flex; gap: 15px; width: 100%; height: 220px; margin-bottom: 80px; overflow: hidden; }
        .hero-banner-strip .strip-img { flex: 1; height: 100%; object-fit: cover; border-radius: 10px; filter: brightness(0.7) grayscale(0.3); transition: 0.5s ease; }
        .hero-banner-strip .strip-img:hover { flex: 1.5; filter: brightness(1) grayscale(0); }

        .hero-split-container { display: flex; align-items: stretch; gap: 60px; max-width: 1200px; margin: 0 auto; position: relative; }
        .split-image-wrapper { flex: 1; position: relative; animation: fadeInLeft 1s ease; }
        .split-image-wrapper img { width: 100%; height: 600px; object-fit: cover; border-radius: 20px; box-shadow: 0 30px 60px rgba(0,0,0,0.5); }
        
        .split-info-card {
            flex: 1; background: var(--navy-light); border: 1px solid rgba(201, 168, 76, 0.2);
            padding: 60px; border-radius: 20px; display: flex; flex-direction: column; justify-content: center; position: relative; animation: fadeInRight 1s ease;
        }
        .glow-dot { position: absolute; width: 150px; height: 150px; background: var(--gold); filter: blur(80px); opacity: 0.2; top: -30px; right: -30px; z-index: -1; }
        .card-title { font-family: var(--font-heading); font-size: 42px; color: var(--gold); margin-bottom: 25px; line-height: 1.2; }
        .card-desc { font-size: 15px; line-height: 1.8; color: var(--text-light); margin-bottom: 35px; }
        
        .attributes-list { border-top: 1px solid rgba(201, 168, 76, 0.2); padding-top: 30px; margin-bottom: 40px; }
        .attr-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px; }
        .attr-label { font-weight: 600; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; }
        .attr-value { color: var(--text-muted); }

        /* Stats Counter */
        .stats-banner { display: flex; justify-content: center; gap: 80px; padding: 80px 0; background: linear-gradient(to right, var(--navy), var(--navy-light), var(--navy)); position: relative; overflow: hidden; }
        .stats-banner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
        .stat-item { text-align: center; opacity: 0; transform: translateY(30px); }
        .stat-item.visible { animation: fadeInUp 0.8s ease forwards; }
        .stat-number { font-family: var(--font-heading); font-size: 48px; color: var(--gold); font-weight: 700; display: block; }
        .stat-label { font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-top: 8px; }

        /* Content Text Reveal */
        .content-section { padding: 100px 60px; text-align: center; background: linear-gradient(to bottom, var(--navy), var(--navy-light)); }
        .content-text { max-width: 800px; margin: 0 auto; font-size: 16px; line-height: 2.2; color: var(--text-light); }
        .content-text p { margin-bottom: 30px; opacity: 0; transform: translateY(20px); transition: 0.8s ease; }
        .content-text p.visible { opacity: 1; transform: translateY(0); }
        .gold-text { color: var(--gold); font-weight: 500; cursor: pointer; }

        /* Values Section */
        .values-section { padding: 80px 60px; background: var(--navy); }
        .values-title { font-family: var(--font-heading); font-size: 42px; color: var(--gold); text-align: center; margin-bottom: 60px; }
        .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; max-width: 1100px; margin: 0 auto; }
        .value-card { background: rgba(201, 168, 76, 0.05); border: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 30px; border-radius: 15px; text-align: center; transition: 0.4s; }
        .value-card:hover { transform: translateY(-10px); border-color: var(--gold); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .value-icon { font-size: 40px; color: var(--gold); margin-bottom: 25px; }

        /* === FOOTER (COPIED FROM BERANDA) === */
        .footer {
            background: #ffffff;
            border-top: 1px solid rgba(201, 168, 76, 0.15);
            padding: 50px 60px 30px;
            position: relative;
            margin-top: 50px;
        }
        .gold-branch-footer {
            position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none;
        }
        .footer-content {
            display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto;
        }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; margin-top: 15px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a {
            width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; color: var(--gold); text-decoration: none; transition: 0.3s;
        }
        .social-links a:hover { background: var(--gold); color: var(--white); transform: translateY(-3px); }
        
        .footer-title {
            color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; position: relative; display: inline-block;
        }
        .footer-title::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px; background: var(--gold); transition: 0.3s; }
        .footer-col:hover .footer-title::after { width: 100%; }
        
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #888; text-decoration: none; font-size: 13px; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .footer-links a:hover { color: var(--gold); transform: translateX(4px); }
        
        .contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px; color: #888; font-size: 13px; transition: 0.3s; cursor: pointer; }
        .contact-item:hover { color: var(--gold); transform: translateX(5px); }
        .contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; }

        .newsletter-text { font-size: 12px; color: #888; line-height: 1.6; margin-bottom: 18px; }
        .newsletter-form { display: flex; border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 4px; overflow: hidden; }
        .newsletter-form input { flex: 1; border: none; padding: 12px 14px; font-size: 13px; outline: none; }
        .newsletter-form button { background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: 0.3s; }
        .newsletter-form button:hover { background: var(--gold-light); }

        .footer-bottom {
            text-align: center; padding: 35px 0; margin-top: 35px; border-top: 1px solid rgba(201, 168, 76, 0.15);
            font-size: 12px; color: #ffffff; background-color: #000000; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;
        }

        /* Toast */
        .toast {
            position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%) translateY(100px);
            background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px;
            font-weight: 500; font-size: 14px; opacity: 0; transition: 0.4s; z-index: 10000; box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4);
            display: flex; align-items: center; gap: 10px;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* Animations */
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        /* Scroll Top */
        .scroll-top {
            position: fixed; bottom: 25px; right: 25px; width: 45px; height: 45px; background: var(--gold);
            color: var(--navy); border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: 0.3s; z-index: 999;
        }
        .scroll-top.visible { opacity: 1; visibility: visible; }

        @media (max-width: 1024px) {
            .hero-split-container { flex-direction: column; }
            .footer-content { grid-template-columns: 1fr 1fr; }
            .values-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 0 30px; }
            .nav-links { display: none; }
            .mobile-menu-btn { display: flex; }
            .footer-content { grid-template-columns: 1fr; }
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
            <input type="text" placeholder="Cari produk..." id="searchInput">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Navbar (Same as Beranda) -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <img src="gambarabout/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="#about" class="active">About Us</a></li>
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
            <div class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- MODERN HERO SECTION (Bread Tale Style - Kept) -->
    <section class="about-hero-modern" id="about">
        <div class="hero-header-text">
            <h1 class="modern-title">ABOUT US</h1>
            <p class="modern-subtitle">Caymira Modest adalah manifestasi dari keanggunan wanita muslimah modern. Kami merancang setiap helai pakaian dengan filosofi bahwa kecantikan sejati terpancar dari kesederhanaan yang berkualitas.</p>
        </div>

        <div class="hero-banner-strip">
            <img src="gambarabout/display gamis.png" class="strip-img">
            <img src="gambarabout/display hijab.png" class="strip-img">
            <img src="gambarabout/display koko.png" class="strip-img"> 
        </div>

        <div class="hero-split-container">
            <div class="split-image-wrapper">
                <img src="gambarabout/gambar baju.png" alt="Caymira Showcase" onerror="this.src='https://images.unsplash.com/photo-1552874869-5c39ec9288dc?w=600&h=800&fit=crop'">
            </div>
            
            <div class="split-info-card">
                <div class="glow-dot"></div>
                <h2 class="card-title">Classic Elegance <br>For Modern Women</h2>
                <p class="card-desc">Berdiri sejak tahun 2020, Caymira Modest lahir dari visi untuk mendefinisikan ulang fashion muslimah. Kami percaya bahwa setiap detail—mulai dari pemilihan bahan silk premium hingga presisi jahitan—adalah bentuk dedikasi kami untuk Anda.</p>
                
                <div class="attributes-list">
                    <div class="attr-row"><span class="attr-label">Quality Standard</span><span class="attr-value">Premium Export Quality</span></div>
                    <div class="attr-row"><span class="attr-label">Handmade Process</span><span class="attr-value">100% Crafted by Local Artisans</span></div>
                    <div class="attr-row"><span class="attr-label">Shipment Area</span><span class="attr-value">Worldwide Shipping Available</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Banner (Synchronized) -->
    <section class="stats-banner">
        <div class="stat-item"><span class="stat-number" data-target="5000">0</span><div class="stat-label">Happy Customers</div></div>
        <div class="stat-item"><span class="stat-number" data-target="150">0</span><div class="stat-label">Products</div></div>
        <div class="stat-item"><span class="stat-number" data-target="25">0</span><div class="stat-label">Cities</div></div>
    </section>

    <!-- Content Narrative -->
    <section class="content-section">
        <div class="content-text">
            <p>Kami percaya bahwa berpakaian sesuai syariat bukan berarti membatasi gaya, melainkan menghadirkan <span class="gold-text" onclick="showToast('✨ Keanggunan dalam kesederhanaan')">keanggunan</span> yang memancarkan percaya diri.</p>
            <p>Setiap produk Caymira Modest dibuat dengan bahan pilihan <span class="gold-text" onclick="showToast('🌟 Kualitas premium terjamin')">berkualitas</span>, desain yang timeless, dan detail yang nyaman digunakan sepanjang hari.</p>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <h2 class="values-title">Our Values</h2>
        <div class="values-grid">
            <div class="value-card"><div class="value-icon">✦</div><h3 class="value-title" style="color:var(--gold); margin-bottom:15px;">Modesty</h3><p style="color:var(--text-muted); font-size:14px;">Menjaga nilai syar'i dengan sentuhan modernitas.</p></div>
            <div class="value-card"><div class="value-icon">✹</div><h3 class="value-title" style="color:var(--gold); margin-bottom:15px;">Quality</h3><p style="color:var(--text-muted); font-size:14px;">Hanya menggunakan material terbaik di kelasnya.</p></div>
            <div class="value-card"><div class="value-icon">❈</div><h3 class="value-title" style="color:var(--gold); margin-bottom:15px;">Design</h3><p style="color:var(--text-muted); font-size:14px;">Rancangan eksklusif yang tidak lekang oleh waktu.</p></div>
        </div>
    </section>

    <!-- Footer (Same as Beranda) -->
    <footer class="footer" id="contact">
        <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4"/>
            <circle cx="100" cy="30" r="2" fill="#c9a84c" opacity="0.6"/><circle cx="110" cy="70" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="90" cy="110" r="2" fill="#c9a84c" opacity="0.7"/><circle cx="105" cy="150" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="95" cy="190" r="2" fill="#c9a84c" opacity="0.6"/><circle cx="115" cy="230" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="85" cy="270" r="2" fill="#c9a84c" opacity="0.7"/>
        </svg>

        <div class="footer-content">
            <div class="footer-brand">
                <img src="gambarabout/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height:50px;">
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
                    <li><a href="#about">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')"><i class="far fa-clock"></i><div><div>Monday - Saturday</div><div>10.00 - 17.00 WIB</div></div></div>
                <div class="contact-item" onclick="showToast('📞 Hubungi: 0895-7042-D0408')"><i class="fas fa-phone"></i><div>0895-7042-D0408</div></div>
                <div class="contact-item" onclick="showToast('📧 Email: caymiramodest@gmail.com')"><i class="far fa-envelope"></i><div>caymiramodest@gmail.com</div></div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Newsletter</h4>
                <p class="newsletter-text">Dapatkan info terbaru & promo menarik.</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); showToast('✅ Terima kasih telah berlangganan!');">
                    <input type="email" placeholder="Your email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastText"></span></div>

    <script>
        // CURSOR LOGIC
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px';
            cursorDot.style.top = e.clientY - 3 + 'px';
        });

        // NAVBAR SCROLL EFFECT
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

        // SEARCH OVERLAY
        function toggleSearch() { document.getElementById('searchOverlay').classList.toggle('active'); }

        // TOAST
        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastText').textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        // STATS COUNTER logic
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numbers = entry.target.querySelectorAll('.stat-number');
                    numbers.forEach(num => {
                        const target = +num.getAttribute('data-target');
                        let count = 0;
                        const timer = setInterval(() => {
                            count += Math.ceil(target / 50);
                            if (count >= target) { num.textContent = target.toLocaleString(); clearInterval(timer); }
                            else num.textContent = Math.floor(count).toLocaleString();
                        }, 30);
                    });
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.stat-item').forEach(item => statsObserver.observe(item));

        // CONTENT REVEAL
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.content-text p').forEach(p => revealObserver.observe(p));

        // CART BADGE
        function updateCartBadge() {
            const cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            const badge = document.getElementById('cartBadge');
            const total = cart.reduce((t, item) => t + item.quantity, 0);
            if(total > 0) { badge.textContent = total; badge.style.display = 'flex'; }
            else { badge.style.display = 'none'; }
        }
        document.addEventListener("DOMContentLoaded", updateCartBadge);

        // PARTICLES
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 25; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDelay = Math.random() * 10 + 's';
                container.appendChild(p);
            }
        }
        createParticles();

        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('active');
        }
    </script>
</body>
</html>
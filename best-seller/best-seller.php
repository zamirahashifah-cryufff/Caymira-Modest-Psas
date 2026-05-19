<?php
include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM best_seller");

if(!$query){
   die("Error: ".mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Seller - Caymira Modest</title>

    <!-- Fonts (Disamakan dengan halaman Contact) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === VARIABLES (Disamakan dengan Contact) === */
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
        ul { list-style: none; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

        /* === CUSTOM CURSOR (Dari Contact) === */
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

        /* === LOADING SCREEN (Dari Contact) === */
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
        .loader.hidden { opacity: 0; visibility: hidden; }
        .loader-text {
            font-family: var(--font-heading);
            font-size: 42px;
            color: var(--gold);
            animation: loaderPulse 1.5s ease-in-out infinite;
        }
        .loader-bar {
            width: 200px; height: 2px;
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

        /* === NAVBAR IDENTIK DENGAN CONTACT === */
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        .logo-img {
            height: 75px;
            width: auto;
            object-fit: contain;
            transition: all 0.3s;
            margin-top: 5px;
            position: relative;
            z-index: 1001;
            cursor: pointer;
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
            content: "";
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s;
        }
        .nav-links a:hover,
        .nav-links a.active {
            color: var(--gold);
        }
        .nav-links a:hover::after,
        .nav-links a.active::after {
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
            top: -8px;
            right: -8px;
            background: var(--gold);
            color: var(--navy);
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        
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
            width: 24px; height: 2px;
            background: var(--gold);
            transition: all 0.3s;
            border-radius: 2px;
        }
        .mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
        .mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

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
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input {
            width: 100%;
            padding: 20px 60px 20px 0;
            background: transparent;
            border: none;
            border-bottom: 2px solid var(--gold);
            color: var(--gold);
            font-size: 32px;
            font-family: var(--font-heading);
            outline: none;
        }
        .search-box input::placeholder { color: rgba(201, 168, 76, 0.4); }
        .search-close {
            position: absolute; right: 0; top: 50%;
            transform: translateY(-50%);
            color: var(--gold); font-size: 28px;
            cursor: pointer; transition: transform 0.3s;
        }
        .search-close:hover { transform: translateY(-50%) rotate(90deg); }

        /* =========================================
           === HEADER BEST SELLER ===
           ========================================= */
        .header-section {
            text-align: center;
            padding: 120px 20px 30px; 
            margin-top: 20px;
        }
        .header-title {
            font-family: var(--font-heading);
            font-size: 48px;
            letter-spacing: 8px;
            font-weight: 400;
            color: var(--text-light);
            margin-bottom: 10px;
        }
        .header-star {
            color: var(--gold);
            font-size: 14px;
            margin-bottom: 15px;
        }
        .header-desc {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.8;
        }

        /* === FEATURES BANNER === */
        .features-banner {
            max-width: 1000px;
            margin: 0 auto 50px;
            border: 1px solid rgba(201, 168, 76, 0.5); /* Mengikuti var(--gold) */
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            padding: 15px 30px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            border-right: 1px solid rgba(201, 168, 76, 0.3);
            padding-right: 30px;
        }
        .feature-item:last-child { border-right: none; padding-right: 0; }
        .feature-item i { font-size: 30px; color: var(--gold); }
        .feature-text h4 {
            font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .feature-text p { font-size: 10px; color: var(--text-muted); }

        /* === MAIN LAYOUT (SIDEBAR & GRID) === */
        .main-container {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 80px;
        }

        /* === SIDEBAR KATEGORI === */
        .sidebar {
            background-color: var(--navy-lighter);
            border: 1px solid rgba(201, 168, 76, 0.4);
            border-radius: 8px;
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        .sidebar-title {
            color: var(--gold);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar-title::after {
            content: ''; width: 30px; height: 1px; background-color: var(--gold);
        }
        .category-list { display: flex; flex-direction: column; gap: 15px; }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex; align-items: center; gap: 12px;
            cursor: pointer; font-size: 13px; color: var(--text-light);
            user-select: none;
        }
        .checkbox-container input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .checkmark {
            height: 18px; width: 18px;
            background-color: transparent; border: 1px solid var(--gold);
            border-radius: 3px; position: relative;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s;
        }
        .checkbox-container:hover .checkmark { background-color: rgba(201, 168, 76, 0.1); }
        .checkbox-container input:checked ~ .checkmark { background-color: var(--gold); }
        .checkmark:after {
            content: "\f00c"; font-family: "Font Awesome 6 Free";
            font-weight: 900; color: var(--navy); font-size: 12px; display: none;
        }
        .checkbox-container input:checked ~ .checkmark:after { display: block; }
        .checkbox-container input:checked ~ span { color: var(--gold); font-weight: 500; }

        /* === PRODUCT GRID === */
        .product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

        .product-card {
            background-color: var(--navy-lighter);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 8px; overflow: hidden;
            position: relative; transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            border-color: rgba(201, 168, 76, 0.5);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }

        .product-img-wrap { position: relative; aspect-ratio: 3/4; overflow: hidden; background-color: #f5f5f5; }
        .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .product-card:hover .product-img-wrap img { transform: scale(1.05); }

        .badge-bestseller {
            position: absolute; top: 10px; left: 0;
            background-color: var(--gold); color: var(--navy);
            font-size: 10px; font-weight: 700; padding: 5px 10px;
            border-radius: 0 4px 4px 0; letter-spacing: 1px; z-index: 2;
        }

        /* === TOMBOL ADD TO CART (TAMPIL SAAT HOVER) === */
        .action-overlay {
           position: absolute; 
           bottom: -50px; 
           left: 0; 
           width: 100%; 
           height: 100%;
           background: linear-gradient(to top, rgba(10,22,40,0.9), transparent);
           display: flex; 
           align-items: flex-end; 
           justify-content: center;
           padding-bottom: 20px; 
           opacity: 0; 
           transition: all 0.4s ease;
           z-index: 3;
        }

        .product-card:hover .action-overlay { 
           bottom: 0; 
           opacity: 1; 
        }

        .btn-action {
          background: var(--gold); 
          color: var(--navy); 
          border: none;
          padding: 10px 20px; 
          border-radius: 20px; 
          font-size: 12px; 
          font-weight: 600;
          display: flex; 
          align-items: center; 
          gap: 8px; 
          cursor: pointer; 
          transition: 0.3s;
        }

        .btn-action:hover { 
           background: var(--white); 
           transform: scale(1.05); 
        }

        .product-info { padding: 15px; }
        .product-name {
            font-size: 13px; font-weight: 400; color: var(--text-light);
            margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .product-price { font-size: 12px; color: var(--gold); font-weight: 500; margin-bottom: 8px; }
        .product-rating { display: flex; align-items: center; gap: 5px; font-size: 10px; }
        .stars { color: var(--gold); }
        .reviews { color: var(--text-muted); }

        /* === FOOTER IDENTIK DENGAN CONTACT === */
        .footer {
            background: #ffffff;
            border-top: 1px solid rgba(201, 168, 76, 0.15);
            padding: 50px 60px 30px;
            position: relative;
            margin-top: 50px;
        }
        .gold-branch-footer {
            position: absolute;
            left: -30px; top: -70px; width: 200px;
            opacity: 0.5; pointer-events: none;
        }
        .footer-content {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr;
            gap: 35px; max-width: 1300px; margin: 0 auto;
        }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a {
            width: 36px; height: 36px;
            border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); text-decoration: none; transition: all 0.3s; font-size: 14px; position: relative; overflow: hidden;
        }
        .social-links a::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--gold); transform: scale(0); transition: transform 0.3s; border-radius: 50%;
        }
        .social-links a:hover::before { transform: scale(1); }
        .social-links a:hover { color: var(--navy); transform: translateY(-3px); }
        .social-links a i { position: relative; z-index: 1; }
        
        .footer-title {
            color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; position: relative; display: inline-block;
        }
        .footer-title::after {
            content: ""; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px; background: var(--gold); transition: width 0.3s;
        }
        .footer-col:hover .footer-title::after { width: 100%; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #888; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; }
        .footer-links a::before { content: "→"; color: var(--gold); opacity: 0; transform: translateX(-10px); transition: all 0.3s; }
        .footer-links a:hover { color: var(--gold); transform: translateX(4px); }
        .footer-links a:hover::before { opacity: 1; transform: translateX(0); }
        
        .footer-contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px; color: #888; font-size: 13px; cursor: pointer; transition: all 0.3s; }
        .footer-contact-item:hover { color: var(--gold); transform: translateX(5px); }
        .footer-contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; transition: transform 0.3s; }
        .footer-contact-item:hover i { transform: scale(1.2); }
        
        .newsletter-text { font-size: 12px; color: #888; line-height: 1.6; margin-bottom: 18px; }
        .newsletter-form { display: flex; border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 4px; overflow: hidden; transition: all 0.3s; }
        .newsletter-form:focus-within { border-color: var(--gold); box-shadow: 0 0 20px rgba(201, 168, 76, 0.2); }
        .newsletter-form input { flex: 1; background: transparent; border: none; padding: 12px 14px; color: #333; font-size: 13px; outline: none; }
        .newsletter-form button { background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: all 0.3s; }
        .newsletter-form button:hover { background: var(--gold-light); }
        
        .footer-bottom {
            text-align: center; padding-top: 35px; margin-top: 35px;
            border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px;
            color: #ffffff; background-color: #000000; padding-bottom: 35px;
            margin-left: -60px; margin-right: -60px;
        }

        /* === SCROLL TO TOP === */
        .scroll-top {
            position: fixed; bottom: 25px; right: 25px; width: 45px; height: 45px;
            background: var(--gold); color: var(--navy); border: none; border-radius: 50%;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999; box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4); font-size: 16px;
        }
        .scroll-top.visible { opacity: 1; visibility: visible; }
        .scroll-top:hover { transform: translateY(-5px) scale(1.1); box-shadow: 0 8px 25px rgba(201, 168, 76, 0.5); }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--gold);
            color: var(--navy);
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            transition: all 0.4s ease;
            z-index: 9999;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* Responsive Layout Grid */
        @media (max-width: 1024px) {
            .main-container { grid-template-columns: 1fr; }
            .sidebar { position: static; margin-bottom: 30px; }
            .features-banner { flex-wrap: wrap; gap: 20px; justify-content: center; }
            .feature-item { border-right: none; padding-right: 0; width: 45%; }
            .footer-content { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 0 30px; }
            .nav-links {
                position: fixed; top: 0; right: -100%; width: 75%; height: 100vh;
                background: var(--navy); flex-direction: column; padding: 100px 40px;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1); border-left: 1px solid rgba(201, 168, 76, 0.2); gap: 30px;
            }
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
            
            .product-grid { grid-template-columns: repeat(2, 1fr); }
            .feature-item { width: 100%; justify-content: center; }
            .header-title { font-size: 32px; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .footer-bottom { margin-left: -30px; margin-right: -30px; }
            .custom-cursor, .cursor-dot { display: none; }
        }
        @media (max-width: 480px) {
            .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Loading Screen -->
    <div class="loader" id="loader">
      <div class="loader-text">caymira</div>
      <div class="loader-bar">
        <div class="loader-progress"></div>
      </div>
    </div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari produk..." id="searchInput" />
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
      <i class="fas fa-check-circle" id="toastIcon" style="margin-right: 5px;"></i>
      <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
      <div class="logo" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
        <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" />
      </div>

      <ul class="nav-links" id="navLinks">
        <li><a href="../Beranda/beranda.php">Beranda</a></li>
        <li><a href="../About-us/aboutus.php">About Us</a></li>
        <li><a href="../best-seller/best-seller.php" class="active">Best Seller</a></li>
        <li><a href="../contact/contact.php">Contact</a></li>
      </ul>

      <div class="nav-icons">
        <i class="fas fa-search" onclick="toggleSearch()"></i>

        <a href="../login_register/profil.php" style="color: inherit">
          <i class="fas fa-user"></i>
        </a>

          <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>

            <div class="cart-icon">

        <!-- Cart Icon Diperbarui -->

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


    <!-- HEADER -->
    <section class="header-section">
        <h1 class="header-title">BEST SELLER</h1>
        <div class="header-star"><i class="fas fa-star"></i></div>
        <p class="header-desc">
            Produk favorit pilihan pelanggan Caymira Modest.<br>
            Kualitas terbaik, desain timeless, dan selalu jadi pilihan utama
        </p>
    </section>

    <!-- FEATURES BANNER -->
    <div class="features-banner">
        <div class="feature-item">
            <i class="fas fa-award"></i>
            <div class="feature-text">
                <h4>Premium Quality</h4>
                <p>Bahan Terbaik & Nyaman</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="far fa-gem"></i>
            <div class="feature-text">
                <h4>Timeless Design</h4>
                <p>Elegan dalam setiap design</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="far fa-star"></i>
            <div class="feature-text">
                <h4>Customer Favorite</h4>
                <p>Pilihan terbaik para pelanggan</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="fas fa-truck-fast"></i>
            <div class="feature-text">
                <h4>Fast Delivery</h4>
                <p>Pengiriman cepat & aman</p>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-container">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-title">KATEGORI</div>
            <div class="category-list">
                <label class="checkbox-container">
                    <input type="checkbox" class="cat-filter" value="all" checked>
                    <div class="checkmark"></div>
                    <span>All Product</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" class="cat-filter" value="gamis">
                    <div class="checkmark"></div>
                    <span>Baju Gamis</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" class="cat-filter" value="koko">
                    <div class="checkmark"></div>
                    <span>Baju Koko</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" class="cat-filter" value="hijab">
                    <div class="checkmark"></div>
                    <span>Hijab</span>
                </label>
                <!-- TAMBAHAN KATEGORI JUBAH -->
                <label class="checkbox-container">
                    <input type="checkbox" class="cat-filter" value="jubah">
                    <div class="checkmark"></div>
                    <span>Jubah</span>
                </label>
            </div>
        </aside>


        <!-- PRODUCT GRID -->
        <div class="product-grid" id="productGrid">

         <?php while($data = mysqli_fetch_assoc($query)) { ?>

            <div class="product-card" data-category="<?= $data['kategori'] ?>">

             <div class="product-img-wrap">
                 <div class="badge-bestseller">
                 BEST SELLER
                 </div>

                 <img src="<?= $data['gambar'] ?>" alt="<?= $data['nama_produk'] ?>">
                 
                 <!-- ACTION OVERLAY: Tombol Tambah ke Keranjang -->
                 <div class="action-overlay">
                    <button class="btn-action" onclick="addToCart('<?= isset($data['id']) ? $data['id'] : rand(100,999) ?>', '<?= htmlspecialchars($data['nama_produk'], ENT_QUOTES) ?>', <?= $data['harga'] ?>, '<?= $data['gambar'] ?>'); event.stopPropagation();">
                       <i class="fas fa-cart-plus"></i> Tambah
                    </button>
                 </div>
            </div>

            <div class="product-info">

              <div class="product-name">
              <?= $data['nama_produk'] ?>
            </div>

            <div class="product-price">
              Rp. <?= number_format($data['harga'],0,',','.') ?>
            </div>

            <div class="product-rating">
              <span class="stars">
                 <i class="fas fa-star"></i>
                 <i class="fas fa-star"></i>
                 <i class="fas fa-star"></i>
                 <i class="fas fa-star"></i>
                 <i class="fas fa-star"></i>
                </span>

              <span class="reviews">
                (<?= isset($data['ulasan']) ? $data['ulasan'] : 0 ?>)
              </span>
            </div>

        </div>

    </div>

  <?php } ?>

</div> 
           
        </div> <!-- END OF PRODUCT GRID -->
    </div> <!-- END OF MAIN CONTAINER -->


    <!-- Footer (Identik dengan Contact) -->
    <footer class="footer" id="contact">
      <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
        <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4" />
        <circle cx="100" cy="30" r="2" fill="#c9a84c" opacity="0.6" />
        <circle cx="110" cy="70" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="90" cy="110" r="2" fill="#c9a84c" opacity="0.7" />
        <circle cx="105" cy="150" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="95" cy="190" r="2" fill="#c9a84c" opacity="0.6" />
        <circle cx="115" cy="230" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="85" cy="270" r="2" fill="#c9a84c" opacity="0.7" />
      </svg>

      <div class="footer-content">
        <div class="footer-brand">
          <div class="logo" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" />
          </div>

          <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
          <div class="social-links">
            <a href="#" onclick="showToast('📸 Instagram: @caymiramodest', true)"><i class="fab fa-instagram"></i></a>
            <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-D0408', true)"><i class="fab fa-whatsapp"></i></a>
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
          <div class="footer-contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu', true)">
            <i class="far fa-clock"></i>
            <div><div>Monday - Saturday</div><div>10.00 - 17.00 WIB</div></div>
          </div>
          <div class="footer-contact-item" onclick="showToast('📞 Hubungi: 0895-7042-D0408', true)">
            <i class="fas fa-phone"></i>
            <div>0895-7042-D0408</div>
          </div>
          <div class="footer-contact-item" onclick="showToast('📧 Email: caymiramodest@gmail.com', true)">
            <i class="far fa-envelope"></i>
            <div>caymiramodest@gmail.com</div>
          </div>
        </div>

        <div class="footer-col">
          <h4 class="footer-title">Newsletter</h4>
          <p class="newsletter-text">Dapatkan info terbaru & promo menarik dari Caymira Modest.</p>
          <form class="newsletter-form" onsubmit="handleSubscribe(event)">
            <input type="email" placeholder="Your email" required id="emailInput" />
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
        // === LOADING SCREEN ===
        window.addEventListener("load", () => {
            setTimeout(() => {
                document.getElementById("loader").classList.add("hidden");
            }, 1500);
        });

        // === CUSTOM CURSOR ===
        const cursor = document.getElementById("cursor");
        const cursorDot = document.getElementById("cursorDot");

        document.addEventListener("mousemove", (e) => {
            cursor.style.left = e.clientX - 10 + "px";
            cursor.style.top = e.clientY - 10 + "px";
            cursorDot.style.left = e.clientX - 3 + "px";
            cursorDot.style.top = e.clientY - 3 + "px";
        });

        document.querySelectorAll("a, button, i, .product-card").forEach((el) => {
            el.addEventListener("mouseenter", () => cursor.classList.add("hover"));
            el.addEventListener("mouseleave", () => cursor.classList.remove("hover"));
        });

        // === NAVBAR JS LOGIC ===
        window.addEventListener("scroll", () => {
            const navbar = document.getElementById("navbar");
            const scrollTop = document.getElementById("scrollTop");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
                scrollTop.classList.add("visible");
            } else {
                navbar.classList.remove("scrolled");
                scrollTop.classList.remove("visible");
            }
        });

        function toggleMobileMenu() {
            const navLinks = document.getElementById("navLinks");
            const menuBtn = document.getElementById("mobileMenuBtn");
            navLinks.classList.toggle("active");
            menuBtn.classList.toggle("active");
        }

        document.querySelectorAll(".nav-links a").forEach((link) => {
            link.addEventListener("click", () => {
                document.getElementById("navLinks").classList.remove("active");
                document.getElementById("mobileMenuBtn").classList.remove("active");
            });
        });

        function toggleSearch() {
            const overlay = document.getElementById("searchOverlay");
            overlay.classList.toggle("active");
            if (overlay.classList.contains("active")) {
                setTimeout(() => document.getElementById("searchInput").focus(), 400);
            }
        }

        document.getElementById("searchOverlay").addEventListener("click", (e) => {
            if (e.target === e.currentTarget) toggleSearch();
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                document.getElementById("searchOverlay").classList.remove("active");
            }
            if (e.key === "/" && !e.target.matches("input") && !e.target.matches("textarea")) {
                e.preventDefault();
                toggleSearch();
            }
        });

        // === SCROLL TO TOP ===
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }

        // === NEWSLETTER ===
        function handleSubscribe(e) {
            e.preventDefault();
            const email = document.getElementById("emailInput").value;
            if (email) {
                showToast("✅ Terima kasih telah berlangganan newsletter Caymira!", true);
                document.getElementById("emailInput").value = "";
            }
        }

        // === FITUR FILTER KATEGORI ===
        const checkboxes = document.querySelectorAll('.cat-filter');
        const products = document.querySelectorAll('.product-card');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                } else {
                    document.querySelector('.cat-filter[value="all"]').checked = true;
                }

                let selectedCategory = "all";
                checkboxes.forEach(cb => {
                    if(cb.checked) selectedCategory = cb.value;
                });

                products.forEach(product => {
                    if (selectedCategory === 'all' || product.getAttribute('data-category') === selectedCategory) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });

        // Fungsi Toast Dinamis
        function showToast(message, useIcon = false) {
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toastText');
            const toastIcon = document.getElementById('toastIcon');

            toastText.innerText = message;
            
            // Menyembunyikan icon centang bawaan untuk emoticon love dll
            if(useIcon) {
                toastIcon.style.display = 'inline-block';
            } else {
                toastIcon.style.display = 'none';
            }

            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
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
                // Sembunyikan badge jika keranjang kosong
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
            
            showToast('🛒 ' + name + ' berhasil ditambahkan!', false);
        }

        // Panggil fungsi ketika halaman selesai dimuat agar jumlah badge update di awal
        document.addEventListener("DOMContentLoaded", function () {
            updateCartBadge();
        });
    </script>
</body>
</html>
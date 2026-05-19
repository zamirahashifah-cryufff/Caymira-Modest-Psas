<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
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
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--navy);
            color: var(--text-light);
            overflow-x: hidden;
        }

        .custom-cursor { width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transition: transform 0.1s, background 0.3s; mix-blend-mode: difference; }
        .custom-cursor.hover { transform: scale(2); background: rgba(201, 168, 76, 0.2); }
        .cursor-dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; }
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; overflow: hidden; }
        .particle { position: absolute; width: 3px; height: 3px; background: var(--gold); border-radius: 50%; opacity: 0; animation: float 12s infinite; }
        @keyframes float { 0% { transform: translateY(100vh) rotate(0deg); opacity: 0; } 10% { opacity: 0.4; } 90% { opacity: 0.4; } 100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; } }
        .navbar { position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(201, 168, 76, 0.6); transition: all 0.3s ease; overflow: visible; }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .logo-img { height: 75px; width: auto; object-fit: contain; transition: all 0.3s; margin-top: 5px; position: relative; z-index: 1001; cursor: pointer; }
        .logo:hover .logo-img { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.5)); }
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { color: var(--text-light); text-decoration: none; font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; position: relative; padding: 5px 0; transition: color 0.3s; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; transition: all 0.3s; position: relative; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }
        .search-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10, 22, 40, 0.98); z-index: 9999; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.4s; }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input { width: 100%; padding: 20px 60px 20px 0; background: transparent; border: none; border-bottom: 2px solid var(--gold); color: var(--gold); font-size: 32px; font-family: 'Playfair Display', serif; outline: none; }
        .search-box input::placeholder { color: rgba(201, 168, 76, 0.4); }
        .search-close { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 28px; cursor: pointer; transition: transform 0.3s; }
        .search-close:hover { transform: translateY(-50%) rotate(90deg); }
        
        .newsletter-banner { padding: 80px 60px; background: linear-gradient(135deg, var(--navy-light), var(--navy-lighter)); position: relative; overflow: hidden; text-align: center; }
        .newsletter-banner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
        .newsletter-banner::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
        .newsletter-content { max-width: 600px; margin: 0 auto; position: relative; z-index: 2; }
        .newsletter-icon { font-size: 48px; color: var(--gold); margin-bottom: 20px; animation: floatIcon 3s ease-in-out infinite; }
        @keyframes floatIcon { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .newsletter-title { font-family: 'Playfair Display', serif; font-size: 32px; color: var(--gold); margin-bottom: 15px; }
        .newsletter-desc { font-size: 14px; color: var(--text-muted); line-height: 1.8; margin-bottom: 30px; }
        .newsletter-form-banner { display: flex; max-width: 450px; margin: 0 auto; border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 50px; overflow: hidden; transition: all 0.3s; }
        .newsletter-form-banner:focus-within { border-color: var(--gold); box-shadow: 0 0 30px rgba(201, 168, 76, 0.2); }
        .newsletter-form-banner input { flex: 1; background: transparent; border: none; padding: 16px 24px; color: var(--text-light); font-size: 14px; outline: none; }
        .newsletter-form-banner input::placeholder { color: var(--text-muted); }
        .newsletter-form-banner button { background: var(--gold); border: none; padding: 0 28px; color: var(--navy); cursor: pointer; transition: all 0.3s; font-size: 16px; }
        .newsletter-form-banner button:hover { background: var(--gold-light); }

        .footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; position: relative; }
        .gold-branch-footer { position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: var(--text-muted); max-width: 230px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a { width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); text-decoration: none; transition: all 0.3s; font-size: 14px; position: relative; overflow: hidden; }
        .social-links a::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--gold); transform: scale(0); transition: transform 0.3s; border-radius: 50%; }
        .social-links a:hover::before { transform: scale(1); }
        .social-links a:hover { color: var(--navy); transform: translateY(-3px); }
        .social-links a i { position: relative; z-index: 1; }
        .footer-title { color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; position: relative; display: inline-block; }
        .footer-title::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px; background: var(--gold); transition: width 0.3s; }
        .footer-col:hover .footer-title::after { width: 100%; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: var(--text-muted); text-decoration: none; font-size: 13px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .footer-links a::before { content: '→'; color: var(--gold); opacity: 0; transform: translateX(-10px); transition: all 0.3s; }
        .footer-links a:hover { color: var(--gold); transform: translateX(4px); }
        .footer-links a:hover::before { opacity: 1; transform: translateX(0); }
        .contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px; color: var(--text-muted); font-size: 13px; transition: all 0.3s; cursor: pointer; }
        .contact-item:hover { color: var(--gold); transform: translateX(5px); }
        .contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; transition: transform 0.3s; }
        .contact-item:hover i { transform: scale(1.2); }
        .newsletter-text { font-size: 12px; color: var(--text-muted); line-height: 1.6; margin-bottom: 18px; }
        .newsletter-form { display: flex; border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 4px; overflow: hidden; transition: all 0.3s; position: relative; }
        .newsletter-form:focus-within { border-color: var(--gold); box-shadow: 0 0 20px rgba(201, 168, 76, 0.2); }
        .newsletter-form input { flex: 1; background: transparent; border: none; padding: 12px 14px; color: #333; font-size: 13px; outline: none; }
        .newsletter-form button { background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: all 0.3s; }
        .newsletter-form button:hover { background: var(--gold-light); }
        .footer-bottom { text-align: center; padding-top: 35px; margin-top: 35px; border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px; color: #ffffff; background-color: #000000; padding-bottom: 35px; margin-left: -60px; margin-right: -60px; }

        .toast { position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%) translateY(100px); background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px; font-weight: 500; font-size: 14px; opacity: 0; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 10000; box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4); display: flex; align-items: center; gap: 10px; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        
        .mobile-menu-btn { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; padding: 5px; }
        .mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: all 0.3s; border-radius: 2px; }
        .mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
        .mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }


        .cart-page-header { margin-top: 120px; text-align: center; margin-bottom: 50px; }
        .cart-page-header h1 { color: var(--gold); font-size: 32px; font-weight: 600; margin-bottom: 10px; font-family: 'Playfair Display', serif; }
        .cart-page-header p { color: var(--text-light); font-size: 14px; }

        .cart-container { max-width: 1200px; margin: 0 auto 100px; padding: 0 40px; display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start; }

        /* --- Left Column: Products --- */
        .cart-left { background: var(--navy-light); border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 4px; overflow: hidden; }
        .cart-table-header { display: flex; background-color: var(--gold); color: var(--navy); padding: 15px 20px; font-weight: 700; font-size: 16px; }

        .col-product { flex: 2; } .col-price { flex: 1; text-align: center; } .col-qty { flex: 1; text-align: center; } .col-subtotal { flex: 1; text-align: right; }

        .cart-items-list { display: flex; flex-direction: column; }
        .cart-item { display: flex; align-items: center; padding: 20px; border-bottom: 1px solid rgba(201, 168, 76, 0.3); transition: background 0.3s; }
        .cart-item:last-child { border-bottom: none; }
        .cart-item:hover { background: rgba(201, 168, 76, 0.05); }

        .item-product { flex: 2; display: flex; align-items: center; gap: 15px; }
        .item-img-box { width: 80px; height: 100px; background: var(--navy-lighter); border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 4px; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        .item-img-box img { max-width: 100%; max-height: 100%; object-fit: cover; }
        .item-info { display: flex; flex-direction: column; }
        .item-brand { font-size: 10px; border: 1px solid var(--text-light); padding: 2px 8px; border-radius: 12px; width: fit-content; margin-bottom: 5px; }
        .item-name { font-size: 16px; font-weight: 600; color: var(--white); margin-bottom: 5px; }
        .remove-btn { color: #e74c3c; font-size: 12px; cursor: pointer; text-decoration: underline; background: none; border: none; text-align: left; padding: 0; margin-top: 5px; transition: 0.3s;}
        .remove-btn:hover { color: #ff6b5a; }

        .item-price-col { flex: 1; text-align: center; font-size: 15px; }
        .item-price-box { border: 1px solid rgba(201, 168, 76, 0.5); padding: 5px 10px; border-radius: 4px; display: inline-block; }
        .item-subtotal-col { flex: 1; text-align: right; font-size: 15px; color: var(--text-light); }

        .item-qty-col { flex: 1; display: flex; justify-content: center; }
        .qty-box { display: flex; align-items: center; border: 1px solid rgba(201, 168, 76, 0.5); border-radius: 4px; overflow: hidden; }
        .qty-btn { background: transparent; border: none; color: var(--text-light); padding: 5px 12px; cursor: pointer; font-size: 16px; transition: 0.3s; }
        .qty-btn:hover { background: rgba(201, 168, 76, 0.2); color: var(--gold); }
        .qty-val { padding: 0 10px; font-size: 14px; font-weight: 600; }

        .cart-bottom-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; }
        .voucher-box { display: flex; height: 40px; }
        .voucher-box input { background: transparent; border: 1px solid rgba(201, 168, 76, 0.5); color: var(--text-light); padding: 0 15px; border-radius: 4px 0 0 4px; outline: none; width: 150px; }
        .voucher-box button { background: var(--gold); border: none; color: var(--navy); padding: 0 20px; border-radius: 0 4px 4px 0; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .voucher-box button:hover { background: var(--gold-light); }
        .clear-cart-btn { color: var(--text-light); text-decoration: none; font-size: 14px; cursor: pointer; transition: 0.3s; }
        .clear-cart-btn:hover { color: var(--gold); }

        /* --- Right Column: Order Summary --- */
        .cart-right { border: 1px solid rgba(201, 168, 76, 0.5); border-radius: 4px; padding: 25px; background: transparent; }
        .summary-title { color: var(--gold); font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid rgba(201, 168, 76, 0.3); }
        .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid rgba(201, 168, 76, 0.3); font-size: 15px; }
        .summary-row i { margin-right: 10px; color: var(--gold); font-size: 18px;}
        .summary-row .val { font-weight: 600; }
        .summary-total { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 16px; }
        .summary-total i { margin-right: 10px; color: var(--gold); font-size: 18px;}
        .summary-total .val { font-weight: 700; color: var(--white); font-size: 18px;}

        .checkout-btn { width: 100%; background: var(--gold); color: var(--navy); border: none; padding: 15px; border-radius: 4px; font-weight: 600; font-size: 14px; cursor: pointer; transition: 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .checkout-btn:hover { background: var(--gold-light); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(201, 168, 76, 0.2); }

        /* Empty State */
        .empty-state { text-align: center; padding: 60px 20px; grid-column: 1 / -1; }
        .empty-state i { font-size: 60px; color: var(--gold); margin-bottom: 20px; }
        .empty-state h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--white); margin-bottom: 10px; }
        .empty-state a { display: inline-block; margin-top: 20px; padding: 10px 25px; border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; text-decoration: none; transition: 0.3s; }
        .empty-state a:hover { background: var(--gold); color: var(--navy); }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-content { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 15px 30px; }
            .logo-img { height: 30px; }
            .nav-links { position: fixed; top: 0; right: -100%; width: 75%; height: 100vh; background: var(--navy); flex-direction: column; padding: 100px 40px; transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1); border-left: 1px solid rgba(201, 168, 76, 0.2); gap: 30px; }
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
            .cart-container { grid-template-columns: 1fr; padding: 0 20px; }
            .cart-bottom-actions { flex-direction: column; gap: 20px; align-items: stretch; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .gold-branch-footer { display: none; }
            .custom-cursor, .cursor-dot { display: none; }
        }
    </style>
</head>
<body>

    <!-- Toast -->
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
            <input type="text" placeholder="Cari produk..." id="searchInput">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.php'">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearch()"></i>
            <i class="fas fa-user" onclick="showToast('👤 Menuju halaman akun...')"></i>
            <div class="cart-icon" onclick="window.location.href='keranjang.php'" style="cursor: pointer;">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartBadge">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Header Keranjang -->
    <div class="cart-page-header">
        <h1>Shopping Cart</h1>
        <p>Review your selected items before checkout</p>
    </div>

    <!-- Container Utama Keranjang -->
    <div class="cart-container" id="cartContainer">
        <!-- Akan diisi otomatis oleh JavaScript -->
    </div>

    <!-- Newsletter Banner -->
    <section class="newsletter-banner">
        <div class="newsletter-content">
            <div class="newsletter-icon"><i class="fa-regular fa-bell"></i></div>
            <h2 class="newsletter-title">Jangan Lewatkan Update Terbaru</h2>
            <p class="newsletter-desc">Dapatkan info koleksi terbaru, promo eksklusif, dan diskon spesial langsung ke inbox Anda.</p>
            <form class="newsletter-form-banner" onsubmit="event.preventDefault(); showToast('Terima kasih telah berlangganan!');">
                <input type="email" placeholder="Masukkan email Anda..." required>
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
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
                    <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
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
                <form class="newsletter-form" onsubmit="event.preventDefault(); showToast('Terima kasih telah berlangganan!');">
                    <input type="email" placeholder="Your email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            renderCart();
            updateCartBadge();
        });

        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        if (window.innerWidth > 768) {
            document.addEventListener('mousemove', (e) => {
                if (cursor && cursorDot) {
                    cursor.style.left = e.clientX - 10 + 'px';
                    cursor.style.top = e.clientY - 10 + 'px';
                    cursorDot.style.left = e.clientX - 3 + 'px';
                    cursorDot.style.top = e.clientY - 3 + 'px';
                }
            });
        }

        function toggleSearch() { document.getElementById('searchOverlay').classList.toggle('active'); }
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('active');
            document.getElementById('mobileMenuBtn').classList.toggle('active');
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastText').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        let discountAmount = 0;

        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        function getCart() {
            return JSON.parse(localStorage.getItem('caymira_cart')) || [];
        }

        function saveCart(cart) {
            localStorage.setItem('caymira_cart', JSON.stringify(cart));
            updateCartBadge();
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

        function renderCart() {
            const cart = getCart();
            const container = document.getElementById('cartContainer');
            
            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-shopping-basket"></i>
                        <h3>Keranjang Kosong</h3>
                        <p>Ayo pilih koleksi busana muslimah favorit Anda sekarang.</p>
                        <a href="../Gamis/gamis.php">Mulai Belanja</a>
                    </div>
                `;
                container.style.gridTemplateColumns = "1fr";
                return;
            }

            container.style.gridTemplateColumns = "2fr 1fr";
            
            let totalQty = 0;
            let subtotal = 0;
            let itemsHTML = '';

            cart.forEach((item, index) => {
                let itemSubtotal = item.price * item.quantity;
                subtotal += itemSubtotal;
                totalQty += item.quantity;

                let imgPath = item.image;
                if(!imgPath.includes('../')) {
                    imgPath = '../Gamis/' + imgPath;
                }

                itemsHTML += `
                    <div class="cart-item">
                        <div class="item-product">
                            <div class="item-img-box">
                                <img src="${imgPath}" alt="${item.name}" onerror="this.src='https://via.placeholder.com/80x100/152238/c9a84c'">
                            </div>
                            <div class="item-info">
                                <span class="item-brand">Caymira Modest</span>
                                <div class="item-name">${item.name}</div>
                                <button class="remove-btn" onclick="removeItem(${index})"><i class="fas fa-trash"></i> Hapus</button>
                            </div>
                        </div>
                        <div class="item-price-col">
                            <div class="item-price-box">${formatRupiah(item.price)}</div>
                        </div>
                        <div class="item-qty-col">
                            <div class="qty-box">
                                <button class="qty-btn" onclick="changeQty(${index}, -1)">-</button>
                                <span class="qty-val">${item.quantity}</span>
                                <button class="qty-btn" onclick="changeQty(${index}, 1)">+</button>
                            </div>
                        </div>
                        <div class="item-subtotal-col">
                            <div class="item-price-box" style="border:none;">${formatRupiah(itemSubtotal)}</div>
                        </div>
                    </div>
                `;
            });

            let grandTotal = subtotal - discountAmount;
            if(grandTotal < 0) grandTotal = 0;

            const leftCol = `
                <div>
                    <div class="cart-left">
                        <div class="cart-table-header">
                            <span class="col-product">Product</span>
                            <span class="col-price">Price</span>
                            <span class="col-qty">Quantity</span>
                            <span class="col-subtotal">Subtotal</span>
                        </div>
                        <div class="cart-items-list">
                            ${itemsHTML}
                        </div>
                    </div>
                    
                    <div class="cart-bottom-actions">
                        <div class="voucher-box">
                            <input type="text" id="voucherInput" placeholder="Voucher Code">
                            <button onclick="applyVoucher()">Apply Voucher</button>
                        </div>
                        <a onclick="clearCart()" class="clear-cart-btn">Clear Shopping Cart</a>
                    </div>
                </div>
            `;

            const rightCol = `
                <div class="cart-right">
                    <div class="summary-title">Order Summary</div>
                    
                    <div class="summary-row">
                        <span><i class="fas fa-shopping-bag"></i> Items</span>
                        <span class="val">${totalQty}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span><i class="far fa-list-alt"></i> Sub Total</span>
                        <span class="val">${formatRupiah(subtotal)}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span><i class="fas fa-ticket-alt"></i> Voucher Discount</span>
                        <span class="val">${formatRupiah(discountAmount)}</span>
                    </div>
                    
                    <div class="summary-total">
                        <span><i class="fas fa-wallet"></i> Total</span>
                        <span class="val">${formatRupiah(grandTotal)}</span>
                    </div>
                    
                    <button class="checkout-btn" onclick="checkout(${grandTotal})">
                        <i class="fas fa-shopping-bag"></i> Proceed to Checkout <i class="fas fa-caret-right"></i>
                    </button>
                </div>
            `;

            container.innerHTML = leftCol + rightCol;
        }

        function changeQty(index, change) {
            let cart = getCart();
            if (cart[index].quantity + change > 0) {
                cart[index].quantity += change;
                saveCart(cart);
                renderCart();
            } else {
                if(confirm("Hapus produk ini dari keranjang?")) {
                    removeItem(index);
                }
            }
        }

        function removeItem(index) {
            let cart = getCart();
            cart.splice(index, 1);
            saveCart(cart);
            renderCart();
            showToast(" Produk dihapus dari keranjang.");
        }

        function clearCart() {
            if(confirm("Apakah Anda yakin ingin mengosongkan keranjang?")) {
                localStorage.removeItem('caymira_cart');
                discountAmount = 0;
                renderCart();
                updateCartBadge();
                showToast(" Keranjang berhasil dikosongkan.");
            }
        }

        function applyVoucher() {
            const code = document.getElementById('voucherInput').value.trim().toUpperCase();
            if(code === 'DISKON50K') {
                discountAmount = 50000;
                showToast("✅ Voucher berhasil digunakan! Diskon Rp 50.000");
                renderCart();
            } else if (code !== '') {
                showToast("❌ Voucher tidak valid atau kadaluarsa.");
            }
        }

        function checkout(grandTotal) {
            let cart = getCart();
            
            if (cart.length === 0) {
                showToast("❌ Keranjang Anda kosong!");
                return;
            }

            let subtotal = 0;
            cart.forEach(item => {
                subtotal += (item.price * item.quantity);
            });

            let dataCheckout = {
                cart: cart,
                subtotal: subtotal,
                diskon: discountAmount,
                grandTotal: grandTotal
            };

            const btnCheckout = document.querySelector('.checkout-btn');
            const originalText = btnCheckout.innerHTML;
            btnCheckout.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btnCheckout.disabled = true;

            fetch('proses_checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataCheckout)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast("✅ Pesanan berhasil dicatat!");

                    let pesan = "Halo Admin Caymira Modest, saya ingin memesan:\n\n";
                    cart.forEach((item, i) => {
                        pesan += `${i+1}. ${item.name} (x${item.quantity})\n`;
                    });
                    pesan += `\n*Total Belanja: ${formatRupiah(grandTotal)}*`;
                    if (discountAmount > 0) pesan += `\n(Sudah termasuk potongan voucher)`;
                    
                    window.open(`https://wa.me/62895704200408?text=${encodeURIComponent(pesan)}`, '_blank');

                    localStorage.removeItem('caymira_cart');
                    discountAmount = 0;
                    renderCart();
                    updateCartBadge();
                } else {
                    showToast("❌ Gagal: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast("❌ Terjadi kesalahan koneksi ke server.");
            })
            .finally(() => {
                btnCheckout.innerHTML = originalText;
                btnCheckout.disabled = false;
            });
        }
    </script>
</body>
</html>
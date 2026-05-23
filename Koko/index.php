<?php 
include 'koneksi.php'; 
$query = mysqli_query($koneksi, "SELECT * FROM koko");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koko Collection - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* === VARIABEL WARNA & GLOBAL === */
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
            background-color: var(--navy);
            color: var(--text-light);
            font-family: var(--font-body);
            line-height: 1.6;
            overflow-x: hidden;
        }
        a { text-decoration: none; color: inherit; transition: color 0.3s ease; }
        img { max-width: 100%; height: auto; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

        /* === STANDAR UI (CURSOR, LOADER, PARTICLES, TOAST) === */
        .custom-cursor { width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transition: transform 0.1s, background 0.3s; mix-blend-mode: difference; }
        .custom-cursor.hover { transform: scale(2); background: rgba(201, 168, 76, 0.2); }
        .cursor-dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; }
        
        .loader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: var(--navy); display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 99999; transition: opacity 0.6s, visibility 0.6s; }
        .loader.hidden { opacity: 0; visibility: hidden; }
        .loader-text { font-family: var(--font-heading); font-size: 42px; color: var(--gold); animation: loaderPulse 1.5s ease-in-out infinite; }
        .loader-bar { width: 200px; height: 2px; background: rgba(201, 168, 76, 0.2); margin-top: 30px; border-radius: 2px; overflow: hidden; }
        .loader-progress { height: 100%; background: var(--gold); width: 0%; animation: loadProgress 2s ease forwards; }
        @keyframes loaderPulse { 0%, 100% { opacity: 0.4; letter-spacing: 2px; } 50% { opacity: 1; letter-spacing: 8px; } }
        @keyframes loadProgress { 0% { width: 0%; } 100% { width: 100%; } }
        
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; overflow: hidden; }
        .particle { position: absolute; width: 3px; height: 3px; background: var(--gold); border-radius: 50%; opacity: 0; animation: float 12s infinite; }
        @keyframes float { 0% { transform: translateY(100vh) rotate(0deg); opacity: 0; } 10% { opacity: 0.4; } 90% { opacity: 0.4; } 100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; } }
        
        .toast { position: fixed; bottom: 90px; left: 50%; transform: translateX(-50%) translateY(100px); background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px; font-weight: 500; font-size: 14px; opacity: 0; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 10000; box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4); display: flex; align-items: center; gap: 10px; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* === STANDAR NAVBAR & SEARCH === */
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
        .cart-icon { position: relative; display: flex; align-items: center; cursor: pointer;}
        .cart-badge { position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite; }
        
        .search-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10, 22, 40, 0.98); z-index: 9999; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.4s; }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input { width: 100%; padding: 20px 60px 20px 0; background: transparent; border: none; border-bottom: 2px solid var(--gold); color: var(--gold); font-size: 32px; font-family: var(--font-heading); outline: none; }
        .search-box input::placeholder { color: rgba(201, 168, 76, 0.4); }
        .search-close { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 28px; cursor: pointer; transition: transform 0.3s; }
        .search-close:hover { transform: translateY(-50%) rotate(90deg); }
        
        .mobile-menu-btn { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; padding: 5px; }
        .mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: all 0.3s; border-radius: 2px; }
        .mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
        .mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        /* === KOKO HERO SECTION === */
        .koko-hero { position: relative; width: 100%; min-height: 85vh; display: flex; align-items: center; overflow: hidden; margin-top: 70px; background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 50%, var(--navy-lighter) 100%); }
        .koko-hero::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 50%, rgba(201, 168, 76, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(201, 168, 76, 0.05) 0%, transparent 50%); z-index: 1; pointer-events: none; }
        .koko-hero::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a84c' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); z-index: 0; opacity: 0.5; }
        .koko-hero-wrapper { position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; width: 90%; max-width: 1200px; margin: 0 auto; padding: 60px 0; gap: 60px; }
        .koko-hero-text { flex: 1; max-width: 550px; }
        .koko-hero-text .subtitle { font-family: var(--font-heading); font-style: italic; font-weight: 400; font-size: 22px; margin-bottom: 15px; color: var(--gold-light); opacity: 0; transform: translateY(30px); animation: fadeInUp 1s ease 0.3s forwards; }
        .koko-hero-text h1 { font-family: var(--font-heading); font-size: 52px; line-height: 1.15; margin-bottom: 20px; color: var(--white); font-weight: 700; opacity: 0; transform: translateY(30px); animation: fadeInUp 1s ease 0.5s forwards; }
        .koko-hero-text h1 span { display: block; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, var(--gold) 100%); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: shine 3s linear infinite; }
        @keyframes shine { to { background-position: 200% center; } }
        .koko-hero-text .description { color: var(--text-light); font-size: 15px; line-height: 1.9; margin-bottom: 35px; opacity: 0; transform: translateY(30px); animation: fadeInUp 1s ease 0.7s forwards; }
        .koko-hero-text .description span { color: var(--gold); font-weight: 500; }
        .koko-hero-cta { display: inline-flex; align-items: center; gap: 12px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); padding: 16px 36px; border-radius: 30px; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; transition: all 0.4s ease; cursor: pointer; border: none; position: relative; overflow: hidden; opacity: 0; transform: translateY(30px); animation: fadeInUp 1s ease 0.9s forwards; }
        .koko-hero-cta::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.5s; }
        .koko-hero-cta:hover::before { left: 100%; }
        .koko-hero-cta:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4); }
        .koko-hero-cta i { transition: transform 0.3s; }
        .koko-hero-cta:hover i { transform: translateX(5px); }
        .koko-hero-images { flex: 1; display: flex; align-items: center; justify-content: center; gap: 20px; position: relative; }
        .koko-hero-img { width: 220px; height: 380px; object-fit: cover; border-radius: 20px; border: 2px solid rgba(201, 168, 76, 0.3); transition: all 0.5s ease; opacity: 0; transform: translateY(50px); }
        .koko-hero-img:nth-child(1) { animation: fadeInUp 1s ease 0.5s forwards; margin-top: 40px; }
        .koko-hero-img:nth-child(2) { animation: fadeInUp 1s ease 0.7s forwards; margin-bottom: 40px; }
        .koko-hero-img:hover { transform: translateY(-10px) scale(1.03); border-color: var(--gold); box-shadow: 0 20px 40px rgba(201, 168, 76, 0.2); }

        .hero-deco-circle { position: absolute; border: 1px solid rgba(201, 168, 76, 0.15); border-radius: 50%; pointer-events: none; }
        .hero-deco-1 { width: 300px; height: 300px; top: -50px; right: -80px; animation: rotate 25s linear infinite; }
        .hero-deco-2 { width: 180px; height: 180px; bottom: 30px; right: 200px; animation: rotate 20s linear infinite reverse; }
        .hero-deco-3 { width: 100px; height: 100px; top: 50%; left: -50px; animation: rotate 18s linear infinite; }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* === MARQUEE BANNER === */
        .marquee-banner { background: linear-gradient(90deg, var(--navy), var(--navy-light), var(--navy)); padding: 15px 0; overflow: hidden; position: relative; border-top: 1px solid rgba(201, 168, 76, 0.2); border-bottom: 1px solid rgba(201, 168, 76, 0.2); }
        .marquee-content { display: flex; animation: marqueeScroll 20s linear infinite; white-space: nowrap; }
        .marquee-item { display: inline-flex; align-items: center; gap: 15px; padding: 0 40px; color: var(--gold); font-size: 13px; letter-spacing: 2px; text-transform: uppercase; }
        @keyframes marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* === FILTER BAR === */
        .filter-bar { background: rgba(15, 29, 53, 0.95); backdrop-filter: blur(10px); padding: 25px 0; position: sticky; top: 70px; z-index: 100; border-bottom: 1px solid rgba(201, 168, 76, 0.15); }
        .filter-wrapper { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
        .filter-categories { display: flex; gap: 15px; flex-wrap: wrap; }
        .filter-btn { background: transparent; border: 1px solid rgba(201, 168, 76, 0.3); color: var(--text-light); padding: 10px 24px; border-radius: 25px; font-size: 13px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all 0.4s ease; font-family: var(--font-body); }
        .filter-btn:hover, .filter-btn.active { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); border-color: var(--gold); box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3); transform: translateY(-2px); }
        .filter-sort { display: flex; align-items: center; gap: 10px; }
        .filter-sort label { font-size: 13px; color: var(--text-muted); letter-spacing: 1px; }
        .filter-sort select { background: rgba(201, 168, 76, 0.1); border: 1px solid rgba(201, 168, 76, 0.2); color: var(--gold); padding: 10px 20px; border-radius: 25px; font-size: 13px; font-family: var(--font-body); cursor: pointer; outline: none; transition: all 0.3s; }
        .filter-sort select:hover { border-color: var(--gold); }

        /* === KOKO COLLECTION === */
        .koko-collection { padding: 80px 0; position: relative; }
        .koko-collection::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 0% 50%, rgba(201, 168, 76, 0.03) 0%, transparent 50%), radial-gradient(circle at 100% 50%, rgba(201, 168, 76, 0.03) 0%, transparent 50%); pointer-events: none; }
        .section-header { text-align: center; margin-bottom: 60px; position: relative; z-index: 1; }
        .section-header h2 { font-family: var(--font-heading); font-size: 42px; color: var(--gold); margin-bottom: 15px; position: relative; display: inline-block; opacity: 0; transform: translateY(30px); }
        .section-header h2.visible { animation: fadeInUp 0.8s ease forwards; }
        .section-header h2::after { content: ''; position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background: var(--gold); transition: width 0.6s ease; }
        .section-header h2.visible::after { width: 80px; }
        .section-header p { color: var(--text-muted); font-size: 16px; margin-top: 25px; font-style: italic; opacity: 0; transform: translateY(20px); }
        .section-header p.visible { animation: fadeInUp 0.8s ease 0.3s forwards; }

        /* Koko Grid & Card */
        .koko-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; position: relative; z-index: 1; }
        .koko-card { background: rgba(201, 168, 76, 0.03); border: 1px solid rgba(201, 168, 76, 0.1); border-radius: 20px; padding: 20px; position: relative; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; opacity: 0; transform: translateY(50px); cursor: pointer; }
        .koko-card.visible { animation: fadeInUp 0.8s ease forwards; }
        .koko-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(201, 168, 76, 0.08) 0%, transparent 60%); opacity: 0; transition: opacity 0.5s; }
        .koko-card:hover::before { opacity: 1; }
        .koko-card::after { content: ''; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; background: linear-gradient(45deg, var(--gold), transparent, var(--gold-light)); border-radius: 22px; z-index: -1; opacity: 0; transition: opacity 0.5s; }
        .koko-card:hover::after { opacity: 0.3; }
        .koko-card:hover { transform: translateY(-15px) scale(1.02); border-color: rgba(201, 168, 76, 0.3); box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(201, 168, 76, 0.1); }
        
        .koko-badge { position: absolute; top: 30px; left: 30px; z-index: 2; font-size: 10px; font-weight: 700; padding: 6px 14px; border-radius: 20px; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); }
        .koko-badge.new { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); animation: badgePulse 2s ease-in-out infinite; }
        .koko-badge.best { background: linear-gradient(135deg, #e74c3c, #c0392b); color: var(--white); }
        .koko-badge.sale { background: linear-gradient(135deg, #27ae60, #2ecc71); color: var(--white); }
        @keyframes badgePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        .koko-img-wrapper { position: relative; overflow: hidden; border-radius: 14px; margin-bottom: 20px; }
        .koko-img { width: 100%; height: 320px; object-fit: cover; border-radius: 14px; transition: transform 0.6s ease; }
        .koko-card:hover .koko-img { transform: scale(1.08); }
        
        .koko-img-overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 25px 15px 15px; background: linear-gradient(to top, rgba(10, 22, 40, 0.9), transparent); opacity: 0; transition: opacity 0.4s, transform 0.4s; transform: translateY(20px); display: flex; justify-content: center; gap: 10px; }
        .koko-card:hover .koko-img-overlay { opacity: 1; transform: translateY(0); }
        .overlay-btn { background: var(--gold); color: var(--navy); padding: 10px 20px; border-radius: 25px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border: none; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 6px; }
        .overlay-btn:hover { background: var(--gold-light); transform: scale(1.05); }
        .overlay-btn.wishlist { background: rgba(255, 255, 255, 0.15); color: var(--white); width: 40px; height: 40px; padding: 0; border-radius: 50%; justify-content: center; }
        .overlay-btn.wishlist:hover { background: #e74c3c; color: var(--white); }

        .koko-info h3 { font-size: 16px; margin-bottom: 8px; font-weight: 500; color: var(--text-light); transition: color 0.3s; line-height: 1.4; }
        .koko-card:hover .koko-info h3 { color: var(--gold-light); }
        .koko-price { color: var(--gold); font-size: 18px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 10px; }
        .koko-rating { display: flex; align-items: center; gap: 8px; }
        .koko-rating .stars { color: var(--gold); font-size: 12px; }
        .koko-rating .review-count { color: var(--text-muted); font-size: 12px; }
        .koko-colors { display: flex; gap: 6px; margin-top: 12px; }
        .color-dot { width: 16px; height: 16px; border-radius: 50%; border: 2px solid transparent; cursor: pointer; transition: all 0.3s; position: relative; }
        .color-dot:hover, .color-dot.active { border-color: var(--gold); transform: scale(1.2); }
        .color-dot::after { content: ''; position: absolute; top: -4px; left: -4px; width: 24px; height: 24px; border: 1px solid transparent; border-radius: 50%; transition: all 0.3s; }
        .color-dot:hover::after, .color-dot.active::after { border-color: var(--gold); }

        /* === STANDAR FOOTER === */
        .footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; position: relative; margin-top: 50px; }
        .gold-branch-footer { position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: var(--text-muted); max-width: 230px; margin-top: 15px;}
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

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive */
        @media (max-width: 1024px) {
            .koko-grid { grid-template-columns: repeat(3, 1fr); }
            .koko-hero-wrapper { flex-direction: column; text-align: center; }
            .koko-hero-text { max-width: 100%; }
            .koko-hero-images { order: -1; }
            .footer-content { grid-template-columns: 1fr 1fr; }
            .koko-hero h1 { font-size: 42px; }
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 30px; }
            .logo-img { height: 30px; }
            .nav-links { position: fixed; top: 0; right: -100%; width: 75%; height: 100vh; background: var(--navy); flex-direction: column; padding: 100px 40px; transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1); border-left: 1px solid rgba(201, 168, 76, 0.2); gap: 30px; }
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
            .koko-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .koko-hero h1 { font-size: 32px; }
            .koko-hero-img { width: 160px; height: 280px; }
            .filter-wrapper { justify-content: center; }
            .filter-sort { width: 100%; justify-content: center; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .gold-branch-footer { display: none; }
            .custom-cursor, .cursor-dot { display: none; }
            .marquee-banner { display: none; }
        }

        @media (max-width: 480px) {
            .koko-grid { grid-template-columns: 1fr; }
            .koko-hero-images { flex-direction: column; }
            .koko-hero-img { width: 200px; height: 300px; margin: 0 !important; }
        }
    </style>
</head>

<body>

    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-text">caymira</div>
        <div class="loader-bar">
            <div class="loader-progress"></div>
        </div>
    </div>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari koko..." id="searchInput">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Standar Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.php'">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/about.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearch()"></i>
             <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon" onclick="window.location.href='../keranjang/keranjang.php'" style="cursor: pointer;">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartBadge">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Koko Hero Section -->
    <section class="koko-hero">
        <div class="hero-deco-circle hero-deco-1"></div>
        <div class="hero-deco-circle hero-deco-2"></div>
        <div class="hero-deco-circle hero-deco-3"></div>
        
        <div class="koko-hero-wrapper">
            <div class="koko-hero-text">
                <p class="subtitle">Stylish & Elegan</p>
                <h1>KOLEKSI <span>KOKO PREMIUM</span></h1>
                <p class="description">
                    Temukan koleksi koko terbaik dengan desain <span>minimalis dan elegan</span>. 
                    Hadir dengan bahan premium yang sejuk, pilihan tepat untuk kamu yang ingin tampil stylish 
                    dengan kesan dewasa yang terang, membuat setiap momen terasa lebih istimewa.
                </p>
                <button class="koko-hero-cta" onclick="document.querySelector('.koko-collection').scrollIntoView({behavior: 'smooth'})">
                    Belanja Sekarang <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            
            <div class="koko-hero-images">
                <img src="../Koko/model1.png" alt="Koko Model 1" class="koko-hero-img">
                <img src="../Koko/model2.png" alt="Koko Model 2" class="koko-hero-img">
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
                <button class="filter-btn active" onclick="filterKoko('all', this)">Semua</button>
                <button class="filter-btn" onclick="filterKoko('new', this)">Terbaru</button>
                <button class="filter-btn" onclick="filterKoko('best', this)">Best Seller</button>
                <button class="filter-btn" onclick="filterKoko('sale', this)">Sale</button>
            </div>
            <div class="filter-sort">
                <label>Urutkan:</label>
                <select onchange="sortKoko(this.value)">
                    <option value="popular">Paling Populer</option>
                    <option value="newest">Terbaru</option>
                    <option value="price-low">Harga: Rendah - Tinggi</option>
                    <option value="price-high">Harga: Tinggi - Rendah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Koko Collection -->
    <section class="container koko-collection" id="collection">
        <div class="section-header">
            <h2>BAJU KOKO</h2>
            <p>Koleksi koko stylish dan elegan untuk laki-laki dewasa</p>
        </div>

 
       <div class="koko-grid" id="kokoGrid">

            <?php 
            while($row = mysqli_fetch_assoc($query)) { 
                $label = isset($row['label']) ? $row['label'] : 'NEW';
                $category_lbl = strtolower($label); 
                $ulasan = isset($row['total_ulasan']) ? $row['total_ulasan'] : rand(40, 150);

                $harga_sekarang = isset($row['harga_diskon']) ? $row['harga_diskon'] : (isset($row['harga']) ? $row['harga'] : 0);
                $harga_coret = isset($row['harga_asli']) ? $row['harga_asli'] : (isset($row['harga_coret']) ? $row['harga_coret'] : 0);

                $sumber_gambar = (strpos($row['gambar'], 'http') === 0) ? $row['gambar'] : '../Beranda/Gambarberanda/' . $row['gambar']; 
                $nama_aman = htmlspecialchars($row['nama_produk'], ENT_QUOTES);
            ?>

            <div class="koko-card" data-category="<?php echo $category_lbl; ?>" data-price="<?php echo $harga_sekarang; ?>">
                
                <?php if(!empty($label)): ?>
                    <span class="koko-badge <?php echo $category_lbl; ?>"><?php echo $label; ?></span>
                <?php endif; ?>

                <div class="koko-img-wrapper">
                    <a href="../detailproduk/index.php?id=<?php echo $row['id']; ?>&kategori=koko" style="display: block;">
                        <img src="<?php echo $sumber_gambar; ?>" alt="<?php echo $nama_aman; ?>" class="koko-img" style="width: 100%; height: 320px; object-fit: cover; object-position: top; border-radius: 12px;">
                    </a>
                    
                    <div class="koko-img-overlay" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 10px;">
                        
                        
                        <button type="button" 
                                style="background: #c9a84c; color: #0a1628; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 80%; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s;"
                                onclick="event.preventDefault(); event.stopPropagation(); addToCart('<?php echo $row['id']; ?>', '<?php echo $nama_aman; ?>', <?php echo $harga_sekarang; ?>, '<?php echo $sumber_gambar; ?>')">
                            <i class="fas fa-cart-plus" style="pointer-events: none;"></i> Tambah 
                        </button>

                    </div>
                </div>

                <div class="koko-info">
                    <a href="../detailproduk/index.php?id=<?php echo $row['id']; ?>&kategori=koko" style="text-decoration: none; color: inherit;">
                        <h3 style="margin-bottom: 5px;"><?php echo $row['nama_produk']; ?></h3>
                    </a>
                    
                    <p class="koko-price">
                        Rp <?php echo number_format($harga_sekarang, 0, ',', '.'); ?>
                        <?php if($harga_coret > $harga_sekarang): ?>
                            <span style="text-decoration: line-through; color: #888; font-size: 14px; margin-left: 5px;">
                                Rp <?php echo number_format($harga_coret, 0, ',', '.'); ?>
                            </span>
                        <?php endif; ?>
                    </p>

                    <div class="koko-rating">
                        <span class="stars" style="color: #ffcc00;">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </span>
                        <span class="review-count">(<?php echo $ulasan; ?>)</span>
                    </div>

                    <div class="koko-colors">
                        <span class="color-dot active" style="background: #2c2c54;"></span>
                        <span class="color-dot" style="background: #40407a;"></span>
                        <span class="color-dot" style="background: #706fd3;"></span>
                    </div>
                </div>
            </div>

            <?php 
            } 
            ?>

        </div>
    </section>

    <!-- Standar Footer -->
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
                <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" style="height: 50px;">
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Beranda</a></li>
                    <li><a href="../About-us/about.php">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item"><i class="far fa-clock"></i><div>10.00 - 17.00 WIB</div></div>
                <div class="contact-item"><i class="fas fa-phone"></i><div>0895-7042-D0408</div></div>
                <div class="contact-item"><i class="far fa-envelope"></i><div>caymiramodest@gmail.com</div></div>
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

    <!-- JavaScript Gabungan -->
    <script>
        // 1. Loading Screen & Init Cart
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => { document.getElementById("loader").classList.add("hidden"); }, 800); 
            updateCartBadge();
        });

        // 2. Custom Cursor
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
            // Hover Effects
            document.querySelectorAll('a, button, .koko-card, .filter-btn, .color-dot').forEach(el => {
                el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
                el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
            });
        }

        // 3. UI Toggles
        function toggleSearch() { document.getElementById('searchOverlay').classList.toggle('active'); }
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('active');
            document.getElementById('mobileMenuBtn').classList.toggle('active');
        }

        // Navbar Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // 4. Toast Notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastText').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // 5. Interaksi Koko (Filter & Wishlist)
        function filterKoko(category, btnElement) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            btnElement.classList.add('active');
            const items = document.querySelectorAll('.koko-card');
            
            items.forEach(item => {
                item.style.display = 'none'; 
                setTimeout(() => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                        item.classList.remove('visible');
                        void item.offsetWidth; 
                        item.classList.add('visible');
                    }
                }, 50);
            });
        }

        function toggleWishlist(btn) {
            const icon = btn.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            if(icon.classList.contains('fas')) {
                btn.style.color = '#e74c3c';
                showToast('❤️ Ditambahkan ke Wishlist');
            } else {
                btn.style.color = 'var(--white)';
                showToast('🤍 Dihapus dari Wishlist');
            }
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });
        document.querySelectorAll('.section-header h2, .section-header p, .koko-card').forEach(el => observer.observe(el));

        // 6. LOGIKA KERANJANG (Sama seperti Gamis)
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
            
            // Path image dikondisikan biar kebaca di keranjang
            // Mengasumsikan file koko di dalam folder Koko
            let imgPath = image.includes('../') ? image : '../Koko/' + image;

            if (existingItem) {
                  existingItem.quantity += 1; 
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: imgPath,
                    quantity: 1
                });
            }

            saveCart(cart); 
            updateCartBadge(); 
            showToast('🛒 ' + name + ' ditambahkan ke keranjang!');
        }
    </script>
</body>
</html>
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
    <title>Caymira Modest - Fashion Syar'i</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
 
/* Cursor */
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

/* === NAVBAR=== */
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

/* === HERO SECTION - ENHANCED === */
.hero {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 600px;
    display: flex;
    overflow: hidden;
    margin-top: 70px;
    margin-bottom: 0;
}
.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 50%, rgba(201, 168, 76, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(201, 168, 76, 0.05) 0%, transparent 50%);
    z-index: 1;
    pointer-events: none;
}
.hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 60%;
    height: 100%;
    background: linear-gradient(
        to right,
        rgba(10, 22, 40, 0.9),
        rgba(10, 22, 40, 0.5),
        transparent
    );
    z-index: 1;
}
.hero-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
    filter: brightness(0.85);
    animation: heroZoom 20s ease-in-out infinite alternate;
}
@keyframes heroZoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.08); }
}
.hero-content-wrapper {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}
.hero-text {
    flex: 1;
    padding: 30px 0;
}
.hero-text h3 {
    font-family: var(--font-heading);
    font-style: italic;
    font-weight: 400;
    font-size: 24px;
    margin-bottom: 20px;
    color: var(--gold-light);
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.5s forwards;
}
.hero-text h1 {
    font-size: 56px;
    line-height: 1.15;
    margin-bottom: 25px;
    color: #FFFFFF;
    font-weight: 700;
    text-shadow: 0 4px 15px rgba(0,0,0,0.5);
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.7s forwards;
}
.hero-text h1 span {
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
.hero-text p {
    color: var(--text-light);
    font-size: 16px;
    max-width: 500px;
    line-height: 1.8;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 0.9s forwards;
}
.hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    padding: 16px 36px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    margin-top: 35px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.4s ease;
    cursor: pointer;
    border: none;
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease 1.1s forwards;
}
.hero-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.hero-cta:hover::before {
    left: 100%;
}
.hero-cta:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
}
.hero-cta i {
    transition: transform 0.3s;
}
.hero-cta:hover i {
    transform: translateX(5px);
}

/* Scroll indicator */
.scroll-indicator {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    opacity: 0;
    animation: fadeIn 1s ease 1.5s forwards;
}
.scroll-indicator span {
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
}
.scroll-indicator i {
    font-size: 20px;
    color: var(--gold);
    animation: bounce 2s infinite;
}

/* Decorative elements */
.hero-decoration {
    position: absolute;
    z-index: 2;
    pointer-events: none;
}
.hero-decoration-1 {
    top: 20%;
    right: 10%;
    width: 200px;
    height: 200px;
    border: 1px solid rgba(201, 168, 76, 0.2);
    border-radius: 50%;
    animation: rotate 20s linear infinite;
}
.hero-decoration-2 {
    bottom: 20%;
    right: 20%;
    width: 100px;
    height: 100px;
    border: 1px solid rgba(201, 168, 76, 0.15);
    border-radius: 50%;
    animation: rotate 15s linear infinite reverse;
}
@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* === KOLEKSI PILIHAN - ENHANCED === */
.categories {
    text-align: center;
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}
.categories::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 50% 0%, rgba(201, 168, 76, 0.05) 0%, transparent 60%);
    pointer-events: none;
}
.section-title {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--gold);
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
    opacity: 0;
    transform: translateY(30px);
}
.section-title.visible {
    animation: fadeInUp 0.8s ease forwards;
}
.section-title::after {
    content: '';
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: var(--gold);
    transition: width 0.6s ease;
}
.section-title.visible::after {
    width: 80px;
}
@keyframes fadeInScale {
    to { opacity: 0.5; transform: scale(1); }
}
.section-subtitle {
    font-family: var(--font-heading);
    color: var(--gold);
    font-style: italic;
    margin-bottom: 60px;
    font-size: 18px;
    opacity: 0;
    transform: translateY(20px);
}
.section-subtitle.visible {
    animation: fadeInUp 0.8s ease 0.3s forwards;
}
.category-grid {
    display: flex;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}
.category-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    opacity: 0;
    transform: translateY(40px);
}
.category-item.visible {
    animation: fadeInUp 0.8s ease forwards;
}
.category-item:nth-child(1).visible { animation-delay: 0.1s; }
.category-item:nth-child(2).visible { animation-delay: 0.2s; }
.category-item:nth-child(3).visible { animation-delay: 0.3s; }

.category-item:hover {
    transform: translateY(-20px);
}
.category-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201, 168, 76, 0.15) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.4s;
    z-index: -1;
}
.category-item:hover::before {
    opacity: 1;
}
.category-item img {
    width: 160px;
    height: 160px;
    object-fit: contain;
    border-radius: 50%;
    border: 2px solid rgba(201, 168, 76, 0.2);
    padding: 20px;
    background: rgba(201, 168, 76, 0.03);
    transition: all 0.5s ease;
    margin-bottom: 20px;
    position: relative;
}
.category-item:hover img {
    border-color: var(--gold);
    box-shadow: 
        0 0 30px rgba(201, 168, 76, 0.2),
        0 10px 40px rgba(0, 0, 0, 0.3);
    background: rgba(201, 168, 76, 0.08);
    transform: scale(1.05);
}
.category-item span {
    font-size: 15px;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--text-light);
    transition: all 0.3s;
    position: relative;
}
.category-item:hover span {
    color: var(--gold);
    transform: translateY(-5px);
}
.category-item span::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 1px;
    background: var(--gold);
    transition: width 0.3s;
}
.category-item:hover span::after {
    width: 30px;
}

/* === PRODUK TERLARIS - ENHANCED === */
.products {
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}
.products::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 0% 50%, rgba(201, 168, 76, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 100% 50%, rgba(201, 168, 76, 0.03) 0%, transparent 50%);
    pointer-events: none;
}
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 50px;
    position: relative;
    z-index: 1;
}
.products-header h3 {
    font-family: var(--font-heading);
    font-size: 32px;
    color: var(--gold);
    position: relative;
    display: inline-block;
    opacity: 0;
    transform: translateX(-30px);
}
.products-header h3.visible {
    animation: fadeInLeft 0.8s ease forwards;
}
.products-header h3::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--gold);
    transition: width 0.6s ease;
}
.products-header h3.visible::after {
    width: 50px;
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
    position: relative;
    opacity: 0;
    transform: translateX(30px);
}
.view-all.visible {
    animation: fadeInRight 0.8s ease 0.2s forwards;
}
.view-all::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: var(--gold);
    transition: width 0.3s;
}
.view-all:hover::after {
    width: 100%;
}
.view-all:hover {
    gap: 12px;
    color: var(--gold-light);
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
    position: relative;
    z-index: 1;
}
.product-card {
    background: rgba(201, 168, 76, 0.03);
    border: 1px solid rgba(201, 168, 76, 0.1);
    border-radius: 16px;
    padding: 25px;
    position: relative;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    opacity: 0;
    transform: translateY(50px);
}
.product-card.visible {
    animation: fadeInUp 0.8s ease forwards;
}
.product-card:nth-child(1).visible { animation-delay: 0.1s; }
.product-card:nth-child(2).visible { animation-delay: 0.2s; }
.product-card:nth-child(3).visible { animation-delay: 0.3s; }

.product-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.08) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.5s;
}
.product-card:hover::before {
    opacity: 1;
}
.product-card::after {
    content: '';
    position: absolute;
    top: -2px; left: -2px; right: -2px; bottom: -2px;
    background: linear-gradient(45deg, var(--gold), transparent, var(--gold-light));
    border-radius: 18px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.5s;
}
.product-card:hover::after {
    opacity: 0.3;
}
.product-card:hover {
    transform: translateY(-15px) scale(1.02);
    border-color: rgba(201, 168, 76, 0.3);
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.4),
        0 0 30px rgba(201, 168, 76, 0.1);
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
    animation: badgePulse 2s ease-in-out infinite;
}
@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.product-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 25px;
}
.product-img {
    width: 100%;
    height: 340px;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.6s ease;
}
.product-card:hover .product-img {
    transform: scale(1.08);
}
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
.product-card:hover .product-img-overlay {
    opacity: 1;
}
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
    display: flex;
    align-items: center;
    gap: 8px;
}
.quick-view-btn:hover {
    background: var(--white);
    transform: scale(1.05);
}
.product-info h4 {
    font-size: 17px;
    margin-bottom: 10px;
    font-weight: 500;
    color: var(--text-light);
    transition: color 0.3s;
}
.product-card:hover .product-info h4 {
    color: var(--gold-light);
}
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

/* === FEATURES - ENHANCED === */
.features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    text-align: center;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}
.features::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.features::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.feature-item {
    padding: 40px 30px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(40px);
}
.feature-item.visible {
    animation: fadeInUp 0.8s ease forwards;
}
.feature-item:nth-child(1).visible { animation-delay: 0.1s; }
.feature-item:nth-child(2).visible { animation-delay: 0.2s; }
.feature-item:nth-child(3).visible { animation-delay: 0.3s; }

.feature-item::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.05) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.5s;
    border-radius: 16px;
}
.feature-item:hover::before {
    opacity: 1;
}
.feature-item:hover {
    transform: translateY(-10px);
    background: rgba(201, 168, 76, 0.03);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}
.feature-item i {
    font-size: 32px;
    color: var(--gold);
    width: 80px;
    height: 80px;
    border: 2px solid rgba(201, 168, 76, 0.3);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    transition: all 0.5s ease;
    position: relative;
}
.feature-item:hover i {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    transform: scale(1.15) rotate(5deg);
    border-color: transparent;
    box-shadow: 0 10px 30px rgba(201, 168, 76, 0.3);
}
.feature-item h4 {
    font-size: 15px;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--text-light);
    font-weight: 600;
}
.feature-item p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.7;
    max-width: 280px;
    margin: 0 auto;
}

/* === BANNER COUPLE - ENHANCED === */
.banner-couple {
    background: linear-gradient(135deg, #f5e6cc, #e8d5b0);
    border-radius: 20px;
    display: flex;
    align-items: center;
    padding: 0 60px;
    color: var(--navy);
    position: relative;
    overflow: hidden;
    margin: 80px auto;        
    max-width: 1100px;        
    border: 1px solid rgba(201, 168, 76, 0.3);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    opacity: 0;
    transform: translateY(50px);
}
.banner-couple.visible {
    animation: fadeInUp 1s ease forwards;
}
.banner-couple::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(201, 168, 76, 0.15) 0%, transparent 70%);
    animation: floatDecoration 8s ease-in-out infinite;
}
.banner-couple::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(201, 168, 76, 0.1) 0%, transparent 70%);
    animation: floatDecoration 10s ease-in-out infinite reverse;
}
@keyframes floatDecoration {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(30px, -30px); }
}
.banner-img {
    width: 45%;
    height: 420px;
    object-fit: cover;
    object-position: 50% 40%;
    border-radius: 0 20px 20px 0;
    position: relative;
    z-index: 1;
    transition: transform 0.5s ease;
}
.banner-couple:hover .banner-img {
    transform: scale(1.02);
}
.banner-content {
    width: 55%;
    text-align: center;
    padding: 60px;
    position: relative;
    z-index: 1;
}
.badge-collection {
    border: 2px solid var(--gold);
    padding: 8px 22px;
    border-radius: 25px;
    font-size: 11px;
    display: inline-block;
    margin-bottom: 25px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--navy);
    background: rgba(201, 168, 76, 0.1);
    animation: badgeGlow 2s ease-in-out infinite;
}
@keyframes badgeGlow {
    0%, 100% { box-shadow: 0 0 5px rgba(201, 168, 76, 0.3); }
    50% { box-shadow: 0 0 20px rgba(201, 168, 76, 0.5); }
}
.banner-content h2 {
    font-size: 36px;
    font-family: var(--font-heading);
    margin-bottom: 20px;
    color: var(--navy);
    line-height: 1.3;
}
.banner-content p {
    font-size: 15px;
    margin-bottom: 30px;
    color: #555;
    line-height: 1.8;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}
.btn-shop {
    background: linear-gradient(135deg, var(--navy), #1a2a3a);
    color: var(--text-light);
    padding: 14px 35px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s ease;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-size: 13px;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.btn-shop::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s;
}
.btn-shop:hover::before {
    left: 100%;
}
.btn-shop:hover {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(201, 168, 76, 0.3);
}
.btn-shop i {
    transition: transform 0.3s;
}
.btn-shop:hover i {
    transform: translateX(5px);
}

/* === SECTION DIVIDER === */
.section-divider {
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.5), transparent);
    margin: 0;
    border: none;
    position: relative;
}
.section-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 1px;
    background: var(--gold);
}
.section-divider::after {
    content: '✦';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--gold);
    font-size: 14px;
    background: var(--navy);
    padding: 0 15px;
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
.social-links a:hover::before {
    transform: scale(1);
}
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
.footer-col:hover .footer-title::after {
    width: 100%;
}
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
    content: '→';
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
.contact-item:hover i {
    transform: scale(1.2);
}
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
.newsletter-form button:hover {
    background: var(--gold-light);
}
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

/* === MARQUEE BANNER === */
.marquee-banner {
    background: linear-gradient(90deg, var(--navy), var(--navy-light), var(--navy));
    padding: 15px 0;
    overflow: hidden;
    position: relative;
    border-top: 1px solid rgba(201, 168, 76, 0.2);
    border-bottom: 1px solid rgba(201, 168, 76, 0.2);
}
.marquee-content {
    display: flex;
    animation: marqueeScroll 20s linear infinite;
    white-space: nowrap;
}
.marquee-item {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 0 40px;
    color: var(--gold);
    font-size: 13px;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.marquee-item i {
    color: var(--gold);
    font-size: 14px;
}
@keyframes marqueeScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* === ANIMATED COUNTER SECTION === */
.stats-banner {
    display: flex;
    justify-content: center;
    gap: 80px;
    padding: 50px 0;
    background: linear-gradient(to right, var(--navy), var(--navy-light), var(--navy));
    position: relative;
    overflow: hidden;
}
.stats-banner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.stat-item {
    text-align: center;
    position: relative;
    opacity: 0;
    transform: translateY(30px);
}
.stat-item.visible {
    animation: fadeInUp 0.8s ease forwards;
}
.stat-item:nth-child(1).visible { animation-delay: 0.1s; }
.stat-item:nth-child(2).visible { animation-delay: 0.2s; }
.stat-item:nth-child(3).visible { animation-delay: 0.3s; }
.stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 48px;
    color: var(--gold);
    font-weight: 700;
    display: block;
    transition: all 0.3s;
}
.stat-item:hover .stat-number {
    transform: scale(1.2);
    text-shadow: 0 0 30px rgba(201, 168, 76, 0.5);
}
.stat-label {
    font-size: 13px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-top: 8px;
}

/* === FLOATING SHAPES BACKGROUND === */
.floating-shapes {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.shape {
    position: absolute;
    border: 1px solid rgba(201, 168, 76, 0.1);
    border-radius: 50%;
    animation: shapeFloat 15s infinite ease-in-out;
}
.shape-1 {
    width: 300px;
    height: 300px;
    top: 10%;
    left: -5%;
    animation-duration: 20s;
}
.shape-2 {
    width: 200px;
    height: 200px;
    top: 60%;
    right: -3%;
    animation-duration: 18s;
    animation-delay: 2s;
}
.shape-3 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 30%;
    animation-duration: 22s;
    animation-delay: 4s;
}
@keyframes shapeFloat {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(30px, -30px) rotate(90deg); }
    50% { transform: translate(-20px, 20px) rotate(180deg); }
    75% { transform: translate(20px, 10px) rotate(270deg); }
}

/* Animations */
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-40px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(40px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Responsive */
@media (max-width: 1024px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
    .footer-content { grid-template-columns: 1fr 1fr; }
    .banner-couple { flex-direction: column; padding: 40px; }
    .banner-img { width: 100%; height: 280px; border-radius: 16px; margin-bottom: 20px; }
    .banner-content { width: 100%; padding: 20px; }
    .stats-banner { gap: 40px; }
    .hero-text h1 { font-size: 42px; }
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
    .hero { height: auto; min-height: 500px; }
    .hero-text h1 { font-size: 32px; }
    .hero-text h1 span { font-size: 28px; }
    .hero-text p { font-size: 14px; }
    .hero-decoration { display: none; }
    .product-grid { grid-template-columns: 1fr; }
    .features { grid-template-columns: 1fr; }
    .category-grid { gap: 30px; }
    .category-item img { width: 120px; height: 120px; }
    .stats-banner { flex-direction: column; gap: 30px; padding: 40px 20px; }
    .stat-number { font-size: 36px; }
    .footer { padding: 35px 30px 25px; }
    .footer-content { grid-template-columns: 1fr; gap: 25px; }
    .footer-bottom { margin-left: -30px; margin-right: -30px; }
    .custom-cursor, .cursor-dot { display: none; }
    .scroll-indicator { display: none; }
    .floating-shapes { display: none; }
    .marquee-banner { display: none; }
}

    </style>
<base target="_blank">
</head>

<body>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Floating Shapes Background -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari produk..." id="searchInput">
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
            <img src="Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php" class="active">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearch()"></i>

            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>

            
            <!-- Cart Icon Diperbarui -->

            <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
            
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <img src="Gambarberanda/banner home page.png" alt="Model Syari" class="hero-bg-image">

        <div class="hero-decoration hero-decoration-1"></div>
        <div class="hero-decoration hero-decoration-2"></div>

        <div class="container hero-content-wrapper">
            <div class="hero-text">
                <h3>Tampil syar'i, anggun & berkelas</h3>
                <h1>FASHION SYAR'I<br><span>PILIHAN TERBAIK</span></h1>
                <p>Temukan koleksi hijab, gamis, koko, dan perlengkapan syar'i berkualitas dengan desain modern yang nyaman dipakai.</p>
                <button class="hero-cta" onclick="showToast('✨ Mulai berbelanja sekarang!')">
                    Belanja Sekarang <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <div class="scroll-indicator" onclick="document.querySelector('.categories').scrollIntoView({behavior: 'smooth'})">
            <span>Scroll</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </header>

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

    <!-- Koleksi Pilihan -->
    <section class="container categories" id="collection">
        <h2 class="section-title">Koleksi Pilihan</h2>
        <p class="section-subtitle">Pilihan terbaik untuk gaya syar'i Anda</p>

        <div class="category-grid">
            <div class="category-item" onclick="showToast('👗 Melihat koleksi Gamis...')">
                <a href="../Gamis/gamis.php" class="category-item" onclick="showToast('👗 Melihat koleksi Gamis...')">
                  <img src="Gambarberanda/gamis_icon.png" alt="Gamis">
                  <span>Gamis</span>
                </a>
            </div>
            <div class="category-item" onclick="showToast('🧕 Melihat koleksi Hijab...')">
                <a href="../Hijab/hijab.php" class="category-item" onclick="showToast('👗 Melihat koleksi Gamis...')">
                    <img src="Gambarberanda/kerudung_icon.png" alt="Hijab">
                    <span>Hijab</span>
                </a>
            </div>
            <div class="category-item" onclick="showToast('👔 Melihat koleksi Koko...'); setTimeout(() => { window.location.href='../Koko/index.php' }, 1000);">
             <a href="../Koko/index.php" class="category-item" onclick="showToast('👔 Melihat koleksi Koko...'); setTimeout(() => { window.location.href='../Koko/index.php' }, 1000);">
                 <img src="Gambarberanda/koko_icon.png" alt="Koko">
                 <span>Koko</span>
             </a>
            </div>
            <div class="category-item" onclick="showToast('👔 Melihat koleksi Jubah...'); setTimeout(() => { window.location.href='../Jubah/index.php' }, 1000);">
             <a href="../Jubah/index.php" class="category-item" onclick="showToast('👔 Melihat koleksi Jubah...'); setTimeout(() => { window.location.href='../Jubah/index.php' }, 1000);">
                 <img src="Gambarberanda/jubah_icon.png" alt="Jubah">
                 <span>Jubah</span>
             </a>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Produk Terlaris -->
    <section class="container products" id="bestseller">
        <div class="products-header">
            <h3>Produk Terlaris</h3>
           <a href="../best-seller/best-seller.php" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            
            <div class="product-card">
                <a href="../detailproduk/index.php?id=3&kategori=best_seller" style="text-decoration: none; color: inherit; display: block;">
                    <span class="badge-new">NEW</span>
                    <div class="product-img-wrapper">
                        <img src="../best-seller/gambar all product/Lunara Gamis.png" class="product-img">
                        
                        <div class="product-img-overlay">
                            <button type="button" class="quick-view-btn" onclick="event.preventDefault(); event.stopPropagation(); addToCart('3', 'Lunara Gamis', 198000, '../best-seller/gambar all product/Lunara Gamis.png');">
                                <i class="fas fa-cart-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h4>Lunara Gamis</h4>
                        <p class="product-price">Rp 198.000</p>
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span>(126)</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="product-card">
                <a href="../detailproduk/index.php?id=5&kategori=best_seller" style="text-decoration: none; color: inherit; display: block;">
                    <span class="badge-new">NEW</span>
                    <div class="product-img-wrapper">
                        <img src="../best-seller/gambar all product/Seliana Hijab.png" class="product-img">
                        <div class="product-img-overlay">
                            <button type="button" class="quick-view-btn" onclick="event.preventDefault(); event.stopPropagation(); addToCart('5', 'Seliana Hijab', 45000, '../best-seller/gambar all product/Seliana Hijab.png');">
                                <i class="fas fa-cart-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h4>Seliana Hijab</h4>
                        <p class="product-price">Rp 45.000</p>
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span>(235)</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="product-card">
                <a href="../detailproduk/index.php?id=8&kategori=best_seller" style="text-decoration: none; color: inherit; display: block;">
                    <span class="badge-new">NEW</span>
                    <div class="product-img-wrapper">
                        <img src="../best-seller/gambar all product/Raell Koko.png" alt="Raell Koko" class="product-img">
                        <div class="product-img-overlay">
                            <button type="button" class="quick-view-btn" onclick="event.preventDefault(); event.stopPropagation(); addToCart('8', 'Raell Koko', 156000, '../best-seller/gambar all product/Raell Koko.png');">
                                <i class="fas fa-cart-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h4>Raell Koko</h4>
                        <p class="product-price">Rp 156.000</p>
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span>(182)</span>
                        </div>
                    </div>
                </a>
            </div>
            
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Stats Banner -->
    <section class="stats-banner">
        <div class="stat-item">
            <span class="stat-number" data-target="5000">0</span>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-item">
            <span class="stat-number" data-target="150">0</span>
            <div class="stat-label">Products</div>
        </div>
        <div class="stat-item">
            <span class="stat-number" data-target="25">0</span>
            <div class="stat-label">Cities</div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Features -->
    <section class="container features">
        <div class="feature-item" onclick="showToast('🛡️ Transaksi aman & terpercaya')">
            <i class="fas fa-shield-halved"></i>
            <h4>Aman & Terpercaya</h4>
            <p>Transaksi aman dengan pelayanan terpercaya untuk kenyamanan berbelanja.</p>
        </div>
        <div class="feature-item" onclick="showToast('🎧 Pelayanan ramah & responsif')">
            <i class="fas fa-headset"></i>
            <h4>Pelayanan Ramah</h4>
            <p>Tim kami siap membantu dengan pelayanan yang responsif dan ramah.</p>
        </div>
        <div class="feature-item" onclick="showToast('🚚 Pengiriman cepat ke seluruh Indonesia')">
            <i class="fas fa-truck-fast"></i>
            <h4>Pengiriman Cepat</h4>
            <p>Pesanan diproses dengan cepat dan dikirim dengan aman ke seluruh Indonesia.</p>
        </div>
    </section>

    <!-- Banner Couple -->
    <section class="container banner-couple">
        <img src="Gambarberanda/couple.png" alt="Couple Collection" class="banner-img">
        <div class="banner-content">
            <span class="badge-collection">NEW COLLECTION</span>
            <h2>KOLEKSI COUPLE<br><span style="font-style: italic; font-weight: 300;">ELEGAN</span></h2>
            <p>Tampil elegan dan serasi dengan koleksi gamis dan koko premium berkualitas untuk setiap momen spesial.</p>
            <button class="btn-shop" onclick="showToast('💑 Melihat koleksi couple...')">
                Belanja Sekarang <i class="fas fa-arrow-right"></i>
            </button>
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
                   <img src="Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
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
                    <li><a href="../Beranda/beranda.php" class="active">Beranda</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
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

        document.querySelectorAll('a, button, i, .value-card, .contact-item, .category-item, .product-card, .feature-item, .btn-shop, .quick-view-btn').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        // ===== PARTICLES =====
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 25; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 12 + 's';
                particle.style.animationDuration = (10 + Math.random() * 8) + 's';
                particle.style.width = particle.style.height = (2 + Math.random() * 3) + 'px';
                container.appendChild(particle);
            }
        }
        createParticles();

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

        // ===== SCROLL REVEAL ANIMATION =====
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        // Observe elements for scroll reveal
        document.querySelectorAll('.section-title, .logokoleksipilihan, .section-subtitle, .category-item, .products-header h3, .view-all, .product-card, .feature-item, .banner-couple, .stat-item').forEach(el => {
            revealObserver.observe(el);
        });

        // ===== STATS COUNTER =====
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numbers = entry.target.querySelectorAll('.stat-number');
                    numbers.forEach(num => animateCounter(num));
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsBanner = document.querySelector('.stats-banner');
        if (statsBanner) {
            statsObserver.observe(statsBanner);
        }

        // ===== PARALLAX EFFECT =====
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-bg-image');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.15}px) scale(1.08)`;
            }
        });

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

        // ===== HERO TILT EFFECT =====
        const heroSection = document.querySelector('.hero');
        if (heroSection) {
            heroSection.addEventListener('mousemove', (e) => {
                const rect = heroSection.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 50;
                const rotateY = (centerX - x) / 50;

                const heroText = document.querySelector('.hero-text');
                if (heroText) {
                    heroText.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                }
            });

            heroSection.addEventListener('mouseleave', () => {
                const heroText = document.querySelector('.hero-text');
                if (heroText) {
                    heroText.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
                }
            });
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
            
            showToast('🛒 ' + name + ' berhasil ditambahkan!');
        }

        // Perbarui badge angka keranjang belanja setiap kali halaman dimuat pertama kali
        document.addEventListener("DOMContentLoaded", function () {
            updateCartBadge();
        });
    </script>
</body>
</html>
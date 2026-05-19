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

        /* Hero Section */
        .hero {
            margin-top: 70px;
            min-height: 78vh;
            display: flex;
            align-items: center;
            padding: 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            flex: 1;
            max-width: 500px;
            z-index: 2;
            animation: fadeInLeft 1s ease;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 68px;
            color: var(--gold);
            font-weight: 400;
            letter-spacing: 3px;
            margin-bottom: 25px;
            position: relative;
        }
        .hero-title::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gold);
            animation: expandWidth 1s ease 0.5s both;
        }
        @keyframes expandWidth {
            from { width: 0; }
            to { width: 60px; }
        }

        .hero-divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        .hero-divider .line {
            width: 50px;
            height: 1px;
            background: var(--gold);
            position: relative;
            overflow: hidden;
        }
        .hero-divider .line::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, var(--gold-light), transparent);
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        .hero-divider .ornament {
            color: var(--gold);
            font-size: 22px;
            animation: rotate 4s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.8;
            color: var(--text-light);
            max-width: 400px;
            position: relative;
        }
        .hero-desc .highlight {
            color: var(--gold);
            font-weight: 500;
            position: relative;
            display: inline-block;
        }
        .hero-desc .highlight::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s;
        }
        .hero-desc:hover .highlight::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .hero-image {
            flex: 1.2;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: fadeInRight 1s ease 0.3s both;
            perspective: 1000px;
        }
        .hero-image-inner {
            position: relative;
            transition: transform 0.5s ease;
            transform-style: preserve-3d;
        }
        .hero-image img {
            max-width: 100%;
            height: auto;
            max-height: 520px;
            object-fit: contain;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
            transition: all 0.5s ease;
        }
        .hero-image:hover .hero-image-inner {
            transform: rotateY(5deg) rotateX(5deg);
        }
        .hero-image:hover img {
            filter: drop-shadow(0 30px 60px rgba(201, 168, 76, 0.2));
        }

        /* Image Tag Badge */
        .image-tag {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gold);
            color: var(--navy);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            animation: bounce 2s infinite;
            cursor: pointer;
            transition: all 0.3s;
        }
        .image-tag:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4);
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Gold Branch Decorations */
        .gold-branch-left {
            position: absolute;
            left: -60px;
            bottom: -20px;
            width: 250px;
            opacity: 0.7;
            pointer-events: none;
            animation: sway 8s ease-in-out infinite;
        }
        .gold-branch-right {
            position: absolute;
            right: -40px;
            top: 30px;
            width: 180px;
            opacity: 0.5;
            pointer-events: none;
            animation: sway 8s ease-in-out infinite reverse;
        }
        @keyframes sway {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }

        /* Stats Counter Section */
        .stats-section {
            padding: 60px;
            display: flex;
            justify-content: center;
            gap: 80px;
            background: linear-gradient(to right, var(--navy), var(--navy-light), var(--navy));
            position: relative;
            overflow: hidden;
        }
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .stat-item {
            text-align: center;
            position: relative;
        }
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

        /* Content Section */
        .content-section {
            padding: 70px 60px;
            text-align: center;
            position: relative;
            background: linear-gradient(to bottom, var(--navy), var(--navy-light));
        }

        .content-text {
            max-width: 750px;
            margin: 0 auto;
            font-size: 15px;
            line-height: 2;
            color: var(--text-light);
        }
        .content-text p {
            margin-bottom: 22px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }
        .content-text p.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .content-text .gold-text {
            color: var(--gold);
            font-weight: 500;
            position: relative;
            cursor: pointer;
        }
        .content-text .gold-text:hover {
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        /* Values Cards */
        .values-section {
            padding: 60px;
            background: var(--navy);
        }
        .values-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: var(--gold);
            text-align: center;
            margin-bottom: 50px;
        }
        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .value-card {
            background: rgba(201, 168, 76, 0.05);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 12px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .value-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .value-card:hover::before {
            opacity: 1;
        }
        .value-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px rgba(201, 168, 76, 0.15);
        }
        .value-icon {
            font-size: 40px;
            color: var(--gold);
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .value-card:hover .value-icon {
            transform: scale(1.2) rotate(10deg);
        }
        .value-title {
            font-size: 18px;
            color: var(--gold);
            margin-bottom: 12px;
            font-weight: 600;
        }
        .value-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Testimonial Slider */
        .testimonial-section {
            padding: 80px 60px;
            background: linear-gradient(to bottom, var(--navy-light), var(--navy));
            position: relative;
            overflow: hidden;
        }
        .testimonial-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: var(--gold);
            text-align: center;
            margin-bottom: 50px;
        }
        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        .testimonial-slide {
            display: none;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        .testimonial-slide.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .testimonial-text {
            font-size: 20px;
            font-style: italic;
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 30px;
            position: relative;
        }
        .testimonial-text::before,
        .testimonial-text::after {
            content: '"';
            font-size: 60px;
            color: var(--gold);
            opacity: 0.3;
            position: absolute;
        }
        .testimonial-text::before {
            top: -20px;
            left: -30px;
        }
        .testimonial-text::after {
            bottom: -40px;
            right: -30px;
        }
        .testimonial-author {
            font-size: 16px;
            color: var(--gold);
            font-weight: 600;
        }
        .testimonial-role {
            font-size: 13px;
            color: var(--text-muted);
        }
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 40px;
        }
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(201, 168, 76, 0.3);
            cursor: pointer;
            transition: all 0.3s;
        }
        .slider-dot.active {
            background: var(--gold);
            transform: scale(1.3);
        }
        .slider-dot:hover {
            background: var(--gold-light);
        }

        /* Newsletter Popup */
        .popup-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(10, 22, 40, 0.9);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s;
        }
        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .popup-box {
            background: var(--navy-light);
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 16px;
            padding: 50px;
            max-width: 450px;
            text-align: center;
            position: relative;
            transform: scale(0.8);
            transition: transform 0.4s;
        }
        .popup-overlay.active .popup-box {
            transform: scale(1);
        }
        .popup-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--gold);
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .popup-close:hover {
            transform: rotate(90deg);
        }
        .popup-icon {
            font-size: 50px;
            color: var(--gold);
            margin-bottom: 20px;
        }
        .popup-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--gold);
            margin-bottom: 15px;
        }
        .popup-text {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: #ffffff;
            border-top: 1px solid rgba(201, 168, 76, 0.15);
            padding: 50px 60px 30px;
            position: relative;
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

        .footer-brand .logo-main { font-size: 22px; margin-bottom: 3px; }
        .footer-brand .logo-sub { margin-bottom: 18px; }
        .footer-brand p {
            font-size: 12px;
            line-height: 1.8;
            color: var(--text-muted);
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
            color: var(--text-muted);
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
            color: var(--text-muted);
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
            color: var(--text-muted);
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
            color: var(--text-light);
            font-size: 13px;
            outline: none;
        }
        .newsletter-form input::placeholder { color: var(--text-muted); }
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
        .toast i {
            font-size: 18px;
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

        /* Responsive */
        @media (max-width: 1024px) {
            .hero { flex-direction: column; text-align: center; padding: 30px; }
            .hero-content { max-width: 100%; margin-bottom: 30px; }
            .hero-title { font-size: 48px; }
            .hero-desc { margin: 0 auto; }
            .hero-image img { max-height: 400px; }
            .values-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-section { gap: 40px; }
            .footer-content { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 30px; }
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
        @media (max-width: 768px) {
            .logo-img { height: 30px; }
}
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
            .hero-title { font-size: 32px; }
            .hero-image img { max-height: 300px; }
            .values-grid { grid-template-columns: 1fr; }
            .stats-section {
                flex-direction: column;
                gap: 30px;
                padding: 40px 30px;
            }
            .stat-number { font-size: 36px; }
            .content-section { padding: 50px 30px; }
            .testimonial-section { padding: 60px 30px; }
            .testimonial-text { font-size: 16px; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .gold-branch-left, .gold-branch-right, .gold-branch-footer { display: none; }
            .custom-cursor, .cursor-dot { display: none; }
        }
    </style>
<base target="_blank">
<base target="_blank">
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

    <!-- Newsletter Popup -->
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-box">
            <i class="fas fa-times popup-close" onclick="closePopup()"></i>
            <div class="popup-icon">✨</div>
            <h3 class="popup-title">Special Offer!</h3>
            <p class="popup-text">Dapatkan diskon 20% untuk pembelian pertama Anda. Daftar newsletter sekarang!</p>
            <form class="newsletter-form" onsubmit="handlePopupSubscribe(event)">
                <input type="email" placeholder="Your email" required id="popupEmail">
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
          <img src="gambarabout/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>


        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php" >Beranda</a></li>
            <li><a href="#about" class="active">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>
         

        <div class="nav-icons">
    <i class="fas fa-search" onclick="toggleSearch()"></i>
    
    <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
    
    <div class="cart-icon">
        <i class="fas fa-shopping-cart" onclick="showToast('🛒 Menuju keranjang belanja...')"></i>
    </div>
    <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
</div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="about">
        <div class="hero-content">
            <h1 class="hero-title">ABOUT US</h1>
            <div class="hero-divider">
                <span class="line"></span>
                <span class="ornament">❦</span>
                <span class="line"></span>
            </div>
            <p class="hero-desc">
                Caymira Modest hadir untuk wanita muslimah yang ingin tampil anggun, modern, dan tetap <span class="highlight">syar'i</span> setiap hari.
            </p>
        </div>

        <div class="hero-image">
            <div class="hero-image-inner">
                <img src="gambarabout/gambar baju.png" 
                     alt="Caymira Modest Collection" 
                     onerror="this.src='https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=500&fit=crop'; this.onerror=null;">
                <div class="image-tag">NEW COLLECTION</div>
            </div>
        </div>

        <svg class="gold-branch-left" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q80 250 100 200 Q120 150 100 100 Q80 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.6"/>
            <circle cx="100" cy="50" r="2" fill="#c9a84c" opacity="0.8"/>
            <circle cx="90" cy="80" r="1.5" fill="#c9a84c" opacity="0.6"/>
            <circle cx="110" cy="120" r="2" fill="#c9a84c" opacity="0.7"/>
            <circle cx="95" cy="160" r="1.5" fill="#c9a84c" opacity="0.5"/>
            <circle cx="105" cy="200" r="2" fill="#c9a84c" opacity="0.8"/>
            <circle cx="85" cy="240" r="1.5" fill="#c9a84c" opacity="0.6"/>
            <circle cx="115" cy="280" r="2" fill="#c9a84c" opacity="0.7"/>
        </svg>

        <svg class="gold-branch-right" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.5"/>
            <circle cx="100" cy="40" r="2" fill="#c9a84c" opacity="0.7"/>
            <circle cx="110" cy="90" r="1.5" fill="#c9a84c" opacity="0.6"/>
            <circle cx="90" cy="140" r="2" fill="#c9a84c" opacity="0.8"/>
            <circle cx="105" cy="190" r="1.5" fill="#c9a84c" opacity="0.5"/>
            <circle cx="95" cy="240" r="2" fill="#c9a84c" opacity="0.7"/>
        </svg>
    </section>

    <!-- Stats Counter -->
    <section class="stats-section">
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
        <div class="stat-item">
            <span class="stat-number" data-target="5">0</span>
            <div class="stat-label">Years Experience</div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="content-text">
            <p>
                Kami percaya bahwa berpakaian sesuai syariat bukan berarti membatasi gaya, melainkan menghadirkan <span class="gold-text" onclick="showToast('✨ Keanggunan dalam kesederhanaan')">keanggunan</span> yang memancarkan percaya diri dalam setiap langkah.
            </p>
            <p>
                Setiap produk Caymira Modest dibuat dengan bahan pilihan <span class="gold-text" onclick="showToast('🌟 Kualitas premium terjamin')">berkualitas</span>, desain yang timeless, dan detail yang nyaman digunakan.
            </p>
            <p>
                Terima kasih telah menjadi bagian dari perjalanan kami. Bersama Caymira Modest, mari wujudkan gaya berpakaian yang tidak hanya indah dipandang, tetapi juga <span class="gold-text" onclick="showToast('🙏 Ibadah yang menyatu dengan gaya')">bernilai ibadah</span>.
            </p>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <h2 class="values-title">Our Values</h2>
        <div class="values-grid">
            <div class="value-card" onclick="showToast('🎯 Modesty: Gaya tanpa meninggalkan nilai syar\'i')">
                <div class="value-icon">🧕</div>
                <h3 class="value-title">Modesty</h3>
                <p class="value-desc">Menjaga aurat dengan gaya yang tetap anggun dan modern</p>
            </div>
            <div class="value-card" onclick="showToast('💎 Quality: Bahan terbaik untuk kenyamanan maksimal')">
                <div class="value-icon">✨</div>
                <h3 class="value-title">Quality</h3>
                <p class="value-desc">Bahan premium yang nyaman dan tahan lama</p>
            </div>
            <div class="value-card" onclick="showToast('🎨 Design: Timeless design untuk setiap momen')">
                <div class="value-icon">🎨</div>
                <h3 class="value-title">Design</h3>
                <p class="value-desc">Desain timeless yang sesuai untuk berbagai acara</p>
            </div>
        </div>
    </section>

    <!-- Testimonial Slider -->
    <section class="testimonial-section">
        <h2 class="testimonial-title">Apa Kata Mereka?</h2>
        <div class="testimonial-slider">
            <div class="testimonial-slide active">
                <p class="testimonial-text">
                    Produk dari Caymira Modest benar-benar membuat saya percaya diri. Bahan yang nyaman dan desain yang elegan. Sangat recommended!
                </p>
                <div class="testimonial-author">Sarah A.</div>
                <div class="testimonial-role">Fashion Blogger</div>
            </div>
            <div class="testimonial-slide">
                <p class="testimonial-text">
                    Akhirnya menemukan brand modest yang benar-benar memahami kebutuhan wanita muslimah modern. Kualitasnya luar biasa!
                </p>
                <div class="testimonial-author">Dewi K.</div>
                <div class="testimonial-role">Entrepreneur</div>
            </div>
            <div class="testimonial-slide">
                <p class="testimonial-text">
                    Sudah 3 tahun menjadi customer setia Caymira. Tidak pernah kecewa dengan kualitas dan pelayanannya. The best!
                </p>
                <div class="testimonial-author">Rina M.</div>
                <div class="testimonial-role">Loyal Customer</div>
            </div>
        </div>
        <div class="slider-dots">
            <div class="slider-dot active" onclick="goToSlide(0)"></div>
            <div class="slider-dot" onclick="goToSlide(1)"></div>
            <div class="slider-dot" onclick="goToSlide(2)"></div>
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
                   <img src="gambarabout/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
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

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

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

        document.querySelectorAll('a, button, i, .value-card, .contact-item').forEach(el => {
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

        // ===== POPUP =====
        function closePopup() {
            document.getElementById('popupOverlay').classList.remove('active');
        }

        // Show popup after 10 seconds
        setTimeout(() => {
            if (!localStorage.getItem('popupShown')) {
                document.getElementById('popupOverlay').classList.add('active');
                localStorage.setItem('popupShown', 'true');
            }
        }, 10000);

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

        statsObserver.observe(document.querySelector('.stats-section'));

        // ===== TESTIMONIAL SLIDER =====
        let currentSlide = 0;
        const slides = document.querySelectorAll('.testimonial-slide');
        const dots = document.querySelectorAll('.slider-dot');

        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        // Auto slide
        setInterval(() => {
            const next = (currentSlide + 1) % slides.length;
            goToSlide(next);
        }, 5000);

        // ===== SCROLL TO TOP =====
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
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

        function handlePopupSubscribe(e) {
            e.preventDefault();
            const email = document.getElementById('popupEmail').value;
            if (email) {
                showToast('🎉 Selamat! Anda mendapatkan diskon 20%!');
                closePopup();
            }
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

        // ===== SCROLL REVEAL =====
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.content-text p').forEach(p => {
            revealObserver.observe(p);
        });

        // ===== PARALLAX EFFECT =====
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-image img');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.1}px)`;
            }
        });

        // ===== TILT EFFECT ON HERO IMAGE =====
        const heroImage = document.querySelector('.hero-image-inner');
        if (heroImage) {
            document.querySelector('.hero-image').addEventListener('mousemove', (e) => {
                const rect = heroImage.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                heroImage.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            document.querySelector('.hero-image').addEventListener('mouseleave', () => {
                heroImage.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
            });
        }

        // ===== KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', (e) => {
            // ESC to close overlays
            if (e.key === 'Escape') {
                document.getElementById('searchOverlay').classList.remove('active');
                document.getElementById('popupOverlay').classList.remove('active');
            }
            // / to open search
            if (e.key === '/' && !e.target.matches('input')) {
                e.preventDefault();
                toggleSearch();
            }
        

        });
    </script>
</body>
</html>
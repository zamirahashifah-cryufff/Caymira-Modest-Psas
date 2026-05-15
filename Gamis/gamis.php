    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gamis Collection - Caymira Modest</title>
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

            /* ===================== PARTICLES ===================== */
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

            /* ===================== NAVBAR ===================== */
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

            /* ===================== SEARCH OVERLAY ===================== */
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

            /* ===================== HERO GAMIS ===================== */
            .hero-gamis {
                margin-top: 70px;
                min-height: 85vh;
                display: flex;
                align-items: center;
                padding: 0 60px;
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 50%, var(--navy) 100%);
            }
            .hero-gamis::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a84c' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.5;
            }

            .hero-gamis-content {
                flex: 1;
                max-width: 550px;
                z-index: 2;
                animation: fadeInLeft 1s ease;
            }
            .hero-gamis-label {
                display: inline-block;
                padding: 8px 20px;
                border: 1px solid var(--gold);
                color: var(--gold);
                font-size: 11px;
                letter-spacing: 3px;
                text-transform: uppercase;
                margin-bottom: 25px;
                animation: fadeInUp 0.8s ease 0.3s both;
            }
            .hero-gamis-title {
                font-family: 'Playfair Display', serif;
                font-size: 58px;
                color: var(--gold);
                font-weight: 400;
                letter-spacing: 3px;
                margin-bottom: 25px;
                line-height: 1.2;
                position: relative;
            }
            .hero-gamis-title::before {
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
            .hero-gamis-desc {
                font-size: 16px;
                line-height: 1.8;
                color: var(--text-light);
                max-width: 420px;
                margin-bottom: 35px;
                animation: fadeInUp 0.8s ease 0.5s both;
            }
            .hero-gamis-desc .highlight {
                color: var(--gold);
                font-weight: 500;
            }
            .hero-gamis-btn {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                padding: 14px 32px;
                background: var(--gold);
                color: var(--navy);
                text-decoration: none;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 2px;
                text-transform: uppercase;
                border-radius: 4px;
                transition: all 0.4s ease;
                animation: fadeInUp 0.8s ease 0.7s both;
                position: relative;
                overflow: hidden;
            }
            .hero-gamis-btn::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                transition: left 0.5s;
            }
            .hero-gamis-btn:hover::before {
                left: 100%;
            }
            .hero-gamis-btn:hover {
                background: var(--gold-light);
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(201, 168, 76, 0.3);
            }
            .hero-gamis-btn i {
                transition: transform 0.3s;
            }
            .hero-gamis-btn:hover i {
                transform: translateX(5px);
            }

            .hero-gamis-image {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                animation: fadeInRight 1s ease 0.3s both;
                perspective: 1000px;
            }
            .hero-gamis-image-inner {
                position: relative;
                transition: transform 0.5s ease;
                transform-style: preserve-3d;
            }
            .hero-gamis-image img {
                max-width: 100%;
                height: auto;
                max-height: 550px;
                object-fit: contain;
                filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
                transition: all 0.5s ease;
            }
            .hero-gamis-image:hover .hero-gamis-image-inner {
                transform: rotateY(5deg) rotateX(5deg);
            }
            .hero-gamis-image:hover img {
                filter: drop-shadow(0 30px 60px rgba(201, 168, 76, 0.2));
            }
            .hero-gamis-tag {
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
            .hero-gamis-tag:hover {
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

            /* ===================== FILTER SECTION ===================== */
            .filter-section {
                padding: 40px 60px;
                background: linear-gradient(to bottom, var(--navy-light), var(--navy));
                border-top: 1px solid rgba(201, 168, 76, 0.1);
                border-bottom: 1px solid rgba(201, 168, 76, 0.1);
            }
            .filter-container {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
            }
            .filter-title {
                font-family: 'Playfair Display', serif;
                font-size: 24px;
                color: var(--gold);
            }
            .filter-title span {
                color: var(--text-muted);
                font-size: 14px;
                font-family: 'Poppins', sans-serif;
                margin-left: 10px;
            }
            .filter-buttons {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }
            .filter-btn {
                padding: 10px 24px;
                background: transparent;
                border: 1px solid rgba(201, 168, 76, 0.3);
                color: var(--text-light);
                font-size: 12px;
                font-weight: 500;
                letter-spacing: 1.5px;
                text-transform: uppercase;
                cursor: pointer;
                transition: all 0.3s ease;
                border-radius: 4px;
            }
            .filter-btn:hover, .filter-btn.active {
                background: var(--gold);
                color: var(--navy);
                border-color: var(--gold);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(201, 168, 76, 0.2);
            }
            .sort-dropdown {
                position: relative;
            }
            .sort-btn {
                padding: 10px 20px;
                background: rgba(201, 168, 76, 0.1);
                border: 1px solid rgba(201, 168, 76, 0.3);
                color: var(--gold);
                font-size: 12px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 10px;
                border-radius: 4px;
                transition: all 0.3s;
            }
            .sort-btn:hover {
                background: rgba(201, 168, 76, 0.2);
            }
            .sort-menu {
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                background: var(--navy-light);
                border: 1px solid rgba(201, 168, 76, 0.3);
                border-radius: 8px;
                min-width: 180px;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s;
                z-index: 100;
                overflow: hidden;
            }
            .sort-menu.active {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            .sort-menu li {
                list-style: none;
                padding: 12px 18px;
                font-size: 13px;
                color: var(--text-light);
                cursor: pointer;
                transition: all 0.2s;
                border-bottom: 1px solid rgba(201, 168, 76, 0.1);
            }
            .sort-menu li:last-child { border-bottom: none; }
            .sort-menu li:hover {
                background: rgba(201, 168, 76, 0.1);
                color: var(--gold);
            }

            /* ===================== PRODUCTS GRID ===================== */
            .products-section {
                padding: 60px;
                background: var(--navy);
                position: relative;
            }
            .products-section::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--gold), transparent);
            }
            .products-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 30px;
                max-width: 1300px;
                margin: 0 auto;
            }
            .product-card {
                background: rgba(201, 168, 76, 0.03);
                border: 1px solid rgba(201, 168, 76, 0.15);
                border-radius: 16px;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                cursor: pointer;
                position: relative;
            }
            .product-card:hover {
                transform: translateY(-12px);
                border-color: var(--gold);
                box-shadow: 0 25px 50px rgba(201, 168, 76, 0.15), 0 0 0 1px var(--gold);
            }
            .product-image {
                position: relative;
                overflow: hidden;
                aspect-ratio: 3/4;
                background: linear-gradient(135deg, var(--navy-lighter), var(--navy-light));
            }
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: all 0.6s ease;
            }
            .product-card:hover .product-image img {
                transform: scale(1.08);
            }
            .product-badge {
                position: absolute;
                top: 15px;
                left: 15px;
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                z-index: 2;
            }
            .badge-new {
                background: var(--gold);
                color: var(--navy);
            }
            .badge-sale {
                background: #e74c3c;
                color: var(--white);
            }
            .badge-bestseller {
                background: #27ae60;
                color: var(--white);
            }
            .product-overlay {
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(10, 22, 40, 0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
                opacity: 0;
                transition: all 0.4s ease;
            }
            .product-card:hover .product-overlay {
                opacity: 1;
            }
            .overlay-btn {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: var(--gold);
                color: var(--navy);
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s;
                transform: translateY(20px);
                opacity: 0;
            }
            .product-card:hover .overlay-btn {
                transform: translateY(0);
                opacity: 1;
            }
            .product-card:hover .overlay-btn:nth-child(2) {
                transition-delay: 0.1s;
            }
            .product-card:hover .overlay-btn:nth-child(3) {
                transition-delay: 0.2s;
            }
            .overlay-btn:hover {
                background: var(--gold-light);
                transform: scale(1.15);
            }
            .product-info {
                padding: 20px;
            }
            .product-name {
                font-size: 15px;
                font-weight: 500;
                color: var(--text-light);
                margin-bottom: 8px;
                transition: color 0.3s;
            }
            .product-card:hover .product-name {
                color: var(--gold);
            }
            .product-price {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 12px;
            }
            .price-current {
                font-family: 'Playfair Display', serif;
                font-size: 20px;
                color: var(--gold);
                font-weight: 600;
            }
            .price-original {
                font-size: 14px;
                color: var(--text-muted);
                text-decoration: line-through;
            }
            .product-colors {
                display: flex;
                gap: 6px;
            }
            .color-dot {
                width: 16px;
                height: 16px;
                border-radius: 50%;
                border: 2px solid transparent;
                cursor: pointer;
                transition: all 0.3s;
                position: relative;
            }
            .color-dot:hover, .color-dot.active {
                border-color: var(--gold);
                transform: scale(1.2);
            }
            .color-dot::after {
                content: '';
                position: absolute;
                top: -4px; left: -4px;
                width: calc(100% + 8px);
                height: calc(100% + 8px);
                border-radius: 50%;
                border: 1px solid transparent;
                transition: all 0.3s;
            }
            .color-dot.active::after {
                border-color: var(--gold);
            }

            /* ===================== NEWSLETTER BANNER ===================== */
            .newsletter-banner {
                padding: 80px 60px;
                background: linear-gradient(135deg, var(--navy-light), var(--navy-lighter));
                position: relative;
                overflow: hidden;
                text-align: center;
            }
            .newsletter-banner::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--gold), transparent);
            }
            .newsletter-banner::after {
                content: '';
                position: absolute;
                bottom: 0; left: 0; right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--gold), transparent);
            }
            .newsletter-content {
                max-width: 600px;
                margin: 0 auto;
                position: relative;
                z-index: 2;
            }
            .newsletter-icon {
                font-size: 48px;
                color: var(--gold);
                margin-bottom: 20px;
                animation: floatIcon 3s ease-in-out infinite;
            }
            @keyframes floatIcon {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .newsletter-title {
                font-family: 'Playfair Display', serif;
                font-size: 32px;
                color: var(--gold);
                margin-bottom: 15px;
            }
            .newsletter-desc {
                font-size: 14px;
                color: var(--text-muted);
                line-height: 1.8;
                margin-bottom: 30px;
            }
            .newsletter-form-banner {
                display: flex;
                max-width: 450px;
                margin: 0 auto;
                border: 1px solid rgba(201, 168, 76, 0.3);
                border-radius: 50px;
                overflow: hidden;
                transition: all 0.3s;
            }
            .newsletter-form-banner:focus-within {
                border-color: var(--gold);
                box-shadow: 0 0 30px rgba(201, 168, 76, 0.2);
            }
            .newsletter-form-banner input {
                flex: 1;
                background: transparent;
                border: none;
                padding: 16px 24px;
                color: var(--text-light);
                font-size: 14px;
                outline: none;
            }
            .newsletter-form-banner input::placeholder { color: var(--text-muted); }
            .newsletter-form-banner button {
                background: var(--gold);
                border: none;
                padding: 0 28px;
                color: var(--navy);
                cursor: pointer;
                transition: all 0.3s;
                font-size: 16px;
            }
            .newsletter-form-banner button:hover {
                background: var(--gold-light);
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
            .newsletter-icon {
                font-size: 50px; 
                color: var(--gold); 
                margin-bottom: 25px;
                display: block;
                text-align: center;
                filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.3));
                animation: bellSway 4s ease-in-out infinite;
                transform-origin: top center;
            }

            @keyframes bellSway {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
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
        
    </head>
    <body>
        <!-- Loading Screen -->
        <div class="loader" id="loader">
            <div class="loader-text">caymira</div>
            <div class="loader-bar">
                <div class="loader-progress"></div>
            </div>
        </div>

        <!-- Floating Shapes Background -->
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <!-- Toast -->
        <div class="toast" id="toast">
            <i class="fas fa-check-circle"></i>
            <span id="toastText"></span>
        </div>

        <!-- ===================== CUSTOM CURSOR ===================== -->
        <div class="custom-cursor" id="cursor"></div>
        <div class="cursor-dot" id="cursorDot"></div>

        <!-- ===================== PARTICLES ===================== -->
        <div class="particles" id="particles"></div>

        <!-- ===================== SEARCH OVERLAY ===================== -->
        <div class="search-overlay" id="searchOverlay">
            <div class="search-box">
                <input type="text" placeholder="Cari produk gamis..." id="searchInput">
                <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
            </div>
        </div>

        <!-- ===================== NAVBAR ===================== -->
        <nav class="navbar" id="navbar">
            <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
            </div>

            <ul class="nav-links" id="navLinks">
                <li><a href="../Beranda/beranda.php">Beranda</a></li>
                <li><a href="../About/about.php">About Us</a></li>
                <li><a href="#bestseller">Best Seller</a></li>
                <li><a href="../contact/contact.php">Contact</a></li>
            </ul>

            <div class="nav-icons">
                <i class="fas fa-search" onclick="toggleSearch()"></i>
                <i class="fas fa-user" onclick="showToast('👤 Menuju halaman akun...')"></i>
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart" onclick="showToast('🛒 Menuju keranjang belanja...')"></i>
                    <span class="cart-badge">3</span>
                </div>
                <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>

        <!-- ===================== HERO GAMIS ===================== -->
        <section class="hero-gamis" id="gamis">
            <div class="hero-gamis-content">
                <div class="hero-gamis-label">Koleksi Eksklusif</div>
                <h1 class="hero-gamis-title">GAMIS</h1>
                <p class="hero-gamis-desc">
                    Koleksi gamis terbaru dengan sentuhan modern dan elegan.
                    Didesain untuk muslimah yang ingin tampil <span class="highlight">anggun, modern, dan tetap syar'i</span>
                    setiap hari dengan kenyamanan maksimal.
                </p>
                <a href="#products" class="hero-gamis-btn">
                    Jelajahi Koleksi <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="hero-gamis-image">
                <div class="hero-gamis-image-inner">
                    <img src="gambarabout/gambar baju.png"
                        alt="Caymira Modest Gamis Collection"
                        onerror="this.src='https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=700&fit=crop'; this.onerror=null;">
                    <div class="hero-gamis-tag">NEW ARRIVAL</div>
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

        <!-- ===================== FILTER SECTION ===================== -->
        <section class="filter-section">
            <div class="filter-container">
                <div class="filter-title">
                    Koleksi Gamis <span>12 Produk</span>
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterProducts('all', this)">Semua</button>
                    <button class="filter-btn" onclick="filterProducts('new', this)">Terbaru</button>
                    <button class="filter-btn" onclick="filterProducts('bestseller', this)">Best Seller</button>
                    <button class="filter-btn" onclick="filterProducts('sale', this)">Diskon</button>
                </div>
                <div class="sort-dropdown">
                    <button class="sort-btn" onclick="toggleSort()">
                        Urutkan <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="sort-menu" id="sortMenu">
                        <li onclick="sortProducts('newest')">Terbaru</li>
                        <li onclick="sortProducts('price-low')">Harga: Rendah ke Tinggi</li>
                        <li onclick="sortProducts('price-high')">Harga: Tinggi ke Rendah</li>
                        <li onclick="sortProducts('popular')">Paling Populer</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- ===================== PRODUCTS GRID ===================== -->
        <section class="products-section" id="products">
            <div class="products-grid" id="productsGrid">
                <!-- Product 1 -->
                <div class="product-card" data-category="new bestseller" data-price="385000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400&h=533&fit=crop" alt="Gamis Alesha">
                        <span class="product-badge badge-new">New</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Alesha Premium</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 385.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #8e44ad;"></span>
                            <span class="color-dot" style="background: #c0392b;"></span>
                            <span class="color-dot" style="background: #27ae60;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card" data-category="bestseller" data-price="420000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&h=533&fit=crop" alt="Gamis Zahra">
                        <span class="product-badge badge-bestseller">Best Seller</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Zahra Elegan</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 420.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #d4b76a;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #e8e8e8;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card" data-category="sale" data-price="299000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=533&fit=crop" alt="Gamis Rania">
                        <span class="product-badge badge-sale">-30%</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Rania Classic</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 299.000</span>
                            <span class="price-original">Rp 425.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #8e44ad;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #c0392b;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card" data-category="new" data-price="450000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=400&h=533&fit=crop" alt="Gamis Amira">
                        <span class="product-badge badge-new">New</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Amira Luxury</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 450.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #27ae60;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #d4b76a;"></span>
                            <span class="color-dot" style="background: #e8e8e8;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="product-card" data-category="bestseller" data-price="375000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400&h=533&fit=crop" alt="Gamis Safira">
                        <span class="product-badge badge-bestseller">Best Seller</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Safira Modern</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 375.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #c0392b;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #8e44ad;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="product-card" data-category="sale" data-price="275000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?w=400&h=533&fit=crop" alt="Gamis Laila">
                        <span class="product-badge badge-sale">-25%</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Laila Simple</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 275.000</span>
                            <span class="price-original">Rp 365.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #e8e8e8;"></span>
                            <span class="color-dot" style="background: #d4b76a;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="product-card" data-category="new" data-price="495000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?w=400&h=533&fit=crop" alt="Gamis Nabila">
                        <span class="product-badge badge-new">New</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Nabila Exclusive</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 495.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #8e44ad;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #27ae60;"></span>
                            <span class="color-dot" style="background: #c0392b;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="product-card" data-category="bestseller" data-price="410000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&h=533&fit=crop" alt="Gamis Fatima">
                        <span class="product-badge badge-bestseller">Best Seller</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Fatima Royal</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 410.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #d4b76a;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #e8e8e8;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 9 -->
                <div class="product-card" data-category="sale" data-price="320000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1558171813-4c088753af8f?w=400&h=533&fit=crop" alt="Gamis Khadijah">
                        <span class="product-badge badge-sale">-20%</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Khadijah Grace</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 320.000</span>
                            <span class="price-original">Rp 400.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #27ae60;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #8e44ad;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 10 -->
                <div class="product-card" data-category="new" data-price="465000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400&h=533&fit=crop" alt="Gamis Maryam">
                        <span class="product-badge badge-new">New</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Maryam Divine</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 465.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #c0392b;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #d4b76a;"></span>
                            <span class="color-dot" style="background: #e8e8e8;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 11 -->
                <div class="product-card" data-category="bestseller" data-price="390000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1495385794356-eed71e66ffd6?w=400&h=533&fit=crop" alt="Gamis Hana">
                        <span class="product-badge badge-bestseller">Best Seller</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Hana Chic</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 390.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #e8e8e8;"></span>
                            <span class="color-dot" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #8e44ad;"></span>
                        </div>
                    </div>
                </div>

                <!-- Product 12 -->
                <div class="product-card" data-category="sale" data-price="285000">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1502716119720-b23a93e5fe1b?w=400&h=533&fit=crop" alt="Gamis Siti">
                        <span class="product-badge badge-sale">-35%</span>
                        <div class="product-overlay">
                            <button class="overlay-btn" onclick="showToast('❤️ Ditambahkan ke wishlist')"><i class="far fa-heart"></i></button>
                            <button class="overlay-btn" onclick="showToast('👁️ Melihat detail produk')"><i class="far fa-eye"></i></button>
                            <button class="overlay-btn" onclick="showToast('🛒 Ditambahkan ke keranjang')"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gamis Siti Basic</h3>
                        <div class="product-price">
                            <span class="price-current">Rp 285.000</span>
                            <span class="price-original">Rp 435.000</span>
                        </div>
                        <div class="product-colors">
                            <span class="color-dot active" style="background: #2c3e50;"></span>
                            <span class="color-dot" style="background: #27ae60;"></span>
                            <span class="color-dot" style="background: #c0392b;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== NEWSLETTER BANNER ===================== -->
        <section class="newsletter-banner">
            <div class="newsletter-content">
                <div class="newsletter-icon">
                <i class="fa-regular fa-bell on"></i>
    <           </div>
                <h2 class="newsletter-title">Jangan Lewatkan Update Terbaru</h2>
                <p class="newsletter-desc">
                    Dapatkan info koleksi terbaru, promo eksklusif, dan diskon spesial
                    langsung ke inbox Anda.
                </p>
                <form class="newsletter-form-banner" onsubmit="handleBannerSubscribe(event)">
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
                        <a href="#" onclick="showToast('👥 Facebook: Caymira Modest')"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-D0408')"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php" class="active">Beranda</a></li>
                        <li><a href="../About-us/aboutus.php">About Us</a></li>
                        <li><a href="#bestseller">Best Seller</a></li>
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
                
            <!-- Loading -->
            <script>
                    window.addEventListener("load", function () {
                    const loader = document.querySelector(".loader");
                    setTimeout(function () {
                    loader.classList.add("hidden");
                    }, 1500); 
                });
                </script>
        </body>
        </html>


<?php
include 'koneksi.php';

// Ambil parameter filter, sort, dan search dari URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build query dasar
$sql = "SELECT * FROM gamis WHERE 1=1";

// Tambahkan logika Pencarian (Search) jika ada
if (!empty($search)) {
    $sql .= " AND (nama LIKE '%$search%' OR warna LIKE '%$search%')";
}

// Filter
if ($filter == 'new') {
    $sql .= " AND is_new = 1";
} elseif ($filter == 'bestseller') {
    $sql .= " AND is_bestseller = 1";
}

// Sort
if ($sort == 'price-low') {
    $sql .= " ORDER BY COALESCE(harga_diskon, harga) ASC";
} elseif ($sort == 'price-high') {
    $sql .= " ORDER BY COALESCE(harga_diskon, harga) DESC";
} elseif ($sort == 'popular') {
    $sql .= " ORDER BY is_bestseller DESC, id DESC";
} else {
    $sql .= " ORDER BY id DESC"; // newest
}

$result = mysqli_query($conn, $sql);

// Hitung total produk (terpengaruh hasil pencarian)
$count_sql = "SELECT COUNT(*) as total FROM gamis WHERE 1=1";
if (!empty($search)) {
    $count_sql .= " AND (nama LIKE '%$search%' OR warna LIKE '%$search%')";
}
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_produk = $count_row['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamis Collection - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        
        /* === GAMIS HERO SECTION === */
        .hero-gamis {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            margin-top: 70px;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 40%, var(--navy-lighter) 100%);
        }

        .hero-gamis::before {
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

        .hero-gamis::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a84c' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
            opacity: 0.5;
        }

        .hero-gamis-wrapper {
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

        .hero-gamis-content {
            flex: 1;
            max-width: 550px;
        }

        .hero-gamis-content .subtitle {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 400;
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--gold-light);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        .hero-gamis-content h1 {
            font-family: 'Playfair Display', serif;
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

        .hero-gamis-content h1 span {
            display: block;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, var(--gold) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s linear infinite;
        }

        @keyframes shine { to { background-position: 200% center; } }

        .hero-gamis-content .description {
            color: var(--text-light);
            font-size: 15px;
            line-height: 1.9;
            margin-bottom: 35px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease 0.7s forwards;
        }

        .hero-gamis-content .description .highlight {
            color: var(--gold);
            font-weight: 500;
        }

        .hero-gamis-btn {
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
            text-decoration: none;
        }

        .hero-gamis-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .hero-gamis-btn:hover::before { left: 100%; }

        .hero-gamis-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
            background: var(--gold-light);
        }

        .hero-gamis-btn i { transition: transform 0.3s; }
        .hero-gamis-btn:hover i { transform: translateX(5px); }

        /* Hero Image */
        .hero-gamis-images {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            perspective: 1000px;
        }

        .hero-gamis-img-wrapper {
            position: relative;
            transition: transform 0.5s ease;
            transform-style: preserve-3d;
            animation: fadeInUp3D 1s ease 0.5s forwards;
            opacity: 0;
            transform: translateY(50px) rotateY(-10deg);
        }

        .hero-gamis-images img {
            width: 320px;
            height: auto;
            max-height: 550px;
            object-fit: contain;
            border-radius: 20px;
            border: 2px solid rgba(201, 168, 76, 0.3);
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-gamis-img-wrapper:hover {
            transform: translateY(-15px) scale(1.05) rotateY(0deg);
            z-index: 10;
        }
        
        .hero-gamis-img-wrapper:hover img {
            border-color: var(--gold);
            box-shadow: 0 30px 60px rgba(201, 168, 76, 0.25);
        }

        .hero-gamis-tag {
            position: absolute;
            top: 20px;
            right: -20px;
            background: var(--gold);
            color: var(--navy);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            animation: bounce 2s infinite;
            z-index: 3;
        }

        @keyframes fadeInUp3D {
            from { opacity: 0; transform: translateY(50px) rotateY(-10deg); }
            to { opacity: 1; transform: translateY(0) rotateY(-5deg); }
        }

        /* Decorative Elements Hero */
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
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* Gold Branch Decorations */
        .gold-branch-left {
            position: absolute;
            left: -60px;
            bottom: -20px;
            width: 250px;
            opacity: 0.7;
            pointer-events: none;
            animation: sway 8s ease-in-out infinite;
            z-index: 2;
        }
        .gold-branch-right {
            position: absolute;
            right: -40px;
            top: 30px;
            width: 180px;
            opacity: 0.5;
            pointer-events: none;
            animation: sway 8s ease-in-out infinite reverse;
            z-index: 2;
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
            text-decoration: none;
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
            padding: 0;
        }
        .sort-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .sort-menu li {
            list-style: none;
            border-bottom: 1px solid rgba(201, 168, 76, 0.1);
        }
        .sort-menu li a {
            display: block;
            padding: 12px 18px;
            font-size: 13px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s;
        }
        .sort-menu li:last-child { border-bottom: none; }
        .sort-menu li a:hover, .sort-menu li a.active {
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
        .badge-new { background: var(--gold); color: var(--navy); }
        .badge-sale { background: #e74c3c; color: var(--white); }
        .badge-bestseller { background: #27ae60; color: var(--white); }
        
      
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

        /* ===================== FOOTER ===================== */
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
        .social-links a:hover::before { transform: scale(1); }
        .social-links a:hover { color: var(--navy); transform: translateY(-3px); }
        .social-links a i { position: relative; z-index: 1; }
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
        .footer-col:hover .footer-title::after { width: 100%; }
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
        .footer-links a:hover { color: var(--gold); transform: translateX(4px); }
        .footer-links a:hover::before { opacity: 1; transform: translateX(0); }
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
        .contact-item:hover { color: var(--gold); transform: translateX(5px); }
        .contact-item i {
            color: var(--gold);
            margin-top: 3px;
            font-size: 14px;
            width: 18px;
            transition: transform 0.3s;
        }
        .contact-item:hover i { transform: scale(1.2); }
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
            color: #333; 
            font-size: 13px;
            outline: none;
        }
        .newsletter-form input::placeholder { color: #888; }
        .newsletter-form button {
            background: var(--gold);
            border: none;
            padding: 0 20px;
            color: var(--navy);
            cursor: pointer;
            transition: all 0.3s;
        }
        .newsletter-form button:hover { background: var(--gold-light); }
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

        /* Miscellaneous UI elements */
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

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        .no-products i {
            font-size: 48px;
            color: var(--gold);
            margin-bottom: 20px;
            display: block;
        }
        .no-products h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: var(--gold);
            margin-bottom: 10px;
        }

        /* Mobile Menu Button */
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
        .mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
        .mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        /* Animations */
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive */
        @media (max-width: 1024px) {
            .products-grid { grid-template-columns: repeat(3, 1fr); }
            .footer-content { grid-template-columns: 1fr 1fr; }
            .hero-gamis-wrapper { flex-direction: column; text-align: center; }
            .hero-gamis-content { max-width: 100%; }
        }

        @media (max-width: 768px) {
            .navbar { padding: 15px 30px; }
            .logo-img { height: 30px; }
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
            .hero-gamis-content h1 { font-size: 32px; }
            .hero-gamis-images img { max-height: 300px; width: 220px; }
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .products-section { padding: 30px; }
            .filter-section { padding: 20px 30px; }
            .filter-container { flex-direction: column; align-items: flex-start; }
            .footer { padding: 35px 30px 25px; }
            .footer-content { grid-template-columns: 1fr; gap: 25px; }
            .gold-branch-left, .gold-branch-right, .gold-branch-footer { display: none; }
            .custom-cursor, .cursor-dot { display: none; }
        }

        @media (max-width: 480px) {
            .products-grid { grid-template-columns: 1fr; }
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
            <input type="text" placeholder="Cari produk gamis..." id="searchInput" value="<?php echo htmlspecialchars($search); ?>">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
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
            <div class="cart-icon">
            <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
              <span class="cart-badge" id="cartBadge">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span>
                <span></span> 
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Gamis -->
    <section class="hero-gamis" id="gamis">
        <div class="hero-deco-circle hero-deco-1"></div>
        <div class="hero-deco-circle hero-deco-2"></div>
        <div class="hero-deco-circle hero-deco-3"></div>
    
        <div class="hero-gamis-wrapper">
            <div class="hero-gamis-content">
                <p class="subtitle">Koleksi Eksklusif</p>
                <h1>GAMIS <span>PREMIUM</span></h1>
                <p class="description">
                    Koleksi gamis terbaru dengan sentuhan modern dan elegan.
                    Didesain untuk muslimah yang ingin tampil <span class="highlight">anggun, modern, dan tetap syar'i</span>
                    setiap hari dengan kenyamanan maksimal.
                </p>
                <a href="#products" class="hero-gamis-btn">
                    Jelajahi Koleksi <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="hero-gamis-images">
                <div class="hero-gamis-img-wrapper">
                    <img src="gambargamis/hero gamis new.png" 
                        alt="Caymira Modest Gamis Collection"
                        onerror="this.src='gambargamis/gamis-hero.jpg'">
                    <div class="hero-gamis-tag">NEW ARRIVAL</div>
                </div>
            </div>
        </div>

        <!-- Gold Branch Decorations -->
        <svg class="gold-branch-left" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q80 250 100 200 Q120 150 100 100 Q80 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.6"/>
        </svg>
        <svg class="gold-branch-right" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.5"/>
        </svg>
    </section>

    <!-- Filter Section -->
    <section class="filter-section" id="filterArea">
        <div class="filter-container">
            <div class="filter-title">
                <?php if(!empty($search)): ?>
                    Hasil Pencarian: "<?php echo htmlspecialchars($search); ?>"
                <?php else: ?>
                    Koleksi Gamis 
                <?php endif; ?>
                <span><?php echo $total_produk; ?> Produk</span>
                <?php if(!empty($search)): ?>
                    <a href="?" style="font-size: 12px; color: var(--gold); margin-left: 10px; text-decoration: underline;">Hapus Pencarian</a>
                <?php endif; ?>
            </div>
            
            <div class="filter-buttons">
                <a href="?filter=all&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search); ?>#products" class="filter-btn <?php echo $filter == 'all' ? 'active' : ''; ?>">Semua</a>
                <a href="?filter=new&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search); ?>#products" class="filter-btn <?php echo $filter == 'new' ? 'active' : ''; ?>">Terbaru</a>
                <a href="?filter=bestseller&sort=<?php echo $sort; ?>&search=<?php echo urlencode($search); ?>#products" class="filter-btn <?php echo $filter == 'bestseller' ? 'active' : ''; ?>">Best Seller</a>
            </div>

            <div class="sort-dropdown">
                <button class="sort-btn" onclick="toggleSort()">
                    Urutkan <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="sort-menu" id="sortMenu">
                    <li><a href="?filter=<?php echo $filter; ?>&sort=newest&search=<?php echo urlencode($search); ?>#products" class="<?php echo $sort == 'newest' ? 'active' : ''; ?>">Terbaru</a></li>
                    <li><a href="?filter=<?php echo $filter; ?>&sort=price-low&search=<?php echo urlencode($search); ?>#products" class="<?php echo $sort == 'price-low' ? 'active' : ''; ?>">Harga: Rendah ke Tinggi</a></li>
                    <li><a href="?filter=<?php echo $filter; ?>&sort=price-high&search=<?php echo urlencode($search); ?>#products" class="<?php echo $sort == 'price-high' ? 'active' : ''; ?>">Harga: Tinggi ke Rendah</a></li>
                    <li><a href="?filter=<?php echo $filter; ?>&sort=popular&search=<?php echo urlencode($search); ?>#products" class="<?php echo $sort == 'popular' ? 'active' : ''; ?>">Paling Populer</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
   <section class="products-section" id="products">
        <div class="products-grid" id="productsGrid">
            <?php
            $folder_gambar = 'gambargamis/'; 

            if (mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_assoc($result)):
                    $badge_class = !empty($row['badge']) ? strtolower(str_replace(' ', '-', $row['badge'])) : '';
                    $path_gambar = $folder_gambar . trim($row['gambar']);
                    $harga_fix = (!empty($row['harga_diskon']) && $row['harga_diskon'] < $row['harga']) ? $row['harga_diskon'] : $row['harga']; 
            ?>
            
            <div class="product-card">
                
                <div class="product-image" onclick="window.location.href='../detailproduk/index.php?id=<?php echo $row['id']; ?>&kategori=gamis'" style="cursor: pointer;">
                    
                    <img src="<?php echo $path_gambar; ?>?v=<?php echo time(); ?>" 
                         alt="<?php echo htmlspecialchars($row['nama']); ?>"
                         onerror="this.src='https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400&h=533&fit=crop';">
                    
                    <?php if(!empty($row['badge'])): ?>
                        <span class="product-badge badge-<?php echo $badge_class; ?>">
                            <?php echo htmlspecialchars($row['badge']); ?>
                        </span>
                    <?php endif; ?>
                    
                    <div class="action-overlay">
                      <button class="btn-action" onclick="event.stopPropagation(); addToCart('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['nama'], ENT_QUOTES); ?>', <?php echo $harga_fix; ?>, '<?php echo $path_gambar; ?>')">
                         <i class="fas fa-cart-plus" style="pointer-events: none;"></i> Tambah
                      </button>
                    </div>
                </div>

                <div class="product-info">
                    
                    <h3 class="product-name" onclick="window.location.href='../detailproduk/index.php?id=<?php echo $row['id']; ?>&kategori=gamis'" style="cursor: pointer; transition: color 0.3s;" onmouseover="this.style.color='#c9a84c'" onmouseout="this.style.color='inherit'">
                        <?php echo htmlspecialchars($row['nama']); ?>
                    </h3>
                    
                    <div class="product-price">
                        <?php if(!empty($row['harga_diskon']) && $row['harga_diskon'] < $row['harga']): ?>
                            <span class="price-current">Rp <?php echo number_format($row['harga_diskon'], 0, ',', '.'); ?></span>
                            <span class="price-original">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                        <?php else: ?>
                            <span class="price-current">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-colors">
                        <?php 
                        if(!empty($row['warna'])):
                            $colors = explode(',', $row['warna']);
                            foreach($colors as $i => $color): 
                                $color = trim($color);
                                if(!empty($color)):
                        ?>
                            <span class="color-dot <?php echo $i==0 ? 'active' : ''; ?>" style="background: <?php echo htmlspecialchars($color); ?>;"></span>
                        <?php 
                                endif;
                            endforeach;
                        else: 
                        ?>
                            <span class="color-dot active" style="background: #2c3e50;"></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php 
                endwhile;
            else:
            ?>
            <div class="no-products">
                <i class="fas fa-search"></i>
                <h3>Pencarian Tidak Ditemukan</h3>
                <p>Maaf, produk yang Anda cari tidak tersedia. Coba kata kunci lain.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Newsletter Banner -->
    <section class="newsletter-banner">
        <div class="newsletter-content">
            <div class="newsletter-icon">
                <i class="fa-regular fa-bell"></i>
            </div>
            <h2 class="newsletter-title">Jangan Lewatkan Update Terbaru</h2>
            <p class="newsletter-desc">
                Dapatkan info koleksi terbaru, promo eksklusif, dan diskon spesial
                langsung ke inbox Anda.
            </p>
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
            <!-- Brand -->
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

            <!-- Links -->
            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Beranda</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Contact -->
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

            <!-- Newsletter -->
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
        const loader = document.getElementById("loader");
        
        if (loader && loader.style.display !== 'none') {
            const forceHide = setTimeout(() => {
                loader.classList.add("hidden");
            }, 3000);

            setTimeout(function () {
                loader.classList.add("hidden");
                clearTimeout(forceHide); 
            }, 1000); 
        }
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

    function toggleSearch() {
        const overlay = document.getElementById('searchOverlay');
        overlay.classList.toggle('active');
        if (overlay.classList.contains('active')) {
            setTimeout(() => document.getElementById('searchInput').focus(), 300);
        }
    }

    // Logika menjalankan pencarian saat tekan Enter (Sekarang otomatis scroll ke bagian produk)
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const searchTerm = this.value.trim();
            if (searchTerm !== "") {
                // Menambahkan #products di akhir URL agar halaman otomatis scroll ke sana
                window.location.href = '?search=' + encodeURIComponent(searchTerm) + '#products';
            } else {
                window.location.href = '?#products';
            }
        }
    });

    function toggleMobileMenu() {
        document.getElementById('navLinks').classList.toggle('active');
        document.getElementById('mobileMenuBtn').classList.toggle('active');
    }

    function toggleSort() {
        document.getElementById('sortMenu').classList.toggle('active');
    }

    document.addEventListener('click', (e) => {
        if(!e.target.closest('.sort-dropdown')) {
            const menu = document.getElementById('sortMenu');
            if(menu) menu.classList.remove('active');
        }
    });

    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastText = document.getElementById('toastText');
        if (toast && toastText) {
            toastText.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }
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

    document.addEventListener("DOMContentLoaded", function () {
        updateCartBadge();
    });
</script>
</body>
</html>

<?php
mysqli_close($conn);
?>
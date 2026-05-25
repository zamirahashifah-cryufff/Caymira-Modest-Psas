<?php
session_start();

// 1. CEK APAKAH SUDAH LOGIN?
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// 2. KONEKSI KE DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "caymira_modest"; 
$conn = new mysqli($host, $user, $pass, $db);

// 3. AMBIL DATA USER
$user_id = $_SESSION['user_id'];
$query = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
$data = $query->fetch_assoc();

// Mencegah Error Undefined array key
$nama_user = isset($data['nama_lengkap']) ? $data['nama_lengkap'] : (isset($data['nama']) ? $data['nama'] : 'Pelanggan Caymira');
$email_user = isset($data['email']) ? $data['email'] : 'Email tidak ditemukan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA (Identik dengan Beranda) === */
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

        /* === NAVBAR (Copy dari Beranda) === */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 1000; background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.6);
            transition: all 0.3s ease;
        }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .logo-img { height: 75px; width: auto; object-fit: contain; transition: all 0.3s; margin-top: 5px; position: relative; z-index: 1001; }
        .logo:hover .logo-img { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.5)); }

        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { color: var(--text-light); font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; position: relative; padding: 5px 0; text-decoration: none; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }

        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; transition: all 0.3s; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
        
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge {
            position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy);
            font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }

        /* Search Overlay */
        .search-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 22, 40, 0.98); z-index: 9999;
            display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.4s;
        }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-box { width: 60%; max-width: 600px; position: relative; }
        .search-box input { width: 100%; padding: 20px 60px 20px 0; background: transparent; border: none; border-bottom: 2px solid var(--gold); color: var(--gold); font-size: 32px; outline: none; }
        .search-close { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 28px; cursor: pointer; }

        /* Mobile Menu */
        .mobile-menu-btn { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; }
        .mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: all 0.3s; }

        /* === CURSOR === */
        .custom-cursor { width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; mix-blend-mode: difference; }
        .cursor-dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; }

        /* === PROFILE SECTION (Styling Konten) === */
        .profile-container {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 100px 20px 50px;
        }
        .profile-card {
            background: rgba(20, 30, 42, 0.6); backdrop-filter: blur(15px);
            border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 20px;
            padding: 40px; width: 100%; max-width: 450px; text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .user-avatar {
            font-size: 40px; color: var(--navy); background: var(--gold);
            width: 90px; height: 90px; line-height: 90px; border-radius: 50%;
            margin: 0 auto 20px;
        }
        .profile-card h2 { font-family: var(--font-heading); color: var(--gold); margin-bottom: 25px; }
        .info-group {
            text-align: left; margin-bottom: 15px; background: rgba(10, 22, 40, 0.8);
            border: 1px solid rgba(201, 168, 76, 0.2); padding: 12px 20px; border-radius: 10px;
        }
        .info-group label { display: block; font-size: 10px; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; }
        .info-group p { color: var(--text-light); font-weight: 500; margin-top: 2px; }
        
        .btn-action {
            display: block; width: 100%; padding: 12px; border-radius: 30px;
            text-decoration: none; font-weight: 600; text-transform: uppercase;
            font-size: 12px; letter-spacing: 1px; transition: 0.3s; margin-top: 10px;
        }
        .btn-home { border: 1px solid var(--gold); color: var(--gold); }
        .btn-home:hover { background: var(--gold); color: var(--navy); }
        .btn-logout { background: #e74c3c; color: white; border: none; margin-top: 20px; }
        .btn-logout:hover { background: #c0392b; }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar { padding: 0 25px; }
            .nav-links { position: fixed; top: 0; right: -100%; width: 75%; height: 100vh; background: var(--navy); flex-direction: column; padding: 100px 40px; transition: 0.4s; }
            .nav-links.active { right: 0; }
            .mobile-menu-btn { display: flex; }
        }
    </style>
</head>
<body>

    <!-- Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" placeholder="Cari produk..." id="searchInput">
            <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
        </div>
    </div>

    <!-- Navbar (Sama dengan Beranda) -->
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
            <a href="profil.php" style="color: var(--gold);"><i class="fas fa-user"></i></a>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Konten Profil -->
    <div class="profile-container">
        <div class="profile-card">
            <div class="user-avatar"><i class="fas fa-user"></i></div>
            <h2>Profil Pelanggan</h2>

            <div class="info-group">
                <label>Nama Lengkap</label>
                <p><?php echo htmlspecialchars($nama_user); ?></p>
            </div>

            <div class="info-group">
                <label>Email Aktif</label>
                <p><?php echo htmlspecialchars($email_user); ?></p>
            </div>

            <div class="info-group">
                <label>Password</label>
                <p>******** <span style="font-size: 10px; color: var(--text-muted);">(Terenkripsi)</span></p>
            </div>

            <a href="../Beranda/beranda.php" class="btn-action btn-home">Kembali Berbelanja</a>
            <a href="logout.php" class="btn-action btn-logout">Keluar Akun</a>
        </div>
    </div>

    <script>
        // Kursus Custom
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px';
            cursorDot.style.top = e.clientY - 3 + 'px';
        });

        // Toggle Navbar Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Mobile Menu
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('active');
            document.getElementById('mobileMenuBtn').classList.toggle('active');
        }

        // Search Overlay
        function toggleSearch() {
            const overlay = document.getElementById('searchOverlay');
            overlay.classList.toggle('active');
            if (overlay.classList.contains('active')) {
                setTimeout(() => document.getElementById('searchInput').focus(), 400);
            }
        }

        // Logic Keranjang (Update Badge)
        function updateCartBadge() {
            const cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = totalItems;
                badge.style.display = totalItems > 0 ? 'flex' : 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", updateCartBadge);
    </script>
</body>
</html>
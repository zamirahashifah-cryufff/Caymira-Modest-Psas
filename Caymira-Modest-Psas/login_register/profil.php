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
$db   = "mbuh"; // Pastikan nama database benar
$conn = new mysqli($host, $user, $pass, $db);

// 3. AMBIL DATA USER DARI DATABASE
$user_id = $_SESSION['user_id'];
$query = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
$data = $query->fetch_assoc();

// Mencegah Error "Undefined array key" dengan mengecek nama kolom di database kamu
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
        /* === VARIABEL WARNA (Sama dengan auth.php) === */
        :root {
            --navy: #0a1628;
            --gold: #cba85a;
            --gold-dark: #b8963f;
            --text-light: #e8e8e8;
            --text-muted: #a0a0a0;
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
            cursor: none; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        a { text-decoration: none; color: inherit; transition: all 0.3s ease; cursor: none; }
        
        /* === CUSTOM CURSOR === */
        .custom-cursor {
            width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%;
            position: fixed; pointer-events: none; z-index: 99999;
            transition: transform 0.1s, background 0.3s; mix-blend-mode: difference;
        }
        .custom-cursor.hover { transform: scale(2); background: rgba(201, 168, 76, 0.2); }
        .cursor-dot {
            width: 6px; height: 6px; background: var(--gold); border-radius: 50%;
            position: fixed; pointer-events: none; z-index: 99999;
        }

        /* === HEADER / NAVBAR === */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 1000; background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(203, 168, 90, 0.3);
        }
        .logo h2 { color: var(--gold); font-family: var(--font-heading); letter-spacing: 2px; }
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; position: relative; padding: 5px 0; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s; }
        .nav-links a:hover::after { width: 100%; }
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; transition: all 0.3s; }
        .nav-icons i:hover, .nav-icons a:hover i { color: var(--gold); transform: scale(1.2); }

        /* === PROFILE SECTION === */
        .profile-section {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding-top: 100px; padding-bottom: 50px; position: relative;
        }
        .profile-card {
            background: rgba(20, 30, 42, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(203, 168, 90, 0.3);
            border-radius: 20px; padding: 50px 40px; width: 100%; max-width: 450px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); text-align: center;
        }
        .user-avatar {
            font-size: 50px; color: var(--navy);
            background: var(--gold); width: 100px; height: 100px;
            line-height: 100px; border-radius: 50%; margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(203, 168, 90, 0.2);
        }
        .profile-card h2 {
            font-family: var(--font-heading); color: var(--gold);
            font-size: 28px; margin-bottom: 30px; letter-spacing: 1px;
        }
        
        .info-group {
            text-align: left; margin-bottom: 15px;
            background: rgba(10, 22, 40, 0.8);
            border: 1px solid rgba(203, 168, 90, 0.2);
            padding: 15px 20px; border-radius: 10px;
        }
        .info-group label {
            display: block; font-size: 11px; color: var(--gold);
            text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 5px;
        }
        .info-group p {
            margin: 0; color: var(--text-light); font-weight: 500; font-size: 15px;
        }

        /* Tombol */
        .btn-action {
            display: block; width: 100%; background: transparent; color: var(--gold);
            padding: 14px; border-radius: 30px; border: 1px solid var(--gold);
            font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;
            cursor: none; margin-top: 15px; transition: all 0.3s; font-size: 13px;
        }
        .btn-action:hover { background: var(--gold); color: var(--navy); transform: translateY(-2px); }
        
        .btn-logout {
            background: #e74c3c; color: #fff; border: none; margin-top: 25px;
        }
        .btn-logout:hover {
            background: #c0392b; color: #fff; border-color: #c0392b;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }
    </style>
</head>
<body>

    <div class="custom-cursor"></div>
    <div class="cursor-dot"></div>

    <nav class="navbar">
        <div class="logo">
            <h2>CAYMIRA</h2>
        </div>
        <ul class="nav-links">
            <li><a href="../Beranda/beranda.php" class="interactive">Beranda</a></li>
            <li><a href="../About-us/aboutus.php" class="interactive">About Us</a></li>
            <li><a href="../login_register/contact.php" class="interactive">Contact</a></li>
            <li><a href="#" class="interactive">Best Seller</a></li>
        
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search interactive"></i>
            <i class="fas fa-shopping-cart interactive"></i>
            <a href="profil.php" class="interactive" style="color: var(--gold);"><i class="fas fa-user"></i></a>
        </div>
    </nav>

    <section class="profile-section">
        <div class="profile-card">
            <div class="user-avatar interactive">
                <i class="fas fa-user"></i>
            </div>
            <h2>Profil Pelanggan</h2>

            <div class="info-group interactive">
                <label>Nama Lengkap</label>
                <p class="data-value">
                <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Nama Belum Diatur'; ?>
                </p>
            </div>

            <div class="info-group interactive">
                <label>Email Aktif</label>
                <p class="data-value">
                <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Email tidak ditemukan'; ?>
                </p>
            </div>

            <div class="info-group interactive">
                <label>Password</label>
                <p class="data-value" style="letter-spacing: 2px; font-weight: bold;">
    ********    <span style="font-size: 12px; font-weight: normal; letter-spacing: normal; color: #888;">(Terenkripsi)</span>
                </p>
            </div>

            <a href="../Beranda/beranda.php" class="btn-action interactive">Kembali ke Beranda</a>
            <a href="logout.php" class="btn-action btn-logout interactive">Keluar Akun</a>
        </div>
    </section>

    <script>
        const cursor = document.querySelector('.custom-cursor');
        const cursorDot = document.querySelector('.cursor-dot');
        const interactives = document.querySelectorAll('.interactive, a, input, button');

        window.addEventListener('mousemove', (e) => {
            cursor.style.transform = `translate(${e.clientX - 10}px, ${e.clientY - 10}px)`;
            cursorDot.style.transform = `translate(${e.clientX - 3}px, ${e.clientY - 3}px)`;
        });

        interactives.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });
    </script>
</body>
</html>
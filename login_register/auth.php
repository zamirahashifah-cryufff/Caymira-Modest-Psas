<?php
session_start();

// KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "caymira_modest"; 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pesan = "";

// PROSES LOGIN & REGISTER
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $nama = $conn->real_escape_string($_POST['nama']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($cek->num_rows > 0) {
            $pesan = "<div class='alert error'>Email sudah terdaftar!</div>";
        } else {
            $insert = $conn->query("INSERT INTO users (nama_lengkap, email, password) VALUES ('$nama', '$email', '$password')");
            if ($insert) {
                $pesan = "<div class='alert success'>Registrasi berhasil! Silakan Login.</div>";
            } else {
                $pesan = "<div class='alert error'>Terjadi kesalahan. Coba lagi.</div>";
            }
        }
    } elseif (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($cek->num_rows > 0) {
            $data = $cek->fetch_assoc();
            if (password_verify($password, $data['password'])) {
                // --- BAGIAN YANG DITAMBAHKAN/DIPERBARUI ---
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['nama'] = $data['nama_lengkap'];      // Untuk sapaan di beranda
                $_SESSION['nama_lengkap'] = $data['nama_lengkap']; // Untuk halaman profil
                $_SESSION['email'] = $data['email'];            // Menyimpan email user ke session
                // ------------------------------------------

                // Keluar dari folder login_register (../), lalu masuk ke Beranda/beranda.php
                header("Location: ../Beranda/beranda.php"); 
                exit();
            } else {
                $pesan = "<div class='alert error'>Password salah!</div>";
            }
        } else {
            $pesan = "<div class='alert error'>Email tidak ditemukan!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caymira Modest - Login & Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA & FONT === */
        :root {
            --navy: #0a1628;
            --gold: #cba85a; /* Disesuaikan dengan warna gold di gambar */
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
        }
        a { text-decoration: none; color: inherit; transition: color 0.3s ease; cursor: none; }
        
        /* === CUSTOM CURSOR === */
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
        .custom-cursor.hover { transform: scale(2); background: rgba(201, 168, 76, 0.2); }
        .cursor-dot {
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
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
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2); }

        /* === AUTH SECTION === */
        .auth-section {
            min-height: 90vh;
            display: flex; align-items: center; justify-content: center;
            padding-top: 70px; margin-bottom: 50px; position: relative;
        }
        .auth-container {
            background: rgba(20, 30, 42, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(203, 168, 90, 0.3);
            border-radius: 20px; padding: 50px 40px; width: 100%; max-width: 450px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); position: relative; z-index: 10;
        }
        .auth-header { text-align: center; margin-bottom: 30px; }
        .auth-header h3 { font-family: var(--font-heading); color: var(--gold); font-size: 28px; margin-bottom: 5px; }
        .auth-header p { font-size: 13px; color: var(--text-muted); }
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group i { position: absolute; left: 15px; top: 15px; color: var(--gold); opacity: 0.7; }
        .form-group input {
            width: 100%; padding: 12px 15px 12px 45px;
            background: rgba(10, 22, 40, 0.8); border: 1px solid rgba(203, 168, 90, 0.3);
            border-radius: 8px; color: var(--text-light); font-family: var(--font-body); font-size: 14px;
            transition: all 0.3s; outline: none;
        }
        .form-group input:focus { border-color: var(--gold); }
        .btn-auth {
            width: 100%; background: var(--gold); color: #000; padding: 14px; border-radius: 30px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;
            border: none; cursor: none; margin-top: 10px; transition: all 0.3s;
        }
        .btn-auth:hover { background: var(--gold-dark); transform: translateY(-3px); }
        .auth-switch { text-align: center; margin-top: 25px; font-size: 13px; color: var(--text-muted); }
        .auth-switch span { color: var(--gold); cursor: none; font-weight: 600; transition: 0.3s; }
        .auth-switch span:hover { text-decoration: underline; }
        #register-form { display: none; }
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; text-align: center; }
        .alert.success { background: rgba(46, 204, 113, 0.1); border: 1px solid #2ecc71; color: #2ecc71; }
        .alert.error { background: rgba(231, 76, 60, 0.1); border: 1px solid #e74c3c; color: #e74c3c; }

        /* === FOOTER (BARU - SESUAI GAMBAR) === */
        .footer {
            background: #ffffff;
            padding: 70px 60px 50px;
            color: #666666;
            font-family: var(--font-body);
        }
        .footer-content {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1.5fr 1.5fr;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Kolom 1: Brand */
        .footer-brand h2 {
            font-family: var(--font-heading);
            color: var(--gold-dark);
            font-size: 26px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .footer-brand p {
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 25px;
            padding-right: 20px;
        }
        .social-links { display: flex; gap: 15px; }
        .social-links a {
            width: 38px; height: 38px;
            border: 1px solid #e0ce9a;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: var(--gold-dark); font-size: 15px; transition: all 0.3s;
        }
        .social-links a:hover { background: var(--gold); color: #fff; border-color: var(--gold); }

        /* Titles Footer */
        .footer-title {
            color: var(--gold-dark);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }
        .footer-title::after {
            content: ''; position: absolute; bottom: -8px; left: 0;
            width: 30px; height: 2px; background: var(--gold);
        }

        /* Kolom 2: Quick Links */
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 15px; }
        .footer-links a { color: #666666; font-size: 14px; transition: color 0.3s; }
        .footer-links a:hover { color: var(--gold-dark); }

        /* Kolom 3: Customer Service */
        .cs-item {
            display: flex; align-items: flex-start; gap: 12px; margin-bottom: 20px;
            font-size: 14px; color: #666666;
        }
        .cs-item i { color: var(--gold-dark); font-size: 16px; margin-top: 4px; }
        .cs-item p { margin: 0; line-height: 1.6; }

        /* Kolom 4: Newsletter */
        .newsletter-text { font-size: 14px; line-height: 1.6; margin-bottom: 20px; }
        .newsletter-form { display: flex; width: 100%; }
        .newsletter-form input {
            flex: 1; padding: 12px 15px;
            border: 1px solid #eee; border-right: none;
            outline: none; font-family: var(--font-body); font-size: 14px;
            background: #fff; color: #333;
        }
        .newsletter-form button {
            background: var(--gold); color: #111;
            border: none; padding: 0 20px; cursor: none;
            transition: background 0.3s;
        }
        .newsletter-form button:hover { background: var(--gold-dark); }

        /* Footer Bottom (Black Bar) */
        .footer-bottom {
            background: #000000;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            position: relative;
        }
        .back-to-top {
            position: absolute;
            right: 40px;
            bottom: 15px;
            background: var(--gold);
            color: #000;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: none; font-size: 18px; transition: transform 0.3s;
        }
        .back-to-top:hover { transform: translateY(-5px); background: var(--gold-dark); }
    </style>
</head>
<body>

    <div class="custom-cursor"></div>
    <div class="cursor-dot"></div>

    <nav class="navbar">
        <div class="logo">
             <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="../Beranda/beranda.php" class="interactive">Beranda</a></li>
            <li><a href="../About-us/aboutus.php" class="interactive">About Us</a></li>
            <li><a href="#" class="interactive">Best Seller</a></li>
            <li><a href="../login_register/contact.php" class="interactive">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search interactive"></i>
            <i class="fas fa-shopping-cart interactive"></i>
            <a href="../login_register/profil.php" class="interactive"><i class="fas fa-user"></i></a>
        </div>
    </nav>

    <section class="auth-section">
        <div class="auth-container">
            <?php echo $pesan; ?>
            
            <div id="login-form">
                <div class="auth-header">
                    <h3>Welcome Back</h3>
                    <p>Silakan login ke akun Caymira kamu</p>
                </div>
                <form action="" method="POST">
                    <div class="form-group">
                        <i class="far fa-envelope"></i>
                        <input type="email" name="email" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="btn-auth interactive">Sign In</button>
                </form>
                <div class="auth-switch">
                    Belum punya akun? <span onclick="toggleForm()" class="interactive">Daftar Sekarang</span>
                </div>
            </div>

            <div id="register-form">
                <div class="auth-header">
                    <h3>Create Account</h3>
                    <p>Bergabunglah dengan Caymira Modest</p>
                </div>
                <form action="" method="POST">
                    <div class="form-group">
                        <i class="far fa-user"></i>
                        <input type="text" name="nama" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <i class="far fa-envelope"></i>
                        <input type="email" name="email" placeholder="Alamat Email" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Buat Password" required>
                    </div>
                    <button type="submit" name="register" class="btn-auth interactive">Sign Up</button>
                </form>
                <div class="auth-switch">
                    Sudah punya akun? <span onclick="toggleForm()" class="interactive">Login Di sini</span>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h2>caymiramodest</h2>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#" class="interactive"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="interactive"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="interactive"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">QUICK LINKS</h4>
                <ul class="footer-links">
                    <li><a href="index.php" class="interactive">Home</a></li>
                    <li><a href="#" class="interactive">About Us</a></li>
                    <li><a href="#" class="interactive">Collection</a></li>
                    <li><a href="#" class="interactive">Best Seller</a></li>
                    <li><a href="#" class="interactive">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">CUSTOMER SERVICE</h4>
                <div class="cs-item">
                    <i class="far fa-clock"></i>
                    <div>
                        <p>Monday - Saturday</p>
                        <p>10.00 - 17.00 WIB</p>
                    </div>
                </div>
                <div class="cs-item">
                    <i class="fas fa-phone-alt"></i>
                    <p>0895-7042-D0408</p>
                </div>
                <div class="cs-item">
                    <i class="far fa-envelope"></i>
                    <p>caymiramodest@gmail.com</p>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">NEWSLETTER</h4>
                <p class="newsletter-text">Dapatkan info terbaru & promo menarik dari Caymira Modest.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email" class="interactive">
                    <button type="submit" class="interactive"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </footer>
    
    <div class="footer-bottom">
        <p>&copy; Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        <button class="back-to-top interactive" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>

    <script>
        // Custom Cursor
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

        // Toggle Login/Register
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }
    </script>
</body>
</html>
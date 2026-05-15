<?php
session_start();
// Opsional: Jika ingin hanya user yang sudah login yang bisa akses contact
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* === VARIABEL WARNA === */
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
            overflow-x: hidden;
            cursor: none; 
        }
        a { text-decoration: none; color: inherit; cursor: none; }

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

        /* === NAVBAR (HEADER) === */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 1000; background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(203, 168, 90, 0.3);
        }
        .logo h2 { color: var(--gold); font-family: var(--font-heading); letter-spacing: 2px; }
        .nav-links { display: flex; gap: 40px; list-style: none; }
        .nav-links a { font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; transition: 0.3s; }
        .nav-links a:hover { color: var(--gold); }
        
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; transition: all 0.3s; cursor: none; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2); }
        .cart-icon { position: relative; display: flex; align-items: center; }

        /* === CONTACT CONTENT (SESUAI GAMBAR) === */
        .contact-container {
            padding: 150px 0 100px;
            text-align: center;
            min-height: 80vh;
        }
        .contact-container h1 {
            font-family: var(--font-heading);
            font-size: 48px;
            margin-bottom: 60px;
            letter-spacing: 2px;
        }
        .contact-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .contact-box {
            flex: 1;
            background: rgba(20, 30, 42, 0.5);
            border: 1px solid rgba(203, 168, 90, 0.2);
            padding: 60px 40px;
            border-radius: 4px;
            transition: 0.4s;
        }
        .contact-box:hover {
            border-color: var(--gold);
            background: rgba(20, 30, 42, 0.8);
            transform: translateY(-10px);
        }
        .contact-box h3 {
            font-family: var(--font-heading);
            font-size: 32px;
            color: var(--gold);
            margin-bottom: 15px;
        }
        .contact-box p {
            color: var(--text-light);
            font-size: 14px;
            opacity: 0.8;
        }

        /* BANNER BAWAH (SESUAI GAMBAR) */
        .bottom-banner {
            width: 100%;
            height: 400px;
            position: relative;
            background: linear-gradient(rgba(10, 22, 40, 0.4), rgba(10, 22, 40, 0.4)), 
                        url('https://images.unsplash.com/photo-1585432959315-d9342fd58eb6?q=80&w=2070&auto=format&fit=crop'); /* Ganti dengan gambar muslimah kamu */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 60px;
            margin-top: 50px;
        }
        .bottom-banner h2 {
            font-family: var(--font-heading);
            font-style: italic;
            font-size: 36px;
            color: #fff;
            font-weight: 400;
        }

        /* === FOOTER (SESUAI GAMBAR PUTIH) === */
        .footer {
            background: #ffffff;
            padding: 70px 60px 50px;
            color: #666666;
        }
        .footer-content {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1.5fr 1.5fr;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-brand h2 { font-family: var(--font-heading); color: var(--gold-dark); font-size: 26px; margin-bottom: 15px; }
        .footer-brand p { font-size: 14px; line-height: 1.8; margin-bottom: 25px; }
        .social-links { display: flex; gap: 15px; }
        .social-links a {
            width: 38px; height: 38px; border: 1px solid #e0ce9a; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold-dark); transition: 0.3s;
        }
        .social-links a:hover { background: var(--gold); color: #fff; }

        .footer-title { color: var(--gold-dark); font-size: 14px; font-weight: 600; letter-spacing: 2px; margin-bottom: 25px; position: relative; display: inline-block; }
        .footer-title::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 30px; height: 2px; background: var(--gold); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 15px; }
        .footer-links a { color: #666666; font-size: 14px; transition: 0.3s; }
        .footer-links a:hover { color: var(--gold-dark); }

        .cs-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 20px; font-size: 14px; }
        .cs-item i { color: var(--gold-dark); margin-top: 4px; }

        .newsletter-form { display: flex; width: 100%; margin-top: 20px; }
        .newsletter-form input {
            flex: 1; padding: 12px; border: 1px solid #eee; outline: none; font-size: 14px;
        }
        .newsletter-form button {
            background: var(--gold); color: #000; border: none; padding: 0 20px; transition: 0.3s;
        }

        .footer-bottom { background: #000; color: #fff; text-align: center; padding: 20px; font-size: 13px; }
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
            <li><a href="#" class="interactive">Best Seller</a></li>
            <li><a href="../login_register/contact.php" class="interactive" style="color: var(--gold);">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search interactive"></i>
            <div class="cart-icon interactive">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="profil.php" class="interactive"><i class="fas fa-user"></i></a>
        </div>
    </nav>

    <section class="contact-container">
        <h1 class="interactive">Lets Get In Touch</h1>
        
        <div class="contact-grid">
            <div class="contact-box interactive">
                <h3>Email</h3>
                <p>caymiramodest@gmail.com</p>
            </div>
            <div class="contact-box interactive">
                <h3>Contact</h3>
                <p>0895-7042-D0408</p>
            </div>
        </div>

        <div class="bottom-banner interactive">
            <h2>Fashion Muslimah Modern, Elegan, dan Syar'i</h2>
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
                    <li><a href="../Beranda/beranda.php" class="interactive">Home</a></li>
                    <li><a href="#" class="interactive">About Us</a></li>
                    <li><a href="#" class="interactive">Collection</a></li>
                    <li><a href="#" class="interactive">Best Seller</a></li>
                    <li><a href="contact.php" class="interactive">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">CUSTOMER SERVICE</h4>
                <div class="cs-item">
                    <i class="far fa-clock"></i>
                    <div><p>Monday - Saturday</p><p>10.00 - 17.00 WIB</p></div>
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
                <p>Dapatkan info terbaru & promo menarik dari Caymira Modest.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email" class="interactive">
                    <button type="submit" class="interactive"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </footer>
    
    <div class="footer-bottom">
        <p>&copy; Copyright 2025 Caymira Modest. All Rights Reserved.</p>
    </div>

    <script>
        // Custom Cursor
        const cursor = document.querySelector('.custom-cursor');
        const cursorDot = document.querySelector('.cursor-dot');
        const interactives = document.querySelectorAll('.interactive, a, button, i');

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
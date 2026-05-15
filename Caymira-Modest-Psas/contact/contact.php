<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caymira Modest - Contact</title>
    <link rel="stylesheet" href="stylecontact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    
    <style>
        
/* =========================================
   1. VARIABEL WARNA & GLOBAL
   ========================================= */
:root {
    --bg-dark: #0a1118;
    --bg-card: #141e2a;
    --gold: #d4af37;
    --gold-light: #f5eacf;
    --text-light: #ffffff;
    --text-muted: #a0aec0;
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Poppins', sans-serif;
}


/* Reset Dasar */
 main
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;

    font-family: var(--font-body), 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #0d1b2a; /* Mempertahankan warna biru gelap Anda */
    color: white;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s ease;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* =========================================
   2. CSS HEADER (NAVBAR BARU)
   ========================================= */
nav {
    padding: 4px 0;
    border-bottom: 1px solid rgba(228, 202, 114, 0.984);
}
.nav-right .navbar-extra a:hover {
    color: var(--gold);
}
.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo {
    display: flex;
    align-items: center;
}
.logo img {
    max-height: 68px; 
    width: auto;
    object-fit: contain;
}
.nav-links {
    display: flex;
    gap: 30px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.nav-links a:hover {
    color: var(--gold);
}
.nav-links a::after{
    content: '';
    display: block;
    padding-bottom: 0.5rem;
    border-bottom: 0.1rem solid var(--gold-light);
    transform: scaleX(0);
    transition: 0.2s linear;
}
.nav-links a:hover::after{
    transform: scaleX(0.5);
}
.nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-bar {

    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #0d1b2a; /* Warna biru gelap dasar */
    color: white;

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

/* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 5%;
    border-bottom: 1px solid #c5a059;
}

.logo {
    color: #c5a059;
    font-weight: bold;
    font-size: 1.2rem;
}
.logo img {
    width: 150px;   /* ubah sesuai selera */
    height: auto;
    display: block;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-size: 0.8rem;
    letter-spacing: 1px;
}

.search-bar {
    background: white;
    border-radius: 20px;
    padding: 2px 10px;
    margin-right: 15px;
}

.search-bar input {
    border: none;
    outline: none;
    width: 150px;
}

.search-bar i {
    color: #333;
}

/* Contact Hero */

.contact-hero {
    text-align: center;
    padding: 60px 20px;
}

.contact-hero h1 {
 
    font-family: var(--font-heading), serif;

    font-family: serif;
}

 .main {
    font-size: 3rem;
    margin-bottom: 40px;
    font-weight: 400;
}

.contact-cards {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.card {
    background-color: #1b263b;
    padding: 40px;
    width: 400px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.card h3 {
    font-family: var(--font-heading), serif;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.card p {
    color: #c5a059;
}



/* Banner */

.banner {
    display: flex;
    background-color: #d1ccc0;
    height: 300px;
    align-items: center;
}

.banner-text {
    flex: 2;
    color: #1b263b;
    padding-left: 5%;
}

.banner-text h2 {
    font-style: italic;
    font-family: var(--font-heading), serif;
    font-size: 2rem;
    font-weight: 400;
}

.banner-image {
    flex: 1;
    height: 100%;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.spacer {
    height: 150px;
    background-color: #0d1b2a;
}



footer {
    background-color: #ffffff;
    color: #333;
    padding: 50px 0 0 0;
    margin-top: 50px;
}
.footer-content {
    display: flex;
    justify-content: space-between;
    padding-bottom: 40px;
}
.footer-left {
    max-width: 400px;
}
.footer-img-logo {
    max-width: 150px;
    margin-bottom: 15px;
    display: block;
}
.footer-logo {
    font-family: var(--font-heading);
    font-size: 24px;
    color: var(--bg-dark); 
    font-weight: 600;
    margin-bottom: 15px;
}
.footer-left p {
    font-size: 12px;
    color: #666;
    margin-bottom: 20px;
}
.social-icons {
    display: flex;
    gap: 15px;
}
.social-icons i {
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s;
}
.social-icons i:hover {
    color: var(--gold);
}
.footer-right {
    text-align: right;
    font-size: 14px;
}
.footer-right h4 {
    margin-bottom: 10px;
}
.footer-right p {
    color: #666;
    margin-bottom: 15px;
}
.copyright {
    background-color: #000;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    font-size: 12px;
}

/* =========================================
   5. RESPONSIVE DESIGN (UNTUK HP)
   ========================================= */
@media (max-width: 768px) {
    .nav-links {
        display: none; /* Menyembunyikan link di hp agar tidak menumpuk */
    }
    .contact-cards {
        flex-direction: column;
        align-items: center;
    }
    .card {
        width: 90%;
    }
    .banner {
        flex-direction: column;
        height: auto;
        text-align: center;
    }
    .banner-text {
        padding: 30px;
    }
    .footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 30px;
    }
    .footer-right {
        text-align: center;
    }
}
/* Footer */
footer {
    background-color: white;
    color: black;
    padding: 40px 5% 10px 5%;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start; /* ini penting */
    flex-wrap: wrap;
}
.footer-brand {
    max-width: 400px;
}

.logo-footer {
    color: #c5a059;
    font-weight: bold;
    margin-bottom: 10px;
}
.footer-brand h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: black;
    letter-spacing: 1px;
}
.footer-brand p {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 20px;
    color: black;
}



.footer-brand p {
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 20px;
    color: black;
}

.social-icons i {
    font-size: 1.5rem;
    margin-right: 15px;
    cursor: pointer;
}

.footer-info {
    text-align: right;
    margin-top: 20px;
}

.info-group {
    margin-bottom: 25px;
}

.info-group h4 {
    margin-bottom: 8px;
    font-weight: bold;
}

.info-group p {
    line-height: 1.6;
}

.copyright {
    margin-top: 40px;
    border-top: 1px solid #ddd;
    padding-top: 10px;
    text-align: right;
    font-size: 0.8rem;
    background-color: black;
    color: white;
    margin-left: -5.5%; /* Menyeimbangkan padding footer */
    margin-right: -5.5%;
    padding-right: 5%;
}

    </style>
</head>
<body>

    <header>
        <div class="logo">
    <img src="gambar/image-removebg-preview.png" alt="Caymira Modest">
</div>
        <nav>
            <a href="#">HOME</a>
            <a href="#">ABOUT US</a>
            <a href="#">CONTACT</a>
            <a href="#">BEST SELLER</a>
        </nav>
        <div class="nav-icons">
            <span class="search-bar"><input type="text"><i class="fa fa-search"></i></span>
            <i class="fa fa-user"></i>
        </div>
 cabang_yepi
    </nav>
> main
    </header>

    <section class="contact-hero">
        <h1>Lets Get In Touch</h1>
        <div class="contact-cards">
            <div class="card">
                <h3>Email</h3>
                <p>caymiramodest@gmail.com</p>
            </div>
            <div class="card">
                <h3>Contact</h3>
                <p>0895-7042-00408</p>
            </div>
        </div>
    </section>

    <section class="banner">
        <div class="banner-text">
            <h2>Fashion Muslimah Modern, Elegan, dan Syar'i</h2>
        </div>
        <div class="banner-image">
            <img src="gambar/Screenshot 2026-04-26 192106.png" alt="Model Muslimah">
        </div>
    </section>

    <div class="spacer"></div>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                 <div class="logo">
                <img src="gambar/image-removebg-preview.png" alt="Caymira Modest">
                <h2>CAYMIRA MODEST</h2>
                <p>Caymira Modest — Toko baju muslim trendi dengan desain modern dan tetap syar'i. Tampil stylish setiap hari!</p>
                <div class="social-icons">
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/62895704200408" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
                </div>
            </div>
            <div class="footer-info">
                <div class="info-group">
                    <h4>Customer Service</h4>
                    <p>Monday to Saturday 10am - 9pm EST:</p>
                    <p>0895-7042-00408</p>
                </div>
                <div class="info-group">
                    <h4>Email us</h4>
                    <p>caymiramodest@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="copyright">
            ©Copyright 2025
        </div>
    </footer>

</body>
</html>
<?php
include '../detailproduk/koneksi.php'; 

$db_koneksi = isset($koneksi) ? $koneksi : (isset($conn) ? $conn : null);

if (!$db_koneksi) {
    die("Waduh, koneksi database gagal!");
}

$id_produk = isset($_GET['id']) ? mysqli_real_escape_string($db_koneksi, $_GET['id']) : '';
$kategori  = isset($_GET['kategori']) ? mysqli_real_escape_string($db_koneksi, $_GET['kategori']) : '';

// Data default jika gagal
$nama_produk = "Produk Tidak Ditemukan";
$harga_asli = 0;
$harga_diskon = 0;
$deskripsi = "Detail produk belum tersedia.";
$gambar_utama = "default.png";
$ulasan = rand(50, 200);

// Tambahkan semua kemungkinan nama tabel
$tabel_valid = ['koko', 'gamis', 'hijab', 'jubah', 'bestseller', 'best-seller', 'best_seller'];

if (!empty($id_produk) && in_array($kategori, $tabel_valid)) {
    
    $result = false;
    
    // HELM PELINDUNG (TRY-CATCH)
    try {
        // PLAN A: Cari pakai kolom 'id_produk' (Tabel Best Seller biasanya pakai ini)
        $query = "SELECT * FROM `$kategori` WHERE id_produk = '$id_produk'";
        $result = mysqli_query($db_koneksi, $query);
    } catch (Exception $e) {
        try {
            // PLAN B: Cari pakai kolom 'id' (Tabel Koko/Jubah biasanya pakai ini)
            $query = "SELECT * FROM `$kategori` WHERE id = '$id_produk'";
            $result = mysqli_query($db_koneksi, $query);
        } catch (Exception $e2) {
            $result = false; 
        }
    }
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $nama_produk = isset($row['nama_produk']) ? $row['nama_produk'] : 'Produk Caymira';
        $harga_asli = isset($row['harga_asli']) ? $row['harga_asli'] : (isset($row['harga_coret']) ? $row['harga_coret'] : 0);
        $harga_diskon = isset($row['harga_diskon']) ? $row['harga_diskon'] : (isset($row['harga']) ? $row['harga'] : 0);
        $deskripsi = isset($row['deskripsi']) ? $row['deskripsi'] : "Koleksi terbaik dengan desain elegan dan bahan premium.";
        
        if (isset($row['gambar'])) {
            $db_gambar = $row['gambar'];
            
            if (strpos($db_gambar, 'http') === 0) {
                $gambar_utama = $db_gambar;
            } elseif (strpos($db_gambar, 'gambar ') === 0) {
                $gambar_utama = '../best-seller/' . $db_gambar;
            } else {
                $gambar_utama = '../Beranda/Gambarberanda/' . $db_gambar;
            }
        }
        
        if(isset($row['total_ulasan'])) $ulasan = $row['total_ulasan'];
        if(isset($row['ulasan'])) $ulasan = $row['ulasan'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

/* === CUSTOM CURSOR === */
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

/* === NAVBAR === */
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

/* Breadcrumb */
.breadcrumb {
    padding: 100px 0 20px;
    font-size: 13px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 10px;
}
.breadcrumb a:hover { color: var(--gold); }
.breadcrumb i { font-size: 10px; color: var(--gold); }
.breadcrumb span:last-child { color: var(--gold); }

/* Product Detail Sections */
.product-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    padding: 20px 0 80px;
}
.main-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(201, 168, 76, 0.15);
    background: #0d1a2d;
}
.main-image {
    width: 100%;
    height: auto;
    object-fit: cover;
}

/* Info & Price */
.product-title {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--white);
    margin-bottom: 15px;
}
.price-section {
    margin: 30px 0;
}
.price-main {
    font-size: 36px;
    font-weight: 700;
    color: var(--gold);
}
.price-original {
    font-size: 18px;
    color: var(--text-muted);
    text-decoration: line-through;
    margin-left: 10px;
}

/* Guarantees */
.guarantee-row {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}
.guarantee-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(201, 168, 76, 0.05);
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
}

/* Colors & Sizes */
.section-label { font-weight: 600; margin-bottom: 10px; }
.color-options, .size-options { display: flex; gap: 10px; margin-bottom: 20px; }
.color-btn { width: 40px; height: 40px; border-radius: 50%; cursor: pointer; border: 2px solid transparent; }
.color-btn.active { border-color: var(--gold); }
.size-btn { padding: 10px 20px; border: 1px solid var(--gold); background: none; color: var(--gold); cursor: pointer; border-radius: 8px; }
.size-btn.active { background: var(--gold); color: var(--navy); }

/* Quantity */
.quantity-wrapper { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
.qty-input { width: 50px; text-align: center; background: none; border: 1px solid var(--gold); color: white; padding: 5px; }

/* Action Button */
.btn-buy {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: var(--navy);
    border: none;
    border-radius: 30px;
    font-weight: 700;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.3s;
}
.btn-buy:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(201, 168, 76, 0.3); }

/* Tabs */
.tab-header { display: flex; gap: 20px; border-bottom: 1px solid rgba(201, 168, 76, 0.2); margin-top: 40px; }
.tab-btn { background: none; border: none; color: var(--text-muted); padding: 10px; cursor: pointer; }
.tab-btn.active { color: var(--gold); border-bottom: 2px solid var(--gold); }
.tab-content { display: none; padding: 20px 0; }
.tab-content.active { display: block; }

/* === FOOTER (Update Sesuai Beranda) === */
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
.footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
.social-links { display: flex; gap: 12px; margin-top: 18px; }
.social-links a {
    width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: var(--gold); transition: all 0.3s; font-size: 14px;
}
.social-links a:hover { background: var(--gold); color: var(--navy); transform: translateY(-3px); }
.footer-title {
    color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px;
    text-transform: uppercase; margin-bottom: 22px; position: relative;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a { color: #888; font-size: 13px; transition: all 0.3s; }
.footer-links a:hover { color: var(--gold); padding-left: 5px; }
.contact-item { display: flex; gap: 10px; margin-bottom: 15px; color: #888; font-size: 13px; }
.contact-item i { color: var(--gold); }
.newsletter-form { display: flex; border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 4px; overflow: hidden; }
.newsletter-form input { flex: 1; padding: 12px; border: none; outline: none; background: transparent; }
.newsletter-form button { background: var(--gold); border: none; padding: 0 20px; cursor: pointer; }
.footer-bottom {
    text-align: center; padding: 35px 0; margin-top: 35px;
    border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px;
    color: #ffffff; background-color: #000000; margin-left: -60px; margin-right: -60px;
}

/* Scroll Top */
.scroll-top {
    position: fixed; bottom: 25px; right: 25px; width: 45px; height: 45px;
    background: var(--gold); color: var(--navy); border: none; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: 0.3s; z-index: 999;
}
.scroll-top.visible { opacity: 1; visibility: visible; }

/* Responsive */
@media (max-width: 768px) {
    .product-detail { grid-template-columns: 1fr; }
    .navbar { padding: 0 20px; }
    .footer-content { grid-template-columns: 1fr; }
}
    </style>
</head>
<body>

    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.php'">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
            <li><a href="../Contact/contact.php">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="window.location.href='../keranjang/keranjang.php'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
        </div>
    </nav>

    <!-- Product Detail -->
    <div class="container" style="padding-top: 100px;">
        <div class="breadcrumb">
            <a href="../Beranda/beranda.php">Beranda</a> <i class="fas fa-chevron-right"></i>
            <span><?php echo $nama_produk; ?></span>
        </div>

        <section class="product-detail">
            <div class="main-image-wrapper">
                <img src="<?php echo $gambar_utama; ?>" class="main-image" id="mainImage">
            </div>
            
            <div class="product-info">
                <h1 class="product-title"><?php echo $nama_produk; ?></h1>
                
                <div class="price-section">
                    <div class="price-main">
                        Rp <?php echo number_format($harga_diskon, 0, ',', '.'); ?>
                        <?php if($harga_asli > $harga_diskon): ?>
                            <span class="price-original">Rp <?php echo number_format($harga_asli, 0, ',', '.'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="guarantee-row">
                    <div class="guarantee-item"><i class="fas fa-shield-alt"></i> 100% Original</div>
                    <div class="guarantee-item"><i class="fas fa-truck"></i> Gratis Ongkir</div>
                </div>

                <div class="section-label">Pilih Ukuran</div>
                <div class="size-options">
                    <button class="size-btn">S</button>
                    <button class="size-btn active">M</button>
                    <button class="size-btn">L</button>
                    <button class="size-btn">XL</button>
                </div>

                <div class="quantity-wrapper">
                    <span>Kuantitas:</span>
                    <input type="number" value="1" class="qty-input" id="qtyInput">
                </div>

                <button class="btn-buy" onclick="buyNow('<?php echo $id_produk; ?>', '<?php echo addslashes($nama_produk); ?>', <?php echo $harga_diskon; ?>, '<?php echo $gambar_utama; ?>')">Beli Sekarang</button>
                
                <div class="tab-header">
                    <button class="tab-btn active" onclick="switchTab(this, 'desc')">Deskripsi</button>
                    <button class="tab-btn" onclick="switchTab(this, 'spec')">Spesifikasi</button>
                </div>
                <div id="desc" class="tab-content active"><p><?php echo $deskripsi; ?></p></div>
                <div id="spec" class="tab-content"><p>Bahan Premium, Jahitan Rapi, Nyaman dipakai seharian.</p></div>
            </div>
        </section>
    </div>

    <!-- FOOTER (SAMA DENGAN BERANDA) -->
    <footer class="footer" id="contact">
        <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4"/>
            <circle cx="100" cy="30" r="2" fill="#c9a84c" opacity="0.6"/><circle cx="110" cy="70" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="90" cy="110" r="2" fill="#c9a84c" opacity="0.7"/><circle cx="105" cy="150" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="95" cy="190" r="2" fill="#c9a84c" opacity="0.6"/><circle cx="115" cy="230" r="1.5" fill="#c9a84c" opacity="0.5"/><circle cx="85" cy="270" r="2" fill="#c9a84c" opacity="0.7"/>
        </svg>

        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                   <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height: 60px;">
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
                    <li><a href="../Beranda/beranda.php">Beranda</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item"><i class="far fa-clock"></i> Monday - Saturday (10.00 - 17.00 WIB)</div>
                <div class="contact-item"><i class="fas fa-phone"></i> 0895-7042-D0408</div>
                <div class="contact-item"><i class="far fa-envelope"></i> caymiramodest@gmail.com</div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Newsletter</h4>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="footer-bottom"><p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p></div>
    </footer>

    <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0, behavior:'smooth'})"><i class="fas fa-chevron-up"></i></button>

    <script>
        // Cursor & Navbar Script
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px'; cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px'; cursorDot.style.top = e.clientY - 3 + 'px';
        });

        window.addEventListener('scroll', () => {
            const st = document.getElementById('scrollTop');
            if(window.scrollY > 100) st.classList.add('visible'); else st.classList.remove('visible');
        });

        function switchTab(btn, id) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active'); document.getElementById(id).classList.add('active');
        }

        function buyNow(id, nama, harga, gambar) {
            let checkoutItems = [{ id, name: nama, price: harga, quantity: document.getElementById('qtyInput').value, image: gambar }];
            sessionStorage.setItem('caymira_checkout_data', JSON.stringify(checkoutItems));
            window.location.href = '../checkout/informasi.php';
        }

        function updateCartBadge() {
            let cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            let count = cart.reduce((t, i) => t + i.quantity, 0);
            const badge = document.getElementById('cartBadge');
            if(badge) { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
        }
        document.addEventListener('DOMContentLoaded', updateCartBadge);

        function showToast(m) { alert(m); }
    </script>
</body>
</html>
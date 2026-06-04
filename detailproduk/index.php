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
$deskripsi = "Deskripsi produk belum tersedia.";
$spesifikasi = "Spesifikasi belum tersedia.";
$pengiriman = "Pengiriman dikirim dari gudang pusat Caymira. Estimasi 2-3 hari kerja.";
$info_ulasan = "Belum ada ulasan tertulis untuk produk ini.";
$gambar_utama = "default.png";
$ulasan = rand(50, 200);

$tabel_valid = ['koko', 'gamis', 'hijab', 'jubah', 'bestseller', 'best-seller', 'best_seller'];

if (!empty($id_produk) && in_array($kategori, $tabel_valid)) {
    $result = false;
    try {
        $query = "SELECT * FROM `$kategori` WHERE id_produk = '$id_produk'";
        $result = mysqli_query($db_koneksi, $query);
    } catch (Exception $e) {
        try {
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
        
        $deskripsi = isset($row['deskripsi']) && !empty($row['deskripsi']) ? nl2br($row['deskripsi']) : "Deskripsi produk belum tersedia.";
        $spesifikasi = isset($row['spesifikasi']) && !empty($row['spesifikasi']) ? nl2br($row['spesifikasi']) : "Spesifikasi belum tersedia.";
        $pengiriman = isset($row['pengiriman']) && !empty($row['pengiriman']) ? nl2br($row['pengiriman']) : "Pengiriman dikirim dari gudang pusat Caymira. Estimasi 2-3 hari kerja.";
        $info_ulasan = isset($row['info_ulasan']) && !empty($row['info_ulasan']) ? nl2br($row['info_ulasan']) : "Belum ada ulasan tertulis untuk produk ini.";

       // === JURUS HYBRID DETEKSI GAMBAR (VERSI PHP) ===
        if (isset($row['gambar'])) {
            $db_gambar = $row['gambar'];
            
            if (empty($db_gambar)) {
                $gambar_utama = 'https://via.placeholder.com/400x600/0a1628/c9a84c?text=Foto';
            } elseif (strpos($db_gambar, 'http') === 0) {
                $gambar_utama = $db_gambar;
            } elseif (strpos($db_gambar, 'gambar ') === 0) {
                $gambar_utama = '../best-seller/' . $db_gambar;
            } else {
                // Nebak folder dari nama kategori atau nama bajunya
                $kat_cek = strtolower($kategori);
                $nama_cek = strtolower($nama_produk);
                
                if ($kat_cek == 'gamis' || strpos($nama_cek, 'gamis') !== false) {
                    $gambar_utama = '../Gamis/' . $db_gambar;
                } elseif ($kat_cek == 'koko' || strpos($nama_cek, 'koko') !== false) {
                    $gambar_utama = '../Koko/' . $db_gambar;
                } elseif ($kat_cek == 'hijab' || strpos($nama_cek, 'hijab') !== false || strpos($nama_cek, 'kerudung') !== false) {
                    $gambar_utama = '../hijab/' . $db_gambar;
                } elseif ($kat_cek == 'jubah' || strpos($nama_cek, 'jubah') !== false) {
                    $gambar_utama = '../Jubah/' . $db_gambar;
                } else {
                    $gambar_utama = '../Beranda/Gambarberanda/' . $db_gambar;
                }
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
        :root {
            --navy: #0a1628; --navy-light: #0f1d35; --gold: #c9a84c;
            --gold-light: #d4b76a; --text-light: #e8e8e8; --text-muted: #a0a0a0;
            --white: #ffffff; --font-heading: 'Playfair Display', serif; --font-body: 'Poppins', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--navy); color: var(--text-light); font-family: var(--font-body); line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: color 0.3s ease; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        
        /* Navbar */
        .navbar { position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(201, 168, 76, 0.6); }
        .logo-img { height: 75px; width: auto; object-fit: contain; margin-top: 5px; cursor:pointer; }
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { color: var(--text-light); font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; }
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; }
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        
        /* Breadcrumb & Detail */
        .breadcrumb { padding: 100px 0 20px; font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 10px; }
        .breadcrumb i { font-size: 10px; color: var(--gold); }
        .product-detail { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; padding: 20px 0 80px; }
        .main-image-wrapper { border-radius: 20px; overflow: hidden; border: 1px solid rgba(201, 168, 76, 0.15); }
        .main-image { width: 100%; height: auto; object-fit: cover; }
        
        /* Info */
        .product-title { font-family: var(--font-heading); font-size: 42px; color: var(--white); margin-bottom: 15px; }
        .price-main { font-size: 36px; font-weight: 700; color: var(--gold); margin: 20px 0; }
        .price-original { font-size: 18px; color: var(--text-muted); text-decoration: line-through; margin-left: 10px; }
        .price-discount { color: #2ecc71; margin-left: 10px; font-weight:bold; }
        .stars { color: var(--gold); }
        
        /* Variasi (Warna & Ukuran) */
        .section-label { font-weight: 600; margin-bottom: 10px; display: block; }
        .color-options { display: flex; gap: 15px; margin-bottom: 25px; }
        .color-btn { width: 35px; height: 35px; border-radius: 50%; cursor: pointer; border: 2px solid transparent; transition: 0.3s; }
        .color-btn.active { border-color: var(--gold); transform: scale(1.1); box-shadow: 0 0 10px rgba(201,168,76,0.5); }
        
        .size-options { display: flex; gap: 10px; margin-bottom: 25px; }
        .size-btn { padding: 8px 18px; border: 1px solid var(--gold); background: none; color: var(--gold); cursor: pointer; border-radius: 8px; transition: 0.3s; }
        .size-btn.active { background: var(--gold); color: var(--navy); }
        .size-btn:hover { background: rgba(201,168,76,0.2); }

        .quantity-wrapper { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
        .qty-input { width: 50px; text-align: center; background: none; border: 1px solid var(--gold); color: white; padding: 5px; border-radius: 5px;}
        
        /* Buttons */
        .action-buttons { display: flex; gap: 15px; margin-bottom: 30px;}
        .btn-buy { flex: 1; padding: 15px; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); border: none; border-radius: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; transition: 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;}
        .btn-cart { flex: 1; padding: 15px; background: transparent; color: var(--gold); border: 2px solid var(--gold); border-radius: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; transition: 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;}
        .btn-buy:hover, .btn-cart:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(201, 168, 76, 0.2); }
        .btn-cart:hover { background: var(--gold); color: var(--navy); }
        
        /* Tabs */
        .tab-header { display: flex; gap: 20px; border-bottom: 1px solid rgba(201, 168, 76, 0.2); margin-top: 20px; }
        .tab-btn { background: none; border: none; color: var(--text-muted); padding: 10px; cursor: pointer; font-size:14px;}
        .tab-btn.active { color: var(--gold); border-bottom: 2px solid var(--gold); }
        .tab-content { display: none; padding: 20px 0; color: #ccc;}
        .tab-content.active { display: block; }

        /* Toast */
        .toast { position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(100px); background: var(--gold); color: var(--navy); padding: 16px 32px; border-radius: 50px; font-weight: 500; font-size: 14px; opacity: 0; transition: all 0.4s; z-index: 10000; box-shadow: 0 8px 30px rgba(201, 168, 76, 0.4); display: flex; align-items: center; gap: 10px; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* Footer */
        .footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; margin-top: 50px; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; color:#666;}
        .footer-title { color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #888; font-size: 13px; }
        .contact-item { display: flex; gap: 10px; margin-bottom: 15px; color: #888; font-size: 13px; }
        .contact-item i { color: var(--gold); }
        .footer-bottom { text-align: center; padding: 30px 0; margin-top: 35px; background: #000; color: #fff; margin-left: -60px; margin-right: -60px; font-size: 12px;}
    </style>
</head>
<body>

    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

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
    

    <div class="container">
        <div class="breadcrumb">
            <a href="../Beranda/beranda.php">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:var(--gold);"><?php echo htmlspecialchars($nama_produk); ?></span>
        </div>
    </div>

    <section class="container product-detail">
        <div class="main-image-wrapper">
            <img src="<?php echo $gambar_utama; ?>" class="main-image" id="mainImage" alt="<?php echo $nama_produk; ?>">
        </div>
            
        <div class="product-info">
            <div class="product-brand" style="color:var(--text-muted); font-size:14px; margin-bottom:5px;">
                <i class="fas fa-certificate" style="color:var(--gold);"></i> Caymira Original
            </div>

            <h1 class="product-title"><?php echo htmlspecialchars($nama_produk); ?></h1>

            <div class="rating-row" style="display:flex; gap:10px; align-items:center; margin-bottom:10px;">
                <div class="stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <span style="color:var(--text-muted); font-size:14px;">(<?php echo $ulasan; ?> Ulasan)</span>
            </div>

            <div class="price-section">
                <div class="price-main">
                    Rp <?php echo number_format($harga_diskon, 0, ',', '.'); ?>
                    <?php if($harga_asli > $harga_diskon): ?>
                        <span class="price-original">Rp <?php echo number_format($harga_asli, 0, ',', '.'); ?></span>
                        <?php $persen = round((($harga_asli - $harga_diskon) / $harga_asli) * 100); ?>
                        <span class="price-discount">-<?php echo $persen; ?>%</span>
                    <?php endif; ?>
                </div>
            </div>

            <span class="section-label">Warna <span id="labelWarna" style="font-weight:normal; color:var(--text-muted);">- Hitam</span></span>
            <div class="color-options">
                <div class="color-btn active" style="background: #1a1a1a;" onclick="pilihWarna(this, 'Hitam')"></div>
                <div class="color-btn" style="background: #f5e6cc;" onclick="pilihWarna(this, 'Cream')"></div>
                <div class="color-btn" style="background: #7a5c58;" onclick="pilihWarna(this, 'Mocca')"></div>
            </div>

            <span class="section-label">Ukuran <span id="labelUkuran" style="font-weight:normal; color:var(--text-muted);">- M</span></span>
            <div class="size-options">
                <button class="size-btn" onclick="pilihUkuran(this, 'S')">S</button>
                <button class="size-btn active" onclick="pilihUkuran(this, 'M')">M</button>
                <button class="size-btn" onclick="pilihUkuran(this, 'L')">L</button>
                <button class="size-btn" onclick="pilihUkuran(this, 'XL')">XL</button>
            </div>

            <div class="quantity-wrapper">
                <span class="section-label" style="margin:0;">Jumlah:</span>
                <input type="number" value="1" min="1" max="10" class="qty-input" id="qtyInput">
            </div>

            <div class="action-buttons">
                <button class="btn-cart" onclick="masukkanKeranjang('<?php echo $id_produk; ?>', '<?php echo addslashes($nama_produk); ?>', <?php echo ($harga_diskon > 0) ? $harga_diskon : $harga_asli; ?>, '<?php echo $gambar_utama; ?>')">
                    <i class="fas fa-cart-plus"></i> Keranjang
                </button>
                <button class="btn-buy" onclick="beliSekarang('<?php echo $id_produk; ?>', '<?php echo addslashes($nama_produk); ?>', <?php echo ($harga_diskon > 0) ? $harga_diskon : $harga_asli; ?>, '<?php echo $gambar_utama; ?>')">
                    <i class="fas fa-shopping-bag"></i> Beli Sekarang
                </button>
            </div>
            
            <div class="tab-header">
                <button class="tab-btn active" onclick="switchTab(this, 'desc')">Deskripsi</button>
                <button class="tab-btn" onclick="switchTab(this, 'spec')">Spesifikasi</button>
                <button class="tab-btn" onclick="switchTab(this, 'shipping')">Pengiriman</button>
                <button class="tab-btn" onclick="switchTab(this, 'review')">Ulasan</button>
            </div>
            
            <div class="tab-content active" id="desc"><p><?php echo $deskripsi; ?></p></div>
            <div class="tab-content" id="spec"><p><?php echo $spesifikasi; ?></p></div>
            <div class="tab-content" id="shipping"><p><?php echo $pengiriman; ?></p></div>
            <div class="tab-content" id="review"><p><?php echo $info_ulasan; ?></p></div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" style="height:60px; margin-bottom:15px; cursor:pointer;" onclick="window.location.href='../Beranda/beranda.php'">
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Beranda</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item"><i class="far fa-clock"></i> Senin - Sabtu (10.00 - 17.00)</div>
                <div class="contact-item"><i class="fas fa-phone"></i> 0895-7042-D0408</div>
                <div class="contact-item"><i class="far fa-envelope"></i> caymiramodest@gmail.com</div>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Sosial Media</h4>
                <div class="contact-item"><i class="fab fa-instagram"></i> @caymiramodest</div>
                <div class="contact-item"><i class="fab fa-facebook"></i> Caymira Modest</div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© Copyright 2026 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        let selectedWarna = 'Hitam';
        let selectedUkuran = 'M';

        function pilihWarna(btn, warna) {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedWarna = warna;
            document.getElementById('labelWarna').innerText = "- " + warna;
        }

        function pilihUkuran(btn, ukuran) {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedUkuran = ukuran;
            document.getElementById('labelUkuran').innerText = "- " + ukuran;
        }

        function switchTab(btn, id) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active'); 
            document.getElementById(id).classList.add('active');
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastText').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function updateCartBadge() {
            let cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            let count = cart.reduce((total, item) => total + item.quantity, 0);
            const badge = document.getElementById('cartBadge');
            if(badge) { 
                badge.textContent = count; 
                badge.style.display = count > 0 ? 'flex' : 'none'; 
            }
        }

        // FUNGSI KERANJANG (BISA UPDATE OTOMATIS)
        function masukkanKeranjang(id, nama, harga, gambar) {
            let cart = JSON.parse(localStorage.getItem('caymira_cart')) || [];
            let qty = parseInt(document.getElementById('qtyInput').value) || 1;
            
            // Cek apakah baju dengan ID, Ukuran, dan Warna yang SAMA persis udah ada di keranjang
            let existingItem = cart.find(item => item.id === id && item.size === selectedUkuran && item.color === selectedWarna);
            
            if (existingItem) {
                existingItem.quantity += qty; // Kalau udah ada, tambahin jumlahnya aja
            } else {
                // Kalau beda ukuran/warna, masukin sebagai barang baru
                cart.push({ 
                    id: id, 
                    name: nama + " (" + selectedWarna + " - " + selectedUkuran + ")", 
                    price: parseInt(harga), 
                    quantity: qty, 
                    image: gambar,
                    size: selectedUkuran,
                    color: selectedWarna
                });
            }
            
            localStorage.setItem('caymira_cart', JSON.stringify(cart));
            updateCartBadge(); // Langsung update angka merah di Navbar!
            showToast("🛒 " + nama + " berhasil dimasukkan ke keranjang!");
        }

        // FUNGSI BELI LANGSUNG
        function beliSekarang(id, nama, harga, gambar) {
            let qty = parseInt(document.getElementById('qtyInput').value) || 1;
            let namaLengkap = nama + " (" + selectedWarna + " - " + selectedUkuran + ")";
            
            let checkoutItems = [{ 
                id: id, 
                name: namaLengkap, 
                price: parseInt(harga), 
                quantity: qty, 
                image: gambar,
                size: selectedUkuran,
                color: selectedWarna
            }];
            
            sessionStorage.setItem('caymira_checkout_data', JSON.stringify(checkoutItems));
            sessionStorage.setItem('caymira_checkout_jalur', 'beli_langsung');
            
            showToast("⚡ Meluncur ke kasir...");
            setTimeout(() => { window.location.href = '../checkout/informasi.php'; }, 800);
        }

        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>
</body>
</html>
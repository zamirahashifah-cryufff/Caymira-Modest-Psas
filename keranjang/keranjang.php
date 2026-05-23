<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Caymira Modest</title>
    <!-- Fonts Identik dengan Gamis.php -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <style>
        /* ===================== VARIABLES (Identik Gamis.php) ===================== */
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--navy);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* ===================== CUSTOM CURSOR ===================== */
        .custom-cursor { width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transition: transform 0.1s, background 0.3s; mix-blend-mode: difference; }
        .custom-cursor.hover { transform: scale(2); background: rgba(201, 168, 76, 0.2); }
        .cursor-dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; }

        /* ===================== NAVBAR (Identik Gamis.php) ===================== */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center; z-index: 1000;
            background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.6); transition: all 0.3s ease;
        }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .logo-img { height: 75px; width: auto; object-fit: contain; transition: all 0.3s; margin-top: 5px; cursor: pointer; }
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { color: var(--text-light); text-decoration: none; font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; position: relative; padding: 5px 0; transition: color 0.3s; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s; }
        .nav-links a:hover { color: var(--gold); }
        .nav-links a:hover::after { width: 100%; }
        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; transition: all 0.3s; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2); }
        .cart-icon { position: relative; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

        /* ===================== LAYOUT KERANJANG ===================== */
        .cart-page-header { margin-top: 120px; text-align: center; margin-bottom: 50px; }
        .cart-page-header h1 { color: var(--gold); font-size: 32px; font-family: 'Playfair Display', serif; }
        .cart-container { max-width: 1200px; margin: 0 auto 100px; padding: 0 40px; display: grid; grid-template-columns: 2fr 1.1fr; gap: 40px; align-items: start; }
        .cart-left { background: var(--navy-light); border: 1px solid rgba(201, 168, 76, 0.3); border-radius: 4px; overflow: hidden; }
        .cart-table-header { display: flex; background-color: var(--gold); color: var(--navy); padding: 15px 20px; font-weight: 700; }
        
        .cart-item { display: flex; align-items: center; padding: 20px; border-bottom: 1px solid rgba(201, 168, 76, 0.3); }
        .item-img-box { width: 90px; height: 120px; background: #000; border: 1px solid rgba(201, 168, 76, 0.4); overflow: hidden; }
        .item-img-box img { width: 100%; height: 100%; object-fit: cover; }
        .qty-box { display: flex; align-items: center; border: 1px solid rgba(201, 168, 76, 0.5); border-radius: 4px; }
        .qty-btn { background: transparent; border: none; color: white; padding: 5px 12px; cursor: pointer; }

        /* Voucher & Actions */
        .cart-bottom-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
        .voucher-box { display: flex; border: 1px solid rgba(201, 168, 76, 0.5); border-radius: 4px; overflow: hidden; }
        .voucher-box input { background: transparent; border: none; padding: 12px 15px; color: var(--text-light); outline: none; width: 180px; }
        .voucher-box button { background: var(--gold); border: none; color: var(--navy); padding: 0 25px; font-weight: 700; cursor: pointer; }

        /* Order Summary Box */
        .cart-right { border: 1px solid var(--gold); border-radius: 4px; padding: 25px; position: sticky; top: 100px; }
        .summary-title { color: var(--gold); font-size: 20px; font-weight: 700; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--gold); }
        .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid rgba(201, 168, 76, 0.4); }
        .circle-icon { width: 45px; height: 45px; border: 1px solid var(--gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 18px; }
        .checkout-btn { width: 100%; background: var(--gold); color: var(--navy); border: none; padding: 14px; border-radius: 4px; font-weight: 700; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 15px; transition: 0.3s; }
        .checkout-btn:hover { background: var(--gold-light); }

        /* ===================== FOOTER (Identik Gamis.php) ===================== */
        .footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; position: relative; color: #333; }
        .gold-branch-footer { position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a { width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); transition: all 0.3s; }
        .social-links a:hover { background: var(--gold); color: white; }
        .footer-title { color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; position: relative; }
        .footer-title::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px; background: var(--gold); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #666; text-decoration: none; font-size: 13px; transition: 0.3s; }
        .footer-links a:hover { color: var(--gold); padding-left: 5px; }
        .contact-item { display: flex; gap: 10px; margin-bottom: 15px; color: #666; font-size: 13px; }
        .contact-item i { color: var(--gold); margin-top: 3px; }
        .footer-bottom { text-align: center; padding: 35px 0; margin-top: 35px; border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px; color: #ffffff; background-color: #000000; margin-left: -60px; margin-right: -60px; }

        /* Toast */
        .toast { position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: var(--gold); color: var(--navy); padding: 10px 25px; border-radius: 30px; font-weight: 500; opacity: 0; transition: 0.4s; z-index: 10000; }
        .toast.show { opacity: 1; }

        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .footer-content { grid-template-columns: 1fr; }
            .cart-container { grid-template-columns: 1fr; }
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

    <div id="toast" class="toast">Pesan muncul di sini</div>

    <!-- Navbar (Identik dengan Gamis.php) -->
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
            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon" onclick="window.location.href='keranjang.php'" style="cursor: pointer;">

            <i class="fas fa-search"></i>
            <i class="fas fa-user"></i>
            <div class="cart-icon" onclick="location.reload()">

                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartBadge">0</span>
            </div>
        </div>
    </nav>

    <div class="cart-page-header">
        <h1>Shopping Cart</h1>
    </div>

    <!-- Konten Keranjang -->
    <div class="cart-container" id="cartContainer"></div>

    <!-- Footer (Identik dengan Gamis.php) -->
    <footer class="footer">
        <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4"/>
        </svg>

        <div class="footer-content">
            <div class="footer-brand">
                <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Logo" style="height:60px; margin-bottom:15px;">
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Beranda</a></li>
                    <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
                    <li><a href="../contact/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item"><i class="far fa-clock"></i><div>Mon - Sat: 10:00 - 17:00</div></div>
                <div class="contact-item"><i class="fas fa-phone"></i><div>0895-7042-D0408</div></div>
            </div>

            <div class="footer-col">
                <h4 class="footer-title">Newsletter</h4>
                <p style="font-size:12px; color:#666; margin-bottom:15px;">Dapatkan info koleksi & promo terbaru.</p>
                <div style="display:flex; border:1px solid #ccc; border-radius:4px; overflow:hidden;">
                    <input type="email" placeholder="Your email" style="border:none; padding:10px; flex:1;">
                    <button style="background:var(--gold); border:none; padding:0 15px;"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        let currentDiscount = 0;

        document.addEventListener("DOMContentLoaded", function () {
            renderCart();
            updateCartBadge();
            initCursor();
        });

        // --- Logic Cursor Identik Gamis.php ---
        function initCursor() {
            const cursor = document.getElementById('cursor');
            const cursorDot = document.getElementById('cursorDot');
            if (window.innerWidth > 768) {
                document.addEventListener('mousemove', (e) => {
                    cursor.style.left = e.clientX - 10 + 'px';
                    cursor.style.top = e.clientY - 10 + 'px';
                    cursorDot.style.left = e.clientX - 3 + 'px';
                    cursorDot.style.top = e.clientY - 3 + 'px';
                });
            }
        }

        // --- Logic Cart ---
        function getCart() { return JSON.parse(localStorage.getItem('caymira_cart')) || []; }
        function saveCart(cart) { localStorage.setItem('caymira_cart', JSON.stringify(cart)); updateCartBadge(); }
        function updateCartBadge() {
            const cart = getCart();
            document.getElementById('cartBadge').textContent = cart.reduce((t, item) => t + item.quantity, 0);
        }
        function formatRupiah(angka) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka); }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        function applyVoucher() {
            const code = document.getElementById('vCode').value.trim().toUpperCase();
            if (code === 'DISKON50K') {
                currentDiscount = 50000;
                showToast("✅ Diskon Rp 50.000 digunakan!");
                renderCart();
            } else {
                currentDiscount = 0;
                showToast("❌ Kode voucher salah.");
                renderCart();
            }
        }

        function renderCart() {
            const cart = getCart();
            const container = document.getElementById('cartContainer');
            if (cart.length === 0) {
                container.innerHTML = `<div class="empty-state" style="text-align:center; grid-column:1/-1;"><h3>Keranjang Kosong</h3><a href="../best-seller/best-seller.php" style="color:var(--gold);">Lanjut Belanja</a></div>`;
                return;
            }

            let itemsHTML = ''; let subtotal = 0; let totalQty = 0;
            cart.forEach((item, index) => {
                let itemTotal = item.price * item.quantity;
                subtotal += itemTotal; totalQty += item.quantity;

                // Smart Path Logic (Biar gambar Gamis & Best Seller muncul)
                let imgPath = item.image;

                if(!imgPath.includes('../')) {
                    imgPath = '../Gamis/' + imgPath; // Jika item dari Gamis
                    imgPath = '../Koko/'  + imgPath;
                    imgPath = '../Jubah/'  + imgPath;
                    imgPath = '../best-seller/'  + imgPath;

                if (!imgPath.startsWith('../')) {
                    const nameLower = item.name.toLowerCase();
                    if (nameLower.includes('gamis') && !imgPath.toLowerCase().includes('gamis')) {
                        imgPath = '../Gamis/' + imgPath;
                    } else if (!imgPath.toLowerCase().includes('best-seller')) {
                        imgPath = '../best-seller/' + imgPath;
                    } else { imgPath = '../' + imgPath; }

                }

                itemsHTML += `
                    <div class="cart-item">
                        <div style="flex:2; display:flex; align-items:center; gap:15px;">
                            <div class="item-img-box"><img src="${imgPath}" onerror="this.src='https://via.placeholder.com/90x120'"></div>
                            <div>
                                <div style="font-weight:600;">${item.name}</div>
                                <button onclick="removeItem(${index})" style="color:#ff4d4d; border:none; background:none; cursor:pointer; font-size:12px;">Hapus</button>
                            </div>
                        </div>
                        <div style="flex:1; text-align:center;">${formatRupiah(item.price)}</div>
                        <div style="flex:1; display:flex; justify-content:center;">
                            <div class="qty-box">
                                <button class="qty-btn" onclick="changeQty(${index}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button class="qty-btn" onclick="changeQty(${index}, 1)">+</button>
                            </div>
                        </div>
                        <div style="flex:1; text-align:right; color:var(--gold); font-weight:600;">${formatRupiah(itemTotal)}</div>
                    </div>
                `;
            });

            container.innerHTML = `
                <div class="cart-left-wrapper">
                    <div class="cart-left">
                        <div class="cart-table-header"><span style="flex:2;">Product</span><span style="flex:1; text-align:center;">Price</span><span style="flex:1; text-align:center;">Qty</span><span style="flex:1; text-align:right;">Total</span></div>
                        ${itemsHTML}
                    </div>
                    <div class="cart-bottom-actions">
                        <div class="voucher-box">
                            <input type="text" placeholder="Voucher Code" id="vCode" value="${currentDiscount > 0 ? 'DISKON50K' : ''}">
                            <button onclick="applyVoucher()">Apply</button>
                        </div>
                        <a href="#" onclick="clearCart()" style="color:white; font-size:14px;">Clear Cart</a>
                    </div>
                </div>
                <div class="cart-right">
                    <div class="summary-title">Order Summary</div>
                    <div class="summary-row">
                        <div style="display:flex; align-items:center; gap:10px;"><div class="circle-icon"><i class="fas fa-shopping-bag"></i></div> Items</div>
                        <div style="font-weight:600;">${totalQty}</div>
                    </div>
                    <div class="summary-row">
                        <div style="display:flex; align-items:center; gap:10px;"><div class="circle-icon"><i class="fas fa-ticket-alt"></i></div> Discount</div>
                        <div style="font-weight:600;">- ${formatRupiah(currentDiscount)}</div>
                    </div>
                    <div class="summary-row" style="border:none;">
                        <div style="display:flex; align-items:center; gap:10px; color:var(--gold); font-weight:700;"><div class="circle-icon"><i class="fas fa-wallet"></i></div> Total</div>
                        <div style="font-size:20px; font-weight:700;">${formatRupiah(subtotal - currentDiscount)}</div>
                    </div>
                    <button class="checkout-btn" onclick="alert('Checkout via WhatsApp?')"><i class="fas fa-shopping-basket"></i> Proceed to Checkout <i class="fas fa-caret-right"></i></button>
                </div>
            `;
        }

        function changeQty(index, delta) {
            let cart = getCart();
            if (cart[index].quantity + delta > 0) {
                cart[index].quantity += delta;
                saveCart(cart); renderCart();
            }
        }
        function removeItem(index) {
            let cart = getCart(); cart.splice(index, 1);
            saveCart(cart); renderCart();
        }
        function clearCart() {
            if(confirm("Kosongkan keranjang?")) { localStorage.removeItem('caymira_cart'); currentDiscount = 0; renderCart(); updateCartBadge(); }
        }

        function checkout(total) {
            let cart = getCart();
            
            // 1. Cek dulu apakah keranjang kosong
            if (cart.length === 0) {
                showToast("⚠️ Keranjang Anda masih kosong!");
                return;
            }

            // 2. Simpan total akhir dan diskon ke LocalStorage biar bisa dibaca di halaman informasi/pembayaran
            localStorage.setItem('caymira_grand_total', total);
            localStorage.setItem('caymira_discount', discountAmount);

            // 3. Efek loading sebentar biar elegan, lalu meluncur ke halaman Informasi
            const btn = document.querySelector('.checkout-btn');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                btn.style.opacity = '0.8';
                btn.style.cursor = 'wait';
            }
            sessionStorage.setItem('caymira_checkout_jalur', 'dari_keranjang');
    window.location.href = '../checkout/informasi.php';
            setTimeout(() => {
                // Arahkan ke halaman form informasi checkout kamu
                window.location.href = '../checkout/informasi.php';
            }, 800);
        }

        window.addEventListener("scroll", () => {
            const navbar = document.getElementById("navbar");
            if (window.scrollY > 50) navbar.classList.add("scrolled");
            else navbar.classList.remove("scrolled");
        });

    </script>
</body>
</html>
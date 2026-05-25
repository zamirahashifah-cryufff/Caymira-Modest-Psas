<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Caymira Modest</title>
    <!-- Fonts Identik Beranda -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   
    <style>
        /* === VARIABEL WARNA & FONT (Identik Beranda) === */
        :root {
            --navy: #0a1628;
            --navy-light: #0f1d35;
            --gold: #c9a84c;
            --gold-light: #d4b76a;
            --text-light: #e8e8e8;
            --text-muted: #a0a0a0;
            --white: #ffffff;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Poppins', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--navy); color: var(--text-light); font-family: var(--font-body); line-height: 1.6; }

        /* === NAVBAR (Identik Beranda) === */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 70px; padding: 0 60px;
            display: flex; justify-content: space-between; align-items: center; z-index: 1000;
            background: rgba(7, 13, 23, 0.98); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.6); transition: all 0.3s ease;
        }
        .logo-img { height: 75px; width: auto; object-fit: contain; margin-top: 5px; cursor: pointer; transition: all 0.3s; }
        .logo-img:hover { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201, 168, 76, 0.5)); }
        
        .nav-links { display: flex; gap: 45px; list-style: none; }
        .nav-links a { color: var(--text-light); text-decoration: none; font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; position: relative; padding: 5px 0; transition: color 0.3s; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s; }
        .nav-links a:hover { color: var(--gold); }
        .nav-links a:hover::after { width: 100%; }

        .nav-icons { display: flex; gap: 25px; align-items: center; }
        .nav-icons i { font-size: 18px; color: var(--text-light); cursor: pointer; transition: all 0.3s; }
        .nav-icons i:hover { color: var(--gold); transform: scale(1.2); }
        .cart-icon { position: relative; display: flex; align-items: center; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

        /* === KERANJANG CONTENT === */
        .cart-header-section { padding-top: 130px; text-align: center; padding-bottom: 50px; }
        .cart-header-section h1 { font-family: var(--font-heading); font-size: 42px; color: var(--gold); margin-bottom: 10px; }
        
        .cart-container { max-width: 1200px; margin: 0 auto 100px; padding: 0 20px; display: grid; grid-template-columns: 1fr 380px; gap: 30px; }
        
        /* Table Style */
        .cart-table-head { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; background: var(--gold); color: var(--navy); padding: 15px; font-weight: 700; border-radius: 4px; }
        .cart-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; padding: 20px 15px; align-items: center; border-bottom: 1px solid rgba(201, 168, 76, 0.2); background: rgba(255,255,255,0.02); }
        
        .product-info { display: flex; gap: 15px; align-items: center; }
        .product-img { width: 80px; height: 105px; object-fit: cover; border: 1px solid var(--gold); border-radius: 4px; }
        .product-details h4 { font-size: 16px; color: var(--white); font-family: var(--font-heading); }
        .product-details p { font-size: 11px; color: var(--text-muted); margin: 5px 0; }

        /* Qty Control */
        .qty-control { display: flex; align-items: center; border: 1px solid var(--gold); border-radius: 4px; width: fit-content; overflow: hidden; }
        .qty-control button { background: none; border: none; color: white; padding: 5px 12px; cursor: pointer; transition: 0.3s; }
        .qty-control button:hover { background: var(--gold); color: var(--navy); }
        .qty-control span { padding: 0 10px; font-weight: bold; }

        /* Sidebar Summary */
        .order-summary { border: 1px solid var(--gold); padding: 25px; border-radius: 8px; background: rgba(255,255,255,0.02); height: fit-content; }
        .order-summary h3 { color: var(--gold); font-family: var(--font-heading); font-size: 24px; margin-bottom: 25px; border-bottom: 1px solid rgba(201, 168, 76, 0.3); padding-bottom: 10px; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .summary-label { display: flex; align-items: center; gap: 12px; }
        .icon-circle { width: 40px; height: 40px; border: 1px solid var(--gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); }
        .btn-checkout { width: 100%; background: var(--gold); color: var(--navy); border: none; padding: 15px; border-radius: 4px; font-weight: bold; font-size: 16px; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 10px; transition: 0.3s; margin-top: 10px; }
        .btn-checkout:hover { background: var(--gold-light); transform: translateY(-2px); }

        /* Actions */
        .cart-actions { margin-top: 25px; display: flex; justify-content: space-between; align-items: center; }
        .voucher-box { display: flex; gap: 10px; }
        .voucher-box input { background: transparent; border: 1px solid var(--gold); padding: 10px; color: white; border-radius: 4px; outline: none; }
        .btn-apply { background: var(--gold); border: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; cursor: pointer; }

        /* === FOOTER (Identik Beranda) === */
        .footer { background: #ffffff; border-top: 1px solid rgba(201, 168, 76, 0.15); padding: 50px 60px 30px; position: relative; margin-top: 50px; color: #333; }
        .gold-branch-footer { position: absolute; left: -30px; top: -70px; width: 200px; opacity: 0.5; pointer-events: none; }
        .footer-content { display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr; gap: 35px; max-width: 1300px; margin: 0 auto; }
        .footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
        .social-links { display: flex; gap: 12px; margin-top: 18px; }
        .social-links a { width: 36px; height: 36px; border: 1px solid rgba(201, 168, 76, 0.35); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); transition: all 0.3s; }
        .social-links a:hover { background: var(--gold); color: white; transform: translateY(-3px); }
        .footer-title { color: var(--gold); font-size: 13px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 22px; position: relative; display: inline-block; }
        .footer-title::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 35px; height: 2px; background: var(--gold); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #666; text-decoration: none; font-size: 13px; transition: all 0.3s; }
        .footer-links a:hover { color: var(--gold); padding-left: 5px; }
        .contact-item { display: flex; gap: 10px; margin-bottom: 15px; color: #666; font-size: 13px; }
        .contact-item i { color: var(--gold); margin-top: 3px; }
        .footer-bottom { text-align: center; padding: 35px 0; margin-top: 35px; border-top: 1px solid rgba(201, 168, 76, 0.15); font-size: 12px; color: #ffffff; background-color: #000000; margin-left: -60px; margin-right: -60px; }

        /* Custom Cursor (Identik Beranda) */
        .custom-cursor { width: 20px; height: 20px; border: 2px solid var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transition: transform 0.1s; mix-blend-mode: difference; }
        .cursor-dot { width: 6px; height: 6px; background: var(--gold); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; }

        @media (max-width: 992px) {
            .cart-container { grid-template-columns: 1fr; }
            .navbar { padding: 0 20px; }
            .footer-content { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Custom Cursor -->
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
            <li><a href="../contact/contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartBadge">0</span>
            </div>
        </div>
    </nav>

    <div class="cart-header-section">
        <h1>Shopping Cart</h1>
        <p>Review your selected items before checkout</p>
    </div>

    <!-- Main Content -->
    <div class="cart-container">
        <div class="cart-left">
            <div class="cart-table-head">
                <div>Product</div>
                <div style="text-align: center;">Price</div>
                <div style="text-align: center;">Quantity</div>
                <div style="text-align: center;">Subtotal</div>
            </div>
            <div id="cartItemsList"></div>

            <div class="cart-actions">
                <div class="voucher-box">
                    <input type="text" placeholder="Voucher Code" id="vCode">
                    <button class="btn-apply" onclick="applyVoucher()">Apply Voucher</button>
                </div>
                <a href="javascript:void(0)" onclick="clearCart()" style="color:var(--text-muted); font-size:14px; text-decoration:none;">Clear Shopping Cart</a>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <div class="summary-label">
                    <div class="icon-circle"><i class="fas fa-shopping-bag"></i></div>
                    <span>Items</span>
                </div>
                <span id="summaryQty" style="font-weight: bold;">0</span>
            </div>
            <div class="summary-row">
                <div class="summary-label">
                    <div class="icon-circle"><i class="fas fa-file-invoice-dollar"></i></div>
                    <span>Sub Total</span>
                </div>
                <span id="summarySubtotal" style="font-weight: bold;">Rp 0</span>
            </div>
            <div class="summary-row">
                <div class="summary-label">
                    <div class="icon-circle"><i class="fas fa-percentage"></i></div>
                    <span>Discount</span>
                </div>
                <span id="summaryDiscount" style="font-weight: bold; color: #ff4d4d;">- Rp 0</span>
            </div>
            <div class="summary-row" style="margin-top: 25px; border-top: 1px solid rgba(201,168,76,0.3); padding-top: 20px;">
                <div class="summary-label">
                    <div class="icon-circle" style="background: var(--gold); color: var(--navy);"><i class="fas fa-wallet"></i></div>
                    <span style="font-size: 18px; font-weight: bold; color: var(--gold);">Total</span>
                </div>
                <span id="summaryGrandTotal" style="font-size: 20px; font-weight: bold;">Rp 0</span>
            </div>
            <button class="btn-checkout" onclick="checkout()">
                <i class="fas fa-shopping-basket"></i> Proceed to Checkout <i class="fas fa-caret-right"></i>
            </button>
        </div>
    </div>

    <!-- Footer Identik Beranda -->
    <footer class="footer">
        <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
            <path d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0" stroke="#c9a84c" stroke-width="1" fill="none" opacity="0.4"/>
        </svg>

        <div class="footer-content">
            <div class="footer-brand">
                <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Logo" style="height:65px; margin-bottom:15px;">
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
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
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
                    <input type="email" placeholder="Your email" style="border:none; padding:10px; flex:1; outline:none;">
                    <button style="background:var(--gold); border:none; padding:0 15px; cursor:pointer;"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© Copyright 2025 Caymira Modest. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        let discount = 0;

        document.addEventListener("DOMContentLoaded", function () {
            renderCart();
            updateBadge();
            // Mouse Cursor Logic
            const cursor = document.getElementById('cursor');
            const cursorDot = document.getElementById('cursorDot');
            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX - 10 + 'px';
                cursor.style.top = e.clientY - 10 + 'px';
                cursorDot.style.left = e.clientX - 3 + 'px';
                cursorDot.style.top = e.clientY - 3 + 'px';
            });
        });

        function getCart() { return JSON.parse(localStorage.getItem('caymira_cart')) || []; }
        function saveCart(cart) { localStorage.setItem('caymira_cart', JSON.stringify(cart)); renderCart(); updateBadge(); }
        function updateBadge() {
            const cart = getCart();
            document.getElementById('cartBadge').textContent = cart.reduce((t, item) => t + item.quantity, 0);
        }
        function formatRupiah(num) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(num); }

        function changeQty(index, delta) {
            let cart = getCart();
            if(cart[index].quantity + delta > 0) {
                cart[index].quantity += delta;
                saveCart(cart);
            }
        }

        function clearCart() { if(confirm('Kosongkan keranjang?')) { localStorage.removeItem('caymira_cart'); renderCart(); updateBadge(); } }

        function applyVoucher() {
            const code = document.getElementById('vCode').value.toUpperCase();
            if(code === 'DISKON50') { discount = 50000; alert('Voucher Berhasil!'); } 
            else { discount = 0; alert('Voucher Tidak Valid'); }
            renderCart();
        }

        function renderCart() {
            const cart = getCart();
            const list = document.getElementById('cartItemsList');
            let subtotal = 0; let totalQty = 0;

            if (cart.length === 0) {
                list.innerHTML = '<div style="padding:50px; text-align:center; opacity:0.5;">Keranjang Anda Kosong.</div>';
                document.getElementById('summaryQty').textContent = '0';
                document.getElementById('summarySubtotal').textContent = 'Rp 0';
                document.getElementById('summaryGrandTotal').textContent = 'Rp 0';
                return;
            }

            list.innerHTML = cart.map((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                totalQty += item.quantity;

                // Path Gambar Cerdas
                let path = item.image;
                if(!path.includes('../')) {
                    if(item.name.toLowerCase().includes('gamis')) path = '../Gamis/' + path;
                    else if(item.name.toLowerCase().includes('koko')) path = '../Koko/' + path;
                    else path = '../best-seller/' + path;
                }

                return `
                    <div class="cart-item">
                        <div class="product-info">
                            <img src="${path}" class="product-img" onerror="this.src='https://via.placeholder.com/80x105'">
                            <div class="product-details">
                                <h4>${item.name}</h4>
                                <p>Premium Quality</p>
                                <span style="font-size:9px; border:1px solid #c9a84c; padding:1px 4px; color:#c9a84c; border-radius:2px;">Color</span>
                                <span style="font-size:9px; border:1px solid #c9a84c; padding:1px 4px; color:#c9a84c; border-radius:2px;">Size</span>
                            </div>
                        </div>
                        <div style="text-align:center;">${formatRupiah(item.price)}</div>
                        <div style="display:flex; justify-content:center;">
                            <div class="qty-control">
                                <button onclick="changeQty(${index}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button onclick="changeQty(${index}, 1)">+</button>
                            </div>
                        </div>
                        <div style="text-align:center; color:var(--gold); font-weight:bold;">${formatRupiah(itemTotal)}</div>
                    </div>
                `;
            }).join('');

            document.getElementById('summaryQty').textContent = totalQty;
            document.getElementById('summarySubtotal').textContent = formatRupiah(subtotal);
            document.getElementById('summaryDiscount').textContent = '- ' + formatRupiah(discount);
            document.getElementById('summaryGrandTotal').textContent = formatRupiah(subtotal - discount);
        }

        function checkout() {
            if(getCart().length === 0) return alert('Keranjang kosong!');
            sessionStorage.setItem('caymira_checkout_jalur', 'dari_keranjang');
            window.location.href = '../checkout/informasi.php';
        }
    </script>
</body>
</html>
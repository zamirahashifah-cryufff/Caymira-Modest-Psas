
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === RESET & GLOBAL === */
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
    background-color: var(--navy);
    color: var(--text-light);
    font-family: var(--font-body);
    line-height: 1.6;
    overflow-x: hidden;
}
a { text-decoration: none; color: inherit; transition: var(--transition); }
img { max-width: 100%; height: auto; display: block; }
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
    width: 20px; height: 20px;
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
    width: 6px; height: 6px;
    background: var(--gold);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 99999;
}
@media (max-width: 768px) {
    .custom-cursor, .cursor-dot { display: none; }
}

/* === LOADING SCREEN === */
.loader {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: var(--navy);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    transition: opacity 0.6s, visibility 0.6s;
}
.loader.hidden {
    opacity: 0;
    visibility: hidden;
}
.loader-text {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--gold);
    animation: loaderPulse 1.5s ease-in-out infinite;
}
.loader-bar {
    width: 200px; height: 2px;
    background: rgba(201, 168, 76, 0.2);
    margin-top: 30px;
    border-radius: 2px;
    overflow: hidden;
}
.loader-progress {
    height: 100%;
    background: var(--gold);
    width: 0%;
    animation: loadProgress 2s ease forwards;
}
@keyframes loaderPulse {
    0%, 100% { opacity: 0.4; letter-spacing: 2px; }
    50% { opacity: 1; letter-spacing: 8px; }
}
@keyframes loadProgress {
    0% { width: 0%; }
    100% { width: 100%; }
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
    transition: var(--transition);
}
.navbar.scrolled {
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.logo-img {
    height: 75px;
    width: auto;
    object-fit: contain;
    transition: var(--transition);
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
    bottom: -4px; left: 0;
    width: 0; height: 2px;
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
    transition: var(--transition);
    position: relative;
}
.nav-icons i:hover {
    color: var(--gold);
    transform: scale(1.2) rotate(5deg);
}
.cart-icon { position: relative; display: flex; align-items: center; }
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
.mobile-menu-btn {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    z-index: 1001;
    padding: 5px;
}
.mobile-menu-btn span {
    width: 24px; height: 2px;
    background: var(--gold);
    transition: var(--transition);
    border-radius: 2px;
}
.mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
.mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

/* === CHECKOUT HERO / HEADER === */
.checkout-header {
    margin-top: 70px;
    padding: 60px 0 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.checkout-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at 50% 0%, rgba(201, 168, 76, 0.08) 0%, transparent 60%);
    pointer-events: none;
}
.checkout-header h1 {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--gold);
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}
.checkout-header p {
    color: var(--text-muted);
    font-size: 15px;
    position: relative;
    z-index: 1;
}

/* === PROGRESS STEPS === */
.progress-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    margin-bottom: 50px;
    position: relative;
    z-index: 1;
}
.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    position: relative;
}
.step-circle {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 2px solid rgba(201, 168, 76, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    color: var(--text-muted);
    background: var(--navy);
    transition: var(--transition);
    position: relative;
    z-index: 2;
}
.step.active .step-circle {
    border-color: var(--gold);
    background: var(--gold);
    color: var(--navy);
    box-shadow: 0 0 20px rgba(201, 168, 76, 0.4);
}
.step.completed .step-circle {
    border-color: var(--gold);
    background: var(--gold);
    color: var(--navy);
}
.step-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    font-weight: 500;
    transition: var(--transition);
}
.step.active .step-label {
    color: var(--gold);
}
.step.completed .step-label {
    color: var(--gold-light);
}
.step-line {
    width: 100px;
    height: 2px;
    background: rgba(201, 168, 76, 0.2);
    margin: 0 15px;
    position: relative;
    top: -22px;
    transition: var(--transition);
}
.step-line.completed {
    background: var(--gold);
}
@media (max-width: 768px) {
    .step-line { width: 40px; margin: 0 8px; }
    .checkout-header h1 { font-size: 28px; }
    .step-label { font-size: 10px; letter-spacing: 1px; }
}

/* === MAIN CHECKOUT LAYOUT === */
.checkout-main {
    padding-bottom: 80px;
}
.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 40px;
    align-items: start;
}
@media (max-width: 1024px) {
    .checkout-grid { grid-template-columns: 1fr; }
}

/* === CARD COMPONENT === */
.checkout-card {
    background: var(--bg-card);
    border: 1px solid rgba(201, 168, 76, 0.12);
    border-radius: 20px;
    padding: 35px;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.checkout-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.05) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.5s;
    pointer-events: none;
}
.checkout-card:hover::before {
    opacity: 1;
}
.checkout-card:hover {
    border-color: rgba(201, 168, 76, 0.25);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
.card-title {
    font-family: var(--font-heading);
    font-size: 22px;
    color: var(--gold);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 1;
}
.card-title i {
    font-size: 18px;
    color: var(--gold);
    opacity: 0.8;
}
.card-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, rgba(201, 168, 76, 0.3), transparent);
    margin-left: 10px;
}

/* === FORM STYLES === */
.form-group {
    margin-bottom: 24px;
    position: relative;
    z-index: 1;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
}
.form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-muted);
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    transition: var(--transition);
}
.form-group:focus-within .form-label {
    color: var(--gold);
}
.form-input {
    width: 100%;
    padding: 14px 18px;
    background: rgba(201, 168, 76, 0.05);
    border: 1.5px solid rgba(201, 168, 76, 0.15);
    border-radius: 12px;
    color: var(--text-light);
    font-family: var(--font-body);
    font-size: 14px;
    transition: var(--transition);
    outline: none;
}
.form-input::placeholder {
    color: rgba(160, 160, 160, 0.5);
}
.form-input:hover {
    border-color: rgba(201, 168, 76, 0.3);
    background: rgba(201, 168, 76, 0.08);
}
.form-input:focus {
    border-color: var(--gold);
    background: rgba(201, 168, 76, 0.08);
    box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.1);
}
.form-input.error {
    border-color: #e74c3c;
    box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
}
.error-text {
    font-size: 12px;
    color: #e74c3c;
    margin-top: 6px;
    display: none;
}
.error-text.show { display: block; }

/* === TEXTAREA === */
textarea.form-input {
    min-height: 100px;
    resize: vertical;
}

/* === SELECT === */
.select-wrapper {
    position: relative;
}
.select-wrapper::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gold);
    pointer-events: none;
    font-size: 14px;
}
select.form-input {
    appearance: none;
    padding-right: 45px;
    cursor: pointer;
}

/* === ORDER SUMMARY === */
.order-item {
    display: flex;
    gap: 18px;
    padding: 18px 0;
    border-bottom: 1px solid rgba(201, 168, 76, 0.1);
    position: relative;
    z-index: 1;
    transition: var(--transition);
}
.order-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.order-item:first-child {
    padding-top: 0;
}
.order-item:hover {
    transform: translateX(5px);
}
.order-img {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid rgba(201, 168, 76, 0.2);
    background: rgba(201, 168, 76, 0.05);
    flex-shrink: 0;
}
.order-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.order-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 4px;
    line-height: 1.4;
}
.order-variant {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 8px;
}
.order-price {
    font-size: 15px;
    font-weight: 600;
    color: var(--gold);
}
.qty-control {
    display: inline-flex;
    align-items: center;
    gap: 0;
    border: 1px solid rgba(201, 168, 76, 0.2);
    border-radius: 8px;
    overflow: hidden;
    margin-top: 8px;
    width: fit-content;
}
.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: rgba(201, 168, 76, 0.1);
    color: var(--gold);
    cursor: pointer;
    font-size: 13px;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}
.qty-btn:hover {
    background: var(--gold);
    color: var(--navy);
}
.qty-value {
    width: 32px;
    text-align: center;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-light);
}

/* === PRICING === */
.pricing-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    font-size: 14px;
    position: relative;
    z-index: 1;
}
.pricing-row:not(:last-child) {
    border-bottom: 1px dashed rgba(201, 168, 76, 0.15);
}
.pricing-label {
    color: var(--text-muted);
}
.pricing-value {
    color: var(--text-light);
    font-weight: 500;
}
.pricing-value.gold {
    color: var(--gold);
    font-weight: 600;
}
.pricing-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201, 168, 76, 0.3), transparent);
    margin: 15px 0;
}
.pricing-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    position: relative;
    z-index: 1;
}
.pricing-total-label {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-light);
}
.pricing-total-value {
    font-family: var(--font-heading);
    font-size: 26px;
    color: var(--gold);
    font-weight: 700;
}

/* === PAYMENT METHODS === */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
    z-index: 1;
}
.payment-option {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px 18px;
    background: rgba(201, 168, 76, 0.05);
    border: 1.5px solid rgba(201, 168, 76, 0.15);
    border-radius: 14px;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
}
.payment-option:hover {
    border-color: rgba(201, 168, 76, 0.3);
    background: rgba(201, 168, 76, 0.08);
    transform: translateX(5px);
}
.payment-option.selected {
    border-color: var(--gold);
    background: rgba(201, 168, 76, 0.12);
    box-shadow: 0 0 20px rgba(201, 168, 76, 0.1);
}
.payment-radio {
    width: 20px; height: 20px;
    border: 2px solid rgba(201, 168, 76, 0.4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--transition);
}
.payment-option.selected .payment-radio {
    border-color: var(--gold);
    background: var(--gold);
}
.payment-radio i {
    font-size: 10px;
    color: var(--navy);
    opacity: 0;
    transition: var(--transition);
}
.payment-option.selected .payment-radio i {
    opacity: 1;
}
.payment-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(201, 168, 76, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--gold);
    flex-shrink: 0;
}
.payment-info {
    flex: 1;
}
.payment-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 2px;
}
.payment-desc {
    font-size: 12px;
    color: var(--text-muted);
}

/* === CHECKOUT BUTTON === */
.btn-checkout {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    border: none;
    border-radius: 14px;
    color: var(--navy);
    font-family: var(--font-body);
    font-size: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 25px;
    position: relative;
    overflow: hidden;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-checkout::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.btn-checkout:hover::before {
    left: 100%;
}
.btn-checkout:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
}
.btn-checkout:active {
    transform: translateY(0);
}
.btn-checkout i {
    transition: transform 0.3s;
}
.btn-checkout:hover i {
    transform: translateX(5px);
}
.btn-checkout:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* === SECURITY BADGE === */
.security-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 18px;
    font-size: 12px;
    color: var(--text-muted);
    position: relative;
    z-index: 1;
}
.security-badge i {
    color: var(--gold);
    font-size: 14px;
}

/* === FOOTER === */
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
.footer-brand .logo-main {
    font-family: var(--font-heading);
    font-size: 22px;
    color: var(--gold);
    font-weight: 600;
    margin-bottom: 3px;
}
.footer-brand .logo-sub {
    font-size: 9px;
    color: var(--gold);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.footer-brand p {
    font-size: 12px;
    line-height: 1.8;
    color: #666;
    max-width: 230px;
}
.social-links {
    display: flex;
    gap: 12px;
    margin-top: 18px;
}
.social-links a {
    width: 36px; height: 36px;
    border: 1px solid rgba(201, 168, 76, 0.35);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    text-decoration: none;
    transition: var(--transition);
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
.social-links a:hover::before {
    transform: scale(1);
}
.social-links a:hover {
    color: var(--navy);
    transform: translateY(-3px);
}
.social-links a i {
    position: relative;
    z-index: 1;
}
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
    bottom: -8px; left: 0;
    width: 35px; height: 2px;
    background: var(--gold);
    transition: width 0.3s;
}
.footer-col:hover .footer-title::after {
    width: 100%;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a {
    color: #888;
    text-decoration: none;
    font-size: 13px;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.footer-links a::before {
    content: '→';
    color: var(--gold);
    opacity: 0;
    transform: translateX(-10px);
    transition: var(--transition);
}
.footer-links a:hover {
    color: var(--gold);
    transform: translateX(4px);
}
.footer-links a:hover::before {
    opacity: 1;
    transform: translateX(0);
}
.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 15px;
    color: #888;
    font-size: 13px;
    transition: var(--transition);
    cursor: pointer;
}
.contact-item:hover {
    color: var(--gold);
    transform: translateX(5px);
}
.contact-item i {
    color: var(--gold);
    margin-top: 3px;
    font-size: 14px;
    width: 18px;
    transition: transform 0.3s;
}
.contact-item:hover i {
    transform: scale(1.2);
}
.newsletter-text {
    font-size: 12px;
    color: #888;
    line-height: 1.6;
    margin-bottom: 18px;
}
.newsletter-form {
    display: flex;
    border: 1px solid rgba(201, 168, 76, 0.25);
    border-radius: 4px;
    overflow: hidden;
    transition: var(--transition);
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
.newsletter-form input::placeholder { color: #aaa; }
.newsletter-form button {
    background: var(--gold);
    border: none;
    padding: 0 20px;
    color: var(--navy);
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.newsletter-form button::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    width: 0; height: 0;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}
.newsletter-form button:hover::before {
    width: 300px; height: 300px;
}
.newsletter-form button:hover {
    background: var(--gold-light);
}
.newsletter-form button i {
    font-size: 14px;
    position: relative;
    z-index: 1;
}
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

/* === SCROLL TO TOP === */
.scroll-top {
    position: fixed;
    bottom: 25px; right: 25px;
    width: 45px; height: 45px;
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
    transition: var(--transition);
    z-index: 999;
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4);
    font-size: 16px;
}
.scroll-top.visible { opacity: 1; visibility: visible; }
.scroll-top:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.5);
}

/* === TOAST === */
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
.toast i { font-size: 18px; }

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* === RESPONSIVE === */
@media (max-width: 1024px) {
    .footer-content { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
    .navbar { padding: 0 30px; }
    .nav-links {
        position: fixed;
        top: 0; right: -100%;
        width: 75%; height: 100vh;
        background: var(--navy);
        flex-direction: column;
        padding: 100px 40px;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 1px solid rgba(201, 168, 76, 0.2);
        gap: 30px;
    }
    .nav-links.active { right: 0; }
    .mobile-menu-btn { display: flex; }
    .footer { padding: 35px 30px 25px; }
    .footer-content { grid-template-columns: 1fr; gap: 25px; }
    .footer-bottom { margin-left: -30px; margin-right: -30px; }
    .checkout-card { padding: 25px; }
    .pricing-total-value { font-size: 22px; }
}
    </style>
<base target="_blank">
</head>
<body>
    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-text">caymira</div>
        <div class="loader-bar">
            <div class="loader-progress"></div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.php'">
            <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.php">Beranda</a></li>
            <li><a href="../About-us/aboutus.php">About Us</a></li>
            <li><a href="../Beranda/beranda.php#bestseller">Best Seller</a></li>
            <li><a href="../login_register/contact.php#contact">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search" onclick="showToast('🔍 Fitur pencarian segera hadir')"></i>
             <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="showToast('🛒 3 item di keranjang')"></i>
                <span class="cart-badge">3</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Checkout Header -->
    <header class="checkout-header">
        <div class="container">
            <h1>Checkout</h1>
            <p>Lengkapi data pengiriman dan pilih metode pembayaran Anda</p>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="container">
        <div class="progress-steps">
            <div class="step active" id="step1">
                <div class="step-circle">1</div>
                <span class="step-label">Informasi</span>
            </div>
            <div class="step-line" id="line1"></div>
            <div class="step" id="step2">
                <div class="step-circle">2</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="step" id="step3">
                <div class="step-circle">3</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>

    <!-- Main Checkout -->
    <main class="checkout-main container">
        <div class="checkout-grid">
            <!-- Left Column: Form -->
            <div class="checkout-left">
                <!-- Shipping Info -->
                <div class="checkout-card" style="margin-bottom: 30px;">
                    <h2 class="card-title"><i class="fas fa-truck"></i> Informasi Pengiriman</h2>
                    <form id="checkoutForm" onsubmit="handleCheckout(event)">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" id="nama" placeholder="Masukkan nama lengkap Anda" required>
                            <span class="error-text" id="error-nama">Nama lengkap wajib diisi</span>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">No. WhatsApp</label>
                                <input type="tel" class="form-input" id="wa" placeholder="08xx-xxxx-xxxx" required>
                                <span class="error-text" id="error-wa">Nomor WhatsApp tidak valid</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" id="email" placeholder="email@contoh.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-input" id="alamat" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan" required></textarea>
                            <span class="error-text" id="error-alamat">Alamat lengkap wajib diisi</span>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Provinsi</label>
                                <div class="select-wrapper">
                                    <select class="form-input" id="provinsi" required>
                                        <option value="" disabled selected>Pilih Provinsi</option>
                                        <option value="jawa-barat">Jawa Barat</option>
                                        <option value="jawa-timur">Jawa Timur</option>
                                        <option value="jawa-tengah">Jawa Tengah</option>
                                        <option value="dki-jakarta">DKI Jakarta</option>
                                        <option value="banten">Banten</option>
                                        <option value="yogyakarta">DI Yogyakarta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kota / Kabupaten</label>
                                <div class="select-wrapper">
                                    <select class="form-input" id="kota" required>
                                        <option value="" disabled selected>Pilih Kota</option>
                                        <option value="bandung">Bandung</option>
                                        <option value="jakarta">Jakarta</option>
                                        <option value="surabaya">Surabaya</option>
                                        <option value="semarang">Semarang</option>
                                        <option value="yogyakarta">Yogyakarta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" class="form-input" id="kecamatan" placeholder="Kecamatan" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-input" id="kodepos" placeholder="402xx" maxlength="5" required>
                                <span class="error-text" id="error-kodepos">Kode pos tidak valid</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catatan untuk Kurir (Opsional)</label>
                            <input type="text" class="form-input" id="catatan" placeholder="Rumah warna hijau, depan masjid">
                        </div>
                    </form>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card">
                    <h2 class="card-title"><i class="fas fa-credit-card"></i> Metode Pembayaran</h2>
                    <div class="payment-methods">
                        <div class="payment-option selected" onclick="selectPayment(this)">
                            <div class="payment-radio"><i class="fas fa-check"></i></div>
                            <div class="payment-icon"><i class="fas fa-university"></i></div>
                            <div class="payment-info">
                                <div class="payment-name">Transfer Bank</div>
                                <div class="payment-desc">BCA, Mandiri, BNI, BRI</div>
                            </div>
                        </div>
                        <div class="payment-option" onclick="selectPayment(this)">
                            <div class="payment-radio"><i class="fas fa-check"></i></div>
                            <div class="payment-icon"><i class="fas fa-wallet"></i></div>
                            <div class="payment-info">
                                <div class="payment-name">E-Wallet</div>
                                <div class="payment-desc">GoPay, OVO, DANA, LinkAja</div>
                            </div>
                        </div>
                        <div class="payment-option" onclick="selectPayment(this)">
                            <div class="payment-radio"><i class="fas fa-check"></i></div>
                            <div class="payment-icon"><i class="fas fa-store"></i></div>
                            <div class="payment-info">
                                <div class="payment-name">COD (Bayar di Tempat)</div>
                                <div class="payment-desc">Bayar saat barang diterima</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="checkout-right">
                <div class="checkout-card" style="position: sticky; top: 90px;">
                    <h2 class="card-title"><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h2>


<div class="order-item">
    <img src="../Gambarberanda/gamis ruffel .jpeg" alt="Gamis" class="order-img">
    <div class="order-details">
        <div class="order-name">Gamis Ruffle Premium</div>
        <div class="order-variant">Navy, M</div>
        <div class="order-price" id="price1">Rp 299.000</div>
        <div class="qty-control">
            <button type="button" class="qty-btn" onclick="updateQty(1, -1)"><i class="fas fa-minus"></i></button>
            <span class="qty-value" id="qty1">1</span>
            <button type="button" class="qty-btn" onclick="updateQty(1, 1)"><i class="fas fa-plus"></i></button>
        </div>
    </div>
</div>

<div class="order-item">
    <img src="Gambarberanda/gamis miryam.jpeg" alt="Jilbab" class="order-img">
    <div class="order-details">
        <div class="order-name">Jilbab Maryam</div>
        <div class="order-variant">Black</div>
        <div class="order-price" id="price2">Rp 109.000</div>
        <div class="qty-control">
            <button type="button" class="qty-btn" onclick="updateQty(2, -1)"><i class="fas fa-minus"></i></button>
            <span class="qty-value" id="qty2">1</span>
            <button type="button" class="qty-btn" onclick="updateQty(2, 1)"><i class="fas fa-plus"></i></button>
        </div>
    </div>
</div>

                    <div class="pricing-divider"></div>

                    <div class="pricing-row">
                        <span class="pricing-label">Subtotal</span>
                        <span class="pricing-value" id="subtotal">Rp 408.000</span>
                    </div>
                    <div class="pricing-row">
                        <span class="pricing-label">Ongkir (JNE Reguler)</span>
                        <span class="pricing-value gold" id="ongkir">Rp 32.000</span>
                    </div>
                    <div class="pricing-row">
                        <span class="pricing-label">Diskon</span>
                        <span class="pricing-value" style="color: #27ae60;">- Rp 0</span>
                    </div>

                    <div class="pricing-divider"></div>

                    <div class="pricing-total">
                        <span class="pricing-total-label">Total Pembayaran</span>
                        <span class="pricing-total-value" id="total">Rp 440.000</span>
                    </div>

                   <button type="button" class="btn-checkout" id="btnCheckout" onclick="processCheckout()">
                    Bayar Sekarang <i class="fas fa-arrow-right"></i>
                </button>

                    <div class="security-badge">
                        <i class="fas fa-lock"></i>
                        <span>Transaksi aman dengan enkripsi SSL</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
            <div class="footer-brand">
                <div class="logo" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                    <img src="../Beranda/Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height: 60px; margin-top: 0;">
                </div>
                <p>Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman dipakai setiap hari.</p>
                <div class="social-links">
                    <a href="#" onclick="showToast('📸 Instagram: @caymiramodest')"><i class="fab fa-instagram"></i></a>
                    <a href="#" onclick="showToast('👥 Facebook: Caymira Modest')"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-0408')"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="../Beranda/beranda.php">Home</a></li>
                    <li><a href="../About-us/aboutus.php">About Us</a></li>
                    <li><a href="../Beranda/beranda.php#collection">Collection</a></li>
                    <li><a href="../Beranda/beranda.php#bestseller">Best Seller</a></li>
                    <li><a href="../login_register/contact.php#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-title">Customer Service</h4>
                <div class="contact-item" onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')">
                    <i class="far fa-clock"></i>
                    <div><div>Monday - Saturday</div><div>10.00 - 17.00 WIB</div></div>
                </div>
                <div class="contact-item" onclick="showToast('📞 Hubungi: 0895-7042-0408')">
                    <i class="fas fa-phone"></i>
                    <div>0895-7042-0408</div>
                </div>
                <div class="contact-item" onclick="showToast('📧 Email: caymiramodest@gmail.com')">
                    <i class="far fa-envelope"></i>
                    <div>caymiramodest@gmail.com</div>
                </div>
            </div>
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

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // ===== LOADING SCREEN =====
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 2000);
        });

        // ===== CUSTOM CURSOR =====
        const cursor = document.getElementById('cursor');
        const cursorDot = document.getElementById('cursorDot');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
            cursorDot.style.left = e.clientX - 3 + 'px';
            cursorDot.style.top = e.clientY - 3 + 'px';
        });
        document.querySelectorAll('a, button, i, .form-input, .payment-option, .qty-btn, .checkout-card, .order-item').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        // ===== NAVBAR SCROLL =====
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const scrollTop = document.getElementById('scrollTop');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                scrollTop.classList.add('visible');
            } else {
                navbar.classList.remove('scrolled');
                scrollTop.classList.remove('visible');
            }
        });

        // ===== MOBILE MENU =====
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            const menuBtn = document.getElementById('mobileMenuBtn');
            navLinks.classList.toggle('active');
            menuBtn.classList.toggle('active');
        }
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navLinks').classList.remove('active');
                document.getElementById('mobileMenuBtn').classList.remove('active');
            });
        });

        // ===== TOAST =====
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toastText');
            toastText.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== NEWSLETTER =====
        function handleSubscribe(e) {
            e.preventDefault();
            const email = document.getElementById('emailInput').value;
            if (email) {
                showToast('✅ Terima kasih telah berlangganan newsletter Caymira!');
                document.getElementById('emailInput').value = '';
            }
        }

        // ===== SCROLL TO TOP =====
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ===== PAYMENT SELECTION =====
        function selectPayment(element) {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            element.classList.add('selected');
            const name = element.querySelector('.payment-name').textContent;
            showToast(`💳 Metode pembayaran: ${name}`);
        }

        // ===== QUANTITY CONTROL =====
        const prices = { 1: 299000, 2: 109000 };
        const qtys = { 1: 1, 2: 1 };
        const ongkir = 32000;

        function updateQty(id, change) {
            const newQty = qtys[id] + change;
            
            // LOGIKA BARU: Jika dikurangin sampai kurang dari 1 (nol)
            if (newQty < 1) {
                // Konfirmasi ke user dulu biar gak gak sengaja kehapus
                const yakin = confirm("Apakah Anda ingin menghapus produk ini dari keranjang?");
                if (yakin) {
                    // 1. Hapus datanya dari object qtys dan harganya
                    delete qtys[id];
                    delete prices[id];
                    
                    // 2. Hilangkan kotak barangnya dari layar HTML
                    // Kita cari tombol yang diklik, lalu naik ke atas sampai ketemu div .order-item, lalu hapus
                    const buttonClicked = event.target.closest('.qty-btn') || event.target;
                    const orderItem = buttonClicked.closest('.order-item');
                    if (orderItem) {
                        orderItem.remove();
                    }
                    
                    showToast('🗑️ Produk berhasil dihapus dari keranjang');
                    calculateTotal();
                }
                return;
            }
            
            if (newQty > 10) {
                showToast('❌ Jumlah maksimal 10');
                return;
            }
            
            // Jalankan update seperti biasa kalau jumlahnya 1 - 10
            qtys[id] = newQty;
            document.getElementById(`qty${id}`).textContent = newQty;
            document.getElementById(`price${id}`).textContent = 'Rp ' + (prices[id] * newQty).toLocaleString('id-ID');
            calculateTotal();
            showToast(`🛒 Jumlah item ${id} diperbarui: ${newQty}`);
        }
        function calculateTotal() {
            let subtotal = 0;
            for (let id in prices) {
                subtotal += prices[id] * qtys[id];
            }
            const total = subtotal + ongkir;
            document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // ===== FORM VALIDATION =====
        function validateForm() {
            let isValid = true;
            const nama = document.getElementById('nama');
            const wa = document.getElementById('wa');
            const alamat = document.getElementById('alamat');
            const kodepos = document.getElementById('kodepos');

            // Reset errors
            document.querySelectorAll('.form-input').forEach(inp => inp.classList.remove('error'));
            document.querySelectorAll('.error-text').forEach(err => err.classList.remove('show'));

            if (!nama.value.trim()) {
                nama.classList.add('error');
                document.getElementById('error-nama').classList.add('show');
                isValid = false;
            }

            const waRegex = /^[0-9]{10,13}$/;
            if (!waRegex.test(wa.value.replace(/\D/g,''))) {
                wa.classList.add('error');
                document.getElementById('error-wa').classList.add('show');
                isValid = false;
            }

            if (!alamat.value.trim()) {
                alamat.classList.add('error');
                document.getElementById('error-alamat').classList.add('show');
                isValid = false;
            }

            const posRegex = /^[0-9]{5}$/;
            if (!posRegex.test(kodepos.value)) {
                kodepos.classList.add('error');
                document.getElementById('error-kodepos').classList.add('show');
                isValid = false;
            }

            return isValid;
        }

 
// ===== CHECKOUT PROCESS (VERSI FINAL) =====
// ===== CHECKOUT PROCESS (VERSI FINAL MIDTRANS) =====
        async function processCheckout() {
            if (!validateForm()) {
                showToast('⚠️ Harap lengkapi data dengan benar');
                return;
            }

            const btn = document.getElementById('btnCheckout');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            // Ambil data form + total harga asli dari halaman
            const totalElement = document.getElementById('total').textContent;
            const totalAngka = parseInt(totalElement.replace(/[^0-9]/g, ''));

            const dataOrder = {
                nama: document.getElementById('nama').value,
                wa: document.getElementById('wa').value,
                email: document.getElementById('email').value,
                alamat: document.getElementById('alamat').value,
                kota: document.getElementById('kota').value,
                kodepos: document.getElementById('kodepos').value,
                total: totalAngka
            };

            try {
                // Tembak ke PHP kamu
                const response = await fetch('proses_checkout.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(dataOrder)
                });
                
                const textResponse = await response.text(); 
                const result = JSON.parse(textResponse);

                if (result.token) {
                    // Langsung pindah halaman sambil bawa token & order_id di URL-nya
                    window.location.href = `pembayaran.php?order_id=${result.order_id}&token=${result.token}`;
                } else {
                    showToast('❌ Gagal: ' + (result.error || 'Cek Console'));
                    btn.disabled = false;
                    btn.innerHTML = 'Bayar Sekarang <i class="fas fa-arrow-right"></i>';
                }

            } catch (error) {
                console.error("ERROR JS:", error);
                showToast('❌ Terjadi kesalahan server');
                btn.disabled = false;
                btn.innerHTML = 'Bayar Sekarang <i class="fas fa-arrow-right"></i>';
            }
        } // <-- INI DIA KURUNG YANG TADI HILANG! Sekarang sudah aman.

        // ===== INPUT FORMATTING =====
        document.getElementById('wa').addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.startsWith('0')) val = val.substring(1);
            if (val.length > 13) val = val.substring(0, 13);
            e.target.value = val ? '0' + val : '';
        });

        document.getElementById('kodepos').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 5);
        });

        // ===== SCROLL REVEAL =====
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.checkout-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.transitionDelay = (index * 0.15) + 's';
            revealObserver.observe(card);
        });
    </script>
</body>
</html>
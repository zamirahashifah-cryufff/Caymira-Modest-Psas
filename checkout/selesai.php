<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Selesai - Caymira Modest</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
/* === VARIABEL === */
:root {
    --navy: #0a1628;
    --navy-light: #0f1d35;
    --gold: #c9a84c;
    --gold-light: #d4b76a;
    --gold-dark: #b8963f;
    --text-light: #e8e8e8;
    --text-muted: #a0a0a0;
    --bg-card: #141e2a;
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Poppins', sans-serif;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
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
.container { width: 90%; max-width: 1200px; margin: 0 auto; }

/* Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: var(--navy); }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

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

/* === LOADER === */
.loader {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    background: var(--navy);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    z-index: 99999;
    transition: opacity 0.6s, visibility 0.6s;
}
.loader.hidden { opacity: 0; visibility: hidden; }
.loader-text {
    font-family: var(--font-heading);
    font-size: 42px; color: var(--gold);
    animation: loaderPulse 1.5s ease-in-out infinite;
}
.loader-bar {
    width: 200px; height: 2px;
    background: rgba(201,168,76,0.2);
    margin-top: 30px; border-radius: 2px;
    overflow: hidden;
}
.loader-progress {
    height: 100%; background: var(--gold);
    width: 0%; animation: loadProgress 2s ease forwards;
}
@keyframes loaderPulse {
    0%,100% { opacity: 0.4; letter-spacing: 2px; }
    50% { opacity: 1; letter-spacing: 8px; }
}
@keyframes loadProgress {
    0% { width: 0%; } 100% { width: 100%; }
}

/* === NAVBAR === */
.navbar {
    position: fixed; top: 0; width: 100%; height: 70px;
    padding: 0 60px; display: flex;
    justify-content: space-between; align-items: center;
    z-index: 1000;
    background: rgba(7,13,23,0.98);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(201,168,76,0.6);
    transition: var(--transition);
}
.navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
.logo-img { height: 75px; width: auto; object-fit: contain; transition: var(--transition); margin-top: 5px; position: relative; z-index: 1001; }
.logo:hover .logo-img { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(201,168,76,0.5)); }
.nav-links { display: flex; gap: 45px; list-style: none; }
.nav-links a {
    color: var(--text-light); text-decoration: none;
    font-size: 12px; font-weight: 500;
    letter-spacing: 1.5px; text-transform: uppercase;
    position: relative; padding: 5px 0;
    transition: color 0.3s;
}
.nav-links a::after {
    content: ''; position: absolute; bottom: -4px; left: 0;
    width: 0; height: 2px; background: var(--gold);
    transition: width 0.3s;
}
.nav-links a:hover, .nav-links a.active { color: var(--gold); }
.nav-links a:hover::after, .nav-links a.active::after { width: 100%; }
.nav-icons { display: flex; gap: 25px; align-items: center; }
.nav-icons i {
    font-size: 18px; color: var(--text-light);
    cursor: pointer; transition: var(--transition); position: relative;
}
.nav-icons i:hover { color: var(--gold); transform: scale(1.2) rotate(5deg); }
.cart-icon { position: relative; display: flex; align-items: center; }
.cart-badge {
    position: absolute; top: -8px; right: -8px;
    background: var(--gold); color: var(--navy);
    font-size: 10px; font-weight: 700;
    width: 18px; height: 18px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
.mobile-menu-btn {
    display: none; flex-direction: column; gap: 5px;
    cursor: pointer; z-index: 1001; padding: 5px;
}
.mobile-menu-btn span { width: 24px; height: 2px; background: var(--gold); transition: var(--transition); border-radius: 2px; }
.mobile-menu-btn.active span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
.mobile-menu-btn.active span:nth-child(2) { opacity: 0; transform: translateX(-20px); }
.mobile-menu-btn.active span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

/* === SUCCESS HERO === */
.success-hero {
    margin-top: 70px;
    padding: 80px 0 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.success-hero::before {
    content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at 50% 30%, rgba(201,168,76,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.success-icon-wrapper {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(39,174,96,0.2), rgba(39,174,96,0.05));
    border: 2px solid rgba(39,174,96,0.4);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 30px;
    position: relative; z-index: 1;
    animation: iconPop 0.6s cubic-bezier(0.68,-0.55,0.265,1.55) forwards;
}
@keyframes iconPop {
    0% { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
.success-icon-wrapper i {
    font-size: 48px;
    color: #27ae60;
    animation: checkScale 0.5s ease 0.3s both;
}
@keyframes checkScale {
    0% { transform: scale(0); }
    70% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
.success-title {
    font-family: var(--font-heading);
    font-size: 42px;
    color: var(--gold);
    margin-bottom: 12px;
    position: relative; z-index: 1;
    animation: fadeInUp 0.8s ease 0.2s both;
}
.success-subtitle {
    font-size: 16px;
    color: var(--text-muted);
    max-width: 500px;
    margin: 0 auto 30px;
    line-height: 1.7;
    position: relative; z-index: 1;
    animation: fadeInUp 0.8s ease 0.4s both;
}
.order-id-box {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 28px;
    background: rgba(201,168,76,0.1);
    border: 1.5px solid rgba(201,168,76,0.25);
    border-radius: 50px;
    font-size: 15px;
    position: relative; z-index: 1;
    animation: fadeInUp 0.8s ease 0.5s both;
}
.order-id-box span { color: var(--text-muted); }
.order-id-box strong { color: var(--gold); font-weight: 600; letter-spacing: 1px; }
.order-id-box i {
    color: var(--gold); cursor: pointer;
    transition: var(--transition); font-size: 14px;
}
.order-id-box i:hover { transform: scale(1.2); color: var(--gold-light); }

/* === PROGRESS === */
.progress-steps {
    display: flex; justify-content: center; align-items: center;
    gap: 0; margin-bottom: 50px; position: relative; z-index: 1;
}
.step { display: flex; flex-direction: column; align-items: center; gap: 10px; position: relative; }
.step-circle {
    width: 44px; height: 44px; border-radius: 50%;
    border: 2px solid rgba(201,168,76,0.3);
    display: flex; align-items: center; justify-content: center;
    font-weight: 600; font-size: 14px; color: var(--text-muted);
    background: var(--navy); transition: var(--transition); position: relative; z-index: 2;
}
.step.active .step-circle {
    border-color: var(--gold); background: var(--gold); color: var(--navy);
    box-shadow: 0 0 20px rgba(201,168,76,0.4);
}
.step.completed .step-circle {
    border-color: var(--gold); background: var(--gold); color: var(--navy);
}
.step-label {
    font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px;
    color: var(--text-muted); font-weight: 500; transition: var(--transition);
}
.step.active .step-label { color: var(--gold); }
.step.completed .step-label { color: var(--gold-light); }
.step-line {
    width: 100px; height: 2px; background: rgba(201,168,76,0.2);
    margin: 0 15px; position: relative; top: -22px; transition: var(--transition);
}
.step-line.completed { background: var(--gold); }
@media (max-width: 768px) {
    .step-line { width: 40px; margin: 0 8px; }
    .success-title { font-size: 28px; }
    .success-icon-wrapper { width: 80px; height: 80px; }
    .success-icon-wrapper i { font-size: 36px; }
}

/* === MAIN LAYOUT === */
.success-main { padding-bottom: 80px; }
.success-grid {
    display: grid; grid-template-columns: 1fr 420px;
    gap: 40px; align-items: start;
}
@media (max-width: 1024px) {
    .success-grid { grid-template-columns: 1fr; }
}

/* === CARD === */
.success-card {
    background: var(--bg-card);
    border: 1px solid rgba(201,168,76,0.12);
    border-radius: 20px; padding: 35px;
    transition: var(--transition); position: relative; overflow: hidden;
    margin-bottom: 30px;
}
.success-card::before {
    content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(135deg, rgba(201,168,76,0.05) 0%, transparent 60%);
    opacity: 0; transition: opacity 0.5s; pointer-events: none;
}
.success-card:hover::before { opacity: 1; }
.success-card:hover {
    border-color: rgba(201,168,76,0.25);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}
.card-title {
    font-family: var(--font-heading); font-size: 22px;
    color: var(--gold); margin-bottom: 25px;
    display: flex; align-items: center; gap: 12px;
    position: relative; z-index: 1;
}
.card-title i { font-size: 18px; color: var(--gold); opacity: 0.8; }
.card-title::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, rgba(201,168,76,0.3), transparent);
    margin-left: 10px;
}

/* === TIMELINE === */
.timeline {
    position: relative; padding-left: 35px;
    position: relative; z-index: 1;
}
.timeline::before {
    content: ''; position: absolute; left: 11px; top: 8px; bottom: 8px;
    width: 2px; background: linear-gradient(to bottom, var(--gold), rgba(201,168,76,0.2));
    border-radius: 2px;
}
.timeline-item {
    position: relative; padding-bottom: 28px;
    display: flex; gap: 18px;
    animation: fadeInLeft 0.6s ease both;
}
.timeline-item:nth-child(1) { animation-delay: 0.1s; }
.timeline-item:nth-child(2) { animation-delay: 0.2s; }
.timeline-item:nth-child(3) { animation-delay: 0.3s; }
.timeline-item:nth-child(4) { animation-delay: 0.4s; }
.timeline-item:last-child { padding-bottom: 0; }
.timeline-dot {
    position: absolute; left: -35px; top: 2px;
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--navy);
    border: 2px solid rgba(201,168,76,0.3);
    display: flex; align-items: center; justify-content: center;
    z-index: 2; transition: var(--transition);
}
.timeline-item.active .timeline-dot {
    border-color: #27ae60;
    background: #27ae60;
    box-shadow: 0 0 12px rgba(39,174,96,0.4);
}
.timeline-item.completed .timeline-dot {
    border-color: var(--gold);
    background: var(--gold);
}
.timeline-dot i { font-size: 10px; color: var(--navy); }
.timeline-item.active .timeline-dot i { color: white; }
.timeline-content { flex: 1; }
.timeline-status {
    font-size: 14px; font-weight: 600;
    color: var(--text-light); margin-bottom: 4px;
}
.timeline-item.active .timeline-status { color: #27ae60; }
.timeline-item.completed .timeline-status { color: var(--gold); }
.timeline-date {
    font-size: 12px; color: var(--text-muted);
}

/* === DETAIL ROW === */
.detail-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 0;
    font-size: 14px;
    border-bottom: 1px solid rgba(201,168,76,0.1);
    position: relative; z-index: 1;
}
.detail-row:last-child { border-bottom: none; }
.detail-label { color: var(--text-muted); display: flex; align-items: center; gap: 10px; }
.detail-label i { color: var(--gold); font-size: 14px; width: 18px; }
.detail-value { color: var(--text-light); font-weight: 500; text-align: right; }
.detail-value.gold { color: var(--gold); font-weight: 600; }

/* === ORDER ITEM === */
.order-item {
    display: flex; gap: 15px; padding: 15px 0;
    border-bottom: 1px solid rgba(201,168,76,0.1);
    position: relative; z-index: 1;
    transition: var(--transition);
}
.order-item:hover { transform: translateX(5px); }
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.order-item:first-child { padding-top: 0; }
.order-img { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; border: 1px solid rgba(201,168,76,0.2); flex-shrink: 0; }
.order-details { flex: 1; }
.order-name { font-size: 14px; font-weight: 500; color: var(--text-light); margin-bottom: 3px; }
.order-variant { font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }
.order-price { font-size: 14px; font-weight: 600; color: var(--gold); }

/* === PRICING === */
.pricing-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; font-size: 14px; position: relative; z-index: 1;
}
.pricing-row:not(:last-child) { border-bottom: 1px dashed rgba(201,168,76,0.15); }
.pricing-label { color: var(--text-muted); }
.pricing-value { color: var(--text-light); font-weight: 500; }
.pricing-value.gold { color: var(--gold); font-weight: 600; }
.pricing-divider {
    height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.3), transparent);
    margin: 12px 0;
}
.pricing-total {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 12px; position: relative; z-index: 1;
}
.pricing-total-label { font-size: 16px; font-weight: 600; color: var(--text-light); }
.pricing-total-value {
    font-family: var(--font-heading); font-size: 24px;
    color: var(--gold); font-weight: 700;
}

/* === CTA BUTTONS === */
.btn-group {
    display: flex; gap: 15px; margin-top: 25px;
    position: relative; z-index: 1;
}
@media (max-width: 768px) {
    .btn-group { flex-direction: column; }
}
.btn-primary {
    flex: 1; padding: 16px;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    border: none; border-radius: 14px; color: var(--navy);
    font-family: var(--font-body); font-size: 15px;
    font-weight: 600; text-transform: uppercase;
    letter-spacing: 1.5px; cursor: pointer;
    transition: var(--transition);
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-primary::before {
    content: ''; position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.btn-primary:hover::before { left: 100%; }
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(201,168,76,0.4);
}
.btn-secondary {
    flex: 1; padding: 16px;
    background: transparent;
    border: 1.5px solid rgba(201,168,76,0.3);
    border-radius: 14px; color: var(--text-light);
    font-family: var(--font-body); font-size: 15px;
    font-weight: 500; cursor: pointer;
    transition: var(--transition);
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-secondary:hover {
    border-color: var(--gold);
    background: rgba(201,168,76,0.1);
    color: var(--gold);
    transform: translateY(-3px);
}

/* === SHIPPING INFO === */
.shipping-info { margin-top: 20px; }
.shipping-row {
    display: flex; gap: 12px; padding: 10px 0;
    font-size: 13px; color: var(--text-muted);
    position: relative; z-index: 1;
}
.shipping-row i { color: var(--gold); width: 18px; margin-top: 2px; }
.shipping-row div { line-height: 1.5; }
.shipping-row strong { color: var(--text-light); font-weight: 500; }

/* === WHATSAPP CTA === */
.whatsapp-cta {
    background: linear-gradient(135deg, rgba(39,174,96,0.15), rgba(39,174,96,0.05));
    border: 1.5px solid rgba(39,174,96,0.3);
    border-radius: 16px; padding: 25px;
    display: flex; align-items: center; gap: 20px;
    position: relative; z-index: 1;
    transition: var(--transition);
}
.whatsapp-cta:hover {
    border-color: rgba(39,174,96,0.5);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(39,174,96,0.15);
}
.whatsapp-icon {
    width: 55px; height: 55px; border-radius: 50%;
    background: #25d366;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: white; flex-shrink: 0;
    transition: var(--transition);
}
.whatsapp-cta:hover .whatsapp-icon { transform: scale(1.1) rotate(-5deg); }
.whatsapp-text { flex: 1; }
.whatsapp-title { font-size: 16px; font-weight: 600; color: #27ae60; margin-bottom: 4px; }
.whatsapp-desc { font-size: 13px; color: var(--text-muted); line-height: 1.5; }
.whatsapp-btn {
    padding: 10px 20px; background: #25d366;
    border: none; border-radius: 10px; color: white;
    font-size: 13px; font-weight: 600; cursor: pointer;
    transition: var(--transition); white-space: nowrap;
}
.whatsapp-btn:hover { background: #128c7e; transform: scale(1.05); }

/* === CONFETTI === */
.confetti-container {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none; z-index: 99998;
    overflow: hidden;
}
.confetti {
    position: absolute; width: 10px; height: 10px;
    background: var(--gold); top: -10px;
    animation: confettiFall 3s ease-out forwards;
}
@keyframes confettiFall {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}

/* === FOOTER === */
.footer {
    background: #ffffff; border-top: 1px solid rgba(201,168,76,0.15);
    padding: 50px 60px 30px; position: relative; margin-top: 50px;
}
.gold-branch-footer {
    position: absolute; left: -30px; top: -70px;
    width: 200px; opacity: 0.5; pointer-events: none;
}
.footer-content {
    display: grid; grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr;
    gap: 35px; max-width: 1300px; margin: 0 auto;
}
.footer-brand .logo-main {
    font-family: var(--font-heading); font-size: 22px;
    color: var(--gold); font-weight: 600; margin-bottom: 3px;
}
.footer-brand .logo-sub {
    font-size: 9px; color: var(--gold);
    letter-spacing: 3px; text-transform: uppercase; margin-bottom: 18px;
}
.footer-brand p { font-size: 12px; line-height: 1.8; color: #666; max-width: 230px; }
.social-links { display: flex; gap: 12px; margin-top: 18px; }
.social-links a {
    width: 36px; height: 36px; border: 1px solid rgba(201,168,76,0.35);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: var(--gold); text-decoration: none; transition: var(--transition);
    font-size: 14px; position: relative; overflow: hidden;
}
.social-links a::before {
    content: ''; position: absolute; top: 0; left: 0;
    width: 100%; height: 100%; background: var(--gold);
    transform: scale(0); transition: transform 0.3s; border-radius: 50%;
}
.social-links a:hover::before { transform: scale(1); }
.social-links a:hover { color: var(--navy); transform: translateY(-3px); }
.social-links a i { position: relative; z-index: 1; }
.footer-title {
    color: var(--gold); font-size: 13px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 22px; position: relative; display: inline-block;
}
.footer-title::after {
    content: ''; position: absolute; bottom: -8px; left: 0;
    width: 35px; height: 2px; background: var(--gold);
    transition: width 0.3s;
}
.footer-col:hover .footer-title::after { width: 100%; }
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a {
    color: #888; text-decoration: none; font-size: 13px;
    transition: var(--transition); display: inline-flex;
    align-items: center; gap: 8px;
}
.footer-links a::before {
    content: '→'; color: var(--gold); opacity: 0;
    transform: translateX(-10px); transition: var(--transition);
}
.footer-links a:hover { color: var(--gold); transform: translateX(4px); }
.footer-links a:hover::before { opacity: 1; transform: translateX(0); }
.contact-item {
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 15px; color: #888; font-size: 13px;
    transition: var(--transition); cursor: pointer;
}
.contact-item:hover { color: var(--gold); transform: translateX(5px); }
.contact-item i { color: var(--gold); margin-top: 3px; font-size: 14px; width: 18px; transition: transform 0.3s; }
.contact-item:hover i { transform: scale(1.2); }
.newsletter-text { font-size: 12px; color: #888; line-height: 1.6; margin-bottom: 18px; }
.newsletter-form {
    display: flex; border: 1px solid rgba(201,168,76,0.25);
    border-radius: 4px; overflow: hidden;
    transition: var(--transition); position: relative;
}
.newsletter-form:focus-within { border-color: var(--gold); box-shadow: 0 0 20px rgba(201,168,76,0.2); }
.newsletter-form input { flex: 1; background: transparent; border: none; padding: 12px 14px; color: #333; font-size: 13px; outline: none; }
.newsletter-form input::placeholder { color: #aaa; }
.newsletter-form button { background: var(--gold); border: none; padding: 0 20px; color: var(--navy); cursor: pointer; transition: var(--transition); position: relative; overflow: hidden; }
.newsletter-form button::before { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: rgba(255,255,255,0.3); border-radius: 50%; transform: translate(-50%,-50%); transition: width 0.6s, height 0.6s; }
.newsletter-form button:hover::before { width: 300px; height: 300px; }
.newsletter-form button:hover { background: var(--gold-light); }
.newsletter-form button i { font-size: 14px; position: relative; z-index: 1; }
.footer-bottom {
    text-align: center; padding-top: 35px; margin-top: 35px;
    border-top: 1px solid rgba(201,168,76,0.15); font-size: 12px;
    color: #ffffff; background-color: #000000;
    padding-bottom: 35px; margin-left: -60px; margin-right: -60px;
}

/* === SCROLL TOP === */
.scroll-top {
    position: fixed; bottom: 25px; right: 25px;
    width: 45px; height: 45px; background: var(--gold);
    color: var(--navy); border: none; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: var(--transition);
    z-index: 999; box-shadow: 0 4px 15px rgba(201,168,76,0.4); font-size: 16px;
}
.scroll-top.visible { opacity: 1; visibility: visible; }
.scroll-top:hover { transform: translateY(-5px) scale(1.1); box-shadow: 0 8px 25px rgba(201,168,76,0.5); }

/* === TOAST === */
.toast {
    position: fixed; bottom: 90px; left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: var(--gold); color: var(--navy);
    padding: 16px 32px; border-radius: 50px;
    font-weight: 500; font-size: 14px; opacity: 0;
    transition: all 0.4s cubic-bezier(0.68,-0.55,0.265,1.55);
    z-index: 10000; box-shadow: 0 8px 30px rgba(201,168,76,0.4);
    display: flex; align-items: center; gap: 10px;
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.toast i { font-size: 18px; }

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

/* === RESPONSIVE === */
@media (max-width: 1024px) {
    .success-grid { grid-template-columns: 1fr; }
    .footer-content { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
    .navbar { padding: 0 30px; }
    .nav-links {
        position: fixed; top: 0; right: -100%; width: 75%; height: 100vh;
        background: var(--navy); flex-direction: column;
        padding: 100px 40px; transition: right 0.4s cubic-bezier(0.4,0,0.2,1);
        border-left: 1px solid rgba(201,168,76,0.2); gap: 30px;
    }
    .nav-links.active { right: 0; }
    .mobile-menu-btn { display: flex; }
    .footer { padding: 35px 30px 25px; }
    .footer-content { grid-template-columns: 1fr; gap: 25px; }
    .footer-bottom { margin-left: -30px; margin-right: -30px; }
    .success-card { padding: 25px; }
    .whatsapp-cta { flex-direction: column; text-align: center; }
    .timeline { padding-left: 30px; }
}
    </style>
<base target="_blank">
</head>

<body>
    <!-- Confetti -->
    <div class="confetti-container" id="confetti"></div>

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-text">caymira</div>
        <div class="loader-bar"><div class="loader-progress"></div></div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="logo" onclick="window.location.href='../Beranda/beranda.html'">
            <img src="Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img">
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="../Beranda/beranda.html">Beranda</a></li>
            <li><a href="../About-us/aboutus.html">About Us</a></li>
            <li><a href="../Beranda/beranda.html#bestseller">Best Seller</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <i class="fas fa-search" onclick="showToast('🔍 Fitur pencarian segera hadir')"></i>
            <i class="fas fa-user" onclick="window.location.href='../login_register/profil.php'"></i>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart" onclick="showToast('🛒 Keranjang kosong')"></i>
                <span class="cart-badge" style="display:none;">0</span>
            </div>
            <div class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Success Hero -->
    <header class="success-hero">
        <div class="container">
            <div class="success-icon-wrapper">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="success-title">Pesanan Berhasil!</h1>
            <p class="success-subtitle">
                Terima kasih telah berbelanja di Caymira Modest. Pesanan Anda sedang diproses dan akan segera dikirim.
            </p>
            <div class="order-id-box">
                <span>No. Pesanan:</span>
                <strong>CM-250516-8842</strong>
                <i class="fas fa-copy" onclick="copyOrderId()"></i>
            </div>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="container">
        <div class="progress-steps">
            <div class="step completed" id="step1">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <span class="step-label">Informasi</span>
            </div>
            <div class="step-line completed" id="line1"></div>
            <div class="step completed" id="step2">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-line completed" id="line2"></div>
            <div class="step active" id="step3">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="success-main container">
        <div class="success-grid">
            <!-- Left Column -->
            <div class="success-left">
                <!-- Tracking Timeline -->
                <div class="success-card">
                    <h2 class="card-title"><i class="fas fa-shipping-fast"></i> Status Pengiriman</h2>
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-dot"><i class="fas fa-check"></i></div>
                            <div class="timeline-content">
                                <div class="timeline-status">Pesanan Diterima</div>
                                <div class="timeline-date">16 Mei 2026, 14:32 WIB</div>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <div class="timeline-dot"><i class="fas fa-check"></i></div>
                            <div class="timeline-content">
                                <div class="timeline-status">Pembayaran Terverifikasi</div>
                                <div class="timeline-date">16 Mei 2026, 14:35 WIB</div>
                            </div>
                        </div>
                        <div class="timeline-item active">
                            <div class="timeline-dot"><i class="fas fa-box"></i></div>
                            <div class="timeline-content">
                                <div class="timeline-status">Sedang Dikemas</div>
                                <div class="timeline-date">Estimasi selesai hari ini</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-status">Dikirim ke Alamat Anda</div>
                                <div class="timeline-date">Estimasi 18 - 19 Mei 2026</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-status">Pesanan Diterima</div>
                                <div class="timeline-date">Menunggu konfirmasi Anda</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="success-card">
                    <h2 class="card-title"><i class="fas fa-receipt"></i> Detail Pesanan</h2>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-calendar"></i> Tanggal Pesanan</span>
                        <span class="detail-value">16 Mei 2026</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-credit-card"></i> Metode Pembayaran</span>
                        <span class="detail-value">Transfer Bank - BCA</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-truck"></i> Kurir Pengiriman</span>
                        <span class="detail-value">JNE Reguler</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-barcode"></i> No. Resi</span>
                        <span class="detail-value gold" style="cursor:pointer;" onclick="copyResi()">
                            JNE2505168842 <i class="fas fa-copy" style="font-size:12px;margin-left:4px;"></i>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-money-bill-wave"></i> Total Pembayaran</span>
                        <span class="detail-value gold">Rp 440.000</span>
                    </div>
                </div>

                <!-- WhatsApp Support -->
                <div class="success-card" style="border: 1.5px solid rgba(39,174,96,0.2);">
                    <div class="whatsapp-cta" onclick="window.open('https://wa.me/6289570420408?text=Halo+Caymira,+saya+ingin+menanyakan+pesanan+saya+CM-250516-8842','_blank')">
                        <div class="whatsapp-icon"><i class="fab fa-whatsapp"></i></div>
                        <div class="whatsapp-text">
                            <div class="whatsapp-title">Butuh Bantuan?</div>
                            <div class="whatsapp-desc">Chat kami via WhatsApp untuk pertanyaan seputar pesanan Anda</div>
                        </div>
                        <button class="whatsapp-btn">Chat Sekarang</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="success-right">
                <div class="success-card" style="position: sticky; top: 90px;">
                    <h2 class="card-title"><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h2>

                    <div class="order-item">
                        <img src="Gambarberanda/gamis ruffel .jpeg" alt="Gamis" class="order-img">
                        <div class="order-details">
                            <div class="order-name">Gamis Ruffle Premium</div>
                            <div class="order-variant">Navy, M x1</div>
                            <div class="order-price">Rp 299.000</div>
                        </div>
                    </div>
                    <div class="order-item">
                        <img src="Gambarberanda/gamis miryam.jpeg" alt="Jilbab" class="order-img">
                        <div class="order-details">
                            <div class="order-name">Jilbab Maryam</div>
                            <div class="order-variant">Black x1</div>
                            <div class="order-price">Rp 109.000</div>
                        </div>
                    </div>

                    <div class="pricing-divider"></div>

                    <div class="pricing-row">
                        <span class="pricing-label">Subtotal</span>
                        <span class="pricing-value">Rp 408.000</span>
                    </div>
                    <div class="pricing-row">
                        <span class="pricing-label">Ongkir (JNE Reguler)</span>
                        <span class="pricing-value gold">Rp 32.000</span>
                    </div>
                    <div class="pricing-row">
                        <span class="pricing-label">Diskon</span>
                        <span class="pricing-value" style="color:#27ae60;">- Rp 0</span>
                    </div>

                    <div class="pricing-divider"></div>

                    <div class="pricing-total">
                        <span class="pricing-total-label">Total</span>
                        <span class="pricing-total-value">Rp 440.000</span>
                    </div>

                    <!-- Shipping Address -->
                    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(201,168,76,0.15);">
                        <h3 style="font-family: var(--font-heading); font-size: 16px; color: var(--gold); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-map-marker-alt" style="font-size: 14px;"></i> Alamat Pengiriman
                        </h3>
                        <div class="shipping-info">
                            <div class="shipping-row">
                                <i class="fas fa-user"></i>
                                <div><strong>Aisyah Putri</strong><br>0812-3456-7890</div>
                            </div>
                            <div class="shipping-row">
                                <i class="fas fa-home"></i>
                                <div>Jl. Mawar No. 12, RT 02/RW 05<br>Kel. Sukajadi, Kec. Bandung Wetan<br>Bandung, Jawa Barat 40115</div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="btn-group">
                        <button class="btn-primary" onclick="window.location.href='../Pesanan/pesanan.html'">
                            <i class="fas fa-box-open"></i> Pesanan Saya
                        </button>
                        <button class="btn-secondary" onclick="window.location.href='../Beranda/beranda.html'">
                            <i class="fas fa-shopping-bag"></i> Belanja Lagi
                        </button>
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
                <div class="logo" onclick="window.scrollTo({top:0,behavior:'smooth'})">
                    <img src="Gambarberanda/logo_caymira_modest.png" alt="Caymira Modest" class="logo-img" style="height:60px;margin-top:0;">
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
                    <li><a href="../login_register/contact.php">Contact</a></li>
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
        document.querySelectorAll('a, button, i, .success-card, .order-item, .timeline-item, .whatsapp-cta, .btn-primary, .btn-secondary').forEach(el => {
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

        // ===== COPY ORDER ID =====
        function copyOrderId() {
            navigator.clipboard.writeText('CM-250516-8842').then(() => {
                showToast('✅ No. Pesanan disalin ke clipboard');
            });
        }

        // ===== COPY RESI =====
        function copyResi() {
            navigator.clipboard.writeText('JNE2505168842').then(() => {
                showToast('✅ No. Resi disalin ke clipboard');
            });
        }

        // ===== CONFETTI =====
        function launchConfetti() {
            const container = document.getElementById('confetti');
            const colors = ['#c9a84c', '#d4b76a', '#ffffff', '#27ae60', '#f1c40f', '#e8e8e8'];
            for (let i = 0; i < 80; i++) {
                const conf = document.createElement('div');
                conf.className = 'confetti';
                conf.style.left = Math.random() * 100 + '%';
                conf.style.background = colors[Math.floor(Math.random() * colors.length)];
                conf.style.width = (6 + Math.random() * 8) + 'px';
                conf.style.height = (6 + Math.random() * 8) + 'px';
                conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                conf.style.animationDuration = (2.5 + Math.random() * 2) + 's';
                conf.style.animationDelay = (Math.random() * 0.8) + 's';
                container.appendChild(conf);
            }
            // Second wave
            setTimeout(() => {
                for (let i = 0; i < 40; i++) {
                    const conf = document.createElement('div');
                    conf.className = 'confetti';
                    conf.style.left = Math.random() * 100 + '%';
                    conf.style.background = colors[Math.floor(Math.random() * colors.length)];
                    conf.style.width = (6 + Math.random() * 8) + 'px';
                    conf.style.height = (6 + Math.random() * 8) + 'px';
                    conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                    conf.style.animationDuration = (2 + Math.random() * 2) + 's';
                    conf.style.animationDelay = '0s';
                    container.appendChild(conf);
                }
            }, 800);
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        // Launch confetti after loader hides
        setTimeout(launchConfetti, 2500);

        // ===== SCROLL REVEAL =====
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.success-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.transitionDelay = (index * 0.15) + 's';
            revealObserver.observe(card);
        });
    </script>
</body>
</html>
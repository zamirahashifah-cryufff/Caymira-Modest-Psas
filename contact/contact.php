<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Caymira Modest</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

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
        --font-heading: "Playfair Display", serif;
        --font-body: "Poppins", sans-serif;
      }

      /* === RESET & GLOBAL === */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        background-color: var(--navy);
        color: var(--text-light);
        font-family: var(--font-body);
        line-height: 1.6;
        overflow-x: hidden;
      }

      a {
        text-decoration: none;
        color: inherit;
        transition: color 0.3s ease;
      }

      img {
        max-width: 100%;
        height: auto;
      }

      .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
      }

      /* Custom Scrollbar */
      ::-webkit-scrollbar {
        width: 8px;
      }
      ::-webkit-scrollbar-track {
        background: var(--navy);
      }
      ::-webkit-scrollbar-thumb {
        background: var(--gold);
        border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background: var(--gold-light);
      }

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

      /* === LOADING SCREEN === */
      .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
        font-family: "Playfair Display", serif;
        font-size: 42px;
        color: var(--gold);
        animation: loaderPulse 1.5s ease-in-out infinite;
      }
      .loader-bar {
        width: 200px;
        height: 2px;
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
        0%, 100% {
          opacity: 0.4;
          letter-spacing: 2px;
        }
        50% {
          opacity: 1;
          letter-spacing: 8px;
        }
      }
      @keyframes loadProgress {
        0% {
          width: 0%;
        }
        100% {
          width: 100%;
        }
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
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
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
        content: "";
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: width 0.3s;
      }
      .nav-links a:hover,
      .nav-links a.active {
        color: var(--gold);
      }
      .nav-links a:hover::after,
      .nav-links a.active::after {
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
        top: -8px;
        right: -8px;
        background: var(--gold);
        color: var(--navy);
        font-size: 10px;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
      }
      @keyframes pulse {
        0%, 100% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.2);
        }
      }

      /* Search Overlay */
      .search-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 22, 40, 0.98);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s;
      }
      .search-overlay.active {
        opacity: 1;
        visibility: visible;
      }
      .search-box {
        width: 60%;
        max-width: 600px;
        position: relative;
      }
      .search-box input {
        width: 100%;
        padding: 20px 60px 20px 0;
        background: transparent;
        border: none;
        border-bottom: 2px solid var(--gold);
        color: var(--gold);
        font-size: 32px;
        font-family: "Playfair Display", serif;
        outline: none;
      }
      .search-box input::placeholder {
        color: rgba(201, 168, 76, 0.4);
      }
      .search-close {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gold);
        font-size: 28px;
        cursor: pointer;
        transition: transform 0.3s;
      }
      .search-close:hover {
        transform: translateY(-50%) rotate(90deg);
      }

      /* Mobile Menu */
      .mobile-menu-btn {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        z-index: 1001;
        padding: 5px;
      }
      .mobile-menu-btn span {
        width: 24px;
        height: 2px;
        background: var(--gold);
        transition: all 0.3s;
        border-radius: 2px;
      }
      .mobile-menu-btn.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
      }
      .mobile-menu-btn.active span:nth-child(2) {
        opacity: 0;
        transform: translateX(-20px);
      }
      .mobile-menu-btn.active span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
      }

      /* === HERO SECTION === */
      .hero-section {
        position: relative;
        width: 100%;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      /* Background Image */
      .hero-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 0;
        filter: brightness(0.85);
      }

      .hero-content {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 100px 20px;
      }

      .hero-content h1 {
        font-family: var(--font-heading);
        font-size: 70px;
        color:#000000;
        margin-bottom: 15px;
        text-shadow: 0 4px 15px rgba(242, 216, 110, 0.566);
      }

      /* === CONTACT SECTION === */
      .contact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        padding: 80px 20px;
      }

      /* Cards (Kiri) */
      .contact-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
      }

      .card {
        background-color: var(--navy-lighter);
        color: var(--text-light);
        padding: 40px 20px;
        border-radius: 16px;
        text-align: center;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(201, 168, 76, 0.1);
      }

      .card:hover {
        transform: translateY(-10px);
        border-color: rgba(201, 168, 76, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      }

      .card i {
        font-size: 32px;
        color: var(--gold);
        margin-bottom: 15px;
      }

      .card h3 {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: 500;
        color: var(--white);
      }

      .card p {
        font-size: 13px;
        color: var(--text-muted);
      }

      /* Form (Kanan) */
      .contact-form-container h2 {
        font-family: var(--font-heading);
        font-size: 40px;
        color: var(--gold);
        margin-bottom: 15px;
      }

      .form-desc {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 14px;
      }

      .form-group {
        margin-bottom: 20px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-light);
      }

      .form-group input,
      .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid rgba(201, 168, 76, 0.2);
        border-radius: 8px;
        font-family: var(--font-body);
        font-size: 14px;
        transition: all 0.3s ease;
        background: var(--navy-lighter);
        color: var(--text-light);
      }

      .form-group input:focus,
      .form-group textarea:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 15px rgba(201, 168, 76, 0.2);
      }

      .form-group input::placeholder,
      .form-group textarea::placeholder {
        color: var(--text-muted);
      }

      .submit-btn {
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--navy);
        border: none;
        padding: 15px 30px;
        width: 100%;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s ease;
        font-family: var(--font-body);
        letter-spacing: 1.5px;
        text-transform: uppercase;
      }

      .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(201, 168, 76, 0.4);
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
        font-family: "Playfair Display", serif;
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
        width: 36px;
        height: 36px;
        border: 1px solid rgba(201, 168, 76, 0.35);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        text-decoration: none;
        transition: all 0.3s;
        font-size: 14px;
        position: relative;
        overflow: hidden;
      }
      .social-links a::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
        content: "";
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 35px;
        height: 2px;
        background: var(--gold);
        transition: width 0.3s;
      }
      .footer-col:hover .footer-title::after {
        width: 100%;
      }
      .footer-links {
        list-style: none;
      }
      .footer-links li {
        margin-bottom: 10px;
      }
      .footer-links a {
        color: #888;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }
      .footer-links a::before {
        content: "→";
        color: var(--gold);
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s;
      }
      .footer-links a:hover {
        color: var(--gold);
        transform: translateX(4px);
      }
      .footer-links a:hover::before {
        opacity: 1;
        transform: translateX(0);
      }
      .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
        color: #888;
        font-size: 13px;
        transition: all 0.3s;
        cursor: pointer;
      }
      .footer-contact-item:hover {
        color: var(--gold);
        transform: translateX(5px);
      }
      .footer-contact-item i {
        color: var(--gold);
        margin-top: 3px;
        font-size: 14px;
        width: 18px;
        transition: transform 0.3s;
      }
      .footer-contact-item:hover i {
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
        transition: all 0.3s;
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
      .newsletter-form input::placeholder {
        color: #aaa;
      }
      .newsletter-form button {
        background: var(--gold);
        border: none;
        padding: 0 20px;
        color: var(--navy);
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
      }
      .newsletter-form button::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
      }
      .newsletter-form button:hover::before {
        width: 300px;
        height: 300px;
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
        bottom: 25px;
        right: 25px;
        width: 45px;
        height: 45px;
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
        transition: all 0.3s;
        z-index: 999;
        box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4);
        font-size: 16px;
      }
      .scroll-top.visible {
        opacity: 1;
        visibility: visible;
      }
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
      .toast i {
        font-size: 18px;
      }

      /* === SECTION DIVIDER === */
      .section-divider {
        width: 100%;
        height: 1px;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(201, 168, 76, 0.5),
          transparent
        );
        margin: 0;
        border: none;
        position: relative;
      }
      .section-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 1px;
        background: var(--gold);
      }
      .section-divider::after {
        content: "✦";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--gold);
        font-size: 14px;
        background: var(--navy);
        padding: 0 15px;
      }

      /* === FLOATING SHAPES BACKGROUND === */
      .floating-shapes {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
      }
      .shape {
        position: absolute;
        border: 1px solid rgba(201, 168, 76, 0.1);
        border-radius: 50%;
        animation: shapeFloat 15s infinite ease-in-out;
      }
      .shape-1 {
        width: 300px;
        height: 300px;
        top: 10%;
        left: -5%;
        animation-duration: 20s;
      }
      .shape-2 {
        width: 200px;
        height: 200px;
        top: 60%;
        right: -3%;
        animation-duration: 18s;
        animation-delay: 2s;
      }
      .shape-3 {
        width: 150px;
        height: 150px;
        bottom: 20%;
        left: 30%;
        animation-duration: 22s;
        animation-delay: 4s;
      }
      @keyframes shapeFloat {
        0%, 100% {
          transform: translate(0, 0) rotate(0deg);
        }
        25% {
          transform: translate(30px, -30px) rotate(90deg);
        }
        50% {
          transform: translate(-20px, 20px) rotate(180deg);
        }
        75% {
          transform: translate(20px, 10px) rotate(270deg);
        }
      }

      /* === PARTICLES === */
      .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
        overflow: hidden;
      }
      .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: var(--gold);
        border-radius: 50%;
        opacity: 0;
        animation: float 12s infinite;
      }
      @keyframes float {
        0% {
          transform: translateY(100vh) rotate(0deg);
          opacity: 0;
        }
        10% {
          opacity: 0.4;
        }
        90% {
          opacity: 0.4;
        }
        100% {
          transform: translateY(-100vh) rotate(720deg);
          opacity: 0;
        }
      }

      /* === ANIMATIONS === */
      @keyframes fadeInLeft {
        from {
          opacity: 0;
          transform: translateX(-40px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
      @keyframes fadeInRight {
        from {
          opacity: 0;
          transform: translateX(40px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }
      @keyframes bounce {
        0%, 100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-10px);
        }
      }

      /* === RESPONSIVE === */
      @media (max-width: 1024px) {
        .contact-section {
          grid-template-columns: 1fr;
        }
        .footer-content {
          grid-template-columns: 1fr 1fr;
        }
      }

      @media (max-width: 768px) {
        .navbar {
          padding: 0 30px;
        }
        .nav-links {
          position: fixed;
          top: 0;
          right: -100%;
          width: 75%;
          height: 100vh;
          background: var(--navy);
          flex-direction: column;
          padding: 100px 40px;
          transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
          border-left: 1px solid rgba(201, 168, 76, 0.2);
          gap: 30px;
        }
        .nav-links.active {
          right: 0;
        }
        .mobile-menu-btn {
          display: flex;
        }
        .hero-content h1 {
          font-size: 40px;
        }
        .contact-cards {
          grid-template-columns: 1fr;
        }
        .footer {
          padding: 35px 30px 25px;
        }
        .footer-content {
          grid-template-columns: 1fr;
          gap: 25px;
        }
        .footer-bottom {
          margin-left: -30px;
          margin-right: -30px;
        }
        .custom-cursor,
        .cursor-dot {
          display: none;
        }
        .floating-shapes {
          display: none;
        }
      }
    </style>
    <base target="_blank" />
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

    <!-- Floating Shapes Background -->
    <div class="floating-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
      <div class="search-box">
        <input type="text" placeholder="Cari produk..." id="searchInput" />
        <i class="fas fa-times search-close" onclick="toggleSearch()"></i>
      </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
      <i class="fas fa-check-circle"></i>
      <span id="toastText"></span>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
      <div
        class="logo"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
      >
        <img
          src="../Beranda/Gambarberanda/logo_caymira_modest.png"
          alt="Caymira Modest"
          class="logo-img"
        />
      </div>

      <ul class="nav-links" id="navLinks">
        <li><a href="../Beranda/beranda.php">Beranda</a></li>
        <li><a href="../About-us/aboutus.php">About Us</a></li>
        <li><a href="../best-seller/best-seller.php">Best Seller</a></li>
        <li><a href="../login_register/contact.php" class="active">Contact</a></li>
      </ul>

      <div class="nav-icons">
        <i class="fas fa-search" onclick="toggleSearch()"></i>

        <a href="../login_register/profil.php" style="color: inherit">
          <i class="fas fa-user"></i>
        </a>

        <div class="cart-icon">
          <i
            class="fas fa-shopping-cart"
            onclick="showToast('🛒 Menuju keranjang belanja...')"
          ></i>
        </div>

        <div
          class="mobile-menu-btn"
          id="mobileMenuBtn"
          onclick="toggleMobileMenu()"
        >
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>

    <header class="hero-section">
      <img src="banner hero.png" alt="Background" class="hero-bg-image">
      <div class="hero-content">
        <h1>Contact Us</h1>
      </div>
    </header>

    <div class="section-divider"></div>

    <section class="contact-section container">
      <div class="contact-cards">
        <div class="card">
          <i class="fa-solid fa-phone"></i>
          <h3>Phone</h3>
          <p>+62 823-4095-0845</p>
        </div>
        <div class="card">
          <i class="fa-brands fa-whatsapp"></i>
          <h3>WhatsApp</h3>
          <p>+62 895-7042-00408</p>
        </div>
        <div class="card">
          <i class="fa-solid fa-envelope"></i>
          <h3>Email</h3>
          <p>caymiramodest@gmail.com</p>
        </div>
        <div class="card">
          <i class="fa-solid fa-store"></i>
          <h3>Our Shop</h3>
          <p>JL. Batik Semar No, 24, Jakarta Selatan, 12430, Indonesia</p>
        </div>
      </div>

      <form id="contactForm">
       <div class="form-group">
          <label for="name">Name</label>
          <!-- Tambahkan name="nama" -->
          <input type="text" id="name" name="nama" placeholder="Your name..." required />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <!-- Tambahkan name="email" -->
          <input type="email" id="email" name="email" placeholder="example@gmail.com" required />
        </div>

        <div class="form-group">
          <label for="subject">Subject</label>
          <!-- Tambahkan name="subject" -->
          <input type="text" id="subject" name="subject" placeholder="Title..." required />
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <!-- Tambahkan name="pesan" -->
          <textarea id="message" name="pesan" rows="5" placeholder="Type here..." required></textarea>
        </div>

        <button type="submit" class="submit-btn">Send Now</button>
      </form>
    </section>

    <div class="section-divider"></div>

    <!-- Footer -->
    <footer class="footer" id="contact">
      <svg class="gold-branch-footer" viewBox="0 0 200 300" fill="none">
        <path
          d="M100 300 Q120 250 100 200 Q80 150 100 100 Q120 50 100 0"
          stroke="#c9a84c"
          stroke-width="1"
          fill="none"
          opacity="0.4"
        />
        <circle cx="100" cy="30" r="2" fill="#c9a84c" opacity="0.6" />
        <circle cx="110" cy="70" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="90" cy="110" r="2" fill="#c9a84c" opacity="0.7" />
        <circle cx="105" cy="150" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="95" cy="190" r="2" fill="#c9a84c" opacity="0.6" />
        <circle cx="115" cy="230" r="1.5" fill="#c9a84c" opacity="0.5" />
        <circle cx="85" cy="270" r="2" fill="#c9a84c" opacity="0.7" />
      </svg>

      <div class="footer-content">
        <div class="footer-brand">
          <div
            class="logo"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
          >
            <img
              src="../Beranda/Gambarberanda/logo_caymira_modest.png"
              alt="Caymira Modest"
              class="logo-img"
            />
          </div>

          <p>
            Fashion muslimah dengan desain modern, bahan berkualitas, dan nyaman
            dipakai setiap hari.
          </p>
          <div class="social-links">
            <a href="#" onclick="showToast('📸 Instagram: @caymiramodest')"
              ><i class="fab fa-instagram"></i
            ></a>
            <a href="#" onclick="showToast('💬 WhatsApp: 0895-7042-D0408')"
              ><i class="fab fa-whatsapp"></i
            ></a>
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
          <div
            class="footer-contact-item"
            onclick="showToast('🕐 Jam Operasional: Senin-Sabtu')"
          >
            <i class="far fa-clock"></i>
            <div>
              <div>Monday - Saturday</div>
              <div>10.00 - 17.00 WIB</div>
            </div>
          </div>
          <div
            class="footer-contact-item"
            onclick="showToast('📞 Hubungi: 0895-7042-D0408')"
          >
            <i class="fas fa-phone"></i>
            <div>0895-7042-D0408</div>
          </div>
          <div
            class="footer-contact-item"
            onclick="showToast('📧 Email: caymiramodest@gmail.com')"
          >
            <i class="far fa-envelope"></i>
            <div>caymiramodest@gmail.com</div>
          </div>
        </div>

        <div class="footer-col">
          <h4 class="footer-title">Newsletter</h4>
          <p class="newsletter-text">
            Dapatkan info terbaru & promo menarik dari Caymira Modest.
          </p>
          <form class="newsletter-form" onsubmit="handleSubscribe(event)">
            <input
              type="email"
              placeholder="Your email"
              required
              id="emailInput"
            />
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
      window.addEventListener("load", () => {
        setTimeout(() => {
          document.getElementById("loader").classList.add("hidden");
        }, 2000);
      });

      // ===== CUSTOM CURSOR =====
      const cursor = document.getElementById("cursor");
      const cursorDot = document.getElementById("cursorDot");

      document.addEventListener("mousemove", (e) => {
        cursor.style.left = e.clientX - 10 + "px";
        cursor.style.top = e.clientY - 10 + "px";
        cursorDot.style.left = e.clientX - 3 + "px";
        cursorDot.style.top = e.clientY - 3 + "px";
      });

      document
        .querySelectorAll(
          "a, button, i, .value-card, .contact-item, .category-item, .product-card, .feature-item, .btn-shop, .quick-view-btn"
        )
        .forEach((el) => {
          el.addEventListener("mouseenter", () => cursor.classList.add("hover"));
          el.addEventListener("mouseleave", () =>
            cursor.classList.remove("hover")
          );
        });

      // ===== PARTICLES =====
      function createParticles() {
        const container = document.getElementById("particles");
        for (let i = 0; i < 25; i++) {
          const particle = document.createElement("div");
          particle.className = "particle";
          particle.style.left = Math.random() * 100 + "%";
          particle.style.animationDelay = Math.random() * 12 + "s";
          particle.style.animationDuration = 10 + Math.random() * 8 + "s";
          particle.style.width = particle.style.height =
            2 + Math.random() * 3 + "px";
          container.appendChild(particle);
        }
      }
      createParticles();

      // ===== NAVBAR SCROLL =====
      window.addEventListener("scroll", () => {
        const navbar = document.getElementById("navbar");
        const scrollTop = document.getElementById("scrollTop");
        if (window.scrollY > 50) {
          navbar.classList.add("scrolled");
          scrollTop.classList.add("visible");
        } else {
          navbar.classList.remove("scrolled");
          scrollTop.classList.remove("visible");
        }
      });

      // ===== MOBILE MENU =====
      function toggleMobileMenu() {
        const navLinks = document.getElementById("navLinks");
        const menuBtn = document.getElementById("mobileMenuBtn");
        navLinks.classList.toggle("active");
        menuBtn.classList.toggle("active");
      }

      document.querySelectorAll(".nav-links a").forEach((link) => {
        link.addEventListener("click", () => {
          document.getElementById("navLinks").classList.remove("active");
          document.getElementById("mobileMenuBtn").classList.remove("active");
        });
      });

      // ===== SEARCH OVERLAY =====
      function toggleSearch() {
        const overlay = document.getElementById("searchOverlay");
        overlay.classList.toggle("active");
        if (overlay.classList.contains("active")) {
          setTimeout(() => document.getElementById("searchInput").focus(), 400);
        }
      }

      document
        .getElementById("searchOverlay")
        .addEventListener("click", (e) => {
          if (e.target === e.currentTarget) toggleSearch();
        });

      // ===== TOAST =====
      function showToast(message) {
        const toast = document.getElementById("toast");
        const toastText = document.getElementById("toastText");
        toastText.textContent = message;
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 3000);
      }

      // ===== NEWSLETTER =====
      function handleSubscribe(e) {
        e.preventDefault();
        const email = document.getElementById("emailInput").value;
        if (email) {
          showToast(
            "✅ Terima kasih telah berlangganan newsletter Caymira!"
          );
          document.getElementById("emailInput").value = "";
        }
      }

      // ===== SCROLL TO TOP =====
      function scrollToTop() {
        window.scrollTo({ top: 0, behavior: "smooth" });
      }

      // ===== SMOOTH SCROLL =====
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute("href"));
          if (target)
            target.scrollIntoView({ behavior: "smooth", block: "start" });
        });
      });

      // ===== ACTIVE NAV =====
      const sections = document.querySelectorAll("section, footer");
      const navItems = document.querySelectorAll(".nav-links a");

      window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach((section) => {
          if (scrollY >= section.offsetTop - 200) {
            current = section.getAttribute("id");
          }
        });
        navItems.forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href").slice(1) === current) {
            link.classList.add("active");
          }
        });
      });

      // ===== CONTACT FORM DENGAN AJAX =====
      document.addEventListener("DOMContentLoaded", () => {
        const contactForm = document.getElementById("contactForm");

        if (contactForm) {
         contactForm.addEventListener("submit", function (e) {
           e.preventDefault(); 
      
           const submitBtn = document.querySelector(".submit-btn");
           submitBtn.innerHTML = "Sending... <i class='fas fa-spinner fa-spin'></i>";
           submitBtn.disabled = true;

          // Mengambil semua data dari form
          const formData = new FormData(this);

          // Mengirim data ke proses_contact.php
        fetch("proses_contact.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
         if (data.status === "success") {
           showToast("✅ " + data.message);
           contactForm.reset(); // Kosongkan form jika sukses
          } else {
            showToast("❌ " + data.message);
          }
        })
        .catch(error => {
          showToast("❌ Terjadi kesalahan pada server.");
          console.error("Error:", error);
        })
        .finally(() => {
        // Kembalikan tombol seperti semula
         submitBtn.innerHTML = "Send Now";
         submitBtn.disabled = false;
        });
    });
  }
});

      // ===== KEYBOARD SHORTCUTS =====
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
          document.getElementById("searchOverlay").classList.remove("active");
        }
        if (e.key === "/" && !e.target.matches("input")) {
          e.preventDefault();
          toggleSearch();
        }
      });
    </script>
  </body>
</html>
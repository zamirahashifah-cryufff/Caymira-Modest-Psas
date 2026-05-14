<?php
session_start();
// Sambungkan ke database
include 'config/db.php';

$is_logged_in = false;
$username = "";
$email = "";

// Cek apakah ada sesi user_id (artinya user sudah login)
if (isset($_SESSION['user_id'])) {
    $is_logged_in = true;
    $user_id = $_SESSION['user_id'];
    
    // Ambil data username dan email dari database
    $query = mysqli_query($conn, "SELECT username, email FROM users WHERE id='$user_id'");
    if ($row = mysqli_fetch_assoc($query)) {
        $username = $row['username'];
        $email = $row['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - Caymira Modest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* GLOBAL RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f5f6fa; display: flex; flex-direction: column; min-height: 100vh; }

        /* ================= HEADER STYLING ================= */
        header {
            background-color: #0b1117; /* Warna gelap header */
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo { color: #d4af37; font-size: 28px; font-family: serif; font-weight: bold; letter-spacing: 1px;}
        .nav-links { display: flex; gap: 30px; }
        .nav-links a { color: white; text-decoration: none; font-size: 14px; font-weight: 600; letter-spacing: 1px;}
        .nav-icons { display: flex; gap: 20px; font-size: 22px; }
        .nav-icons a { color: white; text-decoration: none; transition: 0.3s; }
        .nav-icons a:hover { color: #d4af37; }

        /* ================= MAIN CONTENT STYLING ================= */
        main {
            flex: 1; /* Agar footer selalu di bawah */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }
        .profile-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
            text-align: center;
            border-top: 5px solid #d4af37; /* Garis emas di atas */
        }
        .profile-card h2 { color: #0b1117; margin-bottom: 20px; font-family: serif;}
        .user-data { text-align: left; background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #eee;}
        .user-data p { margin-bottom: 10px; color: #555; font-size: 16px;}
        .user-data strong { color: #0b1117; display: inline-block; width: 100px;}
        
        .btn { display: block; width: 100%; padding: 12px; margin-bottom: 15px; text-decoration: none; font-weight: bold; border-radius: 5px; border: none; cursor: pointer; transition: 0.3s;}
        .btn-gold { background-color: #d4af37; color: #0b1117; }
        .btn-gold:hover { background-color: #b8860b; color: white;}
        .btn-outline { background-color: transparent; border: 2px solid #0b1117; color: #0b1117; }
        .btn-outline:hover { background-color: #0b1117; color: white; }
        .btn-danger { background-color: #ff4757; color: white; }
        .btn-danger:hover { background-color: #ff6b81; }

        /* ================= FOOTER STYLING ================= */
        footer { background-color: white; color: #333; border-top: 1px solid #ddd; }
        .footer-top { display: flex; justify-content: space-between; padding: 50px; flex-wrap: wrap; gap: 30px;}
        .footer-left { max-width: 400px; }
        .footer-left h3 { color: #0b1117; font-family: serif; font-size: 24px; margin-bottom: 15px;}
        .footer-left p { color: #666; line-height: 1.6; margin-bottom: 20px; font-size: 14px;}
        .social-icons i { font-size: 24px; margin-right: 15px; color: #0b1117; cursor: pointer;}
        
        .footer-right { text-align: right; }
        .footer-right h4 { color: #0b1117; margin-bottom: 5px; font-size: 16px;}
        .footer-right p { color: #666; font-size: 14px; margin-bottom: 20px;}
        
        .footer-bottom { background-color: black; color: white; text-align: center; padding: 15px; font-size: 13px; }
    </style>
</head>
<body>

    <header>
        <div class="logo">caymiramodest</div>
        <div class="nav-links">
            <a href="#">ABOUT US</a>
            <a href="#">CONTACT</a>
            <a href="#">BEST SELLER</a>
        </div>
        <div class="nav-icons">
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
            <a href="profile.php"><i class="far fa-user"></i></a>
        </div>
    </header>

    <main>
        <div class="profile-card">
            <?php if ($is_logged_in): ?>
                <i class="far fa-user-circle" style="font-size: 70px; color: #d4af37; margin-bottom: 20px;"></i>
                <h2>Profil Akun</h2>
                
                <div class="user-data">
                    <p><strong>Username</strong> : <?php echo $username; ?></p>
                    <p><strong>Email</strong> : <?php echo $email; ?></p>
                </div>
                
                <a href="logout.php" class="btn btn-danger">Keluar (Logout)</a>
                
            <?php else: ?>
                <i class="fas fa-lock" style="font-size: 60px; color: #ccc; margin-bottom: 20px;"></i>
                <h2>Anda Belum Login</h2>
                <p style="color: #666; margin-bottom: 25px;">Silakan masuk ke akun Anda untuk melihat detail profil dan pesanan.</p>
                
                <a href="login.php" class="btn btn-gold">LOGIN SEKARANG</a>
                <a href="register.php" class="btn btn-outline">BUAT AKUN BARU</a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-top">
            <div class="footer-left">
                <div class="logo" style="font-size: 20px; margin-bottom: 10px;">caymiramodest</div>
                <h3>CAYMIRA MODEST</h3>
                <p>Caymira Modest - Tampil syar'i, elegan & berkelas dengan koleksi busana muslim masa kini. Mewujudkan cantik sesuai syariat.</p>
                <div class="social-icons">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-whatsapp"></i>
                </div>
            </div>
            <div class="footer-right">
                <h4>Customer Service</h4>
                <p>Monday to Saturday: 9am - 5pm EST<br>0895-7042-00408</p>
                <h4>Email us</h4>
                <p>caymiramodest@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            Copyright 2023 Caymira Modest. All Rights Reserved.
        </div>
    </footer>

</body>
</html>
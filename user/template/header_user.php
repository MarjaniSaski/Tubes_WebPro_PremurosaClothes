<?php
session_start(); // Memulai sesi

// Periksa apakah pengguna sudah login dan memiliki peran yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php"); // Redirect ke login jika belum login
    exit;
}
define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
       .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 171, 225, 0.95); /* Warna pink dengan sedikit transparansi */
            backdrop-filter: blur(5px);
            transition: box-shadow 0.3s ease;
        }


        body {
            padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }

        .navbar-links a {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #FF1493;
            transition: width 0.3s ease;
        }

        .navbar-links a:hover::after {
            width: 100%;
        }

        .nav-icon {
            transition: transform 0.2s ease;
        }

        .nav-icon:hover {
            transform: scale(1.1);
        }

        .logo-container img {
            height: 40px; /* Sesuaikan ukuran logo */
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        /* Mobile Menu Styles */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(255, 171, 225, 0.98);
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                padding: 1rem;
                border-radius: 0 0 10px 10px;
            }

            .navbar-links {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }

            .user-menu {
                margin-top: 15px;
                justify-content: center;
            }

            body {
                padding-top: 70px;
            }
        }

        /* Animasi untuk menu mobile */
        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Custom hover effects untuk icon */
        .bi {
            transition: all 0.2s ease;
        }

        .bi:hover {
            color: #FF1493;
        }
    </style>
</head>
<body class="bg-gray-50">
    <header>
        <nav class="navbar p-3 shadow-sm">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Navigation Links -->
                <div class="d-flex gap-4 navbar-links">
                    <a href="indexuser.php" class="text-dark text-decoration-none fw-bold text-sm">HOME</a>
                    <a href="newarrival.php" class="text-dark text-decoration-none fw-bold text-sm">NEW ARRIVAL</a>
                    <a href="product.php" class="text-dark text-decoration-none fw-bold text-sm">PRODUCT</a>
                    <a href="menuswap.php" class="text-dark text-decoration-none fw-bold text-sm">SWAP</a>
                </div>
    
                <!-- Logo -->
                <div class="d-flex justify-content-center">
                    <img src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Logo" class="h-10">
                </div>
    
                <!-- User Menu -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Membungkus teks Hi dengan tag <a> untuk mengarahkan ke profil -->
                    <a href="profile.php" class="text-dark text-decoration-none d-flex align-items-center gap-1">
    <span class="fw-bold text-sm">Hi, <?php echo $_SESSION['username']; ?></span>
</a>


                    <a href="wishlist.php" class="text-dark text-lg nav-icon"><i class="bi bi-heart"></i></a>
                    <a href="pencarian.php" class="text-dark text-lg nav-icon"><i class="bi bi-search"></i></a>
                    <a href="keranjang.php" class="text-dark text-lg nav-icon"><i class="bi bi-cart2"></i></a>
                    <a href="chat.php" class="text-dark text-lg nav-icon"><i class="bi bi-chat-dots"></i></a>
                    <a href="notifikasi.php" class="text-dark text-lg nav-icon"><i class="bi bi-bell"></i></a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Script Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menambahkan shadow saat scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 0) {
                navbar.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>

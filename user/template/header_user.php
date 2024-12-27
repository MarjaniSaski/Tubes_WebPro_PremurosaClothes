<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php"); // Redirect ke login jika belum login
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes');

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan foto profil pengguna
$sql = "SELECT foto FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Tentukan apakah menggunakan ikon default atau gambar profil
$is_default_picture = empty($user_data['foto']);
$profile_picture_url = !$is_default_picture ? HOST . "/images/" . htmlspecialchars($user_data['foto']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 171, 225, 0.95);
            backdrop-filter: blur(5px);
            transition: box-shadow 0.3s ease;
        }

        body {
            padding-top: 80px;
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
            font-size: 24px; 
        }

        .nav-icon:hover {
            transform: scale(1.1);
        }

        .logo-container img {
            height: 40px;
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        .profile-picture {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 25px;
            background-color: #f8f9fa;
            border-radius: 50%;
            overflow: hidden;
        }

        .dropdown-menu {
            margin-top: 15px !important;
            width: 250px;
        }

        .dropdown-item {
            padding: 0.625rem 1rem;
            font-size: 0.95rem;
            color: #333;
        }

        .dropdown-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
            border-color: grey;
        }

        .dropdown-menu .fa-solid, 
        .dropdown-menu .fa-heart, 
        .dropdown-menu .fa-gear {
            color: #ff69b4;
        }

        .dropdown-menu .fa-right-from-bracket, 
        .dropdown-menu .text-danger {
            color: #ff0000 !important;
        }

        /* Menu chat */
        .floating-chat {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #655D8A;
            color: #fff;
            padding: 10px 15px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 1100;
        }

        .floating-chat:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }

        .floating-chat i {
            font-size: 20px;
        }

        .floating-chat span {
            font-size: 16px;
            font-weight: bold;
        }

        /* Mobile Menu */
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

        /* Hover effects untuk icon */
        .bi {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar p-3 shadow-sm">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Navigation -->
                <div class="d-flex gap-4 navbar-links">
                    <a href="indexuser.php" class="text-dark text-decoration-none fw-bold text-sm">HOME</a>
                    <a href="product.php" class="text-dark text-decoration-none fw-bold text-sm">PRODUCT</a>
                    <a href="menuswap.php" class="text-dark text-decoration-none fw-bold text-sm">SWAP</a>
                    <a href="productthrift.php" class="text-dark text-decoration-none fw-bold text-sm">THRIFT</a>
                </div>

                <!-- Logo -->
                <div class="d-flex justify-content-center">
                    <img src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Logo" class="h-10">
                </div>

                <!-- User Menu -->
                <div class="d-flex align-items-center gap-3">
                    <a href="pencarian.php" class="text-dark text-lg nav-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                    <a href="notifikasi.php" class="text-dark text-lg nav-icon">
                        <i class="bi bi-bell-fill"></i>
                    </a>
                    <a href="keranjang.php" class="text-dark text-lg nav-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <div class="vr"></div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-picture">
                                <?php if ($is_default_picture): ?>
                                    <i class="fa-solid fa-user-circle"></i>
                                <?php else: ?>
                                    <img src="<?= $profile_picture_url ?>" alt="User Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <span class="ms-2 fw-bold text-sm">Hi, <?= htmlspecialchars($_SESSION['username']); ?></span>
                            <i class="bi bi-chevron-down ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUserMenu">
                            <li class="px-3 py-2 d-flex flex-column align-items-center border-bottom">
                                <div class="profile-picture" style="width: 70px; height: 70px;">
                                    <?php if ($is_default_picture): ?>
                                        <i class="fa-solid fa-user-circle"></i>
                                    <?php else: ?>
                                        <img src="<?= $profile_picture_url ?>" alt="User Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                                <span class="fw-semibold"><?= htmlspecialchars($_SESSION['username']); ?></span>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2" href="profile.php">
                                <i class="fa-solid fa-user"></i>
                                My Profile
                            </a></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2" href="wishlist.php">
                                <i class="fa-solid fa-heart"></i>
                                Wishlist
                            </a></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2" href="settings.php">
                                <i class="fa-solid fa-gear"></i>
                                Settings
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="../login.php">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Menu chat -->
    <div class="floating-chat" onclick="window.location.href='chat.php'">
        <i class="bi bi-chat-right-dots-fill"></i>
        <span>Chat</span>
    </div>
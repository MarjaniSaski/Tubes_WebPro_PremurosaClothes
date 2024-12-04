<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}
define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes')
?>
<!DOCTYPE html>
<html lang="en">
<!-- <head> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Premurosa Clothes</title>
</head>


<body class="bg-gray-50">
    <header>
        <nav class="bg-pink-300 navbar navbar-expand-lg p-3 sticky-top shadow-sm">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Navigation Links -->
                <div class="d-flex gap-4">
                    <a href="indexuser.php" class="text-dark text-decoration-none fw-bold text-sm">HOME</a> <!-- Diubah -->
                    <a href="#" class="text-dark text-decoration-none fw-bold text-sm">NEW ARRIVAL</a>
                    <a href="#" class="text-dark text-decoration-none fw-bold text-sm">PRODUCT</a>
                    <a href="menuswap.php" class="text-dark text-decoration-none fw-bold text-sm">SWAP</a>
                </div>
    
                <!-- Logo -->
                <div class="d-flex justify-content-center">
                    <img src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Logo" class="h-10">
                </div>
    
                <!-- User Menu -->
                <div class="d-flex align-items-center gap-3">
                    <a href="profile.php" class="text-dark text-decoration-none d-flex align-items-center gap-1">
                        <span class="fw-bold text-sm">Hi, <?php echo $_SESSION['username']; ?></span>
                        <a href="<?= HOST ?>/login.php" class="text-dark text-decoration-none fw-bold text-sm">Logout</a>
                    </a>
                    <a href="#" class="text-dark text-lg"><i class="bi bi-heart"></i></a>
                    <a href="#" class="text-dark text-lg"><i class="bi bi-search"></i></a>
                    <a href="#" class="text-dark text-lg"><i class="bi bi-cart2"></i></a>
                    <a href="#" class="text-dark text-lg"><i class="bi bi-chat-dots"></i></a>
                    <a href="#" class="text-dark text-lg"><i class="bi bi-bell"></i></a>
                </div>
            </div>
        </nav>
    </header>
<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: #fff;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown.show .dropdown-content {
        display: block;
    }

    .dropdown-button {
        cursor: pointer;
    }

    .sidebar a {
        color: black;
        transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a:hover, .sidebar .active {
        background-color:rgba(138, 65, 216, 0.85); 
        color: white;
    }

    .sidebar .active {
        background-color: rgba(138, 65, 216, 0.85);
        color: white;
    }

    </style>

</head>

<body class="bg-gray-100 font-rubik">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white text-black flex flex-col p-6 sidebar fixed h-full">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img class="justify-content-center" src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Homes Logo" width="150" height="auto">
            </div>

            <!-- Menu Items -->
            <div class="relative">
                <ul class="text-black">
                    <li class="mb-5">
                        <a href="dashboard.php?page=dashboard" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="bi bi-grid-fill me-2"></i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="producthome.php?page=products" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="bi bi-box-seam me-2"></i>
                            <span>PRODUCTS</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="orderlist.php?page=orders" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="fa-solid fa-list-check me-2"></i>
                            <span>ORDER LIST</span>
                        </a>
                    </li>
                    <li class="mb-4 dropdown">
                        <a href="#" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition dropdown-button">
                            <i class="fa-solid fa-repeat me-2"></i>
                            <span>SWAP</span>
                            <i class="fa-solid fa-chevron-down ml-2"></i>
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-content p-2">
                            <a href="swappoin.php" class="block px-4 py-2 text-black hover:bg-pink-200 transition">Tukar Poin</a>
                            <a href="swapproduct.php" class="block px-4 py-2 text-black hover:bg-pink-200 transition">Tukar Product</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">

        <?php
        // Mendapatkan parameter page dari URL, jika tidak ada defaultnya 'Dashboard'
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

        // Menentukan teks header berdasarkan nilai parameter page
        switch ($page) {
            case 'dashboard':
                $headerText = 'Dashboard';
                break;
            case 'products':
                $headerText = 'Products';
                break;
            case 'orders':
                $headerText = 'Order List';
                break;
            case 'swap':
                $headerText = 'Swap';
                break;
            case 'swappoin.php':
                $headerText = 'Tukar Poin';
                break;
            case 'swapproduct':
                $headerText = 'Tukar Product';
                break;
            default:
                $headerText = 'Dashboard';
        }
        ?>

        <!-- Header -->
        <div class="bg-white p-4 flex justify-between items-center sticky-header">
            <div>
                <h1 class="text-xl font-bold"><?= $headerText ?></h1>
                <p id="update-time" class="text-gray-500 text-sm"></p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Logout Button with Link -->
                <a href="<?= HOST ?>/login.php" class="relative group">
                    <button class="bg-purple-600 w-10 h-10 flex items-center justify-center rounded-full shadow-md text-white hover:bg-purple-700 hover:scale-105 transition-transform duration-200">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                    <span class="absolute top-12 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Logout
                    </span>
                </a>
            </div>
        </div>

        <script>
            // JavaScript untuk toggle dropdown ketika menu SWAP diklik
            const dropdownButton = document.querySelector('.dropdown-button');
            const dropdownMenu = document.querySelector('.dropdown');

            dropdownButton.addEventListener('click', (e) => {
                dropdownMenu.classList.toggle('show');
            });

            // Update waktu pada halaman
            const currentDate = new Date();
            const gmtOffset = currentDate.getTimezoneOffset() / 60;
            const gmtHour = gmtOffset > 0 ? `GMT-${gmtOffset}` : `GMT+${Math.abs(gmtOffset)}`;
            const hours = currentDate.getHours();
            const minutes = currentDate.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;
            
            document.getElementById('update-time').textContent = `Waktu update terakhir: ${gmtHour} ${time}`;

            // JavaScript untuk menandai menu aktif
            document.addEventListener('DOMContentLoaded', function() {
                const menuItems = document.querySelectorAll('.sidebar a');
                
                menuItems.forEach(item => {
                    // Cek apakah link menu sesuai dengan halaman yang aktif
                    if (window.location.href.includes(item.getAttribute('href'))) {
                        item.classList.add('active'); // Menambahkan kelas 'active' ke item menu
                    }
                });
            });

        </script>
</body>

</html>

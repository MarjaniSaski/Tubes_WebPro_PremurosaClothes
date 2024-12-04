<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect jika bukan admin
    exit;
}
define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes')

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Rubik font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 min-h-screen bg-white p-4">
            <!-- Logo -->
            <div class="flex justify-center">
                <img class="justify-content-center" src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Homes Logo" width="150" height="auto">
            </div>

            <!-- Menu Items -->

            <div class="relative">
                <!-- Button to trigger dropdown -->
                <button class="block px-4 py-2 text-white mt-2 w-48 bg-purple-400 font-semibold hover:bg-purple-200 transition-all duration-300 rounded-lg flex items-center space-x-2">
                    <!-- Icon on the left side of the text -->
                    <i class="bi bi-list"></i><span>Menu</span>
                </button>


                <!-- Dropdown Menu -->
                <ul class="absolute hidden bg-white shadow-lg rounded-lg mt-2 w-48 text-black">
                    <li class="mb-5">
                        <a href="dashboard.php" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="bi bi-grid-fill me-2"></i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="producthome.php" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="bi bi-box-seam"></i>
                            <span>PRODUCTS</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="orderlist.php" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="fa-solid fa-list-check"></i>
                            <span>ORDER LIST</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="adminswap.php" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="fa-solid fa-repeat"></i>
                            <span>SWAP</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 transition">
                            <i class="fa-regular fa-envelope"></i>
                            <span>MESSAGE</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            // JavaScript to toggle the dropdown visibility
            const button = document.querySelector('button');
            const dropdown = document.querySelector('ul');

            button.addEventListener('click', () => {
                dropdown.classList.toggle('hidden');
            });
        </script>
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

        .sidebar a:hover,
        .sidebar .active {
            background-color: rgba(138, 65, 216, 0.85);
            color: white;
        }

        .sidebar .active {
            background-color: rgba(138, 65, 216, 0.85);
            color: white;
        }

        .dropdown-content {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body class="bg-gray-100 font-rubik">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white text-black flex flex-col p-6 sidebar fixed h-full">
            <div class="flex justify-center mb-8">
                <img src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Clothes Logo" width="150">
            </div>
            <ul class="text-black">
                <li class="mb-5">
                    <a href="dashboard.php?page=dashboard" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="bi bi-grid-fill"></i> DASHBOARD
                    </a>
                </li>
                <li class="mb-4">
                    <a href="producthome.php?page=products" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="bi bi-box-seam"></i> PRODUCTS
                    </a>
                </li>
                <li class="mb-4">
                    <a href="orderlist.php?page=orders" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-solid fa-list-check"></i> ORDER LIST
                    </a>
                </li>
                <!-- Dropdown -->
                <li class="mb-4 dropdown">
                    <a href="#" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 dropdown-button">
                        <i class="fa-solid fa-repeat"></i> SWAP
                        <i class="fa-solid fa-chevron-down ml-2"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="swappoin.php" class="block px-4 py-2 text-black hover:bg-pink-200">Tukar Poin</a>
                        <a href="swapproduct.php" class="block px-4 py-2 text-black hover:bg-pink-200">Tukar Produk</a>
                    </div>
                </li>
                <li class="mb-4">
                    <a href="message.php?page=message" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-regular fa-envelope"></i> MESSAGE
                    </a>
                </li>
                <li class="mb-4">
                    <a href="notification.php?page=notification" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-regular fa-bell"></i> NOTIFICATION
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <div class="bg-white p-4 sticky-header flex justify-between items-center">
                <h1 class="text-xl font-bold">Dashboard</h1>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.querySelector('.dropdown-button');
            const dropdown = document.querySelector('.dropdown');

            dropdownButton.addEventListener('click', function (e) {
                e.preventDefault();
                dropdown.classList.toggle('show');
            });
        });
    </script>
</body>

</html>

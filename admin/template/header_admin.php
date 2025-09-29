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
            padding-left: 1rem;
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
            display: flex;
            align-items: center; /* Membuat ikon dan teks sejajar */
        }

        .sidebar a:hover,
        .sidebar .dropdown.show .dropdown-button {
            background-color: rgba(138, 65, 216, 0.85);
            color: white;
        }

        .sidebar .dropdown.show .dropdown-content {
            display: block;
        }

        .sidebar .active {
            background-color: rgba(138, 65, 216, 0.85);
            color: white;
        }

        .sidebar a i {
            margin-right: 15px; /* Tambahkan jarak antara ikon dan teks */
            vertical-align: middle;
        }

        .dropdown-content {
            background-color: #fff;
            padding: 10px;
            margin-top: 10px;
        }

        .dropdown-content a {
            padding: 0.5rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.375rem;
        }

        .dropdown-content a:hover {
            background-color: rgba(138, 65, 216, 0.85);
            color: black;
        }

        .dropdown-content a.active {
            background-color: rgba(138, 65, 216, 0.85);
            color: white;
        }

        .dropdown.show .dropdown-button .fa-chevron-down {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .fa-chevron-down {
            transition: transform 0.3s ease;
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
                        <i class="bi bi-grid-fill"></i> Beranda
                    </a>
                </li>
                <li class="mb-4">
                    <a href="producthome.php?page=products" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                </li>
                <li class="mb-4">
                    <a href="orderlist.php?page=orders" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-solid fa-list-check"></i> Daftar Pesanan
                    </a>
                </li>
                <li class="mb-4 dropdown">
                    <a href="#" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200 dropdown-button">
                        <i class="fa-solid fa-repeat"></i> Tukar
                        <i class="fa-solid fa-chevron-down ml-2"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="swappoin.php?page=swappoin" class="block px-4 py-2 text-black hover:bg-pink-200">
                            <i class="bi bi-coin"></i> Tukar Poin
                        </a>
                        <a href="swapproduct.php?page=swapproduct" class="block px-4 py-2 text-black hover:bg-pink-200">
                            <i class="bi bi-bag"></i> Tukar Produk
                        </a>
                    </div>
                </li>
                <li class="mb-4">
                    <a href="message.php?page=message" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-regular fa-envelope"></i> Pesan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="notification.php?page=notification" class="block px-4 py-2 rounded font-semibold hover:bg-pink-200">
                        <i class="fa-regular fa-bell"></i> Notifikasi
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">

        <?php
        // Mendapatkan parameter page dari URL, jika tidak ada defaultnya 'Dashboard'
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

        // Menentukan teks header berdasarkan nilai parameter page
        switch ($page) {
            case 'dashboard':
                $headerText = 'Beranda';
                break;
            case 'products':
                $headerText = 'Produk';
                break;
            case 'orders':
                $headerText = 'Daftar Pesanan';
                break;
            case 'swappoin':
                $headerText = 'Tukar Poin';
                break;
            case 'swapproduct':
                $headerText = 'Tukar Produk';
                break;
            case 'message':
                $headerText = 'Pesan';
                break;
            case 'notification':
                $headerText = 'Notifikasi';
                break;
            case 'detailproduk':
                $headerText = 'Detail Produk';
                break;
            case 'newproduk':
                $headerText = 'Tambah Produk';
                break;
            case 'adminswap':
                $headerText = 'Penukaran';
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
                        Keluar
                    </span>
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dropdownButton = document.querySelector('.dropdown-button');
                const dropdown = document.querySelector('.dropdown');
                const dropdownContent = document.querySelector('.dropdown-content');

                function isChild(child, parent) {
                    let node = child.parentNode;
                    while (node != null) {
                        if (node === parent) {
                            return true;
                        }
                        node = node.parentNode;
                    }
                    return false;
                }

                // Menangani klik pada tombol dropdown
                dropdownButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    dropdown.classList.toggle('show');

                    // Tambahkan atau hapus kelas 'active' pada tombol dropdown
                    if (dropdown.classList.contains('show')) {
                        dropdownButton.classList.add('active');
                    } else {
                        dropdownButton.classList.remove('active');
                    }
                });

                dropdownContent.addEventListener('click', function (e) {
                    // Don't close dropdown when clicking items
                    e.stopPropagation();
                });


                // Menandai menu aktif berdasarkan URL
                const menuItems = document.querySelectorAll('.sidebar a');
                const currentUrl = window.location.href;

                menuItems.forEach(item => {
                    if (currentUrl.includes(item.getAttribute('href'))) {
                        item.classList.add('active');
                        if (item.closest('.dropdown-content')) {
                            dropdown.classList.add('show');
                            dropdownButton.classList.add('active'); // Tandai menu utama "Swap" juga
                        }
                    }
                });
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

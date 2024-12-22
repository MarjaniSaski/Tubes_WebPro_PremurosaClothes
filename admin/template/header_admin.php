<?php 
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit; // Pastikan eksekusi dihentikan setelah header
}
define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes');

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Rubik font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-rubik">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white text-black flex flex-col p-6 sidebar fixed h-full">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img class="justify-content-center" src="<?= HOST ?>/foto/logoPremurosa.png" alt="Premurosa Homes Logo" width="150" height="auto">
            </div>

            <!-- Menu Items -->
            <ul class="space-y-4">
                <li>
                    <a href="dashboard.php" 
                       class="block px-4 py-2 rounded-lg font-semibold transition 
                              <?= $current_page == 'dashboard.php' ? 'bg-purple-400 text-white' : 'hover:bg-purple-400'; ?>">
                        <i class="bi bi-grid-fill me-2"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a href="producthome.php" 
                       class="block px-4 py-2 rounded-lg font-semibold transition 
                              <?= $current_page == 'producthome.php' ? 'bg-purple-400 text-white' : 'hover:bg-purple-400'; ?>">
                        <i class="bi bi-box-seam"></i>
                        <span>PRODUCTS</span>
                    </a>
                </li>
                <li>
                    <a href="orderlist.php" 
                       class="block px-4 py-2 rounded-lg font-semibold transition 
                              <?= $current_page == 'orderlist.php' ? 'bg-purple-400 text-white' : 'hover:bg-purple-400'; ?>">
                        <i class="fa-solid fa-list-check"></i>
                        <span>ORDER LIST</span>
                    </a>
                </li>
                <li>
                    <a href="adminswap.php" 
                       class="block px-4 py-2 rounded-lg font-semibold transition 
                              <?= $current_page == 'adminswap.php' ? 'bg-purple-400 text-white' : 'hover:bg-purple-400'; ?>">
                        <i class="fa-solid fa-repeat"></i>
                        <span>SWAP</span>
                    </a>
                </li>
                <li>
                    <a href="#" 
                       class="block px-4 py-2 rounded-lg font-semibold transition 
                              <?= $current_page == '#' ? 'bg-purple-400 text-white' : 'hover:bg-purple-400'; ?>">
                        <i class="fa-regular fa-envelope"></i>
                        <span>MESSAGE</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <div class="bg-white p-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">Dashboard</h1>
                    <p id="update-time" class="text-gray-500 text-sm"></p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Button with Link -->
                    <a href="notifications.php" class="relative group">
                        <button 
                            class="bg-purple-600 w-10 h-10 flex items-center justify-center rounded-full shadow-md text-white 
                                hover:bg-purple-700 hover:scale-105 transition-transform duration-200">
                            <i class="fa-regular fa-bell"></i>
                        </button>
                        <span 
                            class="absolute bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs 
                                px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            Notification
                        </span>
                    </a>

                    <!-- Logout Button with Link -->
                    <a href="<?= HOST ?>/login.php" class="relative group">
                        <button 
                            class="bg-purple-600 w-10 h-10 flex items-center justify-center rounded-full shadow-md text-white 
                                hover:bg-purple-700 hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                        <span 
                            class="absolute bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs 
                                px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            Logout
                        </span>
                    </a>
                </div>
            </div>

            <script>
                // Mendapatkan waktu lokal pengguna
                const currentDate = new Date();

                // Mendapatkan zona waktu GMT dari pengguna
                const gmtOffset = currentDate.getTimezoneOffset() / 60; // Menghitung perbedaan zona waktu dalam jam
                const gmtHour = gmtOffset > 0 ? `GMT-${gmtOffset}` : `GMT+${Math.abs(gmtOffset)}`;

                // Mengambil waktu lokal
                const hours = currentDate.getHours();
                const minutes = currentDate.getMinutes().toString().padStart(2, '0'); // Menambahkan 0 di depan menit jika kurang dari 10

                // Format waktu yang diinginkan
                const time = `${hours}:${minutes}`;

                // Menampilkan waktu yang telah diformat dalam elemen <p>
                document.getElementById('update-time').textContent = `Waktu update terakhir: ${gmtHour} ${time}`;
            </script>
</body>
</html>
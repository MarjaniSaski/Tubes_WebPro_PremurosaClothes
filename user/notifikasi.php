<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes - Notifications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <style>
        :root {
            --pink-primary: #FF69B4;
            --pink-light: #FFB6C1;
            --paink-dark: #FF1493;
        }

        .notification-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .notification-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .notification-card.unread {
            background-color: #FFF5F7;
            border-left: 4px solid var(--pink-primary);
        }

        .notification-badge {
            background-color: var(--pink-primary);
            color: white;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 9999px;
        }

        .delete-btn {
            color: #dc3545;
            transition: color 0.2s;
        }

        .delete-btn:hover {
            color: #bb2d3b;
        }

        .notification-icon {
            background-color: #FFF5F7;
            color: var(--pink-primary);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-xl font-semibold text-gray-700">Notifikasi</h1>
                <span class="notification-badge">3</span>
            </div>

            <!-- Item Notifikasi -->
            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="notification-card unread p-4 rounded-lg flex items-center gap-4 shadow">
                    <div class="notification-icon p-3 rounded-full">
                        <i class="bi bi-tag-fill text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-800">Diskon Spesial Hari Ini!</h2>
                        <p class="text-sm text-gray-600">Dapatkan diskon 30% untuk semua produk fashion hari ini</p>
                        <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                            <i class="bi bi-clock"></i>5 menit yang lalu
                        </span>
                    </div>
                    <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                        <i class="bi bi-trash text-lg"></i>
                    </button>
                </div>

                <!-- Item 2 -->
                <div class="notification-card p-4 rounded-lg flex items-center gap-4">
                    <div class="notification-icon p-3 rounded-full">
                        <i class="bi bi-box-seam text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-800">Pesanan Dikonfirmasi</h2>
                        <p class="text-sm text-gray-600">Pesanan #12345 telah dikonfirmasi dan sedang diproses</p>
                        <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                            <i class="bi bi-clock"></i>1 jam yang lalu
                        </span>
                    </div>
                    <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                        <i class="bi bi-trash text-lg"></i>
                    </button>
                </div>

                <!-- Item 3 -->
                <div class="notification-card unread p-4 rounded-lg flex items-center gap-4">
                    <div class="notification-icon p-3 rounded-full">
                        <i class="bi bi-stars text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-800">Koleksi Baru Telah Tiba!</h2>
                        <p class="text-sm text-gray-600">Jangan lewatkan koleksi terbaru musim semi kami</p>
                        <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                            <i class="bi bi-clock"></i>2 jam yang lalu
                        </span>
                    </div>
                    <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                        <i class="bi bi-trash text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include "template/footer_user.php";
?>
</html>

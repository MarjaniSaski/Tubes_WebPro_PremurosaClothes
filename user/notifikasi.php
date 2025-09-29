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
            --pink-dark: #FF1493;
        }

        .notification-card {
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: white; /* Default color */
            border-left: 4px solid transparent; /* No border initially */
        }

        .notification-card.checked {
            background-color: var(--pink-light); /* Pink color when read */
            border-left: 4px solid var(--pink-primary); /* Pink left border */
        }

        .notification-badge {
            background-color: var(--pink-primary);
            color: white;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 9999px;
        }

        .notification-icon {
            background-color: #FFF5F7;
            color: var(--pink-primary);
        }

        /* Styling untuk checkbox */
        .checkbox-btn {
            cursor: pointer;
            width: 20px;
            height: 20px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 2px solid var(--pink-primary);
            border-radius: 4px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .checkbox-btn:checked {
            background-color: var(--pink-primary);
            border-color: var(--pink-dark);
        }

        .checkbox-btn:checked::before {
            content: '✔';
            color: white;
            position: absolute;
            top: 0;
            left: 4px;
            font-size: 14px;
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
                <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
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
                    <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
                </div>

                <!-- Item 2 -->
                <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
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
                    <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
                </div>

                <!-- Item 3 -->
                <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
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
                    <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
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

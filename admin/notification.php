<?php include "template/header_admin.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Notifications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <style>
        :root {
            --purple-primary: #9333EA;
            --purple-light: #F3E8FF;
            --purple-dark: #7E22CE;
        }

        .notification-card {
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: white;
            border-left: 4px solid transparent;
        }

        .notification-card.checked {
            background-color: var(--purple-light);
            border-left: 4px solid var(--purple-primary);
        }

        .notification-badge {
            background-color: var(--purple-primary);
            color: white;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 9999px;
        }

        .notification-icon {
            background-color: #F3E8FF;
            color: var(--purple-primary);
        }

        .checkbox-btn {
            cursor: pointer;
            width: 20px;
            height: 20px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 2px solid var(--purple-primary);
            border-radius: 4px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .checkbox-btn:checked {
            background-color: var(--purple-primary);
            border-color: var(--purple-dark);
        }

        .checkbox-btn:checked::before {
            content: '✔';
            color: white;
            position: absolute;
            top: 0;
            left: 4px;
            font-size: 14px;
        }
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1; /* Ini penting - membuat main mengisi ruang tersedia */
        }
        .content-container {
            flex: 1 0 auto;
            padding-bottom: 2rem; /* Memberikan jarak dengan footer */
        }

        footer {
            margin-top: auto; /* Mendorong footer ke bawah */
            flex-shrink: 0;
            width: 100%;
            border-top: 1px ;
            position: fixed;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="content-container">
        <main>
            <div class="container mx-auto py-6 px-4">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <h1 class="text-xl font-semibold text-gray-700">Notifikasi</h1>
                        <span class="notification-badge">3</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Notifikasi Pesanan Baru -->
                        <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
                            <div class="notification-icon p-3 rounded-full">
                                <i class="fas fa-shopping-bag text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-medium text-gray-800">Pesanan Baru #12345</h2>
                                <p class="text-sm text-gray-600">Amanda Salima - Rp 299.000</p>
                                <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                                    <i class="fas fa-clock"></i>2 menit yang lalu
                                </span>
                            </div>
                            <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
                        </div>

                        <!-- Notifikasi Penjemputan -->
                        <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
                            <div class="notification-icon p-3 rounded-full">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-medium text-gray-800">Permintaan Penjemputan #89012</h2>
                                <p class="text-sm text-gray-600">Lokasi: Jl. Sukajadi No. 123, Bandung</p>
                                <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                                    <i class="fas fa-clock"></i>5 menit yang lalu
                                </span>
                            </div>
                            <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
                        </div>

                        <!-- Notifikasi Pesanan Lain -->
                        <div class="notification-card p-4 rounded-lg flex items-center gap-4 shadow">
                            <div class="notification-icon p-3 rounded-full">
                                <i class="fas fa-shopping-bag text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-medium text-gray-800">Pesanan Baru #12346</h2>
                                <p class="text-sm text-gray-600">Widya Mustika - Rp 190.000</p>
                                <span class="text-xs text-gray-400 mt-2 inline-flex items-center gap-1">
                                    <i class="fas fa-clock"></i>10 menit yang lalu
                                </span>
                            </div>
                            <input type="checkbox" class="checkbox-btn" onclick="this.closest('.notification-card').classList.toggle('checked');">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer>
        <?php include "template/footer_admin.php"; ?>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>

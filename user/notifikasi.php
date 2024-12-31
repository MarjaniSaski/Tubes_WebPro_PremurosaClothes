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
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        :root {
            --pink-primary: #FF69B4;
            --pink-light: #FFB6C1;
            --pink-dark: #FF1493;
        }

        .bg-pink-custom {
            background-color: var(--pink-primary);
        }

        .text-pink-custom {
            color: var(--pink-primary);
        }

        .notification-card {
            border-left: 4px solid var(--pink-primary);
            transition: transform 0.2s;
        }

        .notification-card:hover {
            transform: translateX(5px);
        }

        .notification-card.unread {
            background-color: #FFF0F5;
        }

        .notification-badge {
            background-color: var(--pink-primary);
            color: white;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #666;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background-color: #FFF0F5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--pink-primary);
        }

        .delete-btn {
            color: #dc3545;
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .delete-btn:hover {
            color: #bb2d3b;
        }

        .nav-link.active {
            color: var(--pink-primary) !important;
            border-bottom: 2px solid var(--pink-primary);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Semua</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <!-- Notification Item -->
                        <div class="notification-card unread p-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-3">
                                    <i class="bi bi-tag-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Diskon Spesial Hari Ini!</h6>
                                    <p class="mb-1">Dapatkan diskon 30% untuk semua produk fashion hari ini</p>
                                    <div class="notification-time">
                                        <i class="bi bi-clock me-1"></i>5 menit yang lalu
                                    </div>
                                </div>
                                <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Notification Item -->
                        <div class="notification-card p-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-3">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Pesanan Dikonfirmasi</h6>
                                    <p class="mb-1">Pesanan #12345 telah dikonfirmasi dan sedang diproses</p>
                                    <div class="notification-time">
                                        <i class="bi bi-clock me-1"></i>1 jam yang lalu
                                    </div>
                                </div>
                                <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Notification Item -->
                        <div class="notification-card unread p-3">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-3">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Koleksi Baru Telah Tiba!</h6>
                                    <p class="mb-1">Jangan lewatkan koleksi terbaru musim semi kami</p>
                                    <div class="notification-time">
                                        <i class="bi bi-clock me-1"></i>2 jam yang lalu
                                    </div>
                                </div>
                                <button class="delete-btn" onclick="this.closest('.notification-card').remove();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include "template/footer_user.php"
?>
</html>



HANYA TAMPILAN SAJ
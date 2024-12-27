<?php
require_once 'header_user.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

if (!defined('HOST')) {
    define('HOST', 'http://localhost/Tubes_WebPro_PremurosaClothes');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes</title>
    <link href="<?= HOST ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= HOST ?>/assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        main{
            flex-grow: 1;
        }
        footer {
            background: #FFABE1;
            color: #333;
            padding: 20px 0 5px;
            font-size: 11px; /* Smaller font size for the footer */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .footer-content {
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 15px; /* Reduced gap between sections */
        }

        .footer-section {
            flex: 1;
            width: 250px; /* Limit the width of each section */
            max-width: 100%;
            padding-right: 10px;
        }

        .footer-section h5 {
            color: #FF1493;
            font-size: 0.85rem; /* Smaller heading size */
            font-weight: 600;
            margin-bottom: 8px; /* Reduced margin */
            display: inline-block;
            border-bottom: 2px solid #FF1493;
            padding-bottom: 4px;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            gap: 8px; /* Reduced gap */
            font-size: 10px; /* Smaller text size for contact info */
        }

        .contact-info i {
            color: #FF1493;
            font-size: 10px; /* Smaller icon size */
            width: 12px; /* Adjust icon size */
        }

        .social-icons {
            display: flex;
            gap: 8px; /* Reduced gap between icons */
        }

        .social-icons a {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            color: #FF1493;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 12px; /* Smaller icon size */
        }

        .social-icons a:hover {
            background: #FF1493;
            color: #fff;
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 10px; /* Reduced margin */
            padding-top: 8px; /* Reduced padding */
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 10px; /* Smaller text size for footer bottom */
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-section {
                width: 100%;
                margin-bottom: 12px;
            }

            .contact-info li {
                justify-content: center;
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="container">
            <div class="footer-content">
                <!-- Kontak -->
                <div class="footer-section">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled contact-info">
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>premurosaclothes@gmail.com</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Sunda No. 23, Bandung</span>
                        </li>
                    </ul>
                </div>

                <!-- Sosial Media -->
                <div class="footer-section">
                    <h5>Ikuti Kami</h5>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/saaskiw_/" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@elephantkiw?_t=8sQqm39xkfK&_r=1" target="_blank" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2024 Premurosa Clothes. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?= HOST ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

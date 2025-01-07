<?php
include "template/header_admin.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_produk = $_GET['id'];
$sql = "SELECT * FROM produkBaru WHERE id_produk = '$id_produk'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Produk tidak ditemukan.</p>";
    exit;
}
$conn->close();
?>

<style>
    .product-section {
        padding: 40px 0;
        margin : 30px;
        background-color: #f5f0f8;
        min-height: calc(100vh - 60px);
    }

    .product-wrapper {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
    }

    .product-gallery {
        position: relative;
        background: #f9f9f9;
        height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .product-gallery:hover .product-image {
        transform: scale(1.05);
    }

    .product-details {
        padding: 40px;
        position: relative;
    }

    .product-category {
        display: inline-block;
        background: #e1bee7;
        color: #6a1b9a;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-title {
        font-size: 2.8rem;
        color: #2c2c2c;
        margin-bottom: 20px;
        font-weight: 700;
        line-height: 1.2;
    }

    .product-price-tag {
        background: #6a1b9a;
        color: white;
        padding: 12px 25px;
        border-radius: 15px;
        display: inline-block;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(106, 27, 154, 0.2);
    }

    .product-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .info-card {
        background: #f8f5fb;
        padding: 20px;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .info-label {
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .info-value {
        color: #2c2c2c;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .product-description {
        background: #f8f5fb;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
    }

    .description-header {
        color: #6a1b9a;
        font-size: 1.4rem;
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .description-content {
        color: #666;
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #6a1b9a;
        color: white;
        padding: 15px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid #6a1b9a;
    }

    .back-link:hover {
        background: transparent;
        color: #6a1b9a;
    }

    @media (max-width: 992px) {
        .product-gallery {
            height: 400px;
        }
        
        .product-title {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .product-details {
            padding: 30px 20px;
        }
        
        .product-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="product-section">
    <div class="container">
        <div class="product-wrapper">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <img src="<?= $row['gambar_produk'] ?>" alt="<?= $row['nama_produk'] ?>" class="product-image">
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="product-details">
                        <span class="product-category"><?= $row['genre_produk'] ?></span>
                        <h1 class="product-title"><?= $row['nama_produk'] ?></h1>
                        <div class="product-price-tag">
                            Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?>
                        </div>

                        <div class="product-info-grid">
                            <div class="info-card">
                                <div class="info-label">Genre</div>
                                <div class="info-value"><?= $row['genre_produk'] ?></div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Ukuran</div>
                                <div class="info-value">All Size</div>
                            </div>
                            <div class="info-card">
                                <div class="info-label">Stok</div>
                                <div class="info-value">Tersedia</div>
                            </div>
                        </div>

                        <div class="product-description">
                            <h3 class="description-header">
                                <i class="bi bi-info-circle"></i>
                                Detail Produk
                            </h3>
                            <div class="description-content">
                                <?= $row['detail_produk'] ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="producthome.php" class="back-link">
                                <i class="bi bi-arrow-left-circle"></i>
                                Kembali ke Daftar Produk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
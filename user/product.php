<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';


// Mengatur filter berdasarkan GET parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Terlaris';

// Daftar produk dengan nama dan gambar
$products = [
    ["name" => "Ivory Midi Skirt", "image" => "/foto/rok putih.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Unisex T-Shirt", "image" => "/foto/7.png", "price" => 199000, "rating" => 4.2],
    ["name" => "Striped Shirt", "image" => "/foto/11.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Cabana Men Shirt", "image" => "/foto/18.png", "price" => 199000, "rating" => 4.0],
    ["name" => "Jeans Kulot Highwaist", "image" => "/foto/jeans kulot.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Pink Blouse", "image" => "/foto/blouse pink.png", "price" => 259000, "rating" => 4.6],
    ["name" => "Ruffle Blouse", "image" => "/foto/blouse chocolate.png", "price" => 229000, "rating" => 4.1],
    ["name" => "Snow Dress", "image" => "/foto/dress puti full.png", "price" => 299000, "rating" => 4.4],
    ["name" => "Black Midi Skirt", "image" => "/foto/rok mini.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Jeans Skirt", "image" => "/foto/rok jeans payung.png", "price" => 330000, "rating" => 4.2],
    ["name" => "Floral Shirt", "image" => "/foto/Pink floral.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Titanium Shirt", "image" => "/foto/kemeja abu.png", "price" => 299000, "rating" => 4.0]
];

// Mengurutkan produk berdasarkan filter yang dipilih
if ($filter == 'Harga Terendah') {
    usort($products, function($a, $b) {
        return $a['price'] - $b['price']; // Urutkan dari yang termurah
    });
} elseif ($filter == 'Terlaris') {
    usort($products, function($a, $b) {
        return $b['rating'] - $a['rating']; // Urutkan berdasarkan rating tertinggi
    });
} elseif ($filter == 'Harga Tertinggi') {
    usort($products, function($a, $b) {
        return $b['price'] - $a['price']; // Urutkan dari yang termahal
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk dengan Rating</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    /* Rating */
    .rating {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .rating i {
            font-size: 1.2rem;
            color: #ffcc00;
            margin: 0 2px;
            transition: transform 0.2s ease;
        }

        .rating i:hover {
            transform: scale(1.2);
        }

        .rating span {
            font-size: 1rem;
            color: #555;
            font-weight: bold;
            margin-left: 10px;
        }
</style>

<div class="productlogo bg-pink-200 p-3 flex items-center gap-3">
            <h2 class="text-xl font-bold pl-4">
                <i class="bi bi-bag-heart-fill text-pink-500 mr-3"></i> Product
            </h2>
        </div>

<!-- Product Section -->
<section class="container mx-auto mt-8">
    <div class="flex justify-end mb-4">
        <div class="dropdown">
            <button class="btn bg-pink-400 text-black dropdown-toggle flex justify-between items-center font-semibold rounded-lg" style="width: 200px;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                    // Menampilkan filter yang dipilih
                    echo ucfirst($filter);
                ?>
                
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=Terlaris">Terlaris</a></li>
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=Harga Terendah">Harga Terendah</a></li>
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=Harga Tertinggi">Harga Tertinggi</a></li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Looping untuk menampilkan produk -->
        <?php foreach ($products as $product): ?>
            <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                <img src="<?= HOST . $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full mb-4">
                <h3 class="text-sm font-medium"><?= $product['name'] ?></h3>
                <p class="text-pink-500 font-bold">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                <div class="rating">
                        <?php
                        $fullStars = floor($product['rating']);
                        $halfStars = ($product['rating'] - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStars;
                        for ($i = 0; $i < $fullStars; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        if ($halfStars) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }
                        for ($i = 0; $i < $emptyStars; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
                        <span><?= $product['rating'] ?></span>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
include "template/footer_user.php"
?>
</html>

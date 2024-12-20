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

<!-- Product Section -->
<section class="container mx-auto mt-8">
    <div class="flex justify-end mb-4">
        <div class="dropdown">
            <button class="btn bg-pink-400 text-black dropdown-toggle flex justify-between items-center font-semibold rounded-lg" style="width: 200px;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                    // Menampilkan filter yang dipilih
                    echo ucfirst($filter);
                ?>
                <i class="fas fa-chevron-down"></i>
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
                <p class="text-gray-600">Rating: <?= $product['rating'] ?> / 5</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

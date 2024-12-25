<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
<<<<<<< HEAD
$products = [

    ["name" => "Jeans Kulot Highwaist", "image" => "/foto/jeans kulot.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Crop Stripes Blouse", "image" => "/foto/crop strip shirt.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Black Midi Skirt", "image" => "/foto/rok mini.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Unisex T-Shirt", "image" => "/foto/7.png", "price" => 199000, "rating" => 4.2],
    ["name" => "Cargo Army Men", "image" => "/foto/18.png", "price" => 199000, "rating" => 4.0],
    ["name" => "Dress Teracota", "image" => "/foto/rok putih.png", "price" => 359000, "rating" => 4.8],
    ["name" => "Pink Blouse", "image" => "/foto/blouse pink.png", "price" => 259000, "rating" => 4.6],
    ["name" => "Sea Blouse", "image" => "/foto/blouse blue.png", "price" => 299000, "rating" => 4.7],
    ["name" => "Snow Dress", "image" => "/foto/dress puti full.png", "price" => 299000, "rating" => 4.4],
    ["name" => "Contrast Craft Shirt", "image" => "/foto/kemeja bw.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Hawai Shirt", "image" => "/foto/kemeja mint.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Floral Dress Midi", "image" => "/foto/floral dress midi.png", "price" => 499000, "rating" => 4.3],
    ["name" => "Brown Grid Skirt", "image" => "/foto/rok kotak.png", "price" => 299000, "rating" => 4.0],
    ["name" => "Jeans Skirt", "image" => "/foto/rok jeans payung.png", "price" => 330000, "rating" => 4.2],
    ["name" => "Ruffle Blouse", "image" => "/foto/blouse chocolate.png", "price" => 229000, "rating" => 4.1]
];
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}
?>
<style>
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

    .rating-wishlist {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    position: relative; 
    }

    .rating {
        display: flex;
        align-items: center;
    }

    .rating span {
        margin-left: 0.5rem;
        font-size: 0.9rem;
        color: #333;
    }


    .wishlist-icon {
        position: absolute; 
        top: 50%;
        right: 0px; 
        transform: translateY(-30%); 
        font-size: 1.5rem;
        color: grey;
        cursor: pointer;
        transition: color 0.3s, transform 0.3s;
    }

    .wishlist-icon:hover {
        color: red;
        transform: translateY(-30%) scale(1.2);
    }

    .wishlist-icon.wishlist-active {
        color: red;
    }
</style>
=======
?>

>>>>>>> c12138fec85cd5f84038a36d27175cfab493aebe
<!-- New Arrivals Section -->
<section class="newarrival mt-5">
        <div class="newarrivallogo bg-pink-200 p-3 flex items-center gap-3">
            <h2 class="text-xl font-bold pl-4">
                <i class="bi bi-stars text-pink-500 mr-3"></i>New Arrivals
            </h2>
        </div>
<<<<<<< HEAD
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
            <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                <img src="<?= HOST . $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full mb-4 rounded-md">
                <h3 class="text-sm font-medium"><?= $product['name'] ?></h3>
                <p class="text-pink-500 font-bold">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
                <div class="rating-wishlist flex items-center justify-center space-x-2">
                    <div class="rating flex items-center">
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
                    <!-- Ikon wishlist -->
                    <i class="fas fa-heart wishlist-icon <?= in_array($product['name'], $_SESSION['wishlist']) ? 'wishlist-active' : '' ?>" 
                        data-name="<?= $product['name'] ?>" 
                        onclick="toggleWishlist(this, '<?= $product['name'] ?>')">
                    </i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<script>
    function toggleWishlist(icon, productName) {
    // Ambil wishlist dari localStorage
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

    if (wishlist.includes(productName)) {
        // Jika produk sudah ada, hapus dari wishlist
        wishlist = wishlist.filter(item => item !== productName);
        icon.classList.remove('wishlist-active');
    } else {
        // Jika produk belum ada, tambahkan ke wishlist
        wishlist.push(productName);
        icon.classList.add('wishlist-active');
    }

    // Simpan ke local storage
    localStorage.setItem('wishlist', JSON.stringify(wishlist));

    // Kirim data ke server 
    fetch('save_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ wishlist })
    }).then(response => response.json())
      .then(data => {
          if (data.status !== 'success') {
              console.error('Gagal menyimpan wishlist di server:', data.message);
          }
      });
}
</script>
=======
        <div class="products row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-4 ml-1 mr-1">
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/jeans kulot.png" alt="Comfy Kulot Highwast" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Comfy Kulot Highwast</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/crop strip shirt.png" alt="Crop Stripes Blouse" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Crop Stripes Blouse</p>
                    <p class="text-pink-600 font-bold">Rp259.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/rok mini.png" alt="Midi Rok Serut" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Midi Rok Serut</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/Kemeja.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Unisex Shirt</p>
                    <p class="text-pink-600 font-bold">Rp199.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/cargo army banyak.png" alt="Comfy Kulot Highwast" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Cargo Army Men/p>
                    <p class="text-pink-600 font-bold">Rp399.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/dress coklat.png" alt="Crop Stripes Blouse" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Dress Teracota</p>
                    <p class="text-pink-600 font-bold">Rp359.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/blouse pink.png" alt="Midi Rok Serut" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Blouse Floral Pink</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/blouse blue.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Sea Blouse</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/dress puti full.png" alt="Comfy Kulot Highwast" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>White Dress</p>
                    <p class="text-pink-600 font-bold">Rp499.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/kemeja bw.png" alt="Crop Stripes Blouse" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Contrast Craft Shirt</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/kemeja mint.png" alt="Midi Rok Serut" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Hawai Shirt</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/floral dress midi.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Floral Dress Midi</p>
                    <p class="text-pink-600 font-bold">Rp499.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/rok jeans payung.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Denim Charm</p>
                    <p class="text-pink-600 font-bold">Rp399.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/rok kotak.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Brown Grid Skirt</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/cargo army banyak.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Cargo Army</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>
            <div class="col">
                <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
                    <img src="<?= HOST ?>/foto/blouse chocolate.png" alt="Unisex Shirt" class="card-img-top rounded-lg mb-3" style="height: 250px; object-fit: cover;">
                    <p>Caramel Blouse</p>
                    <p class="text-pink-600 font-bold">Rp299.000</p>
                </div>
            </div>   
        </div>
>>>>>>> c12138fec85cd5f84038a36d27175cfab493aebe

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php
include "template/footer_user.php"
?>
</html>
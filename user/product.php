<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';


// Mengatur filter berdasarkan GET parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Terlaris';

// Daftar produk dengan nama, gambar, harga, dan rating
$products = [
    ["name" => "Ivory Midi Skirt", "image" => "/foto/rok putih.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Unisex T-Shirt", "image" => "/foto/7.png", "price" => 199000, "rating" => 4.2],
    ["name" => "Striped Shirt", "image" => "/foto/11.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Cargo Army Men", "image" => "/foto/18.png", "price" => 199000, "rating" => 4.0],
    ["name" => "Jeans Kulot Highwaist", "image" => "/foto/jeans kulot.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Pink Blouse", "image" => "/foto/blouse pink.png", "price" => 259000, "rating" => 4.6],
    ["name" => "Ruffle Blouse", "image" => "/foto/blouse chocolate.png", "price" => 229000, "rating" => 4.1],
    ["name" => "Snow Dress", "image" => "/foto/dress puti full.png", "price" => 299000, "rating" => 4.4],
    ["name" => "Black Midi Skirt", "image" => "/foto/rok mini.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Jeans Skirt", "image" => "/foto/rok jeans payung.png", "price" => 330000, "rating" => 4.2],
    ["name" => "Floral Shirt", "image" => "/foto/Pink floral.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Titanium Shirt", "image" => "/foto/kemeja abu.png", "price" => 299000, "rating" => 4.0],
    ["name" => "Sea Dress", "image" => "/foto/D6.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Ivory Dress", "image" => "/foto/D8.png", "price" => 299000, "rating" => 4.5],
    ["name" => "Sunset Dress", "image" => "/foto/D4.png", "price" => 199000, "rating" => 4.0],
    ["name" => "Rain Dress", "image" => "/foto/D11.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Lolipop Dress", "image" => "/foto/D1.png", "price" => 299000, "rating" => 4.0],
    ["name" => "School Dress", "image" => "/foto/D12.png", "price" => 330000, "rating" => 4.2],
    ["name" => "Ivory Flower Dress", "image" => "/foto/D9.png", "price" => 399000, "rating" => 4.5],
    ["name" => "Denim Dress", "image" => "/foto/D7.png", "price" => 369000, "rating" => 4.2],
    ["name" => "Bubblegum Dress", "image" => "/foto/D5.png", "price" => 319000, "rating" => 5.0],
    ["name" => "Unicorn Dress", "image" => "/foto/D10.png", "price" => 359000, "rating" => 4.6],
    ["name" => "Seasalt Dress", "image" => "/foto/D2.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Sun Dress", "image" => "/foto/D3.png", "price" => 439000, "rating" => 4.4],
    ["name" => "Jeans Kulot", "image" => "/foto/12.png", "price" => 399000, "rating" => 4.5],
    ["name" => "Jeans Cargo", "image" => "/foto/kulot jeans cargo.png", "price" => 369000, "rating" => 4.2],
    ["name" => "Jeans Kulot Red", "image" => "/foto/red jenas kuot.png", "price" => 319000, "rating" => 5.0],
    ["name" => "Petal Skirt", "image" => "/foto/1.png", "price" => 359000, "rating" => 4.6],
    ["name" => "Denim Diamond Skirt", "image" => "/foto/2.png", "price" => 399000, "rating" => 4.7],
    ["name" => "Black Diamond Shirt", "image" => "/foto/3.png", "price" => 439000, "rating" => 4.4],
    ["name" => "Sea Blouse", "image" => "/foto/blouse blue.png", "price" => 299000, "rating" => 4.7],
    ["name" => "Contrast Craft Shirt", "image" => "/foto/kemeja bw.png", "price" => 299000, "rating" => 4.3],
    ["name" => "Dress Teracota", "image" => "/foto/dress coklat.png", "price" => 359000, "rating" => 4.8]
];

// Mengurutkan produk berdasarkan filter
switch ($filter) {
    case 'Terlaris':
        // Urutkan berdasarkan rating tertinggi ke terendah
        usort($products, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });
        break;

    case 'Harga Terendah':
        // Urutkan berdasarkan harga terendah, jika harga sama urutkan berdasarkan rating tertinggi
        usort($products, function ($a, $b) {
            if ($a['price'] == $b['price']) {
                return $b['rating'] - $a['rating'];
            }
            return $a['price'] - $b['price'];
        });
        break;

    case 'Harga Tertinggi':
        // Urutkan berdasarkan harga tertinggi, jika harga sama urutkan berdasarkan rating tertinggi
        usort($products, function ($a, $b) {
            if ($a['price'] == $b['price']) {
                return $b['rating'] - $a['rating'];
            }
            return $b['price'] - $a['price'];
        });
        break;

    default:
        // Filter default (fallback) ke "Terlaris"
        usort($products, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });
        break;
}
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Clothes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

    /* Style untuk Dropdown */
    .sort-dropdown {
        position: relative;
        display: inline-block;
    }

    .sort-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 0.5rem;
    }

    .sort-dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .sort-dropdown-content a:hover {
        background-color:rgb(248, 183, 218);
    }

    .show {
        display: block;
    }

    .btn span {
        text-align: right;
        width: 100%;
        padding-right: 10px;
    }

    #currentSort{
        text-align:left;
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

<div class="productlogo bg-pink-200 p-3 flex items-center gap-3">
    <h2 class="text-xl font-bold pl-4">
        <i class="bi bi-bag-heart-fill text-pink-500 mr-3"></i> Produk
    </h2>
</div>

<!-- Product Section -->
<section class="container mx-auto mt-8">
    <div class="flex justify-end mb-4">
        <div class="sort-dropdown">
            <button onclick="toggleDropdown()" class="btn bg-pink-400 text-black flex justify-between items-center font-semibold rounded-lg px-4 py-2" style="width: 200px;">
                <span id="currentSort"><?php echo $filter; ?></span>
                <i class="fas fa-chevron-down ml-2"></i>
            </button>
            <div id="sortDropdown" class="sort-dropdown-content">
                <a href="?filter=Terlaris">Terlaris</a>
                <a href="?filter=Harga Tertinggi">Harga Tertinggi</a>
                <a href="?filter=Harga Terendah">Harga Terendah</a>
            </div>
        </div>
    </div>

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
function toggleDropdown() {
    document.getElementById("sortDropdown").classList.toggle("show");
}

// Menutup dropdown jika user mengklik di luar dropdown
window.onclick = function(event) {
    if (!event.target.matches('.btn') && !event.target.matches('.btn *')) {
        var dropdowns = document.getElementsByClassName("sort-dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

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

<?php
 include "template/footer_user.php"
?>
</html>

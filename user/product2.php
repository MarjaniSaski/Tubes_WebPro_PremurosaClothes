<!-- Product tanpa php -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?> 

<!-- Product Section -->
<section class="container mx-auto mt-8">
    <div class="flex justify-end mb-4">
        <div class="dropdown">
            <button class="btn bg-pink-400 text-black dropdown-toggle flex justify-between items-center font-semibold rounded-lg" style="width: 200px;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Terlaris
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=terbaru">Terlaris</a></li>
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=termurah">Harga Terendah</a></li>
                <li><a class="dropdown-item text-black hover:bg-pink-500" href="?filter=terlaris">Harga Tertinggi</a></li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Product Card -->
        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/rok putih.png" alt="Ivory Midi Skirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Ivory Midi Skirt</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/7.png" alt="Unisex T-Shirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Unisex T-Shirt</h3>
            <p class="text-pink-500 font-bold">Rp199.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/11.png" alt="Striped Shirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Striped Shirt</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/18.png" alt="Cabana Men Shirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Cabana Men Shirt</h3>
            <p class="text-pink-500 font-bold">Rp199.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/jeans kulot.png" alt="Jeans Kulot Highwaist" class="w-full mb-4">
            <h3 class="text-sm font-medium">Jeans Kulot Highwaist</h3>
            <p class="text-pink-500 font-bold">Rp399.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/blouse pink.png" alt="Pink Blouse" class="w-full mb-4">
            <h3 class="text-sm font-medium">Pink Blouse</h3>
            <p class="text-pink-500 font-bold">Rp259.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/blouse chocolate.png" alt="Coffee Blouse" class="w-full mb-4">
            <h3 class="text-sm font-medium">Ruffle Blouse</h3>
            <p class="text-pink-500 font-bold">Rp229.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/dress puti full.png" alt="Snow Dress" class="w-full mb-4">
            <h3 class="text-sm font-medium">Snow Dress</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/rok mini.png" alt="Black Midi Skirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Black Midi Skirt</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/rok jeans payung.png" alt="Jeans Skirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Jeans Skirt</h3>
            <p class="text-pink-500 font-bold">Rp330.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/Pink floral.png" alt="Floral Shirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Floral Shirt</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>

        <div class="card bg-pink-200 rounded-lg shadow-md p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300">
            <img src="<?= HOST ?>/foto/kemeja abu.png" alt="Titanium Shirt" class="w-full mb-4">
            <h3 class="text-sm font-medium">Titanium Shirt</h3>
            <p class="text-pink-500 font-bold">Rp299.000</p>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

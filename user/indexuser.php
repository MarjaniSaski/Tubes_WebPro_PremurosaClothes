<?php
include "template/header_user.php"
?>
<style>
    .categories .card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #655D8A; /* Warna latar belakang kategori */
    border-radius: 10px;
    padding: 0;
}
</style>
<!-- Categories Section -->
<section class="categories container mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card bg-purple-500 rounded-lg shadow-lg overflow-hidden transition-all transform hover:scale-105 hover:opacity-100 opacity-80 hover:shadow-xl">
                <img src="<?= HOST ?>/foto/T1.png" class="card-img-top" alt="Tops" style="height: 250px; object-fit: cover;">
                <!-- Link ke halaman Tops -->
                <a href="tops.php" class="btn btn-purple w-100 py-3 text-white font-semibold">TOPS</a>
            </div>
        </div>
        <div class="col">
            <div class="card bg-purple-500 rounded-lg shadow-lg overflow-hidden transition-all transform hover:scale-105 hover:opacity-100 opacity-80 hover:shadow-xl">
                <img src="<?= HOST ?>/foto/C1.png" class="card-img-top" alt="Bottoms" style="height: 250px; object-fit: cover;">
                <!-- Link ke halaman Bottoms -->
                <a href="bottoms.php" class="btn btn-purple py-3 text-white font-semibold">BOTTOMS</a>
            </div>
        </div>
        <div class="col">
            <div class="card bg-purple-500 rounded-lg shadow-lg overflow-hidden transition-all transform hover:scale-105 hover:opacity-100 opacity-80 hover:shadow-xl">
                <img src="<?= HOST ?>/foto/B1.png" class="card-img-top" alt="Dresses" style="height: 250px; object-fit: cover;">
                <!-- Link ke halaman Dresses -->
                <a href="dresses.php" class="btn btn-purple w-100 py-3 text-white font-semibold">DRESSES</a>
            </div>
        </div>
    </div>
</section>

    

    <!-- Terlaris Section -->
    <section class="terlaris mt-5">
        <div class="terlarislogo bg-pink-200 p-3 flex items-center gap-3">
            <h2 class="text-xl font-bold pl-4">
                <i class="bi bi-star"></i>  Terlaris
            </h2>
        </div>
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
        
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
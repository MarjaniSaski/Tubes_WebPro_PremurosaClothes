<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlStatement = "SELECT * FROM produk";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="container mt-5">
        <div class="row">
        <?php foreach ($data as $produk); ?>
            <!-- Image Column -->
            <div class="col-md-6">
                <div class="border border-pink-200 p-3 rounded-lg">
                    <img src="../images/<?= $produk["foto"] ?>" alt="Foto Produk" class="img-fluid rounded-lg">
                </div>
            </div>

            <!-- Product Info Column -->
            <div class="col-md-6">
                <h2 class="text-black text-lg font-bold"><?= $produk['nama']; ?></h2>
                <p class="text-lg font-bold"><?= $produk['poin']; ?> Poin</p>
                
                <div class="mt-3">
                    <h5 class="font-bold">Kode Produk:</h5>
                    <p class="text-black font-semibold"><?= $produk['id_produk']; ?></p>
                </div>

                <div class="mt-4">
                    <h5 class="font-semibold">Informasi Produk</h5>
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>SKU</strong>
                            <span>BLP-2024-FPINK</span>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>Leher</strong>
                            <span>Model kerah bulat tanpa lipatan</span>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>Motif</strong>
                            <span>Floral (bunga-bunga kecil)</span>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>Ukuran</strong>
                            <span>Fit Regular</span>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>Gaya</strong>
                            <span>Bohemian / Casual</span>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                            <strong>Material</strong>
                            <span>Katun ringan, nyaman digunakan</span>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-5">
                    <a href="ekspedisi.php">
                        <button class="btn btn-pink-400 bg-pink-400 text-white font-semibold w-full py-3 rounded-lg hover:bg-pink-600 transition duration-300">
                            Tukarkan
                        </button>
                    </a>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
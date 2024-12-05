<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlStatement = "SELECT * FROM produk";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
<style>
    .custom-voucher-card {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #655D8A; /* Warna latar belakang kategori */
        border-radius: 10px;
        padding: 0;
    }

    .custom-voucher-card:hover {
        transform: translateY(-4px); /* Hover effect */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
    }
</style>

<!-- Divider -->
<div class="pink-divider"></div>

<div class="container-fluid bg-white shadow-sm py-3">
  <div class="d-flex justify-content-between align-items-center px-4">
      <!-- Back Button -->
      <div>
        <button onclick="window.location.href='menuswap.php';" class="btn bg-pink-500 text-white rounded-lg px-4 py-2 shadow-sm hover:bg-pink-600">
            Back
        </button>
    </div>
      <!-- Points Section -->
      <div>
          <div class="d-flex align-items-center border border-indigo-500 rounded-lg px-4 py-2 text-indigo-500 text-lg font-semibold">
              <i class="bi bi-gem me-2" style="font-size: 20px;"></i> 
              350
          </div>
      </div>
  </div>
</div>

<!-- Main Content -->
<main class="container py-5">
  <!-- Voucher Section -->
  <section class="mb-5">
    <h2 class="text-lg font-bold text-purple-700 mb-4">
      <i class="bi bi-ticket-detailed"></i> Voucher
    </h2>
    <!-- Parent container for horizontal scroll -->
    <div class="flex gap-3 overflow-x-auto">
      <!-- Voucher Card -->
      <div class="bg-gradient-to-r from-purple-400 to-purple-200 text-indigo-800 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px]">
        <h3 class="text-xl font-bold">Discount 10%</h3>
        <p class="text-sm">Min. Blj Rp199.000</p>
        <p class="text-sm">S/D: 12.12.24</p>
      </div>
      <div class="bg-gradient-to-r from-purple-400 to-purple-200 text-indigo-800 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px]">
        <h3 class="text-xl font-bold">Discount 5%</h3>
        <p class="text-sm">Min. Blj Rp399.000</p>
        <p class="text-sm">S/D: 12.12.24</p>
      </div>
      <div class="bg-gradient-to-r from-purple-400 to-purple-200 text-indigo-800 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px]">
        <h3 class="text-xl font-bold">Gratis Ongkir</h3>
        <p class="text-sm">Min. Blj Rp999.000</p>
        <p class="text-sm">S/D: 12.12.24</p>
      </div>
      <div class="bg-gradient-to-r from-purple-400 to-purple-200 text-indigo-800 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px]">
        <h3 class="text-xl font-bold">Discount 15%</h3>
        <p class="text-sm">Min. Blj Rp599.000</p>
        <p class="text-sm">S/D: 12.12.24</p>
      </div>
      <div class="bg-gradient-to-r from-purple-400 to-purple-200 text-indigo-800 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px]">
        <h3 class="text-xl font-bold">Discount 20%</h3>
        <p class="text-sm">Min. Blj Rp799.000</p>
        <p class="text-sm">S/D: 12.12.24</p>
      </div>
    </div>
  </section>

  <!-- Expanded Product Section -->
  <section>
      <h2 class="text-lg font-bold text-purple-700 mb-4">
          <i class="bi bi-bag-fill"></i> Product
      </h2>
      <div class="row g-4">
          <!-- Additional Product Cards (more products) -->
        <?php
            foreach ($data as $key => $produk) {
        ?>
          <div class="col-6 col-md-3">
              <a href="katalog.php?img=8.png">
                  <div class="custom-voucher-card rounded-lg p-3 text-white shadow-lg text-center transform hover:translate-y-1">
                      <img src="../images/<?= $produk["foto"] ?>" alt="Product 1" class="w-full rounded-lg mb-3">
                      <h3 class="text-2xl font-bold"><?= $produk['poin'] ?></h3>
                      <p class="text-sm">Poin</p>
                  </div>
              </a>
          </div>
        <?php
            }
        ?>
  </section>
</main>
</body>
</html>

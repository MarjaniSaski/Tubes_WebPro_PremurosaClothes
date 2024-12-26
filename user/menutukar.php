<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$user_id = $_SESSION['user_id'];

$sqlStatement = "SELECT * FROM produk";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sqlStatement = "SELECT * FROM vouchers";
$query = mysqli_query($conn, $sqlStatement);
$datavoucher = mysqli_fetch_all($query, MYSQLI_ASSOC);

$resultData = $conn->query("SELECT first_name, last_name FROM user WHERE id = '$user_id'");

if ($resultData && $resultData->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $resultData->fetch_assoc();
    $fullname = $row['first_name'] . ' ' . $row['last_name'];
} else {
    // Handle the case where no data is found
    $fullname = "Nama Tidak Ditemukan";
}

// Query untuk menjumlahkan poin berdasarkan nama lengkap
$getPoinTukar = $conn->prepare("SELECT SUM(poin) FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $fullname);

if ($getPoinTukar->execute()) {
    $result = $getPoinTukar->get_result();
    $resultPoinTukar = $result->fetch_row()[0];

    // Jika tidak ada poin yang ditemukan, set poin menjadi 0
    if ($resultPoinTukar === null) {
        $resultPoinTukar = 0;
    }
} else {
    echo "Error: " . $getPoinTukar->error;
}

$getPoinTukar->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['poin'])) {
    $user_id = $_SESSION['user_id']; // Ambil ID user dari session
    updateJumlahPenukaran($user_id, $conn, $resultPoinTukar);
}

$conn->close();
?>

<style>
  #voucherPopup,
  #productPopup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
  }

  #voucherPopup.show,
  #productPopup.show {
    display: flex;
  }

  .popup-content {
    position: relative;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    max-width: 600px;
    width: 100%;
  }

  .popup-content h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
  }

  .popup-content p {
    margin-bottom: 10px;
  }

  .popup-content button {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1rem;
  }

  .popup-content .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    cursor: pointer;
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
      <div class="d-flex align-items-center border border-pink-700 rounded-lg px-4 py-2 text-pink-500 text-lg font-semibold">
        <i class="bi bi-coin me-2" style="font-size: 30px;"></i>
        <?= $resultPoinTukar ?>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<main>
  <!-- Voucher Section -->
  <section class="mb-10">
    <div class="productlogo bg-pink-200 p-3 flex items-center gap-3">
      <h2 class="text-xl font-bold pl-4">
          <i class="bi bi-ticket-perforated text-pink-900 mr-3"></i> Voucher
      </h2>
    </div>
    <br>
    <div class="flex gap-3 overflow-x-auto mr-5">
      <?php foreach ($datavoucher as $key => $voucher) { ?>
        <!-- Voucher Card as Button -->
        <button class="bg-gradient-to-r from-pink-600 to-pink-400 text-pink-200 rounded-lg p-4 w-48 text-center shadow-lg transform hover:translate-x-[-10px] ml-4">
          <div class="text-center">
            <h3 class="text-xl font-bold"><?= $voucher['voucher_name'] ?></h3>
            <p class="text-sm">Min. Blj Rp <?= $voucher['max_amount'] ?></p>
            <p class="text-sm">S/D: <?= $voucher['max_period'] ?></p>
          </div>
        </button>
      <?php } ?>
    </div>
  </section>

  <!-- Product Section -->
  <section>
    <div class="productlogo bg-pink-200 p-3 flex items-center gap-3">
      <h2 class="text-xl font-bold pl-4">
          <i class="bi bi-bag-heart text-pink-900 mr-3"></i> Product
      </h2>
    </div>
    <br>
    <div class="row g-4">
        <?php foreach ($data as $key => $produk) { ?>
          <div class="col-6 col-md-3">
              <button 
                  onclick="redirectToKatalogSwap(<?= $produk['id_produk'] ?>)" 
                  class="card bg-pink-200 rounded-lg shadow-md p-4 transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-pink-300 ml-4 flex flex-col justify-center items-center">
                  <img src="../images/<?= $produk["foto"] ?>" alt="Product" class="w-full rounded-lg mb-3">
                  <h3 class="text-2xl font-bold text-center"><?= $produk['poin'] ?></h3>
                  <p class="text-sm text-center">Poin</p>
              </button>
          </div>
      <?php } ?>
    </div>
  </section>

  <!-- Voucher Info Pop-up -->
  <div id="voucherPopup" class="flex hidden">
    <div class="popup-content relative mx-auto my-20 p-8 bg-white rounded-lg max-w-lg w-full">
      <span id="closeVoucherBtn" class="close-btn text-2xl font-bold text-gray-700 cursor-pointer">&times;</span>
      <h2 class="text-xl font-semibold text-gray-800" id="voucherName">Voucher Information</h2>
      <p class="text-gray-600 mt-4"><strong>Name:</strong> <span id="voucherInfoName"></span></p>
      <p class="text-gray-600"><strong>Points:</strong> <span id="voucherPoints"></span> points</p>
      <p class="text-gray-600"><strong>Usage Period:</strong> <span id="voucherUsagePeriod"></span></p>
      <p class="text-gray-600"><strong>Max Period:</strong> <span id="voucherMaxPeriod"></span></p>
      <p class="text-gray-600"><strong>Max Amount:</strong> <span id="voucherMaxAmount"></span></p>

      <div class="mt-6 flex justify-between">
        <button id="claimVoucherBtn" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-400 w-28">
          Claim
        </button>
        <button id="cancelVoucherBtn" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 w-28">
          Cancel
        </button>
      </div>
    </div>
  </div>

  <!-- Product Info Pop-up -->
  <div id="productPopup" class="flex hidden">
    <div class="popup-content relative mx-auto my-20 p-8 bg-gradient-to-r from-pink-400 to-purple-700 rounded-lg max-w-lg w-full">
      <span id="closeProductBtn" class="close-btn text-2xl font-bold text-white cursor-pointer">&times;</span>
      <h2 class="text-xl font-semibold text-white" id="productName">Product Information</h2>
      <div class="mt-4">
        <img id="productImage" src="" alt="Product Image" class="w-full rounded-lg mb-4">
        <p class="text-white"><strong>Points:</strong> <span id="productPoints"></span> Poin</p>
        <p class="text-white"><strong>Details:</strong> <span id="productDetails"></span></p>
      </div>
      <div class="mt-6 flex justify-between">
        <button id="claimProductBtn" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 w-28">
          Claim
        </button>
        <button id="cancelProductBtn" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-28">
          Cancel
        </button>
      </div>
    </div>
  </div>

</main>

<script>
  // Voucher Pop-up logic
  const voucherPopup = document.getElementById('voucherPopup');
  const closeVoucherBtn = document.getElementById('closeVoucherBtn');
  const cancelVoucherBtn = document.getElementById('cancelVoucherBtn');
  const claimVoucherBtn = document.getElementById('claimVoucherBtn');

  // Function to show voucher info
  function showVoucherInfo(voucherCode) {
    fetch(`info_voucher.php?voucher_code=${voucherCode}`)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
        } else {
          document.getElementById('voucherInfoName').innerText = data.voucher_name;
          document.getElementById('voucherPoints').innerText = data.points;
          document.getElementById('voucherUsagePeriod').innerText = data.usage_period;
          document.getElementById('voucherMaxPeriod').innerText = data.max_period;
          document.getElementById('voucherMaxAmount').innerText = data.max_amount;

          // Show pop-up
          voucherPopup.classList.add('show');
        }
      })
      .catch(error => console.error('Error fetching voucher data:', error));
  }

  // Close voucher pop-up
  closeVoucherBtn.onclick = function() {
    voucherPopup.classList.remove('show');
  }

  cancelVoucherBtn.onclick = function() {
    voucherPopup.classList.remove('show');
  }

  // Claim voucher
  claimVoucherBtn.onclick = function() {
    alert('Voucher claimed successfully!');
    voucherPopup.classList.remove('show');
  }

  // Product Pop-up logic
  const productPopup = document.getElementById('productPopup');
  const closeProductBtn = document.getElementById('closeProductBtn');
  const cancelProductBtn = document.getElementById('cancelProductBtn');
  const claimProductBtn = document.getElementById('claimProductBtn');

  // Function to show product info
  function showProductInfo(productId) {
    console.log("Product ID: " + productId); // Debugging ID produk

    if (!productId) {
      alert('Product ID is missing or invalid.');
      return;
    }

    fetch(`info_product.php?id_produk=${productId}`)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
        } else {
          document.getElementById('productName').innerText = data.product_name;
          document.getElementById('productPoints').innerText = data.points;
          document.getElementById('productDetails').innerText = data.details;
          document.getElementById('productImage').src = `../images/${data.image}`;

          // Show pop-up
          productPopup.classList.add('show');
        }
      })
      .catch(error => console.error('Error fetching product data:', error));
  }

  // Close product pop-up
  closeProductBtn.onclick = function() {
    productPopup.classList.remove('show');
  }

  cancelProductBtn.onclick = function() {
    productPopup.classList.remove('show');
  }

  // Claim product
  claimProductBtn.onclick = function() {
    alert('Product claimed successfully!');
    productPopup.classList.remove('show');
  }

  // Close pop-up if clicked outside
  window.onclick = function(event) {
    if (event.target === voucherPopup) {
      voucherPopup.classList.remove('show');
    }
    if (event.target === productPopup) {
      productPopup.classList.remove('show');
    }
  }

  function redirectToKatalogSwap(id_produk) {
    // Redirect ke halaman katalogswap.php dengan ID produk sebagai parameter
    window.location.href = `katalogswap.php?id_produk=${id_produk}`;
}

</script>

</body>
<?php
include "template/footer_user.php"
?>
</html>
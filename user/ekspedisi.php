<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id_produk']; 

// Get user data first since we need the name for the orders query
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$nama_lengkap = $user_data['first_name'] . ' ' . $user_data['last_name'];
$stmt_user->close();

// Get total points earned from orders
$getPoinTukar = $conn->prepare("SELECT SUM(poin) as total_poin FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $nama_lengkap);
$getPoinTukar->execute();
$result = $getPoinTukar->get_result();
$row = $result->fetch_assoc();
$resultPoinTukar = $row['total_poin'] ?? 0;
$getPoinTukar->close();

// Get total points used from shipping_data
$getPointUsed = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used FROM shipping_data WHERE user_id = ?");
$getPointUsed->bind_param("i", $user_id);
$getPointUsed->execute();
$result = $getPointUsed->get_result();
$row = $result->fetch_assoc();
$resultPointUsed = $row['points_used'] ?? 0;
$getPointUsed->close();

$getPointUsedVoucher = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used_voucher FROM tukar_voucher WHERE user_id = ?");
$getPointUsedVoucher->bind_param("i", $user_id);
$getPointUsedVoucher->execute();
$result = $getPointUsedVoucher->get_result();
$row = $result->fetch_assoc();
$resultPointUsedVoucher = $row['points_used_voucher'] ?? 0;
$getPointUsedVoucher->close();

// Calculate remaining points
$totalPoinTersisa = $resultPoinTukar - ($resultPointUsed + $resultPointUsedVoucher);

// Get product data
$sql_product = "SELECT nama, foto, poin, size FROM produk WHERE id_produk = ?";
$stmt_product = $conn->prepare($sql_product);
$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$product_data = $stmt_product->get_result()->fetch_assoc();
$product_points = $product_data['poin'];
$stmt_product->close();

// Check if user has enough points
$can_redeem = $totalPoinTersisa >= $product_points;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Points</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <div class="bg-white p-5 rounded shadow">
        <h3 class="mb-4 text-pink-600 font-semibold text-xl">Detail Produk Penukaran</h3>
        <div class="grid grid-cols-12 gap-8">
            <!-- Product Image - Left Side (30%) -->
            <div class="col-span-4 flex justify-center items-center">
                <img src="../images/<?= $product_data["foto"] ?>"
                     alt="<?php echo htmlspecialchars($product_data['nama']); ?>"
                     class="max-w-[75%] h-auto rounded-lg shadow-lg">
            </div>
            <!-- Product Details - Right Side (70%) -->
            <div class="col-span-8 space-y-4">
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="mb-2"><span class="font-semibold text-pink-400">Nama Produk:</span> 
                        <span class="text-gray-700"><?php echo htmlspecialchars($product_data['nama']); ?></span>
                    </p>
                    <p class="mb-2"><span class="font-semibold text-pink-400">Ukuran:</span> 
                        <span class="text-gray-700"><?php echo htmlspecialchars($product_data['size']); ?></span>
                    </p>
                    <p class="mb-2"><span class="font-semibold text-pink-400">Poin Dibutuhkan:</span> 
                        <span class="text-gray-700"><?php echo number_format($product_points); ?></span>
                    </p>
                </div>
                
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="mb-2"><span class="font-semibold text-pink-400">Total Poin Anda:</span> 
                        <span class="text-gray-700"><?php echo number_format($totalPoinTersisa); ?></span>
                    </p>
                    <p class="mb-2"><span class="font-semibold text-pink-400">Sisa Poin Setelah Penukaran:</span> 
                        <span class="text-gray-700"><?php echo number_format($totalPoinTersisa - $product_points); ?></span>
                    </p>
                    <?php if (!$can_redeem): ?>
                        <p class="text-red-700 font-semibold mt-2">Warning: Poin tidak mencukupi untuk penukaran!!!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="bg-white p-5 rounded shadow">
        <h1 class="mb-4 text-pink-500 font-bold text-3xl">Atur Pengiriman</h1>
        <form id="shipping-form" method="POST" class="w-full">
            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" id="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" id="product_name" value="<?php echo htmlspecialchars($product_data['nama']); ?>">
            <input type="hidden" id="product_size" value="<?php echo htmlspecialchars($product_data['size']); ?>">
            <input type="hidden" id="points_used" value="<?php echo $product_points; ?>">
            <input type="hidden" id="foto" value="<?php echo htmlspecialchars($product_data['foto']); ?>">

            <!-- Shipping Form -->
            <div class="space-y-4">
                <div class="mb-3">
                    <label for="name" class="block text-pink-500 font-medium mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="name" 
                        class="block w-full p-2 border border-pink-200 rounded focus:border-pink-500 focus:ring-pink-500" 
                        value="<?php echo htmlspecialchars($nama_lengkap); ?>" 
                        readonly>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="block text-pink-500 font-medium mb-2">Nomor Telepon</label>
                    <input 
                        type="text" 
                        id="phone" 
                        class="block w-full p-2 border border-pink-200 rounded focus:border-pink-500 focus:ring-pink-500" 
                        required>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="block text-pink-500 font-medium mb-2">Alamat Lengkap</label>
                    <textarea 
                        id="address" 
                        class="block w-full p-2 border border-pink-200 rounded focus:border-pink-500 focus:ring-pink-500" 
                        rows="3" 
                        required>
                    </textarea>
                </div>
                
                <div class="mb-3">
                    <label for="province" class="block text-pink-500 font-medium mb-2">Provinsi, Kab/Kota, Kecamatan, Kode Pos</label>
                    <input 
                        type="text" 
                        id="province" 
                        class="block w-full p-2 border border-pink-200 rounded focus:border-pink-500 focus:ring-pink-500" 
                        required>
                </div>
            </div>

            <!-- Expedition Options -->
            <div class="mt-6">
                <label class="block text-pink-500 font-medium mb-4">Pilih Ekspedisi</label>
                <div class="grid grid-cols-4 gap-6">
                    <?php 
                    $expeditions = ['jne', 'jnt', 'sicepat', 'wahana'];
                    foreach ($expeditions as $expedition): ?>
                        <div class="expedition-option text-center">
                            <input type="radio" name="expedition" id="<?php echo $expedition; ?>" 
                                   value="<?php echo $expedition; ?>" class="hidden" required>
                            <label for="<?php echo $expedition; ?>" class="cursor-pointer">
                                <div class="border-2 border-pink-200 rounded-lg p-4 hover:border-pink-500 transition-all
                                            expedition-label">
                                    <img src="<?php echo HOST; ?>/foto/<?php echo $expedition; ?>.png" 
                                         alt="<?php echo $expedition; ?>" 
                                         class="w-full h-auto mb-2">
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="text-end mt-6">
                <button type="submit" class="bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
                    Konfirmasi Penukaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('shipping-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const expedition = document.querySelector('input[name="expedition"]:checked');
    if (!expedition) {
        Swal.fire({
            title: 'Error!',
            text: 'Pilih ekspedisi pengiriman!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const formData = {
        user_id: document.getElementById('user_id').value,
        product_id: document.getElementById('product_id').value,
        product_name: document.getElementById('product_name').value,
        product_size: document.getElementById('product_size').value,
        name: document.getElementById('name').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        address: document.getElementById('address').value.trim(),
        province: document.getElementById('province').value.trim(),
        expedition: expedition.value,
        points_used: document.getElementById('points_used').value,
        foto: document.getElementById('foto').value
    };

    // Validate form data
    for (const [key, value] of Object.entries(formData)) {
        if (!value) {
            Swal.fire({
                title: 'Error!',
                text: 'Semua field harus diisi!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
    }

    fetch('process_redemption.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Delete the product after successful redemption
            return fetch('delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: formData.product_id
                })
            }).then(response => response.json());
        } else {
            throw new Error(data.message || 'Gagal memproses penukaran');
        }
    })
    .then(deleteData => {
        if (deleteData.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Penukaran poin berhasil! Produk akan segera dikirim.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '/Tubes_WebPro_PremurosaClothes/user/menuswap.php';
            });
        } else {
            throw new Error('Gagal menghapus produk');
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat memproses penukaran.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});

// Add click handler for expedition options
document.querySelectorAll('.expedition-option').forEach(option => {
    option.addEventListener('click', function() {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        
        // Remove active class from all options
        document.querySelectorAll('.expedition-option').forEach(opt => {
            opt.classList.remove('bg-pink-200');
        });
        
        // Add active class to selected option
        this.classList.add('bg-pink-200');
    });
});
</script>
</body>
</html>
<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$user_id = $_SESSION['user_id'];

$sqlStatement = "
    SELECT 
        shipping_data.id AS shipping_id,
        shipping_data.user_id,
        shipping_data.name,
        shipping_data.phone,
        shipping_data.address,
        shipping_data.province,
        shipping_data.product_id,
        shipping_data.product_name,
        shipping_data.product_size,
        shipping_data.expedition,
        shipping_data.points_used,
        shipping_data.shipping_date,
        shipping_data.foto,
        point_redemptions.id AS redemption_id,
        point_redemptions.points_used AS redemption_points,
        point_redemptions.status AS redemption_status,
        point_redemptions.redemption_date
    FROM 
        shipping_data
    LEFT JOIN 
        point_redemptions 
    ON 
        shipping_data.redemption_id = point_redemptions.id
";

// Execute the query
$query = mysqli_query($conn, $sqlStatement);

// Check if query execution was successful
if (!$query) {
    die("Error executing query: " . mysqli_error($conn));
}

// Fetch all results as an associative array
$riwayatproduk = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sqlStatement = "SELECT * FROM tukar_voucher";
$query = mysqli_query($conn, $sqlStatement);
$riwayatvoucher = mysqli_fetch_all($query, MYSQLI_ASSOC);

$user_id = $_SESSION['user_id'];

// Ambil nama lengkap pengguna dari tabel pengguna
$sqlUser = "SELECT CONCAT(first_name, ' ', last_name) AS nama_lengkap FROM user WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();
$namaLengkap = $userData['nama_lengkap'];

// Ambil data orders yang sesuai dengan nama lengkap pengguna
$sqlStatement = "SELECT * FROM orders WHERE nama_lengkap = ?";
$stmtOrder = $conn->prepare($sqlStatement);
$stmtOrder->bind_param("s", $namaLengkap);
$stmtOrder->execute();
$query = $stmtOrder->get_result();
$data = $query->fetch_all(MYSQLI_ASSOC);
?>

    <style>
        .container {
            max-width: 1200px;
            margin-bottom: 30px;
            margin-top: 20px;
            padding-left: 10px;
            padding-right: 15px;
        }
    </style>
<main>
    <body class="bg-gray-50">
        <div class="container">
            <div class="bg-white p-4 rounded-lg shadow justify-content-center">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-pink-600"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Tukar Poin Produk</h2>
                </div>
                            
                <!-- Table Riwayat -->
                <div class="bg-white  overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-pink-100">
                            <tr>
                                <th class="py-3 px-4 text-center text-pink-600">ID Produk</th>
                                <th class="py-3 px-4 text-center text-pink-600">Nama Produk</th>
                                <th class="py-3 px-4 text-center text-pink-600">Foto Produk</th>
                                <th class="py-3 px-4 text-center text-pink-600">Poin yang digunakan</th>
                                <th class="py-3 px-4 text-center text-pink-600">Tanggal Penukaran</th>
                                <th class="py-3 px-4 text-center text-pink-600">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($riwayatproduk as $key => $produk) {
                            ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4 text-center"><?= htmlspecialchars($produk['product_id']) ?></td>
                                <td class="py-2 px-4 text-center"><?= htmlspecialchars($produk['product_name']) ?></td>
                                <td class="py-2 px-4 text-center">
                                    <!-- Check if the 'foto' field has a value before displaying the image -->
                                    <?php if (!empty($produk['foto'])): ?>
                                        <img src="../images/<?= htmlspecialchars($produk['foto']) ?>" alt="Foto Detail" class="w-16 h-16 object-cover mx-auto rounded-md">
                                    <?php else: ?>
                                        <span>No image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 text-center"><?= htmlspecialchars($produk['points_used']) ?></td>
                                <td class="py-2 px-4 text-center"><?= htmlspecialchars($produk['redemption_date']) ?></td>
                                <td class="py-2 px-4 text-center">
                                    <?php
                                    // Ensure that 'status' field is correctly accessed and handle different statuses
                                    if ($produk['redemption_status'] === 'diterima') {
                                        echo '<span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>' . ucfirst($produk['redemption_status']) . '
                                            </span>';
                                    } elseif ($produk['redemption_status'] === 'dikirim') {
                                        echo '<span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-spinner mr-1"></i>' . ucfirst($produk['redemption_status']) . '
                                            </span>';
                                    } elseif ($produk['redemption_status'] === 'proses') {
                                        echo '<span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-spinner mr-1"></i>' . ucfirst($produk['redemption_status']) . '
                                            </span>';
                                    } else {
                                        echo '<span class="text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-exclamation-circle mr-1"></i>Status Tidak Diketahui
                                            </span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="bg-white p-4 rounded-lg shadow justify-content-center">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-pink-600"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Tukar Poin Voucher</h2>
                </div>
                <!-- Table Riwayat Voucher -->
                <div class="bg-white overflow-hidden text-xs">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-pink-100">
                            <tr>
                                <th class="py-3 px-4 text-center text-pink-600">Kode Voucher</th>
                                <th class="py-3 px-4 text-center text-pink-600">Nama Voucher</th>
                                <th class="py-3 px-4 text-center text-pink-600">Poin yang digunakan</th>
                                <th class="py-3 px-4 text-center text-pink-600">Tanggal Penukaran</th>
                                <th class="py-3 px-4 text-center text-pink-600">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($riwayatvoucher as $key => $voucher) {
                            ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4 text-center"><?= $voucher['voucher_code'] ?></td>
                                <td class="py-2 px-4 text-center"><?= $voucher['voucher_name'] ?></td>
                                <td class="py-2 px-4 text-center"><?= $voucher['points_used'] ?></td>
                                <td class="py-2 px-4 text-center"><?= $voucher['claim_date'] ?></td>
                                <td class="py-2 px-4 text-center">
                                <?php
                                    if ($voucher['status'] === 'Terpakai') {
                                        echo '<span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>' . ucfirst($voucher['status']) . '
                                            </span>';
                                    } elseif ($voucher['status'] === 'Belum Terpakai') {
                                        echo '<span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-spinner mr-1"></i>' . ucfirst($voucher['status']) . '
                                            </span>';
                                    } elseif ($voucher['status'] === 'Kadaluwarsa') {
                                        echo '<span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                                <i class="fas fa-exclamation-circle mr-1"></i>' . ucfirst($voucher['status']) . '
                                            </span>';
                                    }
                                ?>
                                </td>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</main>

<?php
include "template/footer_user.php";
?>


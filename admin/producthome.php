<?php
include "template/header_admin.php"
?>
<!-- Main Content -->
<div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Products</h2>
                <div class="flex items-center">
                    <input type="text" placeholder="Search" class="border rounded p-2 mr-4">
                    <button class="bg-pink-500 text-white px-4 py-2 rounded"onclick="window.location.href='newproduct.html'">ADD NEW PRODUCT</button>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6">
                <!-- Product Card -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
                <!-- Repeat Product Card for other products -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include "template/header_admin.php"
?>

<!-- Main Content -->
<div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Order List</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-gray-500">Nov 16, 2024 - Feb 29, 2024</div>
                    <button class="bg-white border border-gray-300 rounded px-4 py-2">Change Status</button>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-xl font-semibold mb-4">Recent Purchases</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Product</th>
                            <th class="py-2 px-4 border-b">Order ID</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Customer Name</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25426</td>
                            <td class="py-2 px-4 border-b">Nov 8th, 2024</td>
                            <td class="py-2 px-4 border-b">Amanda</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 250.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25425</td>
                            <td class="py-2 px-4 border-b">Nov 7th, 2024</td>
                            <td class="py-2 px-4 border-b">Salima</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 250.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25424</td>
                            <td class="py-2 px-4 border-b">Nov 6th, 2024</td>
                            <td class="py-2 px-4 border-b">Alex</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 200.000</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Lorem Ipsum</td>
                            <td class="py-2 px-4 border-b">#25423</td>
                            <td class="py-2 px-4 border-b">Nov 5th, 2024</td>
                            <td class="py-2 px-4 border-b">Rina</td>
                            <td class="py-2 px-4 border-b">
                                <select class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In progress</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="py-2 px-4 border-b">Rp 150.000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-gray-600 text-sm">Showing 1 to 4 of 50 entries</span>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 border rounded-md text-gray-600 bg-white">Previous</button>
                        <button class="px-3 py-1 border rounded-md text-gray-600 bg-white">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
ob_start();
include "template/header_admin.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (isset($_GET['voucher_code'])) {
    $voucher_code = $_GET['voucher_code'];

    $sqlStatement = "SELECT * FROM vouchers WHERE voucher_code = '$voucher_code'";
    $query = mysqli_query($conn, $sqlStatement);
    $voucher = mysqli_fetch_assoc($query);

    if (!$voucher) {
        die("Voucher not found!");
    }
} else {
    die("Voucher code not provided!");
}

if (isset($_POST['btnupdatevoucher'])) {
    $voucher_name = $_POST['voucher_name'];
    $discount = $_POST['discount'];
    $points = $_POST['points'];
    $usage_period = $_POST['usage_period'];
    $max_period = $_POST['max_period'];
    $usage_quota = $_POST['usage_quota'];
    $max_amount = $_POST['max_amount'];

    // Validate date range
    if ($max_period < $usage_period) {
        echo "<script>alert('Selesai Penggunaan tidak boleh kurang dari Mulai Penggunaan!');</script>";
    } else {
        $updateQuery = "UPDATE vouchers SET 
            voucher_name = '$voucher_name',
            discount = '$discount',
            points = '$points',
            usage_period = '$usage_period',
            max_period = '$max_period',
            usage_quota = '$usage_quota',
            max_amount = '$max_amount'
            WHERE voucher_code = '$voucher_code'";

        if (mysqli_query($conn, $updateQuery)) {
            header("Location: swappoin.php?message=Voucher updated successfully");
            exit();
        } else {
            echo "Failed to update voucher: " . mysqli_error($conn);
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="w-full max-w-8xl bg-purple-300 p-8">
        <h3 class="text-center text-3xl font-bold text-purple-800 mb-6">Edit Voucher</h3>

        <form method="post" enctype="multipart/form-data" class="space-y-6">
            <div class="space-y-2">
                <label for="voucher_name" class="block text-gray-700 font-medium">Nama Voucher</label>
                <input type="text" id="voucher_name" name="voucher_name" value="<?= htmlspecialchars($voucher['voucher_name']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Enter voucher name">
            </div>

            <div class="space-y-2">
                <label for="discount" class="block text-gray-700 font-medium">Discount</label>
                <input type="text" id="discount" name="discount" value="<?= htmlspecialchars($voucher['discount']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Enter discount value">
            </div>

            <div class="space-y-2">
                <label for="points" class="block text-gray-700 font-medium">Poin</label>
                <input type="text" id="points" name="points" value="<?= htmlspecialchars($voucher['points']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Enter points required">
            </div>

            <div class="space-y-2">
                <label for="usage_period" class="block text-gray-700 font-medium">Mulai Penggunaan</label>
                <input type="datetime-local" id="usage_period" name="usage_period" 
                    value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($voucher['usage_period']))) ?>" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="space-y-2">
                <label for="max_period" class="block text-gray-700 font-medium">Selesai Penggunaan</label>
                <input type="datetime-local" id="max_period" name="max_period" 
                    value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($voucher['max_period']))) ?>" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="space-y-2">
                <label for="usage_quota" class="block text-gray-700 font-medium">Kuota</label>
                <input type="text" id="usage_quota" name="usage_quota" value="<?= htmlspecialchars($voucher['usage_quota']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Enter usage quota">
            </div>

            <div class="space-y-2">
                <label for="max_amount" class="block text-gray-700 font-medium">Maksimal Pembelian</label>
                <input type="text" id="max_amount" name="max_amount" value="<?= htmlspecialchars($voucher['max_amount']) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Enter max amount">
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="history.back()" class="px-6 py-2 bg-gray-400 font-semibold text-white rounded-lg hover:bg-gray-500 transition">Cancel</button>
                <button type="submit" name="btnupdatevoucher" class="px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">Update</button>
            </div>
        </form>
    </div>

    <script>
        const usagePeriod = document.getElementById('usage_period');
        const maxPeriod = document.getElementById('max_period');

        usagePeriod.addEventListener('change', () => {
            if (maxPeriod.value && maxPeriod.value < usagePeriod.value) {
                maxPeriod.value = usagePeriod.value;
            }
            maxPeriod.min = usagePeriod.value;
        });

        maxPeriod.addEventListener('change', () => {
            if (maxPeriod.value < usagePeriod.value) {
                alert('Selesai Penggunaan tidak boleh kurang dari Mulai Penggunaan.');
                maxPeriod.value = usagePeriod.value;
            }
        });
    </script>

</body>
<?php
include "template/footer_admin.php"
?>
</html>

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
</html>
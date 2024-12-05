<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Check if a voucher_code is provided
if (isset($_GET['voucher_code'])) {
    $voucher_code = $_GET['voucher_code'];

    // Fetch existing voucher data
    $sqlStatement = "SELECT * FROM vouchers WHERE voucher_code = '$voucher_code'";
    $query = mysqli_query($conn, $sqlStatement);
    $voucher = mysqli_fetch_assoc($query);

    if (!$voucher) {
        die("Voucher not found!");
    }
} else {
    die("Voucher code not provided!");
}

// Handle form submission for updating the voucher
if (isset($_POST['btnupdatevoucher'])) {
    $voucher_name = $_POST['voucher_name'];
    $discount = $_POST['discount'];
    $points = $_POST['points'];
    $usage_period = $_POST['usage_period'];
    $max_period = $_POST['max_period'];
    $usage_quota = $_POST['usage_quota'];
    $max_amount = $_POST['max_amount'];

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
<body class="bg-gray-100 font-rubik">

<div class="flex justify-center items-center h-screen">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Edit Voucher</h2>
        <form method="post">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Voucher Name</label>
                <input type="text" name="voucher_name" value="<?= htmlspecialchars($voucher['voucher_name']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Discount</label>
                <input type="text" name="discount" value="<?= htmlspecialchars($voucher['discount']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Poin</label>
                <input type="text" name="points" value="<?= htmlspecialchars($voucher['points']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Usage Period</label>
                <input type="datetime-local" name="usage_period" value="<?= htmlspecialchars($voucher['usage_period']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Max Period</label>
                <input type="datetime-local" name="max_period" value="<?= htmlspecialchars($voucher['max_period']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Usage Quota</label>
                <input type="text" name="usage_quota" value="<?= htmlspecialchars($voucher['usage_quota']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Max Amount</label>
                <input type="text" name="max_amount" value="<?= htmlspecialchars($voucher['max_amount']) ?>" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end space-x-4">
                <a href="swappoin.php" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" name="btnupdatevoucher" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Update</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

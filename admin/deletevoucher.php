<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$voucher_code = $_GET["voucher_code"];

$sqlStatement = "SELECT * FROM vouchers WHERE voucher_code='$voucher_code'";
$query = mysqli_query($conn, $sqlStatement);
$row = mysqli_fetch_assoc($query);

if ($row) {
    $voucher_code = $row['voucher_code'];

    $sqlStatement = "DELETE FROM vouchers WHERE voucher_code='$voucher_code'";
    $query = mysqli_query($conn, $sqlStatement);

    if ($query) {
        $succesMsg = "Penghapusan data voucher dengan voucher code " . $voucher_code . " berhasil";
        header("Location: swappoin.php?successMsg=" . urlencode($succesMsg));
        exit;
    } else {
        echo "Error: Produk tidak berhasil dihapus.";
    }
} else {
    echo "Voucher dengan kode '$voucher_code' tidak ditemukan.";
}

mysqli_close($conn);
?>

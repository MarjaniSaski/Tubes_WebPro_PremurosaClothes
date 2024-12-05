
<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$voucher_code = $_GET["voucher_code"];

// cari data produk

$sqlStatement = "SELECT * FROM vouchers WHERE voucher_code='$voucher_code'";
$query = mysqli_query($conn, $sqlStatement);
$row = mysqli_fetch_assoc($query);


    // Hapus data produk
    $sqlStatement = "DELETE FROM vouchers WHERE voucher_code='$voucher_code'";
    $query = mysqli_query($conn, $sqlStatement);

    if ($query) {
        $succesMsg = "Penghapusan data produk dengan ID " . $voucher_code . " berhasil";
        header("location:swappoin.php?successMsg=$succesMsg");
    } else {
        echo "Error: Produk tidak berhasil dihapus.";
    }

mysqli_close($conn);
ob_end_flush();
?>

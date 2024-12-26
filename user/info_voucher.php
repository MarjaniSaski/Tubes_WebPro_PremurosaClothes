<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (isset($_GET['voucher_code'])) {
    $voucher_code = $_GET['voucher_code']; 
    $sql = "SELECT * FROM vouchers WHERE voucher_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $voucher_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $voucher = $result->fetch_assoc();

    // Jika voucher ditemukan, kembalikan data dalam format JSON
    if ($voucher) {
        echo json_encode($voucher);
    } else {
        echo json_encode(["error" => "Voucher not found"]);
    }
}
?>
<?php
include "template/footer_user.php"
?>

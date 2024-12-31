<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

header('Content-Type: application/json');

$conn->begin_transaction();

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate input data
    if (!isset($data['user_id'], $data['points_used'], $data['product_id'])) {
        throw new Exception('Data tidak lengkap');
    }

    // Get user's full name
    $sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $data['user_id']);
    $stmt_user->execute();
    $user_data = $stmt_user->get_result()->fetch_assoc();
    if (!$user_data) {
        throw new Exception('User tidak ditemukan');
    }
    $nama_lengkap = $user_data['first_name'] . ' ' . $user_data['last_name'];
    $stmt_user->close();

    // Get total points from orders
    $getPoinTukar = $conn->prepare("SELECT COALESCE(SUM(poin), 0) as total_poin FROM orders WHERE nama_lengkap = ?");
    $getPoinTukar->bind_param("s", $nama_lengkap);
    $getPoinTukar->execute();
    $result = $getPoinTukar->get_result();
    $row = $result->fetch_assoc();
    $resultPoinTukar = $row['total_poin'];
    $getPoinTukar->close();

    // Get used points
    $getPointUsed = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used FROM shipping_data WHERE user_id = ?");
    $getPointUsed->bind_param("i", $data['user_id']);
    $getPointUsed->execute();
    $result = $getPointUsed->get_result();
    $row = $result->fetch_assoc();
    $resultPointUsed = $row['points_used'];
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

    // Verify product points
    $sql_product = "SELECT poin FROM produk WHERE id_produk = ?";
    $stmt_product = $conn->prepare($sql_product);
    $stmt_product->bind_param("i", $data['product_id']);
    $stmt_product->execute();
    $product_data = $stmt_product->get_result()->fetch_assoc();
    if (!$product_data) {
        throw new Exception('Produk tidak ditemukan');
    }
    $product_points = $product_data['poin'];
    $stmt_product->close();

    // Verify points match
    if ($product_points != $data['points_used']) {
        throw new Exception('Poin produk tidak sesuai');
    }

    // Check if user has enough points
    if ($totalPoinTersisa < $product_points) {
        throw new Exception('Poin tidak mencukupi. Poin tersedia: ' . $totalPoinTersisa . ', Dibutuhkan: ' . $product_points);
    }

    // Record point redemption - Removed created_at column
    $sql_redeem = "INSERT INTO point_redemptions (user_id, points_used, status) 
                   VALUES (?, ?, 'processed')";
    $stmt_redeem = $conn->prepare($sql_redeem);
    $stmt_redeem->bind_param("ii", $data['user_id'], $product_points);
    if (!$stmt_redeem->execute()) {
        throw new Exception('Gagal mencatat penukaran poin');
    }
    $redemption_id = $conn->insert_id;
    $stmt_redeem->close();

    // Update product status to 'sudah terjual'
    $sql_update_product = "UPDATE produk SET status = 'sudah terjual' WHERE id_produk = ?";
    $stmt_update_product = $conn->prepare($sql_update_product);
    $stmt_update_product->bind_param("i", $data['product_id']);
    if (!$stmt_update_product->execute()) {
        throw new Exception('Gagal memperbarui status produk menjadi "sudah terjual"');
    }
    $stmt_update_product->close();
    
    // Record shipping data - Removed created_at column
    $sql_shipping = "INSERT INTO shipping_data (
        user_id, name, phone, address, province,
        product_id, product_name, product_size,
        expedition, points_used, redemption_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_shipping = $conn->prepare($sql_shipping);
    $stmt_shipping->bind_param(
        "issssisssii",
        $data['user_id'],
        $data['name'],
        $data['phone'],
        $data['address'],
        $data['province'],
        $data['product_id'],
        $data['product_name'],
        $data['product_size'],
        $data['expedition'],
        $product_points,
        $redemption_id
    );
    
    if (!$stmt_shipping->execute()) {
        throw new Exception('Gagal menyimpan data pengiriman');
    }
    $stmt_shipping->close();

    $conn->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Penukaran poin berhasil',
        'data' => [
            'redemption_id' => $redemption_id,
            'points_used' => $product_points,
            'remaining_points' => $totalPoinTersisa - $product_points
        ]
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'debug_info' => [
            'total_points' => $resultPoinTukar ?? 0,
            'points_used' => $resultPointUsed ?? 0,
            'remaining_points' => $totalPoinTersisa ?? 0,
            'required_points' => $product_points ?? 0
        ]
    ]);
}

$conn->close();
?>
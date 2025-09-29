<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

header('Content-Type: application/json');

$conn->begin_transaction();

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate input data
    if (!isset($data['user_id'], $data['points_used'], $data['voucher_code'])) {
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
    
    // Verify product points
    $sql_voucher = "SELECT points, usage_quota FROM vouchers WHERE voucher_code = ? AND usage_quota > 0";
$stmt_voucher = $conn->prepare($sql_voucher);
    $stmt_voucher->bind_param("i", $data['voucher_code']);
    $stmt_voucher->execute();
    $voucher_data = $stmt_voucher->get_result()->fetch_assoc();
    if (!$voucher_data) {
        throw new Exception('Voucher tidak tersedia atau kuota telah habis');
    }
    $voucher_points = $voucher_data['points'];
    $usage_quota = $voucher_data['usage_quota'];
    $stmt_voucher->close();

    // Verify points match
    if ($voucher_points != $data['points_used']) {
        throw new Exception('Poin produk tidak sesuai');
    }

    // Check if user has enough points
    if ($totalPoinTersisa < $voucher_points) {
        throw new Exception('Poin tidak mencukupi. Poin tersedia: ' . $totalPoinTersisa . ', Dibutuhkan: ' . $voucher_points);
    }

    // Record voucher exchange
    $sql_voucher_tukar = "INSERT INTO tukar_voucher (
        user_id,
        voucher_code,
        voucher_name,
        points_used,
        claim_date
    ) VALUES (?, ?, ?, ?, NOW())";

    $stmt_voucher_tukar = $conn->prepare($sql_voucher_tukar);
    $stmt_voucher_tukar->bind_param(
        "isss",
        $data['user_id'],
        $data['voucher_code'],
        $data['voucher_name'],
        $voucher_points
    );

    if (!$stmt_voucher_tukar->execute()) {
        throw new Exception('Gagal menyimpan data voucher tukar');
    }
    $stmt_voucher_tukar->close();

    // Update usage quota
    $update_quota = $conn->prepare("UPDATE vouchers SET usage_quota = usage_quota - 1 WHERE voucher_code = ?");
    $update_quota->bind_param("i", $data['voucher_code']);
    if (!$update_quota->execute()) {
        throw new Exception('Gagal mengurangi kuota penggunaan voucher');
    }
    $update_quota->close();

    $conn->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Penukaran poin berhasil',
        'data' => [
            'points_used' => $voucher_points,
            'remaining_points' => $totalPoinTersisa - $voucher_points
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
            'required_points' => $voucher_points ?? 0
        ]
    ]);
}
$conn->close();
?>

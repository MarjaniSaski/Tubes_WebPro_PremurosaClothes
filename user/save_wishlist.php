<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['wishlist'])) {
    //memastikan tidak ada data terduplikasi
    $_SESSION['wishlist'] = array_unique($data['wishlist']);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No wishlist data provided']);
}
?>

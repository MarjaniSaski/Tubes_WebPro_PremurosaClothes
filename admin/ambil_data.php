<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_order = $_GET['id']; // Ambil ID dari parameter URL

// Ambil data dari database berdasarkan ID
$sql = "SELECT * FROM orders WHERE id_order = '$id_order'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

// Pastikan data ditemukan
if ($data) {
    echo json_encode($data); // Mengembalikan data dalam format JSON
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
?>

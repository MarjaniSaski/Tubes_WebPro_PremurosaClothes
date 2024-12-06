<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Mengambil id produk 
$id_produk = isset($_GET['id_produk']) ? intval($_GET['id_produk']) : 0;

// Mengecek id produk
if ($id_produk <= 0) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

// mengambil data produk
$sql = "SELECT * FROM produk WHERE id = $id_produk";
$result = mysqli_query($conn, $sql);

// Mengecek apakah produk ditemukan
if (mysqli_num_rows($result) > 0) {
    // Mengambil data produk
    $product = mysqli_fetch_assoc($result);

    // Membuat array dengan data produk
    $productData = [
        'product_name' => $product['nama_produk'],
        'points' => $product['poin'],
        'details' => $product['deskripsi'],
        'image' => $product['foto'] // Pastikan path gambar sesuai dengan struktur direktori Anda
    ];

    // Mengembalikan data dalam format JSON
    echo json_encode($productData);
} else {
    echo json_encode(['error' => 'Product not found']);
}

mysqli_close($conn);
?>

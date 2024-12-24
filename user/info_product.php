<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_produk = isset($_GET['id_produk']) ? intval($_GET['id_produk']) : 0;

// Mengecek id produk
if ($id_produk <= 0) {
    echo json_encode(['error' => 'Invalid product ID: ' . $id_produk]);
    exit;
}

$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    echo json_encode(['error' => 'Query preparation failed']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id_produk);
mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Mengambil data produk
    $product = mysqli_fetch_assoc($result);

    // Membuat array dengan data produk
    $productData = [
        'nama' => $product['nama'],
        'point' => $product['poin'],
        'detail' => $product['detail'],
        'foto' => $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $product['foto'] // Pastikan path gambar sesuai
    ];

    // Mengembalikan data dalam format JSON
    echo json_encode($productData);
} else {
    echo json_encode(['error' => 'Product not found']);
}

// Menutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<?php
include "template/footer_user.php"
?>
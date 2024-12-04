// TODO gambar belum kehapus 

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_produk = $_GET["id_produk"];

/**
 * cari data produk
 */
$sqlStatement = "SELECT * FROM produk WHERE id_produk='$id_produk'";
$query = mysqli_query($conn, $sqlStatement);
$row = mysqli_fetch_assoc($query);

// Pastikan data ditemukan
if ($row) {
    // Ambil nama file foto
    $fotoPath = "../images/" . $row['foto'];

    // Hapus foto jika file ada
    if (file_exists($fotoPath)) {
        unlink($fotoPath);
    }

    // Hapus data produk
    $sqlStatement = "DELETE FROM produk WHERE id_produk='$id_produk'";
    $query = mysqli_query($conn, $sqlStatement);

    if ($query) {
        $succesMsg = "Penghapusan data produk dengan ID " . $id_produk . " berhasil";
        header("location:swappoin.php?successMsg=$succesMsg");
    } else {
        echo "Error: Produk tidak berhasil dihapus.";
    }
} else {
    echo "Produk tidak ditemukan.";
}

mysqli_close($conn);
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_order = $_GET['id_order'];
$id= $_GET['id'];
if (isset($_POST['submit'])) {      
    $status = $_POST['status']; // Status baru
    $poin = $_POST['poin'];   // Poin baru

    // Validasi input
    if (!empty($status) && !empty($poin) ) {
        // Mulai transaksi agar kedua query berjalan dengan aman
        mysqli_begin_transaction($conn);

        try {
            // Update query untuk tabel orders
            $sql_order = "UPDATE orders SET status = '$status' WHERE id_order = '$id_order'";

            if (!mysqli_query($conn, $sql_order)) {
                throw new Exception("Gagal memperbarui status pesanan.");
            }

            // Update query untuk tabel user
            $sql_user = "UPDATE users SET poin = poin + '$poin' WHERE id = '$id'";

            if (!mysqli_query($conn, $sql_user)) {
                throw new Exception("Gagal memperbarui poin pengguna.");
            }

            // Commit transaksi jika kedua query sukses
            mysqli_commit($conn);

            echo "<script>alert('Update berhasil!'); window.location.href = 'swapproduct.php';</script>";

        } catch (Exception $e) {
            // Rollback transaksi jika ada yang gagal
            mysqli_rollback($conn);
            echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href = 'swapproduct.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak lengkap!'); window.location.href = 'swapproduct.php';</script>";
    }
}
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';  

if (isset($_POST['submit'])) {
    $id_order = $_POST['id_order'];
    $status = $_POST['status'];
    $poin = $_POST['poin'];

    if ($conn) {
        $stmt = mysqli_prepare($conn, "UPDATE `orders` SET status = ?, poin = ? WHERE id_order = ?");
        
        mysqli_stmt_bind_param($stmt, "sii", $status, $poin, $id_order); 
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: swapproduct.php");  
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);  
        }

        // Menutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Tidak dapat terhubung ke database.";  
    }
}
?>

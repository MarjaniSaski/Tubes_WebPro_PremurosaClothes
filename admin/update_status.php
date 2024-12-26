<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';  

if (isset($_POST['submit'])) {
    // Get the form data and sanitize them to prevent errors
    $id_order = isset($_POST['id_order']) ? intval($_POST['id_order']) : 0;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
    $poin = isset($_POST['poin']) ? intval($_POST['poin']) : 0;

    // Check if the data is valid
    if ($id_order > 0 && !empty($status) && $poin >= 0) {
        if ($conn) {
            // Prepare the SQL query to update the order status
            $stmt = mysqli_prepare($conn, "UPDATE orders SET status = ?, poin = ? WHERE id_order = ?");
            
            if ($stmt) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($stmt, "sii", $status, $poin, $id_order);

                // Execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // After successful update, redirect with a success message
                    header("Location: swapproduct.php?status=updated");
                    exit;
                } else {
                    echo "Error: " . mysqli_error($conn); // Query execution error
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Failed to prepare the query."; // Query preparation failure
            }
        } else {
            echo "Error: Could not connect to the database."; // Connection failure
        }
    } else {
        echo "Error: Invalid data received."; // Validation failure
    }
}
?>

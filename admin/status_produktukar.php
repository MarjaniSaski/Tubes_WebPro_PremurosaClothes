<?php
ob_start();
include "template/header_admin.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (!isset($_GET['id'])) {
    die("Error: Missing ID.");
}

$id = $_GET['id'];

// Modified query to join with shipping_data first
$sqlStatement = "
    SELECT 
        s.id AS shipping_id,
        s.user_id,
        s.name,
        s.phone,
        s.address,
        s.province,
        s.product_id,
        s.product_name,
        s.product_size,
        s.expedition,
        s.points_used,
        s.shipping_date,
        s.foto,
        s.redemption_id,
        pr.points_used AS redemption_points,
        pr.status AS redemption_status,
        pr.redemption_date
    FROM 
        shipping_data s
    LEFT JOIN 
        point_redemptions pr
    ON 
        s.redemption_id = pr.id
    WHERE
        s.id = ?
";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $sqlStatement);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if query execution was successful and data exists
if (!$result || mysqli_num_rows($result) === 0) {
    die("Error: Product not found");
}

// Fetch the result
$riwayatproduk = mysqli_fetch_assoc($result);

// Handle form submission
if (isset($_POST['btnEdit'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Update the status in point_redemptions table
    $updateQuery = "
        UPDATE point_redemptions 
        SET status = ?
        WHERE id = ?
    ";
    
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "si", $status, $riwayatproduk['redemption_id']);
    
    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>
                alert('Status updated successfully');
                window.location.href = 'swappoin.php';
              </script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
}
?>

<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f5f5f5;
    }
    .container {
        background-color: rgba(185, 140, 233, 0.6);
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr; /* Changed to equal width columns */
        gap: 2rem;
        width: 95%;
        max-width: 1400px;
        margin: 2rem auto;
        min-height: 800px;
        border-radius: 15px;
    }
    .image-preview {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 1.5rem; /* Reduced padding */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        height: auto; /* Changed from 100% */
    }
    .image-preview img {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: contain;
        border-radius: 10px;
    }
    .form-container {
        padding: 1.5rem; /* Reduced padding to match image-preview */
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        height: auto; /* Added to match image-preview */
    }
    h2 {
        font-size: 2rem;
        color: #6a11cb;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    h3 {
        font-size: 1.8rem;
        color: #6a11cb;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    label {
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    input, select {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        background-color: #f8f8f8;
        margin-bottom: 1rem;
    }

    select {
        background-color: #fff;
        cursor: pointer;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
    }

    button {
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        color: #fff;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        width: 48%;
        transition: all 0.3s ease;
    }

    button[type="button"] {
        background-color: #9ca3af;
    }

    button[type="button"]:hover {
        background-color: #4b5563;
    }

    button[type="submit"] {
        background-color: #6a11cb;
    }

    button[type="submit"]:hover {
        background-color: #4c0099;
    }
</style>

<!-- Main Content -->
<div class="container">
    <div class="image-preview">
        <h2><?php echo htmlspecialchars($riwayatproduk['product_name']); ?></h2>
        <?php if (!empty($riwayatproduk['foto'])): ?>
            <img src="../images/<?php echo htmlspecialchars($riwayatproduk['foto']); ?>" alt="Product Image">
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>
    </div>
    <div class="form-container">
        <h3>Edit Status Produk</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Nama Produk</label>
                <input type="text" id="productName" value="<?php echo htmlspecialchars($riwayatproduk['product_name']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="productCode">ID Produk</label>
                <input type="text" id="productCode" value="<?php echo htmlspecialchars($riwayatproduk['product_id']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" value="<?php echo htmlspecialchars($riwayatproduk['name']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" value="<?php echo htmlspecialchars($riwayatproduk['phone']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" id="address" value="<?php echo htmlspecialchars($riwayatproduk['address']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="province">Provinsi</label>
                <input type="text" id="province" value="<?php echo htmlspecialchars($riwayatproduk['province']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="expedition">Ekspedisi</label>
                <input type="text" id="expedition" value="<?php echo htmlspecialchars($riwayatproduk['expedition']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="pointsUsed">Points Used</label>
                <input type="text" id="pointsUsed" value="<?php echo htmlspecialchars($riwayatproduk['points_used']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="shippingDate">Shipping Date</label>
                <input type="text" id="shippingDate" value="<?php echo htmlspecialchars($riwayatproduk['shipping_date']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="proses" <?php echo ($riwayatproduk['redemption_status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                    <option value="dikirim" <?php echo ($riwayatproduk['redemption_status'] == 'dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                    <option value="diterima" <?php echo ($riwayatproduk['redemption_status'] == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                </select>
            </div> 
            <div class="button-group">
                <button type="button" class="font-semibold" onclick="window.location.href='swappoin.php'">Cancel</button>
                <button type="submit" class="font-semibold" name="btnEdit">Save</button>
            </div>
        </form>
    </div>
</div>

<?php
include "template/footer_admin.php";
?>
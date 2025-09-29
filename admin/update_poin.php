<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_order = $_GET['id_order'] ?? null;

if ($id_order) {
    $sqlStatement = "SELECT * FROM orders WHERE id_order = ?";
    $stmt = mysqli_prepare($conn, $sqlStatement);
    mysqli_stmt_bind_param($stmt, "s", $id_order);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($query);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['BtnEdit'])) {
    $id_order = $_POST['id_order'];
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $jenis_barang = htmlspecialchars($_POST['jenis_barang']);
    $jenis_bahan = htmlspecialchars($_POST['jenis_bahan']);
    $status = htmlspecialchars($_POST['status']);
    $details = htmlspecialchars($_POST['details']);
    $poin = (int) $_POST['poin'];
    $foto = $_FILES['foto'];

    if (!empty($foto['name'])) {
        $photoName = time() . '_' . basename($foto['name']);
        $targetPath = "../images/" . $photoName;

        // Upload file baru
        if (move_uploaded_file($foto['tmp_name'], $targetPath)) {
            // Hapus file lama jika ada
            if (!empty($data['foto']) && file_exists("../images/" . $data['foto'])) {
                unlink("../images/" . $data['foto']);
            }
        }
    } else {
        $photoName = $data['foto'] ?? ''; // Gunakan foto lama jika tidak ada yang diunggah
    }

    // Query update
    $sqlStatement = "UPDATE orders SET 
        nama_lengkap = ?, 
        jenis_barang = ?, 
        jenis_bahan = ?, 
        status = ?, 
        poin = ?, 
        foto = ?, 
        details = ? 
        WHERE id_order = ?";
    
    $stmt = mysqli_prepare($conn, $sqlStatement);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssisss",
        $nama_lengkap,
        $jenis_barang,
        $jenis_bahan,
        $status,
        $poin,
        $photoName,
        $details,
        $id_order
    );

    if (mysqli_stmt_execute($stmt)) {
        $succesMsg = "Pengubahan data Poin dengan ID Order " . htmlspecialchars($id_order) . " berhasil";
        header("Location:adminswap.php?successMsg=" . urlencode($succesMsg));
        exit;
    } else {
        $errMsg = "Pengubahan data Product dengan ID Order " . htmlspecialchars($id_order) . " GAGAL! " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

ob_end_flush();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Premurosa Clothes Update </title>
    <style>
        .form-container {
            display: flex;
            padding: 2rem;
            gap: 2rem;
            background-color: rgb(233, 213, 255);
            min-height: 50vh;
        }

        .preview-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            width: 50%;
        }

        .preview-title {
            color: #6b46c1;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .preview-image {
            width: 100%;
            height: auto;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .form-section {
            flex: 1;
            background: white;
            padding: 1rem;
            border-radius: 1rem;
        }

        .form-title {
            color: #6b46c1;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            color: #4a5568;
            font-weight: 500;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background: white;
        }

        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            min-height: 80px;
            margin-bottom: 1rem;
            resize: vertical;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            text-transform: uppercase;
        }

        .btn-cancel {
            background: rgb(151, 160, 173);
            color: white;
            border: none;
            transition: background-color 0.3s ease; 
        }

        .btn-cancel:hover {
            background: rgb(171, 180, 193);
        }


        .btn-save {
            background: rgb(168, 136, 242);
            color: white;
            border: none;
            transition: background-color 0.3s ease; 
        }

        .btn-save:hover {
            background: rgb(188, 158, 252); 
        }


        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #FED7AA;
            color: #9A3412;
        }

        .status-completed {
            background-color: #BBF7D0;
            color: #166534;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Preview Section -->
        <div class="preview-card">
            <h3 class="preview-title" id="productName">Ulasan Produk</h3>
            <img src="../images/<?= $data['foto'] ?>" name="foto" id="previewImage" class="preview-image" alt="Product preview">
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2 class="form-title">Edit Status Produk</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">ID Pesanan:</label>
                    <input type="text" class="form-input" id="orderId" name="id_order" value="<?= htmlspecialchars($data['id_order']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Pelanggan:</label>
                    <input type="text" class="form-input" id="customerName" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Barang:</label>
                    <input type="text" class="form-input" id="jenisBarang" name="jenis_barang" value="<?= htmlspecialchars($data['jenis_barang']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Bahan:</label>
                    <input type="text" class="form-input" id="jenisBahan" name="jenis_bahan" value="<?= htmlspecialchars($data['jenis_bahan']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label">Status:</label>
                    <select class="form-select" name="status" id="status" value="<?= htmlspecialchars($data['status']) ?>">
                        <option value="pending">Menunggu</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Poin:</label>
                    <input type="number" class="form-input" name="poin" id="poin" value="<?= htmlspecialchars($data['poin']) ?>"required>
                </div>

                <div class="form-group">
                    <label class="form-label">Detail:</label>
                    <textarea class="form-textarea" name="details" id="details" readonly><?= htmlspecialchars($data['details']) ?></textarea>
                </div>

                <div class="button-group">
                    <button type="button" onclick="window.history.back()" class="btn btn-cancel">Kembali</button>
                    <button type="submit" name="BtnEdit"class="btn btn-save">Kirim</button>
                </div>
            </form>
        </div>
    </div>
  <?php
    include "template/footer_admin.php"
    ?>
</html>

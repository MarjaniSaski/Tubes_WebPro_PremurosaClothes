<?php
ob_start();
include "template/header_admin.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$id_produk = $_GET['id_produk'];
$sqlStatement = "SELECT * FROM produk WHERE id_produk='$id_produk'";
$query = mysqli_query($conn, $sqlStatement);
$row = mysqli_fetch_assoc($query);

if (isset($_POST['btnEdit'])) {
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $detail = $_POST['detail'];
    $foto = $_FILES['foto'];

    if (!empty($foto['name'])) {
        $photoName = time() . '_' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], '../images/' . $photoName);
        unlink("../images/" . $row['foto']);
    } else {
        $photoName = $row['foto'];
    }

    $sqlStatement = "UPDATE produk SET nama='$nama', poin='$poin', foto='$photoName', detail='$detail' WHERE id_produk='$id_produk'";
    $query = mysqli_query($conn, $sqlStatement);
    if ($query) {
        $succesMsg = "Pengubahan data Product dengan ProdukCode " . $id_produk . " berhasil";
        header("location:swappoin.php?successMsg=$succesMsg");
    } else {
        $errMsg = "Pengubahan data Product dengan ProductCode " . $id_produk . " GAGAL !" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
ob_end_flush();
?>

<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        background-color:rgba(185, 140, 233, 0.6) ;
        padding: 30px;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }

    .image-preview {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .image-preview img {
        max-width: 100%;
        border-radius: 10px;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    h2 {
        text-align: center;
        color: #6a11cb;
        font-weight: 600;
        margin-bottom: 20px;
    }

    h3 {
        text-align: center;
        color: #6a11cb;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 25px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        font-size: 14px;
    }

    button[type="button"] {
        background-color:rgb(135, 134, 134);
    }

    button[type="button"]:hover {
        background-color: rgb(88, 88, 88);
    }

    button[type="submit"] {
        background-color: #6a11cb;
    }

    button[type="submit"]:hover {
        background-color:rgb(63, 11, 119);
        
    }


    .button-group {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
</style>

<!-- Main Content -->
<div class="container">
    <div class="image-preview">
        <h2><?= $row['nama'] ?></h2>
        <img src="../images/<?= $row['foto'] ?>" alt="Product Image">
    </div>
    <div class="form-container">
        <h3>Edit Produk</h3>
        <form method="post" enctype="multipart/form-data">
            <label for="productName">Nama Produk</label>
            <input type="text" id="productName" name="nama" value="<?= $row['nama'] ?>" placeholder="Edit product name">

            <label for="productCode">Kode Produk</label>
            <input type="text" id="productCode" name="id_produk" value="<?= $row['id_produk'] ?>" readonly>

            <label for="points">Poin</label>
            <input type="text" id="points" name="poin" value="<?= $row['poin'] ?>" placeholder="Edit points">

            <label for="image">Upload Foto Produk</label>
            <input type="file" id="image" name="foto">

            <label for="details">Details</label>
            <textarea id="details" name="detail" placeholder="Add details" required><?= $row['detail'] ?></textarea>

            <div class="button-group">
                <button type="button" class="font-semibold" onclick="history.back()">Cancel</button>
                <button type="submit" class="font-semibold" name="btnEdit">Save</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

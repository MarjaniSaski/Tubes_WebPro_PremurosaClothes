<?php
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

    // Proses foto jika ada yang di-upload
    if (!empty($foto['name'])) {
        $photoName = time() . '_' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], '../images/' . $photoName);

        unlink("../images/" . $row['foto']);
    } else {
        $photoName = $row['foto'];
    }


    // Query untuk update data produk
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
?>
<style>
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 100vh;
    }
</style>

<!-- Main Content -->
<div class="content">
    <div class="container w-full sm:w-4/5 md:w-2/3 lg:w-2/4">
        <h2 class="text-2xl font-bold mb-6 text-purple-600">Edit Product</h2>
        <form method = "post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="productName">Product Name</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="productName" type="text" name= "nama" placeholder="Edit product name"  value="<?= $row['nama'] ?>">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="productCode">Product Code</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="productCode" type="text" name= "id_produk" placeholder="Edit product code"  value="<?= $row['id_produk'] ?>" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="points">Points</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="points" type="text" name= "poin" placeholder="Edit points"  value="<?= $row['poin'] ?>" >
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="image" name= "foto" type="file">
                        <img src="../images/<?= $row["foto"] ?>" alt="Foto Product" width="150">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="details">Details</label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="details" name= "detail" placeholder="Add details" required><?php echo $row['detail']; ?></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="button" onclick="" class="bg-gray-300 px-6 py-2 rounded hover:bg-gray-400 text-sm">Cancel</button>
                <button type="submit" name="btnEdit" class="bg-purple-500 text-white px-6 py-2 rounded hover:bg-purple-600 text-sm">Save</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
//buat 
if (isset($_POST['btnsubmit'])) {
    $id_produk = $_POST['id_produk'];
    $nama = $_POST['nama'];
    $poin = $_POST['poin'];
    $foto = $_FILES['foto'];
    if (!empty($foto['name'])) {
        $photoName = time() . '_' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], '../images/' . $photoName);
    } else {
        $photoName = "";
    }
    $detail = $_POST['detail'];

    $sqlStatement = "INSERT INTO produk VALUES('$id_produk','$nama','$poin','$photoName','$detail')";
    // echo $sqlStatement;
    $query = mysqli_query($conn, $sqlStatement);
    if (mysqli_affected_rows($conn) > 0) {
        header("location:swappoin.php"); //untuk mendirect data ke mana
    } else {
        echo "Penambahan produk gagal";
    }
}

$sqlStatement = "SELECT * FROM produk";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<?php
if (isset($_POST['btnvoucher'])) {
    $voucher_code = $_POST['voucher_code'];
    $voucher_name = $_POST['voucher_name'];
    $discount = $_POST['discount'];
    $points = $_POST['points'];
    $usage_period = $_POST['usage_period'];
    $max_period = $_POST['max_period'];
    $usage_quota = $_POST['usage_quota'];
    $max_amount = $_POST['max_amount'];

    $sqlStatement = "INSERT INTO vouchers VALUES('$voucher_code	','$voucher_name','$discount','$discount','$usage_period','$max_period','$usage_quota', '$max_amount')";
    // echo $sqlStatement;
    $query = mysqli_query($conn, $sqlStatement);
    if (mysqli_affected_rows($conn) > 0) {
        header("location:swappoin.php"); //untuk mendirect data ke mana
    } else {
        echo "Penambahan voucher gagal";
    }
}

$sqlStatement = "SELECT * FROM vouchers";
$query = mysqli_query($conn, $sqlStatement);
$datavoucher = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

    <style>
       
        /* Konten utama dengan margin untuk menghindari tumpang tindih */
        .main-content {
            margin-left: 16rem;
            /* Sama dengan lebar sidebar */
            margin-top: 4rem;
            /* Untuk menghindari tumpang tindih dengan header */
        }


        .table-container {
            margin-top: 0;
            /* Hapus margin atas */
        }

        /* Styling pop-up */
        .popup-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1100;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0.2s, opacity 0.2s;
        }

        .popup-container.active {
            visibility: visible;
            opacity: 1;
        }

        .popup {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
            <!-- Content -->
            <div class="p-6">
                <!-- Buttons -->
                <div class="flex justify-end mb-4 space-x-4">
                    <button onclick="showPopupAddVoucher()" class="bg-pink-300 text-black text-sm px-4 py-2 rounded-lg shadow">
                        <i class="fa-solid fa-plus"></i> ADD NEW VOUCHER
                    </button>
                    <button onclick="showPopupAddProduct()" class="bg-pink-300 text-black text-sm px-4 py-2 rounded-lg shadow">
                        <i class="fa-solid fa-plus"></i> ADD NEW PRODUCT
                    </button>
                </div>

                <!-- Tabel Voucher -->
                <div class="mt-4 table-container">
                    <h2 class="text-xl font-bold mb-4">Voucher List</h2>
                    <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
                        <thead>

                            <tr class="bg-white-100 text-sm">
                                <th class="px-6 py-3 text-left">Voucher Name</th>
                                <th class="px-6 py-3 text-left">Voucher Code</th>
                                <th class="px-6 py-3 text-left">Discount</th>
                                <th class="px-6 py-3 text-left">Poin</th>
                                <th class="px-6 py-3 text-left">Usage Period</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="voucher-table-body">
                        <?php
                            foreach ($datavoucher as $key => $vouchers) {
                            ?>
                                <tr class="bg-white-200 text-sm">
                                    <td class="px-6 py-3 text-left"><?= $vouchers['voucher_name'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $vouchers['voucher_code'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $vouchers['discount'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $vouchers['points'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $vouchers['usage_period'] ?></td>
                                    <td>
                                        <a href="editvoucherswap.php?voucher_code=<?= urlencode($vouchers['voucher_code']) ?>">
                                            <button class="bg-blue-500 text-black text-sm px-2 py-1 rounded-lg shadow">
                                                Edit
                                            </button>
                                        </a>
                                        <a href="deleteprodukswap.php?voucher_code=<?= urlencode($vouchers['voucher_code']) ?>"
                                            onclick="return confirm('Yakin akan menghapus data?')">
                                            <button class="bg-red-500 text-black py-1 px-2 rounded-lg shadow">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <br>

                <!-- Tabel Produk -->
                <div class="mt-4 table-container">
                    <h2 class="text-xl font-bold mb-4">Product List</h2>
                    <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
                        <thead>
                            <tr class="bg-white-200 text-sm">
                                <th class="px-6 py-3 text-left">Product Name</th>
                                <th class="px-6 py-3 text-left">Product Code</th>
                                <th class="px-6 py-3 text-left">Poin</th>
                                <th class="px-6 py-3 text-left">Details</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body">
                            <?php
                            foreach ($data as $key => $produk) {
                            ?>
                                <tr class="bg-white-200 text-sm">
                                    <td class="px-6 py-3 text-left"><?= $produk['nama'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $produk['id_produk'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $produk['poin'] ?></td>
                                    <td class="px-6 py-3 text-left"><?= $produk['detail'] ?></td>
                                    <td>
                                        <a href="editprodukswap.php?id_produk=<?= urlencode($produk['id_produk']) ?>">
                                            <button class="bg-blue-500 text-black text-sm px-2 py-1 rounded-lg shadow">
                                                Edit
                                            </button>
                                        </a>
                                        <a href="deleteprodukswap.php?id_produk=<?= urlencode($produk['id_produk']) ?>"
                                            onclick="return confirm('Yakin akan menghapus data?')">
                                            <button class="bg-red-500 text-black py-1 px-2 rounded-lg shadow">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-Up Add Voucher -->
    <div id="popup-add-voucher" class="popup-container">
        <div class="popup">
            <h2 class="text-lg font-bold mb-4">Add New Voucher</h2>
            <form method="post">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Voucher Name</label>
                        <input type="text" name="voucher_name" placeholder="Add voucher name" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Voucher Code</label>
                        <input type="text" name="voucher_code" placeholder="Add voucher code" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Discount</label>
                        <input type="text" name="discount" placeholder="% DISC" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poin</label>
                        <input type="text" name="points" placeholder="Add poin" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Usage Period</label>
                        <input type="datetime-local" name="usage_period" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Max Period</label>
                        <input type="datetime-local" name="max_period" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Usage Quota</label>
                        <input type="text" name="usage_quota" placeholder="Add max quota" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Max Amount</label>
                        <input type="text" name="max_amount" placeholder="Add max amount for buyer" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-4">
                    <button type="button" onclick="hidePopupAddVoucher()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" name="btnvoucher" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pop-Up Add Product -->
    <div id="popup-add-product" class="popup-container">
        <div class="popup">
            <h2 class="text-lg font-bold mb-4">Add Product</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Product Name</label>
                        <input type="text" name="nama" placeholder="Add product name" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Product Code</label>
                        <input type="text" name="id_produk" placeholder="Add product code" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poin</label>
                        <input type="text" name="poin" placeholder="Add poin" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Image</label>
                        <!-- Input file for image upload -->
                        <input type="file" accept="image/*" class="w-full border rounded px-3 py-2" id="product-image" name="foto">
                        <p class="text-sm text-gray-500 mt-2">Select an image from your device</p>


                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Details</label>
                        <textarea placeholder="Add details" class="w-full border rounded px-3 py-2 h-24" name="detail"></textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-4">
                    <!-- Samakan ukuran tombol Cancel dan Save -->
                    <button type="button" onclick="hidePopupAddProduct()" class="bg-gray-300 px-6 py-2 rounded hover:bg-gray-400 text-sm">Cancel</button>
                    <button type="submit" name="btnsubmit" class="bg-purple-500 text-white px-6 py-2 rounded hover:bg-purple-600 text-sm">Save</button>
                </div>
            </form>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        function showPopupAddVoucher() {
            document.getElementById('popup-add-voucher').classList.add('active');
        }


        function hidePopupAddVoucher() {
            document.getElementById('popup-add-voucher').classList.remove('active');
        }

        function showPopupAddProduct() {
            document.getElementById('popup-add-product').classList.add('active');
        }

        function hidePopupAddProduct() {
            document.getElementById('popup-add-product').classList.remove('active');
        }
    </script>

</body>

</html>
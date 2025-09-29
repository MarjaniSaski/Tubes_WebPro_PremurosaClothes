<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
//buat 
if (isset($_POST['btnsubmit'])) {
    $id_produk = mysqli_real_escape_string($conn, $_POST['id_produk']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $poin = mysqli_real_escape_string($conn, $_POST['poin']);
    $foto = $_FILES['foto'];
    $detail = mysqli_real_escape_string($conn, $_POST['detail']);

    // Validasi input kosong
    if (empty($id_produk) || empty($nama) || empty($poin) || empty($detail)) {
        echo "Semua kolom wajib diisi.";
        exit;
    }

    // Penanganan upload gambar
    $photoName = "";
    if (!empty($foto['name'])) {
        $photoName = time() . '_' . basename($foto['name']);
        $targetDir = '../images/';
        $targetFile = $targetDir . $photoName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Buat direktori jika belum ada
        }

        if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    }

    // Query insert
    $sqlStatement = "INSERT INTO produk (id_produk, nama, poin, foto, detail) 
                     VALUES ('$id_produk', '$nama', '$poin', '$photoName', '$detail')";

    $query = mysqli_query($conn, $sqlStatement);

    if ($query) {
        header("Location: swappoin.php"); // Redirect setelah berhasil
    } else {
        echo "Penambahan produk gagal: " . mysqli_error($conn); // Debugging error MySQL
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

$sqlStatement = "
    SELECT 
        shipping_data.id AS shipping_id,
        shipping_data.user_id,
        shipping_data.name,
        shipping_data.phone,
        shipping_data.address,
        shipping_data.province,
        shipping_data.product_id,
        shipping_data.product_name,
        shipping_data.product_size,
        shipping_data.expedition,
        shipping_data.points_used,
        shipping_data.shipping_date,
        shipping_data.foto,
        point_redemptions.id AS redemption_id,
        point_redemptions.points_used AS redemption_points,
        point_redemptions.status AS redemption_status,
        point_redemptions.redemption_date
    FROM 
        shipping_data
    LEFT JOIN 
        point_redemptions 
    ON 
        shipping_data.redemption_id = point_redemptions.id
";

// Execute the query
$query = mysqli_query($conn, $sqlStatement);

// Check if query execution was successful
if (!$query) {
    die("Error executing query: " . mysqli_error($conn));
}

// Fetch all results as an associative array
$riwayatproduk = mysqli_fetch_all($query, MYSQLI_ASSOC);

ob_end_flush();
?>
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        .main-content {
            margin-left: 16rem;
            margin-top: 4rem;
        }
        
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
        
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-center {
            justify-content: center;
        }
        
        .gap-2 {
            gap: 0.5rem; /* Atur jarak antar ikon dan teks */
        }
        
        .whitespace-nowrap {
            white-space: nowrap;
        }
        
        .rounded-full {
            border-radius: 9999px;
        }
        
        .text-xs {
            font-size: 0.75rem; /* Atur sesuai kebutuhan */
        }

    </style>
    
<body>
    <!-- Content -->
    <div class="p-6">
        <!-- Buttons -->
        <div class="flex justify-end mb-4 space-x-4">
            <button onclick="showPopupAddVoucher()" class="bg-purple-600 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow">
                <i class="fa-solid fa-plus"></i> Tambahkan Voucher Baru
            </button>
            <button onclick="showPopupAddProduct()" class="bg-purple-600 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow">
                <i class="fa-solid fa-plus"></i> Tambahkan Produk Baru
            </button>
        </div>

        <!-- Tabel Voucher -->
        <div class="mt-4">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Daftar Voucher</h2>
            <div class="border-b-2 border-gray-200 mb-6"></div>
            <table class="w-full text-sm text-left">
                <thead class="bg-purple-100">
                    <tr>
                        <th class="px-6 py-3 text-center">Nama Voucher</th>
                        <th class="px-6 py-3 text-center">Kode Voucher</th>
                        <th class="px-6 py-3 text-center">Diskon</th>
                        <th class="px-6 py-3 text-center">Poin</th>
                        <th class="px-6 py-3 text-center">Masa Pemakaian</th>
                        <th class="px-6 py-3 text-center">Batas Pemakaian</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="voucher-table-body">
                <?php
                    foreach ($datavoucher as $key => $vouchers) {
                    ?>
                    <tr>
                        <td class="px-6 py-3 text-center"><?= $vouchers['voucher_name'] ?></td>
                        <td class="px-6 py-3 text-center"><?= $vouchers['voucher_code'] ?></td>
                        <td class="px-6 py-3 text-center"><?= $vouchers['discount'] ?></td>
                        <td class="px-6 py-3 text-center"><?= $vouchers['points'] ?></td>
                        <td class="px-6 py-3 text-center"><?= $vouchers['usage_period'] ?></td>
                        <td class="px-6 py-3 text-center"><?= $vouchers['max_period']?></td>
                        <td>
                        <div class="flex justify-center space-x-2">
                            <!-- Tombol Edit -->
                            <a href="editvoucherswap.php?voucher_code=<?= urlencode($vouchers['voucher_code']) ?>">
                                <button class="flex justify-center items-center px-2 py-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                </button>
                            </a>
                            <!-- Tombol Hapus -->
                            <a href="deletevoucher.php?voucher_code=<?= urlencode($vouchers['voucher_code']) ?>" 
                            onclick="return confirm('Yakin akan menghapus data?')">
                                <button class="flex justify-center items-center px-2 py-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-2 14H7l-2-14m4-4h8a2 2 0 012 2v1H6V5a2 2 0 012-2z" />
                                    </svg>
                                </button>
                            </a>
                        </div>
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
        <div class="mt-4">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Daftar Produk</h2>
                <div class="border-b-2 border-gray-200 mb-6"></div>
                <table class="w-full text-sm text-left">
                    <thead class="bg-purple-100">
                        <tr>
                            <th class="px-6 py-3 text-center">Nama Produk</th>
                            <th class="px-6 py-3 text-center">Kode Produk</th>
                            <th class="px-6 py-3 text-center">Poin</th>
                            <th class="px-6 py-3 text-center">Detail</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        <?php
                        foreach ($data as $key => $produk) {
                        ?>
                        <tr>
                            <td class="px-6 py-3 text-center"><?= $produk['nama'] ?></td>
                            <td class="px-6 py-3 text-center"><?= $produk['id_produk'] ?></td>
                            <td class="px-6 py-3 text-center"><?= $produk['poin'] ?></td>
                            <td class="px-6 py-3 text-center"><?= $produk['detail'] ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <span class="<?= $produk['status'] == 'Belum Terjual' ? 'bg-orange-200 text-orange-800' : 'bg-green-200 text-green-800' ?> py-1 px-3 rounded-full text-xs">
                                    <?= ucfirst($produk['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-center space-x-2">
                                    <a href="editproduk.php?id_produk=<?= urlencode($produk['id_produk']) ?>">
                                        <button class="flex justify-center items-center px-2 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                        </button>                                        
                                    </a>
                                    <a href="deleteprodukswap.php?id_produk=<?= urlencode($produk['id_produk']) ?>"
                                        onclick="return confirm('Yakin akan menghapus data?')">
                                        <button class="flex justify-center items-center px-2 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-2 14H7l-2-14m4-4h8a2 2 0 012 2v1H6V5a2 2 0 012-2z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>   
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <!-- Tabel Produk Yang Harus Dikirim-->
        <div class="mt-4">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Produk Yang Harus Dikirim</h2>
                <div class="border-b-2 border-gray-200 mb-6"></div>
                <table class="w-full text-sm text-left">
                    <thead class="bg-purple-100">
                        <tr>
                            <th class="px-6 py-3 text-center">Nama Produk</th>
                            <th class="px-6 py-3 text-center">Foto</th>
                            <th class="px-6 py-3 text-center">ID User</th>
                            <th class="px-6 py-3 text-center">Nama</th>
                            <th class="px-6 py-3 text-center">Alamat</th>
                            <th class="px-6 py-3 text-center">Ekspedisi</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        <?php
                        foreach ($riwayatproduk as $key => $produktukar) {
                        ?>
                        <tr class="bg-white-200 text-sm">
                            <td class="px-6 py-3 text-center"><?= htmlspecialchars($produktukar['product_name']) ?></td>
                            <td class="px-6 py-3 text-center">
                                <?php if (!empty($produktukar['foto'])): ?>
                                    <img src="../images/<?= htmlspecialchars($produktukar['foto']) ?>" alt="Foto Detail" class="w-16 h-16 object-cover mx-auto rounded-md">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3 text-center"><?= htmlspecialchars($produktukar['user_id']) ?></td>
                            <td class="px-6 py-3 text-center"><?= htmlspecialchars($produktukar['name']) ?></td>
                            <td class="px-6 py-3 text-center"><?= htmlspecialchars($produktukar['address']) ?>, <?= htmlspecialchars($produktukar['province']) ?></td>
                            <td class="px-6 py-3 text-center"><?= htmlspecialchars($produktukar['expedition']) ?></td>
                            <td class="py-2 px-4 text-center">
                                <?php
                                if ($produktukar['redemption_status'] === 'diterima') {
                                    echo '<span class="flex items-center justify-center gap-2 text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full whitespace-nowrap">
                                            <i class="fas fa-check-circle"></i>' . ucfirst($produktukar['redemption_status']) . '
                                        </span>';
                                } elseif ($produktukar['redemption_status'] === 'dikirim') {
                                    echo '<span class="flex items-center justify-center gap-2 text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full whitespace-nowrap">
                                            <i class="fas fa-spinner"></i>' . ucfirst($produktukar['redemption_status']) . '
                                        </span>';
                                } elseif ($produktukar['redemption_status'] === 'proses') {
                                    echo '<span class="flex items-center justify-center gap-2 text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full whitespace-nowrap">
                                            <i class="fas fa-spinner"></i>' . ucfirst($produktukar['redemption_status']) . '
                                        </span>';
                                } else {
                                    echo '<span class="flex items-center justify-center gap-2 text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded-full whitespace-nowrap">
                                            <i class="fas fa-exclamation-circle"></i>Status Tidak Diketahui
                                        </span>';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="status_produktukar.php?id=<?= urlencode($produktukar['shipping_id']) ?>">
                                        <button class="flex justify-center items-center px-2 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                </svg>
                                        </button>                                        
                                    </a>
                                </div>   
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
    
    <!-- Pop-Up Add Voucher -->
    <div id="popup-add-voucher" class="popup-container">
        <div class="popup">
            <h2 class="text-lg font-bold mb-4">Tambah Voucher</h2>
            <form method="post">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Voucher</label>
                        <input type="text" name="voucher_name" placeholder="Tambah nama voucher" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kode Voucher</label>
                        <input type="text" name="voucher_code" placeholder="Tambah kode voucher" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Diskon</label>
                        <input type="text" name="discount" placeholder="% DISC" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poin</label>
                        <input type="text" name="points" placeholder="Tambah poin" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Periode Penggunaan</label>
                        <input type="datetime-local" name="usage_period" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Maksimum Penggunaan</label>
                        <input type="datetime-local" name="max_period" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kuota Penggunaan</label>
                        <input type="text" name="usage_quota" placeholder="Tambah kuota penggunaan" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Harga Maksimum</label>
                        <input type="text" name="max_amount" placeholder="Tambah harga maksimum" class="w-full border rounded px-3 py-2">
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
            <h2 class="text-lg font-bold mb-4">Tambah Produk</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Nama Produk</label>
                        <input type="text" name="nama" placeholder="Tambah nama produk" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kode Produk</label>
                        <input type="text" name="id_produk" placeholder="Tambah kode produk" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poin</label>
                        <input type="text" name="poin" placeholder="Tambah poin" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Foto</label>
                        <input type="file" accept="image/*" class="w-full border rounded px-3 py-2" id="product-image" name="foto">
                        <p class="text-sm text-gray-500 mt-2">Pilih gambar dari perangkat Anda</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Detail</label>
                        <textarea placeholder="Add details" class="w-full border rounded px-3 py-2 h-24" name="detail"></textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-4">
                    <button type="button" onclick="hidePopupAddProduct()" class="bg-gray-300 px-6 py-2 rounded hover:bg-gray-400 text-sm">Kembali</button>
                    <button type="submit" name="btnsubmit" class="bg-purple-500 text-white px-6 py-2 rounded hover:bg-purple-600 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <footer class="mt-auto">
        <?php include "template/footer_admin.php"; ?>
    </footer>

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

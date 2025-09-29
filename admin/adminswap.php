<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Mengambil data pesanan yang telah selesai
$sqlStatement = "SELECT * FROM orders WHERE status = 'selesai'";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<style>
       html, body {
            height: 100%;
            margin: 0;
        }

        .content-wrapper {
            min-height: calc(100vh - 60px); /* 60px adalah perkiraan tinggi footer */
            padding-bottom: 60px; /* Memberikan ruang untuk footer */
        }

        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 20px;
            text-align: left;
            border-top: 1px solid #ddd;
        }

        /* Pastikan konten utama memiliki padding bottom */
        .p-10 {
            padding-bottom: 60px; /* Memberikan ruang untuk footer */
        }
    #myModal {
        display: none;
    }

    .menunggu {
        color: orange;
    }

    .selesai {
        color: green;
    }
</style>
</head>
<body>
    <div class="content-wrapper">
        <div class="flex-1 p-10">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-2xl font-bold mb-4">Penukaran Selesai</h2>
                <p class="text-gray-500 mb-6">Status Penukaran Terbaru.</p>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="relative inline-block text-left ml-auto">
                    <button id="status-pending-button" type="button" class="inline-flex justify-center rounded-md border bg-purple-500 text-white py-2 px-4 hover:bg-purple-300 shadow-sm text-sm font-semibold" onclick="window.location.href='swapproduct.php';">
                        Status Menunggu
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Nama Pelanggan</th>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Jenis Barang</th>
                            <th class="py-2 px-4 border-b">Jenis Bahan</th>
                            <th class="py-2 px-4 border-b">Detail</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $swap) : ?>
                            <tr data-id="<?= $swap['id_order'] ?>">
                                <td class="py-2 px-4 border-b"><?= $swap['id_order'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $swap['nama_lengkap'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $swap['tanggal_penjemputan'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $swap['jenis_barang'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $swap['jenis_bahan'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="showDetails('<?= $swap['foto'] ?>')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                        <img src="../images/<?= $swap['foto'] ?>" alt="Foto Detail" class="w-16 h-16 object-cover mx-auto rounded-md">
                                    </button>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <span class="<?= $swap['status'] == 'menunggu' ? 'bg-orange-200 text-orange-800' : 'bg-green-200 text-green-800' ?> py-1 px-3 rounded-full text-xs">
                                        <?= ucfirst($swap['status']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b"><?= $swap['poin'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal for Image Details -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>
    </div>
<script>
    // Show details modal with image
    function showDetails(imageSrc) {
        const modal = document.getElementById("myModal");
        const modalImg = document.getElementById("modalImage");
        modal.style.display = "flex";
        modalImg.src = '../images/' + imageSrc;
    }

    // Close modal when clicking outside or on close button
    document.querySelector(".close").onclick = function () {
        const modal = document.getElementById("myModal");
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        const modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/footer_admin.php';
?>
</body>
</html>
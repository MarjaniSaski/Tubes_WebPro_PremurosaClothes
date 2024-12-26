<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlStatement = "SELECT * FROM orders WHERE status = 'Completed'";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<style>
    #myModal {
        display: none;
    }

    .pending {
        @apply text-orange-500;
    }

    .completed {
        @apply text-green-500;
    }
</style>

<div class="flex-1 p-10">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-bold mb-4">Swap Completed </h2>
        <p class="text-gray-500 mb-6">Status Swap Terbaru.</p>
    </div>

    <div class="flex justify-between items-center mb-6">
    <div class="relative inline-block text-left ml-auto">
        <!-- Button text is "Status Pending" -->
        <button id="status-pending-button" type="button" class="inline-flex justify-center rounded-md border bg-purple-500 text-white py-2 px-4 hover:bg-purple-300 shadow-sm text-sm font-semibold" onclick="window.location.href='swapproduct.php';">
            Status Pending
        </button>
    </div>
</div>

    <div class="overflow-x-auto mb-6">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Customer Name</th>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Jenis Barang</th>
                    <th class="py-2 px-4 border-b">Jenis Bahan</th>
                    <th class="py-2 px-4 border-b">Details</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $key => $swap) {
                ?>
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
                            <span class="<?= $swap['status'] == 'Pending' ? 'bg-orange-200 text-orange-800' : 'bg-green-200 text-green-800' ?> py-1 px-3 rounded-full text-xs">
                                <?= ucfirst($swap['status']) ?>
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b"><?= $swap['poin'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
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

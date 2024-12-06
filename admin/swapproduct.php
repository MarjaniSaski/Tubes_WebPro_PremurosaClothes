<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlStatement = "SELECT * FROM orders";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<<<<<<< HEAD
<!-- Main Content -->
=======
<style>
    #myModal {
        display: none;
    }
</style>

>>>>>>> b46aa38c2ccc725d88e3aa6e263b941b06f3d305
<div class="flex-1 p-10">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Swap > Product</h2>
        <p class="text-gray-500 mb-6">This is a list of latest swap.</p>
    </div>
    <div class="overflow-x-auto">
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
                    <th class="py-2 px-4 border-b">Action</th>
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
                        <td class="py-2 px-4 border-b">
                            <button onclick="showDetails('<?= $swap['foto'] ?>')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h3m4 0H4m4 0h3m0-7h0m0 14h0m0-7h0m0 7h0M7 4h0m0 16h0" />
                                </svg>
                            </button>
                        </td>
                        <td class="py-2 px-4 border-b"><span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs"><?= ucfirst($swap['status']) ?></span></td>
                        <td class="py-2 px-4 border-b"><?= $swap['poin'] ?></td>
                        <td class="border px-4 py-2">
                            <button onclick="showData('<?= $swap['id_order'] ?>')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 0l1.5 1.5a2.121 2.121 0 010 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div id="myModal" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
            <div class="modal-content bg-white p-6 rounded-lg shadow-lg relative max-w-lg w-full">
                <span class="close absolute top-2 right-2 text-2xl cursor-pointer">&times;</span>
                <img id="modalImage" src="" alt="Details Image" class="w-full h-auto rounded-lg">
            </div>
        </div>

        <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-96" id="detailsModal" data-id="">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">Details</h3>
                    <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="update_status.php" method="POST" id="updateForm">
                    <div id="detailsContent" class="mt-4"></div>
                    <div class="mt-4">
                        <label for="poin" class="block text-gray-700">Tambah Poin:</label>
                        <input type="number" name="poin" id="poin" class="border rounded py-2 px-3 mt-1 w-full" placeholder="Masukkan jumlah poin" required>
                    </div>
                    <div class="mt-4">
                        <label for="statusSelect" class="block text-gray-700">Status:</label>
                        <select name="status" id="statusSelect" class="border rounded py-2 px-3 mt-1 w-full">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="in_progress">In Progress</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <input type="hidden" name="id_order" id="orderId">
                    <div class="mt-4 flex justify-between">
                        <button type="submit" name="submit" class="bg-purple-500 text-white py-2 px-4 rounded">UPDATE</button>
                        <button type="button" onclick="closeDetails()" class="bg-gray-500 text-white py-2 px-4 rounded">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetails(imageSrc) {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "flex";
        modalImg.src = '../images/' + imageSrc;
    }

    document.querySelector(".close").onclick = function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function showData(id) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'ambil_data.php?id=' + id, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const detailsData = JSON.parse(xhr.responseText);
                if (!detailsData.error) {
                    const data = detailsData;
                    const detailsContent = document.getElementById('detailsContent');
                    detailsContent.innerHTML = `
                        <p><strong>ID:</strong> ${data.id_order}</p>
                        <p><strong>Date:</strong> ${data.tanggal_penjemputan}</p>
                        <p><strong>Customer Name:</strong> ${data.nama_lengkap}</p>
                        <p><strong>Jenis Barang:</strong> ${data.jenis_barang}</p>
                        <p><strong>Jenis Bahan:</strong> ${data.jenis_bahan}</p>
                        <p><strong>Details:</strong> ${data.details}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                        <p><strong>Poin:</strong> ${data.poin}</p>
                    `;
                    document.getElementById('orderId').value = data.id_order;
                    document.getElementById('detailsModal').setAttribute('data-id', data.id_order);
                    document.getElementById('detailsModal').classList.remove('hidden');
                } else {
                    alert('Data tidak ditemukan!');
                }
            }
        };
        xhr.send();
    }

    function closeDetails() {
        document.getElementById('detailsModal').classList.add('hidden');
    }
</script>

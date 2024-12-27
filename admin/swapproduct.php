<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlStatement = "SELECT * FROM tukar_pakaian WHERE status = 'Pending'";
$query = mysqli_query($conn, $sqlStatement);
$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<style>
    #myModal {
        display: none;
    }
    .pending {
        @apply text-orange-500; /* Warna oranye untuk pending */
    }

    .completed {
        @apply text-green-500; /* Warna hijau untuk completed */
    }
    .form-container {
        display: flex;
        padding: 2rem;
        gap: 2rem;
        background-color: rgb(233, 213, 255);
        min-height: 100vh;
    }

    .preview-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        width: 40%;
    }

    .form-section {
        flex: 1;
        padding: 1rem;
    }

    .preview-title {
        color: #6b46c1;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .preview-image {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .form-title {
        color: #6b46c1;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #4a5568;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        background: white;
    }

    .form-textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        min-height: 100px;
        background: white;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }

    .btn-cancel {
        padding: 0.5rem 2rem;
        background: #718096;
        color: white;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
    }

    .btn-save {
        padding: 0.5rem 2rem;
        background: #6b46c1;
        color: white;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
    }

    .file-input-container {
        margin-bottom: 1rem;
    }

    .file-input-button {
        padding: 0.5rem 1rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        cursor: pointer;
    }
</style>

<div class="flex-1 p-10">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-2xl font-bold mb-4">Swap Pending</h2>
    <p class="text-gray-500 mb-6">Status Swap Terbaru.</p>
</div>
<div class="mb-4">
    <button onclick="goBack()" class="bg-purple-500 text-white py-2 px-4 font-semibold hover:bg-purple-300 rounded">
        Back
</button>
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
                <th class="py-2 px-4 border-b">Action</th>
            </tr>
        </thead>
        <tbody>
                <?php
                foreach ($data as $key => $swap) {
                ?>
                    <tr data-id="<?= $swap['id'] ?>">
                        <td class="py-2 px-4 border-b"><?= $swap['id'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $swap['nama_lengkap'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $swap['tanggal_penjemputan'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $swap['jenis_barang'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $swap['jenis_bahan'] ?></td>
                        <td class="py-2 px-4 border-b text-center">
                            <button onclick="showDetails('<?= $swap['foto'] ?>')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                <img src="../images/<?= $swap['foto'] ?>" alt="Foto Detail" class="w-16 h-16 object-cover mx-auto rounded-md">
                            </button>
                        </td>

                        <!-- Modal untuk menampilkan gambar besar -->
                        <div id="myModal" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="modal-content bg-white p-6 rounded-lg shadow-lg relative max-w-lg w-full">
                                <span class="close absolute top-2 right-2 text-2xl cursor-pointer">&times;</span>
                                <img id="modalImage" src="" alt="Details Image" class="w-full h-auto rounded-lg">
                            </div>
                        </div>
                        <td class="py-2 px-4 border-b">
                            <span class="<?= $swap['status'] == 'Pending' ? 'bg-orange-200 text-orange-800' : 'bg-green-200 text-green-800' ?> py-1 px-3 rounded-full text-xs">
                                <?= ucfirst($swap['status']) ?>
                            </span>

                        </td>
                        <td class="py-2 px-4 border-b"><?= $swap['poin'] ?></td>
                        <td class="py-2 px-4 border-b text-center">
                        <a href="update_poin.php?id_order= <?= urlencode($swap['id_order']) ?> ">
                            <button class="text-blue-500 hover:text-blue-700 focus:outline-none">
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
            <div class="bg-white p-6 rounded-lg shadow-lg w-96" id="detailsModalContent" data-id="">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-purple-600">Details</h3>
                    <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="update_status.php" method="POST" id="updateForm" class="p-8 bg-purple-50 rounded-xl shadow-lg w-full mx-auto mt-4">
                    <h2 class="text-2xl text-center text-purple-600 font-semibold mb-6">Edit Status Produk</h2>
                    
                    <!-- Content Details -->
                    <div id="detailsContent" class="mb-4">
                        <!-- Data Order akan ditampilkan disini -->
                    </div>

                    <!-- Input Poin -->
                    <div class="mt-4">
                        <label for="poin" class="block text-gray-700">Tambah Poin:</label>
                        <input type="number" name="poin" id="poin" class="border rounded-lg py-2 px-4 mt-1 w-full focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Masukkan jumlah poin" required>
                    </div>

                    <!-- Dropdown Status -->
                    <div class="mt-4">
                        <label for="statusSelect" class="block text-gray-700">Status:</label>
                        <select name="status" id="statusSelect" class="border rounded-lg py-2 px-4 mt-1 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="pending" class="status pending bg-orange-100">Pending</option>
                            <option value="completed" class="status completed bg-green-100">Completed</option>
                        </select>
                    </div>

                    <!-- Hidden Order ID -->
                    <input type="hidden" name="id_order" id="orderId">

                    <!-- Button Actions -->
                    <div class="mt-6 flex justify-between">
                        <button type="submit" name="submit" class="bg-purple-500 text-white py-2 px-6 rounded-lg shadow hover:bg-purple-400 transition-all duration-200">UPDATE</button>
                        <button type="button" onclick="closeDetails()" class="bg-gray-500 text-white py-2 px-6 rounded-lg shadow hover:bg-gray-400 transition-all duration-200">CANCEL</button>
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
        modal.style.display = "flex"; // Menampilkan modal
        modalImg.src = '../images/' + imageSrc; // Mengubah sumber gambar menjadi gambar besar
    }

    document.querySelector(".close").onclick = function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none"; // Menutup modal saat tombol close diklik
    }

    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none"; // Menutup modal jika area luar modal diklik
        }
    }
    function goBack() {
        window.history.back(); // Navigasi kembali ke halaman sebelumnya
    }
</script>

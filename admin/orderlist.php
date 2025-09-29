<?php
include "template/header_admin.php"
?>
<style>
    footer {
        background-color: #f8f9fa; /* Warna latar belakang footer */
        padding: 20px;
        text-align: left;
        border-top: 1px solid #ddd;
        clear: both;
    }
</style>
<!-- Main Content -->
<div class="flex flex-col min-h-screen">
    <div class="flex-1 p-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-xl font-semibold mb-4">Pembelian Terbaru</h3>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Produk</th>
                        <th class="py-2 px-4 border-b">ID Pesanan</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Nama Pelanggan</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b">Pink Blouse</td>
                        <td class="py-2 px-4 border-b">#25426</td>
                        <td class="py-2 px-4 border-b">8 Nov 2024</td>
                        <td class="py-2 px-4 border-b">Amanda</td>
                        <td class="py-2 px-4 border-b">
                            <select class="status bg-white py-1 px-3 rounded-full text-xs" id="status-25426">
                                <option value="completed">Selesai</option>
                                <option value="in-progress">Sedang Diproses</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">Rp 250.000</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Coquette Dress</td>
                        <td class="py-2 px-4 border-b">#25423</td>
                        <td class="py-2 px-4 border-b">5 Nov 2024</td>
                        <td class="py-2 px-4 border-b">Rina</td>
                        <td class="py-2 px-4 border-b">
                            <select class="status bg-white py-1 px-3 rounded-full text-xs" id="status-25423">
                                <option value="completed">Selesai</option>
                                <option value="in-progress">Sedang Diproses</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">Rp 150.000</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Jeans Skirt</td>
                        <td class="py-2 px-4 border-b">#25440</td>
                        <td class="py-2 px-4 border-b">5 Nov 2024</td>
                        <td class="py-2 px-4 border-b">Budi</td>
                        <td class="py-2 px-4 border-b">
                            <select class="status bg-white py-1 px-3 rounded-full text-xs" id="status-25440">
                                <option value="completed">Selesai</option>
                                <option value="in-progress">Sedang Diproses</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">Rp 250.000</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b">Blue Jeans</td>
                        <td class="py-2 px-4 border-b">#25441</td>
                        <td class="py-2 px-4 border-b">6 Nov 2024</td>
                        <td class="py-2 px-4 border-b">Amel</td>
                        <td class="py-2 px-4 border-b">
                            <select class="status bg-white py-1 px-3 rounded-full text-xs" id="status-25441">
                                <option value="completed">Selesai</option>
                                <option value="in-progress">Sedang Diproses</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">Rp 300.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengubah warna dropdown sesuai status yang dipilih
    function updateColor(select) {
        // Hapus semua kelas warna sebelumnya
        select.classList.remove('bg-green-100', 'bg-yellow-100', 'bg-red-100', 'bg-white');

        // Tambahkan warna sesuai status yang dipilih
        switch (select.value) {
            case 'completed':
                select.classList.add('bg-green-100'); // Warna hijau untuk "Selesai"
                break;
            case 'in-progress':
                select.classList.add('bg-yellow-100'); // Warna kuning untuk "Sedang Diproses"
                break;
            case 'cancelled':
                select.classList.add('bg-red-100'); // Warna merah untuk "Dibatalkan"
                break;
            default:
                select.classList.add('bg-white');
        }
    }

    // Fungsi untuk menetapkan status secara otomatis
    function assignRandomStatus(selectElements) {
        const statuses = ['completed', 'in-progress', 'cancelled'];
        let currentIndex = 0;

        selectElements.forEach((select, index) => {
            // Cek jika ada status yang disimpan di localStorage
            const savedStatus = localStorage.getItem(select.id);
            if (savedStatus) {
                select.value = savedStatus; // Set value sesuai yang disimpan
            } else {
                // Tetapkan status secara siklis dari daftar statuses
                select.value = statuses[currentIndex];
                currentIndex = (currentIndex + 1) % statuses.length; // Perulangan status
                localStorage.setItem(select.id, select.value); // Simpan status yang dipilih
            }
            
            updateColor(select); // Update warna dropdown

            // Set event listener untuk perubahan status
            select.addEventListener('change', function () {
                localStorage.setItem(select.id, select.value); // Simpan status yang dipilih
                updateColor(select); // Update warna
            });
        });
    }

    // Pilih semua elemen dropdown status
    const statusDropdowns = document.querySelectorAll('.status');

    // Panggil fungsi untuk menetapkan status
    assignRandomStatus(statusDropdowns);
</script>


</body>
<?php
include "template/footer_admin.php"
?>
</html>

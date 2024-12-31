<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$user_id = $_SESSION['user_id'];

?>

    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 10px;
            padding-right: 15px;
        }
    </style>
<main>
    <body class="bg-gray-50">
        <div class="container">
            <div class="bg-white p-4 rounded-lg shadow justify-content-center">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-pink-600">Riwayat Tukar Poin Anda!</h2>
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
                            
                <!-- Table Riwayat -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="w-full table-auto text-left text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="py-3 px-4 text-gray-600">ID</th>
                                <th class="py-3 px-4 text-gray-600">Nama Produk</th>
                                <th class="py-3 px-4 text-gray-600">Poin yang digunakan</th>
                                <th class="py-3 px-4 text-gray-600">Tanggal Penukaran</th>
                                <th class="py-3 px-4 text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">#128501</td>
                                <td class="py-2 px-4">Lorem Ipsum</td>
                                <td class="py-2 px-4">250</td>
                                <td class="py-2 px-4">Nov 6th, 2024</td>
                                <td class="py-2 px-4">
                                    <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i> Sukses
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4">#128502</td>
                                <td class="py-2 px-4">Lorem Ipsum</td>
                                <td class="py-2 px-4">50</td>
                                <td class="py-2 px-4">Nov 6th, 2024</td>
                                <td class="py-2 px-4">
                                    <span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                        <i class="fas fa-spinner mr-1"></i> Tertunda
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4">#128501</td>
                                <td class="py-2 px-4">Lorem Ipsum</td>
                                <td class="py-2 px-4">50</td>
                                <td class="py-2 px-4">Nov 6th, 2024</td>
                                <td class="py-2 px-4">
                                    <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                        <i class="fas fa-spinner mr-1"></i> Dibatalkan
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

</main>

<?php
include "template/footer_user.php";
?>
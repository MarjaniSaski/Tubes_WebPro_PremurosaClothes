riwayat_tukarpakaian.php

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$user_id = $_SESSION['user_id'];

// Ambil nama lengkap pengguna dari tabel pengguna
$sqlUser = "SELECT CONCAT(first_name, ' ', last_name) AS nama_lengkap FROM user WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();
$namaLengkap = $userData['nama_lengkap'];

// Ambil data orders yang sesuai dengan nama lengkap pengguna
$sqlStatement = "SELECT * FROM orders WHERE nama_lengkap = ?";
$stmtOrder = $conn->prepare($sqlStatement);
$stmtOrder->bind_param("s", $namaLengkap);
$stmtOrder->execute();
$query = $stmtOrder->get_result();
$data = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-pink-600"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Tukar Pakaian</h2>
                <button onclick="history.back()" class="text-sm font-medium hover:underline focus:outline-none">
                    Kembali
                </button>
            </div>
            <div class="border-b-2 border-gray-200 mb-6"></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-pink-100">
                        <tr>
                            <th class="py-3 px-4 text-pink-600">ID</th>
                            <th class="py-3 px-4 text-pink-600">Foto Produk</th>
                            <th class="py-3 px-4 text-pink-600">Jenis Barang</th>
                            <th class="py-3 px-4 text-pink-600">Jenis Bahan</th>
                            <th class="py-3 px-4 text-pink-600">Tanggal Penjemputan</th>
                            <th class="py-3 px-4 text-pink-600">Status</th>
                            <th class="py-3 px-4 text-pink-600">Poin yang didapat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $swap): ?>
                            <tr data-id="<?= $swap['id_order'] ?>">
                                <td class="py-2 px-4 border-b text-center"><?= $swap['id_order'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button onclick="showDetails('<?= $swap['foto'] ?>')" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                        <img src="../images/<?= $swap['foto'] ?>" alt="Foto Detail" class="w-16 h-16 object-cover mx-auto rounded-md">
                                    </button>
                                </td>
                                <td class="py-2 px-4 border-b text-center"><?= $swap['jenis_barang'] ?></td>
                                <td class="py-2 px-4 border-b text-center"><?= $swap['jenis_bahan'] ?></td>
                                <td class="py-2 px-4 border-b text-center"><?= $swap['tanggal_penjemputan'] ?></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <span class="<?= $swap['status'] == 'Pending' ? 'text-orange-600 bg-orange-100' : 'text-green-600 bg-green-100' ?> py-1 px-3 rounded-full text-xs flex items-center justify-center gap-1">
                                        <?php if ($swap['status'] == 'Pending'): ?>
                                            <i class="fas fa-spinner mr-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-check-circle mr-1"></i>
                                        <?php endif; ?>
                                        <?= ucfirst($swap['status']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b text-center"><?= $swap['poin'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>

<?php include "template/footer_user.php"; ?>
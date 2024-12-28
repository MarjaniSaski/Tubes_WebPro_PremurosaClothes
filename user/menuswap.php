<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$user_id = $_SESSION['user_id'];

$resultDataSQL = $conn->prepare("SELECT first_name, last_name FROM user WHERE id = ?");
$resultDataSQL->bind_param("i", $user_id);
$resultDataSQL->execute();
$resultData = $resultDataSQL->get_result();

if ($resultData && $resultData->num_rows > 0) {
    $row = $resultData->fetch_assoc();
    $fullname = $row['first_name'] . ' ' . $row['last_name'];
} else {
    $fullname = "Nama Tidak Ditemukan";
}

$resultDataSQL->close();

$getPoin = $conn->prepare("SELECT COUNT(*) FROM `orders` WHERE nama_lengkap = ?");
$getPoin->bind_param("s", $fullname);
$getPoin->execute();
$result = $getPoin->get_result();
$resultPoin = $result->fetch_row()[0] ?? 0;
$getPoin->close();

$getPoinTukar = $conn->prepare("SELECT SUM(poin) FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $fullname);
$getPoinTukar->execute();
$result = $getPoinTukar->get_result();
$resultPoinTukar = $result->fetch_row()[0] ?? 0;
$getPoinTukar->close();

// Mendapatkan total poin yang digunakan dari tabel shipping_data
$getPointUsed = $conn->prepare("SELECT SUM(points_used) FROM `shipping_data` WHERE user_id = ?");
$getPointUsed->bind_param("i", $user_id);
$getPointUsed->execute();
$result = $getPointUsed->get_result();
$resultPointUsed = $result->fetch_row()[0] ?? 0;
$getPointUsed->close();

// Menghitung total poin yang tersisa setelah dikurangi poin yang digunakan
$totalPoinTersisa = $resultPoinTukar - $resultPointUsed;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tukar_pakaian'])) {
    updateJumlahPenukaran($user_id, $conn);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['poin'])) {
    updateJumlahPenukaran($user_id, $conn, $resultPoinTukar);
}

$conn->close();
?>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 10px;
        padding-right: 15px;
    }

    .card {
        margin: 15px 0;
    }

    .btn-pink {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
        transition: transform 0.2s, background-color 0.2s;
    }

    .btn-pink:hover {
        background-color: #ff1493;
        border-color: #ff1493;
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #popupOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #popupContent {
        background-color: #ff1493;
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        font-weight: 600;
    }

    #selectedWeight {
        font-weight: bold;
        margin-top: 10px;
        color: #ff1493;
    }
</style>

<body class="bg-gray-50">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Kolom Jumlah Poin -->
            <div class="col-md-5 col-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <img src="<?= HOST ?>/foto/jml.poin.png" alt="Gambar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title text-3xl font-bold"><?= $totalPoinTersisa ?></h3>
                        <p class="text-gray-600">JUMLAH POIN</p>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300" onclick="window.location.href='tukarpoin.php';">
                                <i class="fas fa-arrow-right mr-2"></i> Tukar Poin
                            </button>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300">
                                <i class="fas fa-history mr-2"></i> Riwayat Poin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Jumlah Penukaran -->
            <div class="col-md-5 col-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <img src="<?= HOST ?>/foto/jml.baju.png" alt="Gambar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title text-3xl font-bold"><?= $resultPoin ?></h3>
                        <p class="text-gray-600">JUMLAH PENUKARAN</p>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300" onclick="window.location.href='tukarpakaian.php';">
                                <i class="fas fa-arrow-right mr-2"></i> Tukar Pakaian
                            </button>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300">
                                <i class="fas fa-history mr-2"></i> Riwayat Penukaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Syarat dan Ketentuan -->
        <div>
            <br>
            <h2 style="font-size: 25px; color: #D5006D; font-weight: bold;">
                <i class="bi bi-stars text-pink-500 mr-3"></i>Syarat dan Ketentuan
            </h2>
            <br>
            <p>Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran!</p>
            <ol class="list-decimal text-m list-inside mt-2">
                <li>Pastikan produk yang ditukarkan dalam kondisi sudah dicuci.</li>
                <li>Pastikan produk yang ditukarkan tidak bernjamur dan masih layak pakai.</li>
                <li>Pakaian yang kotor atau rusak tidak dapat ditukar.</li>
                <li>Bawalah pakaian yang ingin ditukar dan bukti persetujuan ke toko.</li>
                <li>Staf Premurosa akan memeriksa kondisi pakaian dan menyetujui atau menolak penukaran.</li>
                <li>Jika penukaran disetujui, Anda dapat memiliki poin yang sudah ditetapkan.</li>
                <li>Admin berhak membatalkan penukaran pakaian jika ditemukan indikasi kecurangan atau pelanggaran.</li>
                <li>Admin tidak bertanggung jawab atas kerugian yang timbul akibat kesalahan dalam proses penukaran pakaian.</li>
            </ol>
            <br>
            <p>Dengan melakukan penukaran ini, Anda dianggap telah menyetujui semua syarat dan ketentuan yang berlaku.</p>
        </div>
    </div>
</body>

<?php
include "template/footer_user.php";
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$sqlPoin = "SELECT poin FROM `user` WHERE id = ?";
$stmt = $conn->prepare($sqlPoin);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultPoin = $stmt->get_result();
$rowPoin = $resultPoin->fetch_assoc();
$poin = $rowPoin ? $rowPoin['poin'] : 0;

$sqlPenukaran = "SELECT COUNT(*) AS jumlah_penukaran FROM `orders` WHERE id_order = ?";
$stmt = $conn->prepare($sqlPenukaran);
$stmt->bind_param("i", $id_order);
$stmt->execute();
$resultPenukaran = $stmt->get_result();
$rowPenukaran = $resultPenukaran->fetch_assoc();
$jumlah_penukaran = $rowPenukaran ? $rowPenukaran['jumlah_penukaran'] : 0;

$stmt->close();
?>

<style>
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

    /* Styling for the Terms and Conditions container */
    .terms-container {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
        height: auto;
    }

    .terms-container h2 {
        color: #ff1493;
        font-size: 24px;
        font-weight: bold;
    }

    .terms-container p,
    .terms-container ol {
        color: #333;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Card Styling */
    .card-terms {
        width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .card-body-terms {
        padding: 20px;
        text-align: left;
    }

    .card-body-terms ol {
        margin-left: 20px;
    }
</style>

<div class="container-fluid bg-pink-200 py-3">
    <div class="container">
        <h1 class="text-left text-2xl font-semibold text-black">
            <i class="bi bi-gem"></i> My Poin
        </h1>
    </div>
</div>

<main class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Kolom Jumlah Poin -->
            <div class="col-md-5 col-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <img src="<?= HOST ?>/foto/jml.poin.png" alt="Gambar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title text-3xl font-bold"><?= $poin ?></h3>
                        <p class="text-gray-600">JUMLAH POIN</p>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300" onclick="window.location.href='menutukar.php';">
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
                        <h3 class="card-title text-3xl font-bold"><?= $jumlah_penukaran ?></h3>
                        <p class="text-gray-600">JUMLAH PENUKARAN</p>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300" onclick="window.location.href='menutukarpakaian.php';">
                                <i class="fas fa-arrow-right mr-2"></i> Tukar Poin
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
    </div>

    <div class="newarrivallogo bg-pink-200 p-3 flex items-center gap-3">
            <h2 class="text-xl font-bold pl-4">
                <i class="bi bi-stars text-pink-500 mr-3"></i>Syarat dan Ketentuan
            </h2>
        </div>

    <!-- Syarat dan Ketentuan Container -->
    <div class="card card-terms">
        <div class="card-body card-body-terms">
        <h2 style="font-size: 25px; color: #D5006D; font-weight: bold;">Syarat dan Ketentuan Penukaran Pakaian</h2>
        <br>
        <p>Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran Poin:</p>
            <ol class="list-decimal">
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
</main>
</body>
<?php
include "template/footer_user.php"
?>
</html>

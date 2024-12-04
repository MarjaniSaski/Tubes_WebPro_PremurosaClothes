<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/PREMUROSA2/config.php';
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
        /* Adjust button hover to a darker pink */
        .btn-hover-dark:hover {
            background-color: #e91e63;
            border-color: #e91e63;
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
<div class="container-fluid bg-pink-200 py-3">
      <div class="container">
        <h1 class="text-left text-2xl font-semibold text-black">
          <i class="bi bi-gem"></i> My Poin
        </h1>
      </div>
  </div>

  <main class="mt-5 ">
  <div class="container">
        <div class="row justify-content-center">
            <!-- Kolom Jumlah Poin -->
            <div class="col-md-4 col-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <img src="<?= HOST ?>/foto/tukarpoin.png" alt="Gambar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title text-3xl font-bold">350</h3>
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
            <div class="col-md-4 col-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <img src="<?= HOST ?>/foto/jumlahpenukaran.png" alt="Gambar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title text-3xl font-bold">5</h3>
                        <p class="text-gray-600">JUMLAH PENUKARAN</p>
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn bg-pink-500 hover:bg-pink-700 text-white font-medium py-3 px-5 w-full rounded-lg shadow-md transition duration-300" onclick="window.location.href='menutukarpakaian.php';">
                                <i class="fas fa-tshirt mr-2"></i> Tukar Pakaian
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


      <div class="mt-8 text-left">
        <h2 class="text-lg font-bold ml-3">Syarat dan Ketentuan Penukaran Pakaian</h2>
        <p class="ml-3">
            Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran Poin:
        </p>
        <ol class="list-decimal ml-10">
            <li>Pastikan produk yang ditukarkan dalam kondisi sudah dicuci.</li>
            <li>Pastikan produk yang ditukarkan tidak bernjamur dan masih layak pakai.</li>
            <li>Pakaian yang kotor atau rusak tidak dapat ditukar.</li>
            <li>Bawalah pakaian yang ingin ditukar dan bukti persetujuan ke toko.</li>
            <li>Staf Premurosa akan memeriksa kondisi pakaian dan menyetujui atau menolak penukaran.</li>
            <li>Jika penukaran disetujui, Anda dapat memiliki poin yang sudah ditetapkan.</li>
            <li>Admin berhak membatalkan penukaran pakaian jika ditemukan indikasi kecurangan atau pelanggaran.</li>
            <li>Admin tidak bertanggung jawab atas kerugian yang timbul akibat kesalahan dalam proses penukaran pakaian.</li>
        </ol>
        <p class="mt-4">
            Dengan melakukan penukaran ini, Anda dianggap telah menyetujui semua syarat dan ketentuan yang berlaku.
        </p>
    </div>

  </main>
</body>
</html>

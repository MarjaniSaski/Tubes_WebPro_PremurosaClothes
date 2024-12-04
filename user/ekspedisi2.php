<?php
include "template/header_user.php"
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
    </style>
<div class="container my-5">
        <!-- Pemilihan Pengiriman -->
        <div id="shippingOptions" class="border p-4 bg-white rounded shadow-sm">
            <h2 class="fw-bold">Atur Penjemputan</h2> <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="namaLengkap" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                        <input type="text" id="alamatLengkap" class="form-control" placeholder="Alamat Lengkap">
                    </div>
                    <div class="mb-3">
                        <label for="provinsi" class="form-label">Provinsi, Kab/Kota, Kecamatan, Kode Pos</label>
                        <input type="text" id="provinsi" class="form-control" placeholder="Provinsi, Kab/Kota, Kecamatan, Kode Pos">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggalPenjemputan" class="form-label">Tambahkan Tanggal Penjemputan</label>
                        <input type="date" id="tanggalPenjemputan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="beratBarang" class="form-label">Pilih Berat</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-pink" data-weight="1 Kg">1 Kg</button>
                            <button class="btn btn-pink" data-weight="3 Kg">3 Kg</button>
                            <button class="btn btn-pink" data-weight="5 Kg">5 Kg</button>                                                     
                        </div>
                    </div>
                        <div id="selectedWeight"></div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="fw-bold">Ekspedisi</h3>
                <br>
                <div class="d-flex justify-content-between align-items-center border rounded p-3">
                    <label><input type="radio" name="ekspedisi" value="JNE"> <img src="<?= HOST ?>/foto/jne.png" alt="JNE" style="height: 120px;"></label>
                    <label><input type="radio" name="ekspedisi" value="J&T"> <img src="<?= HOST ?>/foto/jnt.png" alt="J&T" style="height: 120px;"></label>
                    <label><input type="radio" name="ekspedisi" value="SiCepat"> <img src="<?= HOST ?>/foto/sicepat.png" alt="SiCepat" style="height: 120px;"></label>
                    <label><input type="radio" name="ekspedisi" value="Wahana"> <img src="<?= HOST ?>/foto/wahana.png" alt="Wahana" style="height: 120px;"></label>
                </div>
                <div class="text-end mt-4">
                    <button type="button" id="confirmButton" class=" btn bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
                      Atur Pengiriman
                    </button>
                </div>
            </div>
        </div>
    </div>

     <!-- Pop-up Overlay -->
     <div id="popupOverlay">
        <div id="popupContent">
            <p id="popupMessage"></p>
            <button id="popupOkButton"  class="btn btn-light mt-3">OK</button>
        </div>
    </div>

    <script>
        // Elemen DOM
        const weightButtons = document.querySelectorAll('.btn-pink');
        const selectedWeightDiv = document.getElementById('selectedWeight');
        const confirmButton = document.getElementById('confirmButton');
        const popupOverlay = document.getElementById('popupOverlay');
        const popupMessage = document.getElementById('popupMessage');
        const popupOkButton = document.getElementById('popupOkButton');

        let selectedWeight = "";

        // Event listener untuk tombol berat
        weightButtons.forEach(button => {
            button.addEventListener('click', () => {
                selectedWeight = button.getAttribute('data-weight');
                selectedWeightDiv.textContent = `Anda memilih berat: ${selectedWeight}`;
            });
        });

        // Event listener untuk tombol konfirmasi
        confirmButton.addEventListener('click', () => {
            if (selectedWeight) {
                const nama = document.getElementById('namaLengkap').value.trim();
                if (!nama) {
                    alert("Silakan isi nama lengkap terlebih dahulu.");
                    return;
                }
                popupMessage.textContent = `Halo, ${nama}! Kami akan mengatur pengiriman Anda.`;
                popupOverlay.style.display = 'flex';
            } else {
                alert("Silakan data terlebih dahulu.");
            }
        });

        // Event listener untuk tombol OK di pop-up
        popupOkButton.addEventListener('click', () => {
            popupOverlay.style.display = 'none';
            window.location.href = 'indexuser.php';
        });
    </script>


    <!-- Tambahkan script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

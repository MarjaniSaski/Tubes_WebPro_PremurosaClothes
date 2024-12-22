<?php
include "template/header_user.php"
?>

<style>
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

/* Pop-up Content Style */
#popupContent {
  background-color: #ff1493; /* Pink background */
  color: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  font-weight: 600;
}

/* Styling for the OK Button */
#popupOkButton {
  background-color: #ffffff;
  color: #ff1493;
  font-weight: bold;
  border: none;
  padding: 8px 16px;
  cursor: pointer;
  border-radius: 5px;
}

#popupOkButton:hover {
  background-color: #f0f0f0;
}
</style>

<!-- Atur Pengiriman Section -->
<div class="container mt-5">
    <div class="bg-white p-5 rounded shadow">
      <h3 class="mb-4 text-gray-800 font-semibold">Atur Pengiriman</h3>
      <form id="shipping-form">
        <div class="mb-3">
          <label for="name" class="form-label text-gray-700">Nama Lengkap</label>
          <input type="text" id="name" class="form-control border-gray-300" placeholder="Nama Lengkap">
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label text-gray-700">Nomor Telepon</label>
          <input type="text" id="phone" class="form-control border-gray-300" placeholder="Nomor Telepon">
        </div>
        <div class="mb-3">
          <label for="address" class="form-label text-gray-700">Alamat Lengkap</label>
          <input type="text" id="address" class="form-control border-gray-300" placeholder="Alamat Lengkap">
        </div>
        <div class="mb-3">
          <label for="province" class="form-label text-gray-700">Provinsi, Kab/Kota, Kecamatan, Kode Pos</label>
          <input type="text" id="province" class="form-control border-gray-300" placeholder="Provinsi, Kab/Kota, Kecamatan, Kode Pos">
        </div>
        <div class="text-end">
          <button type="button" id="save-btn" class="bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
            Simpan
          </button>
        </div>
      </form>
      <div id="saved-data" class="mt-4"></div>
    </div>

    <!-- Ekspedisi Section -->
    <div class="bg-white p-5 rounded shadow mt-4">
      <h3 class="mb-4 text-gray-800 font-semibold text-center">Ekspedisi</h3>
      <div class="row text-center">
        <div class="col-md-3">
          <input type="radio" name="expedition" id="jne" class="form-check-input">
          <label for="jne"><img src="<?= HOST ?>/foto/jne.png" alt="JNE" class="img-fluid"></label>
        </div>
        <div class="col-md-3">
          <input type="radio" name="expedition" id="jnt" class="form-check-input">
          <label for="jnt"><img src="<?= HOST ?>/foto/jnt.png" alt="J&T" class="img-fluid"></label>
        </div>
        <div class="col-md-3">
          <input type="radio" name="expedition" id="sicepat" class="form-check-input">
          <label for="sicepat"><img src="<?= HOST ?>/foto/sicepat.png" alt="SiCepat" class="img-fluid"></label>
        </div>
        <div class="col-md-3">
          <input type="radio" name="expedition" id="wahana" class="form-check-input">
          <label for="wahana"><img src="<?= HOST ?>/foto/wahana.png" alt="Wahana" class="img-fluid"></label>
        </div>
      </div>
      <div class="text-end mt-4">
        <button type="button" id="check-btn" class="bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">
          Atur Pengiriman
        </button>
      </div>
    </div>
  </div>

  <div id="popupOverlay">
    <div id="popupContent">
        <p id="popupMessage"></p>
        <button id="popupOkButton" class="btn btn-light mt-3">OK</button>
    </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('check-btn').addEventListener('click', function () {
        const name = document.getElementById('name').value;

        // Mengecek apakah nama sudah terisi
        if (name) {
            const popupMessage = `Hi, ${name}! Kami akan mengatur pengiriman Anda!`;
            document.getElementById('popupMessage').textContent = popupMessage;
      
            document.getElementById('popupOverlay').style.display = 'flex';
        } else {
            alert("Silakan lengkapi semua data pengiriman terlebih dahulu.");
        }
    });

    document.getElementById('popupOkButton').addEventListener('click', function() {
        document.getElementById('popupOverlay').style.display = 'none';
    });

    // Fungsi untuk menyimpan dan menampilkan data
    document.getElementById('save-btn').addEventListener('click', function () {
        // Ambil data dari form
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const province = document.getElementById('province').value;

        // Tampilkan data di bawah form
        const savedDataDiv = document.getElementById('saved-data');
        savedDataDiv.innerHTML = ` 
            <h4>Data Pengiriman yang Disimpan:</h4>
            <p><strong>Nama:</strong> ${name}</p>
            <p><strong>Nomor Telepon:</strong> ${phone}</p>
            <p><strong>Alamat:</strong> ${address}</p>
            <p><strong>Provinsi/Kota/Kecamatan:</strong> ${province}</p>
        `;
    });

document.getElementById('popupOkButton').addEventListener('click', function() {
    // Hide the pop-up after clicking OK
    document.getElementById('popupOverlay').style.display = 'none';
 
    window.location.href = 'home2.php';
});

</script>

</body>
<?php
include "template/footer_user.php"
?>

</html>


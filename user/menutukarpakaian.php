<?php
include "template/header_user.php"

?>
<main class="container my-5">
        <div class="row align-items-start">
            <div class="col-md-6">
                <div class="border rounded shadow-sm p-4 bg-light d-flex flex-column align-items-center">
                    <h2 class="text-center text-pink-500 fw-bold mb-3">Upload here!</h2>
                    
                    <!-- File Input Section -->
                    <div class="d-flex justify-content-center">
                        <label for="fileInput" class="cursor-pointer text-pink-600 font-semibold">
                            Choose File
                        </label>
                        <input type="file" id="fileInput" class="d-none" accept="image/*">
                    </div>
                    <div id="preview" class="mt-4 text-center"></div>
                </div>
            </div>

            <div class="col-md-6">
                <form id="exchangeForm">
                    <div class="mb-3">
                        <label for="jenisBarang" class="form-label">Jenis Barang</label>
                        <select class="form-select" id="jenisBarang" required>
                            <option value="" selected disabled>Pilih jenis barang...</option>
                            <option value="top">Top</option>
                            <option value="bottom">Bottom</option>
                            <option value="dress">Dress</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenisBahan" class="form-label">Jenis Bahan</label>
                        <input type="text" class="form-control" id="jenisBahan" placeholder="Masukkan jenis bahan" required>
                    </div>                    
                    <div class="mb-3">
                        <label for="details" class="form-label">Details</label>
                        <textarea class="form-control" id="details" rows="3" placeholder="Masukkan detail pakaian yang ingin ditukarkan." required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <!-- Back Button -->
                        <button type="button" class="btn bg-pink-400 text-white font-semibold hover:bg-pink-600 border-0" onclick="window.location.href='menuswap.php';">Back</button>
                        
                        <!-- Submit Button -->
                        <button type="button" id="submitBtn" class="btn bg-pink-400 text-white font-semibold hover:bg-pink-600 border-0 ms-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-8">
            <h2 class="text-xl font-bold">Syarat dan Ketentuan Penukaran Pakaian</h2>
            <p class="mt-4">
                Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran Poin:
            </p>
            <ol class="list-decimal list-inside mt-2">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('preview');
        
        fileInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.width = '200px';
                    img.style.height = '200px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.marginTop = '15px';

                    previewContainer.innerHTML = '';  // Clear previous preview
                    previewContainer.appendChild(img);  // Show new image
                };

                reader.readAsDataURL(file);
            }
        });

        // Form Validation and Redirection on Submit
        document.getElementById('submitBtn').addEventListener('click', function (event) {
            const jenisBarang = document.getElementById('jenisBarang').value;
            const jenisBahan = document.getElementById('jenisBahan').value;
            const details = document.getElementById('details').value;

            // Check if all fields are filled
            if (!jenisBarang || !jenisBahan || !details) {
                event.preventDefault(); // Prevent form submission if validation fails
                alert("Mohon lengkapi data terlebih dahulu!"); // Show an alert if data is incomplete
            } else {
                // If the form is valid, redirect to 'ekspedisi2.html'
                window.location.href = 'ekspedisi2.php';
            }
        });
    </script>
</body>
</html>

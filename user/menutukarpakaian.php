<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$uploadedImage = "";
$response = [];

// Process exchange if form submitted
if (isset($_POST['btntukar'])) {
    try {
        $foto = $_FILES['foto'];
        $jenis_barang = $_POST['jenis_barang'];
        $jenis_bahan = $_POST['jenis_bahan'];
        $details = $_POST['details'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        $alamat = $_POST['alamat'];
        $tanggal_penjemputan = $_POST['tanggal_penjemputan'];
        $berat_kg = $_POST['berat_kg'];

        // Validate required fields
        if (empty($jenis_barang)) {
            throw new Exception("Jenis barang harus dipilih!");
        }

        // Handle photo upload
        if (!empty($foto['name'])) {
            $photoName = time() . '_' . basename($foto['name']);
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $photoName;
            
            if (!move_uploaded_file($foto['tmp_name'], $uploadPath)) {
                throw new Exception("Gagal mengupload foto.");
            }
            $uploadedImage = '/Tubes_WebPro_PremurosaClothes/images/' . $photoName;
        } else {
            throw new Exception("Foto harus diupload!");
        }

        // Insert data into database
        $sqlStatement = "INSERT INTO orders (foto, jenis_barang, jenis_bahan, details, nama_lengkap, alamat_lengkap, alamat, tanggal_penjemputan, berat_kg) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlStatement);
        
        if (!$stmt) {
            throw new Exception("Gagal mempersiapkan statement: " . $conn->error);
        }

        $stmt->bind_param("ssssssssi", $photoName, $jenis_barang, $jenis_bahan, $details, $nama_lengkap, $alamat_lengkap, $alamat, $tanggal_penjemputan, $berat_kg);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal menyimpan data: " . $stmt->error);
        }

        $response = [
            'status' => 'success',
            'message' => 'Data berhasil disimpan!'
        ];

        $stmt->close();

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    // Return JSON response for AJAX requests
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .btn-white {
            background-color: white;
            border-color: rgb(186, 186, 186);
            color: black;
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-white:hover {
            background-color: #fa7fcf;
            border-color: #FFABE1;
            transform: scale(1.1);
        }

        .btn-white.active {
            background-color: #fa7fcf;
            color: white;
        }

        #preview img {
            max-width: 200px;
            height: auto;
            margin-top: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container my-5">
        <div class="bg-white p-4 rounded shadow mx-4 my-5">
            <form id="exchangeForm" method="POST" enctype="multipart/form-data">
                <div class="row align-items-start">
                    <div class="col-md-6">
                        <div class="border rounded shadow-sm p-4 bg-light d-flex flex-column align-items-center">
                            <h1 class="text-center text-pink-500 font-bold mb-3 text-3xl">Upload here!</h1>
                            <div class="d-flex justify-content-center">
                                <label for="fileInput" class="cursor-pointer text-pink-600 font-semibold">Choose File</label>
                                <input type="file" id="fileInput" class="d-none" accept="image/*" name="foto" required>
                            </div>
                            <div id="preview" class="mt-4 text-center">
                                <?php if (!empty($uploadedImage)): ?>
                                    <img src="<?php echo $uploadedImage; ?>" alt="Uploaded Image">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenisBarang" class="form-label">Jenis Barang</label>
                            <select class="form-select" id="jenisBarang" name="jenis_barang" required>
                                <option value="" selected disabled>Pilih jenis barang...</option>
                                <option value="top">Top</option>
                                <option value="bottom">Bottom</option>
                                <option value="dress">Dress</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenisBahan" class="form-label">Jenis Bahan</label>
                            <input type="text" class="form-control" id="jenisBahan" name="jenis_bahan" placeholder="Masukkan jenis bahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" rows="3" name="details" placeholder="Masukkan detail pakaian yang ingin ditukarkan." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                            <input type="text" id="alamatLengkap" name="alamat_lengkap" class="form-control" placeholder="Alamat Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="provinsi" class="form-label">Provinsi, Kab/Kota, Kecamatan, Kode Pos</label>
                            <input type="text" id="provinsi" class="form-control" name="alamat" placeholder="Provinsi, Kab/Kota, Kecamatan, Kode Pos" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggalPenjemputan" class="form-label">Tambahkan Tanggal Penjemputan</label>
                            <input type="date" id="tanggalPenjemputan" name="tanggal_penjemputan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="beratBarang" class="form-label">Pilih Berat</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-white weight-btn" data-weight="1">1 Kg</button>
                                <button type="button" class="btn btn-white weight-btn" data-weight="3">3 Kg</button>
                                <button type="button" class="btn btn-white weight-btn" data-weight="5">5 Kg</button>
                            </div>
                            <input type="hidden" id="selectedWeight" name="berat_kg" value="" required>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn bg-gray-400 text-white font-semibold hover:bg-gray-600 border-0 me-3" onclick="window.location.href='menuswap.html';">Back</button>
                            <button type="submit" name="btntukar" class="btn bg-pink-400 hover:bg-pink-600 text-white">Atur Penjemputan</button>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <h2 class="text-2xl font-bold">Syarat dan Ketentuan Penukaran Pakaian</h2>
                    <p class="mt-2 text-m">Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran Poin:</p>
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
                    <p class="text-m">Dengan melakukan penukaran ini, Anda dianggap telah menyetujui semua syarat dan ketentuan yang berlaku.</p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fileInput = document.getElementById("fileInput");
            const previewContainer = document.getElementById("preview");
            const form = document.getElementById("exchangeForm");
            const weightButtons = document.querySelectorAll(".weight-btn");
            const weightInput = document.getElementById("selectedWeight");

            // Image preview handler
            fileInput.addEventListener("change", function () {
                const file = fileInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Selected Image">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.innerHTML = "";
                }
            });

            // Weight button handler
            weightButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    weightButtons.forEach((btn) => btn.classList.remove("active"));
                    this.classList.add("active");
                    weightInput.value = this.getAttribute("data-weight");
                });
            });

            // Form submission handler
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Validate weight selection
                if (!weightInput.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Silakan pilih berat barang terlebih dahulu',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const formData = new FormData(this);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Penukaran Akan Segera Diproses!',
                            text: 'Kami akan segera melakukan penjemputan barang Anda.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect ke halaman menu swap setelah berhasil
                            window.location.href = 'menuswap.html';
                        });
                    } else {
                        Swal.fire({
                            title: 'Penukaran Gagal',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Kesalahan Server',
                        text: 'Terjadi kesalahan saat mencoba proses penukaran.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        });
    </script>
</body>
<?php
include "template/footer_user.php"
?>
</html>
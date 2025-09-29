<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan data user
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();

// Gabungkan first_name dan last_name
$nama_lengkap = $user_data['first_name'] . ' ' . $user_data['last_name'];
$stmt_user->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $foto = $_FILES['foto'];
    $jenis_barang =  $_POST['jenisBarang'];
    $jenis_bahan = $_POST['jenisBahan'];
    $details = $_POST['details'];
    $alamat_lengkap = $_POST['alamatLengkap'];
    $alamat = $_POST['provinsi'];
    $tanggal_penjemputan = $_POST['tanggalPenjemputan'];
    $berat_kg = $_POST['berat_kg'];

    $uploaded_files = [];
    
    for ($i = 0; $i < count($foto['name']); $i++) {
        if ($foto['error'][$i] === UPLOAD_ERR_OK) {
            $file_name = 'SWAPPRODUCT_' . time() . '' . $i . '' . $_SESSION['username'] . '.' . pathinfo($foto['name'][$i], PATHINFO_EXTENSION);
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $file_name;
            
            if (move_uploaded_file($foto['tmp_name'][$i], $file_path)) {
                $uploaded_files[] = $file_name;
            }
        }
    }    

    if (count($uploaded_files) > 0) {
        $foto_names = implode(",", $uploaded_files);
        $sql = "INSERT INTO orders (foto, jenis_barang, jenis_bahan, details, nama_lengkap, alamat_lengkap, alamat, tanggal_penjemputan, berat_kg, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $status = "menunggu";
        $stmt->bind_param("ssssssssis", $foto_names, $jenis_barang, $jenis_bahan, $details, $nama_lengkap, $alamat_lengkap, $alamat, $tanggal_penjemputan, $berat_kg, $status);

        if ($stmt->execute()) {
            echo "
                <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
                <script type=\"text/javascript\">
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Kami akan atur penjemputan Anda',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'menuswap.php';
                    }
                });
                </script>
            ";
        } else {
            echo "Error updating points: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
        <script type=\"text/javascript\">
        Swal.fire({
            title: 'Error!',
            text: 'Gagal mengunggah gambar!',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'tukarpakaian.php';
            }
        });
        </script>
    ";
};
}
    
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

        .weight-btn.active {
            background-color: #fa7fcf;
            color: white;
            border-color: #FFABE1;
        }

        #preview {
            display: grid;
            /* grid-template-columns: repeat(3, 1fr); */
            gap: 10px;
            justify-items: center;
        }

        #preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 5px;
        }

        .bg-white {
            padding: 5px 20px 30px 20px;
            margin-top: 20px;
        }

    </style>

<body class="bg-gray-50">
    <div class="container">
        <div class="bg-white p-4 rounded shadow row justify-content-center">
            <!-- Form Upload pakaian -->
            <form id="exchangeForm" method="POST" enctype="multipart/form-data">
                <div class="row align-items-start">
                    <div class="border rounded shadow-sm p-4 bg-light d-flex flex-column align-items-center">
                        <h1 class="text-center text-pink-600 font-bold mb-3 text-3xl">
                            <i class="fa-solid fa-upload"></i> Unggah disini</h1>
                        <div class="d-flex justify-content-center">
                            <label for="fileInput" class="cursor-pointer text-pink-600 font-medium">Klik untuk mengunggah gambar</i></label>
                            <input type="file" id="fileInput" class="d-none" accept="image/png, image/jpg, image/jpeg" name="foto[]" multiple>
                        </div>
                        <p class="text-center text-gray-400">(Unggah dalam bentuk PNG/JPG/JPEG)</p>
                        <div id="preview" class="mt-4 text-center">
                            <?php if (!empty($uploadedImage)): ?>
                                <img src="<?php echo $uploadedImage; ?>" alt="Uploaded Image">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-4">
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" 
                            value="<?php echo htmlspecialchars($nama_lengkap); ?>" 
                            required>
                        </div>
                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                            <input type="text" id="alamatLengkap" name="alamatLengkap" class="form-control" placeholder="Masukkan Alamat Lengkap" >
                        </div>
                        <div class="mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select class="form-select" id="provinsi" name="provinsi" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                                <option value="Jawa Barat">Jawa Barat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kabupatenKota" class="form-label">Kabupaten/Kota</label>
                            <select class="form-select" id="kabupatenKota" name="kabupatenKota" required>
                                <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                <option value="Kabupaten Bandung">Kabupaten Bandung</option>
                                <option value="Kota Bandung">Kota Bandung</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select class="form-select" id="kecamatan" name="kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kodePos" class="form-label">Kode Pos</label>
                            <select class="form-select" id="kodePos" name="kodePos" required>
                                <option value="" selected disabled>Pilih Kode Pos</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mt-4">
                        <div class="mb-3">
                            <label for="jenisBarang" class="form-label" >Jenis Barang</label>
                            <select class="form-select" id="jenisBarang" name="jenisBarang">
                                <option value="" selected disabled>Pilih jenis barang...</option>
                                <option value="top">Atasan</option>
                                <option value="bottom">Bawahan</option>
                                <option value="dress">Gaun</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenisBahan" class="form-label">Jenis Bahan</label>
                            <input type="text" class="form-control" id="jenisBahan" name="jenisBahan" placeholder="Masukkan jenis bahan">
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" rows="3" name="details" placeholder="Masukkan detail pakaian yang ingin ditukarkan." ></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggalPenjemputan" class="form-label">Tambahkan Tanggal Penjemputan</label>
                            <input type="date" id="tanggalPenjemputan" name="tanggalPenjemputan" class="form-control" >
                            <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const today = new Date().toISOString().split('T')[0];
                                document.getElementById("tanggalPenjemputan").setAttribute("min", today);
                            });
                        </script>
                        </div>
                        <div class="mb-3">
                            <label for="beratBarang" class="form-label">Pilih Berat</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-white weight-btn" data-weight="1">1 Kg</button>
                                <button type="button" class="btn btn-white weight-btn" data-weight="3">3 Kg</button>
                                <button type="button" class="btn btn-white weight-btn" data-weight="5">5 Kg</button>
                            </div>
                            <input type="hidden" id="selectedWeight" name="berat_kg">
                        </div>
                        <br>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn bg-gray-200 text-black hover:bg-gray-400 border-0 me-3" onclick="window.location.href='menuswap.php';">Kembali</button>
                            <button type="submit" name="btnpenjemputan" class="btn bg-pink-500 hover:bg-pink-600 text-Black">Atur Penjemputan</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Kolom Syarat dan Ketentuan -->
            <div>
                <h2 style="font-size: 25px; color: #D5006D; font-weight: bold;">
                    <br>
                    <br>
                    <br>
                    <i class="bi bi-stars text-pink-600 mr-3"></i>Syarat dan Ketentuan
                </h2>
                <br>
                <p>Pastikan Anda Membaca dan Memahami Seluruh Ketentuan Berikut Sebelum Melakukan Penukaran Pakaian!</p>
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
                <p class="text-m">Dengan melakukan penukaran ini, Anda dianggap telah menyetujui semua syarat dan ketentuan yang berlaku.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fileInput = document.getElementById("fileInput");
            const previewContainer = document.getElementById("preview");
            const alamatLengkapInput = document.getElementById("alamatLengkap");
            const alamatInput = document.getElementById("provinsi");
            const barangInput = document.getElementById("jenisBarang");
            const bahanInput = document.getElementById("jenisBahan");
            const detailsInput = document.getElementById("details");
            const tanggalPenjemputanInput = document.getElementById("tanggalPenjemputan");
            const weightButtons = document.querySelectorAll(".weight-btn");
            const weightInput = document.getElementById("selectedWeight");
            const form = document.getElementById("exchangeForm");

            fileInput.addEventListener("change", function () {
                const files = fileInput.files;
                const validExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
                let validFiles = true;

                // Validasi file
                Array.from(files).forEach(file => {
                    if (!validExtensions.includes(file.type)) {
                        validFiles = false;
                        alert('Hanya file gambar dengan ekstensi JPG, PNG, atau JPEG yang diperbolehkan!');
                    }
                });

                if (validFiles) {
                    previewContainer.innerHTML = "";
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith("image/")) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const img = document.createElement("img");
                                img.src = e.target.result;
                                img.alt = "Gambar yang Diupload";
                                previewContainer.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                } else {
                    fileInput.value = ''; // Reset input file jika file tidak valid
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const weightButtons = document.querySelectorAll('.weight-btn');
            const selectedWeightInput = document.getElementById('selectedWeight');

            weightButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Menghapus kelas aktif dari semua tombol
                    weightButtons.forEach(btn => btn.classList.remove('active'));

                    // Menambahkan kelas aktif pada tombol yang dipilih
                    this.classList.add('active');

                    // Menyimpan nilai berat yang dipilih pada input hidden
                    selectedWeightInput.value = this.getAttribute('data-weight');
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const provinsiSelect = document.getElementById("provinsi");
            const kabupatenKotaSelect = document.getElementById("kabupatenKota");
            const kecamatanSelect = document.getElementById("kecamatan");
            const kodePosSelect = document.getElementById("kodePos");

            const kecamatanData = {
                "Kabupaten Bandung": {
                    "Arjasari": ["40379"],
                    "Baleendah": ["40375"],
                    "Banjaran": ["40377"],
                    "Bojongsoang": ["40354"],
                    "Cangkuang": ["40361"],
                    "Cicalengka": ["40923"],
                    "Cikancung": ["40396"],
                    "Cilengkrang": ["40392"],
                    "Cileunyi": ["40393"],
                    "Cimaung": ["40374"],
                    "Cimenyan": ["40399"],
                    "Ciparay": ["40381"],
                    "Ciwidey": ["40362"],
                    "Dayeuhkolot": ["40353"],
                    "Ibun": ["40384"],
                    "Katapang": ["40355	"],
                    "Kertasari": ["40386"],
                    "Kutawaringin": ["40356"],
                    "Majalaya": ["40382"],
                    "Margaasih": ["40351"],
                    "Margahayu": ["40352"],
                    "Nagreg": ["40397"],
                    "Pacet": ["40385"],
                    "Pameungpeuk": ["40376"],
                    "Pangalengan": ["40378"],
                    "Paseh": ["40383"],
                    "Pasirjambu": ["40364"],
                    "Rancabali": ["40363"],
                    "Rancaekek": ["40394"],
                    "Solokanjeruk": ["40387"],
                    "Soreang": ["40311", "40312", "40313", "40314", "40315", "40316", "40317", "40318", "40319"]
                },
                "Kota Bandung": {
                    "Andir": ["40241", "40242", "40243", "40243"],
                    "Astana Anyar": ["40241", "40242", "40243"],
                    "Antapani": ["40291"],
                    "Arcamanik": ["40293"],
                    "Babakan Ciparay": ["40221", "40222", "40223", "40224", "40225", "40226", "40227"],
                    "Bandung Kidul": ["40266", "40267", "40268", "40269"],
                    "Bandung Kulon": ["40211", "40212", "40213", "40214", "40215"],
                    "Bandung Wetan": ["40114", "40115", "40116"],
                    "Batununggal": ["40271", "40272", "40273", "40274", "40275"],
                    "Bojongloa Kaler": ["40231", "40232", "40233"],
                    "Bojongloa Kidul": ["40234", "40235", "40236", "40237", "40238", "40239"],
                    "Buahbatu": ["40286"],
                    "Cibeunying Kaler": ["40122", "40122", "40123"],
                    "Cibeunying Kidul": ["40124", "40125", "40126", "40127", "40128"],
                    "Cibiru": ["40299"],
                    "Cicendo": ["40171", "40172", "40173", "40174", "40175"],
                    "Cidadap": ["40141", "40142", "40143"],
                    "Cinambo": ["40294"],
                    "Coblong": ["40131", "40132", "40133", "40134", "40135"],
                    "Gedebage": ["40295"],
                    "Kiaracondong": ["40281", "40282", "40283", "40284", "40285"],
                    "Lengkong": ["40261", "40262", "40263", "40264", "40265"],
                    "Mandalajati": ["40193", "40194"],
                    "Panyileukan": ["40298"],
                    "Rancasari": ["40292"],
                    "Regol": ["40251", "40252", "40253", "40254", "40255"],
                    "Sukajadi": ["40161", "40162", "40163", "40164"],
                    "Sukasari": ["	40151", "40152", "40153", "0154"],
                    "Sumur Bandung": ["40111", "40112", "40113"],
                    "Ujungberung": ["40199"]
                }
            };

            // Update Kecamatan dan Kode Pos berdasarkan pilihan Kabupaten/Kota
            kabupatenKotaSelect.addEventListener("change", function () {
                const selectedKabKota = kabupatenKotaSelect.value;
                kecamatanSelect.innerHTML = "<option value='' selected disabled>Pilih Kecamatan</option>";
                kodePosSelect.innerHTML = "<option value='' selected disabled>Pilih Kode Pos</option>";

                if (selectedKabKota && kecamatanData[selectedKabKota]) {
                    // Update kecamatan dropdown
                    Object.keys(kecamatanData[selectedKabKota]).forEach(function (kecamatan) {
                        const kecamatanOption = document.createElement("option");
                        kecamatanOption.value = kecamatan;
                        kecamatanOption.textContent = kecamatan;
                        kecamatanSelect.appendChild(kecamatanOption);
                    });
                }
            });

            // Update Kode Pos berdasarkan pilihan Kecamatan
            kecamatanSelect.addEventListener("change", function () {
                const selectedKecamatan = kecamatanSelect.value;
                kodePosSelect.innerHTML = "<option value='' selected disabled>Pilih Kode Pos</option>";

                if (selectedKecamatan) {
                    const selectedKabKota = kabupatenKotaSelect.value;
                    const kodePosArray = kecamatanData[selectedKabKota][selectedKecamatan];
                    if (kodePosArray.length === 1) {
                        const kodePosOption = document.createElement("option");
                        kodePosOption.value = kodePosArray[0];
                        kodePosOption.textContent = kodePosArray[0];
                        kodePosSelect.appendChild(kodePosOption);
                    }
                    else {
                        kodePosArray.forEach(function (kodePos) {
                            const kodePosOption = document.createElement("option");
                            kodePosOption.value = kodePos;
                            kodePosOption.textContent = kodePos;
                            kodePosSelect.appendChild(kodePosOption);
                        });
                    }
                }
            });
        });

        // Form Submission
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            if (fileInput.files.length === 0) {
                Swal.fire({
                    title: "Error Files!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }
            
            if (!alamatLengkapInput.value){
                Swal.fire({
                    title: "Alamat!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!alamatInput.value){
                Swal.fire({
                    title: "Alamat!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!barangInput.value){
                Swal.fire({
                    title: "Barang!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }
            
            if (!bahanInput.value){
                Swal.fire({
                    title: "Bahan!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!detailsInput.value){
                Swal.fire({
                    title: "Bahan!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!tanggalPenjemputanInput.value){
                Swal.fire({
                    title: "TGL!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!weightInput.value) {
                Swal.fire({
                    title: "Error!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!alamatLengkapInput.value){
                Swal.fire({
                    title: "Alamat!",
                    text: "Silakan pilih berat barang terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            form.submit();
        }); 
    </script>
</body>
<?php
include "template/footer_user.php"
?>
</html>
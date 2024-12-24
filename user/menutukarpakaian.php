<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
// Pastikan user sudah login dan dapatkan user_id dari session

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

$uploadedImage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $foto = $_FILES['foto'];
    $jenis_barang =  $_POST['jenisBarang'];
    $jenis_bahan = $_POST['jenisBahan'];
    $details = $_POST['details'];
    $alamat_lengkap = $_POST['alamatLengkap'];
    $alamat = $_POST['provinsi'];
    $tanggal_penjemputan = $_POST['tanggalPenjemputan'];
    $berat_kg = $_POST['berat_kg'];

    $foto_name = 'ORDERS' . time() . '_' . $_SESSION['username'];
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $foto_name;
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);

    $sql = "INSERT INTO orders (foto, jenis_barang, jenis_bahan, details, nama_lengkap, alamat_lengkap, alamat, tanggal_penjemputan, berat_kg, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $status = "Pending";  // Default status

    $stmt->bind_param("ssssssssis", $foto_name, $jenis_barang, $jenis_bahan, $details, $nama_lengkap, $alamat_lengkap, $alamat, $tanggal_penjemputan, $berat_kg, $status);

    if ($stmt->execute()) {
        //pop-up 
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
                    window.location.href = 'menuswap.php'; // Redirect if needed
                }
            });
            </script>
        ";
    } else {
        echo "Error updating points: " . $stmtTukarPoinSQL->error;
    }
    
    $stmtTukarPoinSQL->close();
};
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <input type="file" id="fileInput" class="d-none" accept="image/*" name="foto">
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
                            <label for="jenisBarang" class="form-label" >Jenis Barang</label>
                            <select class="form-select" id="jenisBarang" name="jenisBarang">
                                <option value="" selected disabled>Pilih jenis barang...</option>
                                <option value="top">Top</option>
                                <option value="bottom">Bottom</option>
                                <option value="dress">Dress</option>
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
                    </div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" 
                                value="<?php echo htmlspecialchars($nama_lengkap); ?>" 
                                readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="alamatLengkap" class="form-label">Alamat Lengkap</label>
                            <input type="text" id="alamatLengkap" name="alamatLengkap" class="form-control" placeholder="Alamat Lengkap" >
                        </div>
                        <div class="mb-3">
                            <label for="provinsi" class="form-label">Provinsi, Kab/Kota, Kecamatan, Kode Pos</label>
                            <input type="text" id="provinsi" class="form-control" name="provinsi" placeholder="Provinsi, Kab/Kota, Kecamatan, Kode Pos" >
                        </div>
                    </div>
                    <div class="col-md-6">
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
            const alamatLengkapInput = document.getElementById("alamatLengkap");
            const alamatInput = document.getElementById("provinsi");
            const barangInput = document.getElementById("jenisBarang");
            const bahanInput = document.getElementById("jenisBahan");
            const detailsInput = document.getElementById("details");
            const tanggalPenjemputanInput = document.getElementById("tanggalPenjemputan");
            const weightButtons = document.querySelectorAll(".weight-btn");
            const weightInput = document.getElementById("selectedWeight");
            const form = document.getElementById("exchangeForm");

            // Preview Image
            fileInput.addEventListener("change", function () {
                const file = fileInput.files[0];
                if (file) {
                    // Validasi tipe file
                    if (!file.type.startsWith("image/")) {
                        Swal.fire({
                            title: "File Tidak Valid",
                            text: "Silakan unggah file gambar yang valid (JPEG/PNG).",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        fileInput.value = "";
                        previewContainer.innerHTML = "";
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewContainer.innerHTML = ""; // Kosongkan preview sebelumnya
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.alt = "Selected Image";
                        img.style.maxWidth = "200px";
                        img.style.borderRadius = "5px";
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.innerHTML = "";
                }
            });

            // Weight Button Click Event
            weightButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    weightButtons.forEach((btn) => btn.classList.remove("active"));
                    this.classList.add("active");
                    weightInput.value = this.getAttribute("data-weight");
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
        });
    </script>
</body>
<?php
include "template/footer_user.php"
?>
</html>
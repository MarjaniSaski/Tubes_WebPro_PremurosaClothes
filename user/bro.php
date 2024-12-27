<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$poin = $_GET['poin'] ?? null;

// Query untuk mendapatkan data user
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$nama_lengkap = htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']);
$stmt_user->close();

// Query untuk mengambil data produk
$produk = null;
if ($poin) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE poin = ?");
    $stmt->bind_param("i", $poin);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $produk = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspedisi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="container mt-5">
        <div class="bg-white p-5 rounded shadow">
            <h3 class="mb-4 text-gray-800 font-semibold">Atur Pengiriman</h3>
            <form id="shipping-form">
                <div class="mb-3">
                    <label for="name" class="form-label text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" class="form-control border-gray-300" value="<?php echo htmlspecialchars($nama_lengkap); ?>" readonly>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let isSaved = false; // State to track whether data is saved

            document.getElementById('save-btn').addEventListener('click', function () {
                const name = document.getElementById('name').value;
                const phone = document.getElementById('phone').value;
                const address = document.getElementById('address').value;
                const province = document.getElementById('province').value;

                if (!name || !phone || !address || !province) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Pastikan semua data telah diisi!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Validasi Data',
                    html: `
                        <ul style="text-align: center; list-style-type: none; padding: 0;">
                            <li><strong>Nama:</strong> ${name}</li>
                            <li><strong>Nomor Telepon:</strong> ${phone}</li>
                            <li><strong>Alamat:</strong> ${address}</li>
                            <li><strong>Provinsi:</strong> ${province}</li>
                        </ul>
                        <p style="text-align: center;">Apakah data ini sudah benar?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Benar',
                    cancelButtonText: 'Perbaiki',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        isSaved = true; // Mark data as saved

                        document.getElementById('saved-data').innerHTML = `
                            <div class="alert alert-success">
                                <strong>Data Berhasil Disimpan:</strong><br>
                                Nama: ${name}<br>
                                Nomor Telepon: ${phone}<br>
                                Alamat: ${address}<br>
                                Provinsi: ${province}
                            </div>
                        `;

                        // Disable input fields and enable "Atur Pengiriman"
                        document.getElementById('phone').setAttribute('disabled', true);
                        document.getElementById('address').setAttribute('disabled', true);
                        document.getElementById('province').setAttribute('disabled', true);
                        document.getElementById('check-btn').removeAttribute('disabled');

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data Anda berhasil disimpan!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Silakan Perbaiki',
                            text: 'Periksa kembali data Anda.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            document.getElementById('check-btn').addEventListener('click', function () {
                // Pastikan data pengiriman sudah disimpan
                if (!isSaved) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Harap simpan data pengiriman terlebih dahulu!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Pastikan ekspedisi sudah dipilih
                const ekspedisi = document.querySelector('input[name="expedition"]:checked');
                if (!ekspedisi) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Pilih salah satu ekspedisi pengiriman!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Ambil data ekspedisi
                const ekspedisiId = ekspedisi.id;
                let ekspedisiName = '';

                switch (ekspedisiId) {
                    case 'jne':
                        ekspedisiName = 'JNE';
                        break;
                    case 'jnt':
                        ekspedisiName = 'J&T';
                        break;
                    case 'sicepat':
                        ekspedisiName = 'SiCepat';
                        break;
                    case 'wahana':
                        ekspedisiName = 'Wahana';
                        break;
                    default:
                        ekspedisiName = 'Tidak diketahui';
                }

                // Ambil data produk dari PHP (pastikan produk diinisialisasi di server-side)
                const produk = <?php echo json_encode($produk); ?>;

                // Tampilkan konfirmasi pengiriman menggunakan SweetAlert2
                Swal.fire({
                    title: 'Konfirmasi Pengiriman',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Data Penerima:</strong></p>
                            <p><strong>Nama:</strong> ${document.getElementById('name').value}</p>
                            <p><strong>Nomor Telepon:</strong> ${document.getElementById('phone').value}</p>
                            <p><strong>Alamat:</strong> ${document.getElementById('address').value}</p>
                            <p><strong>Provinsi:</strong> ${document.getElementById('province').value}</p>
                            <hr>
                            <p><strong>Data Pengiriman:</strong></p>
                            <p><strong>Ekspedisi:</strong> ${ekspedisiName}</p>
                            <hr>
                            <p><strong>Data Produk:</strong></p>
                            <p><strong>Tukar Poin:</strong> ${produk.poin}</p>
                        </div>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ff1493',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'menutukar.php';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Pengiriman Dibatalkan',
                            text: 'Pengiriman Anda dibatalkan.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

</body>

<?php include "template/footer_user.php"; ?>

</html>

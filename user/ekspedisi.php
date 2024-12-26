<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan data user dari session
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan data user
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$nama_lengkap = htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']);
$stmt_user->close();

// Mendapatkan data produk dan poin
$product_id = $_GET['id_produk']; 
$sql_product = "SELECT poin FROM produk WHERE id_produk = ?";
$stmt_product = $conn->prepare($sql_product);
$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$product_data = $stmt_product->get_result()->fetch_assoc();
$stmt_product->close();

// Cek apakah data produk ditemukan
$product_points = $product_data ? $product_data['poin'] : 0;
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
                    <button type="button" id="save-btn" class="bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
            <div id="saved-data" class="mt-4"></div>
        </div>

        <div class="bg-white p-5 rounded shadow mt-4">
            <h3 class="mb-4 text-gray-800 font-semibold text-center">Ekspedisi</h3>
            <div class="row text-center">
                <?php 
                $expeditions = ['jne' => 'JNE', 'jnt' => 'J&T', 'sicepat' => 'SiCepat', 'wahana' => 'Wahana'];
                foreach ($expeditions as $id => $name) {
                    echo "<div class='col-md-3'>
                            <input type='radio' name='expedition' id='{$id}' class='form-check-input'>
                            <label for='{$id}'><img src='" . HOST . "/foto/{$id}.png' alt='{$name}' class='img-fluid'></label>
                          </div>";
                }
                ?>
            </div>
            <div class="text-end mt-4">
                <button type="button" id="check-btn" class="bg-pink-400 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded">Atur Pengiriman</button>
            </div>
        </div>
    </div>

    <script>
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
                html: `<ul style="text-align: center; list-style-type: none; padding: 0;">
                    <li><strong>Nama:</strong> ${name}</li>
                    <li><strong>Nomor Telepon:</strong> ${phone}</li>
                    <li><strong>Alamat:</strong> ${address}</li>
                    <li><strong>Provinsi:</strong> ${province}</li>
                </ul>
                <p style="text-align: center;">Apakah data ini sudah benar?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Benar',
                cancelButtonText: 'Perbaiki',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('saved-data').innerHTML = `
                        <div class="alert alert-success">
                            <strong>Data Berhasil Disimpan:</strong><br>
                            Nama: ${name}<br>
                            Nomor Telepon: ${phone}<br>
                            Alamat: ${address}<br>
                            Provinsi: ${province}
                        </div>`;

                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Anda berhasil disimpan!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
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
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const address = document.getElementById('address').value.trim();
            const province = document.getElementById('province').value.trim();
            const ekspedisi = document.querySelector('input[name="expedition"]:checked');

            if (!name || !phone || !address || !province) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Pastikan semua data telah diisi!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!ekspedisi) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Pilih salah satu ekspedisi pengiriman!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const ekspedisiId = ekspedisi.id;
            const ekspedisiName = {
                'jne': 'JNE',
                'jnt': 'J&T',
                'sicepat': 'SiCepat',
                'wahana': 'Wahana'
            }[ekspedisiId] || 'Tidak diketahui';

            const productPoints = <?php echo $product_points; ?>;
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                html: `<p><strong>Nama:</strong> ${name}</p>
                    <p><strong>Nomor Telepon:</strong> ${phone}</p>
                    <p><strong>Alamat:</strong> ${address}</p>
                    <p><strong>Provinsi:</strong> ${province}</p>
                    <p><strong>Ekspedisi:</strong> ${ekspedisiName}</p>
                    <p><strong>Poin Produk:</strong> ${productPoints}</p>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pengiriman telah diatur.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/Tubes_WebPro_PremurosaClothes/user/menuswap.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Silakan periksa kembali data Anda.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
</body>
<?php include "template/footer_user.php"; ?>
</html>

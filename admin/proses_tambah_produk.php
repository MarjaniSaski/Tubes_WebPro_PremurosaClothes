<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Menambahkan gaya khusus untuk font */
    .swal2-popup {
        font-family: 'Arial', sans-serif; /* Ganti dengan font yang Anda inginkan */
    }
</style>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Mengecek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $genre_produk = $_POST['genre_produk'];
    $detail_produk = $_POST['detail_produk'];

    // Menangani pengunggahan gambar
    $gambar_produk = $_FILES['gambar_produk']['name'];
    $gambar_tmp = $_FILES['gambar_produk']['tmp_name'];
    $gambar_error = $_FILES['gambar_produk']['error'];

    // Memastikan tidak ada kesalahan dalam mengunggah gambar
    if ($gambar_error === 0) {
        // Menentukan direktori tempat gambar akan disimpan
        $upload_dir = "../images/";
        // Membuat path untuk menyimpan gambar
        $gambar_path = $upload_dir . basename($gambar_produk);

        // Memindahkan gambar dari lokasi sementara ke folder tujuan
        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            // Menyiapkan query untuk memasukkan data ke database
            $sql = "INSERT INTO produkBaru (nama_produk, gambar_produk, harga_produk, genre_produk, detail_produk) 
                    VALUES ('$nama_produk', '$gambar_path', '$harga_produk', '$genre_produk', '$detail_produk')";

            if ($conn->query($sql) === TRUE) {
                // Menggunakan SweetAlert2 untuk pop-up sukses
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Produk berhasil ditambahkan',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'producthome.php';
                            }
                        });
                    });
                </script>";
            } else {
                // Menampilkan pesan error jika query gagal
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data ke database: " . $conn->error . "',
                            confirmButtonText: 'OK'
                        });
                    });
                </script>";
            }
        } else {
            // Menampilkan pesan error jika gagal mengunggah gambar
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengunggah gambar',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    } else {
        // Menampilkan pesan error jika terjadi kesalahan saat mengunggah gambar
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan saat mengunggah gambar',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}

// Menutup koneksi database
$conn->close();
?>

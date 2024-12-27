<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';


// Ambil ID produk dari URL
$id_produk = $_GET['id_produk'] ?? null;

// Query untuk mengambil data produk
$produk = null;
if ($id_produk) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $produk = $result->fetch_assoc();
    }
}

// Jika produk tidak ditemukan
if (!$produk) {
    echo "<p>Produk tidak ditemukan.</p>";
    exit;
}

// Jika ada foto yang diunggah
if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
    // Menyusun nama foto baru
    $foto = 'PS_' . time() . '_' . $_FILES['foto']['name'];
    // Menentukan lokasi penyimpanan foto
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $foto;
    // Memindahkan file foto ke folder yang sesuai
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
} else {
    // Jika tidak ada foto baru, gunakan foto lama
    $foto = $produk['foto']; // Ambil nama foto dari database
}


$user_id = $_SESSION['user_id']; // Pastikan user_id sudah ada dalam session

// Query untuk mengambil nama lengkap pengguna
$resultData = $conn->query("SELECT first_name, last_name FROM user WHERE id = '$user_id'");

if ($resultData && $resultData->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $resultData->fetch_assoc();
    $fullname = $row['first_name'] . ' ' . $row['last_name'];
} else {
    // Handle the case where no data is found
    $fullname = "Nama Tidak Ditemukan";
}

// Query untuk menjumlahkan poin berdasarkan nama lengkap
$getPoinTukar = $conn->prepare("SELECT SUM(poin) FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $fullname);

if ($getPoinTukar->execute()) {
    $result = $getPoinTukar->get_result();
    $resultPoinTukar = $result->fetch_row()[0];

    // Jika tidak ada poin yang ditemukan, set poin menjadi 0
    if ($resultPoinTukar === null) {
        $resultPoinTukar = 0;
    }
} else {
    echo "Error: " . $getPoinTukar->error;
}

$getPoinTukar->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk Swap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menambahkan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
          body {
            margin: 0;
            padding: 5PX;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Agar header tetap berada di atas konten lainnya */

        }

        .product-container {
            margin: 70px auto;
            max-width: 1500px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
        
        }

        .product-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(247, 94, 193, 0.95); /* Ganti dengan warna yang Anda inginkan */
            padding: 10px;
            margin:20px;
        }

        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .product-details {
            padding: 20px;
            margin:10PX
        }

        .product-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .product-points {
            font-size: 1.5rem;
            color: #FF1493;
            font-weight: 600;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #fff5f8;
            border-radius: 10px;
            display: inline-block;
        }

        .product-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .product-info h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .btn-tukar {
            background-color:rgb(251, 151, 216);
            color: white;
            padding: 15px 40px;
            border-radius: 10px;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-tukar:hover {
            background-color: rgba(247, 94, 193, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(250, 45, 158, 0.3);
        }

        .size-badge {
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-radius: 8px;
            margin-right: 10px;
            color: #666;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Gaya placeholder jika gambar tidak ada */
        .image-placeholder {
            width: 100%;
            height: 500px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }
    </style>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="product-container">
    <div class="row">
        <div class="col-lg-6">
            <div class="product-image-container">
                <!-- Menampilkan gambar produk -->
                <?php if (!empty($foto) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $foto)): ?>
                    <img id="foto" src="/Tubes_WebPro_PremurosaClothes/images/<?= htmlspecialchars($foto); ?>" class="product-image">
                <?php else: ?>
                    <!-- Jika gambar tidak ada, tampilkan placeholder -->
                    <div class="image-placeholder">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="product-details">
                <h1 class="product-title"><?php echo htmlspecialchars($produk['nama']); ?></h1>
                <div class="product-points">
                    <i class="fas fa-coins"></i>
                    <?php echo number_format($produk['poin']); ?> Poin
                </div>

                <div class="product-info">
                    <h5><i class="fas fa-ruler-combined"></i> Ukuran </h5>
                    <?php 
                    // Menampilkan ukuran produk
                    $sizes = explode(',', $produk['size']);
                    foreach($sizes as $size): ?>
                        <span class="size-badge"><?php echo trim($size); ?></span>
                    <?php endforeach; ?>
                    
                </div>

                <div class="product-info">
                    <h5><i class="fas fa-info-circle"></i> Informasi Produk</h5>
                    <ul class="info-list">
                        <li><?php echo htmlspecialchars($produk['detail']); ?></li>
                    </ul>
                </div>

                <button class="btn-tukar" onclick="checkPoin(<?php echo $resultPoinTukar; ?>, <?php echo $produk['poin']; ?>, '<?php echo htmlspecialchars($produk['id_produk']); ?>')">
                    <i class="fas fa-exchange-alt"></i> Tukarkan Sekarang
                </button>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function checkPoin(poinUser, poinProduk, idProduk) {
        if (poinUser < poinProduk) {
            // Menampilkan pop-up SweetAlert2 jika poin tidak cukup
            Swal.fire({
                icon: 'error',
                title: 'Mohon maaf!',
                text: 'Poin Anda tidak cukup untuk menukar produk ini.',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Setelah klik "OK", kembali ke halaman menutukar.php
                    window.location.href = 'menutukar.php';
                }
            });
        } else {
            // Jika poin cukup, lanjutkan ke halaman ekspedisi
            window.location.href = 'ekspedisi.php?id_produk=' + idProduk;
        }
    }
</script>


</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/admin/template/header_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>
<style>
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    /* Mengatur tombol agar berada di sebelah kanan */
    .form-group button {
        text-align: right;  /* Menyelaraskan tombol ke kanan */
        margin-left: auto;   /* Menambahkan margin otomatis untuk menyelaraskan tombol ke kanan */
        display: block;      /* Membuat tombol menjadi blok agar margin bekerja */
    }

    label {
        font-weight: bold;
        color: #6a1b9a;
    }

    input[type="text"], input[type="number"], input[type="file"], textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    textarea {
        resize: vertical;
        height: 150px;
    }

    .btn {
        background-color: #6a1b9a;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #9c4dcc;
    }

    .form-container {
        padding: 20px;
    }
</style>

</head>
<body>

<div class="container">
    <h1 class="text-[#6a1b9a] text-2xl font-bold text-center">Tambah Produk Baru</h1>
        <div class="form-container">
            <form action="proses_tambah_produk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_produk">Nama Produk:</label>
                    <input type="text" id="nama_produk" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label for="gambar_produk">Gambar Produk:</label>
                    <input type="file" id="gambar_produk" name="gambar_produk" required>
                </div>
                <div class="form-group">
                    <label for="harga_produk">Harga Produk:</label>
                    <input type="number" id="harga_produk" name="harga_produk" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="genre_produk">Genre Produk:</label>
                    <input type="text" id="genre_produk" name="genre_produk" required>
                </div>
                <div class="form-group">
                    <label for="detail_produk">Detail Produk:</label>
                    <textarea id="detail_produk" name="detail_produk" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Tambahkan Produk</button>
                </div>
            </form>
        </div>
    </div>

        

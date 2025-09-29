<?php
include "template/header_admin.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    main {
        flex: 1;
    }
    footer {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: left;
        border-top: 1px solid #ddd;
        margin-top: 30px;
    }
</style>
<body class="min-h-screen flex flex-col">
    <main class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold"></h2>
            <div class="flex items-center">
                <input type="text" placeholder="Search" class="border rounded p-2 mr-4">
                <button class="bg-purple-500 text-white px-4 py-2 rounded" onclick="window.location.href='newproduk.php'">Tambah Produk</button>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM produkBaru";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='bg-white p-4 rounded shadow'>
                        <div class='h-32 mb-4 overflow-hidden rounded'>
                            <a href='detailproduk.php?id=" . $row['id_produk'] . "'>
                                <img src='" . $row['gambar_produk'] . "' alt='Foto Produk' class='w-full h-full object-cover'>
                            </a>
                        </div>
                        <h3 class='text-lg font-bold'>" . $row['nama_produk'] . "</h3>
                        <p class='text-purple-500 font-bold'>Rp " . number_format($row['harga_produk'], 0, ',', '.') . "</p>
                        <p class='text-gray-500 mt-2'>" . $row['genre_produk'] . "</p>
                        <p class='text-gray-400 text-sm'>" . $row['detail_produk'] . "</p>
                    </div>";
                }
            } else {
                echo "<p>Tidak ada produk yang tersedia.</p>";
            }

            $conn->close();
            ?>
        </div>
    </main>
    <?php include "template/footer_admin.php"; ?>
</body>
</html>

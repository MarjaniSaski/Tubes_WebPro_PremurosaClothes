<?php
include "template/header_admin.php"
?>
<!-- Main Content -->
<div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Products</h2>
                <div class="flex items-center">
                    <input type="text" placeholder="Search" class="border rounded p-2 mr-4">
                    <button class="bg-pink-500 text-white px-4 py-2 rounded"onclick="window.location.href='newproduct.html'">ADD NEW PRODUCT</button>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6">
                <!-- Product Card -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
                <!-- Repeat Product Card for other products -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <div class="bg-pink-200 h-32 mb-4"></div>
                    <h3 class="text-lg font-bold">Lorem Ipsum</h3>
                    <p class="text-gray-500">Lorem</p>
                    <p class="text-pink-500 font-bold">Rp 200.000</p>
                    <p class="text-gray-500 mt-2">Summary</p>
                    <p class="text-gray-400 text-sm">Lorem ipsum is placeholder text commonly used in the graphic.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

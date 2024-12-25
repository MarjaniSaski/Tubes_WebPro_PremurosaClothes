<?php
include "template/header_user.php"
?>

<!-- Main Content -->
<main class="px-6 py-10">
        <div class="grid grid-cols-3 gap-6">
        
            <!-- Chat Section -->
            <div class="col-span-2 bg-white rounded-lg shadow p-6 flex flex-col">
                <div class="flex items-center gap-4 mb-4">
                    <img src="https://via.placeholder.com/40" alt="User Avatar" class="rounded-full h-10">
                    <span class="text-pink-700 font-medium">Premurosa</span>
                </div>
                <div class="flex-grow bg-pink-50 rounded-lg border border-pink-200"></div>
                <div class="mt-4 flex">
                    <input type="text" placeholder="Tulis Pesan..." class="flex-grow border border-pink-300 rounded-l-lg px-4 py-2">
                    <button class="bg-pink-600 text-white px-4 py-2 rounded-r-lg">Kirim</button>
                </div>
            </div>
        </div>
    </main>
    
<?php
include "template/footer_user.php"
?>
</body>
</html>

<?php include "template/header_admin.php"; ?>
<style>
.chat-item {
    transition: all 0.2s;
    border-left: 4px solid transparent;
    cursor: pointer;
}

.chat-item:hover,
.chat-item.active {
    border-left-color: #6a1b9a;
}

.chat-item.active {
    background-color: #f3e5f5;
}

::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-thumb {
    background: #6a1b9a;
    border-radius: 3px;
}
</style>

<div class="container-fluid">
    <div class="flex h-[calc(100vh-80px)]">
        <!-- Daftar Pesan -->
        <div class="w-1/4 bg-white shadow-sm border-r">
            <div class="sticky top-0 bg-white p-4 border-b">
                <div class="relative">
                    <input type="text" class="w-full p-3 pl-10 rounded-lg border focus:border-purple-500" placeholder="Cari pesan...">
                    <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                </div>
            </div>
            
            <div class="overflow-y-auto h-[calc(100vh-180px)]" id="chat-list">
                <div class="chat-item active p-4 border-b hover:bg-purple-50" data-user="Budi Santoso">
                    <div class="flex justify-between items-start">
                        <div>
                            <h6 class="font-semibold">Budi Santoso</h6>
                            <p class="text-sm text-gray-600 mt-1">Stok jaket denim masih ada?</p>
                            <span class="text-xs text-gray-500">Baru saja</span>
                        </div>
                        <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full">2</span>
                    </div>
                </div>

                <div class="chat-item p-4 border-b hover:bg-purple-50" data-user="Siti Rahayu">
                    <div class="flex justify-between items-start">
                        <div>
                            <h6 class="font-semibold">Siti Rahayu</h6>
                            <p class="text-sm text-gray-600 mt-1">Dress putih ready semua ukuran?</p>
                            <span class="text-xs text-gray-500">5 menit yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chat -->
        <div class="flex-1 bg-gray-50">
            <div class="h-full flex flex-col">
                <!-- Header Chat -->
                <div class="bg-white p-4 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white">
                            <span id="user-initial">BS</span>
                        </div>
                        <div class="ml-3">
                            <h6 class="font-semibold" id="chat-user-name">Budi Santoso</h6>
                            <span class="text-sm text-green-500">● Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Isi Chat -->
                <div class="flex-1 p-4 overflow-y-auto" id="chat-messages">
                    <!-- Pesan akan ditambahkan di sini -->
                </div>

                <!-- Input Pesan -->
                <div class="bg-white border-t p-4">
                    <form id="chat-form" class="flex gap-3">
                        <input type="text" id="message-input" class="flex-1 p-3 rounded-lg border focus:border-purple-500" placeholder="Ketik balasan Anda...">
                        <button type="submit" class="bg-purple-600 text-white px-6 rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const messageForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatList = document.getElementById('chat-list');

    // Template pesan
    function createMessage(text, isAdmin = false) {
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        return `
            <div class="flex ${isAdmin ? 'justify-end' : ''} mb-4">
                <div class="max-w-[75%] ${isAdmin ? 'bg-purple-600 text-white' : 'bg-white'} rounded-lg p-3 shadow-sm">
                    <p>${text}</p>
                    <span class="text-xs ${isAdmin ? 'text-purple-200' : 'text-gray-500'} block text-right mt-1">${time}</span>
                </div>
            </div>
        `;
    }

    // Simulasi pesan untuk masing-masing user
    const chatData = {
        'Budi Santoso': [
            { text: 'Stok jaket denim masih ada?', isAdmin: false },
            { text: 'Ya, masih tersedia ukuran M dan L.', isAdmin: true },
            { text: 'Oke, saya pesan ukuran L ya.', isAdmin: false }
        ],
        'Siti Rahayu': [
            { text: 'Dress putih ready semua ukuran?', isAdmin: false },
            { text: 'Iya, tersedia semua ukuran.', isAdmin: true },
            { text: 'Bisa dikirim hari ini?', isAdmin: false }
        ]
    };

    // Menangani pengiriman pesan
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            chatMessages.insertAdjacentHTML('beforeend', createMessage(message, true));
            messageInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });

    // Menangani klik pada daftar chat
    const chatItems = document.querySelectorAll('.chat-item');
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            // Hapus kelas active dari semua item
            chatItems.forEach(i => i.classList.remove('active'));
            // Tambah kelas active ke item yang diklik
            this.classList.add('active');
            
            // Update nama dan inisial user
            const userName = this.getAttribute('data-user');
            document.getElementById('chat-user-name').textContent = userName;
            document.getElementById('user-initial').textContent = userName.split(' ').map(n => n[0]).join('');
            
            // Reset area chat
            chatMessages.innerHTML = '';
            
            // Menampilkan pesan yang sesuai dengan pengguna
            chatData[userName].forEach(msg => {
                chatMessages.insertAdjacentHTML('beforeend', createMessage(msg.text, msg.isAdmin));
            });
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    });
});
</script>

<?php include "template/footer_admin.php"; ?>
 
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';
?>
<style>
.chat-container {
    transition: all 0.2s;
}

::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-thumb {
    background: #ec4899;
    border-radius: 3px;
}

.product-card {
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-2px);
}

.chat-message {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 16px;
}

.chat-message.buyer {
    justify-content: flex-end; /* Align buyer messages to the right */
}

.chat-bubble {
    max-width: 75%;
    padding: 12px;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.chat-bubble.buyer {
    background-color: #ec4899; /* Pink background for buyer */
    color: white;
}

.chat-bubble.admin {
    background-color: white; /* White background for admin */
    border: 1px solid #f3f4f6; /* Light border for admin messages */
}

.chat-time {
    font-size: 10px;
    margin-top: 4px;
}

.chat-time.buyer {
    color: rgba(255, 255, 255, 0.6); /* Light color for buyer time */
}

.chat-time.admin {
    color: #9ca3af; /* Light color for admin time */
}
</style>

<div class="container-fluid">
    <div class="flex h-[calc(100vh-80px)]">
        <!-- Product Information Area -->
        <div class="w-1/3 bg-white shadow-sm border-r overflow-y-auto">
            <div class="sticky top-0 bg-white p-4 border-b">
                <h5 class="text-xl font-bold text-pink-600 mb-4">Informasi Produk</h5>
                <div class="product-card bg-white rounded-lg shadow-sm p-4 mb-4">
                    <img src="<?= HOST ?>/foto/5.png" alt="Gambar" class="card-img-top">
                    <h6 class="font-semibold text-gray-800">Dress Pink Elegant</h6>
                    <p class="text-pink-600 font-bold mt-2">Rp 299.000</p>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Tersedia ukuran: S, M, L, XL</p>
                        <p class="mt-1">Stok: 10 pcs</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 bg-gray-50">
            <div class="h-full flex flex-col">
                <!-- Chat Header -->
                <div class="bg-white p-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white">
                                <span>PC</span>
                            </div>
                            <div class="ml-3">
                                <h6 class="font-semibold">Admin Premurosa Clothes</h6>
                                <span class="text-sm text-green-500">● Online</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Estimasi balasan: ± 5 menit
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="flex-1 p-4 overflow-y-auto" id="chat-messages">
                    <!-- Welcome Message -->
                    <div class="chat-message">
                        <div class="chat-bubble admin">
                            <p class="text- black">Halo! Selamat datang di Premurosa Clothes.</p>
                            <p class="text-black mt-1">Ada yang bisa kami bantu?</p>
                            <span class="chat-time admin">12:00</span>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="bg-white border-t p-4">
                    <form id="chat-form" class="flex gap-3">
                        <input type="text" id="message-input" class="flex-1 p-3 rounded-lg border focus:border-pink-500" placeholder="Ketik pesan Anda...">
                        <button type="submit" class="bg-pink-600 text-white px-6 rounded-lg hover:bg-pink-700 transition-colors">
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

    // Message template
    function createMessage(text, isBuyer = true) {
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        return `
            <div class="chat-message ${isBuyer ? 'buyer' : ''}">
                <div class="chat-bubble ${isBuyer ? 'buyer' : 'admin'}">
                    <p>${text}</p>
                    <span class="chat-time ${isBuyer ? 'buyer' : 'admin'}">${time}</span>
                </div>
            </div>
        `;
    }

    // Handle message submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        
        if (message) {
            // Display buyer's message
            chatMessages.insertAdjacentHTML('beforeend', createMessage(message, true));
            messageInput.value = '';
            
            // Simulate admin typing indicator
            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'chat-message';
            typingIndicator.innerHTML = `
                <div class="chat-bubble admin">
                    <p class="text-gray-600">Admin sedang mengetik...</p>
                </div>
            `;
            chatMessages.appendChild(typingIndicator);
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Remove typing indicator after delay and show sample response
            setTimeout(() => {
                typingIndicator.remove();
                const adminResponse = "Terima kasih atas pertanyaan Anda. Admin kami akan segera merespons pesan Anda.";
                chatMessages.insertAdjacentHTML('beforeend', createMessage(adminResponse, false));
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 2000);
        }
    });
});
</script>

<?php
include "template/footer_user.php"
?>
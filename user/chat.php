<?php
include "template/header_user.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        header {
            margin: 0;
            padding: 0;
        }

        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .message-box {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 10px;
        }

        .chat-bubble {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 15px;
            max-width: 80%;
            display: inline-block;
          
        }

        .chat-bubble.user {
            background-color: #ff66b2;
            color: white;
            margin-left: auto;
            text-align: right;
            display: inline-block; /* Menyesuaikan lebar dengan panjang teks */
        }


        .chat-bubble.admin {
            background-color: #dcdcdc;
            color: black;
            margin-right: auto;
            text-align: left;
        }

        .send-message-btn {
            background-color: #ff66b2;
            color: white;
            border-radius: 5px;
            width: 80px;
        }

        .message-input {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            width: 80%;
        }
    </style>
</head>

<body>
    <main class="px-6 py-10">
        <div class="chat-container">
            <div class="message-box" id="message-box">
                <!-- Pesan akan tampil di sini -->
            </div>
            <div class="flex items-center mt-4">
                <input type="text" id="message-input" class="message-input" placeholder="Tulis Pesan...">
                <button id="send-btn" class="send-message-btn ml-2">Kirim</button>
            </div>
        </div>
    </main>

    <script>
        // Fungsi untuk menambahkan pesan ke dalam kotak pesan
        function addMessage(content, sender) {
            const messageBox = document.getElementById('message-box');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('chat-bubble', sender);
            messageDiv.textContent = content;
            messageBox.appendChild(messageDiv);
            messageBox.scrollTop = messageBox.scrollHeight; // Scroll otomatis ke bawah
        }

        // Event listener untuk tombol kirim
        document.getElementById('send-btn').addEventListener('click', function () {
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (message) {
                addMessage(message, 'user'); // Menambahkan pesan pengguna
                messageInput.value = ''; // Bersihkan input setelah mengirim pesan

                // Simulasikan respons dari admin
                setTimeout(function () {
                    addMessage("Terima kasih telah menghubungi kami, admin akan segera merespons.", 'admin');
                }, 1500); // Respons admin setelah 1.5 detik
            }
        });

        // Event listener untuk tombol Enter untuk kirim pesan
        document.getElementById('message-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('send-btn').click();
            }
        });
    </script>
    
    <?php
    include "template/footer_user.php";
    ?>
</body>

</html>

<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/PREMUROSA2/config.php';

?>
<!-- Profile Section -->
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <div class="flex items-center justify-center h-16">
            <h1 class="text-2xl font-bold">My Profile</h1>
        </div>
        <div class="flex justify-center items-center">
            <img alt="Profile picture" class="rounded-full w-24 h-24" src="foto/foto.png" />
        </div>
        
        <form class="space-y-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Username" value= >
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" placeholder="Your name">
            </div>
            <div class="flex flex-col">
                <label for="email" class="mb-1">Email</label>
                <input class="border rounded-md p-2" id="email" type="email" placeholder="ex. premurosaclothes@gmail.com"/>
            </div>
            <div class="flex flex-col">
                <label class="mb-1" for="phone">Nomor Telepon</label>
                <input class="border rounded-md p-2" id="phone" type="text" placeholder="081234567890"/>
            </div>
            <div class="flex flex-col">
                <label class="mb-1" for="password">Kata sandi</label>
                <div class="input-group">
                    <input class="form-control" id="password" type="password" placeholder="premurosa123"/>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i id="toggleIcon" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="flex flex-col">
                <label class="mb-1" for="birthdate">Tanggal Lahir</label>
                <input class="border rounded-md p-2" id="birthdate" type="date" placeholder="dd/mm/yy" />
            </div>
            <div class="flex flex-col">
                <label class="mb-1" for="gender">Jenis Kelamin</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="Wanita" checked>
                    <label class="form-check-label" for="female">
                        Wanita
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="Pria">
                    <label class="form-check-label" for="male">
                        Pria
                    </label>
                </div>
            </div>
        </form>
      


        <!-- Buttons Section -->
        <div class="mt-6 text-center">
            <button class="btn btn-purple text-white px-5 py-2 me-3" style="background-color: purple;">Edit</button>
            <button class="btn btn-purple text-white px-5 py-2" style="background-color: purple;">Keluar</button>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>

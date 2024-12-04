<?php
include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/PREMUROSA2/config.php';
?>
<!-- Profile Section -->
<div class="container mt-5 p-4 bg-white rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-center mb-4 font-bold text-xl">My Profile</h2>
        <div class="text-center mb-4">
            <div class="relative w-32 h-32 mx-auto">
                <img id="profilePicture" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="" />
                <p id="noPhotoText" class="text-muted italic">Foto profil belum ditambahkan</p>
                <input id="profilePictureInput" type="file" accept="image/*" class="absolute bottom-0 right-0 opacity-0 cursor-pointer w-8 h-8 hidden">
            </div>
        </div>

        <form id="profileForm" method ="post">
            <div class="mb-3">
                <label for="name" class="form-label text-sm">Nama Lengkap</label>
                <input type="text" id="name" class="form-control rounded-md text-sm" disabled>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label text-sm">Username</label>
                <input type="text" id="username" class="form-control rounded-md text-sm" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-sm">Email</label>
                <input type="email" id="email" class="form-control rounded-md text-sm" disabled>
            </div>
            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="birthDate" class="form-label text-sm">Tanggal Lahir</label>
                <input type="date" id="birthDate" class="form-control rounded-md text-sm" disabled>
            <p id="birthDateMessage" class="text-muted italic mt-2">Tanggal lahir belum diatur. Silakan atur terlebih dahulu.</p>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label text-sm">Nomor Telepon</label>
                <input type="text" id="phone" class="form-control rounded-md text-sm" disabled>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label text-sm">Jenis Kelamin</label>
                <select id="gender" class="form-control rounded-md text-sm" disabled>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select>
            </div>
            <div class="text-center">
                <button type="button" id="editButton" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                    Edit
                </button>
                <button type="button" id="logoutButton" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                    Keluar
                </button>
            </div>
            
        </form>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const profilePicture = document.getElementById('profilePicture');
            const profilePictureInput = document.getElementById('profilePictureInput');
        const noPhotoText = document.getElementById('noPhotoText');
        const editButton = document.getElementById('editButton');
        
        // Load data from localStorage
        const firstName = localStorage.getItem('firstName') || '';
        const lastName = localStorage.getItem('lastName') || '';
        const username = localStorage.getItem('username') || '';
        const email = localStorage.getItem('email') || '';
        const phone = localStorage.getItem('phone') || '';
        const gender = localStorage.getItem('gender') || '';
        const birthDate = localStorage.getItem('birthDate') || '';
        const photo = localStorage.getItem('photo');
    
        // Populate profile form
        document.getElementById('name').value = `${firstName} ${lastName}`;
        document.getElementById('username').value = username;
        document.getElementById('email').value = email;
        document.getElementById('phone').value = phone;
        document.getElementById('gender').value = gender;
    
        // Handle birthDate
        const birthDateInput = document.getElementById('birthDate');
        const birthDateMessage = document.getElementById('birthDateMessage');
        if (birthDate) {
            birthDateInput.value = birthDate;
            birthDateMessage.classList.add('hidden'); // Hide the message
        } else {
            birthDateMessage.classList.remove('hidden'); // Show the message if no birth date set
        }
        
        // Display photo if available
        if (photo) {
            profilePicture.src = photo;
            profilePicture.classList.remove('hidden');
            noPhotoText.classList.add('hidden');
        }
        
        // Edit button functionality
        editButton.addEventListener('click', function () {
            const isEditing = editButton.textContent === 'Save';
            if (isEditing) {
                // Save data
                const [newFirstName, newLastName] = document.getElementById('name').value.split(' ');
                localStorage.setItem('firstName', newFirstName || '');
                localStorage.setItem('lastName', newLastName || '');
                localStorage.setItem('username', document.getElementById('username').value);
                localStorage.setItem('email', document.getElementById('email').value);
                localStorage.setItem('phone', document.getElementById('phone').value);
                localStorage.setItem('gender', document.getElementById('gender').value);
                localStorage.setItem('birthDate', document.getElementById('birthDate').value);
                
                // Handle profile picture upload
                const file = profilePictureInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        localStorage.setItem('photo', e.target.result);
                        profilePicture.src = e.target.result;
                        profilePicture.classList.remove('hidden');
                        noPhotoText.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
    
                // Disable inputs
                toggleInputs(true);
                editButton.textContent = 'Edit';
            } else {
                // Enable inputs
                toggleInputs(false);
                editButton.textContent = 'Save';
            }
        });
    
        // Enable or disable input fields
        function toggleInputs(disabled) {
            document.querySelectorAll('#profileForm input, #profileForm select').forEach(input => {
                input.disabled = disabled;
            });
            profilePictureInput.classList.toggle('hidden', disabled);
        }
    
        // Allow profile picture edit
        profilePicture.addEventListener('click', () => {
            if (!profilePictureInput.classList.contains('hidden')) {
                profilePictureInput.click();
            }
        });
    
        // Handle file selection
        profilePictureInput.addEventListener('change', function () {
            const file = profilePictureInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profilePicture.src = e.target.result;
                    profilePicture.classList.remove('hidden');
                    noPhotoText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        // Handle date input changes
        birthDateInput.addEventListener('change', function () {
            const selectedDate = birthDateInput.value;
            if (selectedDate) {
                localStorage.setItem('birthDate', selectedDate);
                birthDateMessage.classList.add('hidden'); // Hide the message when date is selected
            }
        });
    
        // Logout button functionality
        document.getElementById('logoutButton').addEventListener('click', function () {
            window.location.href = 'login2.html'; // Redirect to login page
        });
    });

     // Ambil nama pengguna dari localStorage
     const username = localStorage.getItem('username');

// Jika ada nama pengguna yang tersimpan, tampilkan di bagian Hi, [Nama Pengguna]
    if (username) {
     document.getElementById('userGreeting').textContent = `Hi, ${username}`;
}
    
    </script>
</body>
</html>

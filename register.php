<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    if ($gender === 'Lainnya') {
        $gender = $_POST['other_gender'] ?: 'Lainnya'; // Gunakan input tambahan jika ada, jika tidak gunakan 'Lainnya'
    }
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role']; // Role bisa 'admin' atau 'buyer'

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'premurosa');
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyisipkan data ke tabel user dengan prepared statement untuk menghindari SQL Injection
    $sql = $conn->prepare("INSERT INTO `user` (first_name, last_name, gender, username, email, phone, password, role) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $sql->bind_param("ssssssss", $first_name, $last_name, $gender, $username, $email, $phone, $password, $role);

    if ($sql->execute()) {
        session_start();
        $_SESSION['user_id'] = $conn->insert_id;
        echo json_encode(['status' => 'success', 'message' => 'Pendaftaran akun berhasil!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Pendaftaran akun gagal.']);
    }

    $sql->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Registrasi</title>
    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-pink {
            background-color: #FFABE1;
        }
        .btn-pink {
            background-color: #FFABE1;
            color: #fff;
            border: none;
        }
        .btn-pink:hover {
            background-color: #e099c2;
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">
    <div class="flex-1 bg-pink-300 flex items-center justify-center text-center">
        <img src="foto/logoPremurosa.png" alt="Premurosa Logo" class="max-w-xs md:max-w-lg">
    </div>
    <div class="flex-1 flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-md">
            <h3 class="text-center text-2xl font-semibold mb-2">Daftar Akun Baru!</h3><br>
            <form id="registerForm" class="space-y-4">
                <div class="mb-3">
                    <input type="text" name="first_name" class="form-control" placeholder="Nama Depan" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="last_name" class="form-control" placeholder="Nama Belakang" required>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="role" class="form-label">Jenis Kelamin</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                    <i class="bi bi-chevron-compact-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="role" class="form-label">Peran</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="" selected>-- Pilih Peran --</option>
                        <option value="admin">Admin</option>
                        <option value="buyer">Pembeli</option>
                    </select>
                    <i class="bi bi-chevron-compact-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                </div>                
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="No Telepon" required>
                </div>
                <div class="mb-3" style="position: relative;">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi" style="padding-right: 40px;" required>
                    <i id="togglePassword" class="fa-regular fa-eye" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #6c757d;"></i>
                </div>

                <button type="submit" class="btn btn-pink w-100">Daftar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        });

        document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const otherGenderInput = document.getElementById('other-gender');
                if (this.value === 'Lainnya') {
                    otherGenderInput.style.display = 'block';
                } else {
                    otherGenderInput.style.display = 'none';
                    otherGenderInput.value = ''; // Reset nilai input "Lainnya"
                }
            });
        });

        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload form
            const formData = new FormData(this);
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'login.php'; // Redirect ke halaman login setelah sukses
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Kesalahan Server!',
                    text: 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>

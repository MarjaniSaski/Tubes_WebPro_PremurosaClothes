<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Menambahkan role yang dipilih dari form

    // Query untuk mendapatkan data user berdasarkan username dan role
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Jika login berhasil, simpan informasi ke session
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Simpan role di session

        // Return JSON response
        echo json_encode([
            'status' => 'success',
            'role' => $user['role']
        ]);
        exit;
    } else {
        // Jika login gagal
        echo json_encode([
            'status' => 'error',
            'message' => 'Login gagal! Username atau password salah atau role tidak cocok.'
        ]);
        exit;
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premurosa Login</title>
    <!-- Rubik font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex min-h-screen bg-gray-100 font-rubik">

    <!-- Left Section -->
    <div class="flex-1 bg-pink-300 flex items-center justify-center text-center">
        <img src="foto/logoPremurosa.png" alt="Premurosa Logo" class="max-w-xs md:max-w-lg">
    </div>

    <!-- Right Section -->
    <div class="flex-1 flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-md">
            <h3 class="text-left text-xl font-semibold mb-1">Selamat Datang di</h3>
            <h3 class="text-left text-2xl font-semibold mb-6">Premurosa Clothes!</h3>

            <form id="loginForm" class="space-y-4">
                <!-- Username -->
                <div>
                    <input type="username" id="username" name="username" style="width: 100%; padding: 12px 40px 12px 12px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 8px;" placeholder="Username" required>
                </div>
                <!-- Password -->
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password" name="password" style="width: 100%; padding: 12px 40px 12px 12px; font-size: 16px; border: 1px solid #d1d5db; border-radius: 8px;" placeholder="Kata Sandi" required>
                    <i id="togglePassword" class="fa-regular fa-eye" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #6b7280;"></i>
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <div class="input-group">
                    <select id="role" name="role" class="form-select form-select-placeholder" style="color: #6b7280;" required>
                        <option value="" selected disabled style:>Pilih Peran</option>
                        <option value="admin">Admin</option>
                        <option value="buyer">Pembeli</option>
                    </select>
                    
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-pink w-full py-2 text-lg rounded-lg font-semibold bg-pink-300 text-white hover:bg-pink-400">
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center mt-4">
                <p class="text-sm">Belum punya akun? 
                    <a href="register.php" class="text-pink-500 font-semibold hover:underline">Sign In</a>
                </p>
            </div>
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

    </script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload form

            const formData = new FormData(this);

            // Kirim permintaan POST ke server
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Login berhasil, tampilkan SweetAlert2
                    Swal.fire({
                        title: 'Login Berhasil!',
                        text: 'Selamat datang kembali.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect ke halaman sesuai role
                        if (data.role === 'admin') {
                            window.location.href = 'admin/dashboard.php';
                        } else if (data.role === 'buyer') {
                            window.location.href = 'user/indexuser.php';
                        }
                    });
                } else {
                    // Login gagal
                    Swal.fire({
                        title: 'Login Gagal',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Kesalahan Server',
                    text: 'Terjadi kesalahan saat mencoba login.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>
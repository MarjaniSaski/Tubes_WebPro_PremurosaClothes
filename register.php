<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
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
        $id = $conn->insert_id;
        // Jika registrasi berhasil, kirimkan respons sukses dalam JSON
        echo json_encode(['status' => 'success', 'message' => 'Pendaftaran akun berhasil!', 'id' => $id]);
    } else {
        // Jika gagal, kirimkan respons error
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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-pink {
            background-color: #FFABE1; /* Light pink color */
        }

        .btn-pink {
            background-color: #FFABE1; /* Button pink */
            color: #fff;
            border: none;
        }

        .btn-pink:hover {
            background-color: #e099c2; /* Darker pink */
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">
    <!-- Left Section -->
    <div class="flex-1 bg-pink-300 flex items-center justify-center text-center">
        <img src="foto/logoPremurosa.png" alt="Premurosa Logo" class="max-w-xs md:max-w-lg">
    </div>

    <!-- Right Section -->
    <div class="flex-1 flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-md">
            <h3 class="text-center text-2xl font-semibold mb-2">Daftar Akun Baru!</h3><br>
            <form id="registerForm" class="space-y-4">
                <!-- Role Selection -->
                <div class="mb-4">
                    <label class="mr-3">
                        <input type="radio" id="role_admin" name="role" value="admin" required> Admin
                    </label>
                    <label>
                        <input type="radio" id="role_buyer" name="role" value="buyer"> Pembeli
                    </label>
                </div>
                <div class="mb-3">
                    <input type="text" name="first_name" class="form-control" placeholder="Nama Depan" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="last_name" class="form-control" placeholder="Nama Belakang" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label><br>
                    <input type="radio" id="pria" name="gender" value="Pria" required> Pria
                    <input type="radio" id="wanita" name="gender" value="Wanita" required> Wanita
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
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                </div>

                <button type="submit" class="btn btn-pink w-100">Daftar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload form

            const formData = new FormData(this);

            // Kirim data ke server
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tampilkan SweetAlert jika berhasil
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect ke halaman login
                        window.location.href = 'login.php';
                    });
                } else {
                    // Tampilkan SweetAlert jika gagal
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
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

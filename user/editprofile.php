<?php
session_start();
require 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mengambil ID pengguna dari session
$id = $_SESSION['user_id'];

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'premurosa');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data pengguna berdasarkan ID
$sql = "SELECT * FROM user WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Menutup koneksi
$stmt->close();

// Memperbarui data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    // Update data pengguna
    $update_sql = "UPDATE user SET first_name=?, last_name=?, username=?, email=?, phone=?, gender=?, role=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", $first_name, $last_name, $username, $email, $phone, $gender, $role, $id);
    
    if ($stmt->execute()) {
        header("Location: profile.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Profil</h2>
        
        <form method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">Nama Depan</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Nama Belakang</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label><br>
                <input type="radio" name="gender" value="Pria" <?php echo ($user['gender'] == 'Pria' ? 'checked' : ''); ?>> Pria
                <input type="radio" name="gender" value="Wanita" <?php echo ($user['gender'] == 'Wanita' ? 'checked' : ''); ?>> Wanita
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" name="role">
                    <option value="admin" <?php echo ($user['role'] == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="buyer" <?php echo ($user['role'] == 'buyer' ? 'selected' : ''); ?>>Pembeli</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
<?php
include "template/footer_user.php"
?>
</html>

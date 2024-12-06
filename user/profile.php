<?php
// Memulai output buffering untuk menghindari pengiriman output sebelum header
ob_start();

include "template/header_user.php";
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Jika ada data yang dikirimkan untuk update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $full_name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birthDate'];

    // Cek apakah ada foto yang diupload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = $_FILES['profile_picture'];
        $profile_picture_name = time() . '_' . $profile_picture['name'];
        $profile_picture_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/uploads/' . $profile_picture_name;
        move_uploaded_file($profile_picture['tmp_name'], $profile_picture_path);
    } else {
        // Jika tidak ada foto, gunakan foto yang lama
        $profile_picture_name = $_POST['existing_profile_picture'];
    }

    // Query untuk update data pengguna
    $sql = "UPDATE user SET first_name = ?, last_name = ?, username = ?, email = ?, phone = ?, gender = ?, birth_date = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $username, $email, $phone, $gender, $birth_date, $profile_picture_name, $user_id);

    // Pisahkan nama depan dan belakang
    $name_parts = explode(" ", $full_name, 2);
    $first_name = $name_parts[0];
    $last_name = $name_parts[1] ?? '';

    if ($stmt->execute()) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui profil.');</script>";
    }
    $stmt->close();
}

// Query untuk mendapatkan data pengguna
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $full_name = $user['first_name'] . ' ' . $user['last_name'];
    $username = $user['username'];
    $email = $user['email'];
    $phone = $user['phone'];
    $gender = $user['gender'];
    $birth_date = $user['birth_date'] ?? '';
    $profile_picture = $user['profile_picture'] ?? '';
} else {
    die("Data pengguna tidak ditemukan!");
}


$stmt->close();
$conn->close();
?>

<div class="container mt-5 p-4 bg-white rounded-lg shadow-md max-w-md mx-auto">
    <h2 class="text-center mb-4 font-bold text-xl">My Profile</h2>
    <div class="text-center mb-4">
        <div class="relative w-32 h-32 mx-auto">
            <?php if ($profile_picture): ?>
                <img id="profilePicture" src="/Tubes_WebPro_PremurosaClothes/uploads/<?= htmlspecialchars($profile_picture); ?>" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="Foto Profil" />
            <?php else: ?>
                <img id="profilePicture" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="Foto Profil" />
            <?php endif; ?>
            <p id="noPhotoText" class="text-muted italic">Foto profil belum ditambahkan</p>
            <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" style="display:none;">
        </div>
    </div>

    <form id="profileForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="existing_profile_picture" value="<?= htmlspecialchars($profile_picture); ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label text-sm">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($full_name); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label text-sm">Username</label>
            <input type="text" id="username" name="username" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($username); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-sm">Email</label>
            <input type="email" id="email" name="email" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($email); ?>" disabled>
        </div>
        <!-- Tanggal Lahir -->
        <div class="mb-3">
            <label for="birthDate" class="form-label text-sm">Tanggal Lahir</label>
            <input type="date" id="birthDate" name="birthDate" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($birth_date); ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label text-sm">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($phone); ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label text-sm">Jenis Kelamin</label>
            <select id="gender" name="gender" class="form-control rounded-md text-sm" disabled>
                <option value="Pria" <?= $gender == 'Pria' ? 'selected' : ''; ?>>Pria</option>
                <option value="Wanita" <?= $gender == 'Wanita' ? 'selected' : ''; ?>>Wanita</option>
            </select>
        </div>
        <div class="text-center">
            <button type="button" id="editButton" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                Edit
            </button>
            <button type="submit" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]" id="saveButton" style="display:none;">
                Simpan
            </button>
            <button type="button" id="logoutButton" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                Keluar
            </button>
        </div>
        
    </form>
</div>

<script>
    // Script untuk mengaktifkan tombol edit
    document.getElementById('editButton').addEventListener('click', function() {
        document.getElementById('name').disabled = false;
        document.getElementById('username').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('birthDate').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('gender').disabled = false;
        document.getElementById('saveButton').style.display = 'inline-block';
        document.getElementById('profilePictureInput').style.display = 'block';
    });

    // Script untuk logout
    document.getElementById('logoutButton').addEventListener('click', function() {
        window.location.href = '/Tubes_WebPro_PremurosaClothes/login.php';
    });

    // Script untuk menampilkan preview foto profil yang diunggah
    document.getElementById('profilePictureInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePicture').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
// Memulai output buffering untuk menghindari pengiriman output sebelum header
ob_start();

include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari sesi
$insert_id = $_SESSION['user_id'];

// Jika ada data yang dikirimkan untuk update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != "") {
        // Jika ada file baru diunggah
        $profile_picture = 'PP_' . time() . '_' . $username;
        $profile_picture_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $profile_picture;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_path);
    } else {
        // Jika tidak ada file baru, gunakan gambar lama
        $profile_picture = $_POST['existing_profile_picture'];
    }
    

    // if (empty($_FILES['profile_picture']['name'])) {
    //     $profile_picture_name = 'Default_Picture.jpg';
    // } else {
    //     $profile_picture = $_FILES['profile_picture'];
    //     $profile_picture_name = time() . '_' . $profile_picture['name'];
    //     $profile_picture_path = $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/images/' . $profile_picture_name;
    //     move_uploaded_file($profile_picture_name, $profile_picture_path);
    // }
    

    // Query untuk update data pengguna
    $sql = "UPDATE user SET first_name = ?, last_name = ?, username = ?, email = ?, phone = ?, gender = ?, foto = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $first_name, $last_name, $username, $email, $phone, $gender, $profile_picture, $insert_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui profil.');</script>";
    }
    $stmt->close();
}

// Query untuk mendapatkan data pengguna
$tmp_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = $tmp_id";
$stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $tmp_id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $first_name = $user['first_name'] ;
    $last_name = $user['last_name'] ;
    $username = $user['username'];
    $email = $user['email'];
    $phone = $user['phone'];
    $gender = $user['gender'];
    if ($user['foto'] == null or $user['foto'] == 'Default_Pictures.jpg') {
        $profile_picture = 'Default_Pictures.jpg';
    } else {
        $profile_picture = $user['foto'];
    }
    
} else {
    die("Data pengguna tidak ditemukan!");
}


$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<style>
        .popup-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .popup-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            position: relative;
            transform: translateY(-20px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .popup-modal.active .popup-content {
            transform: translateY(0);
        }

        .popup-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0fdf4;
            color:rgb(24, 133, 64);
        }

        .popup-icon svg {
            width: 40px;
            height: 40px;
        }

        .popup-title {
            color: #1f2937;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .popup-message {
            color: #6b7280;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .popup-button {
            background: #655D8A;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .popup-button:hover {
            background: #4f4784;
            transform: translateY(-1px);
        }

        @keyframes checkmark {
            0% {
                stroke-dashoffset: 100;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        .checkmark {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: checkmark 0.8s ease forwards;
        }
    </style>
</head>
<body style="background: linear-gradient(to bottom, rgba(249, 199, 232, 0.95), rgba(255, 255, 255, 0.95));">

<div id="popupModal" class="popup-modal">
    <div class="popup-content">
        <div class="popup-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path class="checkmark" d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round">
            </svg>
        </div>
        <h2 class="popup-title">Berhasil!</h2>
        <p id="popupMessage" class="popup-message">Perubahan profil Anda telah disimpan</p>
        <button id="closePopup" class="popup-button">Selesai</button>
    </div>
</div>
    <div class="container mt-5 p-4 bg-white rounded-lg shadow-md max-w-md mx-auto">
        <h2 class="text-center mb-4 font-bold text-xl">My Profile</h2>
    
        <form id="profileForm" method="POST" enctype="multipart/form-data">
            <div class="text-center mb-4">
                <div class="relative w-32 h-32 mx-auto">
                    <?php if ($profile_picture): ?>
                        <img id="profilePicture" src="/Tubes_WebPro_PremurosaClothes/images/<?= htmlspecialchars($profile_picture); ?>" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="Foto Profil" />
                    <?php else: ?>
                        <img id="profilePicture" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="Foto Profil" />
                    <?php endif; ?>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display:none;">
                </div>
            </div>
    
            <input type="hidden" name="existing_profile_picture" value="<?= htmlspecialchars($profile_picture); ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label text-sm">Nama Depan</label>
                <input type="text" id="first_name" name="first_name" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($first_name); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label text-sm">Nama Belakang</label>
                <input type="text" id="last_name" name="last_name" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($last_name); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label text-sm">Username</label>
                <!-- Pastikan 'username' input tetap disabled -->
                <input type="text" id="username" name="username" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($username); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-sm">Email</label>
                <input type="email" id="email" name="email" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($email); ?>" disabled>
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
                <button type="button" id="editButton" class="bg-[#FB9EC6] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                    Edit
                </button>
                <button type="submit" class="bg-[#A888B5] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]" id="saveButton" style="display:none;">
                    Simpan
                </button>
                <button type="button" id="logoutButton" class="bg-[#ff1493] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                    Keluar
                </button>
            </div>
        </form>
    </div>
    </body>
    </html>

<script>
    // Script untuk mengaktifkan tombol edit
    document.getElementById('editButton').addEventListener('click', function() {
        document.getElementById('first_name').disabled = true;
        document.getElementById('last_name').disabled = true;
        document.getElementById('username').disabled = false;  
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('gender').disabled = false;
        document.getElementById('saveButton').style.display = 'inline-block';
        document.getElementById('profile_picture').style.display = 'block';
    });

    // Script untuk logout
    document.getElementById('logoutButton').addEventListener('click', function() {
        window.location.href = '/Tubes_WebPro_PremurosaClothes/login.php';
    });

    // Script untuk menampilkan preview foto profil yang diunggah
    document.getElementById('profile_picture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_picture').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });


     // Fungsi untuk menampilkan pop-up yang diperbarui
     function showPopup(message) {
        const popupModal = document.getElementById('popupModal');
        const popupMessage = document.getElementById('popupMessage');
        popupMessage.textContent = message;
        
        // Tambahkan kelas active untuk memicu animasi
        popupModal.classList.add('active');
        
        // Tambahkan event listener untuk tombol close
        document.getElementById('closePopup').addEventListener('click', function() {
            popupModal.classList.remove('active');
            setTimeout(() => {
                window.location.href = 'profile.php';
            }, 300);
        });
    }

    // Tambahkan event listener untuk form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulasikan pengiriman form
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            showPopup('Profil Anda berhasil diperbarui!');
        })
        .catch(error => {
            showPopup('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
</script>
<?php
include "template/footer_user.php"
?>
</html>
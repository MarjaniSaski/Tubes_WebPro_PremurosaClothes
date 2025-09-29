<?php
ob_start();

include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari sesi
$insert_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $first_name = $_POST['first_name'];  // Nama depan tetap
    $last_name = $_POST['last_name'];    // Nama belakang tetap
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

    // Query untuk update data pengguna, pastikan nama depan dan belakang tetap
    $tgl_lahir = $_POST['tgl_lahir'];

    $sql = "UPDATE user SET username = ?, email = ?, phone = ?, gender = ?, foto = ?, tgl_lahir = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $email, $phone, $gender, $profile_picture, $tgl_lahir, $insert_id);

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
    $tgl_lahir = $user['tgl_lahir'];
    if ($user['foto'] == null or $user['foto'] == 'Default_Picture.jpg') {
        $profile_picture = 'Default_Picture.jpg';
    } else {
        $profile_picture = $user['foto'];
    }
    
} else {
    die("Data pengguna tidak ditemukan!");
}

$stmt->close();
$conn->close();
?>

    <style>
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding-left: 10px;
            padding-right: 15px;
        }

        main{
            flex-grow: 1;
        }
        
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

<main>
    <body class="bg-gray-50">
        <div class="container p-4 bg-white rounded-lg shadow">
            <h2 class="text-center mb-4 font-medium text-xl text-pink-500">Informasi Profil</h2>
            <form id="profileForm" method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <div class="relative w-32 h-32 mx-auto">
                        <?php if ($profile_picture): ?>
                            <img id="profilePicture" src="/Tubes_WebPro_PremurosaClothes/images/<?= htmlspecialchars($profile_picture); ?>" class="rounded-full w-full h-full object-cover border-4 border-pink-200" alt="Foto Profil" />
                        <?php else: ?>
                            <img id="profilePicture" class="rounded-full w-full h-full object-cover border-4 border-pink-500" alt="Foto Profil" />
                        <?php endif; ?>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display:none;">
                        <input type="hidden" name="existing_profile_picture" value="<?= htmlspecialchars($profile_picture); ?>">
                    </div>
                </div> 
                <div class="mb-3">
                    <label for="first_name" class="form-label text-sm">Nama Depan</label>
                    <input type="text" id="first_name" name="first_name" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($first_name); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label text-sm">Nama Belakang</label>
                    <input type="text" id="last_name" name="last_name" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($last_name); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label text-sm">Username</label>
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
                    <label for="tgl_lahir" class="form-label text-sm">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control rounded-md text-sm" value="<?= htmlspecialchars($tgl_lahir); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label text-sm">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="form-control rounded-md text-sm" disabled>
                        <option value="Pria" <?= $gender == 'Pria' ? 'selected' : ''; ?>>Pria</option>
                        <option value="Wanita" <?= $gender == 'Wanita' ? 'selected' : ''; ?>>Wanita</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="button" id="editButton" class="bg-pink-600 text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-pink-400">
                        Ubah
                    </button>
                    <button type="submit" class="bg-pink-600 text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-pink-400" id="saveButton" style="display:none;">
                        Simpan
                    </button>
                    <button type="button" id="backButton" class="bg-pink-400 text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-pink-200">
                        Kembali
                    </button>
                </div>
            </form>

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
        </div>
    </body>
</main>

<script>
    // Script untuk mengaktifkan tombol edit
    document.getElementById('editButton').addEventListener('click', function() {
        // Sembunyikan tombol Edit
        this.style.display = 'none';

        // Tampilkan tombol Save
        document.getElementById('saveButton').style.display = 'inline-block';

        // Izinkan kolom selain first_name dan last_name untuk diedit
        document.getElementById('username').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('gender').disabled = false;
        document.getElementById('tgl_lahir').disabled = false;

        // Tampilkan input untuk mengganti foto profil
        document.getElementById('profile_picture').style.display = 'block';
    });

    // Script untuk tombol kembali
    document.getElementById('backButton').addEventListener('click', function() {
        history.back();
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
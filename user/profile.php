<?php
// Memulai output buffering untuk menghindari pengiriman output sebelum header
ob_start();

// Include file header dan config
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

//mendapatkan id user dari url 
$id = $_GET['id'];
$sqlStatement = "SELECT * FROM user WHERE id='$id'";
$query = mysqli_query($conn, $sqlStatement);

// Cek apakah query berhasil
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}
// Ambil data user 
$row = mysqli_fetch_assoc($query);

// Proses edit profile user 
if (isset($_POST['btnEditProfile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $tgl_lahir = $_POST["tgl_lahir"];
    $foto = $_FILES['foto'];

    // Proses foto jika ada yang di-upload
    if (!empty($foto['name'])) {
        $photoName = time() . '_' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], '../images/' . $photoName);

        // Hapus foto lama
        unlink("../images/" . $row['foto']);
    } else {
        $photoName = $row['foto'];
    }
    // Query untuk update data user
    $sqlStatement = "UPDATE user SET 
                        first_name='$firstname', 
                        last_name='$last_name', 
                        foto='$photoName', 
                        username='$username',
                        gender='$gender', 
                        email='$email', 
                        tgl_lahir='$tgl_lahir',
                        phone='$phone'
                    WHERE id='$id'";
    // Eksekusi query
    $query = mysqli_query($conn, $sqlStatement);
    // Cek hasil query
    if ($query) {
        $successMsg = urlencode("Pengubahan data Profile User berhasil!");
        header("Location: profile.php?successMsg=$successMsg");
        exit; // Hentikan eksekusi setelah redirect
    } else {
        $errMsg = "Pengubahan data Profile User gagal: " . mysqli_error($conn);
        echo $errMsg;
    }
}

// Menutup output buffering dan mengirimkan output
ob_end_flush();
?>

<!-- Profile Section -->
<div class="container mt-5 p-4 bg-white rounded-lg shadow-md max-w-md mx-auto">
    <h2 class="text-center mb-4 font-bold text-xl">My Profile</h2>
    <div class="text-center mb-4">
        <div class="relative w-32 h-32 mx-auto">
            <!-- Foto Profil yang ada sekarang -->
            <img id="profilePicture" class="rounded-full w-full h-full object-cover border-4 border-pink-200" src="<?php echo '../images/' . $row['foto']; ?>" alt="Profile Picture" />
            <p id="noPhotoText" class="text-muted italic <?php echo ($row['foto']) ? 'hidden' : ''; ?>">Foto profil belum ditambahkan</p>
            <!-- Input untuk upload foto -->
            <input id="profilePictureInput" type="file" accept="image/*" name="foto" class="absolute bottom-0 right-0 opacity-0 cursor-pointer w-8 h-8 hidden">
        </div>
    </div>

    <form id="profileForm" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label text-sm">Nama Lengkap</label>
            <input type="text" id="name" name="first_name" class="form-control rounded-md text-sm" value="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label text-sm">Username</label>
            <input type="text" id="username" name="username" class="form-control rounded-md text-sm" value="<?php echo $row['username']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-sm">Email</label>
            <input type="email" id="email" name="email" class="form-control rounded-md text-sm" value="<?php echo $row['email']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="birthDate" class="form-label text-sm">Tanggal Lahir</label>
            <input type="date" id="birthDate" name="tgl_lahir" class="form-control rounded-md text-sm" value="<?php echo $row['tgl_lahir']; ?>" disabled>
            <p id="birthDateMessage" class="text-muted italic mt-2">Tanggal lahir belum diatur. Silakan atur terlebih dahulu.</p>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label text-sm">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-control rounded-md text-sm" value="<?php echo $row['phone']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label text-sm">Jenis Kelamin</label>
            <select id="gender" name="gender" class="form-control rounded-md text-sm" disabled>
                <option value="Pria" <?php echo ($row['gender'] == 'Pria') ? 'selected' : ''; ?>>Pria</option>
                <option value="Wanita" <?php echo ($row['gender'] == 'Wanita') ? 'selected' : ''; ?>>Wanita</option>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" id="btnEditProfile" name="btnEditProfile" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                Edit
            </button>
            <button onclick="window.location.href='<?= HOST ?>/login.php';" type="button" id="logoutButton" class="bg-[#655D8A] text-white py-2 px-4 rounded-md shadow transition ease-in-out duration-300 hover:bg-[#4f4784]">
                Keluar
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePicture = document.getElementById('profilePicture');
        const profilePictureInput = document.getElementById('profilePictureInput');
        const noPhotoText = document.getElementById('noPhotoText');
        const editButton = document.getElementById('btnEditProfile');

        // Enable or disable form fields
        function toggleInputs(disabled) {
            document.querySelectorAll('#profileForm input, #profileForm select').forEach(input => {
                input.disabled = disabled;
            });
            profilePictureInput.classList.toggle('hidden', disabled);
        }

        // Edit button functionality
        editButton.addEventListener('click', function() {
            const isEditing = editButton.textContent === 'Save';
            if (isEditing) {
                // Disable inputs after saving
                toggleInputs(true);
                editButton.textContent = 'Edit';
            } else {
                // Enable inputs for editing
                toggleInputs(false);
                editButton.textContent = 'Save';
            }
        });

        // Allow profile picture edit
        profilePicture.addEventListener('click', () => {
            if (!profilePictureInput.classList.contains('hidden')) {
                profilePictureInput.click();
            }
        });

        // Handle file selection for profile picture
        profilePictureInput.addEventListener('change', function() {
            const file = profilePictureInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicture.src = e.target.result;
                    profilePicture.classList.remove('hidden');
                    noPhotoText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
</body>
<?

<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Pastikan ID pengguna ada di sesi
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Pengguna tidak ditemukan!']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Mengambil data dari form
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$birthDate = $_POST['birthDate'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];

// Query untuk memperbarui data pengguna
$sql = "UPDATE user SET first_name = ?, last_name = ?, username = ?, email = ?, birth_date = ?, phone = ?, gender = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $name, $username, $email, $birthDate, $phone, $gender, $user_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profil berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui profil.']);
}

$stmt->close();
$conn->close();
?>

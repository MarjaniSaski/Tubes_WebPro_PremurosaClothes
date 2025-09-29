<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$voucher_code = $_GET['voucher_code']; 

// Ambil data user
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$nama_lengkap = $user_data['first_name'] . ' ' . $user_data['last_name'];
$stmt_user->close();

// Ambil total poin dari orders
$getPoinTukar = $conn->prepare("SELECT COALESCE(SUM(poin), 0) as total_poin FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $nama_lengkap);
$getPoinTukar->execute();
$result = $getPoinTukar->get_result();
$row = $result->fetch_assoc();
$resultPoinTukar = $row['total_poin'];
$getPoinTukar->close();

// Ambil total poin yang sudah digunakan dari shipping_data
$getPointUsed = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used FROM shipping_data WHERE user_id = ?");
$getPointUsed->bind_param("i", $user_id);
$getPointUsed->execute();
$result = $getPointUsed->get_result();
$row = $result->fetch_assoc();
$resultPointUsed = $row['points_used'];
$getPointUsed->close();

// Ambil total poin yang sudah digunakan untuk voucher
$getPointUsedVoucher = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used_voucher FROM tukar_voucher WHERE user_id = ?");
$getPointUsedVoucher->bind_param("i", $user_id);
$getPointUsedVoucher->execute();
$result = $getPointUsedVoucher->get_result();
$row = $result->fetch_assoc();
$resultPointUsedVoucher = $row['points_used_voucher'];
$getPointUsedVoucher->close();

// Hitung sisa poin
$totalPoinTersisa = $resultPoinTukar - ($resultPointUsed + $resultPointUsedVoucher);

// Ambil data voucher
$sql_voucher = "SELECT voucher_name, discount, points, usage_period, max_period, usage_quota, max_amount 
               FROM vouchers 
               WHERE voucher_code = ?";
$stmt_voucher = $conn->prepare($sql_voucher);
$stmt_voucher->bind_param("i", $voucher_code);
$stmt_voucher->execute();
$voucher_data = $stmt_voucher->get_result()->fetch_assoc();
$voucher_points = $voucher_data['points'];
$stmt_voucher->close();
?>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,rgb(243, 139, 196),rgba(255, 228, 239, 0.76));
    color: #333;
    margin: 0;
    padding: 0;
}

.voucher-container {
    max-width: 850px;
    margin: 100px auto 50px;
    padding: 30px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    animation: fadeIn 0.8s ease;
}

.voucher-header {
    background: linear-gradient(135deg, #ff99c8, #ff66a6);
    color: #fff;
    padding: 40px 30px;
    text-align: center;
    border-radius: 20px 20px 0 0;
    position: relative;
}

.voucher-title {
    font-size: 2.8rem;
    font-weight: bold;
    letter-spacing: 2px;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.user-points {
    font-size: 1.2rem;
    margin-top: 10px;
    font-weight: 500;
}

.voucher-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.detail-card {
    background: linear-gradient(135deg, #ffe4ef, #ffc1e3);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.detail-label {
    font-size: 0.9rem;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1.5px;
    color: #ff66a6;
    margin-bottom: 5px;
}

.detail-value {
    font-size: 1.5rem;
    color: #333;
    font-weight: 600;
}

.usage-period-container {
    display: flex;
    gap: 20px;
}

.btn-container {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    padding: 0 20px;
}

.btn-back, .btn-swap {
    display: inline-block;
    padding: 15px 40px;
    background: linear-gradient(135deg, #ff99c8, #ff66a6);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.btn-back:hover, .btn-swap:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

@media screen and (max-width: 768px) {
    .voucher-container {
        margin: 20px;
    }
    .voucher-title {
        font-size: 2rem;
    }
    .detail-value {
        font-size: 1.2rem;
    }
    .usage-period-container {
        flex-direction: column;
    }
    .btn-container {
        flex-direction: column;
        gap: 15px;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<div class="voucher-container">
    <div class="voucher-header">
        <h2 class="voucher-title">Detail Voucher</h2>
        <div class="user-points">Poin Anda: <?= number_format($totalPoinTersisa) ?></div>
    </div>
    <div class="voucher-details">
        <div class="detail-card">
            <div class="detail-label">Nama Voucher</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['voucher_name']) ?></div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Diskon</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['discount']) ?>% OFF</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Poin Yang Dibutuhkan</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['points']) ?> Points</div>
        </div>
        <div class="usage-period-container">
            <div class="detail-card">
                <div class="detail-label">Periode Penggunaan</div>
                <div class="detail-value"><?= htmlspecialchars($voucher_data['usage_period']) ?></div>
            </div>
            <div class="detail-card">
                <div class="detail-label">Batas Penggunaan</div>
                <div class="detail-value"><?= htmlspecialchars($voucher_data['max_period']) ?></div>
            </div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Kuota Tersisa</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['usage_quota']) ?> kali</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Maksimum Pembelian</div>
            <div class="detail-value">Rp <?= number_format($voucher_data['max_amount'], 0, ',', '.') ?></div>
        </div>
    </div>
    
    <form id="voucher-form" method="POST">
        <div class="btn-container">
            <a href="tukarpoin.php" class="btn-back">Kembali</a>
            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" id="product_id" value="<?php echo $voucher_code; ?>">
            <input type="hidden" id="product_name" value="<?php echo htmlspecialchars($voucher_data['voucher_name']); ?>">
            <input type="hidden" id="points_used" value="<?php echo $voucher_points; ?>">
            <button type="submit" class="btn-swap">Tukarkan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/tukar_voucher.js"></script>

<script>
    document.getElementById('voucher-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Ambil data dari form
    const userId = document.getElementById('user_id').value;
    const productId = document.getElementById('product_id').value;
    const productName = document.getElementById('product_name').value;
    const pointsUsed = document.getElementById('points_used').value;
    const userPoints = parseInt(<?= $totalPoinTersisa ?>);

    // Cek apakah poin mencukupi
    if (userPoints < pointsUsed) {
        Swal.fire(
            'Poin Tidak Cukup!',
            'Anda tidak memiliki cukup poin untuk menukarkan voucher ini.',
            'error'
        );
        return;
    }

    // Konfirmasi penukaran
    Swal.fire({
        title: 'Konfirmasi Penukaran',
        text: `Anda akan menukarkan voucher ${productName} dengan ${pointsUsed} poin. Lanjutkan?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tukarkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('swap_voucher.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id: parseInt(userId),
                    voucher_code: parseInt(productId),
                    voucher_name: productName,
                    points_used: parseInt(pointsUsed)
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                    }).then(() => {
                        window.location.href = 'tukarpoin.php';
                    });
                } else {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Tukarkan';
                    Swal.fire(
                        'Gagal!',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Terjadi kesalahan dalam proses penukaran voucher!',
                    'error'
                );
            });
        }
    });
});
</script>
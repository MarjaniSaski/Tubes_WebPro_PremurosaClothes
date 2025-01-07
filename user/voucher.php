<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/user/template/header_user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$voucher_code = $_GET['voucher_code']; 

// Get user data first since we need the name for the orders query
$sql_user = "SELECT first_name, last_name FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_data = $stmt_user->get_result()->fetch_assoc();
$nama_lengkap = $user_data['first_name'] . ' ' . $user_data['last_name'];
$stmt_user->close();

// Get total points earned from orders
$getPoinTukar = $conn->prepare("SELECT SUM(poin) as total_poin FROM orders WHERE nama_lengkap = ?");
$getPoinTukar->bind_param("s", $nama_lengkap);
$getPoinTukar->execute();
$result = $getPoinTukar->get_result();
$row = $result->fetch_assoc();
$resultPoinTukar = $row['total_poin'] ?? 0;
$getPoinTukar->close();

// Get total points used from shipping_data
$getPointUsed = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used FROM shipping_data WHERE user_id = ?");
$getPointUsed->bind_param("i", $user_id);
$getPointUsed->execute();
$result = $getPointUsed->get_result();
$row = $result->fetch_assoc();
$resultPointUsed = $row['points_used'] ?? 0;
$getPointUsed->close();

$getPointUsedVoucher = $conn->prepare("SELECT COALESCE(SUM(points_used), 0) as points_used_voucher FROM tukar_voucher WHERE user_id = ?");
$getPointUsedVoucher->bind_param("i", $user_id);
$getPointUsedVoucher->execute();
$result = $getPointUsedVoucher->get_result();
$row = $result->fetch_assoc();
$resultPointUsedVoucher = $row['points_used_voucher'] ?? 0;
$getPointUsedVoucher->close();

// Calculate remaining points
$totalPoinTersisa = $resultPoinTukar - ($resultPointUsed + $resultPointUsedVoucher);

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
    margin: 100px auto 50px; /* Added margin for spacing */
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
    text-align:center;
}

.usage-period-container {
    display: flex;
    gap: 20px;
}

.btn-container {
    display: flex;
    justify-content: space-between; 
    margin-top: 30px;
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
    margin: 0 10px;
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
        <h2 class="voucher-title">Voucher Details</h2>
        <div class="user-points">Poin Anda: <?= number_format($totalPoinTersisa) ?></div>
    </div>
    <div class="voucher-details">
        <div class="detail-card">
            <div class="detail-label">Voucher Name</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['voucher_name']) ?></div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Discount</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['discount']) ?>% OFF</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Points Required</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['points']) ?> Points</div>
        </div>
        <div class="usage-period-container">
            <div class="detail-card">
                <div class="detail-label">Usage </div>
                <div class="detail-label">Period </div>
                <div class="detail-value"><?= htmlspecialchars($voucher_data['usage_period']) ?></div>
            </div>
            <div class="detail-card">
                <div class="detail-label">Maximum </div>
                <div class="detail-label">Period</div>
                <div class="detail-value"><?= htmlspecialchars($voucher_data['max_period']) ?></div>
            </div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Usage Quota</div>
            <div class="detail-value"><?= htmlspecialchars($voucher_data['usage_quota']) ?> uses</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Maximum Amount</div>
            <div class="detail-value">Rp <?= number_format($voucher_data['max_amount'], 0, ',', '.') ?></div>
        </div>
    </div>
    <form id="voucher-form" method="POST" class="w-full">
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

<script>
document.getElementById('voucher-form')?.addEventListener('submit', function (e) {
e.preventDefault();

    // Ambil data dari input form
    const userId = document.getElementById('user_id').value;
    const productId = document.getElementById('product_id').value;
    const productName = document.getElementById('product_name').value;
    const pointsUsed = document.getElementById('points_used').value;
    const userPoints = parseInt(<?= $totalPoinTersisa ?>); 
    if (userPoints < pointsUsed) { 
        Swal.fire( 
            'Poin Tidak Cukup!', 
            'Anda tidak memiliki cukup poin untuk menukarkan voucher ini.', 
            'error' 
        ); 
        return; 
    }
    // Konfirmasi pengguna
    Swal.fire({
        title: 'Konfirmasi Penukaran',
        text: `Anda akan menukarkan voucher ${productName} dengan ${pointsUsed} poin. Apakah Anda yakin?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tukarkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim data ke server
            fetch('swap_voucher.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id: userId,
                    voucher_code: productId,
                    voucher_name: productName,
                    points_used: pointsUsed,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Berhasil!',
                            data.message,
                            'success'
                        ).then(() => {
                            // Redirect ke halaman tukarpoin setelah sukses
                            window.location.href = 'tukarpoin.php';
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Terjadi Kesalahan!',
                        'error'
                    );
                    console.error('Error:', error);
                });
        }
    });
});

</script>
<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

// Include database configuration
include $_SERVER['DOCUMENT_ROOT'] . '/Tubes_WebPro_PremurosaClothes/config.php';

$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    if (!empty($query)) {
        // Query to search products based on the search term
        $sql = "SELECT * FROM produk WHERE nama LIKE ? OR description LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_term = "%" . $query . "%";
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Search</title>
</head>
<body class="bg-gray-50">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Search Products</h2>
        
        <!-- Search Form -->
        <form action="search.php" method="GET" class="mb-4 d-flex justify-content-center">
            <input type="text" name="query" class="form-control w-50" placeholder="Search for products..." required>
            <button type="submit" class="btn btn-primary ms-2"><i class="bi bi-search"></i> Search</button>
        </form>

        <!-- Search Results -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])): ?>
            <h5 class="text-center mb-3">Search Results for: <strong><?= htmlspecialchars($_GET['query']); ?></strong></h5>
            
            <?php if (!empty($search_results)): ?>
                <div class="row">
                    <?php foreach ($search_results as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="/Tubes_WebPro_PremurosaClothes/uploads/<?= htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                                    <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No results found for "<strong><?= htmlspecialchars($_GET['query']); ?></strong>"</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
<?php
include "template/footer_user.php"
?>
</html>

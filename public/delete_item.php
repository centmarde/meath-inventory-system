<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Require authentication
AuthGuard::requireAuth();

// Get item ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Item ID is required.";
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];

// Fetch item details for confirmation
try {
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$item) {
        $_SESSION['error'] = "Item not found.";
        header('Location: dashboard.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Failed to fetch item details.";
    header('Location: dashboard.php');
    exit();
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success'] = "Item deleted successfully!";
        header('Location: dashboard.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to delete item. Please try again.";
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Delete Item - Meat Inventory System</title>
</head>
<body>
    <?php include '../views/partials/header.php'; ?>
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Confirm Delete</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            <strong>Warning!</strong> This action cannot be undone.
                        </div>
                        
                        <p class="lead">Are you sure you want to delete this item?</p>
                        
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-tag"></i> <?php echo htmlspecialchars($item['type']); ?></h5>
                                <p class="card-text mb-2">
                                    <strong>Quantity:</strong> <?php echo htmlspecialchars($item['quantity']); ?> units<br>
                                    <strong>Price:</strong> ₱<?php echo number_format($item['price'], 2); ?> per unit<br>
                                    <strong>Total Value:</strong> ₱<?php echo number_format($item['quantity'] * $item['price'], 2); ?>
                                </p>
                            </div>
                        </div>
                        
                        <form method="POST" action="delete_item.php?id=<?php echo $id; ?>" class="mt-4">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="dashboard.php" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" name="confirm_delete" class="btn btn-danger btn-lg">
                                    <i class="bi bi-trash"></i> Delete Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../views/partials/footer.php'; ?>
</body>
</html>

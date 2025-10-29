<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Require authentication
AuthGuard::requireAuth();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = trim($_POST['type']);
    $quantity = trim($_POST['quantity']);
    $price = trim($_POST['price']);
    
    // Validation
    if (empty($type) || empty($quantity) || empty($price)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be a positive number.";
    } elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a positive number.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO inventory (type, quantity, price) VALUES (?, ?, ?)");
            $stmt->execute([$type, $quantity, $price]);
            
            $_SESSION['success'] = "Item added successfully!";
            header('Location: dashboard.php');
            exit();
        } catch (PDOException $e) {
            $error = "Failed to add item. Please try again.";
        }
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
    <title>Add Item - Meat Inventory System</title>
</head>
<body>
    <?php include '../views/partials/header.php'; ?>
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Inventory Item</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="add_item.php">
                            <div class="mb-3">
                                <label for="type" class="form-label"><i class="bi bi-tag"></i> Item Type</label>
                                <select class="form-select form-select-lg" id="type" name="type" required>
                                    <option value="">Select item type...</option>
                                    <option value="Pork" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Pork') ? 'selected' : ''; ?>>Pork</option>
                                    <option value="Chicken" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Chicken') ? 'selected' : ''; ?>>Chicken</option>
                                    <option value="Beef" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Beef') ? 'selected' : ''; ?>>Beef</option>
                                    <option value="Lamb" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Lamb') ? 'selected' : ''; ?>>Lamb</option>
                                    <option value="Turkey" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Turkey') ? 'selected' : ''; ?>>Turkey</option>
                                    <option value="Duck" <?php echo (isset($_POST['type']) && $_POST['type'] == 'Duck') ? 'selected' : ''; ?>>Duck</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label"><i class="bi bi-box"></i> Quantity (units)</label>
                                <input type="number" class="form-control form-control-lg" id="quantity" name="quantity" 
                                       placeholder="Enter quantity" min="0" step="1" 
                                       value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : ''; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="price" class="form-label"><i class="bi bi-cash"></i> Price per Unit (₱)</label>
                                <input type="number" class="form-control form-control-lg" id="price" name="price" 
                                       placeholder="Enter price" min="0" step="0.01" 
                                       value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="dashboard.php" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle"></i> Add Item
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

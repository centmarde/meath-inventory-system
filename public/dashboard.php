<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Require authentication to access this page
AuthGuard::requireAuth();

// Fetch inventory data
$result = $pdo->query('SELECT * FROM inventory');

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
    <title>Dashboard - Meat Inventory System</title>
</head>
<body>
    <?php include '../views/partials/header.php'; ?>
    
    <div class="container my-5">
        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold"><i class="bi bi-speedometer2 text-primary"></i> Dashboard</h1>
                <p class="text-muted">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>! Manage your meat inventory efficiently.</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="add_item.php" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle"></i> Add New Item
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <?php 
            $totalItems = 0;
            $totalValue = 0;
            $tempResult = $pdo->query('SELECT * FROM inventory');
            while ($row = $tempResult->fetch(PDO::FETCH_ASSOC)) {
                $totalItems += $row['quantity'];
                $totalValue += $row['quantity'] * $row['price'];
            }
            $itemCount = $pdo->query('SELECT COUNT(*) FROM inventory')->fetchColumn();
            ?>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-basket3 text-primary" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-2"><?php echo $itemCount; ?></h3>
                        <p class="text-muted mb-0">Product Types</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-success" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-2"><?php echo $totalItems; ?></h3>
                        <p class="text-muted mb-0">Total Quantity</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-warning" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-2">₱<?php echo number_format($totalValue, 2); ?></h3>
                        <p class="text-muted mb-0">Total Value</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Inventory List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><i class="bi bi-tag"></i> Type</th>
                                <th scope="col"><i class="bi bi-box"></i> Quantity</th>
                                <th scope="col"><i class="bi bi-cash"></i> Price</th>
                                <th scope="col"><i class="bi bi-calculator"></i> Total Value</th>
                                <th scope="col" class="text-center"><i class="bi bi-gear"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 1;
                            $hasItems = false;
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                                $hasItems = true;
                                $totalRowValue = $row['quantity'] * $row['price'];
                            ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['type']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo htmlspecialchars($row['quantity']); ?> units</span>
                                    </td>
                                    <td>₱<?php echo number_format($row['price'], 2); ?></td>
                                    <td><strong>₱<?php echo number_format($totalRowValue, 2); ?></strong></td>
                                    <td class="text-center">
                                        <a href="edit_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            
                            <?php if (!$hasItems): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="text-muted mt-3">No items in inventory yet.</p>
                                        <a href="add_item.php" class="btn btn-success">
                                            <i class="bi bi-plus-circle"></i> Add Your First Item
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include '../views/partials/footer.php'; ?>
</body>
</html>
<?php
// Redirect authenticated users to dashboard
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
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
    <title>Home - Meat Inventory System</title>
</head>
<body>
    <?php include '../views/partials/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Meat Inventory Management System</h1>
                    <p class="lead mb-4">Efficiently manage your meat inventory with our comprehensive tracking system. Monitor stock levels, prices, and product types in real-time.</p>
                    <div class="d-grid gap-2 d-md-flex">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="dashboard.php" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-speedometer2"></i> Go to Dashboard
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        <?php endif; ?>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-info-circle"></i> Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-shop" style="font-size: 15rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5" id="features">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Key Features</h2>
            <p class="text-muted">Everything you need to manage your meat inventory</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Inventory Tracking</h4>
                        <p class="text-muted">Keep track of all your meat products including pork, chicken, and beef with accurate quantity monitoring.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar text-success" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Price Management</h4>
                        <p class="text-muted">Manage pricing for each product type and calculate total inventory value automatically.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-graph-up text-info" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Real-time Updates</h4>
                        <p class="text-muted">Create, update, and delete inventory items with instant reflection in your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-shield-check text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Secure Access</h4>
                        <p class="text-muted">User authentication system to protect your inventory data and manage access.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-layout-text-sidebar text-danger" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Easy to Use</h4>
                        <p class="text-muted">Simple and intuitive interface designed for quick navigation and efficient management.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-database text-secondary" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">SQLite Database</h4>
                        <p class="text-muted">Lightweight and reliable SQLite database for fast and efficient data storage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-light py-5">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-3">Ready to Get Started?</h2>
            <p class="lead text-muted mb-4">Login to your account and start managing your inventory today.</p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-speedometer2"></i> Go to Dashboard
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Login Now
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../views/partials/footer.php'; ?>
</body>
</html>

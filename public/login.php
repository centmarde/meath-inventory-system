<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Redirect to dashboard if already logged in
AuthGuard::requireGuest();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple authentication logic (vulnerable to SQL injection)
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $pdo->query($query);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password.";
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
    <title>Login - Meat Inventory System</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shop text-primary" style="font-size: 3rem;"></i>
                            <h2 class="fw-bold mt-3">Meat Inventory</h2>
                            <p class="text-muted">Sign in to your account</p>
                        </div>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="username" class="form-label"><i class="bi bi-person"></i> Username</label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="register.php" class="text-decoration-none fw-bold">Register here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
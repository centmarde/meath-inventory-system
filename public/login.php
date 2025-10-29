<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Redirect to dashboard if already logged in
AuthGuard::requireGuest();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // VULNERABILITY 1: No input sanitization
    $username = $_POST['username'];
    $password = $_POST['password'];

    // VULNERABILITY 2: SQL Injection - Direct string concatenation
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    try {
        // VULNERABILITY 3: Detailed error messages expose database structure
        $result = $pdo->query($query);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // VULNERABILITY 4: No session regeneration after login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // VULNERABILITY 5: Information disclosure in comments (visible in source)
            // Successfully logged in as user ID: $user['id']
            // Database table: users
            // Query executed: $query
            
            header('Location: dashboard.php');
            exit();
        } else {
            // VULNERABILITY 6: User enumeration - different messages for invalid user vs wrong password
            $checkUser = $pdo->query("SELECT * FROM users WHERE username = '$username'");
            if ($checkUser->fetch(PDO::FETCH_ASSOC)) {
                $error = "Invalid password for user '$username'. Please try again.";
            } else {
                $error = "User '$username' does not exist. Please check your username or register.";
            }
        }
    } catch (PDOException $e) {
        // VULNERABILITY 7: Database error exposure
        $error = "Database Error: " . $e->getMessage() . "<br><strong>Query:</strong> " . htmlspecialchars($query);
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
                            <!-- VULNERABILITY 8: Information disclosure in HTML comments -->
                            <!-- SQL Query Format: SELECT * FROM users WHERE username = '$username' AND password = '$password' -->
                            <!-- Database: SQLite (inventory.db) -->
                            <!-- Table: users (columns: id, username, password) -->
                            <!-- Sample payload: admin' OR '1'='1 -->
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
                                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter username">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </button>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center">
                            <p class="mb-2">Don't have an account? 
                                <a href="register.php" class="text-decoration-none fw-bold">Register here</a>
                            </p>
                            <!-- VULNERABILITY 9: Debug mode enabled - sensitive info in comments -->
                            <!-- Server: PHP <?php echo phpversion(); ?> -->
                            <!-- Database Path: ../database/inventory.db -->
                            <!-- Auth Check: Line 14 vulnerable to SQL injection -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- VULNERABILITY 10: Security headers missing (check with dev tools) -->
    <!-- No X-Frame-Options, No Content-Security-Policy, No X-XSS-Protection -->
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
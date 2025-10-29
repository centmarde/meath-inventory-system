<?php
session_start();

require_once '../config/database.php';
require_once '../src/middleware/AuthGuard.php';

// Redirect to dashboard if already logged in
AuthGuard::requireGuest();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif (strlen($username) < 3) {
        $error = "Username must be at least 3 characters long.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            $error = "Username already exists. Please choose another one.";
        } else {
            // Insert new user (Note: In production, password should be hashed!)
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $password]);
                
                $success = "Registration successful! You can now login.";
                
                // Optional: Auto-login after registration
                // $_SESSION['user_id'] = $pdo->lastInsertId();
                // $_SESSION['username'] = $username;
                // header('Location: dashboard.php');
                // exit();
            } catch (PDOException $e) {
                $error = "Registration failed. Please try again.";
            }
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
    <title>Register - Meat Inventory System</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus text-success" style="font-size: 3rem;"></i>
                            <h2 class="fw-bold mt-3">Create Account</h2>
                            <p class="text-muted">Join Meat Inventory System</p>
                        </div>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="register.php">
                            <div class="mb-3">
                                <label for="username" class="form-label"><i class="bi bi-person"></i> Username</label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                       placeholder="Choose a username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                                <small class="text-muted">At least 3 characters</small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                       placeholder="Create a password" required>
                                <small class="text-muted">At least 6 characters</small>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label"><i class="bi bi-lock-fill"></i> Confirm Password</label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" 
                                       placeholder="Confirm your password" required>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-person-plus"></i> Register
                                </button>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="login.php" class="text-decoration-none fw-bold">Login here</a>
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

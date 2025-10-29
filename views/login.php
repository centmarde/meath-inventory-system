<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Simple authentication logic (vulnerable to SQL injection)
            $db = new PDO('sqlite:../database/inventory.db');
            $stmt = $db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<p>Invalid username or password.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
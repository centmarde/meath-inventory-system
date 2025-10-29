<?php
session_start();

require_once '../config/database.php';
require_once '../src/auth/AuthController.php';
require_once '../src/controllers/InventoryController.php';
require_once '../src/middleware/AuthGuard.php';

$authController = new AuthController($pdo);
$inventoryController = new InventoryController($pdo);

$page = 'home'; // Default page

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch ($page) {
    case 'home':
        // Redirect logged-in users to dashboard
        if (AuthGuard::isAuthenticated()) {
            header('Location: dashboard.php');
            exit();
        }
        require_once '../views/home.php';
        break;
    case 'login':
        AuthGuard::requireGuest();
        require_once 'login.php';
        break;
    case 'register':
        AuthGuard::requireGuest();
        require_once 'register.php';
        break;
    case 'dashboard':
        AuthGuard::requireAuth();
        require_once 'dashboard.php';
        break;
    case 'inventory':
        AuthGuard::requireAuth();
        require_once 'inventory/list.php';
        break;
    default:
        // Redirect logged-in users to dashboard
        if (AuthGuard::isAuthenticated()) {
            header('Location: dashboard.php');
            exit();
        }
        require_once '../views/home.php';
        break;
}
?>
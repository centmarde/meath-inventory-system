<?php
/**
 * Authentication Guard Middleware
 * Protects routes from unauthorized access
 */
class AuthGuard {
    
    /**
     * Check if user is authenticated
     * @return bool
     */
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Require authentication - redirect to login if not authenticated
     * Use this for protected pages (dashboard, inventory, etc.)
     */
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: login.php');
            exit();
        }
    }
    
    /**
     * Require guest - redirect to dashboard if already authenticated
     * Use this for guest-only pages (login, register)
     */
    public static function requireGuest() {
        if (self::isAuthenticated()) {
            header('Location: dashboard.php');
            exit();
        }
    }
    
    /**
     * Get current user ID
     * @return int|null
     */
    public static function getUserId() {
        return self::isAuthenticated() ? $_SESSION['user_id'] : null;
    }
    
    /**
     * Get current username
     * @return string|null
     */
    public static function getUsername() {
        return self::isAuthenticated() ? $_SESSION['username'] : null;
    }
}
?>

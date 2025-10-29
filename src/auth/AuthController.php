<?php

class AuthController {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function login($username, $password) {
        // Vulnerable to SQL Injection
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $this->db->query($query);
        if ($result->fetchArray()) {
            $_SESSION['user'] = $username;
            header("Location: /dashboard.php");
        } else {
            return "Invalid username or password.";
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login.php");
    }

    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }
}
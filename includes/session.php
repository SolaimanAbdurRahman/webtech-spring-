<?php
session_start();

// Session timeout (30 minutes)
$timeout = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: index.php?action=login&msg=timeout");
    exit();
}

$_SESSION['last_activity'] = time();

// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function isStaff() {
    return isset($_SESSION['user_type']) && ($_SESSION['user_type'] === 'staff' || $_SESSION['user_type'] === 'admin');
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php?action=login");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: index.php?error=unauthorized");
        exit();
    }
}

function requireStaff() {
    requireLogin();
    if (!isStaff()) {
        header("Location: index.php?error=unauthorized");
        exit();
    }
}

// CSRF protection
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Flash messages
function setFlashMessage($type, $message) {
    $_SESSION['flash_messages'][$type] = $message;
}

function getFlashMessage() {
    if (isset($_SESSION['flash_messages'])) {
        $flash = $_SESSION['flash_messages'];
        unset($_SESSION['flash_messages']);
        return $flash;
    }
    return null;
}

// User functions
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":user_id", $_SESSION['user_id']);
    $stmt->execute();
    
    return $stmt->fetch();
}

function getUserById($user_id) {
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    
    return $stmt->fetch();
}

// Utility functions
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('M d, Y H:i', strtotime($datetime));
}

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}
?> 
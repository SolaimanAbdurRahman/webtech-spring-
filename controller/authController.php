<?php
require_once __DIR__ . '/../model/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Basic validation
    $errors = [];
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is needed';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Attempt to login
        $user = new User();
        $loggedInUser = $user->login($email, $password);
        
        if ($loggedInUser) {
            // Start session and store user data
            session_start();
            $_SESSION['user'] = $loggedInUser;
            
            // Redirect to dashboard
            header('Location: ../view/dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid email or password';
        }
    }
    
    // Pass errors back to view if any
    $loginErrors = $errors;
}

// Then keep your existing GET page checks...
// Add this to your existing authController.php
if (isset($_GET['page']) && $_GET['page'] === 'profile') {
    require_once __DIR__ . '/profileController.php';
    exit;
}

if (isset($_GET['page']) && $_GET['page'] === 'login') {
    include __DIR__ . '/../view/login.php';
    exit;
}
if (isset($_GET['page']) && $_GET['page'] === 'signup') {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
       
        // Basic validation
        $errors = [];
        if (empty($name)) {
            $errors[] = 'Full name is needed';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is needed';
        }
        if (empty($password) || strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }
       
        if (empty($errors)) {
            // Create user if no errors
            $user = new User();
            $registrationResult = $user->signup($name, $email, $password);
           
            if ($registrationResult) {
                // Redirect to login on success
                header('Location: ?page=login');
                exit;
            } else {
                $errors[] = 'signup failed.';
            }
        }
       
        // Pass errors back to view if any
        $registerErrors = $errors;
    }
   
    include __DIR__ . '/../view/signup.php';
    exit;
}
<?php
require_once __DIR__ . '/../model/User.php';

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
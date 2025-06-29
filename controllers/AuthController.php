<?php
require_once 'models/User.php';
require_once 'includes/session.php';

class AuthController {
    private $userModel;
    private $router;

    public function __construct() {
        $this->userModel = new User();
        $this->router = new Router();
    }

    // Display login form
    public function login() {
        if (isLoggedIn()) {
            redirect('index.php');
        }
        
        $this->router->renderView('views/auth/login.php');
    }

    // Handle login
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=login');
        }
        
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($password)) {
            setFlashMessage('error', 'Please enter both username and password');
            redirect('index.php?action=login');
        }
        
        $user = $this->userModel->authenticate($username, $password);
        
        if ($user) {
            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_activity'] = time();
            
            setFlashMessage('success', 'Welcome back, ' . $user['first_name'] . '!');
            redirect('index.php');
        } else {
            setFlashMessage('error', 'Invalid username or password');
            redirect('index.php?action=login');
        }
    }

    // Display registration form
    public function register() {
        if (isLoggedIn()) {
            redirect('index.php');
        }
        
        $this->router->renderView('views/auth/register.php');
    }

    // Handle registration
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=register');
        }
        
        $data = [
            'username' => sanitizeInput($_POST['username']),
            'email' => sanitizeInput($_POST['email']),
            'password_hash' => $_POST['password'], // Store plain text password for testing
            'first_name' => sanitizeInput($_POST['first_name']),
            'last_name' => sanitizeInput($_POST['last_name']),
            'phone' => sanitizeInput($_POST['phone']),
            'user_type' => 'customer',
            'driver_license_number' => sanitizeInput($_POST['driver_license_number']),
            'driver_license_expiry' => $_POST['driver_license_expiry']
        ];
        
        // Validation
        if (empty($data['username']) || empty($data['email']) || empty($data['first_name']) || empty($data['last_name'])) {
            setFlashMessage('error', 'Please fill in all required fields');
            redirect('index.php?action=register');
        }
        
        if (!$this->userModel->validateEmail($data['email'])) {
            setFlashMessage('error', 'Please enter a valid email address');
            redirect('index.php?action=register');
        }
        
        if ($this->userModel->emailExists($data['email'])) {
            setFlashMessage('error', 'Email address already exists');
            redirect('index.php?action=register');
        }
        
        if ($this->userModel->usernameExists($data['username'])) {
            setFlashMessage('error', 'Username already exists');
            redirect('index.php?action=register');
        }
        
        if (strlen($_POST['password']) < 6) {
            setFlashMessage('error', 'Password must be at least 6 characters long');
            redirect('index.php?action=register');
        }
        
        if ($_POST['password'] !== $_POST['confirm_password']) {
            setFlashMessage('error', 'Passwords do not match');
            redirect('index.php?action=register');
        }
        
        if ($this->userModel->create($data)) {
            setFlashMessage('success', 'Registration successful! Please log in.');
            redirect('index.php?action=login');
        } else {
            setFlashMessage('error', 'Registration failed. Please try again.');
            redirect('index.php?action=register');
        }
    }

    // Handle logout
    public function logout() {
        session_unset();
        session_destroy();
        setFlashMessage('success', 'You have been logged out successfully');
        redirect('index.php?action=login');
    }

    // Display profile
    public function profile() {
        requireLogin();
        
        $user = $this->userModel->getById($_SESSION['user_id']);
        $preferences = $this->userModel->getPreferences($_SESSION['user_id']);
        $loyalty = $this->userModel->getLoyaltyInfo($_SESSION['user_id']);
        
        $this->router->renderView('views/auth/profile.php', [
            'user' => $user,
            'preferences' => $preferences,
            'loyalty' => $loyalty
        ]);
    }

    // Update profile
    public function updateProfile() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=profile');
        }
        
        $data = [
            'first_name' => sanitizeInput($_POST['first_name']),
            'last_name' => sanitizeInput($_POST['last_name']),
            'phone' => sanitizeInput($_POST['phone']),
            'driver_license_number' => sanitizeInput($_POST['driver_license_number']),
            'driver_license_expiry' => $_POST['driver_license_expiry']
        ];
        
        if ($this->userModel->update($_SESSION['user_id'], $data)) {
            setFlashMessage('success', 'Profile updated successfully');
        } else {
            setFlashMessage('error', 'Failed to update profile');
        }
        
        redirect('index.php?action=profile');
    }

    // Update preferences
    public function updatePreferences() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=profile');
        }
        
        $data = [
            'favorite_car_type' => sanitizeInput($_POST['favorite_car_type']),
            'seat_position_preference' => sanitizeInput($_POST['seat_position_preference']),
            'preferred_pickup_location' => $_POST['preferred_pickup_location'] ?: null,
            'preferred_insurance_package' => $_POST['preferred_insurance_package'] ?: null
        ];
        
        if ($this->userModel->updatePreferences($_SESSION['user_id'], $data)) {
            setFlashMessage('success', 'Preferences updated successfully');
        } else {
            setFlashMessage('error', 'Failed to update preferences');
        }
        
        redirect('index.php?action=profile');
    }

    // Change password
    public function changePassword() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=profile');
        }
        
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $user = $this->userModel->getById($_SESSION['user_id']);
        if ($current_password !== $user['password_hash']) { // Compare plain text passwords
            setFlashMessage('error', 'Current password is incorrect');
            redirect('index.php?action=profile');
        }
        
        if (strlen($new_password) < 6) {
            setFlashMessage('error', 'New password must be at least 6 characters long');
            redirect('index.php?action=profile');
        }
        
        if ($new_password !== $confirm_password) {
            setFlashMessage('error', 'New passwords do not match');
            redirect('index.php?action=profile');
        }
        
        if ($this->userModel->updatePassword($_SESSION['user_id'], $new_password)) { // Store plain text password
            setFlashMessage('success', 'Password changed successfully');
        } else {
            setFlashMessage('error', 'Failed to change password');
        }
        
        redirect('index.php?action=profile');
    }

    // Forgot password (placeholder)
    public function forgotPassword() {
        $this->router->renderView('views/auth/forgot_password.php');
    }

    // Reset password (placeholder)
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=forgot_password');
        }
        
        $email = sanitizeInput($_POST['email']);
        
        if (!$this->userModel->validateEmail($email)) {
            setFlashMessage('error', 'Please enter a valid email address');
            redirect('index.php?action=forgot_password');
        }
        
        $user = $this->userModel->getByEmail($email);
        if (!$user) {
            setFlashMessage('error', 'Email address not found');
            redirect('index.php?action=forgot_password');
        }
        
        // TODO: Implement password reset functionality
        setFlashMessage('success', 'Password reset instructions sent to your email');
        redirect('index.php?action=login');
    }
}
?> 
<?php
require_once __DIR__ . '/../model/User.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}

$userModel = new User();
$userId = $_SESSION['user']['id'];

// Get user data
$user = $userModel->getUserById($userId);
$prefs = $userModel->getPreferences($userId);
$loyalty = $userModel->getLoyaltyInfo($userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add debug logging at the start
    error_log("Profile controller received POST request");
    
    if (isset($_POST['update_profile'])) {
        error_log("Processing profile update");
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        
        // Add validation
        if (empty($name) || empty($email)) {
            $_SESSION['error'] = 'Name and email are required';
        } else {
            if ($userModel->updateProfile($userId, $name, $email, $phone)) {
                $_SESSION['success'] = 'Profile updated successfully';
                // Update session data
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone'] = $phone;
                $user = $userModel->getUserById($userId);
            } else {
                error_log("Profile update failed for user $userId");
                $_SESSION['error'] = 'Failed to update profile. Please try again.';
            }
        }
    }
    elseif (isset($_POST['update_prefs'])) {
        error_log("Processing preferences update");
        $carType = $_POST['car_type'] ?? '';
        $seatPosition = $_POST['seat_position'] ?? '';
        $climateControl = $_POST['climate'] ?? '';
        
        if ($userModel->updatePreferences($userId, $carType, $seatPosition, $climateControl)) {
            $_SESSION['success'] = 'Preferences updated successfully';
            $prefs = $userModel->getPreferences($userId);
        } else {
            error_log("Preferences update failed for user $userId");
            $_SESSION['error'] = 'Failed to update preferences. Please try again.';
        }
    }
    elseif (isset($_POST['update_password'])) {
        error_log("Processing password update");
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'All password fields are required';
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'New passwords do not match';
        } elseif (!$userModel->verifyPassword($userId, $currentPassword)) {
            $_SESSION['error'] = 'Current password is incorrect';
        } else {
            if ($userModel->updatePassword($userId, $newPassword)) {
                $_SESSION['success'] = 'Password updated successfully';
            } else {
                error_log("Password update failed for user $userId");
                $_SESSION['error'] = 'Failed to update password. Please try again.';
            }
        }
    }
    elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        error_log("Processing avatar upload");
        $uploadDir = __DIR__ . '/../uploads/avatars/';
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                error_log("Failed to create upload directory: $uploadDir");
                $_SESSION['error'] = 'Server error: Could not create upload directory';
                header('Location: ?page=profile');
                exit;
            }
        }

        $fileName = $userId . '_' . time() . '_' . basename($_FILES['avatar']['name']);
        $targetPath = $uploadDir . $fileName;
        
        // Validate image
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($imageFileType, $allowedTypes)) {
            $_SESSION['error'] = 'Only JPG, JPEG, PNG & GIF files are allowed';
        } elseif ($_FILES['avatar']['size'] > $maxFileSize) {
            $_SESSION['error'] = 'File size must be less than 2MB';
        } elseif (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
            if ($userModel->updateAvatar($userId, $fileName)) {
                $_SESSION['success'] = 'Profile picture updated successfully';
                $_SESSION['user']['avatar_url'] = $fileName;
                $user = $userModel->getUserById($userId);
            } else {
                error_log("Avatar update failed for user $userId");
                $_SESSION['error'] = 'Failed to update profile picture in database';
                // Remove the uploaded file if database update failed
                if (file_exists($targetPath)) {
                    unlink($targetPath);
                }
            }
        } else {
            error_log("File upload failed. Error: " . $_FILES['avatar']['error']);
            $_SESSION['error'] = 'Error uploading file. Please try again.';
        }
    }

    header('Location: ?page=profile');
    exit;
}

// Include the view
include __DIR__ . '/../view/profile.php';
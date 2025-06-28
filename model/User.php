user.php

<?php
// model/User.php
 
class User {
    private $db;
 
    public function __construct() {
        $this->connectDB();
    }
 
    private function connectDB() {
        $this->db = new mysqli('localhost', 'root', '', 'webtech');
       
        if ($this->db->connect_error) {
            die("Database connection failed: " . $this->db->connect_error);
        }
    }
 
    /**
     * Register a new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool True if registration succeeded, false otherwise
     */

    public function signup($name, $email, $password) {
        // Check if email already exists
        if ($this->emailExists($email)) {
            return false;
        }
 
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
        // Prepare and execute the insert statement
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $result = $stmt->execute();
        $stmt->close();
 
        return $result;
    }
 
public function login($email, $password) {
    // Prepare and execute the select statement
    $stmt = $this->db->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify the password against the hashed version
        if (password_verify($password, $user['password'])) {
            // Password is correct, return user data (without password)
            unset($user['password']);
            return $user;
        }
    }
    
    $stmt->close();
    return false;
}
    /**
     * Check if email already exists in database
     * @param string $email
     * @return bool True if email exists, false otherwise
     */
    private function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
 
        return $exists;
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT id, name, email, phone, avatar_url, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
  
    public function updateProfile($userId, $name, $email, $phone) {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $userId);
        return $stmt->execute();
    }

    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        return $stmt->execute();
    }

    public function verifyPassword($userId, $password) {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return password_verify($password, $user['password']);
    }
 
    public function updateAvatar($userId, $avatarPath) {
        $stmt = $this->db->prepare("UPDATE users SET avatar_url = ? WHERE id = ?");
        $stmt->bind_param("si", $avatarPath, $userId);
        return $stmt->execute();
    }
    public function getPreferences($userId) {
        $stmt = $this->db->prepare("SELECT car_type, seat_position, climate_control FROM user_preferences WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
 
    public function updatePreferences($userId, $carType, $seatPosition, $climateControl) {
        $stmt = $this->db->prepare("REPLACE INTO user_preferences (user_id, car_type, seat_position, climate_control) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $carType, $seatPosition, $climateControl);
        return $stmt->execute();
    }
    public function getLoyaltyInfo($userId) {
        // This would come from your loyalty program system
        return [
            'tier' => 'Silver',
            'points' => 650,
            'progress' => 65,
            'next_tier_points' => 1000,
            'recent_activity' => [
                ['date' => '2023-05-15', 'description' => 'Weekend rental', 'points' => 50],
                ['date' => '2023-05-10', 'description' => 'Referral bonus', 'points' => 100],
                ['date' => '2023-05-01', 'description' => 'Monthly bonus', 'points' => 20]
            ]
        ];
    }
 
    // Close database connection when object is destroyed
    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
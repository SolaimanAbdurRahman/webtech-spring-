<?php
require_once 'config/database.php';

class User {
    private $db;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get user by ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Get user by email
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Get user by username
    public function getByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Create new user
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (
                    username, email, password_hash, first_name, last_name, 
                    phone, user_type, driver_license_number, driver_license_expiry
                ) VALUES (
                    :username, :email, :password_hash, :first_name, :last_name,
                    :phone, :user_type, :driver_license_number, :driver_license_expiry
                )";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Update user
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                    first_name = :first_name, last_name = :last_name,
                    phone = :phone, driver_license_number = :driver_license_number,
                    driver_license_expiry = :driver_license_expiry
                WHERE user_id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Update password
    public function updatePassword($id, $password_hash) {
        $sql = "UPDATE {$this->table} SET password_hash = :password_hash WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Authenticate user
    public function authenticate($username, $password) {
        $user = $this->getByUsername($username);
        if (!$user) {
            $user = $this->getByEmail($username);
        }
        
        if ($user && $password === $user['password_hash']) { // Compare plain text passwords
            return $user;
        }
        return false;
    }

    // Get user preferences
    public function getPreferences($user_id) {
        $sql = "SELECT * FROM customer_preferences WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Update user preferences
    public function updatePreferences($user_id, $data) {
        // Convert empty strings to null for foreign key fields
        $data['preferred_pickup_location'] = !empty($data['preferred_pickup_location']) ? $data['preferred_pickup_location'] : null;
        $data['preferred_insurance_package'] = !empty($data['preferred_insurance_package']) ? $data['preferred_insurance_package'] : null;
        
        // Check if preferences record exists
        $existing = $this->getPreferences($user_id);
        
        if ($existing) {
            // Update existing record
            $sql = "UPDATE customer_preferences SET 
                        favorite_car_type = :favorite_car_type,
                        seat_position_preference = :seat_position_preference,
                        preferred_pickup_location = :preferred_pickup_location,
                        preferred_insurance_package = :preferred_insurance_package,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE user_id = :user_id";
        } else {
            // Insert new record
            $sql = "INSERT INTO customer_preferences (
                        user_id, favorite_car_type, seat_position_preference,
                        preferred_pickup_location, preferred_insurance_package
                    ) VALUES (
                        :user_id, :favorite_car_type, :seat_position_preference,
                        :preferred_pickup_location, :preferred_insurance_package
                    )";
        }
        
        $data['user_id'] = $user_id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Get loyalty info
    public function getLoyaltyInfo($user_id) {
        $sql = "SELECT * FROM loyalty_program WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add loyalty points
    public function addLoyaltyPoints($user_id, $points, $booking_id = null) {
        // Get or create loyalty record
        $loyalty = $this->getLoyaltyInfo($user_id);
        if (!$loyalty) {
            $sql = "INSERT INTO loyalty_program (user_id, points_balance) VALUES (:user_id, :points)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':points', $points);
            return $stmt->execute();
        } else {
            $sql = "UPDATE loyalty_program SET points_balance = points_balance + :points WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':user_id', $user_id);
            return $stmt->execute();
        }
    }

    // Validate email format
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Check if email exists
    public function emailExists($email, $exclude_id = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        if ($exclude_id) {
            $sql .= " AND user_id != :exclude_id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        if ($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Check if username exists
    public function usernameExists($username, $exclude_id = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = :username";
        if ($exclude_id) {
            $sql .= " AND user_id != :exclude_id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?> 
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
 
    // Close database connection when object is destroyed
    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
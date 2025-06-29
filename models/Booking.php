<?php
require_once 'config/database.php';

class Booking {
    private $db;
    private $table = 'bookings';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get all bookings
    public function getAll() {
        $sql = "SELECT b.*, v.make, v.model, u.first_name, u.last_name 
                FROM {$this->table} b 
                LEFT JOIN vehicles v ON b.vehicle_id = v.vehicle_id 
                LEFT JOIN users u ON b.user_id = u.user_id 
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get booking by ID
    public function getById($id) {
        $sql = "SELECT b.*, 
                       v.make, v.model, v.year, v.vin, v.daily_rate,
                       u.first_name, u.last_name,
                       pl.location_name as pickup_location_name,
                       rl.location_name as return_location_name,
                       ip.package_name as insurance_package_name,
                       ip.daily_rate as insurance_daily_rate
                FROM {$this->table} b 
                LEFT JOIN vehicles v ON b.vehicle_id = v.vehicle_id 
                LEFT JOIN users u ON b.user_id = u.user_id 
                LEFT JOIN pickup_locations pl ON b.pickup_location_id = pl.location_id
                LEFT JOIN pickup_locations rl ON b.return_location_id = rl.location_id
                LEFT JOIN insurance_packages ip ON b.insurance_package_id = ip.package_id
                WHERE b.booking_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Get user bookings
    public function getUserBookings($user_id) {
        $sql = "SELECT b.*, v.make, v.model, v.year 
                FROM {$this->table} b 
                LEFT JOIN vehicles v ON b.vehicle_id = v.vehicle_id 
                WHERE b.user_id = :user_id 
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create booking
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (
                    user_id, vehicle_id, pickup_location_id, return_location_id,
                    pickup_date, return_date, total_amount, insurance_package_id
                ) VALUES (
                    :user_id, :vehicle_id, :pickup_location_id, :return_location_id,
                    :pickup_date, :return_date, :total_amount, :insurance_package_id
                )";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Update booking status
    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status WHERE booking_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Calculate booking total
    public function calculateTotal($vehicle_id, $pickup_date, $return_date, $insurance_id = null) {
        // Get vehicle daily rate
        $vehicle_sql = "SELECT daily_rate FROM vehicles WHERE vehicle_id = :vehicle_id";
        $vehicle_stmt = $this->db->prepare($vehicle_sql);
        $vehicle_stmt->bindParam(':vehicle_id', $vehicle_id);
        $vehicle_stmt->execute();
        $vehicle = $vehicle_stmt->fetch();

        if (!$vehicle) return 0;

        // Calculate days
        $start = new DateTime($pickup_date);
        $end = new DateTime($return_date);
        $days = $end->diff($start)->days + 1;

        // Base cost
        $base_cost = $vehicle['daily_rate'] * $days;

        // Insurance cost
        $insurance_cost = 0;
        if ($insurance_id) {
            $insurance_sql = "SELECT daily_rate FROM insurance_packages WHERE package_id = :insurance_id";
            $insurance_stmt = $this->db->prepare($insurance_sql);
            $insurance_stmt->bindParam(':insurance_id', $insurance_id);
            $insurance_stmt->execute();
            $insurance = $insurance_stmt->fetch();
            if ($insurance) {
                $insurance_cost = $insurance['daily_rate'] * $days;
            }
        }

        // Calculate tax (8%)
        $subtotal = $base_cost + $insurance_cost;
        $tax = $subtotal * 0.08;

        return $subtotal + $tax;
    }

    // Check vehicle availability
    public function isVehicleAvailable($vehicle_id, $pickup_date, $return_date) {
        $sql = "SELECT COUNT(*) FROM {$this->table} 
                WHERE vehicle_id = :vehicle_id 
                AND status IN ('confirmed', 'active') 
                AND (
                    (pickup_date <= :return_date AND return_date >= :pickup_date)
                    OR (pickup_date BETWEEN :pickup_date AND :return_date)
                    OR (return_date BETWEEN :pickup_date AND :return_date)
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':vehicle_id', $vehicle_id);
        $stmt->bindParam(':pickup_date', $pickup_date);
        $stmt->bindParam(':return_date', $return_date);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 0;
    }

    // Get booking statistics
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_bookings,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_bookings,
                    COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_bookings,
                    COUNT(CASE WHEN status = 'active' THEN 1 END) as active_bookings,
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_bookings,
                    SUM(total_amount) as total_revenue
                FROM {$this->table}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?> 
<?php
require_once 'config/database.php';

class Vehicle {
    private $db;
    private $table = 'vehicles';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get all vehicles with optional filters
    public function getAll($filters = []) {
        $sql = "SELECT v.*, c.category_name 
                FROM {$this->table} v 
                LEFT JOIN vehicle_categories c ON v.category_id = c.category_id";
        
        $whereConditions = [];
        $params = [];

        if (!empty($filters['category_id'])) {
            $whereConditions[] = "v.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }

        if (!empty($filters['transmission'])) {
            $whereConditions[] = "v.transmission = :transmission";
            $params[':transmission'] = $filters['transmission'];
        }

        if (!empty($filters['fuel_type'])) {
            $whereConditions[] = "v.fuel_type = :fuel_type";
            $params[':fuel_type'] = $filters['fuel_type'];
        }

        if (!empty($filters['price_min'])) {
            $whereConditions[] = "v.daily_rate >= :price_min";
            $params[':price_min'] = $filters['price_min'];
        }

        if (!empty($filters['price_max'])) {
            $whereConditions[] = "v.daily_rate <= :price_max";
            $params[':price_max'] = $filters['price_max'];
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(' AND ', $whereConditions);
        }

        $sql .= " ORDER BY v.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Get vehicle by ID
    public function getById($id) {
        $sql = "SELECT v.*, c.category_name FROM {$this->table} v 
                LEFT JOIN vehicle_categories c ON v.category_id = c.category_id 
                WHERE v.vehicle_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Get available vehicles
    public function getAvailable($pickup_date, $return_date) {
        $sql = "SELECT v.*, c.category_name FROM {$this->table} v 
                LEFT JOIN vehicle_categories c ON v.category_id = c.category_id 
                WHERE v.status = 'available'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create new vehicle
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (vin, category_id, make, model, year, daily_rate) 
                VALUES (:vin, :category_id, :make, :model, :year, :daily_rate)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Update vehicle
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET make = :make, model = :model, daily_rate = :daily_rate 
                WHERE vehicle_id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Update status
    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status WHERE vehicle_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete vehicle
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE vehicle_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Update fuel level
    public function updateFuelLevel($id, $fuel_level) {
        $sql = "UPDATE {$this->table} SET current_fuel_level = :fuel_level, updated_at = CURRENT_TIMESTAMP WHERE vehicle_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fuel_level', $fuel_level);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get vehicle images
    public function getImages($vehicle_id) {
        $sql = "SELECT * FROM vehicle_images WHERE vehicle_id = :vehicle_id ORDER BY is_primary DESC, image_id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':vehicle_id', $vehicle_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add vehicle image
    public function addImage($vehicle_id, $image_path, $image_type = 'main', $is_primary = false) {
        $sql = "INSERT INTO vehicle_images (vehicle_id, image_path, image_type, is_primary) VALUES (:vehicle_id, :image_path, :image_type, :is_primary)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':vehicle_id' => $vehicle_id,
            ':image_path' => $image_path,
            ':image_type' => $image_type,
            ':is_primary' => $is_primary
        ]);
    }

    // Get vehicle statistics
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_vehicles,
                    COUNT(CASE WHEN status = 'available' THEN 1 END) as available_vehicles,
                    COUNT(CASE WHEN status = 'rented' THEN 1 END) as rented_vehicles,
                    COUNT(CASE WHEN status = 'maintenance' THEN 1 END) as maintenance_vehicles,
                    AVG(daily_rate) as avg_daily_rate
                FROM {$this->table}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Validate VIN
    public function validateVIN($vin) {
        // Basic VIN validation (17 characters, alphanumeric)
        return strlen($vin) === 17 && ctype_alnum($vin);
    }

    // Check if VIN exists
    public function vinExists($vin, $exclude_id = null) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE vin = :vin";
        if ($exclude_id) {
            $sql .= " AND vehicle_id != :exclude_id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':vin', $vin);
        if ($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?> 
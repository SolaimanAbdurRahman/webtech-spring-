<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting vehicle check...\n";

require_once 'config/database.php';

echo "Database config loaded...\n";

$database = new Database();
$db = $database->getConnection();

echo "Database connection established...\n";

echo "=== VEHICLES IN DATABASE ===\n\n";

// Check total count
$total = $db->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();
echo "Total vehicles in database: $total\n\n";

if ($total > 0) {
    // Get all vehicles
    $vehicles = $db->query("SELECT * FROM vehicles ORDER BY vehicle_id")->fetchAll();
    
    echo "=== VEHICLE LIST ===\n";
    foreach ($vehicles as $vehicle) {
        echo "ID: {$vehicle['vehicle_id']} | ";
        echo "License: {$vehicle['license_plate']} | ";
        echo "Make: {$vehicle['make']} | ";
        echo "Model: {$vehicle['model']} | ";
        echo "Year: {$vehicle['year']} | ";
        echo "Category: {$vehicle['category_id']} | ";
        echo "Status: {$vehicle['status']} | ";
        echo "Rate: \${$vehicle['daily_rate']}/day\n";
    }
    
    echo "\n=== VEHICLES BY CATEGORY ===\n";
    $categories = $db->query("
        SELECT c.category_name, COUNT(v.vehicle_id) as count
        FROM vehicle_categories c 
        LEFT JOIN vehicles v ON c.category_id = v.category_id 
        GROUP BY c.category_id, c.category_name
        ORDER BY c.category_id
    ")->fetchAll();
    
    foreach ($categories as $category) {
        echo "{$category['category_name']}: {$category['count']} vehicles\n";
    }
    
    echo "\n=== VEHICLES BY STATUS ===\n";
    $statuses = $db->query("
        SELECT status, COUNT(*) as count
        FROM vehicles 
        GROUP BY status
        ORDER BY status
    ")->fetchAll();
    
    foreach ($statuses as $status) {
        echo "{$status['status']}: {$status['count']} vehicles\n";
    }
    
} else {
    echo "No vehicles found in database!\n";
}

echo "\n=== DATABASE CONNECTION TEST ===\n";
try {
    $test = $db->query("SELECT 1")->fetchColumn();
    echo "Database connection: ✅ Working\n";
} catch (Exception $e) {
    echo "Database connection: ❌ Error - " . $e->getMessage() . "\n";
}

echo "\n=== TABLE STRUCTURE ===\n";
try {
    $columns = $db->query("DESCRIBE vehicles")->fetchAll();
    echo "Vehicles table columns:\n";
    foreach ($columns as $column) {
        echo "  - {$column['Field']} ({$column['Type']})\n";
    }
} catch (Exception $e) {
    echo "Error checking table structure: " . $e->getMessage() . "\n";
}

echo "\nScript completed.\n";
?> 
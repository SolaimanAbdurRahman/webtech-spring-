<?php
require_once 'models/Vehicle.php';
require_once 'includes/session.php';

class VehicleController {
    private $vehicleModel;
    private $router;

    public function __construct() {
        $this->vehicleModel = new Vehicle();
        $this->router = new Router();
    }

    // Display vehicle inventory
    public function index() {
        $filters = [];
        
        // Handle all filter parameters from the form
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $filters['category_id'] = $_GET['category'];
        }
        
        if (isset($_GET['transmission']) && !empty($_GET['transmission'])) {
            $filters['transmission'] = $_GET['transmission'];
        }
        
        if (isset($_GET['fuel_type']) && !empty($_GET['fuel_type'])) {
            $filters['fuel_type'] = $_GET['fuel_type'];
        }
        
        if (isset($_GET['price_min']) && !empty($_GET['price_min'])) {
            $filters['price_min'] = $_GET['price_min'];
        }
        
        if (isset($_GET['price_max']) && !empty($_GET['price_max'])) {
            $filters['price_max'] = $_GET['price_max'];
        }
        
        $vehicles = $this->vehicleModel->getAll($filters);
        
        // Get categories for filter
        $database = new Database();
        $db = $database->getConnection();
        $categories = $db->query("SELECT * FROM vehicle_categories")->fetchAll();
        
        $this->router->renderView('views/vehicles/index.php', [
            'vehicles' => $vehicles,
            'categories' => $categories
        ]);
    }

    // Display vehicle details
    public function show($id) {
        $vehicle = $this->vehicleModel->getById($id);
        
        if (!$vehicle) {
            setFlashMessage('error', 'Vehicle not found');
            redirect('index.php?action=vehicles');
        }
        
        $this->router->renderView('views/vehicles/show.php', [
            'vehicle' => $vehicle
        ]);
    }

    // Display vehicle creation form (admin only)
    public function create() {
        requireStaff();
        
        $database = new Database();
        $db = $database->getConnection();
        $categories = $db->query("SELECT * FROM vehicle_categories")->fetchAll();
        
        $this->router->renderView('views/vehicles/create.php', [
            'categories' => $categories
        ]);
    }

    // Handle vehicle creation
    public function store() {
        requireStaff();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=vehicles');
        }
        
        $data = [
            'vin' => sanitizeInput($_POST['vin']),
            'category_id' => $_POST['category_id'],
            'make' => sanitizeInput($_POST['make']),
            'model' => sanitizeInput($_POST['model']),
            'year' => $_POST['year'],
            'daily_rate' => $_POST['daily_rate']
        ];
        
        // Validation
        if (empty($data['vin']) || empty($data['make']) || empty($data['model'])) {
            setFlashMessage('error', 'Please fill in all required fields');
            redirect('index.php?action=vehicle_create');
        }
        
        if (!$this->vehicleModel->validateVIN($data['vin'])) {
            setFlashMessage('error', 'Invalid VIN format');
            redirect('index.php?action=vehicle_create');
        }
        
        if ($this->vehicleModel->vinExists($data['vin'])) {
            setFlashMessage('error', 'VIN already exists');
            redirect('index.php?action=vehicle_create');
        }
        
        if ($this->vehicleModel->create($data)) {
            setFlashMessage('success', 'Vehicle created successfully');
        } else {
            setFlashMessage('error', 'Failed to create vehicle');
        }
        
        redirect('index.php?action=vehicles');
    }

    // Display vehicle edit form
    public function edit($id) {
        requireStaff();
        
        $vehicle = $this->vehicleModel->getById($id);
        
        if (!$vehicle) {
            setFlashMessage('error', 'Vehicle not found');
            redirect('index.php?action=vehicles');
        }
        
        $database = new Database();
        $db = $database->getConnection();
        $categories = $db->query("SELECT * FROM vehicle_categories")->fetchAll();
        
        $this->router->renderView('views/vehicles/edit.php', [
            'vehicle' => $vehicle,
            'categories' => $categories
        ]);
    }

    // Handle vehicle update
    public function update($id) {
        requireStaff();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=vehicles');
        }
        
        $data = [
            'make' => sanitizeInput($_POST['make']),
            'model' => sanitizeInput($_POST['model']),
            'daily_rate' => $_POST['daily_rate']
        ];
        
        if ($this->vehicleModel->update($id, $data)) {
            setFlashMessage('success', 'Vehicle updated successfully');
        } else {
            setFlashMessage('error', 'Failed to update vehicle');
        }
        
        redirect('index.php?action=vehicles');
    }

    // Handle vehicle deletion
    public function delete($id) {
        requireStaff();
        
        if ($this->vehicleModel->delete($id)) {
            setFlashMessage('success', 'Vehicle deleted successfully');
        } else {
            setFlashMessage('error', 'Failed to delete vehicle');
        }
        
        redirect('index.php?action=vehicles');
    }

    // Get available vehicles for booking
    public function getAvailable() {
        $pickup_date = $_GET['pickup_date'] ?? '';
        $return_date = $_GET['return_date'] ?? '';
        
        if (!$pickup_date || !$return_date) {
            echo json_encode(['error' => 'Pickup and return dates are required']);
            return;
        }
        
        $vehicles = $this->vehicleModel->getAvailable($pickup_date, $return_date);
        echo json_encode($vehicles);
    }

    // Update vehicle status
    public function updateStatus() {
        requireStaff();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=vehicles');
        }
        
        $id = $_POST['vehicle_id'];
        $status = $_POST['status'];
        
        if ($this->vehicleModel->updateStatus($id, $status)) {
            setFlashMessage('success', 'Vehicle status updated');
        } else {
            setFlashMessage('error', 'Failed to update vehicle status');
        }
        
        redirect('index.php?action=vehicles');
    }
}
?> 
<?php
require_once 'models/Booking.php';
require_once 'models/Vehicle.php';
require_once 'includes/session.php';

class BookingController {
    private $bookingModel;
    private $vehicleModel;
    private $router;

    public function __construct() {
        $this->bookingModel = new Booking();
        $this->vehicleModel = new Vehicle();
        $this->router = new Router();
    }

    // Display booking form
    public function create() {
        requireLogin();
        
        $pickup_date = $_GET['pickup_date'] ?? '';
        $return_date = $_GET['return_date'] ?? '';
        $vehicle_id = $_GET['vehicle_id'] ?? '';
        
        // Get all available vehicles (not just based on dates)
        $vehicles = $this->vehicleModel->getAll(['status' => 'available']);
        
        // If dates are provided, filter vehicles for availability
        if ($pickup_date && $return_date) {
            $available_vehicles = $this->vehicleModel->getAvailable($pickup_date, $return_date);
            $available_ids = array_column($available_vehicles, 'vehicle_id');
            $vehicles = array_filter($vehicles, function($vehicle) use ($available_ids) {
                return in_array($vehicle['vehicle_id'], $available_ids);
            });
        }
        
        // Get pickup locations
        $database = new Database();
        $db = $database->getConnection();
        $locations = $db->query("SELECT * FROM pickup_locations WHERE is_active = 1")->fetchAll();
        $insurance_packages = $db->query("SELECT * FROM insurance_packages WHERE is_active = 1")->fetchAll();
        
        $this->router->renderView('views/bookings/create.php', [
            'vehicles' => $vehicles,
            'locations' => $locations,
            'insurance_packages' => $insurance_packages,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'vehicle_id' => $vehicle_id
        ]);
    }

    // Handle booking creation
    public function store() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=booking');
        }
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'vehicle_id' => $_POST['vehicle_id'],
            'pickup_location_id' => $_POST['pickup_location_id'],
            'return_location_id' => $_POST['return_location_id'],
            'pickup_date' => $_POST['pickup_date'],
            'return_date' => $_POST['return_date'],
            'insurance_package_id' => $_POST['insurance_package_id'] ?: null
        ];
        
        // Calculate total amount
        $data['total_amount'] = $this->bookingModel->calculateTotal(
            $data['vehicle_id'],
            $data['pickup_date'],
            $data['return_date'],
            $data['insurance_package_id']
        );
        
        // Validation
        if (empty($data['vehicle_id']) || empty($data['pickup_date']) || empty($data['return_date'])) {
            setFlashMessage('error', 'Please fill in all required fields');
            redirect('index.php?action=booking');
        }
        
        // Check vehicle availability
        if (!$this->bookingModel->isVehicleAvailable($data['vehicle_id'], $data['pickup_date'], $data['return_date'])) {
            setFlashMessage('error', 'Selected vehicle is not available for the chosen dates');
            redirect('index.php?action=booking');
        }
        
        if ($this->bookingModel->create($data)) {
            setFlashMessage('success', 'Booking created successfully');
            redirect('index.php?action=bookings');
        } else {
            setFlashMessage('error', 'Failed to create booking');
            redirect('index.php?action=booking');
        }
    }

    // Display user bookings
    public function index() {
        requireLogin();
        
        $bookings = $this->bookingModel->getUserBookings($_SESSION['user_id']);
        $this->router->renderView('views/bookings/index.php', [
            'bookings' => $bookings
        ]);
    }

    // Display booking details
    public function show($id) {
        requireLogin();
        
        $booking = $this->bookingModel->getById($id);
        
        if (!$booking) {
            setFlashMessage('error', 'Booking not found');
            redirect('index.php?action=bookings');
        }
        
        // Check if user owns this booking or is staff
        if ($booking['user_id'] != $_SESSION['user_id'] && !isStaff()) {
            setFlashMessage('error', 'Unauthorized access');
            redirect('index.php?action=bookings');
        }
        
        $this->router->renderView('views/bookings/show.php', [
            'booking' => $booking
        ]);
    }

    // Cancel booking
    public function cancel($id) {
        requireLogin();
        
        $booking = $this->bookingModel->getById($id);
        
        if (!$booking) {
            setFlashMessage('error', 'Booking not found');
            redirect('index.php?action=bookings');
        }
        
        // Check if user owns this booking or is staff
        if ($booking['user_id'] != $_SESSION['user_id'] && !isStaff()) {
            setFlashMessage('error', 'Unauthorized access');
            redirect('index.php?action=bookings');
        }
        
        // Only allow cancellation of pending or confirmed bookings
        if (!in_array($booking['status'], ['pending', 'confirmed'])) {
            setFlashMessage('error', 'Cannot cancel this booking');
            redirect('index.php?action=bookings');
        }
        
        if ($this->bookingModel->updateStatus($id, 'cancelled')) {
            setFlashMessage('success', 'Booking cancelled successfully');
        } else {
            setFlashMessage('error', 'Failed to cancel booking');
        }
        
        redirect('index.php?action=bookings');
    }

    // Calculate booking quote (AJAX)
    public function calculateQuote() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }
        
        $vehicle_id = $_POST['vehicle_id'] ?? '';
        $pickup_date = $_POST['pickup_date'] ?? '';
        $return_date = $_POST['return_date'] ?? '';
        $insurance_id = $_POST['insurance_id'] ?? null;
        
        if (!$vehicle_id || !$pickup_date || !$return_date) {
            echo json_encode(['error' => 'Missing required parameters']);
            return;
        }
        
        $total = $this->bookingModel->calculateTotal($vehicle_id, $pickup_date, $return_date, $insurance_id);
        
        echo json_encode([
            'total' => $total,
            'formatted_total' => formatCurrency($total)
        ]);
    }

    // Get available vehicles (AJAX)
    public function getAvailableVehicles() {
        $pickup_date = $_GET['pickup_date'] ?? '';
        $return_date = $_GET['return_date'] ?? '';
        $category_id = $_GET['category_id'] ?? null;
        
        if (!$pickup_date || !$return_date) {
            echo json_encode(['error' => 'Pickup and return dates are required']);
            return;
        }
        
        $vehicles = $this->vehicleModel->getAvailable($pickup_date, $return_date);
        
        if ($category_id) {
            $vehicles = array_filter($vehicles, function($vehicle) use ($category_id) {
                return $vehicle['category_id'] == $category_id;
            });
        }
        
        echo json_encode($vehicles);
    }

    // Admin: Display all bookings
    public function adminIndex() {
        requireStaff();
        
        $bookings = $this->bookingModel->getAll();
        $this->router->renderView('views/admin/bookings/index.php', [
            'bookings' => $bookings
        ]);
    }

    // Admin: Update booking status
    public function adminUpdateStatus() {
        requireStaff();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=admin_bookings');
        }
        
        $booking_id = $_POST['booking_id'];
        $status = $_POST['status'];
        
        if ($this->bookingModel->updateStatus($booking_id, $status)) {
            setFlashMessage('success', 'Booking status updated successfully');
        } else {
            setFlashMessage('error', 'Failed to update booking status');
        }
        
        redirect('index.php?action=admin_bookings');
    }
}
?> 
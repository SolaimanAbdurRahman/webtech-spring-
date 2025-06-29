<?php
require_once 'includes/session.php';

class Router {
    private $routes = [];
    
    public function __construct() {
        $this->initializeRoutes();
    }
    
    private function initializeRoutes() {
        // Auth routes
        $this->routes['login'] = ['AuthController', 'login'];
        $this->routes['authenticate'] = ['AuthController', 'authenticate'];
        $this->routes['register'] = ['AuthController', 'register'];
        $this->routes['store'] = ['AuthController', 'store'];
        $this->routes['logout'] = ['AuthController', 'logout'];
        $this->routes['profile'] = ['AuthController', 'profile'];
        $this->routes['update_profile'] = ['AuthController', 'updateProfile'];
        $this->routes['update_preferences'] = ['AuthController', 'updatePreferences'];
        $this->routes['change_password'] = ['AuthController', 'changePassword'];
        $this->routes['forgot_password'] = ['AuthController', 'forgotPassword'];
        $this->routes['reset_password'] = ['AuthController', 'resetPassword'];
        
        // Vehicle routes
        $this->routes['vehicles'] = ['VehicleController', 'index'];
        $this->routes['vehicle_show'] = ['VehicleController', 'show'];
        $this->routes['vehicle_create'] = ['VehicleController', 'create'];
        $this->routes['vehicle_store'] = ['VehicleController', 'store'];
        $this->routes['vehicle_edit'] = ['VehicleController', 'edit'];
        $this->routes['vehicle_update'] = ['VehicleController', 'update'];
        $this->routes['vehicle_delete'] = ['VehicleController', 'delete'];
        $this->routes['vehicle_available'] = ['VehicleController', 'getAvailable'];
        $this->routes['vehicle_status'] = ['VehicleController', 'updateStatus'];
        
        // Booking routes
        $this->routes['booking'] = ['BookingController', 'create'];
        $this->routes['booking_store'] = ['BookingController', 'store'];
        $this->routes['bookings'] = ['BookingController', 'index'];
        $this->routes['booking_show'] = ['BookingController', 'show'];
        $this->routes['booking_cancel'] = ['BookingController', 'cancel'];
        $this->routes['booking_quote'] = ['BookingController', 'calculateQuote'];
        $this->routes['booking_vehicles'] = ['BookingController', 'getAvailableVehicles'];
        $this->routes['admin_bookings'] = ['BookingController', 'adminIndex'];
        $this->routes['admin_booking_status'] = ['BookingController', 'adminUpdateStatus'];
        
        // Page routes
        $this->routes['locations'] = ['PageController', 'locations'];
        $this->routes['pricing'] = ['PageController', 'pricing'];
        $this->routes['insurance'] = ['PageController', 'insurance'];
        $this->routes['loyalty'] = ['PageController', 'loyalty'];
        $this->routes['damage_report'] = ['PageController', 'damageReport'];
        $this->routes['fuel'] = ['PageController', 'fuel'];
        $this->routes['maintenance'] = ['PageController', 'maintenance'];
    }
    
    public function route($action, $params = []) {
        if (!isset($this->routes[$action])) {
            // Default to index page
            $this->renderView('views/index.php');
            return;
        }
        
        $controllerName = $this->routes[$action][0];
        $methodName = $this->routes[$action][1];
        
        require_once "controllers/{$controllerName}.php";
        $controller = new $controllerName();
        
        if (method_exists($controller, $methodName)) {
            if (!empty($params)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                $controller->$methodName();
            }
        } else {
            setFlashMessage('error', 'Method not found');
            redirect('index.php');
        }
    }
    
    public function renderView($viewPath, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include $viewPath;
        
        // Get the buffered content
        $content = ob_get_clean();
        
        // Include the layout
        include 'views/layout.php';
    }
    
    public function dispatch() {
        $action = $_GET['action'] ?? 'index';
        $id = $_GET['id'] ?? null;
        
        $params = [];
        if ($id) {
            $params[] = $id;
        }
        
        $this->route($action, $params);
    }
}

// Helper function to generate URLs
function url($action, $params = []) {
    $url = "index.php?action={$action}";
    
    foreach ($params as $key => $value) {
        $url .= "&{$key}={$value}";
    }
    
    return $url;
}

// Helper function to redirect with action
function redirectTo($action, $params = []) {
    redirect(url($action, $params));
}
?> 
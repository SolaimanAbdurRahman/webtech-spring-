<?php
require_once 'includes/session.php';

class PageController {
    private $router;

    public function __construct() {
        $this->router = new Router();
    }

    // Locations page
    public function locations() {
        $this->router->renderView('views/pages/locations.php');
    }

    // Pricing page
    public function pricing() {
        $this->router->renderView('views/pages/pricing.php');
    }

    // Insurance page
    public function insurance() {
        $this->router->renderView('views/pages/insurance.php');
    }

    // Loyalty page
    public function loyalty() {
        $this->router->renderView('views/pages/loyalty.php');
    }

    // Damage report page
    public function damageReport() {
        $this->router->renderView('views/pages/damage_report.php');
    }

    // Fuel tracking page
    public function fuel() {
        $this->router->renderView('views/pages/fuel.php');
    }

    // Maintenance page
    public function maintenance() {
        $this->router->renderView('views/pages/maintenance.php');
    }
}
?> 
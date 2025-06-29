<?php
$pageTitle = "Car Rental System - Home";
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="jumbotron bg-light p-5 rounded">
                <h1 class="display-4">Welcome to CarRental Pro</h1>
                <p class="lead">Your trusted partner for reliable and affordable car rentals. Choose from our wide selection of vehicles and enjoy a seamless rental experience.</p>
                <hr class="my-4">
                <p>Ready to start your journey? Browse our available vehicles and make a reservation today.</p>
                <a class="btn btn-primary btn-lg" href="index.php?action=vehicles" role="button">Browse Vehicles</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="index.php?action=booking" class="btn btn-outline-primary">Make a Booking</a>
                        <a href="index.php?action=locations" class="btn btn-outline-secondary">View Locations</a>
                        <a href="index.php?action=pricing" class="btn btn-outline-info">Check Pricing</a>
                        <?php if (!isLoggedIn()): ?>
                            <a href="index.php?action=login" class="btn btn-outline-success">Login</a>
                            <a href="index.php?action=register" class="btn btn-outline-warning">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-car fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Wide Vehicle Selection</h5>
                    <p class="card-text">Choose from economy cars, SUVs, luxury vehicles, and more to suit your needs.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-map-marker-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Multiple Locations</h5>
                    <p class="card-text">Pick up and drop off at convenient locations across the city.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Full Insurance Coverage</h5>
                    <p class="card-text">Comprehensive insurance options to give you peace of mind.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html> 
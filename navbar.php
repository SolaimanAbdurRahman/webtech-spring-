<?php
if (!isset($currentUser)) {
    require_once 'includes/session.php';
    $currentUser = getCurrentUser();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-car"></i> CarRental Pro
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php?action=vehicles">Vehicles</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=booking">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=locations">Locations</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=pricing">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=insurance">Insurance</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=loyalty">Loyalty</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=profile">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($currentUser['first_name']); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=bookings">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 
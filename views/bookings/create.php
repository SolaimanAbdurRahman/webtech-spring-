<?php
$pageTitle = "Create Booking - Car Rental System";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Create New Booking</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['flash_messages'])): ?>
                        <?php foreach ($_SESSION['flash_messages'] as $type => $message): ?>
                            <div class="alert alert-<?php echo $type; ?> alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['flash_messages']); ?>
                    <?php endif; ?>

                    <form action="index.php?action=booking_store" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date & Time *</label>
                                <input type="datetime-local" class="form-control" id="pickup_date" name="pickup_date" 
                                       value="<?php echo htmlspecialchars($pickup_date); ?>" required>
                                <div class="invalid-feedback">
                                    Please select pickup date and time.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">Return Date & Time *</label>
                                <input type="datetime-local" class="form-control" id="return_date" name="return_date" 
                                       value="<?php echo htmlspecialchars($return_date); ?>" required>
                                <div class="invalid-feedback">
                                    Please select return date and time.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_location_id" class="form-label">Pickup Location *</label>
                                <select class="form-select" id="pickup_location_id" name="pickup_location_id" required>
                                    <option value="">Select Pickup Location</option>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['location_id']; ?>">
                                            <?php echo htmlspecialchars($location['location_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select pickup location.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_location_id" class="form-label">Return Location *</label>
                                <select class="form-select" id="return_location_id" name="return_location_id" required>
                                    <option value="">Select Return Location</option>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['location_id']; ?>">
                                            <?php echo htmlspecialchars($location['location_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select return location.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vehicle_id" class="form-label">Select Vehicle *</label>
                                <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                                    <option value="">Select Vehicle</option>
                                    <?php if (!empty($vehicles)): ?>
                                        <?php foreach ($vehicles as $vehicle): ?>
                                            <option value="<?php echo $vehicle['vehicle_id']; ?>" 
                                                    data-daily-rate="<?php echo $vehicle['daily_rate']; ?>"
                                                    <?php echo ($vehicle_id == $vehicle['vehicle_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model'] . ' (' . $vehicle['year'] . ')'); ?> - 
                                                $<?php echo number_format($vehicle['daily_rate'], 2); ?>/day
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a vehicle.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="insurance_package_id" class="form-label">Insurance Package</label>
                                <select class="form-select" id="insurance_package_id" name="insurance_package_id">
                                    <option value="">No Insurance</option>
                                    <?php foreach ($insurance_packages as $package): ?>
                                        <option value="<?php echo $package['package_id']; ?>" 
                                                data-daily-rate="<?php echo $package['daily_rate']; ?>">
                                            <?php echo htmlspecialchars($package['package_name']); ?> - 
                                            $<?php echo number_format($package['daily_rate'], 2); ?>/day
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Vehicle Selection Cards -->
                        <?php if (!empty($vehicles)): ?>
                        <div class="mb-4">
                            <h5>Available Vehicles</h5>
                            <div class="row">
                                <?php foreach ($vehicles as $vehicle): ?>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card vehicle-option h-100" data-vehicle-id="<?php echo $vehicle['vehicle_id']; ?>" data-daily-rate="<?php echo $vehicle['daily_rate']; ?>">
                                            <?php if (!empty($vehicle['image_url'])): ?>
                                                <img src="<?php echo htmlspecialchars($vehicle['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" style="height: 150px; object-fit: cover;">
                                            <?php else: ?>
                                                <img src="https://via.placeholder.com/300x150?text=<?php echo urlencode($vehicle['make'] . '+' . $vehicle['model']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" style="height: 150px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?></h6>
                                                <p class="card-text small">
                                                    <strong>Year:</strong> <?php echo $vehicle['year']; ?><br>
                                                    <strong>Color:</strong> <?php echo htmlspecialchars($vehicle['color']); ?><br>
                                                    <strong>Seats:</strong> <?php echo $vehicle['seats']; ?><br>
                                                    <strong>Transmission:</strong> <?php echo ucfirst($vehicle['transmission']); ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="h6 text-primary mb-0">$<?php echo number_format($vehicle['daily_rate'], 2); ?>/day</span>
                                                    <button type="button" class="btn btn-outline-primary btn-sm select-vehicle" data-vehicle-id="<?php echo $vehicle['vehicle_id']; ?>">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Price Summary -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Price Summary</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Vehicle Rate:</strong> <span id="vehicle-rate">$0.00</span>/day</p>
                                        <p class="mb-1"><strong>Insurance:</strong> <span id="insurance-rate">$0.00</span>/day</p>
                                        <p class="mb-1"><strong>Duration:</strong> <span id="duration">0</span> days</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Vehicle Total:</strong> <span id="vehicle-total">$0.00</span></p>
                                        <p class="mb-1"><strong>Insurance Total:</strong> <span id="insurance-total">$0.00</span></p>
                                        <hr>
                                        <h5 class="mb-0"><strong>Total Amount:</strong> <span id="total-amount" class="text-primary">$0.00</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Create Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Price calculation
function calculatePrice() {
    const vehicleSelect = document.getElementById('vehicle_id');
    const insuranceSelect = document.getElementById('insurance_package_id');
    const pickupDate = document.getElementById('pickup_date').value;
    const returnDate = document.getElementById('return_date').value;
    
    const vehicleRate = vehicleSelect.options[vehicleSelect.selectedIndex]?.dataset.dailyRate || 0;
    const insuranceRate = insuranceSelect.options[insuranceSelect.selectedIndex]?.dataset.dailyRate || 0;
    
    let duration = 0;
    if (pickupDate && returnDate) {
        const start = new Date(pickupDate);
        const end = new Date(returnDate);
        duration = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        if (duration < 1) duration = 1;
    }
    
    const vehicleTotal = vehicleRate * duration;
    const insuranceTotal = insuranceRate * duration;
    const totalAmount = vehicleTotal + insuranceTotal;
    
    document.getElementById('vehicle-rate').textContent = '$' + parseFloat(vehicleRate).toFixed(2);
    document.getElementById('insurance-rate').textContent = '$' + parseFloat(insuranceRate).toFixed(2);
    document.getElementById('duration').textContent = duration;
    document.getElementById('vehicle-total').textContent = '$' + vehicleTotal.toFixed(2);
    document.getElementById('insurance-total').textContent = '$' + insuranceTotal.toFixed(2);
    document.getElementById('total-amount').textContent = '$' + totalAmount.toFixed(2);
}

// Add event listeners
document.getElementById('vehicle_id').addEventListener('change', calculatePrice);
document.getElementById('insurance_package_id').addEventListener('change', calculatePrice);
document.getElementById('pickup_date').addEventListener('change', calculatePrice);
document.getElementById('return_date').addEventListener('change', calculatePrice);

// Vehicle selection from cards
document.querySelectorAll('.select-vehicle').forEach(button => {
    button.addEventListener('click', function() {
        const vehicleId = this.dataset.vehicleId;
        const vehicleSelect = document.getElementById('vehicle_id');
        
        // Update dropdown selection
        vehicleSelect.value = vehicleId;
        
        // Update card styling
        document.querySelectorAll('.vehicle-option').forEach(card => {
            card.classList.remove('border-primary');
        });
        this.closest('.vehicle-option').classList.add('border-primary');
        
        // Recalculate price
        calculatePrice();
    });
});

// Initial calculation
calculatePrice();
</script> 
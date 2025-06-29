<?php
$pageTitle = "Booking Details - Car Rental System";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Booking #<?php echo $booking['booking_id']; ?></h3>
                    <span class="badge bg-light text-dark fs-6">
                        <?php echo ucfirst($booking['status']); ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Vehicle Information</h5>
                            <ul class="list-unstyled">
                                <li><strong>Make:</strong> <?php echo htmlspecialchars($booking['make']); ?></li>
                                <li><strong>Model:</strong> <?php echo htmlspecialchars($booking['model']); ?></li>
                                <li><strong>Year:</strong> <?php echo $booking['year']; ?></li>
                                <li><strong>VIN:</strong> <?php echo htmlspecialchars($booking['vin']); ?></li>
                                <li><strong>Daily Rate:</strong> $<?php echo number_format($booking['daily_rate'], 2); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Booking Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Pickup Date:</strong> <?php echo date('M d, Y H:i', strtotime($booking['pickup_date'])); ?></li>
                                <li><strong>Return Date:</strong> <?php echo date('M d, Y H:i', strtotime($booking['return_date'])); ?></li>
                                <li><strong>Duration:</strong> <?php 
                                    $start = new DateTime($booking['pickup_date']);
                                    $end = new DateTime($booking['return_date']);
                                    $duration = $start->diff($end);
                                    echo $duration->days . ' days, ' . $duration->h . ' hours';
                                ?></li>
                                <li><strong>Created:</strong> <?php echo date('M d, Y H:i', strtotime($booking['created_at'])); ?></li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Location Information</h5>
                            <ul class="list-unstyled">
                                <li><strong>Pickup Location:</strong> <?php echo htmlspecialchars($booking['pickup_location_name']); ?></li>
                                <li><strong>Return Location:</strong> <?php echo htmlspecialchars($booking['return_location_name']); ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Insurance Information</h5>
                            <?php if ($booking['insurance_package_name']): ?>
                                <ul class="list-unstyled">
                                    <li><strong>Package:</strong> <?php echo htmlspecialchars($booking['insurance_package_name']); ?></li>
                                    <li><strong>Daily Rate:</strong> $<?php echo number_format($booking['insurance_daily_rate'], 2); ?></li>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">No insurance package selected</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="card-title">Price Breakdown</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Vehicle Rental</strong></td>
                                            <td class="text-end">$<?php echo number_format($booking['vehicle_total'], 2); ?></td>
                                        </tr>
                                        <?php if ($booking['insurance_total'] > 0): ?>
                                        <tr>
                                            <td><strong>Insurance</strong></td>
                                            <td class="text-end">$<?php echo number_format($booking['insurance_total'], 2); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr class="table-primary">
                                            <td><strong>Total Amount</strong></td>
                                            <td class="text-end"><strong>$<?php echo number_format($booking['total_amount'], 2); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="btn-group" role="group">
                                <a href="index.php?action=bookings" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Bookings
                                </a>
                                <?php if (in_array($booking['status'], ['pending', 'confirmed'])): ?>
                                    <a href="index.php?action=booking_cancel&id=<?php echo $booking['booking_id']; ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="fas fa-times"></i> Cancel Booking
                                    </a>
                                <?php endif; ?>
                                <a href="index.php?action=booking" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Make New Booking
                                </a>
                            </div>
             </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
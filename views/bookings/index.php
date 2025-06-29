<?php
$pageTitle = "My Bookings - Car Rental System";
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Bookings</h2>
        </div>
    </div>

    <?php if (isset($_SESSION['flash_messages'])): ?>
        <?php foreach ($_SESSION['flash_messages'] as $type => $message): ?>
            <div class="alert alert-<?php echo $type; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash_messages']); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <?php if (empty($bookings)): ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h4>No Bookings Found</h4>
                        <p class="text-muted">You haven't made any bookings yet.</p>
                        <a href="index.php?action=booking" class="btn btn-primary">Make Your First Booking</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Booking ID</th>
                                <th>Vehicle</th>
                                <th>Pickup Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>#<?php echo $booking['booking_id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($booking['make'] . ' ' . $booking['model']); ?></strong><br>
                                        <small class="text-muted"><?php echo $booking['year']; ?></small>
                                    </td>
                                    <td><?php echo date('M d, Y H:i', strtotime($booking['pickup_date'])); ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($booking['return_date'])); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        switch ($booking['status']) {
                                            case 'pending':
                                                $statusClass = 'warning';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'success';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'danger';
                                                break;
                                            case 'completed':
                                                $statusClass = 'info';
                                                break;
                                            default:
                                                $statusClass = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $statusClass; ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td><strong>$<?php echo number_format($booking['total_amount'], 2); ?></strong></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="index.php?action=booking_show&id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <?php if (in_array($booking['status'], ['pending', 'confirmed'])): ?>
                                                <a href="index.php?action=booking_cancel&id=<?php echo $booking['booking_id']; ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="index.php?action=booking" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Make New Booking
            </a>
        </div>
    </div>
</div> 
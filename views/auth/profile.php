<?php
$pageTitle = "My Profile - Car Rental System";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">My Profile</h3>
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

                    <form action="index.php?action=update_profile" method="POST" class="mb-4">
                        <h5 class="mb-3">Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="driver_license_number" class="form-label">Driver License Number</label>
                                <input type="text" class="form-control" id="driver_license_number" name="driver_license_number" value="<?php echo htmlspecialchars($user['driver_license_number']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="driver_license_expiry" class="form-label">License Expiry</label>
                                <input type="date" class="form-control" id="driver_license_expiry" name="driver_license_expiry" value="<?php echo htmlspecialchars($user['driver_license_expiry']); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>

                    <form action="index.php?action=update_preferences" method="POST" class="mb-4">
                        <h5 class="mb-3">Preferences</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="favorite_car_type" class="form-label">Favorite Car Type</label>
                                <input type="text" class="form-control" id="favorite_car_type" name="favorite_car_type" value="<?php echo htmlspecialchars($preferences['favorite_car_type'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="seat_position_preference" class="form-label">Seat Position Preference</label>
                                <input type="text" class="form-control" id="seat_position_preference" name="seat_position_preference" value="<?php echo htmlspecialchars($preferences['seat_position_preference'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="preferred_pickup_location" class="form-label">Preferred Pickup Location</label>
                                <select class="form-select" id="preferred_pickup_location" name="preferred_pickup_location">
                                    <option value="">Select Location</option>
                                    <?php 
                                    // Get pickup locations
                                    $database = new Database();
                                    $db = $database->getConnection();
                                    $locations = $db->query("SELECT * FROM pickup_locations WHERE is_active = 1")->fetchAll();
                                    foreach ($locations as $location): 
                                    ?>
                                        <option value="<?php echo $location['location_id']; ?>" <?php echo ($preferences['preferred_pickup_location'] ?? '') == $location['location_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($location['location_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="preferred_insurance_package" class="form-label">Preferred Insurance Package</label>
                                <select class="form-select" id="preferred_insurance_package" name="preferred_insurance_package">
                                    <option value="">Select Insurance</option>
                                    <?php 
                                    // Get insurance packages
                                    $packages = $db->query("SELECT * FROM insurance_packages WHERE is_active = 1")->fetchAll();
                                    foreach ($packages as $package): 
                                    ?>
                                        <option value="<?php echo $package['package_id']; ?>" <?php echo ($preferences['preferred_insurance_package'] ?? '') == $package['package_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($package['package_name']); ?> - $<?php echo number_format($package['daily_rate'], 2); ?>/day
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Update Preferences</button>
                    </form>

                    <form action="index.php?action=change_password" method="POST" class="mb-4">
                        <h5 class="mb-3">Change Password</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Change Password</button>
                    </form>

                    <div class="card bg-light mb-0">
                        <div class="card-body">
                            <h5 class="mb-3">Loyalty Program</h5>
                            <?php if ($loyalty): ?>
                                <p><strong>Points:</strong> <?php echo htmlspecialchars($loyalty['points']); ?></p>
                                <p><strong>Tier:</strong> <?php echo htmlspecialchars($loyalty['tier']); ?></p>
                                <p><strong>Next Reward:</strong> <?php echo htmlspecialchars($loyalty['next_reward']); ?></p>
                            <?php else: ?>
                                <p>You are not enrolled in the loyalty program yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> 
<?php
$pageTitle = "Vehicles - Car Rental System";
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Available Vehicles</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <!-- Filters -->
            <div class="card">
                <div class="card-header">
                    <h5>Filters</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="action" value="vehicles">
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Vehicle Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category['category_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['category_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="transmission" class="form-label">Transmission</label>
                            <select class="form-select" id="transmission" name="transmission">
                                <option value="">All</option>
                                <option value="automatic" <?php echo (isset($_GET['transmission']) && $_GET['transmission'] == 'automatic') ? 'selected' : ''; ?>>Automatic</option>
                                <option value="manual" <?php echo (isset($_GET['transmission']) && $_GET['transmission'] == 'manual') ? 'selected' : ''; ?>>Manual</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="fuel_type" class="form-label">Fuel Type</label>
                            <select class="form-select" id="fuel_type" name="fuel_type">
                                <option value="">All</option>
                                <option value="gasoline" <?php echo (isset($_GET['fuel_type']) && $_GET['fuel_type'] == 'gasoline') ? 'selected' : ''; ?>>Gasoline</option>
                                <option value="diesel" <?php echo (isset($_GET['fuel_type']) && $_GET['fuel_type'] == 'diesel') ? 'selected' : ''; ?>>Diesel</option>
                                <option value="hybrid" <?php echo (isset($_GET['fuel_type']) && $_GET['fuel_type'] == 'hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                                <option value="electric" <?php echo (isset($_GET['fuel_type']) && $_GET['fuel_type'] == 'electric') ? 'selected' : ''; ?>>Electric</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price_min" class="form-label">Min Price</label>
                            <input type="number" class="form-control" id="price_min" name="price_min" placeholder="0" value="<?php echo isset($_GET['price_min']) ? htmlspecialchars($_GET['price_min']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="price_max" class="form-label">Max Price</label>
                            <input type="number" class="form-control" id="price_max" name="price_max" placeholder="1000" value="<?php echo isset($_GET['price_max']) ? htmlspecialchars($_GET['price_max']) : ''; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">Apply Filters</button>
                        <a href="index.php?action=vehicles" class="btn btn-outline-secondary w-100">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Results Counter -->
            <div class="mb-3">
                <h6 class="text-muted">
                    <?php 
                    $count = count($vehicles);
                    if (isset($_GET['category']) || isset($_GET['transmission']) || isset($_GET['fuel_type']) || isset($_GET['price_min']) || isset($_GET['price_max'])) {
                        echo "Showing {$count} vehicle" . ($count != 1 ? 's' : '') . " matching your filters";
                    } else {
                        echo "Showing all {$count} vehicles";
                    }
                    ?>
                </h6>
            </div>

            <!-- Vehicle Grid -->
            <div class="row" id="vehicle-grid">
                <?php if (empty($vehicles)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            No vehicles found matching your criteria.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 vehicle-card">
                                <?php if (!empty($vehicle['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($vehicle['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x200?text=<?php echo urlencode($vehicle['make'] . '+' . $vehicle['model']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($vehicle['category_name']); ?> - <?php echo htmlspecialchars($vehicle['year']); ?></p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-users"></i> <?php echo $vehicle['seats']; ?> Seats</li>
                                        <li><i class="fas fa-cog"></i> <?php echo ucfirst($vehicle['transmission']); ?></li>
                                        <li><i class="fas fa-gas-pump"></i> <?php echo ucfirst($vehicle['fuel_type']); ?></li>
                                        <li><i class="fas fa-palette"></i> <?php echo htmlspecialchars($vehicle['color']); ?></li>
                                        <li><i class="fas fa-circle <?php echo $vehicle['status'] === 'available' ? 'text-success' : 'text-danger'; ?>"></i> <?php echo ucfirst($vehicle['status']); ?></li>
                                    </ul>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">$<?php echo number_format($vehicle['daily_rate'], 2); ?>/day</span>
                                        <?php if ($vehicle['status'] === 'available'): ?>
                                            <a href="index.php?action=booking&vehicle_id=<?php echo $vehicle['vehicle_id']; ?>" class="btn btn-primary">Book Now</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary" disabled>Not Available</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Vehicle pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html> 
<div class="container py-5">
    <h2 class="mb-4">Pricing & Rates</h2>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Daily Rental Rates</h5>
                    <p class="card-text">Our competitive rates vary by vehicle type and rental duration.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Vehicle Type</th>
                                    <th>Daily Rate</th>
                                    <th>Weekly Rate</th>
                                    <th>Monthly Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Economy</strong><br><small class="text-muted">Compact cars, fuel efficient</small></td>
                                    <td>$35/day</td>
                                    <td>$210/week</td>
                                    <td>$840/month</td>
                                </tr>
                                <tr>
                                    <td><strong>Standard</strong><br><small class="text-muted">Mid-size sedans, comfortable</small></td>
                                    <td>$45/day</td>
                                    <td>$270/week</td>
                                    <td>$1080/month</td>
                                </tr>
                                <tr>
                                    <td><strong>Premium</strong><br><small class="text-muted">Luxury vehicles, high-end</small></td>
                                    <td>$75/day</td>
                                    <td>$450/week</td>
                                    <td>$1800/month</td>
                                </tr>
                                <tr>
                                    <td><strong>SUV</strong><br><small class="text-muted">Sport utility vehicles</small></td>
                                    <td>$65/day</td>
                                    <td>$390/week</td>
                                    <td>$1560/month</td>
                                </tr>
                                <tr>
                                    <td><strong>Van</strong><br><small class="text-muted">Passenger vans, cargo</small></td>
                                    <td>$85/day</td>
                                    <td>$510/week</td>
                                    <td>$2040/month</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Additional Charges</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Insurance Options</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">Basic Coverage: $15/day</li>
                                <li class="mb-2">Premium Coverage: $25/day</li>
                                <li class="mb-2">Full Coverage: $35/day</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Additional Services</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">GPS Navigation: $10/day</li>
                                <li class="mb-2">Child Seat: $15/day</li>
                                <li class="mb-2">Additional Driver: $10/day</li>
                                <li class="mb-2">Late Return: $25/hour</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Price Calculator</h5>
                    <form id="price-calculator">
                        <div class="mb-3">
                            <label for="vehicle_type" class="form-label">Vehicle Type</label>
                            <select class="form-select" id="vehicle_type" name="vehicle_type">
                                <option value="economy">Economy - $35/day</option>
                                <option value="standard">Standard - $45/day</option>
                                <option value="premium">Premium - $75/day</option>
                                <option value="suv">SUV - $65/day</option>
                                <option value="van">Van - $85/day</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="rental_days" class="form-label">Number of Days</label>
                            <input type="number" class="form-control" id="rental_days" name="rental_days" min="1" value="1">
                        </div>
                        
                        <div class="mb-3">
                            <label for="insurance" class="form-label">Insurance</label>
                            <select class="form-select" id="insurance" name="insurance">
                                <option value="none">No Insurance</option>
                                <option value="basic">Basic - $15/day</option>
                                <option value="premium">Premium - $25/day</option>
                                <option value="full">Full - $35/day</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Additional Services</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gps" name="gps">
                                <label class="form-check-label" for="gps">GPS Navigation ($10/day)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="child_seat" name="child_seat">
                                <label class="form-check-label" for="child_seat">Child Seat ($15/day)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="additional_driver" name="additional_driver">
                                <label class="form-check-label" for="additional_driver">Additional Driver ($10/day)</label>
                            </div>
                        </div>
                        
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Estimated Total</h6>
                                <div id="price-breakdown">
                                    <div>Base Rate: <span id="base-rate">$35.00</span></div>
                                    <div>Insurance: <span id="insurance-cost">$0.00</span></div>
                                    <div>Services: <span id="services-cost">$0.00</span></div>
                                    <div>Tax (8%): <span id="tax-amount">$2.80</span></div>
                                    <hr>
                                    <div class="fw-bold">Total: <span id="total-price">$37.80</span></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special Offers</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-tag text-success"></i> 10% off weekly rentals</li>
                        <li class="mb-2"><i class="fas fa-tag text-success"></i> 15% off monthly rentals</li>
                        <li class="mb-2"><i class="fas fa-tag text-success"></i> Student discount available</li>
                        <li class="mb-2"><i class="fas fa-tag text-success"></i> Corporate rates available</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calculator = document.getElementById('price-calculator');
    const vehicleType = document.getElementById('vehicle_type');
    const rentalDays = document.getElementById('rental_days');
    const insurance = document.getElementById('insurance');
    const gps = document.getElementById('gps');
    const childSeat = document.getElementById('child_seat');
    const additionalDriver = document.getElementById('additional_driver');
    
    const rates = {
        economy: 35,
        standard: 45,
        premium: 75,
        suv: 65,
        van: 85
    };
    
    const insuranceRates = {
        none: 0,
        basic: 15,
        premium: 25,
        full: 35
    };
    
    function calculatePrice() {
        const baseRate = rates[vehicleType.value] * rentalDays.value;
        const insuranceCost = insuranceRates[insurance.value] * rentalDays.value;
        let servicesCost = 0;
        
        if (gps.checked) servicesCost += 10 * rentalDays.value;
        if (childSeat.checked) servicesCost += 15 * rentalDays.value;
        if (additionalDriver.checked) servicesCost += 10 * rentalDays.value;
        
        const subtotal = baseRate + insuranceCost + servicesCost;
        const tax = subtotal * 0.08;
        const total = subtotal + tax;
        
        document.getElementById('base-rate').textContent = '$' + baseRate.toFixed(2);
        document.getElementById('insurance-cost').textContent = '$' + insuranceCost.toFixed(2);
        document.getElementById('services-cost').textContent = '$' + servicesCost.toFixed(2);
        document.getElementById('tax-amount').textContent = '$' + tax.toFixed(2);
        document.getElementById('total-price').textContent = '$' + total.toFixed(2);
    }
    
    vehicleType.addEventListener('change', calculatePrice);
    rentalDays.addEventListener('input', calculatePrice);
    insurance.addEventListener('change', calculatePrice);
    gps.addEventListener('change', calculatePrice);
    childSeat.addEventListener('change', calculatePrice);
    additionalDriver.addEventListener('change', calculatePrice);
    
    calculatePrice();
});
</script> 
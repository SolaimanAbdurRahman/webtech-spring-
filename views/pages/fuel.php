<div class="container py-5">
    <h2 class="mb-4">Fuel Tracking</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Track Your Fuel Usage</h5>
            <p class="card-text">Keep track of your fuel usage and refueling during your rental period.</p>
            <form>
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle_id" placeholder="Enter vehicle ID or license plate">
                </div>
                <div class="mb-3">
                    <label for="fuel_amount" class="form-label">Fuel Added (liters)</label>
                    <input type="number" class="form-control" id="fuel_amount" placeholder="Enter amount in liters">
                </div>
                <div class="mb-3">
                    <label for="fuel_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="fuel_date">
                </div>
                <button type="submit" class="btn btn-primary">Add Record</button>
            </form>
        </div>
    </div>
</div> 
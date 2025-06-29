<div class="container py-5">
    <h2 class="mb-4">Damage Report</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Report Vehicle Damage</h5>
            <p class="card-text">If you notice any damage to your rental vehicle, please report it immediately using the form below.</p>
            <form>
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <input type="text" class="form-control" id="vehicle_id" placeholder="Enter vehicle ID or license plate">
                </div>
                <div class="mb-3">
                    <label for="damage_description" class="form-label">Description of Damage</label>
                    <textarea class="form-control" id="damage_description" rows="4" placeholder="Describe the damage..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="damage_photo" class="form-label">Upload Photo (optional)</label>
                    <input class="form-control" type="file" id="damage_photo">
                </div>
                <button type="submit" class="btn btn-danger">Submit Report</button>
            </form>
        </div>
    </div>
</div> 
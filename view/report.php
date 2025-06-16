<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Inspection - Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --warning: #FFC107;
            --danger: #F44336;
            --dark: #333;
            --light: #f5f5f5;
            --border: #ddd;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: var(--dark);
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .booking-info {
            background: white;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .info-item {
            margin: 5px 0;
        }
        
        /* Inspection Sections */
        .inspection-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .section-header {
            background: var(--dark);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
        }
        
        .section-status {
            background: var(--warning);
            color: var(--dark);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .section-status.completed {
            background: var(--primary);
            color: white;
        }
        
        /* Damage Report */
        .damage-container {
            padding: 20px;
        }
        
        .vehicle-image-container {
            position: relative;
            margin-bottom: 20px;
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
            background: #f5f5f5;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .vehicle-image {
            max-width: 100%;
            max-height: 500px;
            display: block;
        }
        
        .damage-marker {
            position: absolute;
            width: 24px;
            height: 24px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid white;
            transform: translate(-12px, -12px);
            cursor: pointer;
        }
        
        .damage-marker::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            top: 6px;
            left: 6px;
        }
        
        .damage-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .damage-btn {
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border);
            background: white;
        }
        
        .damage-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .damage-notes {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 4px;
            min-height: 100px;
            margin-bottom: 15px;
        }
        
        .damage-list {
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }
        
        .damage-item {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .damage-item:last-child {
            border-bottom: none;
        }
        
        .damage-location {
            font-weight: 600;
        }
        
        .damage-delete {
            color: var(--danger);
            cursor: pointer;
            font-weight: 600;
        }
        
        /* Fuel Tracking */
        .fuel-container {
            padding: 20px;
        }
        
        .fuel-gauge {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .gauge-visual {
            width: 200px;
            height: 30px;
            background: linear-gradient(to right, #f44336, #FFC107, #4CAF50);
            border-radius: 15px;
            margin-right: 20px;
            position: relative;
        }
        
        .gauge-level {
            position: absolute;
            top: -5px;
            width: 4px;
            height: 40px;
            background: var(--dark);
            transform: translateX(-2px);
        }
        
        .fuel-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }
        
        .fuel-option {
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
        }
        
        .fuel-option.active {
            border-color: var(--primary);
            background: #e8f5e9;
        }
        
        .fuel-upload {
            margin-top: 20px;
        }
        
        .upload-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        /* Signature */
        .signature-section {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .signature-pad {
            border: 1px solid var(--border);
            border-radius: 4px;
            margin: 15px 0;
            background: white;
            height: 150px;
        }
        
        .signature-clear {
            color: var(--danger);
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
        }
        
        /* Submit Button */
        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .fuel-gauge {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .gauge-visual {
                margin-right: 0;
                margin-bottom: 15px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Vehicle Inspection Report</h1>
            <p>Complete the inspection checklist before rental pickup/return</p>
        </div>
        
        <!-- Booking Information -->
        <div class="booking-info">
            <div class="info-item"><strong>Booking #:</strong> CR-10245</div>
            <div class="info-item"><strong>Vehicle:</strong> Toyota RAV4 (CR-205)</div>
            <div class="info-item"><strong>Customer:</strong> Michael Brown</div>
            <div class="info-item"><strong>Date:</strong> <?php echo date('F j, Y'); ?></div>
            <div class="info-item"><strong>Type:</strong> Pickup Inspection</div>
        </div>
        
        <!-- Damage Report Section -->
        <div class="inspection-section">
            <div class="section-header">
                <div class="section-title">Damage Report</div>
                <div class="section-status" id="damage-status">Pending</div>
            </div>
            
            <div class="damage-container">
                <div class="vehicle-image-container" id="vehicle-image">
                    <img src="https://source.unsplash.com/random/800x600?car,side" alt="Vehicle Image" class="vehicle-image" id="inspection-image">
                    <!-- Damage markers will be added here by JavaScript -->
                </div>
                
                <div class="damage-controls">
                    <button class="damage-btn active" id="add-damage-btn">Add Damage</button>
                    <button class="damage-btn" id="view-damage-btn">View Damages</button>
                </div>
                
                <textarea class="damage-notes" id="damage-notes" placeholder="Add notes about the damage..."></textarea>
                
                <button class="damage-btn" id="save-damage-btn">Save Damage</button>
                
                <div class="damage-list" id="damage-list">
                    <!-- Sample damage item -->
                    <div class="damage-item">
                        <div>
                            <div class="damage-location">Front Bumper (Right)</div>
                            <div>Small scratch (5cm)</div>
                        </div>
                        <div class="damage-delete">Delete</div>
                    </div>
                    <!-- More damages will be added here -->
                </div>
            </div>
        </div>
        
        <!-- Fuel Tracking Section -->
        <div class="inspection-section">
            <div class="section-header">
                <div class="section-title">Fuel Level</div>
                <div class="section-status" id="fuel-status">Pending</div>
            </div>
            
            <div class="fuel-container">
                <div class="fuel-gauge">
                    <div class="gauge-visual" id="gauge-visual">
                        <div class="gauge-level" id="gauge-level" style="left: 25%;"></div>
                    </div>
                    <div>
                        <h3>Current Fuel Level</h3>
                        <p>Select the approximate fuel level at pickup</p>
                    </div>
                </div>
                
                <div class="fuel-options" id="fuel-options">
                    <div class="fuel-option active" data-level="0">Empty</div>
                    <div class="fuel-option" data-level="25">1/4 Tank</div>
                    <div class="fuel-option" data-level="50">1/2 Tank</div>
                    <div class="fuel-option" data-level="75">3/4 Tank</div>
                    <div class="fuel-option" data-level="100">Full Tank</div>
                </div>
                
                <div class="fuel-upload">
                    <label class="upload-label">Upload Fuel Receipt (if refueled)</label>
                    <input type="file" accept="image/*">
                </div>
            </div>
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section">
            <h3>Customer Acknowledgment</h3>
            <p>By signing below, I confirm that I have reviewed the vehicle condition and fuel level as documented.</p>
            
            <div class="signature-pad" id="signature-pad">
                <!-- Signature canvas would go here -->
                <p style="text-align: center; color: #999; line-height: 150px;">Sign above with your mouse or finger</p>
            </div>
            
            <div style="text-align: right;">
                <span class="signature-clear" id="clear-signature">Clear Signature</span>
            </div>
        </div>
        
        <!-- Submit Button -->
        <button class="submit-btn" id="submit-inspection">Complete Inspection</button>
    </div>
    
    <script>
        // Damage Report Functionality
        const vehicleImage = document.getElementById('vehicle-image');
        const addDamageBtn = document.getElementById('add-damage-btn');
        const viewDamageBtn = document.getElementById('view-damage-btn');
        const saveDamageBtn = document.getElementById('save-damage-btn');
        const damageNotes = document.getElementById('damage-notes');
        const damageList = document.getElementById('damage-list');
        let damageMarkers = [];
        let isAddingDamage = true;
        
        // Toggle between add/view modes
        addDamageBtn.addEventListener('click', function() {
            isAddingDamage = true;
            addDamageBtn.classList.add('active');
            viewDamageBtn.classList.remove('active');
        });
        
        viewDamageBtn.addEventListener('click', function() {
            isAddingDamage = false;
            viewDamageBtn.classList.add('active');
            addDamageBtn.classList.remove('active');
        });
        
        // Add damage marker on image click
        vehicleImage.addEventListener('click', function(e) {
            if (!isAddingDamage) return;
            
            // Calculate position relative to the image container
            const rect = vehicleImage.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Create marker
            const marker = document.createElement('div');
            marker.className = 'damage-marker';
            marker.style.left = x + 'px';
            marker.style.top = y + 'px';
            
            // Add marker to image
            vehicleImage.appendChild(marker);
            damageMarkers.push({
                element: marker,
                x: x / rect.width * 100 + '%',
                y: y / rect.height * 100 + '%'
            });
            
            // Show notes field
            damageNotes.focus();
        });
        
        // Save damage
        saveDamageBtn.addEventListener('click', function() {
            if (damageMarkers.length === 0 || !damageNotes.value) {
                alert('Please mark a damage and add notes');
                return;
            }
            
            // Add to damage list
            const damageItem = document.createElement('div');
            damageItem.className = 'damage-item';
            damageItem.innerHTML = `
                <div>
                    <div class="damage-location">Damage ${damageList.children.length + 1}</div>
                    <div>${damageNotes.value}</div>
                </div>
                <div class="damage-delete">Delete</div>
            `;
            
            damageList.appendChild(damageItem);
            
            // Clear current markers and notes
            damageMarkers.forEach(marker => {
                marker.element.remove();
            });
            damageMarkers = [];
            damageNotes.value = '';
            
            // Update status
            if (damageList.children.length > 0) {
                document.getElementById('damage-status').textContent = 'Completed';
                document.getElementById('damage-status').classList.add('completed');
            }
        });
        
        // Delete damage (event delegation)
        damageList.addEventListener('click', function(e) {
            if (e.target.classList.contains('damage-delete')) {
                e.target.closest('.damage-item').remove();
                
                // Update status if no damages left
                if (damageList.children.length === 0) {
                    document.getElementById('damage-status').textContent = 'Pending';
                    document.getElementById('damage-status').classList.remove('completed');
                }
            }
        });
        
        // Fuel Tracking Functionality
        const fuelOptions = document.querySelectorAll('.fuel-option');
        const gaugeLevel = document.getElementById('gauge-level');
        
        fuelOptions.forEach(option => {
            option.addEventListener('click', function() {
                fuelOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                const level = this.dataset.level;
                gaugeLevel.style.left = level + '%';
                
                // Update status
                document.getElementById('fuel-status').textContent = 'Completed';
                document.getElementById('fuel-status').classList.add('completed');
            });
        });
        
        // Signature Pad (simplified)
        const signaturePad = document.getElementById('signature-pad');
        const clearSignature = document.getElementById('clear-signature');
        
        // In a real app, you would use a proper signature library like Signature Pad
        signaturePad.addEventListener('click', function() {
            this.innerHTML = '<p style="text-align: center; color: var(--primary); line-height: 150px;">Signature Captured</p>';
        });
        
        clearSignature.addEventListener('click', function() {
            signaturePad.innerHTML = '<p style="text-align: center; color: #999; line-height: 150px;">Sign above with your mouse or finger</p>';
        });
        
        // Submit Inspection
        document.getElementById('submit-inspection').addEventListener('click', function() {
            if (damageList.children.length === 0 || !document.getElementById('fuel-status').classList.contains('completed')) {
                alert('Please complete all inspection sections');
                return;
            }
            
            if (signaturePad.innerHTML.includes('Sign above')) {
                alert('Please provide a signature');
                return;
            }
            
            alert('Inspection submitted successfully!');
            // In a real app, this would submit to the server
        });
    </script>
</body>
</html>
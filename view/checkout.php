<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance & Checkout - Car Rental System</title>
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
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }
        
        /* Page Header */
        .page-header {
            grid-column: 1 / -1;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .page-title {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .booking-reference {
            color: #666;
        }
        
        /* Insurance Section */
        .insurance-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 25px;
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        /* Coverage Accordion */
        .coverage-accordion {
            margin-bottom: 30px;
        }
        
        .coverage-item {
            border: 1px solid var(--border);
            border-radius: 6px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .coverage-header {
            padding: 15px 20px;
            background: #f8f9fa;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        
        .coverage-header:hover {
            background: #f1f3f5;
        }
        
        .coverage-header.active {
            background: var(--primary);
            color: white;
        }
        
        .coverage-content {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .coverage-content-inner {
            padding: 20px 0;
        }
        
        .coverage-details {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .coverage-features {
            margin: 15px 0;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        
        .feature-icon {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .select-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            float: right;
        }
        
        .select-btn.selected {
            background: var(--dark);
        }
        
        /* Summary Section */
        .summary-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 25px;
            align-self: start;
            position: sticky;
            top: 20px;
        }
        
        .summary-title {
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .vehicle-summary {
            display: flex;
            margin-bottom: 20px;
        }
        
        .vehicle-image {
            width: 100px;
            height: 70px;
            border-radius: 4px;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .vehicle-info {
            flex: 1;
        }
        
        .vehicle-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .vehicle-dates {
            color: #666;
            font-size: 14px;
        }
        
        /* Fee Breakdown */
        .fee-breakdown {
            margin: 25px 0;
        }
        
        .fee-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border);
        }
        
        .fee-row.total {
            font-weight: 600;
            font-size: 18px;
            border-bottom: none;
            margin-top: 15px;
        }
        
        /* Email Quote */
        .email-quote {
            margin-top: 25px;
        }
        
        .email-input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .send-btn {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        
        /* Checkout Button */
        .checkout-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .checkout-btn:hover {
            background: #45a049;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
            
            .summary-section {
                position: static;
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Select Insurance Coverage</h1>
            <div class="booking-reference">Booking #CR-10245</div>
        </div>
        
        <!-- Insurance Section -->
        <div class="insurance-section">
            <h2 class="section-title">Available Coverage Options</h2>
            
            <div class="coverage-accordion">
                <!-- Basic Coverage -->
                <div class="coverage-item">
                    <div class="coverage-header" onclick="toggleCoverage(this)">
                        <span>Basic Coverage</span>
                        <span>$12/day</span>
                    </div>
                    <div class="coverage-content">
                        <div class="coverage-content-inner">
                            <div class="coverage-details">
                                Our standard protection package that covers the essentials while keeping costs low.
                            </div>
                            <div class="coverage-features">
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Liability coverage up to $50,000</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Collision damage waiver ($1,500 deductible)</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>24/7 roadside assistance</span>
                                </div>
                            </div>
                            <button class="select-btn" onclick="selectCoverage(this, 'basic')">Select</button>
                        </div>
                    </div>
                </div>
                
                <!-- Standard Coverage -->
                <div class="coverage-item">
                    <div class="coverage-header active" onclick="toggleCoverage(this)">
                        <span>Standard Coverage</span>
                        <span>$18/day</span>
                    </div>
                    <div class="coverage-content" style="max-height: 500px;">
                        <div class="coverage-content-inner">
                            <div class="coverage-details">
                                Our most popular option with enhanced protection and lower deductibles.
                            </div>
                            <div class="coverage-features">
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Liability coverage up to $100,000</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Collision damage waiver ($750 deductible)</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Comprehensive coverage</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>24/7 roadside assistance</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Personal accident insurance</span>
                                </div>
                            </div>
                            <button class="select-btn selected" onclick="selectCoverage(this, 'standard')">Selected</button>
                        </div>
                    </div>
                </div>
                
                <!-- Premium Coverage -->
                <div class="coverage-item">
                    <div class="coverage-header" onclick="toggleCoverage(this)">
                        <span>Premium Coverage</span>
                        <span>$25/day</span>
                    </div>
                    <div class="coverage-content">
                        <div class="coverage-content-inner">
                            <div class="coverage-details">
                                Maximum peace of mind with our highest level of protection and no deductibles.
                            </div>
                            <div class="coverage-features">
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Liability coverage up to $300,000</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Zero deductible collision damage waiver</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Comprehensive coverage</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>24/7 premium roadside assistance</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Personal accident insurance</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Personal effects coverage</span>
                                </div>
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>Travel interruption protection</span>
                                </div>
                            </div>
                            <button class="select-btn" onclick="selectCoverage(this, 'premium')">Select</button>
                        </div>
                    </div>
                </div>
                
                <!-- Decline Coverage -->
                <div class="coverage-item">
                    <div class="coverage-header" onclick="toggleCoverage(this)">
                        <span>Decline Coverage</span>
                        <span>$0/day</span>
                    </div>
                    <div class="coverage-content">
                        <div class="coverage-content-inner">
                            <div class="coverage-details">
                                You acknowledge that you are declining all optional coverage and will be fully responsible for any damages or liabilities according to the rental agreement terms.
                            </div>
                            <div style="color: var(--danger); font-weight: 600; margin: 15px 0;">
                                <p>⚠️ Important: By declining coverage, you accept full financial responsibility for any damage to the rental vehicle.</p>
                            </div>
                            <button class="select-btn" onclick="selectCoverage(this, 'decline')">I Understand</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="summary-section">
            <h2 class="summary-title">Booking Summary</h2>
            
            <div class="vehicle-summary">
                <img src="https://source.unsplash.com/random/300x200?car,suv" alt="Toyota RAV4" class="vehicle-image">
                <div class="vehicle-info">
                    <div class="vehicle-name">Toyota RAV4</div>
                    <div class="vehicle-dates">Jun 15 - Jun 18, 2023 (3 days)</div>
                </div>
            </div>
            
            <div class="fee-breakdown">
                <h3>Fee Breakdown</h3>
                
                <div class="fee-row">
                    <span>Base Rate (3 days)</span>
                    <span>$177.00</span>
                </div>
                
                <div class="fee-row">
                    <span>Standard Coverage ($18/day)</span>
                    <span>$54.00</span>
                </div>
                
                <div class="fee-row">
                    <span>Taxes & Fees</span>
                    <span>$23.10</span>
                </div>
                
                <div class="fee-row total">
                    <span>Total Estimated</span>
                    <span>$254.10</span>
                </div>
            </div>
            
            <div class="email-quote">
                <h3>Email Quote</h3>
                <input type="email" class="email-input" placeholder="your@email.com" value="customer@example.com">
                <button class="send-btn" onclick="sendQuote()">Send Quote to Email</button>
            </div>
            
            <button class="checkout-btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
        </div>
    </div>
    
    <script>
        // Toggle coverage accordion
        function toggleCoverage(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');
            
            // Close all first
            document.querySelectorAll('.coverage-header').forEach(h => {
                h.classList.remove('active');
                h.nextElementSibling.style.maxHeight = null;
            });
            
            // Open clicked if wasn't active
            if (!isActive) {
                header.classList.add('active');
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        }
        
        // Select coverage option
        function selectCoverage(button, type) {
            // Update all buttons
            document.querySelectorAll('.select-btn').forEach(btn => {
                btn.textContent = 'Select';
                btn.classList.remove('selected');
            });
            
            // Update selected button
            button.textContent = 'Selected';
            button.classList.add('selected');
            
            // Update fee breakdown (in a real app, this would calculate dynamically)
            const coverageRow = document.querySelector('.fee-row:nth-child(2)');
            let coverageCost = 0;
            let coverageName = '';
            
            switch(type) {
                case 'basic':
                    coverageCost = 36;
                    coverageName = 'Basic Coverage';
                    break;
                case 'standard':
                    coverageCost = 54;
                    coverageName = 'Standard Coverage';
                    break;
                case 'premium':
                    coverageCost = 75;
                    coverageName = 'Premium Coverage';
                    break;
                case 'decline':
                    coverageCost = 0;
                    coverageName = 'No Coverage';
                    break;
            }
            
            coverageRow.innerHTML = `<span>${coverageName} (${type === 'decline' ? '' : '$'+(coverageCost/3)+'/day'})</span><span>$${coverageCost.toFixed(2)}</span>`;
            
            // Update total
            const totalRow = document.querySelector('.fee-row.total span:last-child');
            const baseRate = 177;
            const taxes = 23.10;
            const newTotal = baseRate + coverageCost + taxes;
            totalRow.textContent = `$${newTotal.toFixed(2)}`;
        }
        
        // Send quote to email
        function sendQuote() {
            const emailInput = document.querySelector('.email-input');
            if (!emailInput.value || !emailInput.value.includes('@')) {
                alert('Please enter a valid email address');
                return;
            }
            
            alert(`Quote has been sent to ${emailInput.value}`);
            // In a real app, this would call your backend email service
        }
        
        // Proceed to checkout
        function proceedToCheckout() {
            const selected = document.querySelector('.select-btn.selected');
            if (!selected) {
                alert('Please select an insurance option');
                return;
            }
            
            // In a real app, this would redirect to payment page
            alert('Proceeding to payment...');
        }
        
        // Initialize page - open standard coverage by default
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.coverage-header.active').click();
        });
    </script>
</body>
</html>
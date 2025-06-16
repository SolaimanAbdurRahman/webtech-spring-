<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find & Book Vehicles - Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --dark: #333;
            --light: #f5f5f5;
            --border: #ddd;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        /* Search & Filter Section */
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .search-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 16px;
        }
        
        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            grid-column: 1 / -1;
        }
        
        .search-btn:hover {
            background: #45a049;
        }
        
        /* Results Section */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .sort-options {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Vehicle Cards */
        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .vehicle-card:hover {
            transform: translateY(-5px);
        }
        
        .vehicle-image {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .vehicle-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .vehicle-details {
            padding: 15px;
        }
        
        .vehicle-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .vehicle-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }
        
        .vehicle-spec {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .vehicle-price {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .vehicle-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        /* Booking Calendar */
        .booking-calendar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            padding: 5px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            cursor: pointer;
            position: relative;
        }
        
        .calendar-day.available:hover {
            background: #e8f5e9;
        }
        
        .calendar-day.unavailable {
            background: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }
        
        .calendar-day.selected {
            background: var(--primary);
            color: white;
        }
        
        .calendar-day.today {
            border: 2px solid var(--secondary);
        }
        
        .calendar-day.high-demand::after {
            content: '🔥';
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 10px;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 30px;
        }
        
        .page-item {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
        }
        
        .page-item.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .page-item:hover:not(.active) {
            background: #f5f5f5;
        }
        
        /* Vehicle Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .modal-content {
            background: white;
            margin: 50px auto;
            max-width: 900px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            padding: 15px 20px;
            background: var(--dark);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .modal-image {
            height: 300px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
        }
        
        .modal-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }
        
        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .modal-features {
            margin: 20px 0;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .modal-body {
                grid-template-columns: 1fr;
            }
            
            .vehicle-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Find Your Perfect Rental Vehicle</h1>
            <p>Search, compare, and book in just a few clicks</p>
        </div>
        
        <!-- Search & Filter Section -->
        <div class="search-container">
            <form class="search-form">
                <div class="form-group">
                    <label for="pickup-location">Pickup Location</label>
                    <select id="pickup-location">
                        <option value="">Any Location</option>
                        <option value="airport">City Airport</option>
                        <option value="downtown">Downtown Branch</option>
                        <option value="north">Northside Branch</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="pickup-date">Pickup Date</label>
                    <input type="date" id="pickup-date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="return-date">Return Date</label>
                    <input type="date" id="return-date" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                </div>
                
                <div class="form-group">
                    <label for="vehicle-type">Vehicle Type</label>
                    <select id="vehicle-type">
                        <option value="">All Types</option>
                        <option value="compact">Compact</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="price-range">Price Range</label>
                    <select id="price-range">
                        <option value="">Any Price</option>
                        <option value="0-50">$0 - $50/day</option>
                        <option value="50-100">$50 - $100/day</option>
                        <option value="100-150">$100 - $150/day</option>
                        <option value="150+">$150+/day</option>
                    </select>
                </div>
                
                <button type="submit" class="search-btn">Search Vehicles</button>
            </form>
        </div>
        
        <!-- Results Section -->
        <div class="results-header">
            <h2>24 Vehicles Available</h2>
            <div class="sort-options">
                <label>Sort by:</label>
                <select>
                    <option>Recommended</option>
                    <option>Price (Low to High)</option>
                    <option>Price (High to Low)</option>
                    <option>Vehicle Type</option>
                </select>
            </div>
        </div>
        
        <!-- Vehicle Grid -->
        <div class="vehicle-grid">
            <!-- Vehicle Card 1 -->
            <div class="vehicle-card">
                <div class="vehicle-image" style="background-image: url('https://source.unsplash.com/random/600x400?car,suv');">
                    <span class="vehicle-badge">Popular</span>
                </div>
                <div class="vehicle-details">
                    <h3 class="vehicle-title">Toyota RAV4</h3>
                    <div class="vehicle-specs">
                        <span class="vehicle-spec">🚗 SUV</span>
                        <span class="vehicle-spec">⛽ Hybrid</span>
                        <span class="vehicle-spec">👥 5 Seats</span>
                        <span class="vehicle-spec">🧳 3 Bags</span>
                    </div>
                    <div class="vehicle-price">$89/day</div>
                    <div class="vehicle-actions">
                        <button class="btn btn-secondary" onclick="openVehicleModal(1)">Details</button>
                        <button class="btn btn-primary" onclick="showBookingCalendar(1)">Book Now</button>
                    </div>
                </div>
            </div>
            
            <!-- Vehicle Card 2 -->
            <div class="vehicle-card">
                <div class="vehicle-image" style="background-image: url('https://source.unsplash.com/random/600x400?car,sedan');">
                    <span class="vehicle-badge">Best Value</span>
                </div>
                <div class="vehicle-details">
                    <h3 class="vehicle-title">Honda Civic</h3>
                    <div class="vehicle-specs">
                        <span class="vehicle-spec">🚗 Sedan</span>
                        <span class="vehicle-spec">⛽ 35 MPG</span>
                        <span class="vehicle-spec">👥 5 Seats</span>
                        <span class="vehicle-spec">🧳 2 Bags</span>
                    </div>
                    <div class="vehicle-price">$59/day</div>
                    <div class="vehicle-actions">
                        <button class="btn btn-secondary" onclick="openVehicleModal(2)">Details</button>
                        <button class="btn btn-primary" onclick="showBookingCalendar(2)">Book Now</button>
                    </div>
                </div>
            </div>
            
            <!-- Vehicle Card 3 -->
            <div class="vehicle-card">
                <div class="vehicle-image" style="background-image: url('https://source.unsplash.com/random/600x400?car,luxury');">
                    <span class="vehicle-badge">Luxury</span>
                </div>
                <div class="vehicle-details">
                    <h3 class="vehicle-title">BMW 5 Series</h3>
                    <div class="vehicle-specs">
                        <span class="vehicle-spec">🚗 Luxury</span>
                        <span class="vehicle-spec">⛽ Premium</span>
                        <span class="vehicle-spec">👥 5 Seats</span>
                        <span class="vehicle-spec">🧳 3 Bags</span>
                    </div>
                    <div class="vehicle-price">$149/day</div>
                    <div class="vehicle-actions">
                        <button class="btn btn-secondary" onclick="openVehicleModal(3)">Details</button>
                        <button class="btn btn-primary" onclick="showBookingCalendar(3)">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Booking Calendar (Initially Hidden) -->
        <div class="booking-calendar" id="booking-calendar" style="display: none;">
            <div class="calendar-header">
                <h3>Select Your Rental Dates</h3>
                <div class="calendar-nav">
                    <button onclick="changeMonth(-1)">❮ Previous</button>
                    <span id="current-month">June 2023</span>
                    <button onclick="changeMonth(1)">Next ❯</button>
                </div>
            </div>
            <div class="calendar-grid" id="calendar-days-header">
                <div class="calendar-day-header">Sun</div>
                <div class="calendar-day-header">Mon</div>
                <div class="calendar-day-header">Tue</div>
                <div class="calendar-day-header">Wed</div>
                <div class="calendar-day-header">Thu</div>
                <div class="calendar-day-header">Fri</div>
                <div class="calendar-day-header">Sat</div>
            </div>
            <div class="calendar-grid" id="calendar-days"></div>
            <div style="margin-top: 20px; text-align: center;">
                <button class="btn btn-primary" style="padding: 10px 30px;">Continue to Checkout</button>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <div class="page-item active">1</div>
            <div class="page-item">2</div>
            <div class="page-item">3</div>
            <div class="page-item">4</div>
            <div class="page-item">Next →</div>
        </div>
    </div>
    
    <!-- Vehicle Modal -->
    <div class="modal" id="vehicle-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Vehicle Details</h3>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="modal-image" id="modal-image" style="background-image: url('https://source.unsplash.com/random/800x600?car');"></div>
                    <div class="vehicle-price" style="font-size: 24px; margin: 15px 0;">$89/day</div>
                    <button class="btn btn-primary" style="width: 100%; padding: 12px;" onclick="closeModal(); showBookingCalendar(1);">Book This Vehicle</button>
                </div>
                <div>
                    <h4 style="margin-bottom: 15px;">Specifications</h4>
                    <div class="modal-specs">
                        <div class="spec-item">
                            <span>🚗</span>
                            <span>Type: <strong>SUV</strong></span>
                        </div>
                        <div class="spec-item">
                            <span>⛽</span>
                            <span>Fuel: <strong>Hybrid</strong></span>
                        </div>
                        <div class="spec-item">
                            <span>👥</span>
                            <span>Seats: <strong>5</strong></span>
                        </div>
                        <div class="spec-item">
                            <span>🧳</span>
                            <span>Bags: <strong>3</strong></span>
                        </div>
                        <div class="spec-item">
                            <span>⚙️</span>
                            <span>Transmission: <strong>Automatic</strong></span>
                        </div>
                        <div class="spec-item">
                            <span>💨</span>
                            <span>AC: <strong>Yes</strong></span>
                        </div>
                    </div>
                    
                    <div class="modal-features">
                        <h4 style="margin-bottom: 15px;">Features</h4>
                        <div class="features-grid">
                            <div class="feature-item">✓ Bluetooth</div>
                            <div class="feature-item">✓ Backup Camera</div>
                            <div class="feature-item">✓ GPS Navigation</div>
                            <div class="feature-item">✓ Apple CarPlay</div>
                            <div class="feature-item">✓ Heated Seats</div>
                            <div class="feature-item">✓ Sunroof</div>
                            <div class="feature-item">✓ Keyless Entry</div>
                            <div class="feature-item">✓ Lane Assist</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Current date for calendar
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let selectedVehicleId = null;
        
        // Initialize calendar
        function renderCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                               "July", "August", "September", "October", "November", "December"];
            
            document.getElementById('current-month').textContent = 
                `${monthNames[currentMonth]} ${currentYear}`;
            
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            
            let calendarHtml = '';
            
            // Empty cells for days before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                calendarHtml += '<div class="calendar-day"></div>';
            }
            
            // Days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(currentYear, currentMonth, day);
                const today = new Date();
                const isToday = date.toDateString() === today.toDateString();
                const isWeekend = date.getDay() === 0 || date.getDay() === 6;
                const isAvailable = !isWeekend || day % 3 !== 0; // Mock availability logic
                const isHighDemand = day > 15 && day < 22; // Mock high demand dates
                
                let dayClass = 'calendar-day';
                if (isToday) dayClass += ' today';
                if (!isAvailable) dayClass += ' unavailable';
                if (isHighDemand && isAvailable) dayClass += ' high-demand';
                
                calendarHtml += `<div class="${dayClass}" onclick="selectDate(${day})">${day}</div>`;
            }
            
            document.getElementById('calendar-days').innerHTML = calendarHtml;
        }
        
        // Change month
        function changeMonth(offset) {
            currentMonth += offset;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            } else if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }
        
        // Select date
        function selectDate(day) {
            const date = new Date(currentYear, currentMonth, day);
            alert(`Selected date: ${date.toDateString()}\nFor vehicle ID: ${selectedVehicleId}`);
            // In a real app, this would update the booking form
        }
        
        // Show booking calendar for a specific vehicle
        function showBookingCalendar(vehicleId) {
            selectedVehicleId = vehicleId;
            document.getElementById('booking-calendar').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('booking-calendar').offsetTop - 20,
                behavior: 'smooth'
            });
            renderCalendar();
        }
        
        // Open vehicle modal
        function openVehicleModal(vehicleId) {
            // In a real app, this would fetch vehicle details from the server
            document.getElementById('vehicle-modal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('vehicle-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Initialize calendar on page load
        document.addEventListener('DOMContentLoaded', function() {
            // This would be replaced with actual search results from PHP
            console.log('Page loaded. In a real app, PHP would generate the vehicle listings.');
        });
    </script>
</body>
</html>
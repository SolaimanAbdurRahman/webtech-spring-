<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us & Locations - Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --dark: #333;
            --light: #f5f5f5;
            --border: #ddd;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-title {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #666;
            font-size: 18px;
        }
        
        /* Tabs */
        .content-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border);
        }
        
        .content-tab {
            padding: 12px 25px;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .content-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }
        
        /* Contact Form */
        .contact-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            flex: 1;
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 16px;
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .submit-btn:hover {
            background: #45a049;
        }
        
        /* Locations Section */
        .locations-container {
            display: none;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .locations-container.active {
            display: block;
        }
        
        .location-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
        }
        
        .location-tab {
            padding: 15px 20px;
            cursor: pointer;
            font-weight: 500;
            flex: 1;
            text-align: center;
        }
        
        .location-tab.active {
            border-bottom: 3px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
        }
        
        .location-content {
            display: none;
            padding: 30px;
        }
        
        .location-content.active {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        
        .location-map {
            flex: 1;
            min-width: 300px;
            height: 400px;
            background-color: #eee;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }
        
        .map-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f5f5 25%, #e0e0e0 25%, #e0e0e0 50%, #f5f5f5 50%, #f5f5f5 75%, #e0e0e0 75%);
            background-size: 40px 40px;
            color: #666;
            font-size: 18px;
        }
        
        .location-info {
            flex: 1;
            min-width: 300px;
        }
        
        .location-title {
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .location-address {
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .location-hours {
            margin-bottom: 25px;
        }
        
        .hours-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .hours-table tr {
            border-bottom: 1px solid var(--border);
        }
        
        .hours-table tr:last-child {
            border-bottom: none;
        }
        
        .hours-table td {
            padding: 10px 0;
        }
        
        .hours-table td:first-child {
            font-weight: 600;
            width: 120px;
        }
        
        .location-features {
            margin-top: 25px;
        }
        
        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .feature-tag {
            background: #e8f5e9;
            color: var(--primary);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .location-content.active {
                flex-direction: column;
            }
            
            .location-map {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Contact Us & Locations</h1>
            <p class="page-subtitle">Find our branches or send us a message</p>
        </div>
        
        <!-- Content Tabs -->
        <div class="content-tabs">
            <div class="content-tab active" onclick="showContentTab('contact')">Contact Form</div>
            <div class="content-tab" onclick="showContentTab('locations')">Our Locations</div>
        </div>
        
        <!-- Contact Form -->
        <div id="contact" class="contact-form">
            <form id="contactForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" required>
                        <option value="">Select a subject</option>
                        <option value="booking">Booking Inquiry</option>
                        <option value="support">Customer Support</option>
                        <option value="feedback">Feedback</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Send Message</button>
                </div>
            </form>
        </div>
        
        <!-- Locations Section -->
        <div id="locations" class="locations-container">
            <!-- Location Tabs -->
            <div class="location-tabs">
                <div class="location-tab active" onclick="showLocationTab('downtown')">Downtown</div>
                <div class="location-tab" onclick="showLocationTab('airport')">Airport</div>
                <div class="location-tab" onclick="showLocationTab('northside')">Northside</div>
            </div>
            
            <!-- Downtown Location -->
            <div id="downtown" class="location-content active">
                <div class="location-map">
                    <div class="map-placeholder">
                        Downtown Branch Map
                    </div>
                </div>
                <div class="location-info">
                    <h2 class="location-title">Downtown Branch</h2>
                    <div class="location-address">
                        <p>123 Main Street<br>
                        Downtown District<br>
                        Cityville, CV 12345</p>
                        <p>Phone: (555) 123-4567</p>
                    </div>
                    
                    <div class="location-hours">
                        <h3>Business Hours</h3>
                        <table class="hours-table">
                            <tr>
                                <td>Monday - Friday</td>
                                <td>7:00 AM - 9:00 PM</td>
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                <td>8:00 AM - 8:00 PM</td>
                            </tr>
                            <tr>
                                <td>Sunday</td>
                                <td>9:00 AM - 6:00 PM</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="location-features">
                        <h3>Branch Features</h3>
                        <div class="features-list">
                            <span class="feature-tag">24/7 Key Drop-off</span>
                            <span class="feature-tag">Free Parking</span>
                            <span class="feature-tag">Car Wash</span>
                            <span class="feature-tag">Charging Station</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Airport Location -->
            <div id="airport" class="location-content">
                <div class="location-map">
                    <div class="map-placeholder">
                        Airport Branch Map
                    </div>
                </div>
                <div class="location-info">
                    <h2 class="location-title">Airport Branch</h2>
                    <div class="location-address">
                        <p>456 Aviation Blvd<br>
                        Terminal 3, Level 1<br>
                        Cityville International Airport, CV 12345</p>
                        <p>Phone: (555) 987-6543</p>
                    </div>
                    
                    <div class="location-hours">
                        <h3>Business Hours</h3>
                        <table class="hours-table">
                            <tr>
                                <td>Monday - Sunday</td>
                                <td>5:00 AM - 11:00 PM</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="location-features">
                        <h3>Branch Features</h3>
                        <div class="features-list">
                            <span class="feature-tag">24/7 Key Drop-off</span>
                            <span class="feature-tag">Shuttle Service</span>
                            <span class="feature-tag">Express Check-in</span>
                            <span class="feature-tag">Luggage Storage</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Northside Location -->
            <div id="northside" class="location-content">
                <div class="location-map">
                    <div class="map-placeholder">
                        Northside Branch Map
                    </div>
                </div>
                <div class="location-info">
                    <h2 class="location-title">Northside Branch</h2>
                    <div class="location-address">
                        <p>789 Northern Ave<br>
                        Northside Plaza<br>
                        Cityville, CV 12345</p>
                        <p>Phone: (555) 456-7890</p>
                    </div>
                    
                    <div class="location-hours">
                        <h3>Business Hours</h3>
                        <table class="hours-table">
                            <tr>
                                <td>Monday - Friday</td>
                                <td>8:00 AM - 7:00 PM</td>
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                <td>9:00 AM - 5:00 PM</td>
                            </tr>
                            <tr>
                                <td>Sunday</td>
                                <td>Closed</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="location-features">
                        <h3>Branch Features</h3>
                        <div class="features-list">
                            <span class="feature-tag">Weekend Specials</span>
                            <span class="feature-tag">Family Vehicles</span>
                            <span class="feature-tag">Free Coffee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Show content tab (Contact or Locations)
        function showContentTab(tabId) {
            // Hide all content sections
            document.querySelector('.contact-form').style.display = 'none';
            document.querySelector('.locations-container').style.display = 'none';
            
            // Show selected content section
            if (tabId === 'contact') {
                document.querySelector('.contact-form').style.display = 'block';
            } else {
                document.querySelector('.locations-container').style.display = 'block';
            }
            
            // Update active tab
            document.querySelectorAll('.content-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        // Show location tab (specific branch)
        function showLocationTab(locationId) {
            // Hide all location contents
            document.querySelectorAll('.location-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Show selected location content
            document.getElementById(locationId).classList.add('active');
            
            // Update active location tab
            document.querySelectorAll('.location-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        // Handle form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your message! We will respond within 24 hours.');
            this.reset();
        });
        
        // Initialize page - show contact form by default
        document.addEventListener('DOMContentLoaded', function() {
            showContentTab('contact');
        });
    </script>
</body>
</html>
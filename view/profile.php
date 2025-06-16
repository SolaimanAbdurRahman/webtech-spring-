<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Car Rental System</title>
    <style>
        /* Main Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Profile Header */
        .profile-header {
            display: flex;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .avatar-container {
            position: relative;
            margin-right: 30px;
        }
        
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4CAF50;
        }
        
        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        /* Tabs Navigation */
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            border-bottom-color: #4CAF50;
            font-weight: bold;
            color: #4CAF50;
        }
        
        /* Tab Content */
        .tab-content {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background: #45a049;
        }
        
        /* Loyalty Program */
        .loyalty-card {
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .loyalty-tier {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .loyalty-points {
            font-size: 36px;
            margin: 10px 0;
        }
        
        .progress-bar {
            height: 10px;
            background: rgba(255,255,255,0.3);
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .progress {
            height: 100%;
            background: white;
            border-radius: 5px;
            width: 65%; /* Dynamic value from PHP */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="avatar-container">
                <img src="<?php echo htmlspecialchars($user['avatar_url'] ?? 'default-avatar.jpg'); ?>" alt="Profile Photo" class="avatar">
                <div class="avatar-upload" title="Change Photo">
                    <i>+</i>
                </div>
            </div>
            <div>
                <h1><?php echo htmlspecialchars($user['name']); ?></h1>
                <p>Member since: <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
        
        <!-- Tabs Navigation -->
        <div class="tabs">
            <div class="tab active" onclick="openTab(event, 'profile')">Profile</div>
            <div class="tab" onclick="openTab(event, 'preferences')">Preferences</div>
            <div class="tab" onclick="openTab(event, 'loyalty')">Loyalty Program</div>
            <div class="tab" onclick="openTab(event, 'password')">Password</div>
        </div>
        
        <!-- Profile Tab -->
        <div id="profile" class="tab-content active">
            <h2>Personal Information</h2>
            <form method="POST" action="profile.php">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>
                
                <button type="submit" name="update_profile">Save Changes</button>
            </form>
        </div>
        
        <!-- Preferences Tab -->
        <div id="preferences" class="tab-content">
            <h2>Your Rental Preferences</h2>
            <form method="POST" action="profile.php">
                <div class="form-group">
                    <label for="car_type">Preferred Vehicle Type</label>
                    <select id="car_type" name="car_type">
                        <option value="compact" <?php echo ($prefs['car_type'] ?? '') === 'compact' ? 'selected' : ''; ?>>Compact</option>
                        <option value="sedan" <?php echo ($prefs['car_type'] ?? '') === 'sedan' ? 'selected' : ''; ?>>Sedan</option>
                        <option value="suv" <?php echo ($prefs['car_type'] ?? '') === 'suv' ? 'selected' : ''; ?>>SUV</option>
                        <option value="luxury" <?php echo ($prefs['car_type'] ?? '') === 'luxury' ? 'selected' : ''; ?>>Luxury</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="seat_position">Seat Position</label>
                    <select id="seat_position" name="seat_position">
                        <option value="standard" <?php echo ($prefs['seat_position'] ?? '') === 'standard' ? 'selected' : ''; ?>>Standard</option>
                        <option value="upright" <?php echo ($prefs['seat_position'] ?? '') === 'upright' ? 'selected' : ''; ?>>Upright</option>
                        <option value="reclined" <?php echo ($prefs['seat_position'] ?? '') === 'reclined' ? 'selected' : ''; ?>>Reclined</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="climate">Climate Control Preference</label>
                    <select id="climate" name="climate">
                        <option value="auto" <?php echo ($prefs['climate_control'] ?? '') === 'auto' ? 'selected' : ''; ?>>Automatic</option>
                        <option value="cool" <?php echo ($prefs['climate_control'] ?? '') === 'cool' ? 'selected' : ''; ?>>Cool</option>
                        <option value="warm" <?php echo ($prefs['climate_control'] ?? '') === 'warm' ? 'selected' : ''; ?>>Warm</option>
                    </select>
                </div>
                
                <button type="submit" name="update_prefs">Save Preferences</button>
            </form>
        </div>
        
        <!-- Loyalty Program Tab -->
        <div id="loyalty" class="tab-content">
            <div class="loyalty-card">
                <div class="loyalty-tier">
                    <?php 
                    $tier = $loyalty['tier'] ?? 'Silver';
                    echo htmlspecialchars(ucfirst($tier)) . " Member"; 
                    ?>
                </div>
                <div class="loyalty-points">
                    <?php echo number_format($loyalty['points'] ?? 0); ?> Points
                </div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo min(100, ($loyalty['progress'] ?? 0)); ?>%"></div>
                </div>
                <p>Earn <?php echo (($loyalty['next_tier_points'] ?? 1000) - ($loyalty['points'] ?? 0)); ?> more points to reach Gold status</p>
            </div>
            
            <h3>Rewards Available</h3>
            <ul>
                <li>500 pts - Free 1-day upgrade</li>
                <li>1000 pts - Weekend rental discount</li>
                <li>2500 pts - Free 1-day rental</li>
            </ul>
            
            <h3>Recent Activity</h3>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Activity</th>
                    <th>Points</th>
                </tr>
                <?php foreach ($loyalty['recent_activity'] ?? [] as $activity): ?>
                <tr>
                    <td><?php echo htmlspecialchars($activity['date']); ?></td>
                    <td><?php echo htmlspecialchars($activity['description']); ?></td>
                    <td>+<?php echo htmlspecialchars($activity['points']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        
        <!-- Password Tab -->
        <div id="password" class="tab-content">
            <h2>Change Password</h2>
            <form method="POST" action="profile.php">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="update_password">Change Password</button>
            </form>
        </div>
    </div>
    
    <script>
        function openTab(evt, tabName) {
            // Hide all tab contents
            const tabContents = document.getElementsByClassName("tab-content");
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove("active");
            }
            
            // Remove active class from all tabs
            const tabs = document.getElementsByClassName("tab");
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }
            
            // Show the current tab and mark button as active
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --warning: #FFC107;
            --danger: #F44336;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .admin-container {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: 100vh;
        }
        
        /* Admin Sidebar */
        .admin-sidebar {
            background: var(--dark);
            color: white;
            padding: 20px 0;
        }
        
        .admin-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-menu {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        
        .admin-menu li a {
            display: block;
            padding: 12px 20px;
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .admin-menu li a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .admin-menu li.active a {
            background: var(--primary);
        }
        
        .admin-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .admin-main {
            padding: 20px 30px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .admin-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Admin Tabs */
        .admin-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .admin-tab {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 500;
        }
        
        .admin-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }
        
        /* Tab Content */
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .data-table tr:hover {
            background: #f5f5f5;
        }
        
        /* Forms */
        .admin-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 800px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background: white;
        }
        
        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #3d8b40;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 14px;
        }
        
        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .badge-warning {
            background: #fff8e1;
            color: #ff8f00;
        }
        
        .badge-danger {
            background: #ffebee;
            color: #c62828;
        }
        
        /* Key Locker Section */
        .key-locker {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .key-slot {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .key-slot.assigned {
            border-left: 4px solid var(--primary);
        }
        
        .key-slot.missing {
            border-left: 4px solid var(--danger);
        }
        
        .key-slot h4 {
            margin: 0 0 5px;
            font-size: 16px;
        }
        
        .key-slot p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .key-locker {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <div class="admin-sidebar">
            <div class="admin-brand">
                <h2>Admin Panel</h2>
            </div>
            <ul class="admin-menu">
                <li class="active"><a href="admin.php"><i>📊</i> Dashboard</a></li>
                <li><a href="#users" onclick="showTab('users')"><i>👥</i> User Management</a></li>
                <li><a href="#roles" onclick="showTab('roles')"><i>🔑</i> Role Assignment</a></li>
                <li><a href="#content" onclick="showTab('content')"><i>📝</i> Content Moderation</a></li>
                <li><a href="#maintenance" onclick="showTab('maintenance')"><i>🔧</i> Maintenance</a></li>
                <li><a href="#settings" onclick="showTab('settings')"><i>⚙️</i> System Settings</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1 class="admin-title" id="admin-title">Admin Dashboard</h1>
                <div>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                    <button class="btn btn-primary" style="margin-left: 15px;">Logout</button>
                </div>
            </div>
            
            <!-- Admin Tabs -->
            <div class="admin-tabs">
                <div class="admin-tab active" onclick="showTab('users')">User Management</div>
                <div class="admin-tab" onclick="showTab('roles')">Role Assignment</div>
                <div class="admin-tab" onclick="showTab('content')">Content Moderation</div>
                <div class="admin-tab" onclick="showTab('maintenance')">Maintenance</div>
                <div class="admin-tab" onclick="showTab('settings')">System Settings</div>
            </div>
            
            <!-- User Management Tab -->
            <div id="users" class="tab-content active">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <h2>User Management</h2>
                    <button class="btn btn-primary">Add New User</button>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1001</td>
                            <td>John Smith</td>
                            <td>john@example.com</td>
                            <td>Admin</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Suspend</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1002</td>
                            <td>Sarah Johnson</td>
                            <td>sarah@example.com</td>
                            <td>Staff</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Suspend</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1003</td>
                            <td>Michael Brown</td>
                            <td>michael@example.com</td>
                            <td>Customer</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Suspend</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1004</td>
                            <td>Emily Davis</td>
                            <td>emily@example.com</td>
                            <td>Customer</td>
                            <td><span class="badge badge-danger">Suspended</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-primary btn-sm">Activate</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Role Assignment Tab -->
            <div id="roles" class="tab-content">
                <h2>Role Assignment</h2>
                
                <div class="admin-form">
                    <div class="form-group">
                        <label class="form-label">Select User</label>
                        <select class="form-select">
                            <option>John Smith (Admin)</option>
                            <option>Sarah Johnson (Staff)</option>
                            <option>Michael Brown (Customer)</option>
                            <option>Emily Davis (Customer)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Assign Role</label>
                        <select class="form-select">
                            <option>Admin (Full access)</option>
                            <option>Staff (Limited access)</option>
                            <option>Customer (Basic access)</option>
                            <option>Manager (Extended access)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Permissions</label>
                        <div style="border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox"> User Management
                            </label>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox"> Content Moderation
                            </label>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox"> System Configuration
                            </label>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox"> Reporting
                            </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary">Save Role Assignment</button>
                </div>
            </div>
            
            <!-- Content Moderation Tab -->
            <div id="content" class="tab-content">
                <h2>Content Moderation</h2>
                
                <div style="margin-bottom: 20px;">
                    <button class="btn btn-primary" style="margin-right: 10px;">Pending Reviews</button>
                    <button class="btn">Reported Content</button>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Content Type</th>
                            <th>Submitted By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5001</td>
                            <td>Vehicle Review</td>
                            <td>Michael Brown</td>
                            <td>2023-06-15</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Approve</button>
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>5002</td>
                            <td>Profile Photo</td>
                            <td>Emily Davis</td>
                            <td>2023-06-14</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">Approve</button>
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Maintenance Tab -->
            <div id="maintenance" class="tab-content">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <h2>Maintenance Records</h2>
                    <button class="btn btn-primary">Add Maintenance Record</button>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Vehicle ID</th>
                            <th>Make/Model</th>
                            <th>Last Service</th>
                            <th>Next Due</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CR-205</td>
                            <td>Toyota Camry</td>
                            <td>2023-05-20 (Oil Change)</td>
                            <td>2023-07-20</td>
                            <td><span class="badge badge-success">OK</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">View History</button>
                            </td>
                        </tr>
                        <tr>
                            <td>CR-312</td>
                            <td>Ford Explorer</td>
                            <td>2023-06-01 (Tire Rotation)</td>
                            <td>2023-06-15 (Oil Change)</td>
                            <td><span class="badge badge-warning">Due Soon</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">View History</button>
                            </td>
                        </tr>
                        <tr>
                            <td>CR-118</td>
                            <td>Honda Civic</td>
                            <td>2023-04-15 (Brake Check)</td>
                            <td>OVERDUE (Inspection)</td>
                            <td><span class="badge badge-danger">Overdue</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm">View History</button>
                                <button class="btn btn-danger btn-sm">Flag</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Key Locker Management Subsection -->
                <h3 style="margin-top: 40px;">Key Locker Management</h3>
                <p>Track physical key assignments for vehicles</p>
                
                <div class="key-locker">
                    <div class="key-slot assigned">
                        <h4>Slot #1</h4>
                        <p>CR-205 (Camry)</p>
                        <p>Assigned to: John</p>
                    </div>
                    <div class="key-slot">
                        <h4>Slot #2</h4>
                        <p>Available</p>
                    </div>
                    <div class="key-slot assigned">
                        <h4>Slot #3</h4>
                        <p>CR-312 (Explorer)</p>
                        <p>Assigned to: Sarah</p>
                    </div>
                    <div class="key-slot missing">
                        <h4>Slot #4</h4>
                        <p>CR-118 (Civic)</p>
                        <p>MISSING</p>
                    </div>
                    <div class="key-slot">
                        <h4>Slot #5</h4>
                        <p>Available</p>
                    </div>
                </div>
            </div>
            
            <!-- System Settings Tab -->
            <div id="settings" class="tab-content">
                <h2>System Settings</h2>
                
                <div class="admin-form">
                    <div class="form-group">
                        <label class="form-label">System Name</label>
                        <input type="text" class="form-control" value="CarRental Pro">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Default Timezone</label>
                        <select class="form-select">
                            <option>UTC</option>
                            <option selected>America/New_York</option>
                            <option>America/Chicago</option>
                            <option>America/Los_Angeles</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Maintenance Mode</label>
                        <div>
                            <label style="margin-right: 15px;">
                                <input type="radio" name="maintenance" checked> Off
                            </label>
                            <label>
                                <input type="radio" name="maintenance"> On (Admin only)
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Notifications</label>
                        <div>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox" checked> New bookings
                            </label>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox" checked> Maintenance alerts
                            </label>
                            <label style="display: block; margin-bottom: 8px;">
                                <input type="checkbox"> Daily reports
                            </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary">Save Settings</button>
                    <button class="btn btn-danger" style="margin-left: 10px;">Reset to Defaults</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Tab switching functionality
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.admin-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show the selected tab
            document.getElementById(tabId).classList.add('active');
            
            // Mark the clicked tab as active
            event.currentTarget.classList.add('active');
            
            // Update the page title
            const titleMap = {
                'users': 'User Management',
                'roles': 'Role Assignment',
                'content': 'Content Moderation',
                'maintenance': 'Maintenance Records',
                'settings': 'System Settings'
            };
            document.getElementById('admin-title').textContent = titleMap[tabId];
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Set the first tab as active by default
            document.querySelector('.admin-tab').click();
        });
    </script>
</body>
</html>
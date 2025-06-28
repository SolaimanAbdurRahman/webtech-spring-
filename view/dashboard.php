<?php
// Add this at the top of dashboard.php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --warning: #FFC107;
            --danger: #F44336;
            --dark: #333;
            --light: #f5f5f5;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }
        
        .container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background: var(--dark);
            color: white;
            padding: 20px 0;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar-menu li.active a {
            background: var(--primary);
        }
        
        /* Main Content */
        .main-content {
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        /* Dashboard Widgets */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .widget {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .widget-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .widget-value {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .widget-footer {
            font-size: 14px;
            color: #666;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-btn.secondary {
            background: var(--secondary);
        }
        
        /* Activity Log */
        .activity-log {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .log-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .log-table th, .log-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .log-table th {
            font-weight: 600;
            color: #666;
        }
        
        .log-item-type {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .log-item-type.login {
            background: #E3F2FD;
            color: var(--secondary);
        }
        
        .log-item-type.booking {
            background: #E8F5E9;
            color: var(--primary);
        }
        
        /* Maintenance Alerts */
        .alert-widget {
            background: #FFF3E0;
            border-left: 4px solid var(--warning);
        }
        
        .alert-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #FFE0B2;
        }
        
        .alert-item:last-child {
            border-bottom: none;
        }
        
        .alert-severity {
            font-weight: 600;
            color: var(--warning);
        }
        
        /* Pricing Calculator */
        .calculator {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .calculator-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .calculator-total {
            font-size: 20px;
            font-weight: 600;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
            
            .widget-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo" style="padding: 0 20px 20px;">
                <h2>CarRental Pro</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="dashboard.php"><i class="icon">📊</i> Dashboard</a></li>
                <li><a href="vehicles.php"><i class="icon">🚗</i> Vehicles</a></li>
                <li><a href="bookings.php"><i class="icon">📅</i> Bookings</a></li>
                <li><a href="customers.php"><i class="icon">👥</i> Customers</a></li>
                 <li><a href="profile.php"class="action-btn secondary" > profile</a></li>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <li><a href="admin.php"><i class="icon">⚙️</i> Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Dashboard</h1>
                <div class="user-menu">
                    <span style="margin-right: 15px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <button class="action-btn secondary">🔔 Notifications (3)</button>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="action-btn">➕ New Booking</button>
                <button class="action-btn secondary">🚗 Add Vehicle</button>
                <button class="action-btn secondary">👤 Add Customer</button>
                <button class="action-btn secondary" id="exportBtn">📤 Export Data</button>
               
            </div>
            
            <!-- Widget Grid -->
            <div class="widget-grid">
                <!-- Active Bookings Widget -->
                <div class="widget">
                    <div class="widget-header">
                        <h3 class="widget-title">Active Bookings</h3>
                        <span>📅</span>
                    </div>
                    <div class="widget-value">24</div>
                    <div class="widget-footer">+3 from yesterday</div>
                </div>
                
                <!-- Available Vehicles Widget -->
                <div class="widget">
                    <div class="widget-header">
                        <h3 class="widget-title">Available Vehicles</h3>
                        <span>🚗</span>
                    </div>
                    <div class="widget-value">18/32</div>
                    <div class="widget-footer">56% availability</div>
                </div>
                
                <!-- Revenue Widget -->
                <div class="widget">
                    <div class="widget-header">
                        <h3 class="widget-title">Today's Revenue</h3>
                        <span>💰</span>
                    </div>
                    <div class="widget-value">$2,450</div>
                    <div class="widget-footer">12 bookings completed</div>
                </div>
                
                <!-- Pricing Calculator Widget (Staff Only) -->
                <?php if ($_SESSION['user_role'] !== 'customer'): ?>
                <div class="widget calculator">
                    <div class="widget-header">
                        <h3 class="widget-title">Quick Pricing Calculator</h3>
                        <span>🧮</span>
                    </div>
                    <div class="calculator-row">
                        <span>Daily Rate:</span>
                        <span>$<input type="number" value="49" style="width: 60px;"></span>
                    </div>
                    <div class="calculator-row">
                        <span>Days:</span>
                        <span><input type="number" value="3" style="width: 60px;"></span>
                    </div>
                    <div class="calculator-row">
                        <span>Insurance:</span>
                        <span>$15/day</span>
                    </div>
                    <div class="calculator-total">
                        Estimated Total: $192
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Maintenance Alerts (Admin Only) -->
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <div class="widget alert-widget">
                    <div class="widget-header">
                        <h3 class="widget-title">Maintenance Alerts</h3>
                        <span>⚠️</span>
                    </div>
                    <div class="alert-item">
                        <div>
                            <span class="alert-severity">High Priority</span>
                            <span> - Vehicle #CR-205 needs oil change</span>
                        </div>
                        <span>Due today</span>
                    </div>
                    <div class="alert-item">
                        <div>
                            <span class="alert-severity">Medium Priority</span>
                            <span> - 3 vehicles due for inspection</span>
                        </div>
                        <span>Due in 3 days</span>
                    </div>
                    <div class="alert-item">
                        <div>
                            <span class="alert-severity">Low Priority</span>
                            <span> - Tire rotation needed for 2 SUVs</span>
                        </div>
                        <span>Due in 7 days</span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Activity Log -->
            <div class="activity-log">
                <div class="log-header">
                    <h3>Recent Activity</h3>
                    <button class="action-btn secondary">View All</button>
                </div>
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo date('M d, H:i'); ?></td>
                            <td>John Smith</td>
                            <td><span class="log-item-type booking">Booking</span></td>
                            <td>Created booking #CR-10245</td>
                        </tr>
                        <tr>
                            <td><?php echo date('M d, H:i', strtotime('-1 hour')); ?></td>
                            <td>System</td>
                            <td><span class="log-item-type system">System</span></td>
                            <td>Maintenance alert generated for Vehicle #CR-205</td>
                        </tr>
                        <tr>
                            <td><?php echo date('M d, H:i', strtotime('-2 hours')); ?></td>
                            <td>Sarah Johnson</td>
                            <td><span class="log-item-type login">Login</span></td>
                            <td>User logged in from 192.168.1.5</td>
                        </tr>
                        <tr>
                            <td><?php echo date('M d, H:i', strtotime('-3 hours')); ?></td>
                            <td>Michael Brown</td>
                            <td><span class="log-item-type booking">Booking</span></td>
                            <td>Modified booking #CR-10233</td>
                        </tr>
                        <tr>
                            <td><?php echo date('M d, H:i', strtotime('-5 hours')); ?></td>
                            <td>System</td>
                            <td><span class="log-item-type system">System</span></td>
                            <td>Daily backup completed</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Export button functionality
        document.getElementById('exportBtn').addEventListener('click', function() {
            // In a real implementation, this would trigger a server-side export
            alert('Exporting data... This would generate a CSV/PDF in a real application.');
            
            // Example of what might happen:
            // window.location.href = 'export.php?type=dashboard';
        });
        
        // Collapsible activity log rows
        document.querySelectorAll('.log-table tbody tr').forEach(row => {
            row.addEventListener('click', function() {
                // In a real implementation, this might show more details
                console.log('Showing details for activity:', this.cells[2].textContent);
            });
        });
    </script>
</body>
</html>
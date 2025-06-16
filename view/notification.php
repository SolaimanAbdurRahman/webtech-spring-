<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Car Rental System</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Tabs */
        .notification-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }
        
        .notification-tab {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 500;
        }
        
        .notification-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }
        
        /* Notification List */
        .notification-list {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item.unread {
            background-color: #f8faf8;
        }
        
        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
            min-width: 24px;
            text-align: center;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .notification-message {
            color: #666;
            margin-bottom: 5px;
        }
        
        .notification-time {
            font-size: 12px;
            color: #999;
        }
        
        .notification-actions {
            margin-left: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .mark-read {
            background: none;
            border: none;
            color: var(--secondary);
            font-size: 12px;
            cursor: pointer;
            margin-bottom: 5px;
        }
        
        /* Settings */
        .settings-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .form-check {
            margin-bottom: 10px;
        }
        
        .form-check label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .form-check input {
            margin-right: 10px;
        }
        
        .save-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--dark);
            color: white;
            padding: 15px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .toast-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .toast-close {
            margin-left: 15px;
            cursor: pointer;
            opacity: 0.7;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }
        
        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.3;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .notification-item {
                flex-direction: column;
            }
            
            .notification-actions {
                margin-left: 0;
                margin-top: 10px;
                flex-direction: row;
                align-self: flex-end;
            }
            
            .mark-read {
                margin-bottom: 0;
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Notifications</h1>
            <div>
                <span id="unread-count">3 unread</span>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="notification-tabs">
            <div class="notification-tab active" onclick="showTab('notifications')">Notifications</div>
            <div class="notification-tab" onclick="showTab('settings')">Settings</div>
        </div>
        
        <!-- Notifications Tab -->
        <div id="notifications" class="tab-content active">
            <div class="notification-list">
                <!-- Insurance Signature Alert (Toast will appear for these) -->
                <div class="notification-item unread" data-type="insurance">
                    <div class="notification-icon">📝</div>
                    <div class="notification-content">
                        <div class="notification-title">Insurance Document Signed</div>
                        <div class="notification-message">Your full coverage insurance for booking #CR-10245 has been successfully signed and processed.</div>
                        <div class="notification-time">Just now</div>
                    </div>
                    <div class="notification-actions">
                        <button class="mark-read" onclick="markAsRead(this)">Mark as read</button>
                        <button class="view-details" onclick="viewDetails(this)">View details</button>
                    </div>
                </div>
                
                <!-- Regular Notification -->
                <div class="notification-item unread">
                    <div class="notification-icon">🚗</div>
                    <div class="notification-content">
                        <div class="notification-title">Booking Confirmed</div>
                        <div class="notification-message">Your booking for Toyota RAV4 from Jun 15-18 has been confirmed. Pickup at Downtown Branch.</div>
                        <div class="notification-time">2 hours ago</div>
                    </div>
                    <div class="notification-actions">
                        <button class="mark-read" onclick="markAsRead(this)">Mark as read</button>
                        <button class="view-details" onclick="viewDetails(this)">View details</button>
                    </div>
                </div>
                
                <!-- Read Notification -->
                <div class="notification-item">
                    <div class="notification-icon">💰</div>
                    <div class="notification-content">
                        <div class="notification-title">Payment Processed</div>
                        <div class="notification-message">Your payment of $189.50 for booking #CR-10233 has been processed.</div>
                        <div class="notification-time">Yesterday, 3:45 PM</div>
                    </div>
                    <div class="notification-actions">
                        <button class="mark-read" onclick="markAsRead(this)">Mark as read</button>
                        <button class="view-details" onclick="viewDetails(this)">View details</button>
                    </div>
                </div>
                
                <!-- Older Notifications -->
                <div class="notification-item">
                    <div class="notification-icon">⏰</div>
                    <div class="notification-content">
                        <div class="notification-title">Reminder: Upcoming Rental</div>
                        <div class="notification-message">Your rental for Honda Civic starts tomorrow at 10:00 AM.</div>
                        <div class="notification-time">Jun 12, 9:30 AM</div>
                    </div>
                    <div class="notification-actions">
                        <button class="mark-read" onclick="markAsRead(this)">Mark as read</button>
                        <button class="view-details" onclick="viewDetails(this)">View details</button>
                    </div>
                </div>
                
                <div class="notification-item">
                    <div class="notification-icon">🌟</div>
                    <div class="notification-content">
                        <div class="notification-title">Loyalty Points Added</div>
                        <div class="notification-message">You've earned 150 points from your recent rental. You now have 1,200 points.</div>
                        <div class="notification-time">Jun 10, 4:20 PM</div>
                    </div>
                    <div class="notification-actions">
                        <button class="mark-read" onclick="markAsRead(this)">Mark as read</button>
                        <button class="view-details" onclick="viewDetails(this)">View details</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Settings Tab -->
        <div id="settings" class="tab-content">
            <div class="settings-form">
                <h2 style="margin-top: 0;">Notification Preferences</h2>
                
                <div class="form-group">
                    <label class="form-label">Notification Methods</label>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> In-app notifications
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Email notifications
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox"> SMS text messages
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Notification Types</label>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Booking confirmations
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Payment receipts
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Rental reminders
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Insurance documents
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox"> Promotional offers
                        </label>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" checked> Loyalty program updates
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Notification Frequency</label>
                    <select class="form-control">
                        <option>Immediately</option>
                        <option>Daily summary</option>
                        <option>Weekly summary</option>
                    </select>
                </div>
                
                <button class="save-btn" onclick="saveSettings()">Save Preferences</button>
            </div>
        </div>
    </div>
    
    <!-- Toast Notification (Hidden by default) -->
    <div class="toast" id="insurance-toast">
        <div class="toast-icon">📝</div>
        <div class="toast-message">Insurance document signed successfully!</div>
        <div class="toast-close" onclick="hideToast()">×</div>
    </div>
    
    <script>
        // Show toast notification for insurance signatures
        function showInsuranceToast() {
            const toast = document.getElementById('insurance-toast');
            toast.classList.add('show');
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
        
        // Hide toast manually
        function hideToast() {
            document.getElementById('insurance-toast').classList.remove('show');
        }
        
        // Tab switching
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.notification-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show the selected tab
            document.getElementById(tabId).classList.add('active');
            
            // Mark the clicked tab as active
            event.currentTarget.classList.add('active');
        }
        
        // Mark notification as read
        function markAsRead(button) {
            const notification = button.closest('.notification-item');
            notification.classList.remove('unread');
            updateUnreadCount();
        }
        
        // View notification details
        function viewDetails(button) {
            const notification = button.closest('.notification-item');
            const title = notification.querySelector('.notification-title').textContent;
            alert(`Showing details for: ${title}`);
            
            // Also mark as read when viewing details
            notification.classList.remove('unread');
            updateUnreadCount();
        }
        
        // Update unread count
        function updateUnreadCount() {
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            document.getElementById('unread-count').textContent = 
                unreadCount === 0 ? 'No unread notifications' : `${unreadCount} unread`;
        }
        
        // Save notification settings
        function saveSettings() {
            alert('Notification preferences saved!');
            // In a real app, this would send to server
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            updateUnreadCount();
            
            // Check if we should show insurance toast (simulating coming from signature flow)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('insurance_signed') === 'true') {
                showInsuranceToast();
            }
        });
    </script>
</body>
</html>
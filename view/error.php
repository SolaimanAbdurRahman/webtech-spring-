<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | Car Rental System</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #4CAF50;
            --secondary: #2196F3;
            --dark: #333;
            --light: #f5f5f5;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: var(--dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }
        
        .error-container {
            max-width: 600px;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        /* Error Content */
        .error-code {
            font-size: 120px;
            font-weight: 700;
            margin: 0;
            line-height: 1;
            color: var(--primary);
            opacity: 0.8;
        }
        
        .error-title {
            font-size: 32px;
            margin: 20px 0 10px;
        }
        
        .error-message {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        /* Error Image */
        .error-image {
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #3d8b40;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Footer */
        .error-footer {
            margin-top: 40px;
            color: #999;
            font-size: 14px;
        }
        
        /* 500 Error Specific */
        .server-error .error-code {
            color: var(--danger);
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .error-container {
                width: 90%;
                padding: 30px 20px;
            }
            
            .error-code {
                font-size: 80px;
            }
            
            .error-title {
                font-size: 24px;
            }
            
            .error-message {
                font-size: 16px;
            }
            
            .error-image {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- 404 Error Page -->
    <div class="error-container" id="error-404">
        <div class="error-image" style="background-image: url('https://cdn-icons-png.flaticon.com/512/755/755014.png')"></div>
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-message">
            The page you're looking for doesn't exist or has been moved.
            Please check the URL or navigate back to our homepage.
        </p>
        <div class="action-buttons">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
        <div class="error-footer">
            Need help? Contact our <a href="mailto:support@carrental.com">support team</a>
        </div>
    </div>

    <!-- 500 Error Page (Hidden by default) -->
    <div class="error-container server-error" id="error-500" style="display: none;">
        <div class="error-image" style="background-image: url('https://cdn-icons-png.flaticon.com/512/756/756114.png')"></div>
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Internal Server Error</h2>
        <p class="error-message">
            Something went wrong on our end. We're working to fix the issue.
            Please try again later or contact support if the problem persists.
        </p>
        <div class="action-buttons">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:location.reload()" class="btn btn-secondary">Refresh Page</a>
        </div>
        <div class="error-footer">
            Technical support: <a href="mailto:tech@carrental.com">tech@carrental.com</a>
        </div>
    </div>

    <script>
        // This script would determine which error to show based on server response
        // For demo purposes, you can switch between errors by uncommenting one of these:
        // document.getElementById('error-404').style.display = 'none';
        // document.getElementById('error-500').style.display = 'block';
        
        // In a real application, your server would serve the appropriate error page
    </script>
</body>
</html>
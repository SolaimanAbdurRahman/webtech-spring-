<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
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
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        /* Desktop Navigation (hidden on mobile) */
        .desktop-nav {
            display: flex;
            gap: 25px;
        }
        
        .desktop-nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .desktop-nav a:hover {
            color: var(--primary);
        }
        
        /* Mobile Menu Button (hidden on desktop) */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }
        
        .hamburger {
            width: 25px;
            height: 3px;
            background: var(--dark);
            position: relative;
            transition: all 0.3s;
        }
        
        .hamburger::before,
        .hamburger::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 3px;
            background: var(--dark);
            transition: all 0.3s;
        }
        
        .hamburger::before {
            top: -8px;
        }
        
        .hamburger::after {
            top: 8px;
        }
        
        .mobile-menu-btn.active .hamburger {
            background: transparent;
        }
        
        .mobile-menu-btn.active .hamburger::before {
            transform: rotate(45deg);
            top: 0;
        }
        
        .mobile-menu-btn.active .hamburger::after {
            transform: rotate(-45deg);
            top: 0;
        }
        
        /* Mobile Menu (hidden by default) */
        .mobile-menu {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .mobile-menu.active {
            max-height: 500px;
        }
        
        .mobile-nav {
            list-style: none;
            padding: 20px;
        }
        
        .mobile-nav li {
            margin-bottom: 15px;
        }
        
        .mobile-nav a {
            color: var(--dark);
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .mobile-nav a:hover {
            background: #f5f5f5;
            color: var(--primary);
        }
        
        /* Main Content (for demo) */
        .main-content {
            padding: 100px 20px 50px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Mobile Menu -->
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">CarRental</a>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <a href="/vehicles">Vehicles</a>
                <a href="/bookings">Bookings</a>
                <a href="/locations">Locations</a>
                <a href="/offers">Special Offers</a>
                <a href="/contact">Contact</a>
            </nav>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span class="hamburger"></span>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <ul class="mobile-nav">
                <li><a href="/vehicles">Vehicles</a></li>
                <li><a href="/bookings">Bookings</a></li>
                <li><a href="/locations">Locations</a></li>
                <li><a href="/offers">Special Offers</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/login" style="color: var(--primary); font-weight: 600;">Login</a></li>
            </ul>
        </div>
    </header>
    
    <!-- Main Content (for demo) -->
    <main class="main-content">
        <h1>Welcome to Car Rental System</h1>
        <p>This is a demo of the responsive mobile menu. Resize your browser window to see the mobile menu appear when the screen width is less than 768px.</p>
    </main>
    
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            
            // Toggle body scroll when menu is open
            if (mobileMenu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        
        // Close menu when clicking on a link
        const mobileNavLinks = document.querySelectorAll('.mobile-nav a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.header-container') && 
                mobileMenu.classList.contains('active')) {
                mobileMenuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>
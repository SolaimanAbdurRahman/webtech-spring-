-- Car Rental System Database Schema
-- Created for XAMPP MySQL

-- Drop database if exists and create new one
DROP DATABASE IF EXISTS car_rental_system;
CREATE DATABASE car_rental_system;
USE car_rental_system;

-- Users table (customers and staff)
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    user_type ENUM('customer', 'staff', 'admin') DEFAULT 'customer',
    driver_license_number VARCHAR(20),
    driver_license_expiry DATE,
    date_of_birth DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Vehicle categories
CREATE TABLE vehicle_categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(50) NOT NULL,
    description TEXT,
    base_daily_rate DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Vehicles table
CREATE TABLE vehicles (
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    vin VARCHAR(17),
    license_plate VARCHAR(20) UNIQUE NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    category_id INT,
    color VARCHAR(30),
    mileage INT DEFAULT 0,
    fuel_type ENUM('gasoline', 'diesel', 'electric', 'hybrid') DEFAULT 'gasoline',
    transmission ENUM('automatic', 'manual') DEFAULT 'automatic',
    seats INT DEFAULT 5,
    doors INT DEFAULT 4,
    daily_rate DECIMAL(10,2) NOT NULL,
    hourly_rate DECIMAL(10,2),
    status ENUM('available', 'rented', 'maintenance', 'out_of_service') DEFAULT 'available',
    current_fuel_level ENUM('empty', 'quarter', 'half', 'three_quarter', 'full') DEFAULT 'full',
    last_maintenance_date DATE,
    next_maintenance_date DATE,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES vehicle_categories(category_id)
);

-- Vehicle images
CREATE TABLE vehicle_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    vehicle_id INT,
    image_path VARCHAR(255) NOT NULL,
    image_type ENUM('main', 'interior', 'exterior', '360_tour') DEFAULT 'main',
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE
);

-- Pickup locations
CREATE TABLE pickup_locations (
    location_id INT PRIMARY KEY AUTO_INCREMENT,
    location_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    is_24hr BOOLEAN DEFAULT FALSE,
    is_airport BOOLEAN DEFAULT FALSE,
    opening_hours TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insurance packages
CREATE TABLE insurance_packages (
    package_id INT PRIMARY KEY AUTO_INCREMENT,
    package_name VARCHAR(100) NOT NULL,
    description TEXT,
    daily_rate DECIMAL(10,2) NOT NULL,
    coverage_limit DECIMAL(10,2),
    deductible DECIMAL(10,2),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Customer preferences
CREATE TABLE customer_preferences (
    preference_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    favorite_car_type VARCHAR(50),
    seat_position_preference TEXT,
    preferred_pickup_location INT,
    preferred_insurance_package INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (preferred_pickup_location) REFERENCES pickup_locations(location_id),
    FOREIGN KEY (preferred_insurance_package) REFERENCES insurance_packages(package_id)
);

-- Bookings table
CREATE TABLE bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    vehicle_id INT,
    pickup_location_id INT,
    return_location_id INT,
    pickup_date DATETIME NOT NULL,
    return_date DATETIME NOT NULL,
    actual_pickup_date DATETIME,
    actual_return_date DATETIME,
    total_amount DECIMAL(10,2) NOT NULL,
    insurance_package_id INT,
    insurance_amount DECIMAL(10,2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    pickup_fuel_level ENUM('empty', 'quarter', 'half', 'three_quarter', 'full'),
    return_fuel_level ENUM('empty', 'quarter', 'half', 'three_quarter', 'full'),
    pickup_notes TEXT,
    return_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
    FOREIGN KEY (pickup_location_id) REFERENCES pickup_locations(location_id),
    FOREIGN KEY (return_location_id) REFERENCES pickup_locations(location_id),
    FOREIGN KEY (insurance_package_id) REFERENCES insurance_packages(package_id)
);

-- Damage reports
CREATE TABLE damage_reports (
    report_id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT,
    vehicle_id INT,
    reported_by INT,
    report_type ENUM('pickup', 'return') NOT NULL,
    damage_description TEXT,
    damage_photos TEXT,
    estimated_repair_cost DECIMAL(10,2),
    customer_signature TEXT,
    staff_signature TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
    FOREIGN KEY (reported_by) REFERENCES users(user_id)
);

-- Maintenance records
CREATE TABLE maintenance_records (
    record_id INT PRIMARY KEY AUTO_INCREMENT,
    vehicle_id INT,
    maintenance_type VARCHAR(100) NOT NULL,
    description TEXT,
    odometer_reading INT,
    cost DECIMAL(10,2),
    performed_by INT,
    maintenance_date DATE NOT NULL,
    next_maintenance_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id),
    FOREIGN KEY (performed_by) REFERENCES users(user_id)
);

-- Loyalty program
CREATE TABLE loyalty_program (
    loyalty_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    points_balance INT DEFAULT 0,
    tier ENUM('bronze', 'silver', 'gold', 'platinum') DEFAULT 'bronze',
    total_spent DECIMAL(10,2) DEFAULT 0,
    join_date DATE DEFAULT CURRENT_DATE,
    last_activity_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Loyalty transactions
CREATE TABLE loyalty_transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    loyalty_id INT,
    booking_id INT,
    points_earned INT DEFAULT 0,
    points_redeemed INT DEFAULT 0,
    transaction_type ENUM('earn', 'redeem', 'expire') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loyalty_id) REFERENCES loyalty_program(loyalty_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)
);

-- Additional services
CREATE TABLE additional_services (
    service_id INT PRIMARY KEY AUTO_INCREMENT,
    service_name VARCHAR(100) NOT NULL,
    description TEXT,
    daily_rate DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Booking services (many-to-many relationship)
CREATE TABLE booking_services (
    booking_id INT,
    service_id INT,
    quantity INT DEFAULT 1,
    total_amount DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (booking_id, service_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (service_id) REFERENCES additional_services(service_id)
);

-- Insert sample data
INSERT INTO vehicle_categories (category_name, description, base_daily_rate) VALUES
('Economy', 'Fuel-efficient compact cars', 45.00),
('Compact', 'Small to medium sized cars', 55.00),
('Midsize', 'Comfortable family cars', 65.00),
('Full-size', 'Large comfortable cars', 75.00),
('SUV', 'Sport Utility Vehicles', 85.00),
('Luxury', 'Premium vehicles', 120.00);

INSERT INTO pickup_locations (location_name, address, city, state, zip_code, phone, is_24hr, is_airport) VALUES
('Downtown Office', '123 Main St', 'New York', 'NY', '10001', '212-555-0100', FALSE, FALSE),
('Airport Terminal A', '456 Airport Blvd', 'New York', 'NY', '10002', '212-555-0200', TRUE, TRUE),
('Midtown Branch', '789 5th Ave', 'New York', 'NY', '10003', '212-555-0300', FALSE, FALSE);

INSERT INTO insurance_packages (package_name, description, daily_rate, coverage_limit, deductible) VALUES
('Basic Coverage', 'Standard liability coverage', 15.00, 50000.00, 1000.00),
('Premium Coverage', 'Comprehensive coverage with roadside assistance', 25.00, 100000.00, 500.00),
('Full Protection', 'Maximum coverage with zero deductible', 35.00, 200000.00, 0.00);

INSERT INTO additional_services (service_name, description, daily_rate) VALUES
('GPS Navigation', 'Portable GPS device', 10.00),
('Child Seat', 'Safety seat for children', 15.00),
('Additional Driver', 'Add another authorized driver', 12.00),
('Roadside Assistance', '24/7 emergency assistance', 8.00);

-- Create admin user
INSERT INTO users (username, email, password_hash, first_name, last_name, user_type) VALUES
('admin', 'admin@carrental.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'admin');

-- Insert comprehensive vehicle fleet
INSERT INTO vehicles (
    vin, category_id, make, model, year, color, mileage, fuel_type, transmission, seats, daily_rate, hourly_rate, status, current_fuel_level, last_maintenance_date, next_maintenance_date, license_plate, image_url, doors
) VALUES
('1HGBH41JXMN109186', 1, 'Toyota', 'Corolla', 2022, 'White', 12000, 'gasoline', 'automatic', 5, 45.00, 8.00, 'available', 'full', '2023-12-01', '2024-06-01', 'ABC123', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('2HGCM82633A004352', 1, 'Honda', 'Civic', 2021, 'Silver', 15000, 'gasoline', 'automatic', 5, 44.00, 7.50, 'available', 'three_quarter', '2023-11-15', '2024-05-15', 'XYZ789', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('3FAHP0HA6AR123456', 2, 'Ford', 'Focus', 2020, 'Blue', 18000, 'gasoline', 'manual', 5, 42.00, 7.00, 'available', 'half', '2023-10-10', '2024-04-10', 'FOC456', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('4T1BF1FK5GU123456', 2, 'Toyota', 'Yaris', 2022, 'Red', 9000, 'gasoline', 'automatic', 5, 40.00, 6.50, 'available', 'full', '2023-12-10', '2024-06-10', 'YAR123', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4),
('5NPE24AF4FH123456', 3, 'Hyundai', 'Elantra', 2021, 'Black', 14000, 'gasoline', 'automatic', 5, 48.00, 8.50, 'available', 'three_quarter', '2023-11-20', '2024-05-20', 'ELN789', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('1HGCM82633A004353', 3, 'Honda', 'Accord', 2020, 'Gray', 20000, 'gasoline', 'automatic', 5, 50.00, 9.00, 'available', 'half', '2023-10-20', '2024-04-20', 'ACD456', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('2T1BURHE5JC123456', 4, 'Toyota', 'Camry', 2022, 'White', 8000, 'gasoline', 'automatic', 5, 55.00, 10.00, 'available', 'full', '2023-12-15', '2024-06-15', 'CAM789', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('3FA6P0H74HR123456', 4, 'Ford', 'Fusion', 2021, 'Blue', 13000, 'gasoline', 'automatic', 5, 53.00, 9.50, 'available', 'three_quarter', '2023-11-25', '2024-05-25', 'FSN123', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4),
('1C4RJFBG0FC123456', 5, 'Jeep', 'Grand Cherokee', 2022, 'Black', 10000, 'gasoline', 'automatic', 5, 70.00, 13.00, 'available', 'full', '2023-12-20', '2024-06-20', 'JGC456', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('5XYKT3A10EG123456', 5, 'Kia', 'Sorento', 2021, 'Silver', 17000, 'gasoline', 'automatic', 7, 68.00, 12.50, 'available', 'three_quarter', '2023-11-30', '2024-05-30', 'SOR789', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('WBA3A5C56DF123456', 6, 'BMW', '3 Series', 2022, 'White', 7000, 'gasoline', 'automatic', 5, 90.00, 18.00, 'available', 'full', '2023-12-25', '2024-06-25', 'BMW123', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('WAUZZZ8V0JA123456', 6, 'Audi', 'A4', 2021, 'Black', 11000, 'gasoline', 'automatic', 5, 95.00, 19.00, 'available', 'three_quarter', '2023-12-05', '2024-06-05', 'AUD456', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4),
('JTDKN3DU0A1234567', 1, 'Toyota', 'Prius', 2020, 'Green', 22000, 'hybrid', 'automatic', 5, 47.00, 8.00, 'available', 'half', '2023-10-05', '2024-04-05', 'PRI123', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('1N4AL3AP7JC123456', 2, 'Nissan', 'Sentra', 2021, 'Blue', 16000, 'gasoline', 'automatic', 5, 43.00, 7.00, 'available', 'three_quarter', '2023-11-10', '2024-05-10', 'SEN456', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('2C3CDXBG0JH123456', 4, 'Dodge', 'Charger', 2022, 'Red', 9000, 'gasoline', 'automatic', 5, 60.00, 11.00, 'available', 'full', '2023-12-18', '2024-06-18', 'CHG789', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('3VW2K7AJ5FM123456', 3, 'Volkswagen', 'Jetta', 2020, 'Gray', 21000, 'gasoline', 'manual', 5, 49.00, 8.50, 'available', 'half', '2023-10-18', '2024-04-18', 'JET123', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4),
('1FTFW1EF1EFA12345', 5, 'Ford', 'Explorer', 2021, 'Black', 13000, 'gasoline', 'automatic', 7, 75.00, 14.00, 'available', 'three_quarter', '2023-11-28', '2024-05-28', 'EXP456', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('5YJ3E1EA7KF123456', 6, 'Tesla', 'Model 3', 2022, 'White', 6000, 'electric', 'automatic', 5, 120.00, 22.00, 'available', 'full', '2023-12-28', '2024-06-28', 'TSL789', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('SALWR2RV1KA123456', 5, 'Land Rover', 'Range Rover', 2022, 'Silver', 8000, 'gasoline', 'automatic', 5, 130.00, 25.00, 'available', 'full', '2023-12-30', '2024-06-30', 'RRV123', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('WDDGF8ABXEA123456', 6, 'Mercedes-Benz', 'C-Class', 2021, 'Black', 9000, 'gasoline', 'automatic', 5, 110.00, 20.00, 'available', 'three_quarter', '2023-12-08', '2024-06-08', 'MBZ456', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4),
('1G1BE5SM2J7123456', 1, 'Chevrolet', 'Cruze', 2020, 'Blue', 23000, 'gasoline', 'automatic', 5, 41.00, 6.50, 'available', 'half', '2023-10-08', '2024-04-08', 'CRZ123', 'https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg', 4),
('2T3ZF4DV9BW123456', 5, 'Toyota', 'RAV4', 2021, 'Red', 14000, 'gasoline', 'automatic', 5, 72.00, 13.50, 'available', 'three_quarter', '2023-11-18', '2024-05-18', 'RVF456', 'https://cdn.pixabay.com/photo/2016/11/29/09/32/auto-1868726_1280.jpg', 4),
('3CZRE4H59BG123456', 5, 'Honda', 'CR-V', 2022, 'White', 9000, 'gasoline', 'automatic', 5, 74.00, 14.00, 'available', 'full', '2023-12-12', '2024-06-12', 'CRV789', 'https://cdn.pixabay.com/photo/2013/07/12/15/55/ford-150238_1280.png', 4),
('1N6AD0EV7KN123456', 5, 'Nissan', 'Frontier', 2020, 'Gray', 25000, 'gasoline', 'manual', 5, 65.00, 12.00, 'available', 'half', '2023-10-12', '2024-04-12', 'FRN123', 'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_1280.jpg', 4); 
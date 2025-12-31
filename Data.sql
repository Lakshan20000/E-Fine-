-- Create database
CREATE DATABASE efine_system;
USE efine_system;

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- License holders table
CREATE TABLE license_holders (
    license_id VARCHAR(20) PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100) NOT NULL,
    license_type VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Fine types table
CREATE TABLE fine_types (
    fine_code VARCHAR(10) PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL
);

-- Police stations table
CREATE TABLE police_stations (
    station_id INT AUTO_INCREMENT PRIMARY KEY,
    station_name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Fines table
CREATE TABLE fines (
    fine_id INT AUTO_INCREMENT PRIMARY KEY,
    license_id VARCHAR(20) NOT NULL,
    fine_code VARCHAR(10) NOT NULL,
    vehicle_no VARCHAR(20) NOT NULL,
    station_id INT NOT NULL,
    imposed_date DATE NOT NULL,
    payment_date DATE,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'paid') DEFAULT 'pending',
    receipt_no VARCHAR(20) UNIQUE,
    FOREIGN KEY (license_id) REFERENCES license_holders(license_id),
    FOREIGN KEY (fine_code) REFERENCES fine_types(fine_code),
    FOREIGN KEY (station_id) REFERENCES police_stations(station_id)
);

-- Sample data
INSERT INTO fine_types (fine_code, description, amount) VALUES
('F1001', 'Speeding', 1000.00),
('F1002', 'Red Light Violation', 1500.00),
('F1003', 'Illegal Parking', 500.00),
('F1004', 'No Helmet', 3000.00),
('F1005', 'Seat Belt Violation', 2000.00);

INSERT INTO police_stations (station_name, location) VALUES
('Vavuniya', 'Vavuniya Town'),
('Poovaraasankulam', 'Vavuniya District'),
('Seddikulam', 'Vavuniya District'),
('Nulumkulam', 'Vavuniya District'),
('Vellavely', 'Vavuniya District'),
('Kaluwanchikudy', 'Batticaloa District'),
('Trincomalee', 'Trincomalee District'),
('Ampara', 'Ampara District'),
('Batticaloa', 'Batticaloa District'),
('Kandy', 'Kandy District'),
('Mannar', 'Mannar District'),
('Jaffna', 'Jaffna District'),
('Mullaithevu', 'Mullaithevu District'),
('Kilinochchi', 'Kilinochchi District');

-- Sample license holder (password is 'password123' hashed)
INSERT INTO users (first_name, last_name, email, password) VALUES
('Dilakshan', 'K', 'dilakshan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO license_holders (license_id, user_id, full_name, license_type) VALUES
('D12345678', 1, 'Dilakshan K', 'Heavy'),
('D98765432', NULL, 'Jane Smith', 'Commercial'),
('D45678912', NULL, 'Robert Johnson', 'Learner');
-- database.sql

-- Create the database
CREATE DATABASE IF NOT EXISTS courier_system;
USE courier_system;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Couriers Table
CREATE TABLE IF NOT EXISTS couriers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_id VARCHAR(50) NOT NULL UNIQUE,
    sender_name VARCHAR(100),
    receiver_name VARCHAR(100),
    pickup_address TEXT,
    delivery_address TEXT,
    status ENUM('Pending', 'In Transit', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin user (password: admin123)
INSERT INTO users (username, password, role) VALUES 
('admin', MD5('admin123'), 'admin');

-- Insert sample couriers
INSERT INTO couriers (tracking_id, sender_name, receiver_name, pickup_address, delivery_address, status) VALUES
('CR1001', 'John Doe', 'Alice Smith', '123 Main St, City A', '456 Oak Rd, City B', 'In Transit'),
('CR1002', 'Bob Johnson', 'Clara Lee', '789 Pine Ln, Town X', '101 Maple Ave, Town Y', 'Pending');

-- Optional: Add index for tracking_id
CREATE INDEX idx_tracking_id ON couriers(tracking_id);

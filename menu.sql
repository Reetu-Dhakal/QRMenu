-- HamroMenu Database Schema
-- Multi-restaurant system
-- Created for PHP + MySQL

CREATE DATABASE IF NOT EXISTS hamromenu;
USE hamromenu;

-- 1. Restaurants table
CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Users table (owner, admin, staff)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('owner', 'admin', 'staff') NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE SET NULL
);

-- 3. Tables (physical restaurant tables)
CREATE TABLE tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    table_number INT NOT NULL,
    qr_code VARCHAR(255) NOT NULL UNIQUE,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- 4. Menu items
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
);

-- 5. Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    table_id INT NOT NULL,
    status ENUM('pending', 'preparing', 'ready', 'completed', 'cancelled') DEFAULT 'pending',
    note TEXT DEFAULT NULL,
    total_amount DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE
);

-- 6. Order items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

-- Sample data for testing

-- Insert a restaurant
INSERT INTO restaurants (name, address, phone) VALUES
('Sunrise Cafe', 'Thamel, Kathmandu', '9800000001'),
('Momo Hub', 'Patan, Lalitpur', '9800000002');

-- Insert an owner (password = "password123" hashed)
INSERT INTO users (restaurant_id, name, email, password, role) VALUES
(NULL, 'Raj Owner', 'raj@hamromenu.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner'),
(1, 'Sita Admin', 'sita@sunrise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(1, 'Ram Staff', 'ram@sunrise.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff');

-- Insert tables for restaurant 1
INSERT INTO tables (restaurant_id, table_number, qr_code) VALUES
(1, 1, 'SUNRISE-TABLE-001'),
(1, 2, 'SUNRISE-TABLE-002'),
(1, 3, 'SUNRISE-TABLE-003'),
(2, 1, 'MOMOHUB-TABLE-001'),
(2, 2, 'MOMOHUB-TABLE-002');

-- Insert menu items for restaurant 1
INSERT INTO menu_items (restaurant_id, name, description, price, category, is_available) VALUES
(1, 'Steamed Momo', '8 pieces with sauce', 150.00, 'Momo', 1),
(1, 'Fried Momo', '8 pieces crispy fried', 170.00, 'Momo', 1),
(1, 'Chicken Chowmein', 'Stir fried noodles', 180.00, 'Noodles', 1),
(1, 'Masala Tea', 'Hot spiced tea', 60.00, 'Drinks', 1),
(1, 'Cold Coffee', 'Iced blended coffee', 120.00, 'Drinks', 1);

-- Insert menu items for restaurant 2
INSERT INTO menu_items (restaurant_id, name, description, price, category, is_available) VALUES
(2, 'Buff Momo', '10 pieces with achaar', 160.00, 'Momo', 1),
(2, 'Jhol Momo', 'Momo in spicy soup', 190.00, 'Momo', 1),
(2, 'Lassi', 'Sweet yogurt drink', 80.00, 'Drinks', 1);
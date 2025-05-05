
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE DATABASE IF NOT EXISTS `shopVNB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `shopVNB`;


CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    pass VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    sex ENUM('M', 'F', 'Other'),
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci UNIQUE NOT NULL,
    numOfVisit INT DEFAULT 0,
    role ENUM('admin', 'customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create branch table
CREATE TABLE `branch` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    userId INT,
    FOREIGN KEY (userId) REFERENCES user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create brand table
CREATE TABLE `brand` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create product table
CREATE TABLE `product` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    description TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    listsOfInmage TEXT, -- Assuming this stores image URLs as JSON or comma-separated
    price DECIMAL(10, 2) NOT NULL,
    createdDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    category VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    rating DECIMAL(3, 2),
    color VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    size VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    branchId INT,
    FOREIGN KEY (branchId) REFERENCES branch(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create ProductCart table
CREATE TABLE `ProductCart` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    userId INT,
    FOREIGN KEY (userId) REFERENCES user(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create Has table (junction table between ProductCart and product)
CREATE TABLE `Has` (
    productCartId INT,
    productId INT,
    quantity INT DEFAULT 1,
    PRIMARY KEY (productCartId, productId),
    FOREIGN KEY (productCartId) REFERENCES ProductCart(id),
    FOREIGN KEY (productId) REFERENCES product(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create review table
CREATE TABLE `review` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    details TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    title VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    stars INT CHECK (stars BETWEEN 1 AND 5),
    FOREIGN KEY (userId) REFERENCES user(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create techno table
CREATE TABLE `techno` (
    name VARCHAR(100) PRIMARY KEY,
    description TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create use table (junction table between product and techno)
CREATE TABLE `use` (
    productId INT,
    technoName VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    PRIMARY KEY (productId, technoName),
    FOREIGN KEY (productId) REFERENCES product(id),
    FOREIGN KEY (technoName) REFERENCES techno(name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create Changeable inf table
CREATE TABLE `Changeable inf` (
    id INT AUTO_INCREMENT PRIMARY KEY
);

-- Create Formal inf table
CREATE TABLE `Formal inf` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    description TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create Q&A table
CREATE TABLE `Q&A` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    question TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    answer TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    productId INT,
    FOREIGN KEY (productId) REFERENCES product(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Insert sample data into user table
INSERT INTO user (phone, address, pass, sex, name, email, numOfVisit, role) VALUES
('123-456-7890', '123 Main St, City', 'password123', 'M', 'John Doe', 'john@example.com', 15, 'customer'),
('234-567-8901', '456 Oak St, Town', 'password456', 'F', 'Jane Smith', 'jane@example.com', 8, 'customer'),
('345-678-9012', '789 Pine St, Village', 'adminpass', 'M', 'Admin User', 'admin@example.com', 42, 'admin'),
('456-789-0123', '321 Elm St, County', 'managerpass', 'F', 'Manager User', 'manager@example.com', 30, 'customer'),
('567-890-1234', '654 Maple St, State', 'password789', 'Other', 'Alex Johnson', 'alex@example.com', 5, 'customer');

-- Insert sample data into branch table
INSERT INTO branch (address, userId) VALUES
('100 Commerce St, Downtown', 4),
('200 Market St, Uptown', 3),
('300 Shop St, Midtown', 4);

-- Insert sample data into brand table
INSERT INTO brand (name) VALUES
('TechBrand'),
('FashionStyle'),
('HomeGoods'),
('SportGear'),
('KitchenWare');

-- Insert sample data into product table
INSERT INTO product (name, description, listsOfInmage, price, category, rating, color, size, branchId) VALUES
('Smartphone X', 'Latest smartphone with advanced features', 'image1.jpg,image2.jpg', 999.99, 'Electronics', 4.7, 'Black', '6.5 inch', 1),
('Designer Jeans', 'Premium quality jeans', 'jeans1.jpg,jeans2.jpg', 89.99, 'Clothing', 4.2, 'Blue', 'M', 2),
('Coffee Maker', 'Automatic coffee maker with timer', 'coffee1.jpg', 129.99, 'Kitchen', 4.5, 'Silver', 'Standard', 3),
('Running Shoes', 'Lightweight running shoes', 'shoes1.jpg,shoes2.jpg', 79.99, 'Footwear', 4.8, 'Red', '42', 2),
('Wireless Headphones', 'Noise cancelling headphones', 'headphones1.jpg', 199.99, 'Electronics', 4.6, 'White', 'One Size', 1);

-- Insert sample data into ProductCart table
INSERT INTO ProductCart (address, userId) VALUES
('123 Main St, City', 1),
('456 Oak St, Town', 2),
('654 Maple St, State', 5);

-- Insert sample data into Has table
INSERT INTO Has (productCartId, productId, quantity) VALUES
(1, 1, 1),
(1, 3, 2),
(2, 2, 1),
(2, 4, 1),
(3, 5, 1);

-- Insert sample data into review table
INSERT INTO review (userId, details, title, stars, date) VALUES
(1, 'Great product, works as expected', 'Excellent Purchase', 5, '2023-01-15 10:30:00'),
(2, 'Good quality but a bit expensive', 'Good but Pricey', 4, '2023-02-20 14:45:00'),
(5, 'Not what I expected, disappointed', 'Disappointing', 2, '2023-03-10 09:15:00'),
(1, 'Amazing sound quality', 'Best Headphones', 5, '2023-04-05 16:20:00'),
(2, 'Fits perfectly and looks great', 'Perfect Fit', 5, '2023-05-12 11:10:00');

-- Insert sample data into techno table
INSERT INTO techno (name, description) VALUES
('5G', 'Fifth generation mobile network technology'),
('Bluetooth 5.0', 'Latest Bluetooth technology for wireless connectivity'),
('Wi-Fi 6', 'Latest Wi-Fi standard for faster wireless internet'),
('OLED', 'Organic Light Emitting Diode display technology'),
('NFC', 'Near Field Communication for contactless communication');

-- Insert sample data into use table
INSERT INTO `use` (productId, technoName) VALUES
(1, '5G'),
(1, 'Bluetooth 5.0'),
(1, 'NFC'),
(5, 'Bluetooth 5.0'),
(3, 'Wi-Fi 6');

-- Insert sample data into Changeable inf table
INSERT INTO `Changeable inf` (id) VALUES (1), (2), (3);

-- Insert sample data into Formal inf table
INSERT INTO `Formal inf` (name, description) VALUES
('Warranty Info', 'Standard 1-year manufacturer warranty'),
('Return Policy', '30-day return policy for unused items'),
('Shipping Info', 'Free shipping on orders over $50');

-- Insert sample data into Q&A table
INSERT INTO `Q&A` (category, question, answer, productId) VALUES
('Technical', 'Is this phone compatible with carrier X?', 'Yes, it works with all major carriers', 1),
('Usage', 'How long does the battery last?', 'Up to 12 hours of continuous use', 1),
('Size', 'Do these jeans run small?', 'They are true to size', 2),
('Features', 'Does the coffee maker have a timer?', 'Yes, it has a programmable timer', 3),
('Compatibility', 'Will these headphones work with my iPhone?', 'Yes, they are compatible with all smartphones', 5);
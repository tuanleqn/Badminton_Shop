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
    Product_id INT,
    FOREIGN KEY (userId) REFERENCES user(id),
    FOREIGN KEY (Product_id) REFERENCES product(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create Response table
CREATE TABLE `Response` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    lastName VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    content TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('read', 'unread', 'responsed') DEFAULT 'unread',
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;









-- Insert sample data into review table
INSERT INTO review (userId, details, title, stars, date, Product_id) VALUES
(1, 'Great product, works as expected', 'Excellent Purchase', 5, '2023-01-15 10:30:00', 1),
(2, 'Good quality but a bit expensive', 'Good but Pricey', 4, '2023-02-20 14:45:00', 2),
(5, 'Not what I expected, disappointed', 'Disappointing', 2, '2023-03-10 09:15:00', 3),
(1, 'Amazing sound quality', 'Best Headphones', 5, '2023-04-05 16:20:00', 5),
(2, 'Fits perfectly and looks great', 'Perfect Fit', 5, '2023-05-12 11:10:00', 4);

-- Insert sample data for Response table
INSERT INTO `Response` (firstName, lastName, email, content) VALUES
('John', 'Doe', 'john.doe@example.com', 'Great service and products!'),
('Jane', 'Smith', 'jane.smith@example.com', 'I love the badminton rackets here'),
('Mike', 'Johnson', 'mike.j@example.com', 'The shipping was very fast');

-- Insert sample data into use table

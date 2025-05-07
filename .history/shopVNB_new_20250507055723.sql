SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `shopVNB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `shopVNB`;


-- Create review table
CREATE TABLE `review` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    details TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    title VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    stars INT CHECK (stars BETWEEN 1 AND 5),
    Product_id INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
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
    status ENUM('new', 'read', 'replied') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `order` (
    `orderId` INT AUTO_INCREMENT PRIMARY KEY,
    `userId` INT NOT NULL,
    `receiverName` VARCHAR(255) NOT NULL,
    `receiverPhone` VARCHAR(20) NOT NULL,
    `receiverAddress` TEXT NOT NULL,
    `receiverEmail` VARCHAR(255) NOT NULL,
    `paymentMethod` VARCHAR(50) NOT NULL,
    `orderDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `totalPayment` DECIMAL(10, 2) NOT NULL
);

CREATE TABLE `order_details` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orderId` INT NOT NULL,
    `productId` INT NOT NULL,
    `quantity` INT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`orderId`) REFERENCES `order`(`orderId`)
);

ALTER TABLE `order_details`
ADD COLUMN `userId` INT NOT NULL AFTER `orderId`,
ADD COLUMN `name` VARCHAR(255) NOT NULL AFTER `productId`,
ADD COLUMN `size` VARCHAR(50) DEFAULT 'N/A' AFTER `name`,
ADD COLUMN `color` VARCHAR(50) DEFAULT 'N/A' AFTER `size`,
ADD COLUMN `image` VARCHAR(255) DEFAULT NULL AFTER `price`;

-- Insert sample reviews
INSERT INTO review (userId, details, title, stars, date, Product_id, status) VALUES
(1, 'Great product, works as expected', 'Excellent Purchase', 5, '2023-01-15 10:30:00', 1, 'approved'),
(2, 'Good quality but a bit expensive', 'Good but Pricey', 4, '2023-02-20 14:45:00', 2, 'approved'),
(5, 'Not what I expected, disappointed', 'Disappointing', 2, '2023-03-10 09:15:00', 3, 'approved'),
(1, 'Amazing quality and feel', 'Best Racket', 5, '2023-04-05 16:20:00', 1, 'approved'),
(2, 'Fits perfectly and looks great', 'Perfect Fit', 5, '2023-05-12 11:10:00', 4, 'approved');



-- Insert sample responses
INSERT INTO `Response` (firstName, lastName, email, content, status) VALUES
('John', 'Doe', 'john.doe@example.com', 'Great service and products!', 'read'),
('Jane', 'Smith', 'jane.smith@example.com', 'I love the badminton rackets here', 'replied'),
('Mike', 'Johnson', 'mike.j@example.com', 'The shipping was very fast', 'new');
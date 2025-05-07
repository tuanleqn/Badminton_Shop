SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `shopVNB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `shopVNB`;



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
ADD COLUMN `name` VARCHAR(255) NOT NULL AFTER `productId`,
ADD COLUMN `size` VARCHAR(50) DEFAULT 'N/A' AFTER `name`,
ADD COLUMN `color` VARCHAR(50) DEFAULT 'N/A' AFTER `size`,
ADD COLUMN `image` VARCHAR(255) DEFAULT NULL AFTER `price`;


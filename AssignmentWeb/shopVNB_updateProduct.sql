-- Add a table to store product ratings
CREATE TABLE `product_ratings` (
    product_id INT PRIMARY KEY,
    average_rating FLOAT DEFAULT 0,
    total_reviews INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES product(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `product`
DROP COLUMN `listsOfInmage`;

CREATE TABLE `product_images` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    image_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES product(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- CREATE TABLE `product_colors` (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     product_id INT NOT NULL,
--     color VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
--     FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Update product_images table
ALTER TABLE `product_images`
DROP FOREIGN KEY `product_images_ibfk_1`,
ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE;

-- Update review table
ALTER TABLE `review`
DROP FOREIGN KEY `review_ibfk_2`,
ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE;

-- Update product_ratings table
ALTER TABLE `product_ratings`
DROP FOREIGN KEY `product_ratings_ibfk_1`,
ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE;


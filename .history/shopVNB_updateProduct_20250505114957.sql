-- Add a table to store product ratings
CREATE TABLE `product_ratings` (
    product_id INT PRIMARY KEY,
    average_rating FLOAT DEFAULT 0,
    total_reviews INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES product(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `product`
DROP COLUMN `listsOfInmage`;
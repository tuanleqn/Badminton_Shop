<?php

require_once __DIR__ . '/../helper/config.php';

class SiteModel {
    private $db;

    public function __construct() {
        global $DBConnect;

        $this->db = $DBConnect;
        if (!$this->db) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $shop_DB = mysqli_select_db($this->db, "shopVNB");
    }

    public function getDbConnection() {
        return $this->db;
    }

    public function getProductDetails($productId) {
        $query = "SELECT p.*, pi.image_path 
                  FROM product p
                  LEFT JOIN product_images pi ON p.id = pi.product_id
                  WHERE p.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getProductImages($productId) {
        $query = "SELECT image_path FROM product_images WHERE product_id = ? ORDER BY image_order ASC, id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['image_path'];
        }
        return $images;
    }

    public function ProductImages($productId) {
        $query = "SELECT id, image_path, image_order 
                  FROM product_images 
                  WHERE product_id = ? 
                  ORDER BY image_order ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function updateImageOrder($imageOrder) {
        $orderArray = explode(',', $imageOrder);
        foreach ($orderArray as $order => $imageId) {
            $sql = "UPDATE product_images SET image_order = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ii', $order, $imageId);
            $stmt->execute();
        }
    }
    public function updateProduct($productId, $data) {
        $sql = "UPDATE product 
            SET name = ?, description = ?, price = ?, category = ?, color = ?, size = ?, brandId = ? 
            WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param(
            'ssdsssii',
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category'],
            $data['color'],
            $data['size'],
            $data['brandId'],
            $productId
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    

    public function getAverageRating($productId) {
        $query = "SELECT AVG(stars) AS average_rating FROM review WHERE product_id = ? AND status = 'approved'";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['average_rating'] ?? 0;
    }

    public function getTotalReviews($productId) {
        $query = "SELECT COUNT(*) AS total_reviews FROM review WHERE product_id = ? AND status = 'approved'";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['total_reviews'] ?? 0;
    }

    public function getProductReviews($productId) {
        $query = "SELECT * FROM review WHERE product_id = ? AND status = 'approved' ORDER BY date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }
    public function submitReview($productId, $stars, $title, $details) {
        // Validate input
        if ($productId > 0 && $stars > 0 && $stars <= 5 && !empty($title) && !empty($details)) {
            $query = "INSERT INTO review (product_id, stars, title, details, date, status) VALUES (?, ?, ?, ?, NOW(), 'pending')";
            $stmt = $this->db->prepare($query);
    
            if (!$stmt) {
                error_log("Prepare failed: " . $this->db->error);
                return false;
            }
    
            $stmt->bind_param("iiss", $productId, $stars, $title, $details);
    
            if ($stmt->execute()) {
                $stmt->close();
                return true; // Success
            } else {
                error_log("Execute failed: " . $stmt->error);
                $stmt->close();
                return false; // Failure
            }
        } else {
            error_log("Invalid input: productId=$productId, stars=$stars, title=$title, details=$details");
            return false; // Invalid input
        }
    }

    public function getProductReviewsWithUser($productId) {
        $query = "
            SELECT r.*, u.name AS reviewer_name, u.email AS reviewer_email
            FROM review r
            LEFT JOIN user u ON r.userId = u.id
            WHERE r.Product_id = ? AND r.status = 'approved'
            ORDER BY r.date DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProducts($limit, $offset, $orderBy = 'p.id ASC', $categories = null, $brands = null, $sizes = null) {
        $query = "
            SELECT 
                p.id, 
                p.name, 
                p.price, 
                p.category, 
                p.size, 
                p.description, 
                b.name AS brand_name, 
                COALESCE(pr.average_rating, 0) AS average_rating, 
                (SELECT image_path 
                 FROM product_images 
                 WHERE product_images.product_id = p.id 
                 ORDER BY image_order ASC LIMIT 1) AS image_path
            FROM product p
            LEFT JOIN product_ratings pr ON p.id = pr.product_id
            LEFT JOIN brand b ON p.brandId = b.id
        ";
    
        $conditions = [];
        $params = [];
        $types = '';
    
        if ($categories) {
            $placeholders = implode(',', array_fill(0, count($categories), '?'));
            $conditions[] = "p.category IN ($placeholders)";
            $params = array_merge($params, $categories);
            $types .= str_repeat('s', count($categories));
        }
    
        if ($brands) {
            $placeholders = implode(',', array_fill(0, count($brands), '?'));
            $conditions[] = "p.brandId IN ($placeholders)";
            $params = array_merge($params, $brands);
            $types .= str_repeat('i', count($brands));
        }
    
        if ($sizes) {
            $placeholders = implode(',', array_fill(0, count($sizes), '?'));
            $conditions[] = "p.size IN ($placeholders)";
            $params = array_merge($params, $sizes);
            $types .= str_repeat('s', count($sizes));
        }
    
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $query .= " ORDER BY $orderBy LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';
    
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function getAllBrands() {
        $query = "SELECT DISTINCT b.id, b.name FROM brand b INNER JOIN product p ON b.id = p.brandId";
        $result = $this->db->query($query);
    
        $brands = [];
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
        return $brands;
    }

    public function getAllSizes() {
        $query = "SELECT DISTINCT size FROM product WHERE size IS NOT NULL AND size != ''";
        $result = $this->db->query($query);
    
        $sizes = [];
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row['size'];
        }
        return $sizes;
    }

    public function getTotalProducts() {
        $query = "SELECT COUNT(*) AS total FROM product";
        $res = mysqli_query($this->db, $query);
        $row = mysqli_fetch_assoc($res);
        return $row['total'];
    }
    
    public function updateProductRatings() {
        $query = "
            INSERT INTO product_ratings (product_id, average_rating, total_reviews)
            SELECT
                Product_id,
                AVG(stars) AS average_rating,
                COUNT(*) AS total_reviews
            FROM
                review
            WHERE
                status = 'approved'
            GROUP BY
                Product_id
            ON DUPLICATE KEY UPDATE
                average_rating = VALUES(average_rating),
                total_reviews = VALUES(total_reviews);
        ";
        $this->db->query($query);
    }

    

    public function getSortedProducts($limit, $offset, $orderBy) {
        $query = "SELECT 
                      p.*, 
                      COALESCE(pr.average_rating, 0) AS average_rating, 
                      COALESCE(pr.total_reviews, 0) AS total_reviews,
                      pi.image_path
                  FROM product p
                  LEFT JOIN product_ratings pr ON p.id = pr.product_id
                  LEFT JOIN product_images pi ON p.id = pi.product_id
                  ORDER BY $orderBy
                  LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    
        return $products;
    }
    
    public function syncProductRatings() {
        $query = "
            UPDATE product p
            LEFT JOIN product_ratings pr ON p.id = pr.product_id
            SET p.rating = COALESCE(pr.average_rating, 0);
        ";
        $this->db->query($query);
    }

    public function searchProducts($search = '') {
        $query = "SELECT COUNT(*) AS total FROM product WHERE name LIKE ? OR description LIKE ?";
        $stmt = $this->db->prepare($query);
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function getProducts($search = '', $limit = 5, $offset = 0) {
        $query = "
            SELECT p.*, MIN(pi.image_path) AS image
            FROM product p
            LEFT JOIN product_images pi ON 
            p.id = pi.product_id AND pi.image_order = 0
            WHERE p.name LIKE ? OR p.description LIKE ?
            GROUP BY p.id
            LIMIT ? OFFSET ?
        ";
        $stmt = $this->db->prepare($query);
    
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return [];
        }
    
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Debug: Log the fetched products
        $products = $result->fetch_all(MYSQLI_ASSOC);
        error_log('Products fetched from database: ' . print_r($products, true));
    
        return $products;
    }

    public function getNewestProducts($limit = 4) {
        $query = "
        SELECT 
            p.id, 
            p.name, 
            p.price, 
            p.category, 
            p.description, 
            COALESCE(pr.average_rating, 0) AS average_rating, 
            (SELECT image_path 
             FROM product_images 
             WHERE product_images.product_id = p.id 
             ORDER BY image_order ASC LIMIT 1) AS image_path
        FROM product p
        LEFT JOIN product_ratings pr ON p.id = pr.product_id
        ORDER BY p.createdDate DESC
        LIMIT ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function deleteProductById($productId) {
        $query = "DELETE FROM product WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);

        return $stmt->execute();
    }


    public function removeImages($imageIds) {
        foreach ($imageIds as $imageId) {
            $sql = "SELECT image_path FROM product_images WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $imageId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
    
            if ($row) {
                $filePath = __DIR__ . '/uploads/' . $row['image_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $deleteSql = "DELETE FROM product_images WHERE id = ?";
                $deleteStmt = $this->db->prepare($deleteSql);
                $deleteStmt->bind_param('i', $imageId);
                $deleteStmt->execute();
            }
        }
    }

    public function uploadImages($productId, $images) {
        // Define the absolute path to the uploads directory
        $uploadDir = __DIR__ . '/../uploads/';
        
        // Check if the directory exists, and create it if it doesn't
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        // Loop through the uploaded files
        foreach ($images['tmp_name'] as $key => $tmpName) {
            // Generate a unique file name
            $fileName = uniqid() . '-' . basename($images['name'][$key]);
            $targetPath = $uploadDir . $fileName;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Save the relative path to the database
                $imagePath = 'uploads/' . $fileName;
                $sql = "INSERT INTO product_images (product_id, image_path, image_order) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $currentOrder = $key; // Use the key as the order
                $stmt->bind_param('isi', $productId, $imagePath, $currentOrder);
                $stmt->execute();
            } else {
                // Log an error if the file upload fails
                error_log("Failed to upload file: " . $tmpName);
            }
        }
    }
    public function getProductColors($productId) {
        $sql = "SELECT color FROM product_colors WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        $colors = [];
        while ($row = $result->fetch_assoc()) {
            $colors[] = $row['color'];
        }
        return $colors;
    }

    public function deleteProductColors($productId) {
        $sql = "DELETE FROM product_colors WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
    }

    public function getProductById($productId) {
        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getReviews($status, $limit, $offset) {
        $sql = "SELECT r.*, p.name AS product_name 
                FROM review r 
                JOIN product p ON r.product_id = p.id 
                WHERE r.status = ? 
                ORDER BY r.date DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sii', $status, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getStatusReviews($status) {
        $sql = "SELECT COUNT(*) AS total FROM review WHERE status = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function getProductCountsByCategory() {
        $query = "SELECT category, COUNT(*) as count 
                  FROM product 
                  GROUP BY category";
        $result = $this->db->query($query);
        
        $counts = [];
        while ($row = $result->fetch_assoc()) {
            $counts[$row['category']] = $row['count'];
        }
        return $counts;
    }

}
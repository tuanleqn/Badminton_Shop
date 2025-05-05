<?php
// filepath: d:\Tieu_Anh\xampp\htdocs\Shop-badminton\AssignmentWeb\app\controllers\product\add.php
require_once __DIR__ . '/../../../helper/config.php';

function addProduct($data, $file) {
    global $DBConnect;

    try {
        $name = $DBConnect->real_escape_string($data['name']);
        $description = $DBConnect->real_escape_string($data['description']);
        $price = floatval($data['price']);
        $category = $DBConnect->real_escape_string($data['category']);
        $color = $DBConnect->real_escape_string($data['color']);
        $size = $DBConnect->real_escape_string($data['size']);
        $brandID = intval($data['branchId']);

        // Insert product into the database
        $stmt = $DBConnect->prepare("INSERT INTO product (name, description, price, category, color, size, branchId) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsssi", $name, $description, $price, $category, $color, $size, $brandID);

        if (!$stmt->execute()) {
            error_log("Database Error (product): " . $stmt->error);
            return ['success' => false, 'message' => 'Failed to add product: ' . $stmt->error];
        }

        // Get the ID of the newly inserted product
        $productId = $stmt->insert_id;
        if (!$productId) {
            error_log("Failed to retrieve product ID after insertion.");
            return ['success' => false, 'message' => 'Failed to retrieve product ID.'];
        }

        // Handle file upload
        if (isset($file['listsOfImage']) && !empty($file['listsOfImage']['name'][0])) {
            $uploadDir = __DIR__ . '/../../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }

            $imageOrder = 0; // Initialize image order

            foreach ($file['listsOfImage']['name'] as $key => $imageName) {
                $tmpName = $file['listsOfImage']['tmp_name'][$key];
                $uniqueName = uniqid() . '-' . basename($imageName);
                $filePath = $uploadDir . $uniqueName;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $imagePath = 'uploads/' . $uniqueName;

                    // Insert image into the product_images table with image_order
                    $imageStmt = $DBConnect->prepare("INSERT INTO product_images (product_id, image_path, image_order) VALUES (?, ?, ?)");
                    $imageStmt->bind_param("isi", $productId, $imagePath, $imageOrder);

                    if (!$imageStmt->execute()) {
                        error_log("Database Error (product_images): " . $imageStmt->error);
                        return ['success' => false, 'message' => 'Failed to save image: ' . $imageStmt->error];
                    }

                    $imageOrder++; // Increment image order for the next image
                } else {
                    error_log("Failed to move uploaded file: " . $imageName);
                }
            }
        } else {
            error_log("No images uploaded or an error occurred.");
        }

        return ['success' => true, 'message' => 'Product and images added successfully.'];
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        return ['success' => false, 'message' => 'An unexpected error occurred.'];
    }
}
?>
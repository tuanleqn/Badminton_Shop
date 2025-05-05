<?php
try {
    require_once __DIR__ . '/../../../helper/config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $createdDate = date('Y-m-d H:i:s');
        $category = $_POST['category'];
        $rating = $_POST['rating'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $branchId = $_POST['branchId'];

        // Validate required fields
        if (empty($name) || empty($price) || empty($category)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
            exit;
        }

        // Insert product into the database
        $sql = "INSERT INTO product (name, description, price, createdDate, category, rating, color, size, branchId) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $DBConnect->prepare($sql);
        $stmt->bind_param('ssssssisi', $name, $description, $price, $createdDate, $category, $rating, $color, $size, $branchId);

        if (!$stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add product.']);
            exit;
        }

        // Get the ID of the newly inserted product
        $productId = $stmt->insert_id;

        // Handle file uploads
        if (!empty($_FILES['listsOfImage']['name'][0])) {
            $uploadDir = __DIR__ . '/../../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }

            foreach ($_FILES['listsOfImage']['name'] as $key => $imageName) {
                $tmpName = $_FILES['listsOfImage']['tmp_name'][$key];
                $uniqueName = uniqid() . '-' . basename($imageName);
                $targetPath = $uploadDir . $uniqueName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imagePath = 'uploads/' . $uniqueName;

                    // Insert image into the product_images table
                    $imageStmt = $DBConnect->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    $imageStmt->bind_param("is", $productId, $imagePath);

                    if (!$imageStmt->execute()) {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to save image.']);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to upload images.']);
                    exit;
                }
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Product and images added successfully.']);
        $stmt->close();
        $DBConnect->close();
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    error_log("Trace: " . $e->getTraceAsString());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
}
?>
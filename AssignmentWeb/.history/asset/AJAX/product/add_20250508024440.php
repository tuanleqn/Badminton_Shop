<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once dirname(__DIR__, 3) . '/app/helper/config.php';
    $db = new db();
    $DBConnect = $db->connect;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate that all required POST data exists
        $requiredFields = ['name', 'price', 'category', 'brandId'];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            error_log('Missing required fields: ' . implode(', ', $missingFields));
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields: ' . implode(', ', $missingFields)]);
            exit;
        }

        if (!isset($_POST['brandId']) || trim($_POST['brandId']) === '') {
            error_log('Missing brandId in POST data');
            echo json_encode(['status' => 'error', 'message' => 'Missing brandId']);
            exit;
        }
        
        $brandId = filter_var($_POST['brandId'], FILTER_VALIDATE_INT);

        if ($brandId === false || $brandId <= 0) {
            error_log('Invalid brand ID: ' . $_POST['brandId']);
            echo json_encode(['status' => 'error', 'message' => 'Invalid brand ID']);
            exit;
        }

        // Sanitize and validate inputs
        $name = strip_tags(trim($_POST['name']));
        $description = isset($_POST['description']) ? strip_tags(trim($_POST['description'])) : '';
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $createdDate = date('Y-m-d H:i:s');
        $category = strip_tags(trim($_POST['category']));
        // Fix rating validation and conversion
        $rating = isset($_POST['rating']) ? filter_var($_POST['rating'], FILTER_VALIDATE_FLOAT) : 0.0;
        $rating = is_numeric($rating) ? number_format((float)$rating, 1, '.', '') : '0.0';
        $brandId = filter_var($_POST['brandId'], FILTER_VALIDATE_INT);
        $color = isset($_POST['color']) ? implode // Keep the input as a comma-separated string
        $size = isset($_POST['size']) ? implode(', ', array_map('strip_tags', explode(',', $_POST['size']))) : ''; // Fix size processing

        // Validate price and branchId
        if ($price === false || $price <= 0) {
            error_log('Invalid price value: ' . $_POST['price']);
            echo json_encode(['status' => 'error', 'message' => 'Invalid price value']);
            exit;
        }

        if (empty($color)) {
            echo json_encode(['status' => 'error', 'message' => 'Color is required']);
            exit;
        }

        if ($brandId === false || $brandId <= 0) {
            error_log('Invalid brand ID: ' . $_POST['brandId']);
            echo json_encode(['status' => 'error', 'message' => 'Invalid brand ID']);
            exit;
        }

        // Start transaction
        $DBConnect->begin_transaction();

        try {
            // Insert product into the database
            $sql = "INSERT INTO product (name, description, price, createdDate, category, rating, color, size, brandId) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $DBConnect->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $DBConnect->error);
            }

            $stmt->bind_param('ssdsssisi', $name, $description, $price, $createdDate, $category, $rating, $color, $size, $brandId);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

           
            $productId = $stmt->insert_id;

            // Handle file uploads
            if (!empty($_FILES['listsOfImage']['name'][0])) {
                $uploadDir = __DIR__ . '/../../../uploads/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        throw new Exception("Failed to create upload directory");
                    }
                }

                foreach ($_FILES['listsOfImage']['name'] as $key => $imageName) {
                    if ($_FILES['listsOfImage']['error'][$key] !== UPLOAD_ERR_OK) {
                        throw new Exception("Upload error for file {$imageName}: " . $_FILES['listsOfImage']['error'][$key]);
                    }

                    $tmpName = $_FILES['listsOfImage']['tmp_name'][$key];
                    $fileInfo = pathinfo($imageName);
                    $uniqueName = uniqid() . '-' . $fileInfo['filename'] . '.' . $fileInfo['extension'];
                    $targetPath = $uploadDir . $uniqueName;

                    // Validate file type
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $tmpName);
                    if (!in_array($mimeType, $allowedTypes)) {
                        throw new Exception("Invalid file type for {$imageName}");
                    }

                    if (!move_uploaded_file($tmpName, $targetPath)) {
                        throw new Exception("Failed to move uploaded file {$imageName}");
                    }

                    $imagePath = 'uploads/' . $uniqueName;
                    $imageStmt = $DBConnect->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    if (!$imageStmt) {
                        throw new Exception("Failed to prepare image insert statement");
                    }
                    
                    $imageStmt->bind_param("is", $productId, $imagePath);
                    if (!$imageStmt->execute()) {
                        throw new Exception("Failed to save image record: " . $imageStmt->error);
                    }
                }
            }

            // Commit transaction
            $DBConnect->commit();
            echo json_encode(['status' => 'success', 'message' => 'Product and images added successfully.']);
        } catch (Exception $e) {
            $DBConnect->rollback();
            throw $e;
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($imageStmt)) $imageStmt->close();
            $DBConnect->close();
        }
    } else {
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    error_log("Exception in add.php: " . $e->getMessage());
    error_log("Trace: " . $e->getTraceAsString());
    echo json_encode([
        'status' => 'error', 
        'message' => 'An unexpected error occurred. Please check the logs for details.',
        'debug' => $e->getMessage() // Remove this in production
    ]);
}
?>
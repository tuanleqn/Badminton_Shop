<?php
require_once __DIR__ . '/../models/SiteModel.php';

class ReviewController {
    private $db;

    public function __construct() {
        $model = new SiteModel();
        $this->db = $model->getDbConnection();
    }

    public function updateReviewStatus($id, $status) {
        if (in_array($status, ['approved', 'rejected'])) {
            $query = "UPDATE review SET status = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $status, $id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }
}

// Handle the incoming request
header('Content-Type: application/json');

// Clear any previous output
if (ob_get_length()) {
    ob_clean();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the JSON payload
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if ($data === null) {
            throw new Exception('Invalid JSON: ' . json_last_error_msg());
        }

        if (isset($data['id']) && isset($data['status'])) {
            $id = intval($data['id']);
            $status = $data['status'];

            $reviewController = new ReviewController();
            if ($reviewController->updateReviewStatus($id, $status)) {
                // If the review is approved, update the product_ratings table if needed
                if ($status === 'approved') {
                    $siteModel = new SiteModel();
                    $siteModel->updateProductRatings();
                }

                echo json_encode(['success' => true, 'message' => 'Review status updated successfully.']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update review status.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    exit;
}
?>
<?php
require_once __DIR__ . '/../../models/SiteModel.php';
require_once __DIR__ . '/../update_review.php'; // Include the ReviewController

header('Content-Type: application/json');

// Clear any previous output
if (ob_get_length()) {
    ob_clean();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the JSON payload
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['status'])) {
            $id = intval($data['id']);
            $status = $data['status'];

            $reviewController = new ReviewController();
            if ($reviewController->updateReviewStatus($id, $status)) {
                // If the review is approved, update the product_ratings table
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
            echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
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
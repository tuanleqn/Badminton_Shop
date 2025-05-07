<?php
require_once __DIR__ . '/../controllers/OrderController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    $orderId = $data['id'] ?? null;
    $status = $data['status'] ?? null;

    if ($orderId && $status) {
        $controller = new OrderController();
        $response = $controller->updateOrderStatus($orderId, $status);

        // Return a JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Return an error response
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
}
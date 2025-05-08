<?php
// filepath: d:\Tieu_Anh\xampp\htdocs\Shop-badminton\AssignmentWeb\app\controllers\order.php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../helper/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action']) && $data['action'] === 'saveOrder') {
        $session = Session::getInstance();
        $user = $session->get('user');
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit();
        }

        if (
            !isset($data['receiverInfo']) ||
            !isset($data['paymentMethod']) ||
            !isset($data['totalPayment']) ||
            !isset($data['cart']) ||
            empty($data['cart'])
        ) {
            echo json_encode(['success' => false, 'message' => 'Invalid order data']);
            exit();
        }
        

        $orderModel = new OrderModel();
        $orderId = $orderModel->saveOrder(
            $user['id'],
            $data['receiverInfo'],
            $data['paymentMethod'],
            $data['totalPayment'],
            $data['cart']
        );

        if ($orderId) {
            echo json_encode(['success' => true, 'orderId' => $orderId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save order']);
        }
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getOrders') {
    $session = Session::getInstance();
    $user = $session->get('user');
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    $orderModel = new OrderModel();
    $orders = $orderModel->getOrdersByUserId($user['id']);
    echo json_encode(['success' => true, 'orders' => $orders]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
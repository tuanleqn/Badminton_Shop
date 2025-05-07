<?php

require_once __DIR__ . '/../helper/config.php';
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController extends db
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function updateOrderStatus($orderId, $status)
    {
        return $this->orderModel->updateOrderStatus($orderId, $status);
    }

    public function manageOrders($statusFilter, $page, $limit) {
        $orderModel = new OrderModel();
    
        // Fetch orders
        $orders = $orderModel->getOrders($statusFilter, $page, $limit);
    
        // Fetch total orders for pagination
        $totalOrders = $orderModel->getTotalOrders($statusFilter);
        $totalPages = ceil($totalOrders / $limit);
    
        return [
            'orders' => $orders,
            'totalPages' => ceil($totalOrders / $limit),
            'currentPage' => $page,
            'totalOrders' => $totalOrders, // Add totalProducts to the response
        ];
    }
}
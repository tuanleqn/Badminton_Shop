<?php

require_once __DIR__ . '/../helper/config.php';

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
}
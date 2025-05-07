<?php

require_once __DIR__ . '/../helper/config.php';

class OrderController extends db
{
    public function updateOrderStatus($orderId, $status) {
        try {
            $query = "UPDATE `order` SET `status` = ? WHERE `orderId` = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->bind_param("si", $status, $orderId);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'Order status updated successfully'];
            } else {
                return ['success' => false, 'message' => 'No changes made to the order status'];
            }
        } catch (Exception $e) {
            error_log("Error updating order status: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while updating the order status'];
        }
    }
}
<?php
// filepath: d:\Tieu_Anh\xampp\htdocs\Shop-badminton\AssignmentWeb\app\models\OrderModel.php
require_once __DIR__ . '/../helper/config.php';
class OrderModel extends db {
    public function saveOrder($userId, $receiverInfo, $paymentMethod, $totalPayment, $cart) {
        try {
            // Start transaction
            mysqli_begin_transaction($this->connect);

            // Insert into `order` table
            $query = "INSERT INTO `order` (userId, receiverName, receiverPhone, receiverAddress, receiverEmail, paymentMethod, totalPayment)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect->prepare($query);
            $stmt->bind_param(
                "isssssd",
                $userId,
                $receiverInfo['name'],
                $receiverInfo['phone'],
                $receiverInfo['address'],
                $receiverInfo['email'],
                $paymentMethod,
                $totalPayment
            );
            $stmt->execute();
            $orderId = $this->connect->insert_id;

            // Insert into `order_details` table
            $query = "INSERT INTO `order_details` (orderId, productId, name, size, color, quantity, price, image)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect->prepare($query);

            foreach ($cart as $item) {
                // Assign array values to temporary variables
                $productId = $item['productId'];
                $name = $item['name'];
                $size = $item['size'] ?? 'N/A'; // Default to 'N/A' if size is not provided
                $color = $item['color'] ?? 'N/A'; // Default to 'N/A' if color is not provided
                $quantity = $item['quantity'];
                $price = $item['price'];
                $image = $item['image'] ?? null; // Default to null if image is not provided

                // Bind parameters
                $stmt->bind_param(
                    "iisssids",
                    $orderId,
                    $productId,
                    $name,
                    $size,
                    $color,
                    $quantity,
                    $price,
                    $image
                );
                $stmt->execute();
            }

            // Commit transaction
            mysqli_commit($this->connect);
            return $orderId;
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($this->connect);
            error_log("Order Save Error: " . $e->getMessage());
            return false;
        }
    }

    public function getOrdersByUserId($userId) {
        try {
            $query = "SELECT o.orderId, o.receiverName, o.receiverPhone, o.receiverAddress, o.receiverEmail, 
                             o.paymentMethod, o.orderDate, o.totalPayment, 
                             GROUP_CONCAT(
                                 CONCAT_WS(':', 
                                     od.productId, 
                                     IFNULL(od.name, 'Unknown Product'), 
                                     od.size, 
                                     od.color, 
                                     od.quantity, 
                                     od.price, 
                                     IFNULL(od.image, 'placeholder.jpg')
                                 ) SEPARATOR '|'
                             ) AS products
                      FROM `order` o
                      LEFT JOIN `order_details` od ON o.orderId = od.orderId
                      WHERE o.userId = ?
                      GROUP BY o.orderId
                      ORDER BY o.orderDate DESC";
            $stmt = $this->connect->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $products = [];
                if (!empty($row['products'])) {
                    $productDetails = explode('|', $row['products']);
                    foreach ($productDetails as $productDetail) {
                        list($productId, $name, $size, $color, $quantity, $price, $image) = explode(':', $productDetail);
                        $products[] = [
                            'productId' => $productId,
                            'name' => $name,
                            'size' => $size,
                            'color' => $color,
                            'quantity' => $quantity,
                            'price' => $price,
                            'image' => $image
                        ];
                    }
                }
    
                $orders[] = [
                    'orderId' => $row['orderId'],
                    'receiverName' => $row['receiverName'],
                    'receiverPhone' => $row['receiverPhone'],
                    'receiverAddress' => $row['receiverAddress'],
                    'receiverEmail' => $row['receiverEmail'],
                    'paymentMethod' => $row['paymentMethod'],
                    'orderDate' => $row['orderDate'],
                    'totalPrice' => $row['totalPayment'],
                    'products' => $products
                ];
            }
    
            return $orders;
        } catch (Exception $e) {
            error_log("Error fetching orders: " . $e->getMessage());
            return [];
        }
    }
}
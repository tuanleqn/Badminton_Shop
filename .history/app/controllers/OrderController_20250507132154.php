<?php

require_once __DIR__ . '/../helper/config.php';

class OderController extends db
{
    private $connect;

    public function __construct($DBConnect)
    {
        $this->connect = $DBConnect;
    }

    public function manageOrders($statusFilter, $page, $limit)
    {
        // Calculate offset for pagination
        $offset = ($page - 1) * $limit;

        // Prepare SQL query with status filter and pagination
        $query = "SELECT * FROM `order` WHERE status = ? LIMIT ?, ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("sii", $statusFilter, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch orders
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        // Get total number of orders for pagination
        $queryCount = "SELECT COUNT(*) as total FROM `order` WHERE status = ?";
        $stmtCount = $this->connect->prepare($queryCount);
        $stmtCount->bind_param("s", $statusFilter);
        $stmtCount->execute();
        $resultCount = $stmtCount->get_result();
        $totalOrders = $resultCount->fetch_assoc()['total'];

        // Calculate total pages
        $totalPages = ceil($totalOrders / $limit);

        return [
            'orders' => $orders,
            'totalPages' => $totalPages,
            'currentPage' => (int)$page,
            'statusFilter' => htmlspecialchars($statusFilter),
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ];
    }
}
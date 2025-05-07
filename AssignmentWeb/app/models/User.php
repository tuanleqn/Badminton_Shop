<?php
require_once __DIR__ . '/../helper/config.php';

class User extends db {
    protected $conn;
    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
        if (!$this->conn) {
            die("Connection failed in User model");
        }
    }

    // Basic user operations
    public function getUserById($id) {
        $query = "SELECT phone, address, name,email,role FROM user WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt)->fetch_assoc();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM user";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function getAllCustomer() {
        $query = "SELECT * FROM user WHERE role = 'customer'";
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            return false;
        }
        $userList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $userList[] = $row;
        }
        return $userList;
    }

    // Get user's branch
    public function getUserBranch($userId) {
        $query = "SELECT * FROM branch WHERE userId = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt)->fetch_assoc();
    }

    // Get user's reviews
    public function getUserReviews($userId) {
        $query = "SELECT r.*, p.name as product_name FROM review r 
                  JOIN product p ON r.Product_id = p.id 
                  WHERE r.userId = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $reviews = [];
        $result = mysqli_stmt_get_result($stmt);
        while($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }

    // Get user's cart
    public function getUserCart($userId) {
        $query = "SELECT pc.*, p.* FROM ProductCart pc 
                  JOIN Has h ON pc.id = h.productCartId 
                  JOIN product p ON h.productId = p.id 
                  WHERE pc.userId = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $cartItems = [];
        $result = mysqli_stmt_get_result($stmt);
        while($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        return $cartItems;
    }

    public function updateUser($userId, $data) {
        $query = "UPDATE user SET phone = ?, address = ?, name = ?, email = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $data['phone'], $data['address'], $data['name'], $data['email'], $userId);
        return mysqli_stmt_execute($stmt);
    }

    public function updateProfile($userData) {
        $query = "UPDATE user 
                 SET name = ?, email = ?, phone = ?, address = ? 
                 WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", 
            $userData['name'],
            $userData['email'],
            $userData['phone'],
            $userData['address'],
            $userData['id']
        );
        return mysqli_stmt_execute($stmt);
    }

    // Close the database connection
    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
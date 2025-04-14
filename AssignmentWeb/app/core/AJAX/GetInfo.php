<?php
require_once __DIR__ . '/../../helper/config.php';

class GetInfo {
    private $conn;

    public function __construct() {
        global $DBConnect;
        $this->conn = $DBConnect;
    }
    
    public function getInfo($name) {
        if (!$this->conn) {
            return false;
        }
        
        // Prevent SQL injection using prepared statement
        $stmt = $this->conn->prepare("SELECT `description` FROM `Formal inf` WHERE `name` = ?");
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("s", $this->name);
        if (!$stmt->execute()) {
            return false;
        }
        
        $result = $stmt->get_result();
        if (!$result) {
            return false;
        }

        $data = $result->fetch_assoc();
        $stmt->close();
        
        return $data;
    }
}
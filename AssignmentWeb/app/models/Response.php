<?php
require_once __DIR__ . '/../helper/config.php';

class Response extends db {
    protected $conn;
    
    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
        if (!$this->conn) {
            die("Connection failed in Response model");
        }
    }

    public function getAllResponses() {
        $query = "SELECT * FROM `Response` ORDER BY createdAt DESC";
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        $responses = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $responses[] = $row;
        }
        
        return $responses;
    }

    public function getNumberOfNewest($number) {
        $query = "SELECT * FROM `Response` WHERE status != 'responsed' ORDER BY createdAt DESC LIMIT ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $number);
        
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
        
        $result = mysqli_stmt_get_result($stmt);
        $responses = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $responses[] = $row;
        }
        
        return $responses;
    }

    public function updateStatus($id, $status) {
        $validStatuses = ['read', 'unread', 'responsed'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $query = "UPDATE `Response` SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        
        return mysqli_stmt_execute($stmt);
    }

    public function createResponse($data) {
        $query = "INSERT INTO `Response` (firstName, lastName, email, content) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", 
            $data['firstName'], 
            $data['lastName'], 
            $data['email'], 
            $data['content']
        );
        
        return mysqli_stmt_execute($stmt);
    }

    public function deleteResponse($id) {
        $query = "DELETE FROM `Response` WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
}
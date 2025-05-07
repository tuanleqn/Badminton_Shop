<?php
require_once __DIR__ . '/../helper/config.php';

// Class FormalInfo
class FormalInfo extends db {
    protected $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
        if (!$this->conn) {
            die("Connection failed in FormalInfo model");
        }
    }
    
    public function getAllFormalInfo() {
        if (!$this->conn) {
            return false;
        }
        
        $query = "SELECT name, description FROM `Formal inf`";
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($this->conn));
        }
        
        $formalInfoList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $formalInfoList[] = $row;
        }
        
        return $formalInfoList;
    }

    public function modifyFormalInfo($data) {
        if (!$this->conn) {
            return false;
        }
        
        $success = true;
        foreach ($data as $item) {
            $query = "UPDATE `Formal inf` SET description = ? WHERE name = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $item['description'], $item['name']);
            
            if (!mysqli_stmt_execute($stmt)) {
                $success = false;
                break;
            }
        }
        
        return $success;
    }
    
    // No need for closeConnection method as it's handled by db class destructor
}
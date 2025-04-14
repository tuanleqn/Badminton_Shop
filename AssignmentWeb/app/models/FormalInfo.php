<?php
require_once __DIR__ . '/../helper/config.php';

// Class FormalInfo
class FormalInfo {
    private $db;
    public $conn;

    public function __construct() {
        $this->db = new db();
        $this->conn = $this->db->connect;
    }
    
    public function getAllFormalInfo() {
        if (!$this->conn) {
            return false;
        }
        
        $query = "SELECT name, description FROM `Formal inf`";
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        $formalInfoList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $formalInfoList[] = $row;
        }
        
        return $formalInfoList;
    }
    public function closeConnection() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
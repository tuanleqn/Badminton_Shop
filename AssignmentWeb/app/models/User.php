<?php
require_once __DIR__ . '/../helper/config.php';

class User {
    private $db;
    public $conn;
    
    public function __construct() {
        $this->db = new db();
        $this->conn = $this->db->connect;
    }
}
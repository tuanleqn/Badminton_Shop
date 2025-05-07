<?php
require_once __DIR__ . '/../helper/config.php';


class Branch extends db {
    protected $conn;

    public function __construct(){
        parent::__construct();
        $this->conn = $this->connect;
        if (!$this->conn) {
            die("Connection failed in Branch model");
        }
    }

    public function getAllBranches() {
        if (!$this->conn) {
            return false;
        }
        $query = "SELECT id, name, address FROM branch";
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->conn));
        }
        $branchList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $branchList[] = $row;
        }
        return $branchList;
    }

    public function addBranch($name, $address) {
        if (!$this->conn) {
            return false;
        }
        $query = "INSERT INTO branch (name, address) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $name, $address);
        return mysqli_stmt_execute($stmt);
    }

    public function updateBranch($id, $name, $address) {
        if (!$this->conn) {
            return false;
        }
        $query = "UPDATE branch SET address = ? WHERE name = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $address, $name);
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
        return true;
    }

    public function deleteBranch($id) {
        if (!$this->conn) {
            throw new Exception('Database connection failed');
        }
        
        try {
            // Start transaction
            mysqli_begin_transaction($this->conn);
            
            // Check if branch exists
            $checkQuery = "SELECT id FROM branch WHERE id = ?";
            $checkStmt = mysqli_prepare($this->conn, $checkQuery);
            if (!$checkStmt) {
                throw new Exception('Failed to prepare check statement: ' . mysqli_error($this->conn));
            }
            
            mysqli_stmt_bind_param($checkStmt, "i", $id);
            if (!mysqli_stmt_execute($checkStmt)) {
                throw new Exception('Failed to execute check statement: ' . mysqli_error($this->conn));
            }
            
            mysqli_stmt_store_result($checkStmt);
            if (mysqli_stmt_num_rows($checkStmt) === 0) {
                throw new Exception('Branch not found');
            }
            mysqli_stmt_close($checkStmt);
            
            // Delete the branch
            $deleteQuery = "DELETE FROM branch WHERE id = ?";
            $deleteStmt = mysqli_prepare($this->conn, $deleteQuery);
            if (!$deleteStmt) {
                throw new Exception('Failed to prepare delete statement: ' . mysqli_error($this->conn));
            }
            
            mysqli_stmt_bind_param($deleteStmt, "i", $id);
            if (!mysqli_stmt_execute($deleteStmt)) {
                throw new Exception('Failed to delete branch: ' . mysqli_error($this->conn));
            }
            
            if (mysqli_stmt_affected_rows($deleteStmt) === 0) {
                throw new Exception('No branch was deleted');
            }
            
            mysqli_stmt_close($deleteStmt);
            mysqli_commit($this->conn);
            return true;
            
        } catch (Exception $e) {
            mysqli_rollback($this->conn);
            throw $e;
        }
    }
}
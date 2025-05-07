<?php
require_once __DIR__ . '/../helper/config.php';

class UserAuth extends db {
    protected $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
        if (!$this->conn) {
            die("Connection failed in UserAuth model");
        }
    }

    public function login($email, $password) {
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($user = mysqli_fetch_assoc($result)) {
            if($password === $user['pass']) { // Note: In production, use password_verify() with hashed passwords
                unset($user['pass']); // Don't store password in session
                return $user;
            }
        }
        return false;
    }

    public function register($userData) {
        // Check if email already exists
        $query = "SELECT id FROM user WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $userData['email']);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_get_result($stmt)->num_rows > 0) {
            return ["error" => "Email already exists"];
        }

        // Insert new user
        $query = "INSERT INTO user (name, email, pass, phone, address, sex, role) 
                  VALUES (?, ?, ?, ?, ?, ?, 'customer')";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $userData['name'],
            $userData['email'],
            $userData['password'], // Note: In production, use password_hash()
            $userData['phone'],
            $userData['address'],
            $userData['sex']
        );

        if(mysqli_stmt_execute($stmt)) {
            return ["success" => "Registration successful"];
        }
        return ["error" => "Registration failed"];
    }

    public function verifyPassword($email, $password) {
        $query = "SELECT pass FROM user WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            return ($password === $row['pass']); // Note: In production, use password_verify()
        }
        
        return false;
    }

    public function updatePassword($email, $newPassword) {
        $query = "UPDATE user SET pass = ? WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
        
        return mysqli_stmt_execute($stmt);
    }
    public function checkUserExists($email, $phone) {
        try {
            $query = "SELECT * FROM user WHERE email = ? OR phone = ?";
            $stmt = $this->conn->prepare($query); 
            $stmt->bind_param("ss", $email, $phone); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 
            return $result->num_rows > 0;
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
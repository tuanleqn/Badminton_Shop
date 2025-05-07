<?php

$host = 'localhost';
$dbname = 'shopVNB';  
$username = 'root'; 
$password = '';

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Thiết lập chế độ lỗi cho PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Hiển thị lỗi nếu kết nối thất bại
    die("Kết nối thất bại: " . $e->getMessage());
}

?>
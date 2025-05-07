<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';


$productController = new ProductController();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $productController->deleteProduct();
    exit(); // Ensure no further code is executed
}

// Add other edit functionality here...
?>
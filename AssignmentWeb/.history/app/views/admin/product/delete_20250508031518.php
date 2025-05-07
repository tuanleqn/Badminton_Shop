<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once '../app/helper/URL.php';


$productController = new ProductController();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $productController->deleteProduct();
    $redirectUrl = URL::to('public/admin/produclist');
    header("Location: $redirectUrl?message=Product deleted successfully");
    exit(); 
}

// Add other edit functionality here...
?>
<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once __DIR__ . '/../../../helper/URL.php';

$productController = new ProductController();

if (isset($_GET['action']) && $_GET['action'] === 'productdelete' && isset($_GET['id'])) {
    $result = $productController->deleteProduct($_GET['id']);
    if ($result) {
        header("Location: " . URL::to('public/admin/productlist') . "?message=Product deleted successfully");
    } else {
        echo "Failed to delete the product.";
    }
    exit;
}
?>
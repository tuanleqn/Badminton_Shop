<?php
require_once __DIR__ . '/../../../app/models/SiteModel.php'; 
require_once __DIR__ . '/../../../app/controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$stars = isset($_POST['stars']) && is_numeric($_POST['stars']) ? (int)$_POST['stars'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $details = isset($_POST['details']) ? trim($_POST['details']) : '';

    if ($productId <= 0 || $stars <= 0 || $stars > 5 || empty($title) || empty($details)) {
        header('Location: http://localhost/Shop-badminton/AssignmentWeb/public/ProductSite/productdetail?id=' . $productId . '&error=invalid_input');
        exit;
    }

    $productController = new ProductController();
    $success = $productController->submitReview($productId, $stars, $title, $details);


    if ($success) {
        header('Location: http://localhost/Shop-badminton/AssignmentWeb/public/ProductSite/productdetail?id=' . $productId);
        exit;
    } else {
        // Redirect back to the product detail page with an error query parameter
        header('Location: http://localhost/Shop-badminton/AssignmentWeb/public/ProductSite/productdetail?id=' . $productId . '&error=review_failed');
        exit;
    }
}
?>
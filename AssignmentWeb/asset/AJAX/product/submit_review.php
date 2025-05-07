<?php
require_once __DIR__ . '/../models/site_model.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $stars = isset($_POST['stars']) ? (int)$_POST['stars'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $details = isset($_POST['details']) ? trim($_POST['details']) : '';

    $productController = new ProductController();
    $message = $productController->submitReview($productId, $stars, $title, $details);

    echo $message;
}
?>
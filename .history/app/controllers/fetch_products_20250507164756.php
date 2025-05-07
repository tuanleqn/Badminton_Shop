<?php
require_once __DIR__ . '/../models/SiteModel.php';

// Create an instance of the Product model
$productModel = new SiteModel();

$limit = 8; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
// Get the sort parameter
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Adjust the query based on the sort parameter
switch ($sort) {
    case 'New':
        $orderBy = 'p.created_at DESC'; // Assuming `created_at` is the column for product creation date
        break;
    case 'Rating':
        $orderBy = 'pr.average_rating DESC'; // Sort by average rating
        break;
    case 'Price-ascending':
        $orderBy = 'p.price ASC'; // Sort by price ascending
        break;
    case 'Price-descending':
        $orderBy = 'p.price DESC'; // Sort by price descending
        break;
    default:
        $orderBy = 'p.id ASC'; // Default sorting
        break;
}
$productModel->syncProductRatings();
// Fetch all products
$category = isset($_GET['category']) ? $_GET['category'] : null;
$brandId = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;

// Case 1: Fetch all products
if (!$category && !$brandId) {
    $products = $productModel->getAllProducts($limit, $offset, $orderBy);
}
// Case 2: Fetch products by category
elseif ($category && !$brandId) {
    $products = $productModel->getAllProducts($limit, $offset, $orderBy, $category);
}
// Case 3: Fetch products by category and brand
elseif ($category && $brandId) {
    $products = $productModel->getAllProducts($limit, $offset, $orderBy, $category, $brandId);
}

// Ensure $products is an array
if (!$products) {
    $products = [];
}

$totalProducts = $productModel->getTotalProducts();
$totalPages = ceil($totalProducts / $limit);



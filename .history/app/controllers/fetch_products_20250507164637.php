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
// $products = $productModel->getAllProducts($limit, $offset, $orderBy);
// Case 1 : fetch all products
$products = $productModel->getAllProducts($limit, $offset, $orderBy);
// Case 2 : fetch products by category
$products =
// $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
// Ensure $products is an array
// if (!$products) {
//     $products = [];
// }
$totalProducts = $productModel->getTotalProducts();
$totalPages = ceil($totalProducts / $limit);



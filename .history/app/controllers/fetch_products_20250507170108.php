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

$categories = isset($_GET['category']) ? explode(',', $_GET['category']) : null;
$brands = isset($_GET['brand_id']) ? explode(',', $_GET['brand_id']) : null;
$sizes = isset($_GET['size']) ? explode(',', $_GET['size']) : null;

// Fetch products based on the filters
$products = $productModel->getAllProducts($limit, $offset, $orderBy, $categories, $brands, $sizes);


// Ensure $products is an array
if (!$products) {
    $products = [];
}

// Get total products for pagination
$totalProducts = $productModel->getTotalProducts();
$totalPages = ceil($totalProducts / $limit);


// Return the products as JSON (for AJAX requests)
// header('Content-Type: application/json');
// echo json_encode([
//     'products' => $products,
//     'totalPages' => $totalPages,
//     'currentPage' => $page
// ]);



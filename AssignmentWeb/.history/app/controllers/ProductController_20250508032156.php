<?php
require_once __DIR__ . '/../models/SiteModel.php';

class ProductController {
    private $siteModel;

    public function __construct() {
        $this->siteModel = new SiteModel(); // Initialize SiteModel
    }

    public function getProductDetails($productId) {
        return $this->siteModel->getProductDetails($productId);
    }

    public function getProductImages($productId) {
        return $this->siteModel->getProductImages($productId);
    }

    public function getAverageRating($productId) {
        return $this->siteModel->getAverageRating($productId);
    }

    public function getTotalReviews($productId) {
        return $this->siteModel->getTotalReviews($productId);
    }

    public function getProductReviews($productId) {
        return $this->siteModel->getProductReviews($productId);
    }

    public function submitReview($productId, $stars, $title, $details) {
        return $this->siteModel->submitReview($productId, $stars, $title, $details);
    }

    public function getProductReviewsWithUser($productId) {
        return $this->siteModel->getProductReviewsWithUser($productId);
    }

   
    public function deleteProduct() {
        if (isset($_GET['id'])) {
            $productId = intval($_GET['id']);
            error_log("Deleting product with ID: $productId"); // Debug statement
    
            try {
                $isDeleted = $this->siteModel->deleteProductById($productId);
    
                if ($isDeleted) {
                    error_log("Product deleted successfully.");
                    header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/list.php?message=Product deleted successfully");
                } else {
                    error_log("No product found with ID: $productId.");
                    header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/list.php?message=No product found to delete");
                }
            } catch (Exception $e) {
                error_log("Error deleting product: " . $e->getMessage());
                header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/list.php?message=Error deleting product");
            }
    
            exit();
        } else {
            error_log("Invalid product ID.");
            header("Location: URL::to()?message=Invalid product ID");
            exit();
        }
    }
    

    public function listProducts($search = '', $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;

        // Fetch products and total count
        $products = $this->siteModel->getProducts($search, $limit, $offset);
        $totalProducts = $this->siteModel->searchProducts($search);

        // Calculate total pages
        $totalPages = ceil($totalProducts / $limit);

        return [
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'totalProducts' => $totalProducts, 
        ];
    }

    public function editProduct($productId, $postData, $filesData) {
        // Validate product ID
        if ($productId <= 0) {
            header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/list.php?error=Invalid product ID");
            exit;
        }
    
        // Sanitize and validate the color field
        $postData['color'] = isset($postData['color']) ? strip_tags(trim($postData['color'])) : '';
        if (empty($postData['color'])) {
            header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/edit.php?error=Color is required");
            exit;
        }
    
        // Sanitize and validate the size field
        $postData['size'] = isset($postData['size']) ? implode(', ', array_map('strip_tags', explode(',', $postData['size']))) : '';
        if (empty($postData['size'])) {
            header("Location: /Shop-badminton/AssignmentWeb/app/views/admin/product/edit.php?error=Size is required");
            exit;
        }
    
        // Update product details
        $updateResult = $this->siteModel->updateProduct($productId, $postData);
    
        // Update image order
        if (!empty($postData['imageOrder'])) {
            $this->siteModel->updateImageOrder($postData['imageOrder']);
        }
    
        // Remove selected images
        if (!empty($postData['remove_images'])) {
            $this->siteModel->removeImages($postData['remove_images']);
        }
    
        // Handle new image uploads
        if (!empty($filesData['images']['name'][0])) {
            $this->siteModel->uploadImages($productId, $filesData['images']);
        }
    
        // Redirect after successful update
        if ($updateResult) {
            header("Location: /Shop-badminton/AssignmentWeb/public/admin/productlist?success=Product updated successfully");
        } else {
            header("Location: /Shop-badminton/AssignmentWeb/public/admin/productlist?error=Failed to update product");
        }
        exit;
    }

    public function searchProduct() {
        try {
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
            // Debug: Log the search query
            error_log('Search query: ' . $search);
    
            // Fetch products matching the search query
            $products = $this->siteModel->getProducts($search);
    
            // Debug: Log the fetched products
            error_log('Fetched products: ' . print_r($products, true));
    
            // Return the products as JSON
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
        } catch (Exception $e) {
            // Debug: Log the error
            error_log('Error in searchProduct: ' . $e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'An error occurred while fetching products.']);
        }
        exit;
    }

    public function getProduct($productId) {
        return $this->siteModel->getProductById($productId);
    }
    public function ProductImages($productId) {
        return $this->siteModel->ProductImages($productId);
        error_log("Product Images: " . print_r($images, true)); // Debug
    return $images;
    }

    public function manageReviews($status, $page, $limit) {
        $offset = ($page - 1) * $limit;

        // Fetch reviews
        $reviews = $this->siteModel->getReviews($status, $limit, $offset);

        // Count total reviews for pagination
        $totalReviews = $this->siteModel->getStatusReviews($status);
        $totalPages = ceil($totalReviews / $limit);

        return [
            'reviews' => $reviews,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }
}
?>
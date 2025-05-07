<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['review_success']) && $_SESSION['review_success'] === true) {
    echo "<script>alert('Thank you for your review!');</script>";
    unset($_SESSION['review_success']); 
}
require_once __DIR__ . '/../../models/SiteModel.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId > 0) {
    $productController = new ProductController();
    $product = $productController->getProductDetails($productId);
    $images = $productController->getProductImages($productId);
    $averageRating = $productController->getAverageRating($productId);
    $totalReviews = $productController->getTotalReviews($productId);
    $reviews = $productController->getProductReviewsWithUser($productId);


    if (!$product) {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}
// $model = new SiteModel();
// $db = $model->getDbConnection(); // Use the public method to get the database connection

// // Get the product ID from the query string
// $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// if ($productId > 0) {
//     // Fetch product details from the database
//     $query = "SELECT p.*, pi.image_path 
//               FROM product p
//               LEFT JOIN product_images pi ON p.id = pi.product_id
//               WHERE p.id = $productId";
//     $result = mysqli_query($db, $query); // Use $db instead of $model->db
//     $product = mysqli_fetch_assoc($result);

//     if (!$product) {
//         die("Product not found.");
//     }

//     // Fetch all images for the product
//     $imagesQuery = "SELECT image_path FROM product_images WHERE product_id = $productId";
//     $imagesResult = mysqli_query($db, $imagesQuery); // Use $db instead of $model->db
//     $images = [];
//     if ($imagesResult) {
//         while ($row = mysqli_fetch_assoc($imagesResult)) {
//             $images[] = $row['image_path'];
//         }
//     }
// } else {
//     die("Invalid product ID.");
// }
?>


<!DOCTYPE html>
<html lang="vi">
    <head>
        <title><?php echo htmlspecialchars($product['name']); ?> - Product Detail</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/pd_style.css'); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/@fontsource/roboto/index.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    </head>
    <body>
        
        <div class="justify-content-between align-items-center container-fluid px-3 mt-5">
            <nav aria-label="breadcrumb" class="container mt-3">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="../product_site/index.php">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="currentPage"><?php echo htmlspecialchars($product['name']); ?></li>
                </ol>
            </nav> 
            <div class="container mt-5">
                <div class="row">
                    <!-- Slider Section -->
                    <div class="col-md-6">
                        <div class="image-container position-relative">
                            <img src="/Shop-badminton/AssignmentWeb/<?php echo htmlspecialchars($images[0]); ?>" id="largeImage" alt="Product Image" class="img-fluid rounded">
                        </div>

                        <!-- Carousel for thumbnails -->
                        <div class="container mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <button id="prevBtn" class="btn btn-outline-secondary btn-sm">&lt;</button>
                                <div class="row flex-nowrap" id="thumbnailRow" style="overflow-x: auto; width: 100%;"></div>
                                <button id="nextBtn" class="btn btn-outline-secondary btn-sm">&gt;</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-md-6">
                        <h1 id="productTitle" class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                        <p id="productPrice" class="product-price">$<?php echo htmlspecialchars($product['price']); ?></p>
                        <div class="product-rating" id="averageRating">
                            <?php
                                $fullStars = floor($averageRating);
                                $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - ($fullStars + $halfStar);

                                for ($i = 0; $i < $fullStars; $i++) {
                                    echo '<i class="bi bi-star-fill text-warning"></i>';
                                }
                                if ($halfStar) {
                                    echo '<i class="bi bi-star-half text-warning"></i>';
                                }
                                for ($i = 0; $i < $emptyStars; $i++) {
                                    echo '<i class="bi bi-star text-warning"></i>';
                                }
                            ?>
                            <p><?php echo $averageRating; ?> / 5 (<?php echo $totalReviews; ?> reviews)</p>
                        </div>
                        <div class="labels" id="productLabels">
                            <span class="badge badge-secondary">Label 1</span>
                            <span class="badge badge-secondary">Label 2</span>
                        </div>
                        <div class="form-group">
                            <label for="option1" class="visually-hidden">Choose Color</label>
                            <select class="form-control" id="option1" title="Choose Color">

                                <!-- <option>Màu sắc</option>
                                <option>Value 2</option> -->
                            </select>
                            <label for="option2" class="visually-hidden">Choose Size</label>
                            <select class="form-control" id="option2" title="Choose Size">
                                <option>Size</option>
                                <option>Value 2</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <button id="decreaseBtn" class="btn btn-outline-danger btn-sm me-2">-</button>
                            <label for="quantity" class="visually-hidden">Quantity</label>
                            <input type="number" id="quantity" class="form-control text-center quantity-input" value="1" min="1" title="Enter quantity" placeholder="1">
                            <button id="increaseBtn" class="btn btn-outline-danger btn-sm ms-2">+</button>
                        </div>
                        <div class="d-flex gap-3">
                        <form action="<?php echo URL::to('public/ProductSite/productcart'); ?>" method="POST" id="buyNowForm">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="image" value="<?php echo htmlspecialchars($images[0]); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                            <input type="hidden" name="size" value="<?php echo htmlspecialchars($product['size'] ?? ''); ?>">
                            <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                            <button type="submit" class="btn btn-custom text-white fw-bold px-4" style="background-color: #f98850;">
                                MUA NGAY
                            </button>
                        </form>
                        <script>
    console.log("Product ID:", "<?php echo htmlspecialchars($product['id']); ?>");
    console.log("Product Name:", "<?php echo htmlspecialchars($product['name']); ?>");
    console.log("Product Image:", "<?php echo htmlspecialchars($images[0]); ?>");
    console.log("Product Price:", "<?php echo htmlspecialchars($product['price']); ?>");
    console.log("Product Size:", "<?php echo htmlspecialchars($product['size'] ?? ''); ?>");
</script>
                        <button id="addToCartBtn" class="btn btn-danger text-white fw-bold px-4">THÊM VÀO GIỎ HÀNG</button>
                        </div>
                        <div class="product-description mt-4">
                            <h2>Description</h2>
                            <p id="productDescription"><?php echo htmlspecialchars($product['description']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="reviews-section container mt-5 px-3">
      
                <h1 class="mt-4" id="reviewHeading">Leave a Review</h1>
                <form id="reviewForm" class="row g-3" method="POST" action="<?php echo URL::to('asset/AJAX/product/submit_review.php'); ?>">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">

                    <!-- Star Rating -->
                    <div class="form-group col-12 d-flex justify-content-md-end justify-content-end">
                        <div id="starRating">
                            <i class="star bi bi-star-fill" data-value="1"></i>
                            <i class="star bi bi-star-fill" data-value="2"></i>
                            <i class="star bi bi-star-fill" data-value="3"></i>
                            <i class="star bi bi-star-fill" data-value="4"></i>
                            <i class="star bi bi-star-fill" data-value="5"></i>
                        </div>
                        <input type="hidden" id="stars" name="stars" value="0">
                    </div>

                    <!-- Review Title -->
                    <div class="form-group row align-items-center">
                        <label for="reviewTitle" class="col-md-3 col-form-label text-md-end">Review Title</label>
                        <div class="col-md-9">
                            <input type="text" id="reviewTitle" name="title" class="form-control" placeholder="Enter your review title" required>
                        </div>
                    </div>
                    
                    <!-- Review Body -->
                    <div class="form-group row align-items-center mt-3">
                        <label for="reviewBody" class="col-md-3 col-form-label text-md-end">Review Body</label>
                        <div class="col-md-9">
                            <textarea id="reviewBody" name="details" class="form-control" rows="3" placeholder="Write your review here" required></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group col-12 d-flex justify-content-center justify-content-md-end">
                        <button type="submit" class="btn btn-primary" style="background-color: #f98850;">Submit Review</button>
                    </div>
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_input'): ?>
                        <div class="alert alert-danger">Please fill in all fields and provide a valid star rating.</div>
                    <?php endif; ?>
                </form>
            
                <div class="reviews-section container mt-5 px-3">
                    <h2 class="mb-4" id="reviewHeading">Latest Reviews</h2>
                    <div class="row" id="reviewsContainer">
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $index => $review): ?>
                                <div class="col-md-4 mb-4 review-card" data-index="<?php echo $index; ?>">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <?php
                                                $stars = (int)$review['stars'];
                                                echo str_repeat('<i class="bi bi-star-fill text-warning"></i>', $stars);
                                                echo str_repeat('<i class="bi bi-star text-muted"></i>', 5 - $stars);
                                                ?>
                                            </div>
                                            <h5 class="card-title"><?php echo htmlspecialchars($review['title']); ?></h5>
                                            <p class="card-text"><?php echo htmlspecialchars($review['details']); ?></p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <small>
                                                Posted by <?php echo htmlspecialchars($review['reviewer_name'] ?? 'Anonymous'); ?>
                                                
                                                on <?php echo htmlspecialchars($review['date']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No reviews yet. Be the first to leave a review!</p>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div id="reviewPagination" class="d-flex justify-content-center mt-3">
                        <nav>
                            <ul class="pagination">
                                <!-- Pagination buttons will be dynamically generated -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <script>
    const images = <?php echo json_encode($images); ?>; // Pass PHP images array to JavaScript
    let currentIndex = 0;

    function updateThumbnails() {
    const thumbnailRow = document.getElementById('thumbnailRow');
    thumbnailRow.innerHTML = '';
    for (let i = currentIndex; i < currentIndex + 4; i++) {
        if (i < images.length) {
            const col = document.createElement('div');
            col.className = 'col-3';
            const imgElement = document.createElement('img');
            imgElement.src = '/Shop-badminton/AssignmentWeb/' + images[i % images.length];
            imgElement.className = 'thumbnail-image'; // Apply the CSS class
            imgElement.alt = `Thumbnail ${i + 1}`;
            imgElement.addEventListener('click', () => {
                document.getElementById('largeImage').src = '/Shop-badminton/AssignmentWeb/' + images[i % images.length];
            });
            col.appendChild(imgElement);
            thumbnailRow.appendChild(col);
        }
    }

    // Automatically update the large image to the first thumbnail in the current view
    document.getElementById('largeImage').src = '/Shop-badminton/AssignmentWeb/' + images[currentIndex % images.length];
}

    document.getElementById('nextBtn').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateThumbnails();
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateThumbnails();
    });

    // Initialize thumbnails and large image on page load
    updateThumbnails();

   
</script>
        <script src="<?php echo URL::to('asset/js/pc_script.js'); ?>"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>
<?php
// Adjust the path to correctly point to the controllers directory
require_once __DIR__ . '/../../controllers/fetch_products.php';
require_once __DIR__ . '/../../helper/URL.php';

// Extract unique categories from the displayed products
$displayedCategories = !empty($products) ? array_unique(array_map(function ($product) {
    return htmlspecialchars($product['category']);
}, $products)) : [];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/roboto/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/ps_style.css'); ?>">
</head>
<body>    
    <div class="container-fluid">        
        <div class="sidebar row">
            <!-- Sidebar for Filters -->
            <div class="col-md-3 d-none d-md-block">
                <!-- Sidebar for Filters (Visible on Desktop) -->
                <div class="filter-sidebar">
                    <h5>Keywords</h5>
                    <input type="text" class="form-control mb-3" placeholder="Search..." id="searchInput">
                    <div class="keyword-display" id="keywordDisplay"></div>
                    <h5>Filters</h5>

                    <!-- Case 1: Filter by Category + Size -->
                    <h6>Categories</h6>
                    <div id="categoryContainer">
                        <?php
                        if (!empty($displayedCategories)) {
                            foreach ($displayedCategories as $category) {
                                echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='" . strtolower($category) . "' id='category-" . strtolower($category) . "'>
                                    <label class='form-check-label' for='category-" . strtolower($category) . "'>
                                        $category
                                    </label>
                                </div>";
                            }
                        } else {
                            echo "<p>No categories available.</p>";
                        }
                        ?>
                    </div>

                    <!-- Case 2: Filter by Brand + Category + Size -->
                    <h6>Brands</h6>
                    <div id="brandContainer">
    <?php
    if (!empty($brands)) {
        foreach ($brands as $brand) {
            echo "
            <div class='form-check'>
                <input class='form-check-input' type='checkbox' value='" . strtolower($brand['id']) . "' id='brand-" . strtolower($brand['id']) . "'>
                <label class='form-check-label' for='brand-" . strtolower($brand['id']) . "'>
                    " . htmlspecialchars($brand['name']) . "
                </label>
            </div>";
        }
    } else {
        echo "<p>No brands available.</p>";
    }
    ?>
</div>

                    <!-- Case 3: Filter by Size -->
                    <h6>Sizes</h6>
                    <div id="sizeContainer">
                        <?php
                        if (!empty($sizes)) {
                            foreach ($sizes as $size) {
                                echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='" . strtolower($size) . "' id='size-" . strtolower($size) . "'>
                                    <label class='form-check-label' for='size-" . strtolower($size) . "'>
                                        " . htmlspecialchars($size) . "
                                    </label>
                                </div>";
                            }
                        } else {
                            echo "<p>No sizes available.</p>";
                        }
                        ?>
                    </div>
            
                    <!-- <h5>Price</h5>
                    <input type="range" class="form-range" id="priceRange" min="0" max="100" value="50" oninput="updatePriceValue()">
                    <label for="priceRange">Price: $<span id="priceValue">50</span></label> -->
            
                    <h5>Sort By</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortCriteria" id="New" onclick="sortProducts('New')">
                        <label class="form-check-label" for="New">New</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortCriteria" id="Price-ascending" onclick="sortProducts('Price-ascending')">
                        <label class="form-check-label" for="Price-ascending">Price ascending</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortCriteria" id="Price-descending" onclick="sortProducts('Price-descending')">
                        <label class="form-check-label" for="Price-descending">Price descending</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortCriteria" id="Rating" onclick="sortProducts('Rating')">
                        <label class="form-check-label" for="Rating">Rating</label>
                    </div>
                </div>
            </div>
            
                     
            <!-- Floating Filter Button for Mobile View -->
            <div class="d-md-none">
                <button class="btn btn-danger filter-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                        <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.146.354L10 8.207v5.586l-4 2V8.207L1.646 2.854A.5.5 0 0 1 1.5 2.5v-1z"/>
                    </svg>
                    Lọc
                </button>
            </div>

            <!-- Offcanvas Filter Sidebar for Mobile -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- <h5>Keywords</h5>
                    <input type="text" class="form-control mb-3" placeholder="Search..." id="searchInputMobile"> -->
                    <div class="keyword-display" id="keywordDisplayMobile"></div>
                    <h5>Categories</h5>
                    <div id="categoryContainerMobile"></div>

                    <h5>Price</h5>
                    <input type="range" class="form-range" id="priceRangeMobile" min="0" max="100" value="50" oninput="updatePriceValueMobile()">
                    <label for="priceRangeMobile">Price: $<span id="priceValueMobile">50</span></label>

                    <!-- <h5>Sort By</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortMobile" id="NewMobile" onclick="updateTagsMobile()">
                        <label class="form-check-label" for="NewMobile">New</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortMobile" id="Price-ascendingMobile" onclick="updateTagsMobile()">
                        <label class="form-check-label" for="Price-ascendingMobile">Price ascending</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortMobile" id="Price-descendingMobile" onclick="updateTagsMobile()">
                        <label class="form-check-label" for="Price-descendingMobile">Price descending</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sortMobile" id="RatingMobile" onclick="updateTagsMobile()">
                        <label class="form-check-label" for="RatingMobile">Rating</label>
                    </div> -->
                </div>
            </div>
    
            <!-- Product Grid -->
            <div class="col-12 col-md-9 px-3">             
                <div class="search-sort-container d-flex justify-content-between align-items-center mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" id="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page" id="currentPage">Products</li>
                        </ol>
                    </nav>
                
                    <!-- Dropdown for Sorting -->
                    <div class="dropdown d-md-none">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                                <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1H2.5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                            Sắp xếp: Mặc định
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><button class="dropdown-item" onclick="sortProducts('Price-ascending')">Giá tăng dần</button></li>
                            <li><button class="dropdown-item" onclick="sortProducts('Price-descending')">Giá giảm dần</button></li>
                            <li><button class="dropdown-item" onclick="sortProducts('New')">Hàng mới nhất</button></li>
                            <li><button class="dropdown-item" onclick="sortProducts('Rating')">Đánh giá</button></li>
                        </ul>
                    </div>

                    <!-- Buttons for Desktop View -->
                    <div class="d-none d-md-block">
                    <button class="btn btn-outline-dark ms-2" onclick="sortProducts('New')">New</button>
                    <button class="btn btn-outline-secondary" onclick="sortProducts('Price-ascending')">Price ascending</button>
                    <button class="btn btn-outline-secondary" onclick="sortProducts('Price-descending')">Price descending</button>
                    <button class="btn btn-outline-secondary" onclick="sortProducts('Rating')">Rating</button>
                    </div>                 
                </div>
                
                <div id="productList" class="row">
                    <?php
                        if (!empty($products)) {
                            foreach ($products as $product) {
                                // Extract product details
                                $name = htmlspecialchars($product['name']);
                                $price = htmlspecialchars($product['price']);
                                $category = htmlspecialchars($product['category']);
                                $description = htmlspecialchars($product['description']);
                                $image = !empty($product['image_path']) 
                                    ? '/Shop-badminton/AssignmentWeb/' . htmlspecialchars($product['image_path']) 
                                    : '/Shop-badminton/AssignmentWeb/app/uploads/placeholder.jpg';
                                $averageRating = isset($product['average_rating']) ? round($product['average_rating'], 1) : 0;
                                // Generate the product card
                                echo "
                                    <div class='col-6 col-md-4 col-lg-3 mb-4'>
                                        <div class='product-card card h-100 d-flex flex-column' 
                                            data-id='" . $product['id'] . "' 
                                            data-price='" . $product['price'] . "' 
                                            data-rating='" . (isset($product['average_rating']) ? $product['average_rating'] : 0) . "' 
                                            data-category='" . strtolower($product['category']) . "'>
                                            <img src='" . $image . "' alt='Product Image' class='card-img-top img-fluid' style='width: 250px; height: 300px; object-fit: cover; align-self: center;'>
                                            <div class='card-body'>
                                                <h6 class='card-title'>" . htmlspecialchars($product['name']) . "</h6>
                                                <p class='card-text'>$" . htmlspecialchars($product['price']) . "</p>
                                                <div>Rating: ";

                                    // Render stars
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

                                    echo " (" . number_format($product['average_rating'], 1) . ")</div>
                                                <p class='card-text'>Category: " . htmlspecialchars($product['category']) . "</p>
                                                <a href='" . URL::to('public/ProductSite/productdetail?id=' . $product['id']) . "' class='btn btn-custom' style='background-color: #f98850;'>Buy Now</a>
                                            </div>
                                        </div>
                                    </div>";
                            }
                        } else {
                            echo "<p>No products available.</p>";
                        }
                        ?>
                </div>
                <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <span id="totalProducts"></span>
                    <button class="btn btn-primary" id="loadMoreBtn">Load More</button>
</div> -->
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="paginationControls">
                      <!-- Pagination items will be generated here -->
                      <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    </ul>
                  </nav>
            </div>
        </div>
        </div>
     
    
    
        <script src="<?php echo URL::to('asset/js/ps_script.js'); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
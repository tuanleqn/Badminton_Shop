<?php 
require_once __DIR__ . '/../../helper/URL.php';
require_once __DIR__ . '/../../helper/config.php';
require_once __DIR__ . '/../news_site/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<?php require_once dirname(__DIR__) . '/header_footer/header.php'; ?>
<!-- Hero Slider -->
<div class="hero-slider">
            <div class="hero-slide">
                <?php foreach($data['formalInfo'] as $info): ?>
                    <?php if($info['name'] == 'banner'): ?>
                        <img src="<?php echo $info['description']; ?>" alt="banner" class="img-fluid">
                    <?php endif; ?>
                    <?php endforeach; ?>
                <div class="hero-content">
                    <div class="container">
                        <div class="hero-text">
                            <h1 class="animated-text">THIẾT BỊ CẦU LÔNG CHÍNH HÃNG</h1>
                            <p>Sản phẩm chất lượng cao từ các thương hiệu hàng đầu</p>
                            <div class="hero-buttons">
                                <a href="<?= URL::to('public/ProductSite/index'); ?>" class="btn btn-primary btn-lg">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="features-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Giao hàng miễn phí</h4>
                                <?php foreach($data['formalInfo'] as $info): ?>
                                <?php if($info['name'] == 'Shipping benefit'): ?>
                                    <p><?php echo $info['description']; ?> </p>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Đổi trả dễ dàng</h4>
                                <?php foreach($data['formalInfo'] as $info): ?>
                                <?php if($info['name'] == 'Refund'): ?>
                                    <p><?php echo $info['description']; ?> </p>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Bảo hành chính hãng</h4>
                                <p>Sản phẩm chính hãng 100%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="feature-content">
                                <h4>Hỗ trợ 24/7</h4>
                                <p>Tư vấn trực tuyến</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Categories -->
        <section class="product-categories">
            <div class="container">
                <div class="section-header">
                    <h2>DANH MỤC SẢN PHẨM</h2>
                    <p>Khám phá các sản phẩm cầu lông chất lượng cao</p>
                </div>
                <div class="row product-banner">
                    <?php 
                    $categoryData = [
                        ['name' => 'Vợt cầu lông', 'image' => '1.1.webp', 'category' => 'Vợt cầu lông'],
                        ['name' => 'Giày cầu lông', 'image' => '2_1.webp', 'category' => 'Giày cầu lông'],
                        ['name' => 'Áo cầu lông', 'image' => '3_1.webp', 'category' => 'Áo cầu lông'],
                        ['name' => 'Quần cầu lông', 'image' => '4.webp', 'category' => 'Quần cầu lông'],
                        ['name' => 'Túi vợt', 'image' => '5.webp', 'category' => 'Túi vợt'],
                        ['name' => 'Balo thể thao', 'image' => '6.webp', 'category' => 'Balo thể thao'],
                        ['name' => 'Phụ kiện', 'image' => '7.webp', 'category' => 'Phụ kiện'],
                        ['name' => 'Quả cầu', 'image' => '8.webp', 'category' => 'Quả cầu']
                    ];
                    
                    $productCounts = $data['siteModel']->getProductCountsByCategory();
                    
                    foreach ($categoryData as $category): 
                        $count = isset($productCounts[$category['category']]) ? $productCounts[$category['category']] : 0;
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/' . $category['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['name']); ?>">
                                <div class="category-overlay">
                                    <a href="<?php echo URL::to('public/ProductSite/index?category=' . urlencode($category['category'])); ?>" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                                <span><?php echo $count; ?> sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Sale Products -->
        <section class="sale-products">
            <div class="container">
                <div class="section-header">
                    <h2>Sản phẩm mới nhất</h2>
                    <p>Khám phá những sản phẩm mới về của chúng tôi</p>
                </div>
                <div class="row">
                <?php
                    $newestProducts = $data['siteModel']->getNewestProducts(4);
                    foreach($newestProducts as $product):
                        $averageRating = round($product['average_rating'], 1);
                        $fullStars = floor($averageRating);
                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - ($fullStars + $halfStar);
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                        <div class="product-card card h-100 d-flex flex-column" data-id="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>" data-rating="<?php echo $averageRating; ?>" data-category="<?php echo strtolower($product['category']); ?>">
                            <div class="sale-badge">NEW</div>
                            <div class="product-img">
                                <img src="/Shop-badminton/AssignmentWeb/app/<?php echo $product['image_path']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top img-fluid" style="width: 250px; height: 300px; object-fit: cover; align-self: center;">
                                <div class="product-actions">
                                    <a href="/Shop-badminton/AssignmentWeb/app/views/product_site/product_detail.php?id=<?php echo $product['id']; ?>" class="btn-action"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn-action"><i class="fas fa-shopping-cart"></i></a>
                                    <a href="#" class="btn-action"><i class="fas fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-info card-body">
                                <div class="product-brand"><?php echo ucfirst($product['category']); ?></div>
                                <h3 class="product-title card-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="product-price card-text">
                                    <span class="current-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</span>
                                </div>
                                <div class="product-rating">
                                    <?php
                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        }
                                        if ($halfStar) {
                                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                        }
                                        for ($i = 0; $i < $emptyStars; $i++) {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="add-to-cart mt-auto">
                                <a href="<?php echo URL::to('public/ProductSite/productdetail?id=' . $product['id']); ?>" class="btn btn-custom btn-add-cart">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= URL::to('public/ProductSite/index'); ?>" class="btn-view-all">Xem tất cả sản phẩm <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        <!-- Banner Section -->
        <section class="banner-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="promo-banner">
                            <img src="<?php echo URL::asset('images/1.1.webp'); ?>" alt="Promo Banner">
                            <div class="banner-content">
                                <h3>Vợt cầu lông cao cấp</h3>
                                <p>Bộ sưu tập tất cả vợt Yonex</p>
                                <a href="<?php echo URL::to('public/ProductSite/index?category=' . urlencode('Vợt cầu lông') . '&brand=' . urlencode('Yonex')); ?>" class="btn-shop-now">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="promo-banner">
                            <img src="<?php echo URL::asset('images/2_1.webp'); ?>" alt="Promo Banner">
                            <div class="banner-content">
                                <h3>Giày cầu lông chính hãng</h3>
                                <p>Bộ sưu tập mới nhất từ Li-Ning</p>
                                <a href="<?php echo URL::to('public/ProductSite/index?category=' . urlencode('Giày cầu lông') . '&brand=' . urlencode('Li-Ning')); ?>" class="btn-shop-now">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section class="news-section">
            <div class="container">
                <div class="section-header">
                    <h2>TIN TỨC MỚI</h2>
                    <p>Cập nhật thông tin mới nhất về cầu lông</p>
                </div>
                <div class="row">
                    <?php
                    // Fetch the 3 most recent news articles
                    $stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc ORDER BY Ngay_viet DESC LIMIT 3");
                    $stmt->execute();
                    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach($news as $article):
                        // Convert date to day and month
                        $date = new DateTime($article['Ngay_viet']);
                        $day = $date->format('d');
                        $month = 'Tháng ' . $date->format('n');
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="<?php echo URL::to('app/views/news_site/' . $article['Link_anh']); ?>" alt="<?php echo htmlspecialchars($article['Title']); ?>">
                                <div class="news-date">
                                    <span class="day"><?php echo $day; ?></span>
                                    <span class="month"><?php echo $month; ?></span>
                                </div>
                            </div>
                            <div class="news-body">
                                <div class="news-meta">
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($article['Nguoi_viet']); ?></span>
                                    <?php
                                    // Get comment count for this article
                                    $stmt_comments = $pdo->prepare("SELECT COUNT(*) FROM bang_cmt WHERE ID_tin = ?");
                                    $stmt_comments->execute([$article['ID_tin']]);
                                    $comment_count = $stmt_comments->fetchColumn();
                                    ?>
                                    <span><i class="fas fa-comments"></i> <?php echo $comment_count; ?> bình luận</span>
                                </div>
                                <h5 class="news-title"><?php echo htmlspecialchars($article['Title']); ?></h5>
                                <p class="news-text"><?php echo mb_substr(strip_tags($article['Noi_dung_tin']), 0, 100) . '...'; ?></p>
                                <a href="<?php echo URL::to('public/News_site/chitiettin?ID_tin=' . $article['ID_tin']); ?>" class="btn-read-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo URL::to('public/News_site/tintuc'); ?>" class="btn-view-all">Xem tất cả tin tức <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        <!-- Brands Section -->
        <section class="brands-section">
            <div class="container">
                <div class="section-header">
                    <h2>THƯƠNG HIỆU NỔI BẬT</h2>
                    <p>Đối tác chính thức của chúng tôi</p>
                </div>
                <div class="brands-slider">
                    <div class="brand-item">
                        <img src="<?php echo URL::asset('images/logo-web.png'); ?>" alt="Brand">
                    </div>
                    <div class="brand-item">
                        <img src="<?php echo URL::asset('images/logo-web.png'); ?>" alt="Brand">
                    </div>
                    <div class="brand-item">
                        <img src="<?php echo URL::asset('images/logo-web.png'); ?>" alt="Brand">
                    </div>
                    <div class="brand-item">
                        <img src="<?php echo URL::asset('images/logo-web.png'); ?>" alt="Brand">
                    </div>
                    <div class="brand-item">
                        <img src="<?php echo URL::asset('images/logo-web.png'); ?>" alt="Brand">
                    </div>
                </div>
            </div>
        </section>

        <?php require_once dirname(__DIR__) . '/header_footer/footer.php'; ?>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php require_once __DIR__ . '/../../helper/URL.php'; ?>
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
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/1.1.webp'); ?>" class="card-img-top" alt="Vợt cầu lông">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Vợt cầu lông</h4>
                                <span>24 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/2_1.webp'); ?>" class="card-img-top" alt="Giày cầu lông">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Giày cầu lông</h4>
                                <span>18 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/3_1.webp'); ?>" class="card-img-top" alt="Áo cầu lông">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Áo cầu lông</h4>
                                <span>32 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/4.webp'); ?>" class="card-img-top" alt="Quần cầu lông">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Quần cầu lông</h4>
                                <span>15 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/5.webp'); ?>" class="card-img-top" alt="Túi vợt">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Túi vợt</h4>
                                <span>12 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/6.webp'); ?>" class="card-img-top" alt="Balo thể thao">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Balo thể thao</h4>
                                <span>8 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/7.webp'); ?>" class="card-img-top" alt="Phụ kiện">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Phụ kiện</h4>
                                <span>28 sản phẩm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="category-card">
                            <div class="category-img">
                                <img src="<?php echo URL::asset('images/8.webp'); ?>" class="card-img-top" alt="Quả cầu">
                                <div class="category-overlay">
                                    <a href="#" class="btn-view">Xem ngay</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4>Quả cầu</h4>
                                <span>6 sản phẩm</span>
                            </div>
                        </div>
                    </div>
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
                                <a href="#" class="btn-shop-now">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="promo-banner">
                            <img src="<?php echo URL::asset('images/2_1.webp'); ?>" alt="Promo Banner">
                            <div class="banner-content">
                                <h3>Giày cầu lông chính hãng</h3>
                                <p>Bộ sưu tập mới nhất từ Li-Ning</p>
                                <a href="#" class="btn-shop-now">Mua ngay</a>
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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="<?php echo URL::asset('images/1.1.webp'); ?>" alt="Tin tức">
                                <div class="news-date">
                                    <span class="day">15</span>
                                    <span class="month">Tháng 4</span>
                                </div>
                            </div>
                            <div class="news-body">
                                <div class="news-meta">
                                    <span><i class="fas fa-user"></i> Admin</span>
                                    <span><i class="fas fa-comments"></i> 5 bình luận</span>
                                </div>
                                <h5 class="news-title">Sản phẩm mới ra mắt</h5>
                                <p class="news-text">Khám phá bộ sưu tập vợt cầu lông mới nhất với công nghệ tiên tiến giúp nâng cao hiệu suất chơi.</p>
                                <a href="#" class="btn-read-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="<?php echo URL::asset('images/2_1.webp'); ?>" alt="Tin tức">
                                <div class="news-date">
                                    <span class="day">12</span>
                                    <span class="month">Tháng 4</span>
                                </div>
                            </div>
                            <div class="news-body">
                                <div class="news-meta">
                                    <span><i class="fas fa-user"></i> Admin</span>
                                    <span><i class="fas fa-comments"></i> 3 bình luận</span>
                                </div>
                                <h5 class="news-title">Giải đấu sắp diễn ra</h5>
                                <p class="news-text">Thông tin về các giải đấu cầu lông sắp diễn ra trong tháng tới và cách đăng ký tham gia.</p>
                                <a href="#" class="btn-read-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="<?php echo URL::asset('images/3_1.webp'); ?>" alt="Tin tức">
                                <div class="news-date">
                                    <span class="day">10</span>
                                    <span class="month">Tháng 4</span>
                                </div>
                            </div>
                            <div class="news-body">
                                <div class="news-meta">
                                    <span><i class="fas fa-user"></i> Admin</span>
                                    <span><i class="fas fa-comments"></i> 8 bình luận</span>
                                </div>
                                <h5 class="news-title">Kỹ thuật cầu lông cơ bản</h5>
                                <p class="news-text">Hướng dẫn các kỹ thuật cơ bản dành cho người mới bắt đầu chơi cầu lông từ các chuyên gia.</p>
                                <a href="#" class="btn-read-more">Xem thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="#" class="btn-view-all">Xem tất cả tin tức <i class="fas fa-arrow-right"></i></a>
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Sports Shop - Liên Hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid px-0">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="logo-hotline">
                            <img src="../../assets/images/logo-web.png" alt="logo" class="logo-img">
                            <div class="hotline">
                                <i class="fas fa-phone-alt text-primary"></i>
                                <span class="fw-bold">HOTLINE:</span> 
                                <span><?php foreach($data['formalInfo'] as $info): ?>
                                    <?php if($info['name'] == 'Hotline'): ?>
                                        <?php echo $info['description']; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 d-none d-lg-block text-center">
                        <img src="../../assets/images/logo-web.png" alt="logo" class="center-logo">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="header-actions">
                            <?php if(isset($data['user'])): ?>
                                <div class="dropdown">
                                    <a href="#" class="action-link dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i>
                                        <span class="d-none d-md-inline"><?php echo $data['user']['name']; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Thông tin tài khoản</a></li>
                                        <li><a class="dropdown-item" href="#">Đơn hàng của tôi</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="<?php echo URL::to('public/auth/logout'); ?>">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <div class="auth-buttons">
                                    <a href="<?php echo URL::to('public/auth/login'); ?>" class="btn btn-outline-primary">Đăng nhập</a>
                                    <a href="<?php echo URL::to('public/auth/register'); ?>" class="btn btn-primary">Đăng ký</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="main-nav">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/Shop-badminton/AssignmentWeb/public/home/index">TRANG CHỦ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">GIỚI THIỆU</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">SẢN PHẨM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">TIN TỨC</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">HƯỚNG DẪN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">KHUYẾN MÃI</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="<?php echo URL::to('public/home/contract'); ?>">LIÊN HỆ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="contact-info-box">
                            <h2>NƠI GIẢI ĐÁP TOÀN BỘ MỌI THẮC MẮC CỦA BẠN</h2>
                            <div class="title-line"></div>
                            <div class="contact-details">
                                <div class="contact-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <div>
                                        <h5>Hotline</h5>
                                        <?php foreach($data['formalInfo'] as $info): ?>
                                    <?php if($info['name'] == 'Hotline'): ?>
                                       <p> <?php echo $info['description']; ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <h5>Email</h5>
                                        <?php foreach($data['formalInfo'] as $info): ?>
                                    <?php if($info['name'] == 'Email shop'): ?>
                                       <p> <?php echo $info['description']; ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <h5>Địa chỉ</h5>
                                        <p>123 đường ABC, quận XYZ, TP.HCM</p>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <h5>Giờ làm việc</h5>
                                        <p>Thứ 2 - Chủ nhật: 8:00 - 22:00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="social-links mt-4">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form-box">
                            <h3>GỬI THÔNG TIN LIÊN HỆ</h3>
                            <p>Vui lòng điền đầy đủ thông tin bên dưới, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất</p>
                            <form class="contact-form" method="POST" id="contactForm" onsubmit="return handleSubmit(event)">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first-name">Họ và tên đệm</label>
                                        <input type="text" id="first-name" name="firstName" class="form-control" placeholder="Họ và tên đệm" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last-name">Tên</label>
                                        <input type="text" id="last-name" name="lastName" class="form-control" placeholder="Tên" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message">Nội dung phản hồi</label>
                                    <textarea id="message" name="content" class="form-control" rows="5" placeholder="Nội dung" required></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                    <button type="reset" class="btn btn-outline-secondary">Làm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="map-section">
            <div class="container-fluid px-0">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5177580567037!2d106.69892121471856!3d10.771412992324944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3330bcc7%3A0x4db964d76bf6e18e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaG9hIGjhu41jIFThu7Egbmhpw6puIFRQLkhDTQ!5e0!3m2!1svi!2s!4v1648196248528!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>

        <footer class="main-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="footer-widget">
                            <h5>THÔNG TIN CHUNG</h5>
                            <div class="footer-divider"></div>
                            <p>Sports là hệ thống cửa hàng cầu lông với hơn 50 chi nhánh trên toàn quốc, cung cấp sỉ và lẻ các mặt hàng dụng cụ cầu lông từ phong trào tới chuyên nghiệp.</p>
                            <div class="social-links">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="footer-widget">
                            <h5>THÔNG TIN LIÊN HỆ</h5>
                            <div class="footer-divider"></div>
                            <ul class="contact-info">
                                <li><i class="fas fa-map-marker-alt"></i> 123 đường ABC, quận XYZ, TP.HCM</li>
                                <li><i class="fas fa-phone-alt"></i> Hotline: 0000000000</li>
                                <li><i class="fas fa-envelope"></i> Email: info@gmail.com</li>
                                <li><i class="fas fa-clock"></i> Giờ làm việc: 8:00 - 22:00</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="footer-widget">
                            <h5>CHÍNH SÁCH</h5>
                            <div class="footer-divider"></div>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fas fa-angle-right"></i> Chính sách bảo hành</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Chính sách đổi trả</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Chính sách vận chuyển</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Chính sách thanh toán</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Chính sách bảo mật</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="footer-widget">
                            <h5>HƯỚNG DẪN</h5>
                            <div class="footer-divider"></div>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fas fa-angle-right"></i> Hướng dẫn mua hàng</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Hướng dẫn thanh toán</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Hướng dẫn đổi trả</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Hướng dẫn bảo hành</a></li>
                                <li><a href="#"><i class="fas fa-angle-right"></i> Câu hỏi thường gặp</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="copyright">© 2024 Sports Shop. All Rights Reserved.</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="payment-methods">
                                <span>Phương thức thanh toán:</span>
                                <img src="../../assets/images/logo-web.png" alt="Payment Methods" class="payment-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/extensions/parsleyjs/parsley.min.js"></script>
    <script>
        function handleSubmit(event) {
            event.preventDefault();
            
            const form = document.getElementById('contactForm');
            const formData = new FormData(form);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    showAlert('success', 'Cảm ơn bạn đã gửi thông tin! Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.');
                    form.reset();
                } else {
                    showAlert('danger', 'Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại sau.');
                }
            })
            .catch(error => {
                showAlert('danger', 'Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại sau.');
            });

            return false;
        }

        function showAlert(type, message) {
            // Remove any existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            // Insert alert before the form
            const form = document.getElementById('contactForm');
            form.parentNode.insertBefore(alertDiv, form);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    </script>
</body>
</html>


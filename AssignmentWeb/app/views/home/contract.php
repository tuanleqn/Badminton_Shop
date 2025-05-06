<!DOCTYPE html>
<html lang="vi">
<?php require_once dirname(__DIR__) . '/header_footer/header.php'; ?>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row justify-content-center my-5">
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

<?php require_once dirname(__DIR__) . '/header_footer/footer.php'; ?>

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


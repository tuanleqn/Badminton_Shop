<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>THÔNG TIN CHUNG</h5>
                <?php foreach($formalInfo as $info): ?>
                    <?php if($info['name'] == 'About'): ?>
                        <p><?php echo $info['description']; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="social-icons">
                    <a href="<?php foreach($formalInfo as $info): ?>
                            <?php if($info['name'] == 'Facebook'): ?>
                                <?php echo $info['description']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php foreach($formalInfo as $info): ?>
                            <?php if($info['name'] == 'Instagram'): ?>
                                <?php echo $info['description']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>"><i class="fab fa-instagram"></i></a>
                    <a href="<?php foreach($formalInfo as $info): ?>
                            <?php if($info['name'] == 'Youtube'): ?>
                                <?php echo $info['description']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>THÔNG TIN LIÊN HỆ</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 đường ABC, quận XYZ, TP.HCM</li>
                    <li><i class="fas fa-phone me-2"></i> 
                        <?php foreach($formalInfo as $info): ?>
                            <?php if($info['name'] == 'Hotline'): ?>
                                <?php echo $info['description']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </li>
                    <li><i class="fas fa-envelope me-2"></i>
                        <?php foreach($formalInfo as $info): ?>
                            <?php if($info['name'] == 'Email shop'): ?>
                                <?php echo $info['description']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                <h5 class="mb-3">ĐĂNG KÝ NHẬN TIN</h5>
                <p>Đăng ký nhận thông tin khuyến mãi và sản phẩm mới nhất từ VNB SPORTS</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email của bạn">
                    <button class="btn btn-primary" type="button">Đăng ký</button>
                </div>
            </div>
        </div>

        <div class="copyright text-center mt-3">
            <p class="mb-0">&copy; 2025 VNB SPORTS. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mobile Navigation
  const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
  const mobileNav = document.getElementById('mobile-nav');
  const mobileNavOverlay = document.getElementById('mobile-nav-overlay');
  const mobileNavClose = document.getElementById('mobile-nav-close');

  if (mobileMenuToggle && mobileNav && mobileNavOverlay && mobileNavClose) {
    mobileMenuToggle.addEventListener('click', function () {
      mobileNav.classList.add('active');
      mobileNavOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    });

    function closeMobileNav() {
      mobileNav.classList.remove('active');
      mobileNavOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    mobileNavClose.addEventListener('click', closeMobileNav);
    mobileNavOverlay.addEventListener('click', closeMobileNav);

    window.addEventListener('resize', function () {
      if (window.innerWidth >= 768) {
        closeMobileNav();
      }
    });
  }
</script>
</body>

</html>
<?php
$userData = $user;
include(__DIR__ . '/../header_footer/header.php');
?>

<style>
  .hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
      url('<?php echo URL::to("assets/images/cover-photo.png"); ?>');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 80px 0;
    text-align: center;
  }

  .hero-section h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .hero-section p {
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto 30px;
  }

  .btn-primary {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s;
  }

  .btn-primary:hover {
    background-color: #e55c00;
    border-color: #e55c00;
    transform: translateY(-2px);
  }

  .section-title {
    position: relative;
    margin-bottom: 40px;
    font-weight: 700;
    color: var(--primary-color);
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: var(--secondary-color);
  }

  .intro-section,
  .vision-section,
  .philosophy-section,
  .quality-section,
  .slogan-section,
  .stores-section {
    padding: 60px 0;
  }

  .vision-section,
  .philosophy-section,
  .slogan-section {
    background-color: var(--light-color);
  }

  .vision-card {
    background-color: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    height: 100%;
    transition: transform 0.3s;
    margin: 0 10px;
  }

  .vision-card:hover {
    transform: translateY(-5px);
  }

  .vision-card h3 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 15px;
  }

  .vision-icon {
    font-size: 2.5rem;
    color: var(--secondary-color);
    margin-bottom: 20px;
  }

  .store-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    margin: 0 10px;
  }

  .store-card:hover {
    transform: translateY(-5px);
  }

  .store-card .card-body {
    padding: 25px;
  }

  .store-card .card-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 15px;
  }

  .store-card .card-text {
    color: #666;
    margin-bottom: 12px;
  }

  .sidebar {
    margin-bottom: 30px;
  }

  .sidebar-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary-color);
  }

  .sidebar-item {
    display: block;
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    color: var(--dark-color);
    text-decoration: none;
    transition: all 0.3s;
  }

  .sidebar-item:hover {
    background-color: #f5f5f5;
    color: var(--secondary-color);
    padding-left: 20px;
  }

  .sidebar-item i {
    margin-right: 10px;
    color: var(--secondary-color);
  }

  .card-container {
    padding: 0 15px;
  }

  /* Mobile view */
  @media (max-width: 767px) {
    .hero-section {
      padding: 50px 20px;
      text-align: center;
    }

    .hero-section h1 {
      font-size: 2rem;
    }

    .hero-section p {
      font-size: 1rem;
    }

    .btn-primary {
      padding: 8px 20px;
      font-size: 0.9rem;
    }

    .vision-card,
    .store-card {
      margin: 10px 0;
    }

    .sidebar {
      margin-bottom: 20px;
    }

    .sidebar-item {
      padding: 10px;
      font-size: 0.9rem;
    }

    .section-title {
      font-size: 1.5rem;
    }

    .section-title::after {
      width: 40px;
    }
  }

  /* Tablet view */
  @media (min-width: 768px) and (max-width: 991px) {
    .hero-section {
      padding: 60px 30px;
    }

    .hero-section h1 {
      font-size: 2.5rem;
    }

    .hero-section p {
      font-size: 1.1rem;
    }

    .btn-primary {
      padding: 10px 20px;
      font-size: 1rem;
    }

    .vision-card,
    .store-card {
      margin: 15px 0;
    }

    .sidebar {
      margin-bottom: 25px;
    }

    .sidebar-item {
      padding: 12px;
      font-size: 1rem;
    }

    .section-title {
      font-size: 1.8rem;
    }

    .section-title::after {
      width: 50px;
    }
  }
</style>

<section class="hero-section">
  <div class="container">
    <h1>GIỚI THIỆU</h1>
    <p>Hệ thống shop cầu lông hàng đầu Việt Nam với hơn 1 Super Center, 5 shop Premium và 66 chi nhánh trên toàn quốc
    </p>
    <a href="#" class="btn btn-primary">Mua sắm ngay</a>
  </div>
</section>

<div class="container py-5">
  <div class="row">
    <div class="col-lg-8">
      <section class="intro-section pb-5">
        <h2 class="section-title">GIỚI THIỆU</h2>
        <div class="row">
          <div class="col-lg-12">
            <?php foreach ($introduceContent as $content): ?>
              <p><?php echo $content['content']; ?></p>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </div>

    <div class="col-lg-4">
      <div class="sticky-sidebar">
        <div class="sidebar mb-5">
          <h3 class="sidebar-title">CÓ THỂ BẠN SẼ THÍCH</h3>
          <?php foreach ($suggestedContent as $item): ?>
            <a href="<?php echo URL::to($item['note']); ?>" class="sidebar-item">
              <i class="fas fa-link"></i> <?php echo $item['content']; ?>
            </a>
          <?php endforeach; ?>
        </div>

        <div class="sidebar mb-5">
          <h3 class="sidebar-title">DANH MỤC TIN TỨC</h3>
          <?php foreach ($newsCategories as $item): ?>
            <a href="<?php echo URL::to($item['note']); ?>" class="sidebar-item">
              <i class="fas fa-newspaper"></i> <?php echo $item['content']; ?>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="sidebar">
          <h3 class="sidebar-title">DANH MỤC SẢN PHẨM</h3>
          <?php foreach ($productCategories as $item): ?>
            <a href="<?php echo URL::to($item['note']); ?>" class="sidebar-item">
              <i class="fas fa-badminton"></i> <?php echo $item['content']; ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="vision-section py-5">
  <div class="container">
    <h2 class="section-title">TẦM NHÌN, SỨ MỆNH VÀ GIÁ TRỊ CỐT LÕI</h2>
    <div class="row">
      <div class="col-lg-4 mb-4 card-container">
        <div class="vision-card">
          <div class="vision-icon">
            <i class="fas fa-eye"></i>
          </div>
          <h3>TẦM NHÌN</h3>
          <?php foreach ($visionContent as $content): ?>
            <p><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-4 mb-4 card-container">
        <div class="vision-card">
          <div class="vision-icon">
            <i class="fas fa-bullseye"></i>
          </div>
          <h3>SỨ MỆNH</h3>
          <?php foreach ($missionContent as $content): ?>
            <p><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-4 mb-4 card-container">
        <div class="vision-card">
          <div class="vision-icon">
            <i class="fas fa-gem"></i>
          </div>
          <h3>GIÁ TRỊ CỐT LÕI</h3>
          <?php foreach ($coreValuesContent as $content): ?>
            <p><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="philosophy-section py-5">
  <div class="container">
    <h2 class="section-title">TRIẾT LÝ KINH DOANH</h2>
    <div class="row">
      <div class="col-lg-12">
        <div class="vision-card">
          <div class="vision-icon text-center">
            <i class="fas fa-handshake"></i>
          </div>
          <?php foreach ($businessPhilosophyContent as $content): ?>
            <p class="text-center"><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="quality-section py-5">
  <div class="container">
    <h2 class="section-title">CHÍNH SÁCH CHẤT LƯỢNG</h2>
    <div class="row">
      <div class="col-lg-12">
        <div class="vision-card">
          <div class="vision-icon text-center">
            <i class="fas fa-certificate"></i>
          </div>
          <?php foreach ($qualityPolicyContent as $content): ?>
            <p><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="slogan-section py-5">
  <div class="container">
    <h2 class="section-title">KHẨU HIỆU</h2>
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="vision-card">
          <div class="vision-icon">
            <i class="fas fa-quote-left"></i>
          </div>
          <h3 class="mb-4">Slogan</h3>
          <?php foreach ($sloganContent as $content): ?>
            <p class="fs-2 fw-bold text-primary"><?php echo $content['content']; ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="stores-section py-5">
  <div class="container">
    <h2 class="section-title">HỆ THỐNG CỬA HÀNG</h2>
    <div class="row">
      <?php
      $index = 1;
      foreach ($branches as $branch): ?>
        <div class="col-md-4 mb-4 card-container">
          <div class="store-card">
            <div class="card-body">
              <h5 class="card-title">Cửa hàng <?php echo $index; ?></h5>
              <p class="card-text"><i class="fas fa-phone-alt text-primary me-2"></i> <?php echo $branch['user_phone']; ?>
              </p>
              <p class="card-text"><i class="fas fa-map-marker-alt text-primary me-2"></i>
                <?php echo $branch['branch_address']; ?></p>
              <a href="#" class="btn btn-outline-primary mt-2">Xem bản đồ</a>
            </div>
          </div>
        </div>
        <?php
        $index++;
      endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <a href="#" class="btn btn-primary">Xem tất cả cửa hàng</a>
    </div>
  </div>
</section>

<?php
include(__DIR__ . '/../header_footer/footer.php');
?>

<script>
  // Hiệu ứng fadeIn cho từng section khi cuộn đến
  window.addEventListener('scroll', function () {
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
      const sectionTop = section.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      if (sectionTop < windowHeight * 0.75) {
        section.classList.add('animate__animated', 'animate__fadeIn');
      }
    });
  });

  // Nếu màn hình nhỏ, loại bỏ lớp sticky của sidebar
  if (window.innerWidth < 768) {
    const sidebar = document.querySelector('.sticky-sidebar');
    if (sidebar) {
      sidebar.classList.remove('sticky-sidebar');
    }
  }
</script>
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

  /* Faq */
  .faq-section {
    padding: 60px 0;
  }

  .faq-search {
    margin-bottom: 40px;
  }

  .faq-search .form-control {
    padding: 12px 20px;
    border-radius: 30px;
    border: 1px solid #ddd;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .faq-search .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
  }

  .faq-search .btn {
    border-radius: 30px;
    padding: 12px 25px;
  }

  .faq-category {
    margin-bottom: 40px;
  }

  .faq-category-title {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary-color);
  }

  /* Accordion */
  .accordion-item {
    border: none;
    margin-bottom: 15px;
    border-radius: 8px !important;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .accordion-button {
    font-weight: 600;
    padding: 20px;
    background-color: white;
    color: var(--dark-color);
  }

  .accordion-button:not(.collapsed) {
    background-color: var(--primary-color);
    color: white;
  }

  .accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
  }

  .accordion-body {
    padding: 20px;
    background-color: #f9f9f9;
  }

  /* Form & Contact Info */
  .contact-form {
    background-color: var(--light-color);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .contact-form .form-control {
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
  }

  .contact-form .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
  }

  .contact-info {
    padding: 40px;
  }

  .contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
  }

  .contact-info-icon {
    width: 50px;
    height: 50px;
    background-color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .contact-info-content h5 {
    font-weight: 600;
    margin-bottom: 5px;
  }

  .contact-info-content p {
    color: #666;
    margin-bottom: 0;
  }

  /* Navigation danh mục trong FAQ */
  .faq-category-nav {
    position: sticky;
    top: 20px;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .faq-category-nav .nav-link {
    color: var(--dark-color);
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s;
  }

  .faq-category-nav .nav-link:hover,
  .faq-category-nav .nav-link.active {
    background-color: var(--primary-color);
    color: white;
  }

  .faq-category-nav .nav-link i {
    margin-right: 10px;
    color: var(--secondary-color);
  }

  .faq-category-nav .nav-link:hover i,
  .faq-category-nav .nav-link.active i {
    color: white;
  }

  /* Mobile view */
  @media (max-width: 767px) {
    .faq-category-nav {
      position: static;
      margin-bottom: 20px;
    }

    .faq-search .form-control {
      padding: 10px 15px;
    }

    .accordion-button {
      padding: 15px;
    }
  }

  /* Tablet view */
  @media (min-width: 768px) and (max-width: 991px) {
    .faq-category-nav {
      top: 10px;
    }

    .faq-search .form-control {
      padding: 12px 18px;
    }
  }
</style>

<section class="hero-section">
  <div class="container">
    <h1>HỎI ĐÁP</h1>
    <p>Tìm kiếm câu trả lời cho các câu hỏi thường gặp về sản phẩm, dịch vụ và chính sách của VNB Sports</p>
  </div>
</section>

<section class="faq-section">
  <div class="container">
    <div class="faq-search">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="input-group">
            <input type="text" class="form-control" id="faq-search-input" placeholder="Tìm kiếm câu hỏi...">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Danh mục FAQ -->
      <div class="col-lg-3 mb-4">
        <div class="faq-category-nav">
          <h4 class="mb-4">Danh mục</h4>
          <ul class="nav flex-column">
            <?php if (!empty($faqs) && is_array($faqs)): ?>
              <?php
              $first = true;
              foreach ($faqs as $category => $faqItems):
                // Tạo slug cho danh mục dùng làm id anchor
                $categorySlug = strtolower(str_replace(' ', '-', $category));
                ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo $first ? 'active' : ''; ?>" href="#<?php echo $categorySlug; ?>">
                    <?php echo $category; ?>
                  </a>
                </li>
                <?php
                $first = false;
              endforeach;
              ?>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="#">Không có danh mục</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <div class="col-lg-9">
        <?php if (!empty($faqs) && is_array($faqs)): ?>
          <?php foreach ($faqs as $category => $faqItems):
            // Tạo slug cho danh mục (sử dụng cho id)
            $categorySlug = strtolower(str_replace(' ', '-', $category));
            // Tạo id duy nhất cho accordion của danh mục này
            $accordionId = "accordion" . ucfirst($categorySlug);
            ?>
            <div class="faq-category" id="<?php echo $categorySlug; ?>">
              <h3 class="faq-category-title"><?php echo $category; ?></h3>
              <div class="accordion" id="<?php echo $accordionId; ?>">
                <?php $itemIndex = 1; ?>
                <?php foreach ($faqItems as $faq):
                  // Tạo id duy nhất cho heading và collapse
                  $headingId = "heading" . ucfirst($categorySlug) . $itemIndex;
                  $collapseId = "collapse" . ucfirst($categorySlug) . $itemIndex;
                  // Item đầu tiên trong mỗi danh mục được show mặc định
                  $expanded = ($itemIndex === 1) ? "true" : "false";
                  $collapseClass = ($itemIndex === 1) ? "accordion-collapse collapse show" : "accordion-collapse collapse";
                  $buttonClass = ($itemIndex === 1) ? "accordion-button" : "accordion-button collapsed";
                  ?>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                      <button class="<?php echo $buttonClass; ?>" type="button" data-bs-toggle="collapse"
                        data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $expanded; ?>"
                        aria-controls="<?php echo $collapseId; ?>">
                        <?php echo $faq['question']; ?>
                      </button>
                    </h2>
                    <div id="<?php echo $collapseId; ?>" class="<?php echo $collapseClass; ?>"
                      aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#<?php echo $accordionId; ?>">
                      <div class="accordion-body">
                        <?php echo $faq['answer']; ?>
                      </div>
                    </div>
                  </div>
                  <?php $itemIndex++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Không có câu hỏi và trả lời nào.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>



<?php
include(__DIR__ . '/../header_footer/footer.php');
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('faq-search-input');
    const accordionItems = document.querySelectorAll('.accordion-item');
    const faqCategories = document.querySelectorAll('.faq-category');
    const navLinks = document.querySelectorAll('.faq-category-nav .nav-link');

    // Xử lý tìm kiếm trong FAQ
    if (searchInput) {
      searchInput.addEventListener('keyup', function () {
        const searchTerm = this.value.toLowerCase().trim();

        accordionItems.forEach(item => {
          const questionEl = item.querySelector('.accordion-button');
          const questionText = questionEl ? questionEl.textContent.toLowerCase() : "";
          // Nếu câu hỏi chứa từ khóa, hiển thị; ngược lại ẩn
          item.style.display = questionText.includes(searchTerm) ? 'block' : 'none';
        });

        // Ẩn danh mục nếu không có câu hỏi nào được hiển thị trong nó
        faqCategories.forEach(category => {
          const items = category.querySelectorAll('.accordion-item');
          let hasVisible = false;
          items.forEach(item => {
            if (item.style.display !== 'none') {
              hasVisible = true;
            }
          });
          category.style.display = hasVisible ? 'block' : 'none';
        });
      });
    }

    // Xử lý Navigation cho FAQ category
    navLinks.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');

        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 100,
            behavior: 'smooth'
          });
        }
      });
    });
  });
</script>
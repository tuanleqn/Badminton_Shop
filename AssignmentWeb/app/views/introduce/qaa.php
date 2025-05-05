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
            <button class="btn btn-primary" type="button"><i class="fas fa-search me-2"></i>Tìm kiếm</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 mb-4">
        <div class="faq-category-nav">
          <h4 class="mb-4">Danh mục</h4>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#mua-hang"><i class="fas fa-shopping-cart"></i>Mua hàng</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#san-pham"><i class="fas fa-box-open"></i>Sản phẩm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#bao-hanh"><i class="fas fa-shield-alt"></i>Bảo hành</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#van-chuyen"><i class="fas fa-truck"></i>Vận chuyển</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#doi-tra"><i class="fas fa-exchange-alt"></i>Đổi trả</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#thanh-toan"><i class="fas fa-credit-card"></i>Thanh toán</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tai-khoan"><i class="fas fa-user"></i>Tài khoản</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="faq-category" id="mua-hang">
          <h3 class="faq-category-title">Mua hàng</h3>
          <div class="accordion" id="accordionMuaHang">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  Làm thế nào để đặt hàng trên website VNB Sports?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionMuaHang">
                <div class="accordion-body">
                  <p>Để đặt hàng trên website VNB Sports, bạn có thể thực hiện theo các bước sau:</p>
                  <ol>
                    <li>Truy cập website <a href="https://shopvnb.com">shopvnb.com</a></li>
                    <li>Tìm kiếm và chọn sản phẩm bạn muốn mua</li>
                    <li>Nhấn nút "Thêm vào giỏ hàng"</li>
                    <li>Kiểm tra giỏ hàng và nhấn "Thanh toán"</li>
                    <li>Điền thông tin giao hàng và chọn phương thức thanh toán</li>
                    <li>Xác nhận đơn hàng</li>
                  </ol>
                  <p>Sau khi đặt hàng thành công, bạn sẽ nhận được email xác nhận đơn hàng và nhân viên của chúng tôi
                    sẽ liên hệ để xác nhận lại thông tin.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Tôi có thể mua hàng mà không cần đăng ký tài khoản không?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionMuaHang">
                <div class="accordion-body">
                  <p>Có, bạn có thể mua hàng trên website VNB Sports mà không cần đăng ký tài khoản. Khi thanh toán,
                    bạn chỉ cần điền đầy đủ thông tin giao hàng và chọn phương thức thanh toán.</p>
                  <p>Tuy nhiên, chúng tôi khuyên bạn nên đăng ký tài khoản để:</p>
                  <ul>
                    <li>Theo dõi lịch sử đơn hàng dễ dàng</li>
                    <li>Lưu thông tin giao hàng cho lần mua sau</li>
                    <li>Nhận thông tin về chương trình khuyến mãi</li>
                    <li>Tích lũy điểm thưởng và nhận ưu đãi</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Làm thế nào để kiểm tra tình trạng đơn hàng của tôi?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionMuaHang">
                <div class="accordion-body">
                  <p>Để kiểm tra tình trạng đơn hàng, bạn có thể thực hiện một trong các cách sau:</p>
                  <ol>
                    <li><strong>Đăng nhập tài khoản:</strong> Nếu bạn đã đăng ký tài khoản, hãy đăng nhập và vào mục
                      "Đơn hàng của tôi" để xem tình trạng đơn hàng.</li>
                    <li><strong>Kiểm tra email:</strong> Chúng tôi sẽ gửi email cập nhật tình trạng đơn hàng cho bạn.
                    </li>
                    <li><strong>Liên hệ hotline:</strong> Gọi số hotline 0936155994 và cung cấp mã đơn hàng để nhân
                      viên kiểm tra giúp bạn.</li>
                  </ol>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Tôi có thể hủy đơn hàng sau khi đã đặt không?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#accordionMuaHang">
                <div class="accordion-body">
                  <p>Bạn có thể hủy đơn hàng trong vòng 24 giờ sau khi đặt hàng và trước khi đơn hàng được giao cho
                    đơn vị vận chuyển. Để hủy đơn hàng, bạn có thể:</p>
                  <ul>
                    <li>Đăng nhập tài khoản và chọn "Hủy đơn hàng" trong mục "Đơn hàng của tôi"</li>
                    <li>Gọi hotline 0936155994 để được hỗ trợ hủy đơn hàng</li>
                  </ul>
                  <p>Lưu ý: Đối với đơn hàng đã được giao cho đơn vị vận chuyển, bạn sẽ không thể hủy đơn hàng. Trong
                    trường hợp này, bạn có thể từ chối nhận hàng hoặc liên hệ với chúng tôi để được hướng dẫn đổi/trả
                    hàng.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="san-pham">
          <h3 class="faq-category-title">Sản phẩm</h3>
          <div class="accordion" id="accordionSanPham">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                  aria-expanded="true" aria-controls="collapseFive">
                  Làm thế nào để biết sản phẩm còn hàng hay không?
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive"
                data-bs-parent="#accordionSanPham">
                <div class="accordion-body">
                  <p>Trên trang chi tiết sản phẩm, bạn có thể kiểm tra tình trạng hàng như sau:</p>
                  <ul>
                    <li>Nếu sản phẩm còn hàng, bạn sẽ thấy nút "Thêm vào giỏ hàng" và thông tin về số lượng còn lại.
                    </li>
                    <li>Nếu sản phẩm hết hàng, sẽ hiển thị thông báo "Hết hàng" hoặc "Tạm hết hàng".</li>
                  </ul>
                  <p>Ngoài ra, bạn có thể liên hệ trực tiếp với chúng tôi qua hotline 0936155994 để kiểm tra tình
                    trạng hàng chính xác nhất, đặc biệt là đối với các sản phẩm hot hoặc mới ra mắt.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Làm thế nào để phân biệt hàng chính hãng và hàng giả?
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                data-bs-parent="#accordionSanPham">
                <div class="accordion-body">
                  <p>VNB Sports cam kết chỉ bán hàng chính hãng 100%. Để phân biệt hàng chính hãng và hàng giả, bạn có
                    thể lưu ý các điểm sau:</p>
                  <ol>
                    <li><strong>Tem nhãn:</strong> Sản phẩm chính hãng luôn có tem nhãn rõ ràng, in sắc nét và có mã
                      QR hoặc mã vạch để kiểm tra.</li>
                    <li><strong>Chất lượng:</strong> Sản phẩm chính hãng có chất lượng hoàn thiện cao, không có lỗi
                      trong quá trình sản xuất.</li>
                    <li><strong>Giá cả:</strong> Hàng chính hãng thường có giá cả phù hợp với thị trường, không quá rẻ
                      so với mặt bằng chung.</li>
                    <li><strong>Bao bì:</strong> Hàng chính hãng có bao bì đẹp, chắc chắn, thông tin đầy đủ và rõ
                      ràng.</li>
                  </ol>
                  <p>Khi mua hàng tại VNB Sports, bạn sẽ nhận được hóa đơn và phiếu bảo hành chính hãng (nếu có), đảm
                    bảo quyền lợi của bạn.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                  Làm thế nào để chọn vợt cầu lông phù hợp?
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                data-bs-parent="#accordionSanPham">
                <div class="accordion-body">
                  <p>Để chọn vợt cầu lông phù hợp, bạn nên xem xét các yếu tố sau:</p>
                  <ol>
                    <li><strong>Trình độ chơi:</strong> Người mới chơi nên chọn vợt nhẹ, cân bằng đầu nhẹ hoặc cân
                      bằng. Người chơi trung cấp và cao cấp có thể chọn vợt theo phong cách chơi.</li>
                    <li><strong>Trọng lượng vợt:</strong> Vợt nhẹ (80-84g) dễ điều khiển, vợt nặng (85-89g) tạo lực
                      đánh mạnh hơn.</li>
                    <li><strong>Cân bằng vợt:</strong> Cân bằng đầu nhẹ giúp phòng thủ tốt, cân bằng đầu nặng tăng sức
                      mạnh tấn công.</li>
                    <li><strong>Độ cứng của thân vợt:</strong> Thân mềm giúp tạo lực tốt cho người mới, thân cứng phù
                      hợp với người có kỹ thuật và sức mạnh.</li>
                  </ol>
                  <p>Bạn có thể đến trực tiếp cửa hàng VNB Sports để được tư vấn và test vợt trước khi mua. Nhân viên
                    của chúng tôi sẽ giúp bạn chọn vợt phù hợp nhất với trình độ và phong cách chơi của bạn.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="bao-hanh">
          <h3 class="faq-category-title">Bảo hành</h3>
          <div class="accordion" id="accordionBaoHanh">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight"
                  aria-expanded="true" aria-controls="collapseEight">
                  Chính sách bảo hành của VNB Sports như thế nào?
                </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse show" aria-labelledby="headingEight"
                data-bs-parent="#accordionBaoHanh">
                <div class="accordion-body">
                  <p>VNB Sports áp dụng chính sách bảo hành theo quy định của nhà sản xuất:</p>
                  <ul>
                    <li><strong>Vợt cầu lông:</strong> Bảo hành 6-12 tháng tùy thương hiệu, chỉ áp dụng cho lỗi sản
                      xuất (nứt, gãy khung vợt trong điều kiện sử dụng bình thường).</li>
                    <li><strong>Giày cầu lông:</strong> Bảo hành 1-3 tháng tùy thương hiệu, chỉ áp dụng cho lỗi sản
                      xuất như bong đế, rách đường chỉ may.</li>
                    <li><strong>Phụ kiện:</strong> Bảo hành 1 tháng cho lỗi sản xuất.</li>
                  </ul>
                  <p>Lưu ý: Bảo hành không áp dụng cho các trường hợp hư hỏng do sử dụng không đúng cách, va đập mạnh,
                    hoặc tự ý sửa chữa. Để được bảo hành, bạn cần giữ hóa đơn và phiếu bảo hành.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                  Làm thế nào để yêu cầu bảo hành sản phẩm?
                </button>
              </h2>
              <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                data-bs-parent="#accordionBaoHanh">
                <div class="accordion-body">
                  <p>Để yêu cầu bảo hành sản phẩm, bạn có thể thực hiện theo các bước sau:</p>
                  <ol>
                    <li>Mang sản phẩm cần bảo hành đến bất kỳ cửa hàng VNB Sports nào trên toàn quốc.</li>
                    <li>Xuất trình hóa đơn mua hàng và phiếu bảo hành (nếu có).</li>
                    <li>Nhân viên của chúng tôi sẽ kiểm tra sản phẩm và xác định lỗi.</li>
                    <li>Nếu sản phẩm đủ điều kiện bảo hành, chúng tôi sẽ tiến hành sửa chữa hoặc đổi mới sản phẩm theo
                      chính sách của từng thương hiệu.</li>
                  </ol>
                  <p>Thời gian bảo hành thông thường từ 7-15 ngày tùy thuộc vào tình trạng sản phẩm và chính sách của
                    nhà sản xuất. Trong trường hợp cần thời gian lâu hơn, chúng tôi sẽ thông báo cụ thể cho bạn.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="van-chuyen">
          <h3 class="faq-category-title">Vận chuyển</h3>
          <div class="accordion" id="accordionVanChuyen">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTen">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen"
                  aria-expanded="true" aria-controls="collapseTen">
                  Phí vận chuyển được tính như thế nào?
                </button>
              </h2>
              <div id="collapseTen" class="accordion-collapse collapse show" aria-labelledby="headingTen"
                data-bs-parent="#accordionVanChuyen">
                <div class="accordion-body">
                  <p>Phí vận chuyển được tính dựa trên các yếu tố sau:</p>
                  <ul>
                    <li><strong>Khoảng cách:</strong> Phí vận chuyển sẽ khác nhau tùy thuộc vào khoảng cách từ kho
                      hàng đến địa chỉ giao hàng.</li>
                    <li><strong>Trọng lượng và kích thước:</strong> Sản phẩm càng nặng và kích thước càng lớn, phí vận
                      chuyển càng cao.</li>
                    <li><strong>Đơn vị vận chuyển:</strong> Mỗi đơn vị vận chuyển có mức phí khác nhau.</li>
                  </ul>
                  <p>Cụ thể:</p>
                  <ul>
                    <li>Nội thành Hà Nội và TP.HCM: 20.000đ - 30.000đ</li>
                    <li>Các tỉnh thành khác: 30.000đ - 50.000đ</li>
                  </ul>
                  <p>Đặc biệt, VNB Sports áp dụng chính sách miễn phí vận chuyển cho đơn hàng từ 500.000đ trở lên (áp
                    dụng cho khu vực nội thành) và từ 1.000.000đ trở lên (áp dụng toàn quốc).</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEleven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                  Thời gian giao hàng là bao lâu?
                </button>
              </h2>
              <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven"
                data-bs-parent="#accordionVanChuyen">
                <div class="accordion-body">
                  <p>Thời gian giao hàng phụ thuộc vào khu vực giao hàng:</p>
                  <ul>
                    <li><strong>Nội thành Hà Nội và TP.HCM:</strong> 1-2 ngày làm việc</li>
                    <li><strong>Các tỉnh thành miền Bắc và miền Nam:</strong> 2-3 ngày làm việc</li>
                    <li><strong>Các tỉnh miền Trung và Tây Nguyên:</strong> 3-5 ngày làm việc</li>
                    <li><strong>Khu vực hải đảo và vùng sâu vùng xa:</strong> 5-7 ngày làm việc</li>
                  </ul>
                  <p>Lưu ý: Thời gian giao hàng có thể bị ảnh hưởng bởi các yếu tố khách quan như thời tiết, giao
                    thông, dịch bệnh, v.v. Trong trường hợp này, chúng tôi sẽ thông báo cho bạn về sự chậm trễ và thời
                    gian giao hàng dự kiến mới.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="doi-tra">
          <h3 class="faq-category-title">Đổi trả</h3>
          <div class="accordion" id="accordionDoiTra">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwelve">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                  Chính sách đổi trả của VNB Sports như thế nào?
                </button>
              </h2>
              <div id="collapseTwelve" class="accordion-collapse collapse show" aria-labelledby="headingTwelve"
                data-bs-parent="#accordionDoiTra">
                <div class="accordion-body">
                  <p>VNB Sports áp dụng chính sách đổi trả như sau:</p>
                  <ul>
                    <li><strong>Thời gian đổi trả:</strong> Trong vòng 7 ngày kể từ ngày nhận hàng.</li>
                    <li><strong>Điều kiện đổi trả:</strong>
                      <ul>
                        <li>Sản phẩm còn nguyên vẹn, không có dấu hiệu đã qua sử dụng</li>
                        <li>Còn đầy đủ tem nhãn, bao bì, phụ kiện đi kèm</li>
                        <li>Có hóa đơn mua hàng hoặc phiếu giao hàng</li>
                      </ul>
                    </li>
                    <li><strong>Các trường hợp được đổi trả:</strong>
                      <ul>
                        <li>Sản phẩm bị lỗi do nhà sản xuất</li>
                        <li>Sản phẩm không đúng mẫu mã, kích thước như đã đặt</li>
                        <li>Sản phẩm không đúng như mô tả trên website</li>
                      </ul>
                    </li>
                  </ul>
                  <p>Lưu ý: Đối với vợt cầu lông đã được căng dây, chúng tôi không áp dụng chính sách đổi trả trừ khi
                    sản phẩm bị lỗi do nhà sản xuất.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThirteen">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                  Làm thế nào để đổi hoặc trả sản phẩm?
                </button>
              </h2>
              <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen"
                data-bs-parent="#accordionDoiTra">
                <div class="accordion-body">
                  <p>Để đổi hoặc trả sản phẩm, bạn có thể thực hiện theo các bước sau:</p>
                  <ol>
                    <li><strong>Liên hệ với chúng tôi:</strong> Gọi hotline 0936155994 hoặc gửi email đến
                      info@shopvnb.com để thông báo về việc đổi/trả sản phẩm.</li>
                    <li><strong>Cung cấp thông tin:</strong> Mã đơn hàng, tên sản phẩm, lý do đổi/trả.</li>
                    <li><strong>Nhận hướng dẫn:</strong> Nhân viên của chúng tôi sẽ hướng dẫn bạn cách thức đổi/trả
                      sản phẩm.</li>
                    <li><strong>Gửi sản phẩm:</strong> Đóng gói sản phẩm cẩn thận và gửi về địa chỉ được cung cấp, kèm
                      theo hóa đơn và phiếu đổi/trả.</li>
                  </ol>
                  <p>Sau khi nhận được sản phẩm và kiểm tra, chúng tôi sẽ tiến hành đổi sản phẩm mới hoặc hoàn tiền
                    cho bạn trong vòng 7 ngày làm việc.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="thanh-toan">
          <h3 class="faq-category-title">Thanh toán</h3>
          <div class="accordion" id="accordionThanhToan">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFourteen">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFourteen" aria-expanded="true" aria-controls="collapseFourteen">
                  VNB Sports chấp nhận những phương thức thanh toán nào?
                </button>
              </h2>
              <div id="collapseFourteen" class="accordion-collapse collapse show" aria-labelledby="headingFourteen"
                data-bs-parent="#accordionThanhToan">
                <div class="accordion-body">
                  <p>VNB Sports chấp nhận các phương thức thanh toán sau:</p>
                  <ul>
                    <li><strong>Thanh toán khi nhận hàng (COD):</strong> Bạn thanh toán trực tiếp cho nhân viên giao
                      hàng khi nhận sản phẩm.</li>
                    <li><strong>Chuyển khoản ngân hàng:</strong> Chuyển tiền vào tài khoản ngân hàng của VNB Sports.
                    </li>
                    <li><strong>Thanh toán qua thẻ tín dụng/ghi nợ:</strong> Thanh toán trực tuyến qua cổng thanh toán
                      an toàn.</li>
                    <li><strong>Ví điện tử:</strong> Thanh toán qua Momo, ZaloPay, VNPay, v.v.</li>
                    <li><strong>Trả góp:</strong> Áp dụng cho đơn hàng từ 3.000.000đ trở lên, hợp tác với các ngân
                      hàng và công ty tài chính.</li>
                  </ul>
                  <p>Lưu ý: Đối với thanh toán COD, một số khu vực vùng sâu vùng xa có thể không được hỗ trợ. Vui lòng
                    liên hệ với chúng tôi để biết thêm chi tiết.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFifteen">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                  Thanh toán trực tuyến có an toàn không?
                </button>
              </h2>
              <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen"
                data-bs-parent="#accordionThanhToan">
                <div class="accordion-body">
                  <p>Có, thanh toán trực tuyến tại VNB Sports hoàn toàn an toàn. Chúng tôi áp dụng các biện pháp bảo
                    mật cao nhất để bảo vệ thông tin thanh toán của bạn:</p>
                  <ul>
                    <li>Sử dụng công nghệ mã hóa SSL 256-bit để bảo vệ thông tin cá nhân và thông tin thanh toán.</li>
                    <li>Hợp tác với các cổng thanh toán uy tín và được cấp phép như VNPAY, OnePay, v.v.</li>
                    <li>Tuân thủ các tiêu chuẩn bảo mật quốc tế PCI DSS.</li>
                    <li>Không lưu trữ thông tin thẻ tín dụng của khách hàng.</li>
                  </ul>
                  <p>Nếu bạn vẫn lo ngại về vấn đề bảo mật, bạn có thể chọn phương thức thanh toán khi nhận hàng (COD)
                    hoặc chuyển khoản ngân hàng.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="faq-category" id="tai-khoan">
          <h3 class="faq-category-title">Tài khoản</h3>
          <div class="accordion" id="accordionTaiKhoan">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSixteen">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSixteen" aria-expanded="true" aria-controls="collapseSixteen">
                  Làm thế nào để đăng ký tài khoản trên website VNB Sports?
                </button>
              </h2>
              <div id="collapseSixteen" class="accordion-collapse collapse show" aria-labelledby="headingSixteen"
                data-bs-parent="#accordionTaiKhoan">
                <div class="accordion-body">
                  <p>Để đăng ký tài khoản trên website VNB Sports, bạn có thể thực hiện theo các bước sau:</p>
                  <ol>
                    <li>Truy cập website <a href="https://shopvnb.com">shopvnb.com</a></li>
                    <li>Nhấn vào nút "Đăng ký" ở góc trên bên phải màn hình</li>
                    <li>Điền đầy đủ thông tin cá nhân: họ tên, email, số điện thoại, mật khẩu</li>
                    <li>Nhấn nút "Đăng ký" để hoàn tất</li>
                  </ol>
                  <p>Sau khi đăng ký thành công, bạn sẽ nhận được email xác nhận. Hãy nhấn vào liên kết trong email để
                    kích hoạt tài khoản của bạn.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSeventeen">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen">
                  Tôi quên mật khẩu, làm thế nào để lấy lại?
                </button>
              </h2>
              <div id="collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="headingSeventeen"
                data-bs-parent="#accordionTaiKhoan">
                <div class="accordion-body">
                  <p>Nếu bạn quên mật khẩu, bạn có thể thực hiện các bước sau để lấy lại:</p>
                  <ol>
                    <li>Truy cập trang đăng nhập của VNB Sports</li>
                    <li>Nhấn vào liên kết "Quên mật khẩu"</li>
                    <li>Nhập địa chỉ email đã đăng ký tài khoản</li>
                    <li>Nhấn nút "Gửi yêu cầu"</li>
                    <li>Kiểm tra email và làm theo hướng dẫn để đặt lại mật khẩu</li>
                  </ol>
                  <p>Lưu ý: Liên kết đặt lại mật khẩu chỉ có hiệu lực trong vòng 24 giờ. Nếu bạn không nhận được
                    email, hãy kiểm tra thư mục spam hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="section-title">Gửi câu hỏi cho chúng tôi</h2>
        <p class="mb-4">Nếu bạn không tìm thấy câu trả lời cho câu hỏi của mình, vui lòng gửi câu hỏi cho chúng tôi
          qua form bên dưới. Đội ngũ hỗ trợ của chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
        <div class="contact-form">
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Họ và tên</label>
              <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên của bạn">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Nhập địa chỉ email của bạn">
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Số điện thoại</label>
              <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại của bạn">
            </div>
            <div class="mb-3">
              <label for="question" class="form-label">Câu hỏi của bạn</label>
              <textarea class="form-control" id="question" rows="5" placeholder="Nhập câu hỏi của bạn"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi câu hỏi</button>
          </form>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="contact-info">
          <h2 class="section-title">Thông tin liên hệ</h2>
          <p class="mb-4">Bạn cũng có thể liên hệ trực tiếp với chúng tôi qua các kênh sau:</p>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <div class="contact-info-content">
              <h5>Hotline</h5>
              <p>0936155994 | 0987654321</p>
              <p>Thời gian: 8h00 - 21h00 (Thứ 2 - Chủ nhật)</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="contact-info-content">
              <h5>Email</h5>
              <p>info@shopvnb.com</p>
              <p>cskh@shopvnb.com</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="contact-info-content">
              <h5>Trụ sở chính</h5>
              <p>390/2 Hà Huy Giáp, Phường Thạnh Lộc, Quận 12, TP.HCM</p>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon">
              <i class="fas fa-comments"></i>
            </div>
            <div class="contact-info-content">
              <h5>Chat trực tuyến</h5>
              <p>Chat với chúng tôi qua Messenger hoặc Zalo</p>
              <div class="mt-2">
                <a href="#" class="btn btn-outline-primary me-2"><i
                    class="fab fa-facebook-messenger me-2"></i>Messenger</a>
                <a href="#" class="btn btn-outline-primary"><i class="fas fa-comment me-2"></i>Zalo</a>
              </div>
            </div>
          </div>
        </div>
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
        const searchTerm = this.value.toLowerCase();

        accordionItems.forEach(item => {
          const question = item.querySelector('.accordion-button').textContent.toLowerCase();
          const answer = item.querySelector('.accordion-body').textContent.toLowerCase();

          item.style.display = (question.includes(searchTerm) || answer.includes(searchTerm)) ? 'block' : 'none';
        });

        faqCategories.forEach(category => {
          const visibleItems = category.querySelectorAll('.accordion-item[style="display: block"]');
          category.style.display = (visibleItems.length === 0) ? 'none' : 'block';
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
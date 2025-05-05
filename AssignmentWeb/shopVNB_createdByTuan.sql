SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION
    ;
SET
    time_zone = "+00:00";
DROP
    DATABASE IF EXISTS `shopVNB`;
CREATE DATABASE IF NOT EXISTS `shopVNB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci; USE
    `shopVNB`;
CREATE TABLE `user`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    pass VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    sex ENUM('M', 'F', 'Other'),
    NAME VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci UNIQUE NOT NULL,
    numOfVisit INT DEFAULT 0,
    role ENUM('admin', 'customer') DEFAULT 'customer'
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `branch`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    userId INT,
    FOREIGN KEY(userId) REFERENCES USER(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `brand`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `product`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    description TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    listsOfInmage TEXT,
    price DECIMAL(10, 2) NOT NULL,
    createdDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    category VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    rating DECIMAL(3, 2),
    color VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    size VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    branchId INT,
    FOREIGN KEY(branchId) REFERENCES branch(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `ProductCart`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    userId INT,
    FOREIGN KEY(userId) REFERENCES USER(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `Has`(
    productCartId INT,
    productId INT,
    quantity INT DEFAULT 1,
    PRIMARY KEY(productCartId, productId),
    FOREIGN KEY(productCartId) REFERENCES ProductCart(id),
    FOREIGN KEY(productId) REFERENCES product(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; CREATE TABLE `review`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    details TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    title VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    DATE DATETIME DEFAULT CURRENT_TIMESTAMP,
    stars INT CHECK
        (stars BETWEEN 1 AND 5),
        Product_id INT,
    STATUS ENUM
        ('pending', 'approved', 'rejected') DEFAULT 'pending',
        FOREIGN KEY(userId) REFERENCES USER(id),
        FOREIGN KEY(Product_id) REFERENCES product(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
CREATE TABLE `Response`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    lastName VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    content TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    STATUS ENUM
        ('new', 'read', 'replied') DEFAULT 'new'
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
CREATE TABLE `Formal inf`(
    `id` INT(11) NOT NULL,
    `name` VARCHAR(100) DEFAULT NULL,
    `description` TEXT DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
-- Bảng faq (hỗ trợ phần Q&A)
CREATE TABLE `faq`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    -- Danh mục: 'Mua hàng', 'Sản phẩm', v.v.
    question TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    answer TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    displayOrder INT DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
-- Bảng introduce (lưu trữ nội dung giới thiệu)
CREATE TABLE `introduce`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    -- Ví dụ: 'Tầm nhìn', 'Sứ mệnh'
    content TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    note TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; INSERT INTO `user`(
    id,
    phone,
    address,
    pass,
    sex,
    NAME,
    email,
    numOfVisit,
    role
)
VALUES(
    1,
    '0123456789',
    '123 Main St',
    'password123',
    'M',
    'John Doe',
    'john.doe@example.com',
    5,
    'customer'
),(
    2,
    '0987654321',
    '456 Elm St',
    'password456',
    'F',
    'Jane Smith',
    'jane.smith@example.com',
    3,
    'customer'
),(
    5,
    '0112233445',
    '789 Oak St',
    'password789',
    'M',
    'Mike Johnson',
    'mike.johnson@example.com',
    1,
    'admin'
);
INSERT INTO `branch`(address, userId)
VALUES(
    '390/2 Hà Huy Giáp, Phường Thạnh Lộc, Quận 12',
    1
),(
    '20 Cao Bá Nhạ, Phường Nguyễn Cư Trinh, Quận 1, TP.HCM',
    2
),(
    '209 Âu Cơ, Phường 5, Quận 11, TP.HCM',
    5
),(
    '284 Xô Viết Nghệ Tĩnh, P.21, Quận Bình Thạnh, TP.HCM',
    1
),(
    '916 Kha Vạn Cân, Phường Trường Thọ, TP.Thủ Đức',
    5
),(
    'Số 6 Nguyễn Hữu Cầu, Phường Tân Định, Quận 1, TP.HCM',
    2
);
INSERT INTO `brand`(id, NAME)
VALUES(1, 'Yonex'),(2, 'Li-Ning'),(3, 'Victor');
INSERT INTO `product`(
    id,
    NAME,
    description,
    listsOfInmage,
    price,
    category,
    rating,
    color,
    size,
    branchId
)
VALUES(
    1,
    'Badminton Racket A',
    'High-quality racket',
    '["img1.jpg", "img2.jpg"]',
    100.00,
    'Sports',
    4.8,
    'Blue',
    'Standard',
    1
),(
    2,
    'Badminton Shoes B',
    'Comfortable shoes',
    '["img3.jpg", "img4.jpg"]',
    80.00,
    'Sports',
    4.5,
    'White',
    '42',
    1
),(
    3,
    'Badminton Net C',
    'Durable net',
    '["img5.jpg"]',
    50.00,
    'Sports',
    4.2,
    'Black',
    'Large',
    2
),(
    4,
    'Badminton Bag D',
    'Spacious bag',
    '["img6.jpg", "img7.jpg"]',
    60.00,
    'Accessories',
    4.7,
    'Red',
    'Medium',
    2
);
INSERT INTO `ProductCart`(id, address, userId)
VALUES(1, '123 Main St', 1),(2, '456 Elm St', 2);
INSERT INTO `Has`(
    productCartId,
    productId,
    quantity
)
VALUES(1, 1, 2),(1, 3, 1),(2, 2, 1),(2, 4, 3);
INSERT INTO `review`(
    userId,
    details,
    title,
    stars,
    DATE,
    Product_id,
STATUS
)
VALUES(
    1,
    'Great product, works as expected',
    'Excellent Purchase',
    5,
    '2023-01-15 10:30:00',
    1,
    'approved'
),(
    2,
    'Good quality but a bit expensive',
    'Good but Pricey',
    4,
    '2023-02-20 14:45:00',
    2,
    'approved'
),(
    5,
    'Not what I expected, disappointed',
    'Disappointing',
    2,
    '2023-03-10 09:15:00',
    3,
    'approved'
),(
    1,
    'Amazing quality and feel',
    'Best Racket',
    5,
    '2023-04-05 16:20:00',
    1,
    'approved'
),(
    2,
    'Fits perfectly and looks great',
    'Perfect Fit',
    5,
    '2023-05-12 11:10:00',
    4,
    'approved'
);
INSERT INTO `Response`(
    firstName,
    lastName,
    email,
    content,
STATUS
)
VALUES(
    'John',
    'Doe',
    'john.doe@example.com',
    'Great service and products!',
    'read'
),(
    'Jane',
    'Smith',
    'jane.smith@example.com',
    'I love the badminton rackets here',
    'replied'
),(
    'Mike',
    'Johnson',
    'mike.johnson@example.com',
    'The shipping was very fast',
    'new'
);
INSERT INTO `Formal inf`(`id`, `name`, `description`)
VALUES(
    1,
    'Email shop',
    'info@example.com'
),(2, 'Hotline', '0123456789'),(
    3,
    'Logo',
    'https://cdn.shopvnb.com/themes/images/logo.svg'
),(
    4,
    'banner',
    'https://cdn.shopvnb.com/img/480x0/uploads/slider/1000z-launch-website-banner_1695177885.webp'
),(
    5,
    'Shipping benefit',
    'Mien phi toan quoc'
),(6, 'Refund', 'Trong vòng 8 ngày'),(7, 'Company name', 'Badminton'),(
    8,
    'Facebook',
    'https://www.facebook.com/'
),(
    9,
    'Instagram',
    'https://www.instagram.com/'
),(
    10,
    'Youtube',
    'https://www.youtube.com/'
);
INSERT INTO `faq`(
    category,
    question,
    answer,
    displayOrder
)
VALUES(
    'Mua hàng',
    'Làm thế nào để đặt hàng trên website VNB Sports?',
    'Để đặt hàng trên website VNB Sports, bạn có thể thực hiện theo các bước sau: 1. Truy cập website shopvnb.com 2. Tìm kiếm và chọn sản phẩm bạn muốn mua 3. Nhấn nút "Thêm vào giỏ hàng" 4. Kiểm tra giỏ hàng và nhấn "Thanh toán" 5. Điền thông tin giao hàng và chọn phương thức thanh toán 6. Xác nhận đơn hàng',
    1
),(
    'Sản phẩm',
    'Làm thế nào để biết sản phẩm còn hàng hay không?',
    'Trên trang chi tiết sản phẩm, bạn có thể kiểm tra tình trạng hàng như sau: Nếu sản phẩm còn hàng, bạn sẽ thấy nút "Thêm vào giỏ hàng" và thông tin về số lượng còn lại.',
    1
);
INSERT INTO `introduce`(section, content, note)
VALUES(
    "Giới thiệu",
    '<p>Bài viết được ShopVNB - Hệ thống shop cầu lông hàng đầu Việt Nam với hơn 1 Super Center, 5 shop Premium
              và 66 chi nhánh trên toàn quốc kiểm duyệt và chia sẻ.</p>

            <p>Tháng 12/2011, Forum <a href="https://www.vnbadminton.com/">https://www.vnbadminton.com/</a> được thành
              lập, đây là website cung cấp những thông tin chuyên nghiệp về tin tức và diễn đàn cầu lông. Nhận thấy sự
              phát triển của cầu lông trong nước, bên cạnh đó là mong muốn phục vụ tốt hơn cho thành viên và những bạn
              yêu mến cầu lông. Tháng 12/2012, Ban Quản Trị Vnbadminton đã mạnh dạn xây dựng Shop cầu lông VNB (<a
                href="https://shopvnb.com/">https://shopvnb.com/</a>) để có thể làm được vai trò này. Với kinh nghiệm
              nhiều năm hoạt động trong lĩnh vực cầu lông, đến với shopvnb bạn sẽ yên tâm về chất lượng sản phẩm, đội
              ngũ tư vấn sản phẩm chuyên nghiệp và giá cả hợp lý.</p>

            <p>Bên cạnh một website chuyên nghiệp thì Shop VNB còn phát triển thêm 1 kênh fanpage <a
                href="https://www.facebook.com/caulongvnbadminton/">https://www.facebook.com/caulongvnbadminton/</a>
              để cung cấp thông tin nhanh hơn cho thành viên yêu mến cầu lông. Chính sự chuyên nghiệp này đã được tạo
              được uy tín rất lớn trong cộng đồng yêu mến cầu lông trong và ngoài nước.</p>

            <p>Hiện nay, Hệ thống cửa hàng cầu lông VNB đã có hơn 50 chi nhánh trải dài trên khắp mọi miền Đất nước.
              Với tiêu chí luôn đảm bảo cung cấp đầy đủ các mặt hàng chuyên dụng dành riêng cho bộ môn cầu lông như
              giày, vợt cầu lông, túi vợt, balo, quần áo, phụ kiện,... nổi trội với nhiều phân khúc giá trải dài từ
              thấp đến cao nên các lông thủ cần mua gì cứ đến ngay với ShopVNB, chắc chắn sẽ làm các bạn vô cùng hài
              lòng.</p>

            <p>ShopVNB luôn là nơi cung cấp nhanh nhất các mặt hàng hot đến từ những thương hiệu top đầu thế giới như
              Yonex, Lining, Victor, Mizuno,... Không những vậy các sản phẩm đến từ các hãng tầm trung và giá rẻ như
              Adidas, Forza, Apacs, VNB, Kamito,... Shop cầu lông VNB cũng luôn cung cấp đầy đủ và mẫu mã rất đa dạng.
            </p>

            <p class="fw-bold">Đặc biệt, ShopVNB là địa chỉ nổi tiếng căng vợt cầu lông chuẩn nhất ở Việt Nam. Tất cả
              các cửa hàng được trang bị máy đan vợt điện tử cao cấp cùng nhân viên ở shop luôn được trau dồi liên tục
              các kĩ thuật đan vợt hàng đầu trên thế giới.</p>',
    ''
),(
    'Tầm nhìn',
    '<p class="fw-bold">"Trở thành nhà phân phối và sản xuất thể thao lớn nhất Việt Nam"</p>
          <ul>
            <li>Trở thành đơn vị dẫn đầu cả nước trong lĩnh vực thể thao, giúp nâng cao sức khỏe cộng đồng.</li>
            <li>Tự lực sản xuất các sản phẩm chất lượng cao, phù hợp với nhu cầu của người Việt.</li>
            <li>Xây dựng hệ thống cửa hàng rộng khắp 64 tỉnh thành.</li>
          </ul>',
    ''
),(
    'Sứ mệnh',
    '<p class="fw-bold">"VNB SPORTS cam kết mang đến những sản phẩm, dịch vụ chất lượng tốt nhất phục vụ cho
            người chơi thể thao để nâng cao sức khỏe của chính mình."</p>
          <ul>
            <li><strong>Đối với thị trường:</strong> Trở thành Thương hiệu cầu lông của người Việt, cung cấp những sản
              phẩm cầu lông chất lượng tốt nhất.</li>
            <li><strong>Đối với đối tác:</strong> Đề cao tinh thần hợp tác cùng phát triển; cô gắng trở thành "Người
              đồng hành số 1" của các đối tác.</li>
            <li><strong>Đối với nhân viên:</strong> Xây dựng môi trường làm việc chuyên nghiệp, năng động, sáng tạo và
              nhân văn.</li>
            <li><strong>Đối với xã hội:</strong> Hài hòa lợi ích doanh nghiệp với lợi ích xã hội; đóng góp tích cực
              vào các hoạt động hướng về cộng đồng.</li>
          </ul>',
    ''
),(
    'Giá trị cốt lõi',
    '<p class="fw-bold">TRUNG - TÍN - TÂM - TRÍ - NHÂN</p>
          <ul>
            <li><strong>TRUNG:</strong> Trung thực với Khách hàng - Đối tác - Nhân viên.</li>
            <li><strong>TÍN:</strong> VNB SPORTS đặt chữ TÍN lên hàng đầu, lấy chữ TÍN làm trọng tâm.</li>
            <li><strong>TÂM:</strong> VNB SPORTS đặt chữ TÂM là một trong những nền tảng quan trọng của việc kinh
              doanh.</li>
            <li><strong>TRÍ:</strong> VNB SPORTS luôn đề cao sự sáng tạo, là đòn bẩy phát triển.</li>
            <li><strong>NHÂN:</strong> VNB SPORTS xây dựng các mối quan hệ bằng sự thiện chí, tinh thần nhân văn.</li>
          </ul>',
    ''
),(
    'Triết lý kinh doanh',
    '<p class="text-center">VNB SPORTS mong muốn trở thành một công ty phân phối và sản xuất sản phẩm cầu lông
            chất lượng tốt nhất ở Việt Nam. Vì thế chúng tôi tâm niệm rằng chất lượng và sáng tạo là người bạn đồng
            hành của VNB SPORTS. Chúng tôi xem khách hàng là trung tâm và cam kết đáp ứng mọi nhu cầu của khách hàng.
          </p>',
    ''
),(
    'Chính sách chất lượng',
    '<p>Luôn thỏa mãn và có trách nhiệm với khách hàng bằng cách không ngừng cải tiến, đa dạng hóa sản phẩm và
            dịch vụ, đảm bảo chất lượng với giá cả cạnh tranh, tôn trọng đạo đức kinh doanh và tuân theo pháp luật.
          </p>
          <p class="fw-bold mt-3 text-center">ShopVNB cam kết bán hàng chính hãng, không bán hàng kém chất lượng làm
            ảnh hưởng đến thành viên.</p>',
    ''
),(
    'Khẩu hiệu',
    'Together we can do it!',
    ''
),(
    'CÓ THỂ BẠN SẼ THÍCH',
    'HƯỚNG DẪN MUA HÀNG',
    'https://shopvnb.com/huong-dan-mua-hang'
),(
    'CÓ THỂ BẠN SẼ THÍCH',
    'Hướng dẫn mua hàng cũ',
    'https://shopvnb.com/huong-dan-mua-hang-cu'
),(
    'CÓ THỂ BẠN SẼ THÍCH',
    'Các sản phẩm khuyến mại',
    'https://shopvnb.com/san-pham-khuyen-mai'
),(
    'CÓ THỂ BẠN SẼ THÍCH',
    'Cách thức thanh toán khi mua hàng tại ShopVNB',
    'https://shopvnb.com/cach-thanh-toan'
),(
    'CÓ THỂ BẠN SẼ THÍCH',
    'Đặt hàng online',
    'https://shopvnb.com/dat-hang-online'
),(
    'DANH MỤC TIN TỨC',
    'Thông Tin Tổng Hợp Cầu Lông',
    'https://shopvnb.com/thong-tin-tong-hop'
),(
    'DANH MỤC TIN TỨC',
    'Câu Lạc Bộ - Nhóm Cầu Lông',
    'https://shopvnb.com/cau-lac-bo-nhom'
),(
    'DANH MỤC TIN TỨC',
    'Thầy Dạy Đánh Cầu Lông',
    'https://shopvnb.com/thay-day-cau-long'
),(
    'DANH MỤC TIN TỨC',
    'Tin tức VNB Sports',
    'https://shopvnb.com/tin-tuc-vnb-sports'
),(
    'DANH MỤC TIN TỨC',
    'Chính sách',
    'https://shopvnb.com/chinh-sach'
),(
    'DANH MỤC TIN TỨC',
    'Tin Tennis',
    'https://shopvnb.com/tin-tennis'
),(
    'DANH MỤC TIN TỨC',
    'Sân Tennis',
    'https://shopvnb.com/san-tennis'
),(
    'DANH MỤC TIN TỨC',
    'Kiến thức tennis',
    'https://shopvnb.com/kien-thuc-tennis'
),(
    'DANH MỤC TIN TỨC',
    'Hiểu đúng về ghế massage',
    'https://shopvnb.com/ghe-massage'
),(
    'DANH MỤC TIN TỨC',
    'Sống khoẻ cùng VNB Sports',
    'https://shopvnb.com/song-khoe'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Yonex',
    'https://shopvnb.com/vot-cau-long-yonex'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Victor',
    'https://shopvnb.com/vot-cau-long-victor'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Lining',
    'https://shopvnb.com/vot-cau-long-lining'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Mizuno',
    'https://shopvnb.com/vot-cau-long-mizuno'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Apacs',
    'https://shopvnb.com/vot-cau-long-apacs'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông VNB',
    'https://shopvnb.com/vot-cau-long-vnb'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Proace',
    'https://shopvnb.com/vot-cau-long-proace'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Forza',
    'https://shopvnb.com/vot-cau-long-forza'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông FlyPower',
    'https://shopvnb.com/vot-cau-long-flypower'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Tenway',
    'https://shopvnb.com/vot-cau-long-tenway'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Pro Kennex',
    'https://shopvnb.com/vot-cau-long-pro-kennex'
),(
    'DANH MỤC SẢN PHẨM',
    'Vợt Cầu Lông Babolat',
    'https://shopvnb.com/vot-cau-long-babolat'
);
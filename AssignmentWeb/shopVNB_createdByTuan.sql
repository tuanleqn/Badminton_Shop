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
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
    name VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; 

-- First create product table
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `createdDate` datetime DEFAULT current_timestamp(),
  `category` varchar(50) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `branchId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branchId` (`branchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Then create product_images table
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `ProductCart`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    userId INT,
    FOREIGN KEY(userId) REFERENCES user(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `Has`(
    productCartId INT,
    productId INT,
    quantity INT DEFAULT 1,
    PRIMARY KEY(productCartId, productId)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `product_ratings` (
  `product_id` int(11) NOT NULL,
  `average_rating` float DEFAULT 0,
  `total_reviews` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `stars` int(11) DEFAULT NULL CHECK (`stars` between 1 and 5),
  `Product_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
    `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    phone VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    displayOrder INT DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;
-- Bảng introduce (lưu trữ nội dung giới thiệu)
CREATE TABLE `introduce`(
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    -- Ví dụ: 'Tầm nhìn', 'Sứ mệnh'
    content TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    note TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci; 

-- Insert user data first
INSERT INTO `user` (id, phone, address, pass, sex, name, email, numOfVisit, role) 
VALUES 
(1, '0123456789', '123 Street A', 'hashedpass123', 'M', 'John Doe', 'john@example.com', 0, 'customer'),
(2, '0987654321', '456 Street B', 'hashedpass456', 'F', 'Jane Smith', 'jane@example.com', 0, 'customer'),
(5, '0123456780', '789 Street C', 'hashedpass789', 'M', 'Admin User', 'admin@example.com', 0, 'admin');

-- Insert branch data first
INSERT INTO `branch` (id, address, userId) 
VALUES 
(1, '123 Main Branch St', 1),
(2, '456 Second Branch St', 2);

-- Then insert ProductCart data
INSERT INTO `ProductCart` (`id`, `address`, `userId`) 
VALUES 
(1, '123 Main St', 1),
(2, '456 Elm St', 2);

-- Then insert product data
INSERT INTO `product`(
    id,
    name,
    description,
    price,
    category,
    rating,
    color,
    size,
    branchId
)
VALUES
(1, 'Badminton Racket A', 'High-quality racket', 100.00, 'Sports', 4.8, 'Blue', 'Standard', 1),
(2, 'Badminton Shoes B', 'Comfortable shoes', 80.00, 'Sports', 4.5, 'White', '42', 1),
(3, 'Badminton Net C', 'Durable net', 50.00, 'Sports', 4.2, 'Black', 'Large', 2),
(4, 'Badminton Bag D', 'Spacious bag', 60.00, 'Accessories', 4.7, 'Red', 'Medium', 2);

-- Then insert product_images data
INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `image_order`) 
VALUES
(56, 1, 'uploads/681650d0a2d29-a6c766496832d86c81232.jpg', 0),
(57, 1, 'uploads/681650d0a3dda-SD_2024_Christmas.webp', 1),
(89, 2, 'uploads/681709de17f1e-0ac8d846d63d66633f2c3.jpg', 0),
(90, 2, 'uploads/681709de1dfc9-2025_Chinese_New_Year%27s_Day_Illustration.webp', 1),
(91, 3, 'uploads/6817896e03676-2024_Christmas_Illustration.webp', 0),
(92, 4, 'uploads/6817896e05cb5-2025_Chinese_New_Year%27s_Day_Illustration.webp', 0);

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
    DATE,
    stars,
    Product_id,
    status
)
VALUES(
    1,
    'Great product, works as expected',
    'Excellent Purchase',
    '2023-01-15 10:30:00',
    5,
    1,
    'approved'
),(
    2,
    'Good quality but a bit expensive',
    'Good but Pricey',
    '2023-02-20 14:45:00',
    4,
    2,
    'approved'
),(
    5,
    'Not what I expected, disappointed',
    'Disappointing',
    '2023-03-10 09:15:00',
    2,
    3,
    'approved'
),(
    1,
    'Amazing quality and feel',
    'Best Racket',
    '2023-04-05 16:20:00',
    5,
    1,
    'approved'
),(
    2,
    'Fits perfectly and looks great',
    'Perfect Fit',
    '2023-05-12 11:10:00',
    5,
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
    `name`,
    email,
    phone,
    displayOrder
)
VALUES(
    'Mua hàng',
    'Làm thế nào để đặt hàng trên website VNB Sports?',
    '<p>Để đặt hàng trên website VNB Sports, bạn có thể thực hiện theo các bước sau:</p>
<ol>
  <li>Truy cập website <a href="https://shopvnb.com">shopvnb.com</a></li>
  <li>Tìm kiếm và chọn sản phẩm bạn muốn mua</li>
  <li>Nhấn nút "Thêm vào giỏ hàng"</li>
  <li>Kiểm tra giỏ hàng và nhấn "Thanh toán"</li>
  <li>Điền thông tin giao hàng và chọn phương thức thanh toán</li>
  <li>Xác nhận đơn hàng</li>
</ol>
<p>Sau khi đặt hàng thành công, bạn sẽ nhận được email xác nhận đơn hàng và nhân viên của chúng tôi sẽ liên hệ để xác nhận lại thông tin.</p>',
    'Alice',
    'alice@example.com',
    '0123456789',
    1
),(
    'Mua hàng',
    'Tôi có thể mua hàng mà không cần đăng ký tài khoản không?',
    '<p>Có, bạn có thể mua hàng trên website VNB Sports mà không cần đăng ký tài khoản. Khi thanh toán, bạn chỉ cần điền đầy đủ thông tin giao hàng và chọn phương thức thanh toán.</p>
<p>Tuy nhiên, chúng tôi khuyên bạn nên đăng ký tài khoản để:</p>
<ul>
  <li>Theo dõi lịch sử đơn hàng dễ dàng</li>
  <li>Lưu thông tin giao hàng cho lần mua sau</li>
  <li>Nhận thông tin về chương trình khuyến mãi</li>
  <li>Tích lũy điểm thưởng và nhận ưu đãi</li>
</ul>',
    'Bob',
    'bob@example.com',
    '0987654321',
    1
),(
    'Mua hàng',
    'Làm thế nào để kiểm tra tình trạng đơn hàng của tôi?',
    '<p>Để kiểm tra tình trạng đơn hàng, bạn có thể thực hiện một trong các cách sau:</p>
<ol>
  <li><strong>Đăng nhập tài khoản:</strong> Nếu bạn đã đăng ký, hãy đăng nhập và vào mục "Đơn hàng của tôi" để xem tình trạng đơn hàng.</li>
  <li><strong>Kiểm tra email:</strong> Chúng tôi sẽ gửi email cập nhật tình trạng đơn hàng cho bạn.</li>
  <li><strong>Liên hệ hotline:</strong> Gọi số hotline 0936155994 và cung cấp mã đơn hàng để nhân viên kiểm tra giúp bạn.</li>
</ol>',
    'Carol',
    'carol@example.com',
    '0909123456',
    1
),(
    'Mua hàng',
    'Tôi có thể hủy đơn hàng sau khi đã đặt không?',
    '<p>Bạn có thể hủy đơn hàng trong vòng 24 giờ sau khi đặt hàng và trước khi đơn hàng được giao cho đơn vị vận chuyển. Để hủy đơn hàng, bạn có thể:</p>
<ul>
  <li>Đăng nhập tài khoản và chọn "Hủy đơn hàng" trong mục "Đơn hàng của tôi"</li>
  <li>Gọi hotline 0936155994 để được hỗ trợ hủy đơn hàng</li>
</ul>
<p>Lưu ý: Đối với đơn hàng đã được giao cho đơn vị vận chuyển, bạn sẽ không thể hủy đơn hàng. Trong trường hợp này, bạn có thể từ chối nhận hàng hoặc liên hệ với chúng tôi để được hướng dẫn đổi/trả hàng.</p>',
    'Dave',
    'dave@example.com',
    '0912345678',
    1
),(
    'Sản phẩm',
    'Làm thế nào để biết sản phẩm còn hàng hay không?',
    '<p>Trên trang chi tiết sản phẩm, bạn có thể kiểm tra tình trạng hàng như sau:</p>
<ul>
  <li>Nếu sản phẩm còn hàng, bạn sẽ thấy nút "Thêm vào giỏ hàng" và thông tin về số lượng còn lại.</li>
  <li>Nếu sản phẩm hết hàng, sẽ hiển thị thông báo "Hết hàng" hoặc "Tạm hết hàng".</li>
</ul>
<p>Ngoài ra, bạn có thể liên hệ trực tiếp với chúng tôi qua hotline 0936155994 để kiểm tra tình trạng hàng chính xác nhất, đặc biệt là đối với các sản phẩm hot hoặc mới ra mắt.</p>',
    'Eve',
    'eve@example.com',
    '0934567890',
    1
),(
    'Sản phẩm',
    'Làm thế nào để phân biệt hàng chính hãng và hàng giả?',
    '<p>VNB Sports cam kết chỉ bán hàng chính hãng 100%. Để phân biệt hàng chính hãng và hàng giả, bạn có thể lưu ý các điểm sau:</p>
<ol>
  <li><strong>Tem nhãn:</strong> Sản phẩm chính hãng luôn có tem nhãn rõ ràng, in sắc nét và có mã QR hoặc mã vạch để kiểm tra.</li>
  <li><strong>Chất lượng:</strong> Sản phẩm chính hãng có chất lượng hoàn thiện cao, không có lỗi trong quá trình sản xuất.</li>
  <li><strong>Giá cả:</strong> Hàng chính hãng thường có giá cả phù hợp với thị trường, không quá rẻ so với mặt bằng chung.</li>
  <li><strong>Bao bì:</strong> Hàng chính hãng có bao bì đẹp, chắc chắn, thông tin đầy đủ và rõ ràng.</li>
</ol>
<p>Khi mua hàng tại VNB Sports, bạn sẽ nhận được hóa đơn và phiếu bảo hành chính hãng (nếu có), đảm bảo quyền lợi của bạn.</p>',
    'Frank',
    'frank@example.com',
    '0945678901',
    1
),(
    'Sản phẩm',
    'Làm thế nào để chọn vợt cầu lông phù hợp?',
    '<p>Để chọn vợt cầu lông phù hợp, bạn nên xem xét các yếu tố sau:</p>
<ol>
  <li><strong>Trình độ chơi:</strong> Người mới chơi nên chọn vợt nhẹ, cân bằng. Người chơi trung cấp và cao cấp có thể chọn vợt theo phong cách chơi.</li>
  <li><strong>Trọng lượng vợt:</strong> Vợt nhẹ (80-84g) dễ điều khiển, vợt nặng (85-89g) tạo lực đánh mạnh hơn.</li>
  <li><strong>Cân bằng vợt:</strong> Cân bằng đầu nhẹ giúp phòng thủ tốt, cân bằng đầu nặng tăng sức mạnh tấn công.</li>
  <li><strong>Độ cứng của thân vợt:</strong> Thân mềm giúp tạo lực tốt cho người mới, thân cứng phù hợp với người có kỹ thuật và sức mạnh.</li>
</ol>
<p>Bạn có thể đến trực tiếp cửa hàng VNB Sports để được tư vấn và test vợt trước khi mua. Nhân viên của chúng tôi sẽ giúp bạn chọn vợt phù hợp nhất với trình độ và phong cách chơi của bạn.</p>',
    'Grace',
    'grace@example.com',
    '0956789012',
    1
),(
    'Bảo hành',
    'Chính sách bảo hành của VNB Sports như thế nào?',
    '<p>VNB Sports áp dụng chính sách bảo hành theo quy định của nhà sản xuất:</p>
<ul>
  <li><strong>Vợt cầu lông:</strong> Bảo hành 6-12 tháng tùy thương hiệu, chỉ áp dụng cho lỗi sản xuất (nứt, gãy khung vợt trong điều kiện sử dụng bình thường).</li>
  <li><strong>Giày cầu lông:</strong> Bảo hành 1-3 tháng tùy thương hiệu, chỉ áp dụng cho lỗi sản xuất như bong đế, rách đường chỉ may.</li>
  <li><strong>Phụ kiện:</strong> Bảo hành 1 tháng cho lỗi sản xuất.</li>
</ul>
<p>Lưu ý: Bảo hành không áp dụng cho các trường hợp hư hỏng do sử dụng không đúng cách, va đập mạnh, hoặc tự ý sửa chữa. Để được bảo hành, bạn cần giữ hóa đơn và phiếu bảo hành.</p>',
    'Henry',
    'henry@example.com',
    '0967890123',
    1
),(
    'Bảo hành',
    'Làm thế nào để yêu cầu bảo hành sản phẩm?',
    '<p>Để yêu cầu bảo hành sản phẩm, bạn có thể thực hiện theo các bước sau:</p>
<ol>
  <li>Mang sản phẩm cần bảo hành đến bất kỳ cửa hàng VNB Sports nào trên toàn quốc.</li>
  <li>Xuất trình hóa đơn mua hàng và phiếu bảo hành (nếu có).</li>
  <li>Nhân viên của chúng tôi sẽ kiểm tra sản phẩm và xác định lỗi.</li>
  <li>Nếu sản phẩm đủ điều kiện bảo hành, chúng tôi sẽ tiến hành sửa chữa hoặc đổi mới sản phẩm theo chính sách của từng thương hiệu.</li>
</ol>
<p>Thời gian bảo hành thông thường từ 7-15 ngày tùy thuộc vào tình trạng sản phẩm và chính sách của nhà sản xuất. Trong trường hợp cần thời gian lâu hơn, chúng tôi sẽ thông báo cụ thể cho bạn.</p>',
    'Irene',
    'irene@example.com',
    '0978901234',
    1
),(
    'Vận chuyển',
    'Phí vận chuyển được tính như thế nào?',
    '<p>Phí vận chuyển được tính dựa trên các yếu tố sau:</p>
<ul>
  <li><strong>Khoảng cách:</strong> Phí vận chuyển sẽ khác nhau tùy thuộc vào khoảng cách từ kho hàng đến địa chỉ giao hàng.</li>
  <li><strong>Trọng lượng và kích thước:</strong> Sản phẩm càng nặng và kích thước càng lớn, phí vận chuyển càng cao.</li>
  <li><strong>Đơn vị vận chuyển:</strong> Mỗi đơn vị vận chuyển có mức phí khác nhau.</li>
</ul>
<p>Cụ thể:</p>
<ul>
  <li>Nội thành Hà Nội và TP.HCM: 20.000đ - 30.000đ</li>
  <li>Các tỉnh thành khác: 30.000đ - 50.000đ</li>
</ul>
<p>Đặc biệt, VNB Sports áp dụng chính sách miễn phí vận chuyển cho đơn hàng từ 500.000đ (nội thành) và từ 1.000.000đ (toàn quốc).</p>',
    'John',
    'john@example.com',
    '0989012345',
    1
),(
    'Vận chuyển',
    'Thời gian giao hàng là bao lâu?',
    '<p>Thời gian giao hàng phụ thuộc vào khu vực giao hàng:</p>
<ul>
  <li><strong>Nội thành Hà Nội và TP.HCM:</strong> 1-2 ngày làm việc</li>
  <li><strong>Các tỉnh thành miền Bắc và miền Nam:</strong> 2-3 ngày làm việc</li>
  <li><strong>Các tỉnh miền Trung và Tây Nguyên:</strong> 3-5 ngày làm việc</li>
  <li><strong>Khu vực hải đảo và vùng sâu vùng xa:</strong> 5-7 ngày làm việc</li>
</ul>
<p>Lưu ý: Thời gian giao hàng có thể bị ảnh hưởng bởi các yếu tố như thời tiết, giao thông, dịch bệnh, v.v. Trong trường hợp này, chúng tôi sẽ thông báo cho bạn về sự chậm trễ và thời gian giao hàng dự kiến mới.</p>',
    'Karen',
    'karen@example.com',
    '0990123456',
    1
),(
    'Đổi trả',
    'Chính sách đổi trả của VNB Sports như thế nào?',
    '<p>VNB Sports áp dụng chính sách đổi trả như sau:</p>
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
<p>Lưu ý: Đối với vợt cầu lông đã được căng dây, chúng tôi không áp dụng chính sách đổi trả trừ khi sản phẩm bị lỗi do nhà sản xuất.</p>',
    'Leo',
    'leo@example.com',
    '0911123456',
    1
),(
    'Đổi trả',
    'Làm thế nào để đổi hoặc trả sản phẩm?',
    '<p>Để đổi hoặc trả sản phẩm, bạn có thể thực hiện theo các bước sau:</p>
<ol>
  <li><strong>Liên hệ với chúng tôi:</strong> Gọi hotline 0936155994 hoặc gửi email đến info@shopvnb.com để thông báo về việc đổi/trả sản phẩm.</li>
  <li><strong>Cung cấp thông tin:</strong> Mã đơn hàng, tên sản phẩm, lý do đổi/trả.</li>
  <li><strong>Nhận hướng dẫn:</strong> Nhân viên của chúng tôi sẽ hướng dẫn bạn cách thức đổi/trả sản phẩm.</li>
  <li><strong>Gửi sản phẩm:</strong> Đóng gói sản phẩm cẩn thận và gửi về địa chỉ được cung cấp, kèm theo hóa đơn và phiếu đổi/trả.</li>
</ol>
<p>Sau khi nhận được sản phẩm và kiểm tra, chúng tôi sẽ tiến hành đổi sản phẩm mới hoặc hoàn tiền cho bạn trong vòng 7 ngày làm việc.</p>',
    'Mia',
    'mia@example.com',
    '0922234567',
    1
),(
    'Thanh toán',
    'VNB Sports chấp nhận những phương thức thanh toán nào?',
    '<p>VNB Sports chấp nhận các phương thức thanh toán sau:</p>
<ul>
  <li><strong>Thanh toán khi nhận hàng (COD):</strong> Bạn thanh toán trực tiếp cho nhân viên giao hàng khi nhận sản phẩm.</li>
  <li><strong>Chuyển khoản ngân hàng:</strong> Chuyển tiền vào tài khoản ngân hàng của VNB Sports.</li>
  <li><strong>Thanh toán qua thẻ tín dụng/ghi nợ:</strong> Thanh toán trực tuyến qua cổng thanh toán an toàn.</li>
  <li><strong>Ví điện tử:</strong> Thanh toán qua Momo, ZaloPay, VNPay, v.v.</li>
  <li><strong>Trả góp:</strong> Áp dụng cho đơn hàng từ 3.000.000đ trở lên, hợp tác với các ngân hàng và công ty tài chính.</li>
</ul>',
    'Nina',
    'nina@example.com',
    '0933345678',
    1
),(
    'Thanh toán',
    'Thanh toán trực tuyến có an toàn không?',
    '<p>Có, thanh toán trực tuyến tại VNB Sports hoàn toàn an toàn. Chúng tôi áp dụng các biện pháp bảo mật cao nhất để bảo vệ thông tin thanh toán của bạn:</p>
<ul>
  <li>Sử dụng công nghệ mã hóa SSL 256-bit để bảo vệ thông tin cá nhân và thông tin thanh toán.</li>
  <li>Hợp tác với các cổng thanh toán uy tín và được cấp phép như VNPAY, OnePay, v.v.</li>
  <li>Tuân thủ các tiêu chuẩn bảo mật quốc tế PCI DSS.</li>
  <li>Không lưu trữ thông tin thẻ tín dụng của khách hàng.</li>
</ul>
<p>Nếu bạn vẫn lo ngại về vấn đề bảo mật, bạn có thể chọn phương thức thanh toán khi nhận hàng (COD) hoặc chuyển khoản ngân hàng.</p>',
    'Oscar',
    'oscar@example.com',
    '0944456789',
    1
),(
    'Tài khoản',
    'Làm thế nào để đăng ký tài khoản trên website VNB Sports?',
    '<p>Để đăng ký tài khoản trên website VNB Sports, bạn có thể thực hiện theo các bước sau:</p>
<ol>
  <li>Truy cập website <a href="https://shopvnb.com">shopvnb.com</a></li>
  <li>Nhấn vào nút "Đăng ký" ở góc trên bên phải màn hình</li>
  <li>Điền đầy đủ thông tin cá nhân: họ tên, email, số điện thoại, mật khẩu</li>
  <li>Nhấn nút "Đăng ký" để hoàn tất</li>
</ol>
<p>Sau khi đăng ký thành công, bạn sẽ nhận được email xác nhận. Hãy nhấn vào liên kết trong email để kích hoạt tài khoản của bạn.</p>',
    'Paul',
    'paul@example.com',
    '0955567890',
    1
),(
    'Tài khoản',
    'Tôi quên mật khẩu, làm thế nào để lấy lại?',
    '<p>Nếu bạn quên mật khẩu, bạn có thể thực hiện các bước sau để lấy lại:</p>
<ol>
  <li>Truy cập trang đăng nhập của VNB Sports</li>
  <li>Nhấn vào liên kết "Quên mật khẩu"</li>
  <li>Nhập địa chỉ email đã đăng ký tài khoản</li>
  <li>Nhấn nút "Gửi yêu cầu"</li>
  <li>Kiểm tra email và làm theo hướng dẫn để đặt lại mật khẩu</li>
</ol>
<p>Lưu ý: Liên kết đặt lại mật khẩu chỉ có hiệu lực trong vòng 24 giờ. Nếu bạn không nhận được email, hãy kiểm tra thư mục spam hoặc liên hệ với chúng tôi để được hỗ trợ.</p>',
    'Queenie',
    'queenie@example.com',
    '0966678901',
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
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `product`
--

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`branchId`) REFERENCES `branch` (`id`);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;


ALTER TABLE `review`
  ADD KEY `userId` (`userId`),
  ADD KEY `review_ibfk_2` (`Product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `review`
--

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;


  --
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`product_id`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;



-- Add foreign key constraints after all data insertions
ALTER TABLE `Has`
    ADD CONSTRAINT `fk_has_productcart` 
    FOREIGN KEY(productCartId) REFERENCES ProductCart(id) 
    ON DELETE CASCADE;

ALTER TABLE `Has`
    ADD CONSTRAINT `fk_has_product` 
    FOREIGN KEY(productId) REFERENCES product(id) 
    ON DELETE CASCADE;
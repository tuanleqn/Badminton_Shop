<?php
require 'config.php'; // file chứa kết nối PDO

$sql = "SELECT * FROM bang_tin_tuc";
$stmt = $pdo->query($sql);

// Hiển thị dữ liệu
// $tieude=[];
// $noidung=[];
// $link_anh=[];
// while ($row_ = $stmt->fetch()) {
//     echo "ID: " . $row_['ID_tin'] . "<br>";

//     echo "Tên: " . $row_['Ngay_viet'] . "<br>";
//     echo "Email: " . $row_['Noi_dung_tin'] . "<hr>";
//     $tieude[]=$row_['Title'];
//     $noidung[]=$row_['Noi_dung_tin'];
//     $link_anh[]=$row_['Link_anh'];
// }
// echo $tieude[0];
// Thiết lập phân trang
$itemsPerPage = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Lấy tổng số bài viết
if (isset($_GET['tu_khoa']) && !empty(trim($_GET['tu_khoa']))) {
    $tu_khoa = trim($_GET['tu_khoa']);
    $stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM bang_tin_tuc WHERE Noi_dung_tin LIKE :tu_khoa");
    $stmtTotal->bindValue(':tu_khoa', "%$tu_khoa%", PDO::PARAM_STR);
    $stmtTotal->execute();
} else {
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM bang_tin_tuc");
}

$totalItems = $stmtTotal->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

// Lấy bài viết theo trang
if (isset($_GET['tu_khoa']) && !empty(trim($_GET['tu_khoa']))) {
    $tu_khoa = trim($_GET['tu_khoa']);
    $stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc WHERE Noi_dung_tin LIKE :tu_khoa ORDER BY Ngay_viet DESC LIMIT :offset, :limit");
    $stmt->bindValue(':tu_khoa', "%$tu_khoa%", PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc ORDER BY Ngay_viet DESC LIMIT :offset, :limit");
}

// Gắn giá trị phân trang
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);

// Thực thi truy vấn
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang tin tức</title>
    <link rel="stylesheet" href="./CSS/stylenews.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<?php
require_once __DIR__ . '/../../core/App.php';
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helper/URL.php'; 
require_once __DIR__ . '/../../helper/config.php';
require_once __DIR__ . '/../../helper/session.php'; 
require_once dirname(__DIR__) . '/header_footer/header.php'; ?>
<div class="container_">
    
    <div class="row_"> <!-- khung chua conten phai va trai -->
        <div class="left-content "> <!--container cua khung trai-->
            <h1 class="title-page">Thông Tin Tổng Hợp Cầu Lông</h1>
            <form action="#" method="get" class="search-container"> <!--  thanh tìm kiếm -->
                <div class="input-group1 input-group">
                    <div class="search-tt"><label for="search-tt"><strong>Từ Khóa</strong></label></div>
                    <div><input type="text" id="search-tt" name="sr-holder" value="" class="search-tt-ip"></div>
                    <div class="search-tt-bt" ><button  type="submit"> Tìm kiếm</button></div>
                </div>
            </form>
            <div class="container-tt row_" id="results">
                <?php foreach ($posts as $post): ?>
                    <div class="col-tt">
                        <div class="box-tt"><!--box chu anh va if anh-->
                            <div class="img-tt">
                                <a href="<?php echo URL::to('public/News_site/chitiettin'); ?>?ID_tin=<?php echo $post['ID_tin'] ?>"><img src="<?php echo URL::to('app/views/news_site'); ?>/<?php echo $post['Link_anh'] ?>" alt=""></a>
                            </div>
                            <div class="content-tt"  >
                                <h3><?php echo$post['Title']?></h3>
                                <!-- <div class="date-tt"> -->
                                    <p class="date-line"><span><?php echo$post['Ngay_viet']?></span></p>
                                <!-- </div> -->
                                <div class="noidung"> <?php echo$post['Noi_dung_tin']?></div>
                                </div>
                        </div>
                    </div>  
                <?php endforeach; ?>
            </div>
            <div id="pagination-bar">
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-primary1" href="?page=1"><<</a>
                        <a class="btn btn-primary1" href="?page=<?= $page - 1 ?>"><</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 1); $i <= min($totalPages, $page + 1); $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="btn btn-primary1 active" style="color:white; background-color:#0d6efd!important;  "><?= $i ?></span>
                        <?php else: ?>
                            <a class="btn btn-primary1" href="?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-primary1" href="?page=<?= $page + 1 ?>">></a>
                        <a class="btn btn-primary1" href="?page=<?= $totalPages ?>">>></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="right-content">
            <div class="right-tt">
                <div class="titlehead">Danh mục tin tức</div>
                <nav class="nav-category">
                <ul class="nav-pills">
                  <li class="nav-item relative">
                    <a
                      title="Thông Tin Tổng Hợp Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Thông Tin Tổng Hợp Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Câu Lạc Bộ - Nhóm Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Câu Lạc Bộ - Nhóm Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Thầy Dạy Đánh Cầu Lông"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Thầy Dạy Đánh Cầu Lông</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Tin tức VNB Sports"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Tin tức VNB Sports</a
                    >
                  </li>
                  <li class="nav-item relative">
                    <a
                      title="Chính sách"
                      class="nav-link"
                      href="tin-tuc.html"
                      >Chính sách</a
                    >
                  </li>
                </ul>
              </nav>
            </div>
        </div>
    </div>
    
</div>

<?php require_once dirname(__DIR__) . '/header_footer/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- <?php foreach ($items as $item): ?>
        <div class="box">
            <img src="<?= $item['image_url'] ?>" alt="Ảnh">
            <p><?= $item['text'] ?></p>
            <button onclick="selectItem('<?= $item['text'] ?>')">Chọn</button>
        </div>
    <?php endforeach; ?>  -->
<!-- <?php
// Kết nối đến MySQL
$conn = new mysqli("localhost", "root", "", "mydatabase");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ bảng items
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

$items = [];
if ($result->num_rows > 0) {
    while ($row_ = $result->fetch_assoc()) {
        $items[] = $row_;
    }
}

$conn->close();
?>  -->
<?php
require_once __DIR__ . '/../../core/App.php';
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helper/URL.php'; 
require_once __DIR__ . '/../../helper/config.php';
require_once __DIR__ . '/../../helper/session.php'; 
require_once dirname(__DIR__) . '/header_footer/header.php'; 
// Cấu hình kết nối
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Nhận dữ liệu từ form
$tieude = $_POST['tieude'] ?? '';
$content = $_POST['content'] ?? '';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$ngay_viet = date("Y-m-d H:i:s");


do {
    $id_tin = rand(100000, 999999);
    $stmt_check = $pdo->prepare("SELECT ID_tin FROM bang_tin_tuc WHERE ID_tin = ?");
    $stmt_check->execute([$id_tin]);
} while ($stmt_check->rowCount() > 0);
// Kiểm tra file ảnh
if (isset($_FILES['file-anh']) && $_FILES['file-anh']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Shop-badminton/AssignmentWeb/app/views/news_site/image/";
    $file_tmp = $_FILES['file-anh']['tmp_name'];
    $file_name = pathinfo($_FILES['file-anh']['name'], PATHINFO_FILENAME);
    $file_ext = strtolower(pathinfo($_FILES['file-anh']['name'], PATHINFO_EXTENSION));

    // Tạo tên mới cho file
    $random_suffix = rand(100000, 999999);
    $new_file_name = $file_name . "_" . $random_suffix . "." . $file_ext;
    $target_path = $upload_dir . $new_file_name;
    $link_anh="imange/". $new_file_name;

    // Di chuyển file ảnh vào thư mục image
    if (move_uploaded_file($file_tmp, $target_path)) {
        // Chèn thủ công cả ID_tin
        $sql = "INSERT INTO bang_tin_tuc (ID_tin, Title, Noi_dung_tin, Ngay_viet, Link_anh) 
                VALUES (:idtin, :tieude, :content, :ngayviet, :linkanh)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idtin'    => $id_tin,
            ':tieude'   => $tieude,
            ':content'  => $content,
            ':ngayviet' => $ngay_viet,
            ':linkanh'  => $link_anh
        ]);

        header("Location:  admintintuc");
        exit;
    } else {
        echo "Không thể upload ảnh.";
    }
} else {
    echo "Vui lòng chọn một file ảnh hợp lệ.";
    
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.tiny.cloud/1/9xs7pkcxy1z19cmeqee2123vpe1qo9t9pwmvlk6tz0iqescp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: '#mytextarea'
    });
    </script>

</head>
<body>

<div class="container">
    <div>
        <h1 style="text-align:center">TẠO BÀI VIẾT MỚI</h1>
    </div>
    <form  method="post" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="tieude" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="tieude" name="tieude" required>
        </div>
        <div class="mb-3">
            <label for="link-anh" class="form-label">File ảnh tiêu đề (.jpg)</label>
            <input type="file" class="form-control" id="link-anh" name="file-anh" accept=".jpg" required>
        </div>
        <div class="mb-3">
            <label for="mytextarea" class="form-label">Nội dung</label>
            <textarea class="form-control" name="content" id="mytextarea" ></textarea>
        </div>
        <button type="submit" name="send" class="btn btn-primary">Gửi lên</button>
    </form>
</div>
</body>
<?php if (isset($_GET['success'])): ?>
  <script>
    alert("Tạo bài thành công");
  </script>
<?php endif; ?>
</html>
<?php
require 'config.php';
require 'config.php';
require_once __DIR__ . '/../../core/App.php';
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../helper/URL.php'; 
require_once __DIR__ . '/../../helper/config.php';
require_once __DIR__ . '/../../helper/session.php'; 
require_once dirname(__DIR__) . '/header_footer/header.php'; 
// Lấy ID_tin từ URL
$id_tin = $_GET['ID_tin'] ?? null;
if (!$id_tin) {
    die("Thiếu ID_tin.");
}

// Nếu form được submit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieude = $_POST['tieude'] ?? '';
    $content = $_POST['content'] ?? '';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $ngay_viet = date("Y-m-d H:i:s");
    $anh_cu = $_POST['anh_cu'] ?? null;
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Shop-badminton/AssignmentWeb/app/views/news_site/image/";
    $link_anh_moi = $anh_cu;

    // Nếu có upload ảnh mới
    if (isset($_FILES['file-anh']) && $_FILES['file-anh']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file-anh']['tmp_name'];
        $file_name = pathinfo($_FILES['file-anh']['name'], PATHINFO_FILENAME);
        $file_ext = strtolower(pathinfo($_FILES['file-anh']['name'], PATHINFO_EXTENSION));
        $random_suffix = rand(100000, 999999);
        $new_file_name = $file_name . "_" . $random_suffix . "." . $file_ext;
        $target_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            // Xóa ảnh cũ nếu tồn tại
            if ($anh_cu && file_exists($anh_cu)) {
                unlink($anh_cu);
            }
            $link_anh_moi = "imange/". $new_file_name;
        } else {
            echo "Không thể upload ảnh mới. Ảnh cũ vẫn giữ nguyên.<br>";
        }
    }

    // Cập nhật bài viết
    $sql = "UPDATE bang_tin_tuc 
            SET Title = :tieude, Noi_dung_tin = :content, Ngay_viet = :ngayviet, Link_anh = :linkanh
            WHERE ID_tin = :idtin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tieude'   => $tieude,
        ':content'  => $content,
        ':ngayviet' => $ngay_viet,
        ':linkanh'  => $link_anh_moi,
        ':idtin'    => $id_tin
    ]);
    header("Location:  admintintuc");
        exit;
    echo "<p style='color: green;'>Đã cập nhật bài viết thành công!</p>";
}

// Lấy dữ liệu cũ để hiển thị form
$stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc WHERE ID_tin = :id");
$stmt->execute([':id' => $id_tin]);
$tin = $stmt->fetch();

if (!$tin) {
    die("Không tìm thấy bài viết.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tiny.cloud/1/9xs7pkcxy1z19cmeqee2123vpe1qo9t9pwmvlk6tz0iqescp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div>
        <h1 style="text-align:center">CHỈNH SỬA BÀI VIẾT</h1>
    </div>
    <form method="post" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="tieude" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="tieude" name="tieude" value="<?php echo$tin['Title']?>" required>
        </div>
        <div class="mb-3">
          <label for="anh-cu" class="form-label">Ảnh hiện tại:</label><br>
          <img src="<?php echo URL::to('app/views/news_site'); ?>/<?= htmlspecialchars($tin['Link_anh']) ?>" width="200"><br>
          <input type="hidden" name="anh_cu" value="<?= htmlspecialchars($tin['Link_anh']) ?>"><br>
        </div>
        <div class="mb-3">
            <label for="link-anh" class="form-label">File ảnh tiêu đề (.jpg)</label>
            <input type="file" class="form-control" id="link-anh" name="file-anh" accept=".jpg" >
        </div>
        <div class="mb-3">
            <label for="mytextarea" class="form-label">Nội dung</label>
            <textarea class="form-control" name="content" id="mytextarea" ><?php echo$tin['Noi_dung_tin']?></textarea>
        </div>
        <button type="submit" name="send" class="btn btn-primary">Chỉnh sửa</button>
    </form>
</div>
</body>
</html>
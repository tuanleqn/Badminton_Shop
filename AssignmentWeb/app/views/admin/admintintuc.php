<?php
require 'config.php'; // file chứa kết nối PDO

$sql = "SELECT * FROM bang_tin_tuc";
$stmt = $pdo->query($sql);

$itemsPerPage = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Lấy tổng số bài viết
$stmtTotal = $pdo->query("SELECT COUNT(*) FROM bang_tin_tuc");
$totalItems = $stmtTotal->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

// Lấy bài viết theo trang
$stmt = $pdo->prepare("SELECT * FROM bang_tin_tuc ORDER BY Ngay_viet DESC LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/news_site/CSS/stylenews.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/news_site/CSS/appnews.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body style="background-color:#f2f6ff">
<?php require_once dirname(__DIR__) . '/admin/components/sidebar.php'; ?>
<div style="margin: 50px 20px 50px 350px; border:none; background-color:transparent" class="card">
            <div style="margin-bottom:20px" class="card-header">
                <h4 class="card-title">Các bài viết đã đăng</h4>
            </div>
            <div style="margin-left:20px" class="mb-3">
                <form class="d-flex">
                    <label style="margin:auto 10px" for="search-box" class="form-label">Tìm bài viết: </label>
                    <input style="width:60%"id="search-box" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
            </div>
            <div style="margin:24px" class="create-btn">
                <button type="button" class="btn btn-success">
                    <a style="color:white; text-decoration:none" href="<?php echo URL::to('public/admin/taonoidung'); ?>"><i class="bi bi-plus-square"></i> Tạo bài viết mới</a>
                </button>
            </div>
            <div class="card-body">
                <?php foreach ($posts as $post): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <div class="pr-50">
                                <div class="avatar avatar-2xl" style="width: 120px; heigh: 120px;">
                                    <img style="border-radius: 0%;" src="<?php echo URL::to('app/views/news_site'); ?>/<?php echo $post['Link_anh'] ?>" alt="Avatar">    
                                </div>
                            </div>
                            <div class="comment-body">
                                <div class="comment-profileName"><Strong>Tiêu đề: <?php echo $post['Title'] ?></Strong></div>
                                <div class="comment-time">Thời gian: <?php echo $post['Ngay_viet'] ?></div>
                                <div class="comment-message">
                                    <p class="list-group-item-text truncate mb-20">Người Viết: <?php echo $post['Nguoi_viet'] ?></p>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn icon icon-left btn-primary me-2 text-nowrap"><a style="color:white; text-decoration:none" href="<?php echo URL::to('public/News_site/chitiettin'); ?>?ID_tin=<?php echo $post['ID_tin']?>"><i class="bi bi-eye-fill"></i> Show</a></button>
                                    <button class="btn icon icon-left btn-warning me-2 text-nowrap"><a style="color:black; text-decoration:none" href="<?php echo URL::to('public/admin/edit_tin_tuc'); ?>?ID_tin=<?php echo $post['ID_tin']?>"><i class="bi bi-pencil-square"></i> Edit</a></button>
                                    <button class="btn icon icon-left btn-danger me-2 text-nowrap"><a  onclick="return confirm('Xác nhận xoá?');" style="color:black; text-decoration:none" href="<?php echo URL::to('public/admin/xoanoidung'); ?>?ID_tin=<?php echo $post['ID_tin']?>"><i class="bi bi-x-circle"></i> Remove</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            </div>
            <div style="padding:20px" id="pagination-bar">
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-primary" href="?page=1"><<</a>
                        <a class="btn btn-primary" href="?page=<?= $page - 1 ?>"><</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 1); $i <= min($totalPages, $page + 1); $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="btn btn-primary active" style="color:white; background-color:#0d6efd;  "><?= $i ?></span>
                        <?php else: ?>
                            <a class="btn btn-primary" href="?page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-primary" href="?page=<?= $page + 1 ?>">></a>
                        <a class="btn btn-primary" href="?page=<?= $totalPages ?>">>></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
</body>
</html>
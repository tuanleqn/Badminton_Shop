<?php
require 'config.php'; // file chứa kết nối PDO

$id = $_GET['ID_cmt'];

// Modified query to join with user table for replies
$sql = "SELECT b.*, u.name as user_name 
        FROM bang_cmt b 
        LEFT JOIN user u ON b.ID_user = u.id 
        WHERE b.reply_to = :id 
        ORDER BY b.time_cmt DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$itemsPerPage = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Lấy tổng số bài viết
$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM bang_cmt WHERE reply_to = ?");
$stmtTotal->execute([$_GET['ID_cmt']]);
$totalItems = $stmtTotal->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

// Lấy bài viết theo trang
$stmt = $pdo->prepare("SELECT * FROM bang_cmt WHERE reply_to = :idcmt ORDER BY time_cmt DESC LIMIT :offset, :limit");

$stmt->bindValue(':idcmt', $_GET['ID_cmt'], PDO::PARAM_INT); // Gán giá trị cho điều kiện ID_cmt
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);

$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);



//
//Đoạn này lấy id_cmt cho cmt cũ
//
if (isset($_GET['ID_cmt'])) {
    $id_cmt = $_GET['ID_cmt'];

    // Truy vấn dữ liệu
    $stmt2 = $pdo->prepare("SELECT b.*, u.name as user_name 
                           FROM bang_cmt b 
                           LEFT JOIN user u ON b.ID_user = u.id 
                           WHERE b.ID_cmt = ?");
    $stmt2->execute([$id_cmt]);

    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Không tìm thấy bình luận.";
        exit;
    }
} else {
    echo "Thiếu tham số ID_cmt.";
    exit;
}
//
//
//
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
            <div class="card-header">
                <h4 class="card-title">Bình luận</h4>
            </div>

            <div class="card-body">
                    <div class="comment">
                        <div class="comment-header">
                            <div class="pr-50">
                                <div class="avatar avatar-2xl" style="width: 120px; heigh: 120px;">
                                    <img style="background-color:lightblue" src="" alt="Avatar">    
                                </div>
                            </div>
                            <div class="comment-body">
                                <div class="comment-profileName"><Strong>Tên người viết: <?php echo $row['user_name'] ?></Strong></div>
                                <div class="comment-time">Thời gian: <?php echo $row['time_cmt'] ?></div>
                                <div class="comment-message">
                                    <p class="list-group-item-text truncate mb-20">Nội dung: <?php echo $row['noi_dung_cmt'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                
                        <h4 class="card-title">Dưới đây là các phản hồi bình luận của bình luận trên:</h4>
                    </div>
                    <?php
                        if (count($replies) === 0) {
                            echo '<div style="color:red" class="card-header">
                                    <h4 class="card-title">Không có phản hồi nào cho bình luận trên!</h4>
                                </div>';
                        }
                    ?>
                    <div class="card-header">
                    <button class="btn icon icon-left btn-primary me-2 text-nowrap"><a style="color:white; text-decoration:none" href="<?php echo URL::to('public/admin/admin_comments'); ?>"><i class="bi bi-arrow-left-square-fill"></i> Back</a></button>
                    </div>
                <?php foreach ($replies as $reply): ?>
                    <div class="comment" style="margin-left:50px">
                        <div class="comment-header">
                            <div class="pr-50">
                                <div class="avatar avatar-2xl" style="width: 120px; heigh: 120px;">
                                    <img style="background-color:lightblue" src="" alt="Avatar">    
                                </div>
                            </div>
                            <div class="comment-body">
                                <div class="comment-profileName"><Strong>Tên người viết: <?php echo $reply['user_name'] ?></Strong></div>
                                <div class="comment-time">Thời gian: <?php echo $reply['time_cmt'] ?></div>
                                <div class="comment-message">
                                    <p class="list-group-item-text truncate mb-20">Nội dung: <?php echo $reply['noi_dung_cmt'] ?></p>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn icon icon-left btn-primary me-2 text-nowrap"><a style="color:white; text-decoration:none" href="<?php echo URL::to('public/News_site/chitiettin'); ?>?ID_tin=<?php echo $row['ID_tin']?>#reply-cmt<?php echo $reply['ID_cmt']?>"><i class="bi bi-eye-fill"></i> Show</a></button>
                                    <button id="edit-bt<?php echo $reply['ID_cmt']?>" class="btn icon icon-left btn-warning me-2 text-nowrap" data-oldcmt="<?php echo $reply['noi_dung_cmt']?>" data-idcmt="<?php echo $reply['ID_cmt']?>"><a style="color:black; text-decoration:none"><i class="bi bi-pencil-square"></i> Edit</a></button>
                                    <button class="btn icon icon-left btn-danger me-2 text-nowrap"><a onclick="return confirm('Xác nhận xoá?');" style="color:black; text-decoration:none" href="<?php echo URL::to('public/admin/xoa_reply'); ?>?ID_reply=<?php echo $reply['ID_cmt']?>"><i class="bi bi-x-circle"></i> Remove</a></button>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('edit-bt<?php echo $reply['ID_cmt']?>').addEventListener('click', function () {
                            const idcmt = this.dataset.idcmt;
                            const oldcmt = this.dataset.oldcmt;

                            const overlay = document.createElement('div');
                            overlay.id = 'overlay';
                            overlay.style.cssText = `
                                position: fixed;
                                top: 0; left: 0;
                                width: 100vw;
                                height: 100vh;
                                background: rgba(0,0,0,0.5);
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                z-index: 999;
                            `;

                            const formBox = document.createElement('div');
                            formBox.className = 'form-popup shadow-lg p-3 mb-5 bg-body rounded';
                            formBox.style.cssText = `
                                background: white;
                                padding: 20px;
                                border-radius: 10px;
                                max-width: 600px;
                                width: 90%;
                            `;

                            formBox.innerHTML = `
                                <form action="<?php echo URL::to('public/admin/edit_reply'); ?>?ID_cmt=${idcmt}" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Bình luận cũ</label>
                                    <textarea class="form-control" rows="3" disabled>${oldcmt}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Chỉnh sửa</label>
                                    <textarea class="form-control" name="cmt_edited" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning me-2 text-nowrap">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-secondary" id="closeBtn">Đóng</button>
                                </form>
                            `;

                            overlay.appendChild(formBox);
                            document.body.appendChild(overlay);

                            document.getElementById('closeBtn').addEventListener('click', () => overlay.remove());
                            });

                        </script>
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
    <div>
    
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
</body>
</html>

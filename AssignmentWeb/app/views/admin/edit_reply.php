<?php
require_once 'config.php'; // file chứa kết nối PDO
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra nếu có ID_cmt và cmt_edited từ GET và POST
if (isset($_GET['ID_cmt']) && isset($_POST['cmt_edited'])) {
    $id_reply = $_GET['ID_cmt'];
    $noi_dung_moi = $_POST['cmt_edited'];
    $thoigian_sua = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại

    // SQL query để cập nhật nội dung và giờ sửa trong bảng comment
    $sql = "UPDATE bang_cmt SET Noi_dung_cmt = ?, time_cmt = ? WHERE ID_cmt = ?";

    // Chuẩn bị và thực thi câu lệnh
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$noi_dung_moi, $thoigian_sua, $id_reply]);

    // Kiểm tra xem có bản ghi nào bị ảnh hưởng không
    if ($stmt->rowCount() > 0) {
        echo "Bình luận đã được sửa thành công!";
    } else {
        echo "Lỗi: Không tìm thấy bình luận để sửa.";
    }
} else {
    echo "Thông tin thiếu, không thể sửa bình luận!";
}

header("Location: admin_replies?ID_cmt=" . $_GET['ID_cmt']);
exit();

?>
<?php
// Kết nối database
require_once 'config.php'; // file này nên chứa $pdo = new PDO(...);

// Kiểm tra có tham số ID không
if (isset($_GET['ID_reply']) && is_numeric($_GET['ID_reply'])) {
    $id_reply = (int)$_GET['ID_reply'];

    // Chuẩn bị và thực thi câu lệnh xóa
    $sql = "DELETE FROM bang_reply WHERE ID_reply = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_reply]);

    $referer = $_SERVER['HTTP_REFERER'];
    // Kiểm tra có xóa thành công không
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Xóa thành công!'); window.location.href='$referer';</script>";
    } else {
        echo "<script>alert('Không tìm thấy bản ghi để xóa.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Thiếu ID hoặc ID không hợp lệ.'); history.back();</script>";
}
?>
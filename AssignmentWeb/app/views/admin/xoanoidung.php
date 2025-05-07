<?php
// Kết nối database
require 'config.php'; // file này nên chứa $pdo = new PDO(...);

// Kiểm tra có tham số ID không
if (isset($_GET['ID_tin']) && is_numeric($_GET['ID_tin'])) {
    $id_tin = (int)$_GET['ID_tin'];

    // Chuẩn bị và thực thi câu lệnh xóa
    $sql = "DELETE FROM bang_tin_tuc WHERE ID_tin = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_tin]);

    $referer = $_SERVER['HTTP_REFERER'] ;
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

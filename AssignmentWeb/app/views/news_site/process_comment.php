<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once __DIR__ . '/../../helper/session.php';

$session = Session::getInstance();
$user = $session->get('user');

try {
    if (!$user) {
        throw new Exception("Bạn cần đăng nhập để bình luận");
    }

    if (!isset($_POST['Noi_dung_cmt'], $_POST['ID_tin'])) {
        throw new Exception("Thiếu dữ liệu");
    }

    $id_tin = $_POST['ID_tin'];
    $noi_dung = trim($_POST['Noi_dung_cmt']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date("Y-m-d H:i:s");

    // Tạo ID_cmt ngẫu nhiên và đảm bảo không trùng
    do {
        $id_cmt = rand(100000000, 999999999);
        $stmt_check = $pdo->prepare("SELECT ID_cmt FROM bang_cmt WHERE ID_cmt = ?");
        $stmt_check->execute([$id_cmt]);
    } while ($stmt_check->rowCount() > 0);

    // Thêm comment
    $stmt = $pdo->prepare("INSERT INTO bang_cmt (ID_tin, ID_cmt, ID_user, Noi_dung_cmt, time_cmt, reply_to) VALUES (?, ?, ?, ?, ?,?)");
    $stmt->execute([$id_tin, $id_cmt, $user['id'], $noi_dung, $time, null]);

    echo json_encode([
        'success' => true,
        'comment' => [
            'ID_cmt' => $id_cmt,
            'name' => htmlspecialchars($user['name']),
            'Noi_dung_cmt' => htmlspecialchars($noi_dung),
            'time_cmt' => $time
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

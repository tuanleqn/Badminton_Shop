<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once __DIR__ . '/../../helper/session.php';

$session = Session::getInstance();
$user = $session->get('user');

try {
    if (!$user) {
        throw new Exception("Bạn cần đăng nhập để trả lời bình luận");
    }

    if (!isset($_POST['Noi_dung_cmt'], $_POST['ID_cmt'])) {
        throw new Exception("Thiếu dữ liệu");
    }

    $id_cmt = $_POST['ID_cmt'];
    $temp = $id_cmt;
    $stmt_check = $pdo->prepare("SELECT ID_tin FROM bang_cmt WHERE ID_cmt = ?");
    $stmt_check->execute([$temp]);
    $id_tin = $stmt_check->fetchColumn();
    if (!$id_tin) {
        throw new Exception("ID comment không hợp lệ");
    }

    $noi_dung = trim($_POST['Noi_dung_cmt']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date("Y-m-d H:i:s");

    // Tạo ID_reply ngẫu nhiên và đảm bảo không trùng
    do {
        $id_reply = rand(100000000, 999999999);
        $stmt_check = $pdo->prepare("SELECT ID_cmt FROM bang_cmt WHERE ID_cmt = ?");
        $stmt_check->execute([$id_reply]);
    } while ($stmt_check->rowCount() > 0);
    if (!$id_cmt) {
        throw new Exception("ID comment không hợp lệ");
    }
    // Thêm comment với user_id
    $stmt = $pdo->prepare("INSERT INTO bang_cmt (ID_tin, ID_cmt, ID_user, Noi_dung_cmt, time_cmt, reply_to) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_tin, $id_reply, $user['id'], $noi_dung, $time, $id_cmt]);

    echo json_encode([
        'success' => true,
        'reply' => [
            'ID_reply' => $id_reply,
            'Noi_dung_cmt' => htmlspecialchars($noi_dung),
            'time_cmt' => $time,
            'ID_cmt' => $id_cmt,
            'name' => htmlspecialchars($user['name']),
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

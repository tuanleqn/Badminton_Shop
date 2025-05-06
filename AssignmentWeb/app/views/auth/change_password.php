<?php
require_once __DIR__ . '/../../helper/session.php';
require_once __DIR__ . '/../../helper/URL.php';
$session = Session::getInstance();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu - VNB Sports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once __DIR__ . '/../header_footer/header.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Đổi mật khẩu</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($session->hasFlash('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo $session->getFlash('error'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($session->hasFlash('success')): ?>
                            <div class="alert alert-success">
                                <?php echo $session->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo URL::to('public/auth/updatePasswordAction'); ?>" method="POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cập nhật mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../header_footer/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
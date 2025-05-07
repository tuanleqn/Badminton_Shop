<?php
require_once __DIR__ . '/../../helper/session.php';
require_once __DIR__ . '/../../helper/URL.php';
$session = Session::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sports Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL::to('assets/css/style.css'); ?>">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if(isset($data['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $data['error']; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($_GET['expired'])): ?>
                            <div class="alert alert-warning">
                                Your session has expired. Please log in again.
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?php echo URL::to('public/auth/login'); ?>" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                            <div class="text-center">
                                <p>Don't have an account? <a href="<?php echo URL::to('public/auth/register'); ?>">Sign up here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
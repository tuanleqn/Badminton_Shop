<?php 
require_once(__DIR__ . '/../../helper/URL.php');

require_once(__DIR__ . '/../../helper/session.php');

$session = Session::getInstance();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>
    
    <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/compiled/svg/favicon.svg'); ?>" type="image/x-icon">
    
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/iconly.css'); ?>">
</head>

<body>
    <div id="app">
    <?php require_once 'components/sidebar.php'; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
<div class="page-heading">
    <h3>Web Statistics</h3>
</div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Profiles</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo count($data['customer']); ?></h6>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card"> 
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldBag"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Orders</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo $data['totalOrders']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldCategory"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Product Categories</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo count($data['productTypes']); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Products</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo $data['totalProducts']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Responses</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($data['response'] as $response): ?>
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="<?php echo URL::to('app/views/admin/assets/compiled/jpg/5.jpg'); ?>">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0"><?php echo $response['firstName'] . ' ' . $response['lastName']; ?></p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0"><?php echo $response['content']; ?></p>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="<?php echo URL::to('app/views/admin/assets/compiled/jpg/1.jpg'); ?>" alt="Face 1">
                        </div>
                        <div class="ms-3 name" style="overflow: hidden;">
                            <h5 class="font-bold"><?php echo $data['user']['name']?></h5>
                            <h6 class="text-muted mb-0 text-truncate"><?php echo $data['user']['email']?></h6>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo URL::to('public/auth/logout'); ?>" class="btn btn-danger btn-block">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Top Spenders</h4>
                </div>
                <div class="card-content pb-4">
                    <?php if (isset($data['topSpenders']) && !empty($data['topSpenders'])): ?>
                        <?php foreach ($data['topSpenders'] as $spender): ?>
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="<?php echo URL::to('app/views/admin/assets/compiled/jpg/1.jpg'); ?>">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($spender['name']); ?></h5>
                                    <h6 class="text-muted mb-0">Total Spent: $<?php echo number_format($spender['total_spent'], 2); ?></h6>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="px-4 py-3">
                            <p class="text-muted">No spending data available</p>
                        </div>
                    <?php endif; ?>
                    <div class="px-4">
                        <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>View All Orders</button>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>

            <footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2023 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Saugi</a></p>
        </div>
    </div>
</footer>
        </div>
    </div>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    
    
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
    

    
<!-- Need: Apexcharts -->
<script src="<?php echo URL::to('app/views/admin/assets/extensions/apexcharts/apexcharts.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/static/js/pages/dashboard.js'); ?>"></script>

</body>

</html>
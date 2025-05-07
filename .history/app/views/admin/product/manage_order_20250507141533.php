<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/OrderController.php';
require_once '../app/helper/URL.php';

$db = new db();
$DBConnect = $db->connect;

// Get filters and pagination parameters
$statusFilter = isset($_GET['status']) ? $DBConnect->real_escape_string($_GET['status']) : 'pending';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 5; // Number of items per page
$offset = ($page - 1) * $limit;

// Initialize controller
$controller = new OrderController($DBConnect);
$data = $controller->manageOrders($statusFilter, $page, $limit);

// Extract data for easier access
$orders = $data['orders'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$totalOrders = $data['totalOrders'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable.css'); ?>">
    <link rel="shortcut icon" href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/a.css'); ?>" />
</head>
<body>
    <div id="app">
    <?php require_once dirname(__DIR__) . '/components/sidebar.php'; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="layout-horizontal"> 
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Danh sách đơn hàng</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <!-- <li class="breadcrumb-item"><a href="index.html">Danh sách</a></li> -->
                                    <li class="breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form method="GET" class="d-flex">
                            <select name="status" class="form-select">
                                <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="shipped" <?php echo $statusFilter === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="delivered" <?php echo $statusFilter === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-2">Filter</button>
                        </form>
                    </div>
                    <section class="section"> 
                        <div class="table-responsive"> 
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['orderId']; ?></td>
                                        <td><?php echo htmlspecialchars($order['receiverName']); ?></td>
                                        <td><?php echo $order['totalPayment']; ?> đ</td>
                                        <td id="order-status-<?php echo $order['orderId']; ?>"><?php echo ucfirst($order['status']); ?></td>
                                        <td>
                                            <?php if ($order['status'] === 'cancelled'): ?>
                                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="pending">Reopen</a>
                                            <?php elseif ($order['status'] === 'pending'): ?>
                                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="shipped">Ship</a>
                                                <a href="#" class="btn btn-danger btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="cancelled">Cancel</a>
                                            <?php elseif ($order['status'] === 'shipped'): ?>
                                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="delivered">Deliver</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </section>

                    <div class="dataTable-info">
                        Showing <?php echo ($currentPage - 1) * $limit + 1; ?> to <?php echo min($currentPage * $limit, $totalOrders); ?> of <?php echo $totalOrders; ?> orders
                    </div>

                                
                    <nav class="dataTable-pagination">
                                <ul class="dataTable-pagination-list pagination pagination-primary">
                                    <?php if ($page > 1): ?>
                                        <li class="pager page-item">
                                            <a href="?page=<?php echo $page - 1; ?>" class="page-link">‹</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="pager page-item">
                                            <a href="?page=<?php echo $page + 1; ?>" class="page-link">›</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>

                </div>
            </div>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Danh sách đơn hàng</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Danh sách</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
    <div id="main" class="layout-horizontal">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" class="d-flex">
                <select name="status" class="form-select">
                    <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="shipped" <?php echo $statusFilter === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                    <option value="delivered" <?php echo $statusFilter === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                    <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Filter</button>
            </form>
        </div>
        <div class="table-responsive"> 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['orderId']; ?></td>
                        <td><?php echo htmlspecialchars($order['receiverName']); ?></td>
                        <td><?php echo $order['totalPayment']; ?> đ</td>
                        <td id="order-status-<?php echo $order['orderId']; ?>"><?php echo ucfirst($order['status']); ?></td>
                        <td>
                            <?php if ($order['status'] === 'cancelled'): ?>
                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="pending">Reopen</a>
                            <?php elseif ($order['status'] === 'pending'): ?>
                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="shipped">Ship</a>
                                <a href="#" class="btn btn-danger btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="cancelled">Cancel</a>
                            <?php elseif ($order['status'] === 'shipped'): ?>
                                <a href="#" class="btn btn-success btn-sm update-status-btn" data-id="<?php echo $order['orderId']; ?>" data-status="delivered">Deliver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        
        <div class="dataTable-info">
            Showing <?php echo ($currentPage - 1) * $limit + 1; ?> to <?php echo min($currentPage * $limit, $totalOrders); ?> of <?php echo $totalOrders; ?> orders
        </div>

                    
        <nav class="dataTable-pagination">
                    <ul class="dataTable-pagination-list pagination pagination-primary">
                        <?php if ($page > 1): ?>
                            <li class="pager page-item">
                                <a href="?page=<?php echo $page - 1; ?>" class="page-link">‹</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="pager page-item">
                                <a href="?page=<?php echo $page + 1; ?>" class="page-link">›</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
    </div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.id;
            const status = this.dataset.status;
            
            fetch('<?php echo URL::to("app/controllers/update_order.php"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: orderId,
                    status: status
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById(`order-status-${orderId}`).textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status');
            });
        });
    });
});
</script>

<script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/simple-datatables/umd/simple-datatables.js'); ?>"></script>
</body>
</html>
<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once '../app/helper/URL.php';

$db = new db();
$DBConnect = $db->connect;
// Get filters and pagination parameters
$statusFilter = isset($_GET['status']) ? $DBConnect->real_escape_string($_GET['status']) : 'pending';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 5;

// Initialize controller
$controller = new ProductController($DBConnect);
$data = $controller->manageReviews($statusFilter, $page, $limit);

// Extract data for easier access
$reviews = $data['reviews'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/extensions/simple-datatables/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/a.css'); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                            <h3>Danh sách bình luận</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Danh sách</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh sách bình luận</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <?php echo ucfirst($statusFilter); ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="?status=pending">Pending</a></li>
                            <li><a class="dropdown-item" href="?status=approved">Approved</a></li>
                            <li><a class="dropdown-item" href="?status=rejected">Rejected</a></li>
                        </ul>
                    </div>
                    <section> 
                        <div class="table-responsive"> 
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Stars</th>
                                    <th>Title</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $reviews->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                        <td><?php echo $row['stars']; ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                                        <td id="review-status-<?php echo $row['id']; ?>"><?php echo ucfirst($row['status']); ?></td>
                                        <td>
    <?php if ($row['status'] === 'rejected'): ?>
        <a href="#" class="text-success update-status-btn" data-id="<?php echo $row['id']; ?>" data-status="approved" title="Approve">
            <i class="bi bi-check fs-5"></i>
        </a>
    <?php elseif ($row['status'] === 'approved'): ?>
        <a href="#" class="text-danger update-status-btn" data-id="<?php echo $row['id']; ?>" data-status="rejected" title="Reject">
            <i class="bi bi-x fs-5"></i>
        </a>
    <?php else: ?>
        <a href="#" class="text-success me-2 update-status-btn" data-id="<?php echo $row['id']; ?>" data-status="approved" title="Approve">
            <i class="bi bi-check fs-5"></i>
        </a>
        <a href="#" class="text-danger update-status-btn" data-id="<?php echo $row['id']; ?>" data-status="rejected" title="Reject">
            <i class="bi bi-x fs-5"></i>
        </a>
    <?php endif; ?>
</td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        </div>
                    </section>
                    <nav>
                        <ul class="pagination justify-content-end">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                                
            </div>                               
        </div>
    </div>    
</div>
    
<script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/simple-datatables/umd/simple-datatables.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/static/js/pages/simple-datatables.js'); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewId = this.dataset.id;
            const status = this.dataset.status;
            
            fetch('<?php echo URL::to("app/controllers/update_review.php"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: reviewId,
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
                    document.getElementById(`review-status-${reviewId}`).textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    // Reload the page to update the UI
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
</body>
</html>

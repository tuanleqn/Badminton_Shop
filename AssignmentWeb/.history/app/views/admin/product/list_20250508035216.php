<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once __DIR__ . '/../../../models/SiteModel.php';
require_once '../app/helper/URL.php';

if (!isset($DBConnect)) {
    $DBConnect = new mysqli('localhost', 'root', '', 'shopvnb'); 
    if ($DBConnect->connect_error) {
        die("Database connection failed: " . $DBConnect->connect_error);
    }
}

$productController = new ProductController();

// Get search and pagination parameters
$search = isset($_GET['search']) ? $DBConnect->real_escape_string($_GET['search']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;


// Fetch products and pagination data
$data = $productController->listProducts($search, $page, $limit);
$products = $data['products'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$totalProducts = $data['totalProducts'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="shortcut icon" href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1zbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">

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
                <!-- Page content -->
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Danh sách sản phẩm</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-md-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Danh sách</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách sản phẩm</li>
                            </ol>
                        </nav>
                    </div>
                </div>
               

                <!-- filepath: d:\Tieu_Anh\xampp\htdocs\Shop-badminton\AssignmentWeb\app\views\admin\product\list.php -->
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Show</span>
                            <select name="table2_length" aria-controls="table2" class="form-select form-select-sm" onchange="changeEntries(this.value)">
                                <option value="10" <?php echo isset($_GET['limit']) && $_GET['limit'] == 10 ? 'selected' : ''; ?>>10</option>
                                <option value="25" <?php echo isset($_GET['limit']) && $_GET['limit'] == 25 ? 'selected' : ''; ?>>25</option>
                                <option value="50" <?php echo isset($_GET['limit']) && $_GET['limit'] == 50 ? 'selected' : ''; ?>>50</option>
                                <option value="100" <?php echo isset($_GET['limit']) && $_GET['limit'] == 100 ? 'selected' : ''; ?>>100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                        </form>
                    </div>
                    <div class="col-12 col-md-3 text-md-end">
                        <a href="<?php echo URL::to('public/admin/productadd'); ?>" class="btn btn-success btn-sm w-100 w-md-auto">Thêm sản phẩm mới</a>
                    </div>
                </div>
                

                <section class="section">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                                        <td><?php echo '$' . number_format($product['price'], 2, '.', ','); ?></td>
                                        <td>
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?php echo URL::to('/' . htmlspecialchars($product['image'])); ?>" alt="Image" style="width: 80px; height: 80px; object-fit: cover;">
                                            <?php else: ?>
                                                <span>No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around d-grid gap-2">
                                                <a href="<?php echo URL::to('public/admin/productedit?id=' . $product['id']); ?>" class="btn btn-secondary btn-sm">Edit</a>
                                                <a href="<?php echo URL::to('public/admin/productdelete?&action=deleteid=' . $product['id']); ?>" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>                
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="dataTable-info">
                    Showing <?php echo ($currentPage - 1) * $limit + 1; ?> to <?php echo min($currentPage * $limit, $totalProducts); ?> of <?php echo $totalProducts; ?> products
                </div>

                    
                <nav class="dataTable-pagination">
                    <ul class="dataTable-pagination-list pagination pagination-primary">
                        <?php if ($page > 1): ?>
                            <li class="pager page-item">
                                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>" class="page-link">‹</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="pager page-item">
                                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>" class="page-link">›</a>
                            </li>
                        <?php endif; ?>
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
<script>
    function changeEntries(limit) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('limit', limit);
        urlParams.set('page', 1);
        window.location.search = urlParams.toString();
    }
</script>

</body>
</html>

<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once __DIR__ . '/../../../models/SiteModel.php';
require_once '../app/helper/URL.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$controller = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->editProduct($productId, $_POST, $_FILES);
}

$product = $controller->getProduct($productId);
$productImages = $controller->ProductImages($productId);

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
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
    <div id="main" class="layout-horizontal">
        <div class="container mt-5">
            <p class="display-4 text-center">Chỉnh sửa sản phẩm</p>
            <form id="editProductForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($productId); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Danh sách hình ảnh</label>
                    <div class="mb-3">
                        <!-- Select All Checkbox -->
                        <?php if (!empty($productImages)): ?>
                            <div class="mb-2">
                                <input type="checkbox" id="selectAllImages" class="form-check-input">
                                <label for="selectAllImages" class="form-check-label">Chọn tất cả</label>
                            </div>
                            <div class="d-flex flex-wrap" id="sortableImages">
                                
                            <?php foreach ($productImages as $index => $image): ?>
                                
                                <div class="me-2 mb-2 image-item" data-id="<?php echo htmlspecialchars($image['id']); ?>">
                                    <img src="<?php echo URL::to('/' . htmlspecialchars($image['image_path'])); ?>" 
                                        alt="Product Image" 
                                        style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px;">
                                    <div>
                                        <input type="checkbox" class="image-checkbox" name="remove_images[]" value="<?php echo htmlspecialchars($image['id']); ?>"> Xóa
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>Không có hình ảnh nào.</p>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" id="imageOrder" name="imageOrder" value="">
                    <!-- Input for uploading new images -->
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-image"></i></span>
                        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Danh mục</label>
                    <!-- <div class="mb-3">
                    <label for="category" class="form-label">Danh mục</label>
                    <select class="form-select" id="category" name="category">
                        <option value="" selected>Chọn danh mục</option>
                        <option value="1">Vợt cầu lông</option>
                        <option value="2">Giày cầu lông</option>
                        <option value="3">Áo cầu lông</option>
                        <option value="4">Quần cầu lông</option>
                        <option value="5">Túi vợt</option>
                        <option value="6">Balo thể thao</option>
                        <option value="7">Phụ kiện</option>
                        <option value="8">Quả cầu</option>
                    </select>
                </div> -->
                    <select class="form-select" id="category" name="category">
                        <option value="" <?php echo $product['category'] == '' ? 'selected' : ''; ?>>Chọn danh mục</option>
                        <option value="1" <?php echo $product['category'] == 'Vợt cầu lông' ? 'selected' : ''; ?>>Vợt cầu lông</option>
                        <option value="2" <?php echo $product['category'] == 'Giày cầu lông' ? 'selected' : ''; ?>>Giày cầu lông</option>
                        <option value="3" <?php echo $product['category'] == 'Áo cầu lông' ? 'selected' : ''; ?>>Áo cầu lông</option>
                        <option value="4" <?php echo $product['category'] == 'Quần cầu lông' ? 'selected' : ''; ?>>Quần cầu lông</option>
                        <option value="5" <?php echo $product['category'] == 'Túi vợt' ? 'selected' : ''; ?>>Túi vợt</option>
                        <option value="6" <?php echo $product['category'] == 'Balo thể thao' ? 'selected' : ''; ?>>Balo thể thao</option>
                        <option value="7" <?php echo $product['category'] == 'Phụ kiện' ? 'selected' : ''; ?>>Phụ kiện</option>
                        <option value="8" <?php echo $product['category'] == 'Quả cầu' ? 'selected' : ''; ?>>Quả cầu</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Màu sắc</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                        <input type="text" class="form-control" id="color" name="color" 
                            value="<?php echo htmlspecialchars($product['color']); ?>" 
                            placeholder="Nhập màu sắc sản phẩm (ví dụ: Đỏ, Xanh)">
                    </div>
                    <small class="form-text text-muted">Nhập các màu sắc, cách nhau bằng dấu phẩy.</small>
                </div>
               
                <div class="mb-3">
                    <label for="size" class="form-label">Kích thước</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-ruler"></i></span>
                        <input type="text" class="form-control" id="size" name="size" 
                            value="<?php echo htmlspecialchars($product['size']); ?>" 
                            placeholder="Nhập kích thước sản phẩm (ví dụ: S, M, L)">
                    </div>
                    <small class="form-text text-muted">Nhập các kích thước, cách nhau bằng dấu phẩy.</small>
                </div>
                <div class="mb-3">
                    <label for="branchId" class="form-label">BrandID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="number" class="form-control" id="branchId" name="branchId" 
                        value="<?php echo isset($product['branchId']) ? htmlspecialchars($product['branchId']) : ''; ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                <a href="<?php echo URL::to('public/admin/productlist'); ?>" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        const sortable = new Sortable(document.getElementById('sortableImages'), {
            animation: 150,
            onEnd: function () {
                const order = Array.from(document.querySelectorAll('.image-item')).map(item => item.dataset.id);
                document.getElementById('imageOrder').value = order.join(',');
            }
        });

        const selectAllCheckbox = document.getElementById('selectAllImages');
        const imageCheckboxes = document.querySelectorAll('.image-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            imageCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    });
    document.getElementById('editProductForm').addEventListener('submit', function () {
    console.log(document.getElementById('imageOrder').value);
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/simple-datatables/umd/simple-datatables.js'); ?>"></script>
<script src="<?php echo URL::to('asset/js/admin.js'); ?>"></script>
</body>
</html>
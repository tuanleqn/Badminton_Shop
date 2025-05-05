<?php
require_once __DIR__ . '/../../../helper/config.php';
require_once __DIR__ . '/../../../controllers/ProductController.php';
require_once __DIR__ . '/../../../models/SiteModel.php';

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
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/template/dist/assets/extensions/simple-datatables/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/template/dist/assets/compiled/css/table-datatable.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/template/dist/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/template/dist/assets/compiled/css/app-dark.css'); ?>">
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
                                    <img src="<?php echo URL::to('app/' . htmlspecialchars($image['image_path'])); ?>" 
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
                    <select class="form-select" id="category" name="category">
                        <option value="" <?php echo $product['category'] == '' ? 'selected' : ''; ?>>Chọn danh mục</option>
                        <option value="1" <?php echo $product['category'] == '1' ? 'selected' : ''; ?>>Danh mục 1</option>
                        <option value="2" <?php echo $product['category'] == '2' ? 'selected' : ''; ?>>Danh mục 2</option>
                        <option value="3" <?php echo $product['category'] == '3' ? 'selected' : ''; ?>>Danh mục 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Màu sắc</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                        <input type="text" class="form-control" id="color" name="color" value="<?php echo htmlspecialchars($product['color']); ?>">
                    </div>                    
                </div>
               
                <div class="mb-3">
                    <label for="size" class="form-label">Kích thước</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-ruler"></i></span>
                        <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>">
                    </div>
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
                <a href="list.php" class="btn btn-secondary">Quay lại</a>
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

<script src="<?php echo URL::to('app/views/admin/template/dist/assets/static/js/initTheme.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/template/dist/assets/compiled/js/app.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/template/dist/assets/static/js/pages/simple-datatables.js'); ?>"></script>
<script src="<?php echo URL::to('asset/js/admin.js'); ?>"></script>
</body>
</html>
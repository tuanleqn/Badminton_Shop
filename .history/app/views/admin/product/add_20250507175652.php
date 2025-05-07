<?php
require_once '../app/helper/URL.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable.css'); ?>">
    <link rel="shortcut icon" href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable.css'); ?>">
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
            <p class="display-4 text-center">Thêm sản phẩm mới</p>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form id="addProductForm" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Nhập giá sản phẩm">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Danh sách hình ảnh</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-image"></i></span>
                        <input type="file" class="form-control" id="listsOfImage" name="listsOfImage[]" accept="image/*" multiple>                    </div>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Danh mục</label>
                    <select class="form-select" id="category" name="category">
                        <option value="" selected>Chọn danh mục</option>
                        <option value="1">Vợt cầu lông</option>
                        <option value="2">Giày cầu lông</option>
                        <option value="3">Áo cầu lông</option>
                        <option value="4">Quần cầu lông</option>
                        <option value="5">Túi vợt</option>
                        <option value="6">Quần cầu lông</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Màu sắc</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                        <input type="text" class="form-control" id="color" name="color" placeholder="Nhập màu sắc sản phẩm">
                    </div>                    
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-star"></i></span>
                        <input type="number" class="form-control" id="rating" name="rating" placeholder="Nhập rating sản phẩm" min="1" max="5">
                        
                    </div>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Kích thước</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-ruler"></i></span>
                        <input type="text" class="form-control" id="size" name="size" placeholder="Nhập kích thước sản phẩm">
                
                    </div>
                </div>
                <div class="mb-3">
                    <label for="brandId" class="form-label">Brand ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="number" class="form-control" id="brandId" name="brandId" placeholder="Enter Brand ID" required>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirm" required>
                    <label class="form-check-label" for="confirm">Xác nhận thông tin</label>
                </div>
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                <a href="list.php" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo URL::to("asset/AJAX/product/add.php"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error(`Server Error: ${text}`);
            }
        });
    })
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            window.location.href = '<?php echo URL::to("public/admin/productlist"); ?>';
        } else {
            throw new Error(data.message || 'Failed to add product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product: ' + error.message);
    });
});
</script>
<script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
<script src="<?php echo URL::to('app/views/admin/assets/extensions/simple-datatables/umd/simple-datatables.js'); ?>"></script>
</body>
</html>
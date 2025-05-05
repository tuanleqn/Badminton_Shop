<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link rel="stylesheet" href="../template/dist/assets/extensions/simple-datatables/style.css">
    <link rel="shortcut icon" href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1zbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" crossorigin href="../template/dist/assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="../template/dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="../template/dist/assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../template/dist/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="../../../../asset/css/product/a.css" />
</head>
<body>
<div id="app">
<?php
require_once '../components/sidebar.php'; ?>
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
                        <option value="1">Danh mục 1</option>
                        <option value="2">Danh mục 2</option>
                        <option value="3">Danh mục 3</option>
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
                    <label for="brandID" class="form-label">BrandID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="number" class="form-control" id="branchId" name="branchId" placeholder="Enter Branch ID" required>
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

        fetch('../../../asset/AJAX/product/add.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                window.location.href = 'list.php'; // Redirect to product list
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the product.');
        });
    });
</script>
<script src="../template/dist/assets/static/js/initTheme.js"></script>
<script src="../template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../template/dist/assets/compiled/js/app.js"></script>
<script src="../template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="../template/dist/assets/static/js/pages/simple-datatables.js"></script>
</body>
</html>
<?php

require_once __DIR__ . '/../../models/SiteModel.php';
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../helper/config.php';
require_once __DIR__ . '/../../helper/URL.php';


$productId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
$productName = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$productImage = isset($_POST['image']) ? htmlspecialchars($_POST['image']) : 'assets/images/default-image.jpg';
$productPrice = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : 0;
$productSize = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '';
$productQuantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/pc_style.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/roboto/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/pc_style.css'); ?>">
</head>

<body>
    
<div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= URL::to('public/home/index'); ?>">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>

        <!-- Cart Section -->
        <div class="card">
            <div class="card-header cart-header">
                GIỎ HÀNG CỦA BẠN
            </div>
            <div class="row card-body" id="cartItems">
                <!-- Check All Checkbox -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="checkAllProducts">
                    <label class="form-check-label" for="checkAllProducts">Chọn tất cả sản phẩm</label>
                </div>
            
                <!-- Cart items will be dynamically added here -->
            </div>
        </div>

        <!-- Total Section -->
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="cart-total">TỔNG TIỀN:</h5>
                <h5 id="totalPrice" class="cart-total">0 đ</h5>
            </div>
            <button class="btn btn-checkout w-100 mt-3" data-bs-toggle="modal" data-bs-target="#paymentModal">ĐẶT HÀNG</button>
        </div>
        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Total Price -->
                        <h6 class="text-muted">Tổng tiền</h6>
                        <p>Tổng cộng: <strong id="modalTotalPrice">0 đ</strong></p>

                        <h6 class="text-muted mt-4">Sản phẩm đã chọn</h6>
                        <div id="selectedProductsContainer">
                            <!-- Selected products will be dynamically added here -->
                        </div>

                        <!-- Shipping Information -->
                        <h6 class="text-muted mt-4">Thông tin nhận hàng</h6>
                        <form>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Họ và tên người nhận hàng</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Nhập họ và tên">
                                <div id="fullNameError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Nhập số điện thoại">
                                <div id="phoneNumberError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="houseNumber" class="form-label">Số nhà và tên đường</label>
                                <input type="text" class="form-control" id="houseNumber" name="houseNumber" placeholder="Nhập số nhà và tên đường">
                                <div id="houseNumberError" class="form-text text-danger"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="city" class="form-label">Thành phố/Tỉnh</label>
                                <select class="form-select" id="city" name="city">
                                    <option value="" selected>Chọn thành phố/tỉnh</option>
                                </select>
                                <div id="cityError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="district" class="form-label">Quận/Huyện</label>
                                <select class="form-select" id="district" name="district">
                                    <option value="" selected>Chọn quận/huyện</option>
                                </select>
                                <div id="districtError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="ward" class="form-label">Phường/Xã</label>
                                <select class="form-select" id="ward" name="ward">
                                    <option value="" selected>Chọn phường/xã</option>
                                </select>
                                <div id="wardError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                                <div id="emailError" class="form-text text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="orderNotes" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                                <textarea class="form-control" id="orderNotes" name="orderNotes" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                        </form>

                        <!-- Payment Options -->
                        <h6 class="text-muted mt-4">Thanh toán</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="codPayment" value="COD" checked>
                            <label class="form-check-label" for="codPayment">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="onlinePayment" value="Online">
                            <label class="form-check-label" for="onlinePayment">
                                Thanh toán qua cổng ngân hàng
                            </label>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="checkoutButton">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            const productId = "<?php echo $productId; ?>";
            const productName = "<?php echo $productName; ?>";
            const productImage = "<?php echo $productImage; ?>";
            const productPrice = "<?php echo $productPrice; ?>";
            const productSize = "<?php echo $productSize; ?>";
            const productQuantity = "<?php echo $productQuantity; ?>";
        </script>
        <script src="<?php echo URL::to('asset/js/pc_script.js'); ?>"></script>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí đơn hàng</title>
    <link rel="stylesheet" href="<?php echo URL::to('asset/css/product/od_style.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/roboto/index.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb" id="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URL::to('public/home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="currentPage">Đơn hàng của tôi</li>
                </ol>
            </nav> 
        </nav>
        <h4 class="text-uppercase fw-bold mb-4">Quản lý đơn hàng</h4>

        <div id="ordersContainer"></div>
        <!-- Order Details Modal -->
        <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Chi tiết đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <!-- Order details will be dynamically populated here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Retrieve order details from localStorage
            const orderDetails = JSON.parse(localStorage.getItem("orderDetails"));

            if (orderDetails) {
                const ordersContainer = document.getElementById("ordersContainer");

                // Display order details
                let orderHTML = `
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ và tên:</strong> ${orderDetails.customerInfo.fullName}</p>
                    <p><strong>Số điện thoại:</strong> ${orderDetails.customerInfo.phoneNumber}</p>
                    <p><strong>Email:</strong> ${orderDetails.customerInfo.email}</p>
                    <p><strong>Địa chỉ:</strong> ${orderDetails.customerInfo.address.houseNumber}, ${orderDetails.customerInfo.address.ward}, ${orderDetails.customerInfo.address.district}, ${orderDetails.customerInfo.address.city}</p>
                    <p><strong>Ghi chú:</strong> ${orderDetails.customerInfo.orderNotes}</p>
                    <p><strong>Phương thức thanh toán:</strong> ${orderDetails.paymentMethod}</p>
                    <h5 class="mt-4">Chi tiết đơn hàng</h5>
                    <ul>
                `;

                orderDetails.cart.forEach((item) => {
                    orderHTML += `
                        <li>
                            <strong>${item.name}</strong> - ${item.quantity} x ${item.price} = ${(item.quantity * parseFloat(item.price.replace(/[^\d.-]/g, ""))).toLocaleString("vi-VN")} đ
                        </li>
                    `;
                });

                orderHTML += `
                    </ul>
                    <h5 class="mt-4">Tổng tiền: ${orderDetails.totalPrice}</h5>
                `;

                ordersContainer.innerHTML = orderHTML;
            } else {
                document.getElementById("ordersContainer").innerHTML = "<p>Không có đơn hàng nào.</p>";
            }
        });
    </script> -->
    <script src="<?php echo URL::to('asset/js/od_script.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
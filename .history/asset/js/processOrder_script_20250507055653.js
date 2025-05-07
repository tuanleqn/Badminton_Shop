document.getElementById("checkoutButton").addEventListener("click", function () {
    const fullName = document.getElementById("fullName").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();
    const email = document.getElementById("email").value.trim();

    // Validate required fields
    if (!fullName || !phoneNumber || !email) {
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    // Check if the user exists in the database
    $.ajax({
        url: "/Shop-badminton/AssignmentWeb/app/controllers/UserController.php",
        type: "POST",
        data: { action: "checkUser", email: email, phone: phoneNumber },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.exists) {
                // User exists, proceed with the order
                processOrder();
            } else {
                // User does not exist, prompt registration
                alert("Bạn chưa có tài khoản. Vui lòng đăng ký trước khi đặt hàng.");
                showRegistrationForm();
            }
        },
        error: function () {
            alert("Đã xảy ra lỗi khi kiểm tra tài khoản. Vui lòng thử lại!");
        },
    });
});

function processOrder() {
    // Collect order details and process the order
    const houseNumber = document.getElementById("houseNumber").value.trim();
    const ward = document.getElementById("ward").value;
    const district = document.getElementById("district").value;
    const city = document.getElementById("city").value;

    const selectedProducts = [];
    cart.forEach((product, index) => {
        const checkbox = document.getElementById(`product${index}`);
        if (checkbox && checkbox.checked) {
            selectedProducts.push({
                name: product.name,
                image: product.image,
                quantity: product.quantity,
                price: product.price,
                totalPrice: parseFloat(product.price) * product.quantity,
            });
        }
    });

    const totalPrice = selectedProducts.reduce((total, product) => total + product.totalPrice, 0);

    const orderDetails = {
        orderId: `ORD-${Date.now()}`,
        date: new Date().toLocaleString("vi-VN"),
        fullName: document.getElementById("fullName").value.trim(),
        phoneNumber: document.getElementById("phoneNumber").value.trim(),
        email: document.getElementById("email").value.trim(),
        address: `${houseNumber}, ${ward}, ${district}, ${city}`,
        totalPrice: `${totalPrice.toLocaleString("vi-VN")} đ`,
        products: selectedProducts,
    };

    // Save order to localStorage
    const existingOrders = JSON.parse(localStorage.getItem("orders")) || [];
    existingOrders.push(orderDetails);
    localStorage.setItem("orders", JSON.stringify(existingOrders));

    // Update the cart in localStorage
    const remainingCart = cart.filter((_, index) => !document.getElementById(`product${index}`).checked);
    localStorage.setItem("cart", JSON.stringify(remainingCart));

    alert("Đặt hàng thành công!");
    window.location.href = "/Shop-badminton/AssignmentWeb/public/ProductSite/ordermanagement";
}

function showRegistrationForm() {
    // Show a registration form in the modal
    const modalBody = document.querySelector(".modal-body");
    modalBody.innerHTML = `
        <h6 class="text-muted">Đăng ký tài khoản</h6>
        <form id="registrationForm">
            <div class="mb-3">
                <label for="registerFullName" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="registerFullName" placeholder="Nhập họ và tên">
            </div>
            <div class="mb-3">
                <label for="registerPhoneNumber" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="registerPhoneNumber" placeholder="Nhập số điện thoại">
            </div>
            <div class="mb-3">
                <label for="registerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="registerEmail" placeholder="Nhập email">
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="registerPassword" placeholder="Nhập mật khẩu">
            </div>
            <button type="button" class="btn btn-primary" id="registerButton">Đăng ký</button>
        </form>
    `;

    document.getElementById("registerButton").addEventListener("click", function () {
        const fullName = document.getElementById("registerFullName").value.trim();
        const phoneNumber = document.getElementById("registerPhoneNumber").value.trim();
        const email = document.getElementById("registerEmail").value.trim();
        const password = document.getElementById("registerPassword").value.trim();

        if (!fullName || !phoneNumber || !email || !password) {
            alert("Vui lòng nhập đầy đủ thông tin đăng ký!");
            return;
        }

        // Send registration data to the server
        $.ajax({
            url: "/Shop-badminton/AssignmentWeb/app/controllers/UserController.php",
            type: "POST",
            data: { action: "registerUser", fullName, phoneNumber, email, password },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert("Đăng ký thành công! Bạn có thể tiếp tục đặt hàng.");
                    processOrder();
                } else {
                    alert("Đăng ký thất bại. Vui lòng thử lại!");
                }
            },
            error: function () {
                alert("Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại!");
            },
        });
    });
}
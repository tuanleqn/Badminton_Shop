let orders = JSON.parse(localStorage.getItem("orders")) || [];
document.addEventListener("DOMContentLoaded", function () {
    const ordersContainer = document.getElementById("ordersContainer");
    const modal = document.getElementById("orderDetailsModal");
    const modalBody = document.getElementById("modalBody");
    const paginationContainer = document.createElement("div");
    paginationContainer.classList.add("pagination-container", "mt-4", "d-flex", "justify-content-center");

    // Retrieve orders from localStorage
    let orders = [];
    const ordersPerPage = 6; // Number of orders per page
    let currentPage = 1;

    fetch("/Shop-badminton/AssignmentWeb/app/controllers/order.php?action=getOrders")
        .then((response) => response.json())
        .then((data) => {
            if (data.success && data.orders) {
                orders = data.orders; // Assign fetched orders
                renderOrders(); // Render the orders
            } else {
                ordersContainer.innerHTML = "<p>Không có đơn hàng nào.</p>";
            }
        })
        .catch((error) => {
            console.error("Error fetching orders:", error);
            ordersContainer.innerHTML = "<p>Đã xảy ra lỗi khi tải đơn hàng.</p>";
        });

    // Sort orders by newest first (descending order based on orderId timestamp)
    orders = orders.sort((a, b) => {
        const timestampA = parseInt(a.orderId.split('-')[1], 10);
        const timestampB = parseInt(b.orderId.split('-')[1], 10);
        return timestampB - timestampA; // Newest orders first
    });
    function addViewMoreListeners() {
        document.querySelectorAll(".view-more-btn").forEach(button => {
            button.addEventListener("click", function () {
                const index = this.getAttribute("data-index");
                const additionalProducts = document.getElementById(`additionalProducts${index}`);
                additionalProducts.classList.remove("d-none"); // Show additional products
                this.remove(); // Remove the "View More" button
            });
        });
    }
    // Function to render orders for the current page
    function renderOrders() {
        ordersContainer.innerHTML = ""; // Clear the container
        const startIndex = (currentPage - 1) * ordersPerPage;
        const endIndex = Math.min(startIndex + ordersPerPage, orders.length);
        const ordersToDisplay = orders.slice(startIndex, endIndex);

        ordersToDisplay.forEach((order, index) => {
            const orderCard = document.createElement("div");
            orderCard.classList.add("card", "mb-3");

            // Order Header
            const orderHeader = `
                <div class="card-header">
                    <strong>Mã đơn hàng:</strong> ${order.orderId}
                </div>
            `;

            // Order Body
            let productsHTML = "";
            order.products.forEach((product, productIndex) => {
                if (productIndex < 1) { // Show only the first product initially
                    productsHTML += `
                        <div class="d-flex align-items-center mb-2">
                            <img src="${product.image || 'placeholder.jpg'}" alt="${product.name}" class="img-fluid px-1 py-1" style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="ms-3">
                                <h6>${product.name}</h6>
                                <p class="mb-0">Số lượng: x${product.quantity}</p>
                            </div>
                        </div>
                    `;
                }
            });

            // View More Button (if more than 1 product)
            if (order.products.length > 1) {
                productsHTML += `
                    <button class="btn btn-link p-0 view-more-btn" data-index="${index}">
                        Xem thêm sản phẩm
                    </button>
                    <div class="additional-products d-none" id="additionalProducts${index}">
                        ${order.products.slice(1).map(product => `
                            <div class="d-flex align-items-center mb-2">
                                <img src="/Shop-badminton/AssignmentWeb/${product.image || 'placeholder.jpg'}" alt="${product.name}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ms-3">
                                    <h6>${product.name}</h6>
                                    <p class="mb-0">Số lượng: x${product.quantity}</p>
                                </div>
                            </div>
                        `).join("")}
                    </div>
                `;
            }

            const orderFooter = `
                <div class="card-body">
                    <p><strong>Tổng tiền:</strong> ${order.totalPrice} đ</p>
                    <button class="btn btn-primary btn-sm custom-btn" onclick="showOrderDetails(${startIndex + index})">Xem chi tiết</button>
                </div>
            `;

            // Combine all parts and append to the container
            orderCard.innerHTML = orderHeader + productsHTML + orderFooter;
            ordersContainer.appendChild(orderCard);
        });

        renderPagination();
        addViewMoreListeners();
    }

    function renderPagination() {
        paginationContainer.innerHTML = ""; // Clear pagination container
        const totalPages = Math.ceil(orders.length / ordersPerPage);
        const maxVisibleButtons = 5; // Maximum number of page buttons to display
    
        // Calculate the range of page numbers to display
        const startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
        const endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);
    
        // Add "Previous" button
        const prevButton = document.createElement("button");
        prevButton.classList.add("btn", "btn-outline-secondary", "pagination-btn");
        prevButton.textContent = "Previous";
        prevButton.disabled = currentPage === 1; // Disable if on the first page
        prevButton.addEventListener("click", function () {
            if (currentPage > 1) {
                currentPage--;
                renderOrders();
            }
        });
        paginationContainer.appendChild(prevButton);
    
        // Add numbered page buttons
        for (let i = startPage; i <= endPage; i++) {
            const pageButton = document.createElement("button");
            pageButton.classList.add("btn", "btn-outline-primary", "pagination-btn");
            pageButton.textContent = i;
            if (i === currentPage) {
                pageButton.classList.add("active");
            }
            pageButton.addEventListener("click", function () {
                currentPage = i;
                renderOrders();
            });
            paginationContainer.appendChild(pageButton);
        }
    
        // Add "Next" button
        const nextButton = document.createElement("button");
        nextButton.classList.add("btn", "btn-outline-secondary", "pagination-btn");
        nextButton.textContent = "Next";
        nextButton.disabled = currentPage === totalPages; // Disable if on the last page
        nextButton.addEventListener("click", function () {
            if (currentPage < totalPages) {
                currentPage++;
                renderOrders();
            }
        });
        paginationContainer.appendChild(nextButton);
    }

    // Function to show order details in a modal
    window.showOrderDetails = function (orderIndex) {
        const order = orders[orderIndex];

        // Populate modal content
        modalBody.innerHTML = `
            <p><strong>Mã đơn hàng:</strong> ${order.orderId}</p>
            <p><strong>Ngày đặt hàng:</strong> ${order.orderDate}</p>
            <p><strong>Họ tên:</strong> ${order.receiverName}</p>
            <p><strong>Số điện thoại:</strong> ${order.receiverPhone}</p>
            <p><strong>Email:</strong> ${order.receiverEmail}</p>
            <p><strong>Địa chỉ:</strong> ${order.receiverAddress}</p>
            <p><strong>Tổng tiền:</strong> ${order.totalPrice} đ</p>
            <h5>Sản phẩm:</h5>
            ${order.products.map(product => `
                <div class="d-flex align-items-center mb-2">
                    <img src="/Shop-badminton/AssignmentWeb/${product.image || 'placeholder.jpg'}" alt="${product.name}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="ms-3">
                        <h6>${product.name}</h6>
                        <p class="mb-0">Kích thước: ${product.size}</p>
                        <p class="mb-0">Màu sắc: ${product.color}</p>
                        <p class="mb-0">Số lượng: x${product.quantity}</p>
                        <p class="mb-0">Giá: ${product.price} đ</p>
                    </div>
                </div>
            `).join("")}
        `;

        // Show the modal
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    };

    // Initial render
    ordersContainer.parentNode.appendChild(paginationContainer);
    renderOrders();
});
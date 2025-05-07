let cart = JSON.parse(localStorage.getItem("cart")) || [];
document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded and parsed");
    
    if (typeof productId === "undefined" || !productId) {
        console.error("Product ID is not defined!");
        return;
    }


    const existingProductIndex = cart.findIndex((item) => item.id === productId);
    if (existingProductIndex === -1) {
        const newProduct = {
            id: productId,
            name: productName,
            image: productImage,
            price: productPrice,
            size: productSize,
            quantity: productQuantity,
        };
        cart.push(newProduct);
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    const paymentModal = document.getElementById("paymentModal");

    // When the modal is shown, set aria-hidden to false
    paymentModal.addEventListener("shown.bs.modal", function () {
        paymentModal.querySelector(".btn-close").focus(); // Focus on the close button
    });

    // When the modal is hidden, set aria-hidden to true
    paymentModal.addEventListener("hidden.bs.modal", function () {
        const triggerButton = document.querySelector('[data-bs-target="#paymentModal"]');
        if (triggerButton) {
            triggerButton.focus(); // Return focus to the button that opened the modal
        }
    });
    // const checkAllProducts = document.getElementById("checkAllProducts");

    // // Event listener for "Check All" checkbox
    // checkAllProducts.addEventListener("change", function () {
    //     const isChecked = this.checked;
    //     const productCheckboxes = document.querySelectorAll(".product-checkbox");

    //     // Set all product checkboxes to the same state as "Check All"
    //     productCheckboxes.forEach((checkbox) => {
    //         checkbox.checked = isChecked;
    //     });

    //     // Update the total price after toggling all checkboxes
    //     updateCheckAllState();
    //     updateTotalPrice();
    // });
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("product-checkbox")) {
            // updateCheckAllState();
            updateTotalPrice();
        }
    });

    renderCart();
    // populateSelectedProducts();
    updateTotalPrice();
});

function renderCart() {
    const cartItemsContainer = document.getElementById("cartItems");
    if (!cartItemsContainer) {
        console.error("Cart Items Container not found!");
        return;
    }

    cartItemsContainer.innerHTML = `
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="checkAllProducts">
            <label class="form-check-label" for="checkAllProducts">Chọn tất cả sản phẩm</label>
        </div>
    `;

    cart.forEach((item, index) => {
        const price = item.price ? item.price.replace(/[^\d.-]/g, "") : "0";
        const itemTotalPrice = parseFloat(price) * item.quantity;

        const cartItemHTML = `
            <div class="col-12 mb-3">
                <div class="card p-3">
                    <div class="row align-items-center">
                        <!-- Checkbox -->
                        <div class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input product-checkbox" type="checkbox" value="${itemTotalPrice}" id="product${index}" checked>
                            </div>
                        </div>
                        <!-- Product Image -->
                        <div class="col-auto">
                            <img src="/Shop-badminton/AssignmentWeb/${item.image}" alt="${item.name}" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <!-- Product Details -->
                        <div class="col">
                            <h5 class="mb-1">${item.name}</h5>
                            <p class="mb-1">Màu sắc: ${item.color || "Không có"}</p>
                            <p class="mb-1">Size: ${item.size || "N/A"}</p>
                            <p class="mb-1">Giá: ${item.price}</p>
                        </div>
                        <!-- Quantity Controls -->
                        <div class="col-auto">
                            <div class="quantity-controls d-flex align-items-center">
                                <button class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity(${index})">-</button>
                                <input type="text" id="quantityInput${index}" value="${item.quantity}" readonly class="form-control text-center mx-1" style="width: 50px;">
                                <button class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity(${index})">+</button>
                            </div>
                        </div>
                        <!-- Total Price and Delete Button -->
                        <div class="col-auto text-end">
                            <strong>${itemTotalPrice.toLocaleString("vi-VN")} đ</strong>
                            <button class="btn btn-danger btn-sm mt-2" onclick="deleteProduct(${index})">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        cartItemsContainer.innerHTML += cartItemHTML;
    });

    checkoutButton.addEventListener("click", function () {
        if (cart.length === 0) {
            alert("Giỏ hàng của bạn đang trống!");
            return;
        }
    
        console.log("Checking user authentication...");
    
        // Collect selected products
        fetch("/Shop-badminton/AssignmentWeb/app/controllers/auth.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "action=checkUser",
        })
            .then((response) => {
                console.log("Response received:", response);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // Parse the response as JSON
            })
            .then((data) => {
                console.log("User authentication data:", data);
                if (data.exists) {
                    console.log("User authenticated. Processing order...");
                    processOrder();
                } else {
                    alert("Bạn chưa có tài khoản. Vui lòng đăng ký trước khi đặt hàng.");
                    window.location.href = "/Shop-badminton/AssignmentWeb/public/auth/register";
                }
            })
            .catch((error) => {
                console.error("Error checking user:", error);
                alert("Đã xảy ra lỗi khi kiểm tra tài khoản. Vui lòng thử lại!");
            });
    });
    attachEventListeners();
}

function attachEventListeners() {
    const checkAllProducts = document.getElementById("checkAllProducts");
    const productCheckboxes = document.querySelectorAll(".product-checkbox");

    if (!checkAllProducts) {
        console.error("Check All Products checkbox not found!");
        return;
    }

    // Event listener for "Check All" checkbox
    checkAllProducts.addEventListener("change", function () {
        const isChecked = this.checked;
        productCheckboxes.forEach((checkbox) => {
            checkbox.checked = isChecked;
        });
        updateTotalPrice();
    });

    // Event listener for individual product checkboxes
    productCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            updateCheckAllState();
            updateTotalPrice();
        });
    });
}


function calculateTotalPayment() {
    let total = 0;

    // Loop through all checked checkboxes
    document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
        total += parseFloat(checkbox.value); // Add the value of the selected product
    });

    return total; // Return the total payment
}

function processOrder() {
    console.log("Processing order...");

    document.querySelectorAll('.form-text.text-danger').forEach(el => el.textContent = '');

    let isValid = true;
    const fullNameElement = document.getElementById("fullName");
    const phoneNumberElement = document.getElementById("phoneNumber");
    const houseNumberElement = document.getElementById("houseNumber");
    const cityElement = document.getElementById("city");
    const districtElement = document.getElementById("district");
    const wardElement = document.getElementById("ward");
    const emailElement = document.getElementById("email");

    // Validate required fields
    if (
        !fullNameElement.value.trim() ||
        !phoneNumberElement.value.trim() ||
        !houseNumberElement.value.trim() ||
        !cityElement.value ||
        !districtElement.value ||
        !wardElement.value ||
        !emailElement.value.trim()
    ) {
        alert("Vui lòng điền đầy đủ thông tin người nhận!");
        return;
    }

    if (fullNameElement.value.trim() === '') {
        document.getElementById('fullNameError').textContent = 'Họ và tên không được để trống.';
        isValid = false;
    }

    const phoneRegex = /^[0-9]{10,11}$/; // Accepts 10-11 digit numbers
    if (!phoneRegex.test(phoneNumberElement.value.trim())) {
        document.getElementById('phoneNumberError').textContent = 'Số điện thoại không hợp lệ.';
        isValid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // regex email
    if (!emailRegex.test(email.value.trim())) {
        document.getElementById('emailError').textContent = 'Email không hợp lệ.';
        isValid = false;
    }


    if (houseNumberElement.value.trim() === '') {
        document.getElementById('houseNumberError').textContent = 'Số nhà và tên đường không được để trống.';
        isValid = false;
    }

    const address = `${houseNumberElement.value.trim()}, ${wardElement.options[wardElement.selectedIndex].text.trim()}, ${districtElement.options[districtElement.selectedIndex].text.trim()}, ${cityElement.options[cityElement.selectedIndex].text.trim()}`;

    const receiverInfo = {
        name: fullNameElement.value.trim(),
        phone: phoneNumberElement.value.trim(),
        address: address,
        email: emailElement.value.trim(),
    };

    const paymentMethodElement = document.querySelector('input[name="paymentMethod"]:checked');
    if (!paymentMethodElement) {
        alert("Vui lòng chọn phương thức thanh toán!");
        return;
    }

    const paymentMethod = paymentMethodElement.value;
    const totalPayment = calculateTotalPayment();
    const cart = JSON.parse(localStorage.getItem("cart"));

    if (!cart || cart.length === 0) {
        alert("Giỏ hàng của bạn đang trống!");
        return;
    }

    const formattedCart = cart.map((item) => ({
        productId: item.id,
        name: item.name,
        size: item.size || "N/A",
        color: item.color || "N/A",
        quantity: item.quantity,
        price: parseFloat(item.price.replace(/[^\d.-]/g, "")),
        image: item.image || null,
    }));

    console.log("Order details:", {
        receiverInfo,
        paymentMethod,
        totalPayment,
        cart: formattedCart,
    });

    fetch("/Shop-badminton/AssignmentWeb/app/controllers/order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "saveOrder",
            receiverInfo,
            paymentMethod,
            totalPayment,
            cart: formattedCart,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log("Order response:", data);
            if (data.success) {
                alert("Đặt hàng thành công!");
                localStorage.removeItem("cart"); // Clear the cart
                window.location.href = "/Shop-badminton/AssignmentWeb/public/ProductSite/ordermanagement";
            } else {
                alert("Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại!");
            }
        })
        .catch((error) => {
            console.error("Error processing order:", error);
            alert("Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại!");
        });
}


    window.increaseQuantity = function (index) {
        cart[index].quantity++;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        updateTotalPrice(); // Update total price after rendering
    };
    window.decreaseQuantity = function (index) {
        if (cart[index].quantity > 1) {
            cart[index].quantity--;
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCart();
            updateTotalPrice(); // Update total price after rendering
        } else {
            alert("Số lượng không thể nhỏ hơn 1.");
        }
    };

    function updateTotalPrice() {
        let total = 0;

        // Loop through all checked checkboxes
        document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
            total += parseFloat(checkbox.value); // Add the value of the selected product
        });

        // Update the total price in the cart and modal
        totalPriceElement.textContent = `${total.toLocaleString("vi-VN")} đ`;
        const modalTotalPrice = document.getElementById('modalTotalPrice');
        if (modalTotalPrice) {
            modalTotalPrice.textContent = `${total.toLocaleString("vi-VN")} đ`;
        }
    }

    
    window.deleteProduct = function (index) {
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        updateTotalPrice(); // Update total price after rendering
    };

    function updateTotalPrice() {
        const productCheckboxes = document.querySelectorAll(".product-checkbox:checked");
        let totalPrice = 0;

        productCheckboxes.forEach((checkbox) => {
            totalPrice += parseFloat(checkbox.value);
        });

        // Update the total price in the DOM
        const totalPriceElement = document.getElementById("totalPrice");
        const modalTotalPriceElement = document.getElementById("modalTotalPrice");

        totalPriceElement.textContent = `${totalPrice.toLocaleString("vi-VN")} đ`;
        modalTotalPriceElement.textContent = `${totalPrice.toLocaleString("vi-VN")} đ`;
    }

    function updateCheckAllState() {
        const productCheckboxes = document.querySelectorAll(".product-checkbox");
        const allChecked = Array.from(productCheckboxes).every((checkbox) => checkbox.checked);
        const noneChecked = Array.from(productCheckboxes).every((checkbox) => !checkbox.checked);

        // Update the "Check All" checkbox state
        if (allChecked) {
            checkAllProducts.checked = true;
            checkAllProducts.indeterminate = false;
        } else if (noneChecked) {
            checkAllProducts.checked = false;
            checkAllProducts.indeterminate = false;
        } else {
            checkAllProducts.indeterminate = true; // Set indeterminate state if some are checked
        }
    }

    const totalPriceElement = document.getElementById("totalPrice");
    const checkoutButton = document.getElementById("checkoutButton");
    
    const citySelect = document.getElementById("city");
    const wardSelect = document.getElementById("ward");
    const districtSelect = document.getElementById("district");

    const addressData = {
        "Hồ Chí Minh": {
            "Quận 1": ["Phường 1", "Phường 2", "Phường 3"],
            "Quận 2": ["Phường 4", "Phường 5", "Phường 6"],
            
        },
        "Hà Nội": {
            "Quận Ba Đình": ["Phường Cống Vị", "Phường Điện Biên", "Phường Giảng Võ"],
            "Quận Hoàn Kiếm": ["Phường Chương Dương", "Phường Cửa Đông", "Phường Hàng Bạc"],
        },
        "Đà Nẵng": {
            "Quận Hải Châu": ["Phường Bình Hiên", "Phường Bình Thuận", "Phường Hòa Cường Bắc"],
            "Quận Sơn Trà": ["Phường An Hải Bắc", "Phường An Hải Đông", "Phường An Hải Tây"],
        },
    };
    const fullName = document.getElementById("fullName").value.trim();
        const phoneNumber = document.getElementById("phoneNumber").value.trim();
        const email = document.getElementById("email").value.trim();
        const houseNumber = document.getElementById("houseNumber").value.trim();
        const ward = document.getElementById("ward").value;
        const district = document.getElementById("district").value;
        const city = document.getElementById("city").value;
        citySelect.innerHTML = '<option value="" selected>Chọn thành phố/tỉnh</option>'; // Clear existing options
    Object.keys(addressData).forEach((city) => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        citySelect.appendChild(option);
    });
    
    citySelect.addEventListener("change", function () {
        const selectedCity = citySelect.value;
    
        // Clear district and ward dropdowns
        districtSelect.innerHTML = '<option value="" selected>Chọn quận/huyện</option>';
        wardSelect.innerHTML = '<option value="" selected>Chọn phường/xã</option>';
    
        if (selectedCity && addressData[selectedCity]) {
            // Populate district dropdown
            Object.keys(addressData[selectedCity]).forEach((district) => {
                const option = document.createElement("option");
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    });
    
    
    // Event listener for district selection
    districtSelect.addEventListener("change", function () {
        const selectedCity = citySelect.value;
        const selectedDistrict = districtSelect.value;
    
        // Clear ward dropdown
        wardSelect.innerHTML = '<option value="" selected>Chọn phường/xã</option>';
    
        if (selectedCity && selectedDistrict && addressData[selectedCity][selectedDistrict]) {
            // Populate ward dropdown
            addressData[selectedCity][selectedDistrict].forEach((ward) => {
                const option = document.createElement("option");
                option.value = ward;
                option.textContent = ward;
                wardSelect.appendChild(option);
            });
        }
    });
        

// document.addEventListener("DOMContentLoaded", function () {
//     const cartItemsContainer = document.getElementById("cartItems");
//     const totalPriceElement = document.getElementById("totalPrice");
//     const checkoutButton = document.getElementById("checkoutButton");
    
//     const citySelect = document.getElementById("city");
//     const wardSelect = document.getElementById("ward");
//     const districtSelect = document.getElementById("district");

//     const addressData = {
//         "Hồ Chí Minh": {
//             "Quận 1": ["Phường 1", "Phường 2", "Phường 3"],
//             "Quận 2": ["Phường 4", "Phường 5", "Phường 6"],
            
//         },
//         "Hà Nội": {
//             "Quận Ba Đình": ["Phường Cống Vị", "Phường Điện Biên", "Phường Giảng Võ"],
//             "Quận Hoàn Kiếm": ["Phường Chương Dương", "Phường Cửa Đông", "Phường Hàng Bạc"],
//         },
//         "Đà Nẵng": {
//             "Quận Hải Châu": ["Phường Bình Hiên", "Phường Bình Thuận", "Phường Hòa Cường Bắc"],
//             "Quận Sơn Trà": ["Phường An Hải Bắc", "Phường An Hải Đông", "Phường An Hải Tây"],
//         },
//     };

    

//     checkoutButton.addEventListener("click", function () {
//         // Retrieve the latest values of the form fields
//         const fullName = document.getElementById("fullName").value.trim();
//         const phoneNumber = document.getElementById("phoneNumber").value.trim();
//         const email = document.getElementById("email").value.trim();
//         const houseNumber = document.getElementById("houseNumber").value.trim();
//         const ward = document.getElementById("ward").value;
//         const district = document.getElementById("district").value;
//         const city = document.getElementById("city").value;
    
//         const selectedProducts = [];
//         const remainingCart = []; // To store products not selected for checkout
    
//         document.querySelectorAll(".product-checkbox").forEach((checkbox) => {
//             const productIndex = checkbox.id.replace("product", ""); // Extract product index
//             const product = cart[productIndex]; // Get product from cart
    
//             if (checkbox.checked) {
//                 // Add selected product to the order
//                 selectedProducts.push({
//                     name: product.name,
//                     image: product.image || "placeholder.jpg", // Use placeholder if no image
//                     quantity: product.quantity,
//                     price: product.price,
//                     totalPrice: parseFloat(product.price.replace(/[^\d.-]/g, "")) * product.quantity,
//                 });
//             } else {
//                 // Add unselected product back to the cart
//                 remainingCart.push(product);
//             }
//         });
    
//         const totalPrice = document.getElementById("modalTotalPrice").textContent;
    
//         // Create order details object
//         const orderDetails = {
//             orderId: `ORD-${Date.now()}`,
//             date: new Date().toLocaleString("vi-VN"), // Add order date in Vietnamese format
//             fullName,
//             phoneNumber,
//             email,
//             address: `${houseNumber}, ${ward}, ${district}, ${city}`,
//             totalPrice,
//             products: selectedProducts,
//         };
    
//         // Save order to localStorage
//         const existingOrders = JSON.parse(localStorage.getItem("orders")) || [];
//         existingOrders.push(orderDetails);
//         localStorage.setItem("orders", JSON.stringify(existingOrders));
    
//         // Update the cart in localStorage with remaining products
//         localStorage.setItem("cart", JSON.stringify(remainingCart));
    
//         // Redirect to order-management.html
//         window.location.href = "order-management.html";
//     });

//     citySelect.innerHTML = '<option value="" selected>Chọn thành phố/tỉnh</option>'; // Clear existing options
//     Object.keys(addressData).forEach((city) => {
//         const option = document.createElement("option");
//         option.value = city;
//         option.textContent = city;
//         citySelect.appendChild(option);
//     });
    
//     citySelect.addEventListener("change", function () {
//         const selectedCity = citySelect.value;
    
//         // Clear district and ward dropdowns
//         districtSelect.innerHTML = '<option value="" selected>Chọn quận/huyện</option>';
//         wardSelect.innerHTML = '<option value="" selected>Chọn phường/xã</option>';
    
//         if (selectedCity && addressData[selectedCity]) {
//             // Populate district dropdown
//             Object.keys(addressData[selectedCity]).forEach((district) => {
//                 const option = document.createElement("option");
//                 option.value = district;
//                 option.textContent = district;
//                 districtSelect.appendChild(option);
//             });
//         }
//     });
    
    
//     // Event listener for district selection
//     districtSelect.addEventListener("change", function () {
//         const selectedCity = citySelect.value;
//         const selectedDistrict = districtSelect.value;
    
//         // Clear ward dropdown
//         wardSelect.innerHTML = '<option value="" selected>Chọn phường/xã</option>';
    
//         if (selectedCity && selectedDistrict && addressData[selectedCity][selectedDistrict]) {
//             // Populate ward dropdown
//             addressData[selectedCity][selectedDistrict].forEach((ward) => {
//                 const option = document.createElement("option");
//                 option.value = ward;
//                 option.textContent = ward;
//                 wardSelect.appendChild(option);
//             });
//         }
//     });

//     // Retrieve the cart from localStorage
//     // let cart = JSON.parse(localStorage.getItem("cart")) || [];

//     // // Function to render the cart items
//     // function renderCart() {
//     //     cartItemsContainer.innerHTML = `
//     //         <div class="form-check mb-3">
//     //             <input class="form-check-input" type="checkbox" id="checkAllProducts">
//     //             <label class="form-check-label" for="checkAllProducts">Chọn tất cả sản phẩm</label>
//     //         </div>
//     //     `;
    
//     //     // Dynamically add cart items here
//     //     cart.forEach((item, index) => {
//     //         const itemTotalPrice = parseFloat(item.price.replace(/[^\d.-]/g, "")) * item.quantity;
    
//     //         const cartItemHTML = `
//     //             <div class="col-12 mb-3">
//     //                 <div class="d-flex align-items-center border p-3">
//     //                     <div class="form-check me-3">
//     //                         <input class="form-check-input product-checkbox" type="checkbox" value="${itemTotalPrice}" id="product${index}" checked title="Select Product">
//     //                     </div>
//     //                     <img src="${item.image}" alt="${item.name}" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
//     //                     <div class="ms-3 flex-grow-1">
//     //                         <h5>${item.name}</h5>
//     //                         <p>Màu sắc: ${item.color}</p>
//     //                         <p>Size: ${item.size}</p>
//     //                         <p>Giá: ${item.price}</p>
//     //                         <div class="quantity-controls">
//     //                             <button class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity(${index})" aria-label="Giảm số lượng">-</button>
//     //                             <input type="text" id="quantityInput${index}" name="quantityInput${index}" class="form-control col-md-2 align-items-center text-center" value="${item.quantity}" readonly title="Product Quantity">                                <button class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity(${index})">+</button>
//     //                         </div>
//     //                     </div>
//     //                     <div>
//     //                         <strong>${itemTotalPrice.toLocaleString("vi-VN")} đ</strong>
//     //                         <button class="btn btn-danger btn-sm mt-2" onclick="deleteProduct(${index})" title="Delete Product">
//     //                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
//     //                                 <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
//     //                             </svg>
//     //                         </button>
//     //                     </div>
//     //                 </div>
//     //             </div>
//     //         `;
//     //         cartItemsContainer.innerHTML += cartItemHTML;
//     //     });
    
//     //     // Reattach the "Check All" event listener
//     //     const checkAllProducts = document.getElementById("checkAllProducts");
//     //     checkAllProducts.addEventListener("change", function () {
//     //         const isChecked = checkAllProducts.checked;
//     //         const productCheckboxes = document.querySelectorAll(".product-checkbox");
//     //         productCheckboxes.forEach((checkbox) => {
//     //             checkbox.checked = isChecked;
//     //         });
//     //         updateTotalPrice();
//     //     });
//     // }

    
    

//     // function populateSelectedProducts() {
//     //     const selectedProductsContainer = document.getElementById("selectedProductsContainer");
//     //     selectedProductsContainer.innerHTML = ""; // Clear the container
    
//     //     // Loop through all checked checkboxes
//     //     document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
//     //         const productIndex = checkbox.id.replace("product", ""); // Extract the product index
//     //         const product = cart[productIndex]; // Get the product from the cart
    
//     //         // Create the HTML for the selected product
//     //         const selectedProductHTML = `
//     //             <div class="d-flex justify-content-between align-items-center mb-3">
//     //                 <div class="d-flex align-items-center">
//     //                     <img src="${product.image}" alt="${product.name}" class="img-fluid me-3" style="width: 60px; height: 60px; object-fit: cover;">
//     //                     <div>
//     //                         <h6>${product.name}</h6>
//     //                         <p class="mb-0">Màu sắc: ${product.color}</p>
//     //                         <p class="mb-0">Size: ${product.size}</p>
//     //                         <p class="mb-0">Số lượng: ${product.quantity}</p>
//     //                     </div>
//     //                 </div>
//     //                 <div>
//     //                     <strong>${(parseFloat(product.price.replace(/[^\d.-]/g, "")) * product.quantity).toLocaleString("vi-VN")} đ</strong>
//     //                 </div>
//     //             </div>
//     //         `;
    
//     //         // Append the product to the container
//     //         selectedProductsContainer.innerHTML += selectedProductHTML;
//     //     });
//     // }



    

//     // Function to decrease quantity
    




    

//     // Ensure "Check All" reflects the state of individual checkboxes


//     // Add event listener to individual product checkboxes
    
    
// });




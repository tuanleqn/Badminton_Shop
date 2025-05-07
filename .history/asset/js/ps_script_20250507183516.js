function sortProducts(criteria) {
    const productList = document.getElementById('productList');
    const products = Array.from(productList.getElementsByClassName('product-card'))
        .filter(product => product.parentElement.style.display !== 'none'); // Only include visible products

    // Sort products based on criteria
    products.sort((a, b) => {
        switch (criteria) {
            case 'New':
                return parseInt(b.dataset.id) - parseInt(a.dataset.id); // Assuming 'id' represents recency
            case 'Price-ascending':
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            case 'Price-descending':
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            case 'Rating':
                return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
            case 'Category':
                return a.dataset.category.localeCompare(b.dataset.category);
            default:
                return 0;
        }
    });

    // Generate new HTML for sorted products
    let productListHTML = '';
    products.forEach(product => {
        const id = product.dataset.id;
        const price = product.dataset.price;
        const rating = parseFloat(product.dataset.rating) || 0;
        const category = product.dataset.category;
        const imagePath = product.querySelector('img').getAttribute('src');
        const name = product.querySelector('.card-title').textContent;
        const brand = product.dataset.brand || 'unknown';
        const size = product.dataset.size || 'unknown';

        // Generate stars for rating
        const fullStars = Math.floor(rating);
        const halfStar = rating - fullStars >= 0.5 ? 1 : 0;
        const emptyStars = 5 - (fullStars + halfStar);
        let starsHTML = '';

        for (let i = 0; i < fullStars; i++) {
            starsHTML += '<i class="bi bi-star-fill text-warning"></i>';
        }
        if (halfStar) {
            starsHTML += '<i class="bi bi-star-half text-warning"></i>';
        }
        for (let i = 0; i < emptyStars; i++) {
            starsHTML += '<i class="bi bi-star text-warning"></i>';
        }

        // Append product card HTML with matching structure and styles
        productListHTML += `
            <div class='col-6 col-md-4 col-lg-3 mb-4'>
                <div class='product-card card h-100 d-flex flex-column' 
                    data-id='${id}' 
                    data-price='${price}' 
                    data-rating='${rating}' 
                    data-category='${category}' 
                    data-brand='${brand}' 
                    data-size='${size}'>
                    <img src='${imagePath}' alt='Product Image' class='card-img-top img-fluid' style='width: 250px; height: 300px; object-fit: cover; align-self: center;'>
                    <div class='card-body'>
                        <h6 class='card-title'>${name}</h6>
                        <p class='card-text'>$${price}</p>
                        <div>Rating: ${starsHTML} </div>
                        <p class='card-text'>Category: ${category}</p>
                        <a href='productdetail?id=${id}' class='btn btn-custom' style='background-color: #f98850;'>Buy Now</a>
                    </div>
                </div>
            </div>
        `;
    });
    console.log(productListHTML);
    // Update the product list container
    productList.innerHTML = productListHTML;
}




function filterProducts() {
    const selectedCategories = Array.from(document.querySelectorAll('#categoryContainer .form-check-input:checked'))
        .map(checkbox => checkbox.value.toLowerCase());
    const selectedBrands = Array.from(document.querySelectorAll('#brandContainer .form-check-input:checked'))
        .map(checkbox => checkbox.value.toLowerCase());
    const selectedSizes = Array.from(document.querySelectorAll('#sizeContainer .form-check-input:checked'))
        .map(checkbox => checkbox.value.toLowerCase());

    const productList = document.getElementById('productList');
    const products = Array.from(productList.getElementsByClassName('product-card'));

    products.forEach(product => {
        const productCategory = product.dataset.category ? product.dataset.category.toLowerCase() : '';
        const productBrand = product.dataset.brand ? product.dataset.brand.toLowerCase() : '';
        const productSize = product.dataset.size ? product.dataset.size.toLowerCase() : '';

        const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(productCategory);
        const matchesBrand = selectedBrands.length === 0 || selectedBrands.includes(productBrand);
        const matchesSize = selectedSizes.length === 0 || selectedSizes.includes(productSize);

        if (matchesCategory && matchesBrand && matchesSize) {
            product.parentElement.style.display = ''; // Show product
        } else {
            product.parentElement.style.display = 'none'; // Hide product
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const categoryCheckboxes = document.querySelectorAll('#categoryContainer .form-check-input');
    const brandCheckboxes = document.querySelectorAll('#brandContainer .form-check-input');
    const sizeCheckboxes = document.querySelectorAll('#sizeContainer .form-check-input');

    [...categoryCheckboxes, ...brandCheckboxes, ...sizeCheckboxes].forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const productList = document.getElementById('productList');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        fetch(`${searchProductUrl}?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Clear the product list
                productList.innerHTML = '';

                if (data.products && data.products.length > 0) {
                    // Render the filtered products
                    data.products.forEach(product => {
                        const productCard = `
                            <div class='col-6 col-md-4 col-lg-3 mb-4'>
                                <div class='product-card card h-100 d-flex flex-column' 
                                    data-id='${product.id}' 
                                    data-price='${product.price}' 
                                    data-rating='${product.average_rating || 0}' 
                                    data-brand='${product.brand_name.toLowerCase()}' 
                                    data-category='${product.category.toLowerCase()}'
                                    data-size='${product.size.toLowerCase()}'>
                                    <img src='${product.image_path || '/Shop-badminton/AssignmentWeb/uploads/placeholder.jpg'}' 
                                        alt='Product Image' 
                                        class='card-img-top img-fluid' 
                                        style='width: 250px; height: 300px; object-fit: cover; align-self: center;'>
                                    <div class='card-body'>
                                        <h6 class='card-title'>${product.name}</h6>
                                        <p class='card-text'>$${product.price}</p>
                                        <div>Rating: ${product.average_rating || 0}</div>
                                        <p class='card-text'>Category: ${product.category}</p>
                                        <a href='<?php echo URL::to('public/ProductSite/productdetail?id='); ?>${product.id}' 
                                           class='btn btn-custom' 
                                           style='background-color: #f98850;'>Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        productList.insertAdjacentHTML('beforeend', productCard);
                    });
                } else {
                    productList.innerHTML = '<p>No products found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                productList.innerHTML = '<p>Error fetching products. Please try again later.</p>';
            });
    });
});

function searchProducts() {
    const desktopSearchInput = document.getElementById('searchInput')?.value.toLowerCase().trim() || '';
    const mobileSearchInput = document.getElementById('searchInputMobile')?.value.toLowerCase().trim() || '';
    const searchInput = desktopSearchInput || mobileSearchInput;

    const productList = document.getElementById('productList');
    const products = Array.from(productList.getElementsByClassName('product-card'));

    products.forEach(product => {
        const productName = product.getAttribute('data-name').toLowerCase();
        if (productName.includes(searchInput)) {
            product.parentElement.style.display = ''; // Show product
        } else {
            product.parentElement.style.display = 'none'; // Hide product
        }
    });
}

// Add event listener to the search input
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', searchProducts);
});
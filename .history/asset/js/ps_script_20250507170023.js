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
                    data-category='${category}'>
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




function filterByCategory() {
    const selectedCategories = Array.from(document.querySelectorAll('#categoryContainer .form-check-input:checked'))
        .map(checkbox => checkbox.value.toLowerCase());

    const productList = document.getElementById('productList');
    const products = Array.from(productList.getElementsByClassName('product-card'));

    products.forEach(product => {
        const productCategory = product.dataset.category.toLowerCase();
        if (selectedCategories.length === 0 || selectedCategories.includes(productCategory)) {
            product.parentElement.style.display = ''; // Show product
        } else {
            product.parentElement.style.display = 'none'; // Hide product
        }
    });
    // Update the sort order after filtering
    
}

document.addEventListener('DOMContentLoaded', () => {
    function fetchFilteredProducts() {
        const selectedCategories = Array.from(document.querySelectorAll('#categoryContainer .form-check-input:checked')).map(input => input.value);
        const selectedBrands = Array.from(document.querySelectorAll('#brandContainer .form-check-input:checked')).map(input => input.value);
        const selectedSizes = Array.from(document.querySelectorAll('#sizeContainer .form-check-input:checked')).map(input => input.value);

        // Prepare the query parameters
        const params = new URLSearchParams();
        if (selectedCategories.length > 0) params.append('category', selectedCategories.join(','));
        if (selectedBrands.length > 0) params.append('brand_id', selectedBrands.join(','));
        if (selectedSizes.length > 0) params.append('size', selectedSizes.join(','));

        // Send AJAX request
        fetch(`/Shop-badminton/AssignmentWeb/app/controllers/fetch_products.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                // Update the product list
                const productList = document.getElementById('productList');
                productList.innerHTML = '';

                if (data.products && data.products.length > 0) {
                    data.products.forEach(product => {
                        const productCard = `
                            <div class="col-6 col-md-4 col-lg-3 mb-4">
                                <div class="product-card card h-100">
                                    <img src="${product.image_path || '/Shop-badminton/AssignmentWeb/app/uploads/placeholder.jpg'}" alt="Product Image" class="card-img-top img-fluid" style="width: 250px; height: 300px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title">${product.name}</h6>
                                        <p class="card-text">$${product.price}</p>
                                        <p class="card-text">Category: ${product.category}</p>
                                        <a href="/Shop-badminton/AssignmentWeb/public/ProductSite/productdetail?id=${product.id}" class="btn btn-custom" style="background-color: #f98850;">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        productList.innerHTML += productCard;
                    });
                } else {
                    productList.innerHTML = '<p>No products available.</p>';
                }
            })
            .catch(error => console.error('Error fetching products:', error));
    }

    // Add event listeners to checkboxes
    document.querySelectorAll('.form-check-input').forEach(input => {
        input.addEventListener('change', fetchFilteredProducts);
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
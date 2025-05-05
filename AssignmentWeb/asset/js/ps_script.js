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
                        <div>Rating: ${starsHTML} (${rating.toFixed(1)})</div>
                        <p class='card-text'>Category: ${category}</p>
                        <a href='/Shop-badminton/AssignmentWeb/app/views/product_site/product_detail.php?id=${id}' class='btn btn-custom'>Buy Now</a>
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
    const categoryCheckboxes = document.querySelectorAll('#categoryContainer .form-check-input');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterByCategory);
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
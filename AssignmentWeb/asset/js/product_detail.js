function changeMainImage(thumbnail) {
    const largeImage = document.getElementById('largeImage');
    largeImage.src = thumbnail.src;

    // Highlight the active thumbnail
    document.querySelectorAll('.thumbnail-image').forEach(img => img.classList.remove('active'));
    thumbnail.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#starRating .star');
    const starsInput = document.getElementById('stars');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-value');
            starsInput.value = rating;

            // Update star visuals
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill', 'text-warning');
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning');
                    s.classList.add('bi-star');
                }
            });
        });
    });
});
document.querySelectorAll('.thumbnail-image').forEach((thumbnail) => {
    thumbnail.addEventListener('click', function () {
        const largeImage = document.getElementById('largeImage');
        largeImage.src = this.src; // Update the large image source
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const imageDataElement = document.getElementById('imageData');
    const images = JSON.parse(imageDataElement.getAttribute('data-images')); // Parse the JSON string
    let currentIndex = 0;

    function updateThumbnails() {
        const thumbnailRow = document.getElementById('thumbnailRow');
        thumbnailRow.innerHTML = '';
        for (let i = currentIndex; i < currentIndex + 4; i++) {
            if (i < images.length) {
                const col = document.createElement('div');
                col.className = 'col-3';
                const imgElement = document.createElement('img');
                imgElement.src = '/Shop-badminton/AssignmentWeb/app/' + images[i % images.length];
                imgElement.className = 'thumbnail-image'; // Apply the CSS class
                imgElement.alt = `Thumbnail ${i + 1}`;
                imgElement.addEventListener('click', () => {
                    document.getElementById('largeImage').src = '/Shop-badminton/AssignmentWeb/app/' + images[i % images.length];
                });
                col.appendChild(imgElement);
                thumbnailRow.appendChild(col);
            }
        }

        // Automatically update the large image to the first thumbnail in the current view
        document.getElementById('largeImage').src = '/Shop-badminton/AssignmentWeb/app/' + images[currentIndex % images.length];
    }

    document.getElementById('nextBtn').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateThumbnails();
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateThumbnails();
    });

    // Initialize thumbnails and large image on page load
    updateThumbnails();
});

document.addEventListener('DOMContentLoaded', function () {
    const reviewsPerPage = 3; // Number of reviews per page
    const reviews = document.querySelectorAll('.review-card');
    const paginationContainer = document.querySelector('#reviewPagination .pagination');

    function showPage(page) {
        const start = (page - 1) * reviewsPerPage;
        const end = start + reviewsPerPage;

        reviews.forEach((review, index) => {
            review.style.display = index >= start && index < end ? 'block' : 'none';
        });
    }

    function createPagination() {
        const totalPages = Math.ceil(reviews.length / reviewsPerPage);
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item';
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', (e) => {
                e.preventDefault();
                showPage(i);
                document.querySelectorAll('.page-item').forEach(item => item.classList.remove('active'));
                li.classList.add('active');
            });
            paginationContainer.appendChild(li);
        }

        // Set the first page as active
        if (paginationContainer.firstChild) {
            paginationContainer.firstChild.classList.add('active');
        }
    }

    // Initialize pagination
    if (reviews.length > 0) {
        createPagination();
        showPage(1);
    }
});
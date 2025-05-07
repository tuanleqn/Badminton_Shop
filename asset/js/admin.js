document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.update-status-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior

            const reviewId = this.dataset.id;
            const status = this.dataset.status;

            // Send AJAX request
            fetch('/Shop-badminton/AssignmentWeb/app/controllers/product/submit_review.php', {
method: 'POST',
headers: {
    'Content-Type': 'application/json',
},
body: JSON.stringify({ id: reviewId, status: status }),
})
.then(response => {
    console.log('Raw Response:', response); // Log the raw response
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
})
.then(data => {
    console.log('Parsed Response:', data); // Log the parsed JSON response
    if (data.success) {
        // Update the status in the table
        const statusCell = document.querySelector(`#review-status-${reviewId}`);
        statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);

        alert(data.message); // Show success message
    } else {
        alert(data.message); // Show error message
    }
})
.catch(error => {
    console.error('Error occurred:', error); // Log the full error
    alert('An error occurred while updating the review status. Please try again.');
});
        });
    });
});


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Table - Admin Dashboard</title>
    
    <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/compiled/svg/favicon.svg'); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable-jquery.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
</head>

<body>
    <div id="app">
        <?php require_once 'components/sidebar.php'; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Customer Responses</h3>
                            <p class="text-subtitle text-muted">View and manage customer feedback and inquiries</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo URL::to('public/admin/index'); ?>">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Responses</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Response List
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Content</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['responses'] as $response): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($response['firstName']); ?></td>
                                            <td><?php echo htmlspecialchars($response['lastName']); ?></td>
                                            <td><?php echo htmlspecialchars($response['email']); ?></td>
                                            <td><?php echo htmlspecialchars($response['content']); ?></td>
                                            <td><?php echo htmlspecialchars($response['createdAt']); ?></td>
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <?php if ($response['status'] == 'unread'): ?>
                                                            <button class="btn btn-danger dropdown-toggle me-1" type="button"
                                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <?php echo htmlspecialchars($response['status']); ?>
                                                        </button>
                                                        <?php elseif ($response['status'] == 'read'): ?>
                                                            <button class="btn btn-secondary dropdown-toggle me-1" type="button"
                                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <?php echo htmlspecialchars($response['status']); ?>
                                                        </button>
                                                        <?php else: ?>
                                                            <button class="btn btn-success dropdown-toggle me-1" type="button"
                                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <?php echo htmlspecialchars($response['status']); ?>
                                                        </button>
                                                        <?php endif; ?>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                            <a href="#" class="dropdown-item status-item" data-response-id="<?php echo $response['id']; ?>" data-status="read">read</a>
                                                            <a href="#" class="dropdown-item status-item" data-response-id="<?php echo $response['id']; ?>" data-status="unread">unread</a>
                                                            <a href="#" class="dropdown-item status-item" data-response-id="<?php echo $response['id']; ?>" data-status="responsed">responsed</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <button class="btn btn-danger delete-response" 
                                                            data-response-id="<?php echo $response['id']; ?>"
                                                            title="Delete Response">
                                                        <i class="bi bi-trash"></i> 
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; VNB Admin</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/pages/datatables.js'); ?>"></script>
    <!-- Add SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/extensions/sweetalert2/sweetalert2.min.css'); ?>">
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('.status-item').on('click', function(e) {
                e.preventDefault();
                const responseId = $(this).data('response-id');
                const newStatus = $(this).data('status');
                const button = $(this).closest('.dropdown').find('button');

                $.ajax({
                    url: '<?php echo URL::to("public/admin/response"); ?>',
                    type: 'POST',
                    data: {
                        id: responseId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update button color and text
                            button.text(newStatus);
                            button.removeClass('btn-danger btn-secondary btn-warning');
                            if (newStatus === 'unread') {
                                button.addClass('btn-danger');
                            } else if (newStatus === 'read') {
                                button.addClass('btn-secondary');
                            } else {
                                button.addClass('btn-warning');
                            }
                        }
                    },
                    error: function() {
                        alert('Failed to update status. Please try again.');
                    }
                });
            });
            $('.delete-response').on('click', function(e) {
                e.preventDefault();
                const responseId = $(this).data('response-id');
                const row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this response? This action cannot be undone.')) {
                    $.ajax({
                        url: '<?php echo URL::to("public/admin/response"); ?>',
                        type: 'DELETE',
                        contentType: 'application/json',
                        data: JSON.stringify({ id: responseId }),
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Response deleted successfully'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to delete response'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete response. Please try again.'
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
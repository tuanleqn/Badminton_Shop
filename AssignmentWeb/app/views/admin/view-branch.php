<?php 
require_once '../app/helper/URL.php';
require_once '../app/helper/session.php';
$session = Session::getInstance();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Branch</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable-jquery.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>">
    <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/static/images/logo/favicon.svg'); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/static/images/logo/favicon.png'); ?>" type="image/png">
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
            <div class="page-heading email-application">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Branch edit</h3>
                            <p class="text-subtitle text-muted">Modify branch address</p>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <?php if ($session->get('message')): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo $session->get('message');
                            $session->remove('message');
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($session->get('error')): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $session->get('error');
                            $session->remove('error');
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                Branch list
                            </h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                                Add Branch
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>View</th>
                                            <th>Delete</th> 
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($branches && is_array($branches)): ?>
                                        <?php foreach ($branches as $branch): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($branch['name']); ?></td>
                                                <td><?php echo htmlspecialchars($branch['address']); ?></td>
                                                <td>
                                                <span><button type="button" class="btn btn-outline-primary block" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#default"
                                                    data-branch-name="<?php echo htmlspecialchars($branch['name']); ?>"
                                                    data-branch-address="<?php echo htmlspecialchars($branch['address']); ?>">
                                                    View
                                                </button>
                                                </span>
                                                </td>
                                                <td>
                                                <span> <button type="button" class="btn btn-outline-danger block delete-branch"
                                                    data-branch-id="<?php echo htmlspecialchars($branch['id']); ?>">
                                                    Delete
                                                </button></span>
                                                </td>
                                                <td>
                                                <span><button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#inlineForm"
                                                        data-branch-id ="<?php echo htmlspecialchars($branch['id']); ?>"
                                                        data-branch-name="<?php echo htmlspecialchars($branch['name']); ?>"
                                                        data-branch-address="<?php echo htmlspecialchars($branch['address']); ?>">
                                                        Edit</button>
                                                </span>
                                                </td>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center">No branches found</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Add Branch Modal -->
                <div class="modal fade text-left" id="addBranchModal" tabindex="-1" role="dialog"
                    aria-labelledby="addBranchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addBranchModalLabel">Add New Branch</h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="<?php echo URL::to('public/admin/viewBranch'); ?>" method="POST">
                                <div class="modal-body">
                                    <label for="new-branch-name">Branch Name: </label>
                                    <div class="form-group">
                                        <input id="new-branch-name" name="branchName" type="text" 
                                            placeholder="Enter Branch Name" class="form-control" required>
                                    </div>
                                    <label for="new-branch-address">Branch Address: </label>
                                    <div class="form-group">
                                        <input id="new-branch-address" name="branchAddress" type="text" 
                                            placeholder="Enter Branch Address" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="action" value="add">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ms-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Add Branch</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left" id="default" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel1">Branch Details</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="branch-name">Branch Name:</label>
                                            <p id="modal-branch-name" class="form-control-static"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="branch-address">Branch Address:</label>
                                            <p id="modal-branch-address" class="form-control-static"></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">Edit branch information</h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form action="<?php echo URL::to('public/admin/viewBranch'); ?>" method="POST">
                                                <div class="modal-body">
                                                    <label for="branch-id-edit">Branch id: </label>
                                                    <div class="form-group">
                                                        <input id="branch-id-edit" name="branchid" type="text" placeholder="Branch id"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <label for="branch-name-edit">Branch Name: </label>
                                                    <div class="form-group">
                                                        <input id="branch-name-edit" name="branchName" type="text" placeholder="Branch Name"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <label for="branch-address-edit">Branch Address: </label>
                                                    <div class="form-group">
                                                        <input id="branch-address-edit" name="branchAddress" type="text" placeholder="Branch Address"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-primary ms-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Update</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
        </div>
    </div>
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/pages/datatables.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('default');
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const branchName = button.getAttribute('data-branch-name');
                const branchAddress = button.getAttribute('data-branch-address');
                document.getElementById('modal-branch-name').textContent = branchName;
                document.getElementById('modal-branch-address').textContent = branchAddress;
            });

            // Add handler for edit modal
            const editModal = document.getElementById('inlineForm');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const branchId = button.getAttribute('data-branch-id');
                const branchName = button.getAttribute('data-branch-name');
                const branchAddress = button.getAttribute('data-branch-address');
                document.getElementById('branch-id-edit').value = branchId;
                document.getElementById('branch-name-edit').value = branchName;
                document.getElementById('branch-address-edit').value = branchAddress;
            });
        });
        $(document).ready(function() {
            $('.delete-branch').on('click', function() {
                const branchId = $(this).data('branch-id');

                if (confirm('Are you sure you want to delete this branch?')) {
                    $.ajax({
                        url: '<?php echo URL::to("public/admin/viewBranch"); ?>',
                        type: 'DELETE',
                        contentType: 'application/json',
                        data: JSON.stringify({ id: branchId }),
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Error: ' + (response.message || 'Failed to delete branch'));
                            }
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Error deleting branch';
                            try {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                console.error('Failed to parse error response:', xhr.responseText);
                            }
                            alert(errorMessage);
                        }
                    });
                }
            });
        });

    </script>
</body>
</html>

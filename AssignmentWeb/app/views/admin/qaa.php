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
  <title>Manage Q&A Content</title>
  <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
  <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
  <link rel="stylesheet"
    href="<?php echo URL::to('app/views/admin/assets/compiled/css/table-datatable-jquery.css'); ?>">
  <link rel="stylesheet"
    href="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>">
  <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/static/images/logo/favicon.svg'); ?>"
    type="image/x-icon">
  <link rel="shortcut icon" href="<?php echo URL::to('app/views/admin/assets/static/images/logo/favicon.png'); ?>"
    type="image/png">
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
              <h3>Q&A Management</h3>
              <p class="text-subtitle text-muted">Manage questions and answers</p>
            </div>
          </div>
        </div>

        <section class="section">
          <?php if ($session->get('message')): ?>
            <div class="alert alert-success">
              <?php echo $session->get('message');
              $session->remove('message'); ?>
            </div>
          <?php endif; ?>

          <?php if ($session->get('error')): ?>
            <div class="alert alert-danger">
              <?php echo $session->get('error');
              $session->remove('error'); ?>
            </div>
          <?php endif; ?>

          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="card-title">List of Q&A</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQaaModal">
                Add New
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="table1">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Question</th>
                      <th>Answer</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Order</th>
                      <th>View</th>
                      <th>Delete</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($qaas) && is_array($qaas)): ?>
                      <?php foreach ($qaas as $qaa): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($qaa['category']); ?></td>
                          <td><?php echo htmlspecialchars(substr($qaa['question'], 0, 50)) . '...'; ?></td>
                          <td><?php echo htmlspecialchars(substr($qaa['answer'], 0, 50)) . '...'; ?></td>
                          <td><?php echo htmlspecialchars($qaa['name']); ?></td>
                          <td><?php echo htmlspecialchars($qaa['email']); ?></td>
                          <td><?php echo htmlspecialchars($qaa['phone']); ?></td>
                          <td><?php echo htmlspecialchars($qaa['displayOrder']); ?></td>
                          <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                              data-bs-target="#viewModal" data-category="<?php echo htmlspecialchars($qaa['category']); ?>"
                              data-question="<?php echo htmlspecialchars($qaa['question']); ?>"
                              data-answer="<?php echo htmlspecialchars($qaa['answer']); ?>"
                              data-name="<?php echo htmlspecialchars($qaa['name']); ?>"
                              data-email="<?php echo htmlspecialchars($qaa['email']); ?>"
                              data-phone="<?php echo htmlspecialchars($qaa['phone']); ?>"
                              data-order="<?php echo htmlspecialchars($qaa['displayOrder']); ?>">
                              View
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-outline-danger delete-qaa"
                              data-qaa-id="<?php echo $qaa['id']; ?>">
                              Delete
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                              data-bs-target="#editModal" data-id="<?php echo $qaa['id']; ?>"
                              data-category="<?php echo htmlspecialchars($qaa['category']); ?>"
                              data-question="<?php echo htmlspecialchars($qaa['question']); ?>"
                              data-answer="<?php echo htmlspecialchars($qaa['answer']); ?>"
                              data-name="<?php echo htmlspecialchars($qaa['name']); ?>"
                              data-email="<?php echo htmlspecialchars($qaa['email']); ?>"
                              data-phone="<?php echo htmlspecialchars($qaa['phone']); ?>"
                              data-order="<?php echo htmlspecialchars($qaa['displayOrder']); ?>">
                              Edit
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="10" class="text-center">No Q&A entries found</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>

        <!-- Add Q&A Modal -->
        <div class="modal fade" id="addQaaModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add New Q&A</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?php echo URL::to('public/admin/qaa'); ?>" method="POST">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Category</label>
                      <input name="category" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Display Order</label>
                      <input name="displayOrder" type="number" class="form-control" value="1" min="1">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Question</label>
                    <textarea name="question" rows="3" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Answer</label>
                    <textarea name="answer" rows="4" class="form-control" required></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Name</label>
                      <input name="name" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Email</label>
                      <input name="email" type="email" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Phone</label>
                      <input name="phone" type="text" class="form-control" required>
                    </div>
                  </div>
                  <input type="hidden" name="action" value="add">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Q&A Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <p><strong>Category:</strong> <span id="view-category"></span></p>
                  </div>
                  <div class="col-md-6">
                    <p><strong>Display Order:</strong> <span id="view-order"></span></p>
                  </div>
                </div>
                <div class="mb-3">
                  <p><strong>Question:</strong></p>
                  <p id="view-question" class="p-2 bg-light rounded"></p>
                </div>
                <div class="mb-3">
                  <p><strong>Answer:</strong></p>
                  <p id="view-answer" class="p-2 bg-light rounded"></p>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <p><strong>Name:</strong> <span id="view-name"></span></p>
                  </div>
                  <div class="col-md-4">
                    <p><strong>Email:</strong> <span id="view-email"></span></p>
                  </div>
                  <div class="col-md-4">
                    <p><strong>Phone:</strong> <span id="view-phone"></span></p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Q&A</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?php echo URL::to('public/admin/qaa'); ?>" method="POST">
                <div class="modal-body">
                  <input type="hidden" name="id" id="edit-id">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Category</label>
                      <input name="category" id="edit-category" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Display Order</label>
                      <input name="displayOrder" id="edit-order" type="number" class="form-control" min="1">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Question</label>
                    <textarea name="question" id="edit-question" rows="3" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Answer</label>
                    <textarea name="answer" id="edit-answer" rows="4" class="form-control" required></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Name</label>
                      <input name="name" id="edit-name" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Email</label>
                      <input name="email" id="edit-email" type="email" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Phone</label>
                      <input name="phone" id="edit-phone" type="text" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
  <script src="<?php echo URL::to('app/views/admin/assets/extensions/jquery/jquery.min.js'); ?>"></script>
  <script
    src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
  <script
    src="<?php echo URL::to('app/views/admin/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
  <script>
    $(document).ready(function () {
      $('#table1').DataTable();

      // View modal
      $('#viewModal').on('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        $('#view-category').text(btn.getAttribute('data-category'));
        $('#view-question').text(btn.getAttribute('data-question'));
        $('#view-answer').text(btn.getAttribute('data-answer'));
        $('#view-name').text(btn.getAttribute('data-name'));
        $('#view-email').text(btn.getAttribute('data-email'));
        $('#view-phone').text(btn.getAttribute('data-phone'));
        $('#view-order').text(btn.getAttribute('data-order'));
      });

      // Edit modal
      $('#editModal').on('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        $('#edit-id').val(btn.getAttribute('data-id'));
        $('#edit-category').val(btn.getAttribute('data-category'));
        $('#edit-question').val(btn.getAttribute('data-question'));
        $('#edit-answer').val(btn.getAttribute('data-answer'));
        $('#edit-name').val(btn.getAttribute('data-name'));
        $('#edit-email').val(btn.getAttribute('data-email'));
        $('#edit-phone').val(btn.getAttribute('data-phone'));
        $('#edit-order').val(btn.getAttribute('data-order'));
      });

      // Delete action
      $('.delete-qaa').on('click', function () {
        const id = $(this).data('qaa-id');
        if (confirm('Are you sure you want to delete this Q&A?')) {
          $.ajax({
            url: '<?php echo URL::to("public/admin/qaa"); ?>',
            type: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({ id }),
            success: function (res) {
              if (res.success) {
                location.reload();
              } else {
                alert('Error deleting Q&A');
              }
            },
            error: function (xhr) {
              let msg = 'Error deleting Q&A';
              try {
                msg = JSON.parse(xhr.responseText).message;
              } catch (e) { };
              alert(msg);
            }
          });
        }
      });
    });
  </script>
</body>

</html>
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
  <title>Manage Introduction Content</title>
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
              <h3>Introduction Content</h3>
              <p class="text-subtitle text-muted">Manage introduction sections</p>
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
              <h5 class="card-title">List of Introductions</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIntroduceModal">
                Add New
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="table1">
                  <thead>
                    <tr>
                      <th>Section</th>
                      <th>Content</th>
                      <th>Note</th>
                      <th>View</th>
                      <th>Delete</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($introduces) && is_array($introduces)): ?>
                      <?php foreach ($introduces as $intro): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($intro['section']); ?></td>
                          <td><?php echo htmlspecialchars(substr($intro['content'], 0, 50)) . '...'; ?></td>
                          <td><?php echo htmlspecialchars($intro['note']); ?></td>
                          <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                              data-bs-target="#viewModal" data-section="<?php echo htmlspecialchars($intro['section']); ?>"
                              data-content="<?php echo htmlspecialchars($intro['content']); ?>"
                              data-note="<?php echo htmlspecialchars($intro['note']); ?>">
                              View
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-outline-danger delete-intro"
                              data-intro-id="<?php echo $intro['id']; ?>">
                              Delete
                            </button>
                          </td>
                          <td>
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                              data-bs-target="#editModal" data-id="<?php echo $intro['id']; ?>"
                              data-section="<?php echo htmlspecialchars($intro['section']); ?>"
                              data-content="<?php echo htmlspecialchars($intro['content']); ?>"
                              data-note="<?php echo htmlspecialchars($intro['note']); ?>">
                              Edit
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="text-center">No introductions found</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>

        <!-- Add Introduce Modal -->
        <div class="modal fade" id="addIntroduceModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add New Introduction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?php echo URL::to('public/admin/introduce'); ?>" method="POST">
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Section</label>
                    <input name="section" type="text" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="4" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Note</label>
                    <input name="note" type="text" class="form-control">
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
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Introduction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>Section:</strong> <span id="view-section"></span></p>
                <p><strong>Content:</strong></p>
                <p id="view-content"></p>
                <p><strong>Note:</strong> <span id="view-note"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Introduction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?php echo URL::to('public/admin/introduce'); ?>" method="POST">
                <div class="modal-body">
                  <input type="hidden" name="id" id="edit-id">
                  <div class="mb-3">
                    <label class="form-label">Section</label>
                    <input name="section" id="edit-section" type="text" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="edit-content" rows="4" class="form-control" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Note</label>
                    <input name="note" id="edit-note" type="text" class="form-control">
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
        $('#view-section').text(btn.getAttribute('data-section'));
        $('#view-content').text(btn.getAttribute('data-content'));
        $('#view-note').text(btn.getAttribute('data-note'));
      });

      // Edit modal
      $('#editModal').on('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        $('#edit-id').val(btn.getAttribute('data-id'));
        $('#edit-section').val(btn.getAttribute('data-section'));
        $('#edit-content').val(btn.getAttribute('data-content'));
        $('#edit-note').val(btn.getAttribute('data-note'));
      });

      // Delete action
      $('.delete-intro').on('click', function () {
        const id = $(this).data('intro-id');
        if (confirm('Are you sure you want to delete this item?')) {
          $.ajax({
            url: '<?php echo URL::to("public/admin/introduce"); ?>',
            type: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({ id }),
            success: function (res) { location.reload(); },
            error: function (xhr) {
              let msg = 'Error deleting item';
              try { msg = JSON.parse(xhr.responseText).message; } catch { };
              alert(msg);
            }
          });
        }
      });
    });
  </script>
</body>

</html>
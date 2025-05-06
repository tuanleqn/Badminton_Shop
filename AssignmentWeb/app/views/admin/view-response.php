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
    <title>View response</title>
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/app-dark.css'); ?>">
    <!-- <link rel="stylesheet" href="<?php echo URL::to('app/views/admin/assets/compiled/css/email.css'); ?>"> -->
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
                            <h3>Email Application</h3>
                            <p class="text-subtitle text-muted">Read and compose emails</p>
                        </div>
                    </div>
                </div>

                <section class="section content-area-wrapper">
                    <div class="row">
                        <!-- Email List -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Email Toolbar -->
                                    <div class="email-toolbar mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-3">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </div>
                                                <button class="btn btn-light me-2"><i class="bi bi-trash"></i></button>
                                                <button class="btn btn-light me-2"><i class="bi bi-envelope"></i></button>
                                                <button class="btn btn-light"><i class="bi bi-folder"></i></button>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search mail...">
                                                    <button class="btn btn-light"><i class="bi bi-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email List -->
                                    <div class="email-list">
                                        <?php foreach ($responses as $response): ?>
                                        <div class="email-item d-flex align-items-center p-3 border-bottom" 
                                             data-id="<?php echo $response['id']; ?>"
                                             style="cursor: pointer;">
                                            <div class="form-check me-3" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="form-check-input" value="<?php echo $response['id']; ?>">
                                            </div>
                                            <div class="avatar me-3">
                                                <img src="<?php echo URL::to('app/views/admin/assets/static/images/faces/1.jpg'); ?>" alt="avatar">
                                            </div>
                                            <div class="email-content flex-grow-1">
                                                <div class="d-md-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 me-2"><?php echo htmlspecialchars($response['firstName'] . ' ' . $response['lastName']); ?></h6>
                                                    <div class="d-flex align-items-center email-meta">
                                                        <span class="badge bg-<?php 
                                                            echo $response['status'] === 'read' ? 'success' : 
                                                                ($response['status'] === 'unread' ? 'warning' : 'info'); 
                                                        ?>"><?php echo ucfirst($response['status']); ?></span>
                                                        <small class="ms-2 text-nowrap"><?php echo date('d M Y H:i', strtotime($response['createdAt'])); ?></small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column" style="overflow: hidden;">
                                                    <span class="text-muted text-truncate mb-1"><?php echo htmlspecialchars($response['email']); ?></span>
                                                    <p class="text-muted mb-0 text-truncate"><?php echo htmlspecialchars(substr($response['content'], 0, 100)) . '...'; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Response Detail Modal -->
                                    <div class="modal fade" id="responseDetailModal" tabindex="-1" 
                                         role="dialog" 
                                         aria-labelledby="responseDetailModalTitle"
                                         aria-modal="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responseDetailModalTitle">Response Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalCloseButton"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card border-0">
                                                        <div class="card-body p-0">
                                                            <div class="response-header mb-3">
                                                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2">
                                                                    <div class="mb-2 mb-md-0">
                                                                        <h6 class="response-name fw-bold mb-1"></h6>
                                                                        <p class="response-email text-muted mb-0"></p>
                                                                    </div>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="response-status badge me-2"></span>
                                                                        <small class="response-date text-muted"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="response-content border-top pt-3"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary reply-btn" onclick="showComposeReply()">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Pagination -->
                                    <div class="email-pagination d-flex justify-content-between align-items-center mt-4">
                                        <span>Showing <?php echo count($responses); ?> responses</span>
                                        <div>
                                            <button class="btn btn-light me-2"><i class="bi bi-chevron-left"></i></button>
                                            <button class="btn btn-light"><i class="bi bi-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Compose Modal -->
            <div class="modal fade" id="composeModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Compose Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">To</label>
                                    <input type="email" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Subject</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="6" placeholder="Type your message here..."></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="emailAttach">
                                        <label class="custom-file-label" for="emailAttach">Attach File</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Compose Sidebar -->
            <div class="compose-new-mail-sidebar ps">
                <div class="card shadow-none quill-wrapper p-0">
                    <div class="card-header">
                        <h3 class="card-title" id="emailCompose">New Message</h3>
                        <button type="button" class="close close-icon email-compose-new-close-btn">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <!-- form start -->
                    <form action="#" id="compose-form">
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div class="form-group pb-50">
                                    <label for="emailfrom">from</label>
                                    <input type="text" id="emailfrom" class="form-control"
                                        placeholder="<?php echo ($session->get('user')['email']) ? $session->get('user')['email'] : ''; ?>" disabled>
                                </div>
                                <div class="form-label-group">
                                    <label for="emailTo">To</label>
                                    <input type="email" id="emailTo" class="form-control" placeholder="To"
                                        required>
                                </div>
                                <div class="form-label-group">
                                    <label for="emailSubject">Subject</label>
                                    <input type="text" id="emailSubject" class="form-control" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="6" placeholder="Type your message here..."></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="emailAttach">
                                        <label class="custom-file-label" for="emailAttach">Attach File</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end pt-0">
                            <button type="reset" class="btn btn-light-secondary cancel-btn me-1">
                                <i class="bi bi-x me-3"></i>
                                <span class="d-sm-inline d-none">Cancel</span>
                            </button>
                            <button type="submit" class="btn-send btn btn-primary">
                                <i class="bi bi-send me-3"></i> <span class="d-sm-inline d-none">Send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/static/js/components/dark.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?php echo URL::to('app/views/admin/assets/compiled/js/app.js'); ?>"></script>
    <script>
        let currentResponseId = null;

        // Initialize Bootstrap modal
        const responseModal = document.getElementById('responseDetailModal');
        
        // Update response details and show modal
        function fetchResponseDetails(id) {
            currentResponseId = id;
            
            // First fetch the response details
            fetch(`<?php echo URL::to('public/admin/response/'); ?>/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const response = data.response;
                        
                        // If status is unread, update it to read
                        if (response.status === 'unread') {
                            updateStatus(id, 'read', document.querySelector(`[data-id="${id}"] .dropdown`))
                                .then(() => {
                                    // Update the badge in the list view
                                    const listBadge = document.querySelector(`[data-id="${id}"] .badge`);
                                    if (listBadge) {
                                        listBadge.className = 'badge bg-success';
                                        listBadge.textContent = 'read';
                                    }
                                });
                        }
                        
                        document.querySelector('.response-name').textContent = `${response.firstName} ${response.lastName}`;
                        document.querySelector('.response-email').textContent = response.email;
                        document.querySelector('.response-date').textContent = new Date(response.createdAt).toLocaleString();
                        document.querySelector('.response-content').textContent = response.content;
                        
                        // Update status button in modal
                        const statusBtn = document.querySelector('.response-status');
                        statusBtn.innerHTML = `<span class="badge bg-${
                            response.status === 'read' ? 'success' : 
                            (response.status === 'unread' ? 'warning' : 'info')
                        }">${response.status === 'unread' ? 'read' : response.status}</span>`;
                        
                        // Show modal using Bootstrap's API
                        const modal = new bootstrap.Modal(responseModal);
                        modal.show();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateStatus(id, status, element) {
            return fetch('<?php echo URL::to('public/admin/response'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id, status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && element) {
                    // Update UI
                    const badge = element.querySelector('.badge');
                    if (badge) {
                        badge.className = `badge bg-${
                            status === 'read' ? 'success' : 
                            (status === 'unread' ? 'warning' : 'info')
                        }`;
                        badge.textContent = status;
                    }
                }
                return data;
            })
            .catch(error => {
                console.error('Error:', error);
                return { success: false, error };
            });
        }

        function showComposeReply() {
            const replyTo = document.querySelector('.response-email').textContent;
            const replyName = document.querySelector('.response-name').textContent;
            
            // Fill compose form with reply details
            document.getElementById('emailTo').value = replyTo;
            document.getElementById('emailSubject').value = 'Re: Response from ' + replyName;
            
            // Show compose form
            document.querySelector('.compose-new-mail-sidebar').classList.add('show');
            
            // Set current response ID for status update after sending
            document.getElementById('compose-form').setAttribute('data-response-id', currentResponseId);
            
            // Hide response modal
            const modal = bootstrap.Modal.getInstance(responseModal);
            modal.hide();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle compose button click

            // Handle close button click
            document.querySelector('.email-compose-new-close-btn').addEventListener('click', function() {
                document.querySelector('.compose-new-mail-sidebar').classList.remove('show');
            });

            // Handle cancel button click
            document.querySelector('.cancel-btn').addEventListener('click', function() {
                document.querySelector('.compose-new-mail-sidebar').classList.remove('show');
            });

            // Handle form submission
            document.getElementById('compose-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const emailData = {
                    to: document.getElementById('emailTo').value,
                    subject: document.getElementById('emailSubject').value,
                    message: document.querySelector('#compose-form textarea').value,
                    responseId: this.getAttribute('data-response-id')
                };

                // Send email using fetch API
                fetch('<?php echo URL::to('public/admin/sendMail'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(emailData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI to show email was sent
                        alert('Email sent successfully!');
                        document.querySelector('.compose-new-mail-sidebar').classList.remove('show');
                        
                        // Reset form
                        this.reset();
                        
                        // Update response status in the list if needed
                        if (emailData.responseId) {
                            const responseItem = document.querySelector(`.email-item[data-id="${emailData.responseId}"]`);
                            if (responseItem) {
                                const badge = responseItem.querySelector('.badge');
                                badge.className = 'badge bg-info';
                                badge.textContent = 'responsed';
                            }
                        }
                    } else {
                        alert('Failed to send email: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while sending the email');
                });
            });

            // Handle email item click
            document.querySelectorAll('.email-item').forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetchResponseDetails(id);
                });
            });

            // Handle status update
            document.querySelectorAll('.status-update').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const status = this.getAttribute('data-status');
                    updateStatus(id, status, this);
                });
            });

            // Handle status update in modal
            document.querySelectorAll('.status-update-modal').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const status = this.getAttribute('data-status');
                    if (currentResponseId) {
                        updateStatus(currentResponseId, status, this);
                    }
                });
            });

            // Safely add sidebar toggle handlers
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebarCloseIcon = document.querySelector('.sidebar-close-icon');
            const emailAppSidebar = document.querySelector('.email-app-sidebar');

            if (sidebarToggle && emailAppSidebar) {
                sidebarToggle.addEventListener('click', () => {
                    emailAppSidebar.classList.toggle('show');
                });
            }

            if (sidebarCloseIcon && emailAppSidebar) {
                sidebarCloseIcon.addEventListener('click', () => {
                    emailAppSidebar.classList.remove('show');
                });
            }
        });
    </script>
    <style>
        .compose-new-mail-sidebar {
            position: fixed;
            right: -400px;
            top: 0;
            width: 400px;
            height: 100vh;
            background: #1b1b1b;
            z-index: 1050;
            transition: all 0.3s ease;
            box-shadow: -8px 0 18px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            color: #fff;
        }

        .compose-new-mail-sidebar.show {
            right: 0;
        }

        .compose-new-mail-sidebar .card {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: transparent;
            border: none;
        }

        .compose-new-mail-sidebar .card-content {
            flex: 1;
            overflow-y: auto;
            padding: 0;
            min-height: 0; /* This is important for flex child scrolling */
        }

        .compose-new-mail-sidebar .card-body {
            padding: 1rem;
            overflow-y: auto;
            background: #1b1b1b;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .compose-new-mail-sidebar .form-group {
            margin-bottom: 0; /* Remove default margin since we're using gap */
        }

        .compose-new-mail-sidebar textarea.form-control {
            flex: 1;
            min-height: 200px;
            resize: none; /* Prevent manual resizing since it will fill available space */
            background: #2a2a2a;
            border: 1px solid #333;
            color: #fff;
        }

        .compose-new-mail-sidebar .card-header {
            padding: 1rem;
            background: #2a2a2a;
            border-bottom: 1px solid #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1;
            color: #fff;
        }

        .compose-new-mail-sidebar .card-footer {
            padding: 1rem;
            background: #2a2a2a;
            border-top: 1px solid #333;
            position: sticky;
            bottom: 0;
            z-index: 1;
        }

        @media screen and (max-width: 576px) {
            .email-item {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .email-content {
                width: 100%;
                margin-top: 1rem;
            }

            .email-meta {
                margin-top: 0.5rem;
                width: 100%;
                justify-content: space-between;
            }

            .avatar {
                order: -1;
            }

            .form-check {
                position: absolute;
                top: 1rem;
                right: 1rem;
            }

            #responseDetailModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            #responseDetailModal .modal-header {
                padding: 0.75rem;
            }
            
            #responseDetailModal .modal-body {
                padding: 0.75rem;
            }
            
            #responseDetailModal .response-header {
                flex-direction: column;
            }
            
            #responseDetailModal .response-content {
                font-size: 0.95rem;
                line-height: 1.5;
                word-break: break-word;
            }
            
            #responseDetailModal .modal-footer {
                padding: 0.75rem;
                flex-wrap: nowrap;
            }
            
            #responseDetailModal .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</body>
</html>

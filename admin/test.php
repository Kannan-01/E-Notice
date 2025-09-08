<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/admin.css">
    <link rel="stylesheet" href="./assets/style.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'settings';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="mx-auto" style="max-width: 900px;">
                    <h3 class="fw-bold mb-4">Account Settings</h3>
                    <div class="row g-4">
                        <!-- Left Menu -->
                        <div class="col-lg-4">
                            <div class="list-group mb-4 shadow-sm" id="settings-tabs">
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="notice-tab">
                                    <i class="bi bi-file-text me-2"></i> Notice
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="holiday-tab">
                                    <i class="bi bi-calendar2-event me-2"></i> Holiday
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="exam-tab">
                                    <i class="bi bi-clipboard-check me-2"></i> Exam
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="online-class-tab">
                                    <i class="bi bi-laptop me-2"></i> Online class
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center text-danger" id="logout-btn">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </button>
                            </div>
                        </div>
                        <!-- Tab Content -->
                        <div class="col-lg-8">

                            <?php
                            require 'profile.php'
                            ?>

                            <?php
                            require 'notification.php'
                            ?>

                            <?php
                            require 'password.php'
                            ?>

                        </div>
                    </div>
                </div>

                <!-- Logout Modal -->
                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to log out?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="../auth/logout.php" class="btn btn-danger">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    // Tabs toggle logic
                    document.querySelectorAll('#settings-tabs button').forEach(tab => {
                        tab.addEventListener('click', function() {
                            document.querySelectorAll('#settings-tabs .list-group-item').forEach(item => item.classList.remove('active'));
                            this.classList.add('active');
                            const target = this.getAttribute('data-target');
                            document.querySelectorAll('.settings-section').forEach(sec => sec.style.display = 'none');
                            document.getElementById(target).style.display = 'block';
                        });
                    });

                    // Logout modal show
                    document.getElementById('logout-btn').addEventListener('click', function() {
                        new bootstrap.Modal(document.getElementById('logoutModal')).show();
                    });
                </script>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
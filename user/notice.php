<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../admin/assets/admin.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'notice';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <!-- Main Content: User Notice Board UI -->
                <!-- Container & Header -->
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">My Notices</h2>
                        <div class="text-muted" style="font-size: 1rem;">
                            Sort By <b>Recent Project <i class="bi bi-chevron-down"></i></b>
                        </div>
                    </div>

                    <!-- Cards Grid -->
                    <div class="row g-4">

                        <!-- Notice Card Template -->
                        <div class="col-sm-6 col-lg-4">
                            <div class="project-card shadow-sm rounded-4 bg-white p-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="project-accent" style="background:#cd5ff8;"></span>
                                    <div class="ms-2">
                                        <h5 class="fw-semibold mb-1">Sample Notice Title</h5>
                                        <small class="text-muted">Last updated 3 days ago</small>
                                    </div>
                                </div>
                                <ul class="mb-3 ps-4 text-dark small">
                                    <li>First related note here</li>
                                    <li>Second related note here</li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="avatars-group">
                                        <img class="avatar" src="https://randomuser.me/api/portraits/women/31.jpg" alt="User 1" />
                                        <img class="avatar" src="https://randomuser.me/api/portraits/men/35.jpg" alt="User 2" />
                                        <img class="avatar" src="https://randomuser.me/api/portraits/men/25.jpg" alt="User 3" />
                                    </div>
                                    <button type="button" class="btn p-1 text-muted">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Repeat Notice Cards with different data -->
                        <!-- Example for a "Holiday" Notice -->
                        <div class="col-sm-6 col-lg-4">
                            <div class="project-card shadow-sm rounded-4 bg-white p-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="project-accent" style="background:#ffaf49;"></span>
                                    <div class="ms-2">
                                        <h5 class="fw-semibold mb-1">Holiday Schedule</h5>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                </div>
                                <p class="mb-3 ps-4 text-dark small">
                                    Campus closed for national holidays.
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="avatars-group">
                                        <img class="avatar" src="https://randomuser.me/api/portraits/men/50.jpg" alt="User 1" />
                                    </div>
                                    <button type="button" class="btn p-1 text-muted">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add more cards similar to these -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</body>

</html>
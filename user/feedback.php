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
            <!-- sidebar -->
            <?php
            $currentPage = 'feedback';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container" style="max-width: 720px;">
                    <!-- Page Heading -->
                    <h2 class="fw-bold mb-4">Feedback & Suggestions</h2>

                    <div class="cards shadow-sm rounded-4 p-4 bg-white">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs border-0 mb-4" id="feedbackTabs" style="--bs-nav-tabs-border-width: 0;">
                            <li class="nav-item">
                                <button class="nav-link active fw-semibold" id="overview-tab" type="button"
                                    style="background:#fffbe6; color: #c89110; border-radius: 8px 8px 0 0;">Feedback</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-semibold text-muted" id="test-tab" type="button"
                                    style="background: transparent; border-radius: 8px 8px 0 0;">Suggestion</button>
                            </li>
                        </ul>

                        <!-- Feedback Form -->
                        <form id="feedback-form">
                            <div>
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control mb-3" placeholder="Briefly describe your feedback" required>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Category</label>
                                <select class="form-select mb-3">
                                    <option value="" disabled selected>Select category</option>
                                    <option>Facility Issue</option>
                                    <option>Academic Suggestion</option>
                                    <option>Staff/Faculty</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Department</label>
                                <select class="form-select mb-3">
                                    <option value="" disabled selected>Select department</option>
                                    <option>Computer Science</option>
                                    <option>Commerce</option>
                                    <option>Mathematics</option>
                                    <option>English</option>
                                    <option>All</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Describe the issue</label>
                                <textarea class="form-control mb-3" rows="4" placeholder="e.g. Projector not working in Lab 2"></textarea>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-outline-secondary me-2">Cancel</button>
                                <button type="submit" class="btn fw-semibold px-4"
                                    style="background: #fbbf24; color: #222; border-radius: 18px;">Submit</button>
                            </div>
                        </form>

                        <!-- Suggestion Form (hidden by default) -->
                        <form id="suggestion-form" style="display:none;">
                            <div>
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control mb-3" placeholder="Briefly describe your suggestion" required>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Suggested for</label>
                                <select class="form-select mb-3">
                                    <option value="" disabled selected>Choose Area</option>
                                    <option>Facility Improvement</option>
                                    <option>Event Idea</option>
                                    <option>Curriculum</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Details</label>
                                <textarea class="form-control mb-3" rows="4" placeholder="Describe your suggestion"></textarea>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-outline-secondary me-2">Cancel</button>
                                <button type="submit" class="btn fw-semibold px-4"
                                    style="background: #fbbf24; color: #222; border-radius: 18px;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tab Switch Script -->
                <script>
                    document.getElementById('overview-tab').onclick = function() {
                        this.classList.add('active');
                        document.getElementById('test-tab').classList.remove('active');
                        document.getElementById('feedback-form').style.display = 'block';
                        document.getElementById('suggestion-form').style.display = 'none';
                        this.style.background = '#fffbe6';
                        this.style.color = '#c89110';
                        document.getElementById('test-tab').style.background = 'transparent';
                        document.getElementById('test-tab').style.color = '#888';
                    };
                    document.getElementById('test-tab').onclick = function() {
                        this.classList.add('active');
                        document.getElementById('overview-tab').classList.remove('active');
                        document.getElementById('feedback-form').style.display = 'none';
                        document.getElementById('suggestion-form').style.display = 'block';
                        this.style.background = '#fffbe6';
                        this.style.color = '#c89110';
                        document.getElementById('overview-tab').style.background = 'transparent';
                        document.getElementById('overview-tab').style.color = '#888';
                    };
                </script>

                <style>
                    .card.shadow-sm {
                        transition: none !important;
                        /* Disables zoom effect on hover */
                    }
                </style>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
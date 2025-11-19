<?php
session_start();
include '../db/connection.php';

// Check if user is logged in and admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Get notice ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid notice ID.");
}

$notice_id = intval($_GET['id']);

// Fetch notice details
$noticeResult = mysqli_query($conn, "SELECT * FROM notices WHERE id = $notice_id LIMIT 1");
if (!$noticeResult || mysqli_num_rows($noticeResult) === 0) {
    die("Notice not found.");
}

$notice = mysqli_fetch_assoc($noticeResult);

// Handle form submission
if (isset($_POST['save_notice'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $target = mysqli_real_escape_string($conn, $_POST['target']);
    $valid_from = $_POST['valid_from'] ?: null;
    $valid_until = $_POST['valid_until'] ?: null;

    $updateSql = "
        UPDATE notices SET
            title='$title',
            description='$description',
            department='$department',
            target='$target',
            valid_from=" . ($valid_from ? "'$valid_from'" : "NULL") . ",
            valid_until=" . ($valid_until ? "'$valid_until'" : "NULL") . "
        WHERE id=$notice_id
    ";

    mysqli_query($conn, $updateSql);

    // Redirect back to edit page with success flag
    header("Location: edit-notice.php?id=$notice_id&success=1");
    exit();
}

// Check for success message
$showToast = isset($_GET['success']) && $_GET['success'] == 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Notice | E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="container-fluid">
    <div class="row d-flex j">
        <!-- Sidebar -->
        <?php
        $currentPage = 'view-notice';
        require './common/sidebar.php';
        ?>

        <!-- Main Panel -->
        <div class="col-lg-6  py-5 px-4">
            <div class="container">
                <div id="notice-tab" class="settings-section" style="display:block;">
                    <form id="noticeForm" method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
                        <h5 class="fw-bold mb-4">Edit <span class="text-warning">Notice</span></h5>
                        <div class="row g-4 justify-content-between">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        value="<?= htmlspecialchars($notice['title']) ?>" />
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($notice['description']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select" id="department" name="department" required>
                                        <option value="All" <?= ($notice['department']=='All')?'selected':'' ?>>All</option>
                                        <option value="Commerce" <?= ($notice['department']=='Commerce')?'selected':'' ?>>Commerce</option>
                                        <option value="Computer Science" <?= ($notice['department']=='Computer Science')?'selected':'' ?>>Computer Science</option>
                                        <option value="Fashion Design" <?= ($notice['department']=='Fashion Design')?'selected':'' ?>>Fashion Design</option>
                                        <option value="Business Administration" <?= ($notice['department']=='Business Administration')?'selected':'' ?>>Business Administration</option>
                                        <option value="Psychology" <?= ($notice['department']=='Psychology')?'selected':'' ?>>Psychology</option>
                                        <option value="Mathematics" <?= ($notice['department']=='Mathematics')?'selected':'' ?>>Mathematics</option>
                                        <option value="English" <?= ($notice['department']=='English')?'selected':'' ?>>English</option>
                                        <option value="Social Work" <?= ($notice['department']=='Social Work')?'selected':'' ?>>Social Work</option>
                                    </select>
                                </div>

                                <div class="mb-3 d-flex gap-3">
                                    <div class="flex-fill">
                                        <label for="valid_from" class="form-label">Valid From</label>
                                        <input type="date" class="form-control" id="valid_from" name="valid_from" 
                                               value="<?= $notice['valid_from'] ?>" required />
                                    </div>

                                    <div class="flex-fill">
                                        <label for="valid_until" class="form-label">Valid Until</label>
                                        <input type="date" class="form-control" id="valid_until" name="valid_until" 
                                               value="<?= $notice['valid_until'] ?>" required />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="target" class="form-label">Target Audience</label>
                                    <select class="form-select" id="target" name="target" required>
                                        <option value="student" <?= ($notice['target']=='student')?'selected':'' ?>>Students</option>
                                        <option value="teacher" <?= ($notice['target']=='teacher')?'selected':'' ?>>Teachers</option>
                                        <option value="all" <?= ($notice['target']=='all')?'selected':'' ?>>All</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" name="save_notice" class="btn btn-warning px-5 py-2 fw-bold text-white">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Notice updated successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php if ($showToast): ?>
    const toastEl = document.getElementById('successToast');
    const toast = new bootstrap.Toast(toastEl, { delay: 2000 }); // toast delay 2 sec
    toast.show();

    // Redirect after toast disappears
    setTimeout(() => {
        window.location.href = 'view-notices.php';
    }, 2100); // slightly longer than toast delay
<?php endif; ?>
</script>
</body>
</html>

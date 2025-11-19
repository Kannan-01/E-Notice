<?php
session_start();
include '../db/connection.php';

// Check if user is logged in and admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Get holiday ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid holiday ID.");
}

$holiday_id = intval($_GET['id']);

// Fetch holiday details
$holidayResult = mysqli_query($conn, "SELECT * FROM holidays WHERE id = $holiday_id LIMIT 1");
if (!$holidayResult || mysqli_num_rows($holidayResult) === 0) {
    die("Holiday not found.");
}

$holiday = mysqli_fetch_assoc($holidayResult);

// Handle form submission
$showToast = false;
if (isset($_POST['save_holiday'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $target = mysqli_real_escape_string($conn, $_POST['target']);
    
    // Single-day or multi-day
    $holiday_date = $_POST['holiday_date'] ?: null;
    $start_date = $_POST['start_date'] ?: null;
    $end_date = $_POST['end_date'] ?: null;

    $updateSql = "
        UPDATE holidays SET
            title='$title',
            description='$description',
            department='$department',
            target='$target',
            holiday_date=" . ($holiday_date ? "'$holiday_date'" : "NULL") . ",
            start_date=" . ($start_date ? "'$start_date'" : "NULL") . ",
            end_date=" . ($end_date ? "'$end_date'" : "NULL") . "
        WHERE id=$holiday_id
    ";

    if (mysqli_query($conn, $updateSql)) {
        $showToast = true; // show toast
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Holiday | E-Notice</title>
<link rel="icon" type="image/x-icon" href="../noti.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php
        $currentPage = 'view-holidays';
        require './common/sidebar.php';
        ?>

        <div class="col-lg-6 py-5 px-4">
            <div class="container">
                <div id="holiday-tab" class="settings-section" style="display:block;">
                    <form id="holidayForm" method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
                        <h5 class="fw-bold mb-4">Edit <span class="text-warning">Holiday</span></h5>

                        <div class="mb-3">
                            <label for="title" class="form-label">Holiday Title</label>
                            <input type="text" class="form-control" id="title" name="title" required
                                value="<?= htmlspecialchars($holiday['title']) ?>" />
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($holiday['description']) ?></textarea>
                        </div>

                        <div class="form-check form-switch mb-3 ms-1">
                            <input class="form-check-input" type="checkbox" id="multiDayToggle" <?= ($holiday['start_date'] || $holiday['end_date']) ? 'checked' : '' ?> />
                            <label class="form-check-label" for="multiDayToggle">Multi-Day Holiday?</label>
                        </div>

                        <div class="mb-3" id="singleDayDiv">
                            <label for="holiday_date" class="form-label">Holiday Date</label>
                            <input type="date" class="form-control" id="holiday_date" name="holiday_date"
                                value="<?= htmlspecialchars($holiday['holiday_date']) ?>" />
                        </div>

                        <div class="row" id="multiDayDiv" style="display:none;">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="<?= htmlspecialchars($holiday['start_date']) ?>" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="<?= htmlspecialchars($holiday['end_date']) ?>" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department" required>
                                <option value="All" <?= ($holiday['department']=='All')?'selected':'' ?>>All</option>
                                <option value="Commerce" <?= ($holiday['department']=='Commerce')?'selected':'' ?>>Commerce</option>
                                <option value="Computer Science" <?= ($holiday['department']=='Computer Science')?'selected':'' ?>>Computer Science</option>
                                <option value="Fashion Design" <?= ($holiday['department']=='Fashion Design')?'selected':'' ?>>Fashion Design</option>
                                <option value="Business Administration" <?= ($holiday['department']=='Business Administration')?'selected':'' ?>>Business Administration</option>
                                <option value="Psychology" <?= ($holiday['department']=='Psychology')?'selected':'' ?>>Psychology</option>
                                <option value="Mathematics" <?= ($holiday['department']=='Mathematics')?'selected':'' ?>>Mathematics</option>
                                <option value="English" <?= ($holiday['department']=='English')?'selected':'' ?>>English</option>
                                <option value="Social Work" <?= ($holiday['department']=='Social Work')?'selected':'' ?>>Social Work</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="target" class="form-label">Target Audience</label>
                            <select class="form-select" id="target" name="target" required>
                                <option value="students" <?= ($holiday['target']=='students')?'selected':'' ?>>Students</option>
                                <option value="teachers" <?= ($holiday['target']=='teachers')?'selected':'' ?>>Teachers</option>
                                <option value="all" <?= ($holiday['target']=='all')?'selected':'' ?>>All</option>
                            </select>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" name="save_holiday" class="btn btn-warning px-5 py-2 fw-bold text-white">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
  <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Holiday updated successfully!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle = document.getElementById("multiDayToggle");
    const singleDayDiv = document.getElementById("singleDayDiv");
    const multiDayDiv = document.getElementById("multiDayDiv");

    function updateToggleDisplay() {
        if (toggle.checked) {
            singleDayDiv.style.display = "none";
            multiDayDiv.style.display = "flex";
            document.getElementById("holiday_date").required = false;
            document.getElementById("start_date").required = true;
            document.getElementById("end_date").required = true;
        } else {
            singleDayDiv.style.display = "block";
            multiDayDiv.style.display = "none";
            document.getElementById("holiday_date").required = true;
            document.getElementById("start_date").required = false;
            document.getElementById("end_date").required = false;
        }
    }
    toggle.addEventListener("change", updateToggleDisplay);
    updateToggleDisplay();

    // Show toast if update was successful
    <?php if($showToast): ?>
        const toastEl = document.getElementById('successToast');
        const toast = new bootstrap.Toast(toastEl, { delay: 2000 });
        toast.show();
        setTimeout(() => {
            window.location.href = "view-holidays.php";
        }, 2000);
    <?php endif; ?>
</script>
</body>
</html>

<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id   = $_SESSION['user_id'];
$userRole  = $_SESSION['role']; // role already stored in session

// Get user department
$userDept = null;
if ($userRole === 'student') {
    $result = mysqli_query($conn, "SELECT department FROM students WHERE user_id = $user_id LIMIT 1");
    if ($result && mysqli_num_rows($result) > 0) {
        $userDept = mysqli_fetch_assoc($result)['department'];
    }
} elseif ($userRole === 'teacher') {
    $result = mysqli_query($conn, "SELECT department FROM teachers WHERE user_id = $user_id LIMIT 1");
    if ($result && mysqli_num_rows($result) > 0) {
        $userDept = mysqli_fetch_assoc($result)['department'];
    }
}

if (!$userDept) {
    $userDept = '';
}

// Update expired holidays
$today = date('Y-m-d');

mysqli_query($conn, "
    UPDATE holidays 
    SET status = 'inactive' 
    WHERE status = 'active'
      AND (
          (end_date IS NOT NULL AND end_date < '$today')
          OR (holiday_date IS NOT NULL AND holiday_date < '$today')
      )
");

// Fetch active holiday notices
$holidaysSql = "
    SELECT * FROM holidays 
    WHERE (department = '$userDept' OR department = 'All' OR department IS NULL)
      AND status = 'active'
    ORDER BY posted_at DESC
";
$holidaysResult = mysqli_query($conn, $holidaysSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Holiday Notices</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'holiday';
            require './common/sidebar.php';
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">Holiday Notices</h2>
                        <div class="text-muted" style="font-size: 1rem;">
                            Sort By <b>Recent <i class="bi bi-chevron-down"></i></b>
                        </div>
                    </div>

                    <!-- Holiday Grid -->
                    <div class="row g-4">
                        <?php
                        if ($holidaysResult && mysqli_num_rows($holidaysResult) > 0) {
                            while ($holiday = mysqli_fetch_assoc($holidaysResult)) {
                        ?>
                                <!-- Holiday Card -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="project-card shadow-sm rounded-4 bg-white p-4 h-100 d-flex flex-column">

                                        <!-- Header -->
                                        <div class="d-flex align-items-start mb-3">
                                            <span class="project-accent me-3" style="background:#ffaf49"></span>
                                            <h5 class="fw-semibold mb-0 flex-grow-1">
                                                <?= htmlspecialchars($holiday['title']) ?>
                                            </h5>
                                        </div>

                                        <!-- Description -->
                                        <p class="text-dark small flex-grow-1 ps-3 mb-3">
                                            <?= nl2br(htmlspecialchars($holiday['description'])) ?>
                                        </p>

                                        <!-- Dates -->
                                        <div class="d-flex align-items-center ps-3 text-muted small mb-2">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <?php if (!empty($holiday['start_date']) && !empty($holiday['end_date'])): ?>
                                                <?= date('M d, Y', strtotime($holiday['start_date'])) ?> - <?= date('M d, Y', strtotime($holiday['end_date'])) ?>
                                            <?php elseif (!empty($holiday['holiday_date'])): ?>
                                                <?= date('M d, Y', strtotime($holiday['holiday_date'])) ?>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Footer -->
                                        <div class="text-end mt-auto">
                                            <small class="fst-italic text-muted">
                                                Posted on <?= date('M d, Y', strtotime($holiday['posted_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<p>No active holiday notices available for your department.</p>';
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
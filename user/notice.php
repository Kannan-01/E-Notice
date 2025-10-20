<?php
session_start();
include '../db/connection.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user role
$userRoleResult = mysqli_query($conn, "SELECT role FROM users WHERE id = $user_id LIMIT 1");
if (!$userRoleResult || mysqli_num_rows($userRoleResult) == 0) {
    die("User role not found.");
}
$userRole = mysqli_fetch_assoc($userRoleResult)['role'];

// Get user department from relevant table
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

// Handle missing department
if (!$userDept) {
    $userDept = 'All';
}

// Update expired notices (optional)
$today = date('Y-m-d');
mysqli_query($conn, "UPDATE notices SET status = 'inactive' WHERE valid_until < '$today' AND status = 'active'");

// Build notice query based on role
if ($userRole === 'teacher') {
    // Teacher sees department notices + teacher/all targets
    $noticesSql = "
        SELECT * FROM notices
        WHERE status = 'active'
          AND (valid_until IS NULL OR valid_until >= CURDATE())
          AND (
              (department = '$userDept' OR department = 'All' OR department IS NULL)
              AND (target = 'teacher' OR target = 'all')
          )
        ORDER BY posted_at DESC
    ";
} elseif ($userRole === 'student') {
    // Student sees department notices + student/all targets
    $noticesSql = "
        SELECT * FROM notices
        WHERE status = 'active'
          AND (valid_until IS NULL OR valid_until >= CURDATE())
          AND (
              (department = '$userDept' OR department = 'All' OR department IS NULL)
              AND (target = 'student' OR target = 'all')
          )
        ORDER BY posted_at DESC
    ";
} else {
    // Admin or others see all
    $noticesSql = "
        SELECT * FROM notices
        WHERE status = 'active'
          AND (valid_until IS NULL OR valid_until >= CURDATE())
        ORDER BY posted_at DESC
    ";
}

$noticesResult = mysqli_query($conn, $noticesSql);
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
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'notice';
            require './common/sidebar.php';
            ?>

            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">
                            <span class="text-warning">
                                <?= ucfirst($userRole) ?> 
                            </span> Announcements
                        </h2>
                    </div>

                    <!-- Cards Grid -->
                    <div class="row g-4">
                        <?php
                        if ($noticesResult && mysqli_num_rows($noticesResult) > 0) {
                            while ($notice = mysqli_fetch_assoc($noticesResult)) {
                        ?>
                                <!-- Notice Card -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="project-card shadow-sm rounded-4 bg-white p-4 h-100 d-flex flex-column">
                                        <!-- Header -->
                                        <div class="d-flex align-items-start mb-3">
                                            <span class="project-accent me-3" style="background:#cd5ff8;"></span>
                                            <h5 class="fw-semibold mb-0 flex-grow-1">
                                                <?= htmlspecialchars($notice['title']) ?>
                                            </h5>
                                        </div>

                                        <!-- Description -->
                                        <p class="text-dark small flex-grow-1 ps-3 mb-3">
                                            <?= nl2br(htmlspecialchars($notice['description'])) ?>
                                        </p>

                                        <!-- Footer -->
                                        <div class="text-end mt-auto">
                                            <small class="fst-italic text-muted">
                                                Posted on <?= date('M d, Y', strtotime($notice['posted_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<p>No active notices available for your department or role.</p>';
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

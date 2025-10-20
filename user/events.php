<?php
session_start();
include '../db/connection.php';

// ✅ Route guard
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user role
$userRoleResult = mysqli_query($conn, "SELECT role FROM users WHERE id = $user_id LIMIT 1");
if (!$userRoleResult || mysqli_num_rows($userRoleResult) == 0) {
    die("User role not found.");
}
$userRole = mysqli_fetch_assoc($userRoleResult)['role'];

// ✅ Get user department based on role
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

// If no department found, fallback
if (!$userDept) {
    $userDept = 'All';
}

// ✅ Update expired events
$today = date('Y-m-d');
mysqli_query($conn, "UPDATE events SET status = 'inactive' WHERE event_date < '$today' AND status = 'active'");

// ✅ Fetch active events for user's department or general (All/NULL)
$sql = "SELECT * FROM events 
        WHERE (event_department = '$userDept' OR event_department IS NULL OR event_department = 'All') 
          AND status = 'active'
        ORDER BY event_date DESC";
$result = $conn->query($sql);
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
            <?php
            $currentPage = 'events';
            require './common/sidebar.php';
            ?>
            <div class="col-lg-9 py-5 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold"><span class="text-warning">College</span> Notices</h2>
                </div>
                <div class="row g-4">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $eventId = $row['id'];
                            $poster = !empty($row['event_poster'])
                                ? "../" . $row['event_poster']
                                : "./assets/img/default-poster.jpg";
                    ?>
                            <!-- Event Card -->
                            <div class="col-md-3"> <!-- was col-md-4, made smaller column -->
                                <div class="card shadow-sm border-0 rounded-4 h-100">
                                    <img src="<?= $poster ?>" class="card-img-top rounded-top-4"
                                        alt="<?= htmlspecialchars($row['event_title']) ?>"
                                        style="height: 160px; object-fit: cover; cursor:pointer;"
                                        data-bs-toggle="modal" data-bs-target="#eventModal<?= $eventId ?>">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold text-truncate" style="font-size: 1rem;">
                                            <?= htmlspecialchars($row['event_title']) ?>
                                        </h5>
                                        <p class="card-text text-muted mb-1" style="font-size: 0.9rem;">
                                            <i class="bi bi-calendar-event"></i> <?= date("d M Y", strtotime($row['event_date'])) ?>
                                        </p>
                                        <p class="card-text text-muted" style="font-size: 0.9rem;">
                                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['event_venue']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="eventModal<?= $eventId ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-body pb-3">
                                            <div class="row g-4">
                                                <div class="col-md-5 text-center">
                                                    <img src="<?= $poster ?>" class="img-fluid rounded-3 shadow-sm"
                                                        alt="<?= htmlspecialchars($row['event_title']) ?>"
                                                        style="object-fit: contain; width:100%;">
                                                </div>
                                                <div class="col-md-7 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <h4 class="fw-bold text-black border-start border-3 border-warning ps-2 mb-3">
                                                            <?= htmlspecialchars($row['event_title']) ?>
                                                        </h4>
                                                        <ul class="list-unstyled mb-3">
                                                            <li><i class="bi bi-calendar-event text-warning"></i> <strong class="text-black">Date:</strong> <span class="text-dark"><?= date("d M Y", strtotime($row['event_date'])) ?></span></li>
                                                            <li><i class="bi bi-clock text-warning"></i> <strong class="text-black">Time:</strong> <span class="text-dark"><?= date("h:i A", strtotime($row['event_time'])) ?></span></li>
                                                            <li><i class="bi bi-geo-alt text-warning"></i> <strong class="text-black">Venue:</strong> <span class="text-dark"><?= htmlspecialchars($row['event_venue']) ?></span></li>
                                                            <li><i class="bi bi-person text-warning"></i> <strong class="text-black">Organized By:</strong> <span class="text-dark"><?= htmlspecialchars($row['event_organized_by']) ?></span></li>
                                                            <li><i class="bi bi-people text-warning"></i> <strong class="text-black">Target:</strong> <span class="text-dark"><?= htmlspecialchars($row['event_target']) ?></span></li>
                                                            <li><i class="bi bi-building text-warning"></i> <strong class="text-black">Department:</strong> <span class="text-dark"><?= htmlspecialchars($row['event_department']) ?></span></li>
                                                        </ul>
                                                        <h6 class="fw-bold text-black border-start border-3 border-warning ps-2">Description</h6>
                                                        <p class="text-dark"><?= nl2br(htmlspecialchars($row['event_description'])) ?></p>
                                                    </div>
                                                    <div class="border-top border-warning pt-2 mt-3 small text-end text-dark">
                                                        <i class="bi bi-clock-history text-warning"></i>
                                                        <span class="fw-semibold text-black">Posted on</span> <?= date("d M Y h:i A", strtotime($row['posted_at'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-muted'>No events available.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
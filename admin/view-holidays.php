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

// Ensure only admin can access this page
if ($userRole !== 'admin') {
    header("Location: ../auth/unauthorized.php");
    exit();
}

// Handle delete request
if (isset($_POST['delete_holiday_id'])) {
    $del_id = intval($_POST['delete_holiday_id']);
    mysqli_query($conn, "DELETE FROM holidays WHERE id = $del_id");
    header("Location: view-holidays.php");
    exit();
}

// Update expired holidays automatically
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

// Fetch only active (non-expired) holidays, ordered by most recent, limit 10
$holidaysSql = "
    SELECT * FROM holidays
    WHERE status = 'active' AND (holiday_date IS NULL OR holiday_date >= '$today') AND (end_date IS NULL OR end_date >= '$today')
    ORDER BY posted_at DESC
    LIMIT 10
";
$holidaysResult = mysqli_query($conn, $holidaysSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice | Holidays</title>
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
        $currentPage = 'view-holidays';
        require './common/sidebar.php';
        ?>

        <!-- Main Panel -->
        <div class="col-lg-9 py-5 px-4">
            <div class="container py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold"><span class="text-warning">All</span> Holidays</h2>
                </div>

                <!-- Cards Grid -->
                <div class="row g-4">
<?php
if ($holidaysResult && mysqli_num_rows($holidaysResult) > 0) {
    while ($holiday = mysqli_fetch_assoc($holidaysResult)) {
        $dropdownId = 'dropdownHoliday' . $holiday['id'];
?>
    <div class="col-sm-6 col-lg-4">
        <div class="project-card shadow-sm rounded-4 bg-white p-4 h-100 d-flex flex-column position-relative">
            
            <!-- Dropdown for Edit/Delete (Top Right) -->
            <div class="position-absolute top-0 end-0 p-3">
                <div class="dropdown">
                    <i class="bi bi-three-dots-vertical text-muted fs-5" role="button" id="<?= $dropdownId ?>" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="<?= $dropdownId ?>">
                        <li><a class="dropdown-item" href="edit-holiday.php?id=<?= $holiday['id'] ?>">Edit</a></li>
                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $holiday['id'] ?>">Delete</a></li>
                    </ul>
                </div>
            </div>

            <!-- Header -->
            <div class="d-flex align-items-start mb-3">
                <span class="project-accent me-3" style="background:#ff6f61;"></span>
                <h5 class="fw-semibold mb-0 flex-grow-1"><?= htmlspecialchars($holiday['title']) ?></h5>
            </div>

            <!-- Description -->
            <p class="text-dark small flex-grow-1 ps-3 mb-3"><?= nl2br(htmlspecialchars($holiday['description'])) ?></p>

            <!-- Extra Info -->
            <p class="small text-muted ps-3 mb-1">
                <strong>Date:</strong> <?= isset($holiday['holiday_date']) ? date('M d, Y', strtotime($holiday['holiday_date'])) : 'N/A' ?><br>
                <strong>Type:</strong> <?= htmlspecialchars($holiday['type'] ?? 'General') ?><br>
                <strong>Status:</strong> <?= ucfirst($holiday['status']) ?>
            </p>

            <!-- Footer -->
            <div class="text-end mt-auto">
                <small class="fst-italic text-muted">
                    Added on <?= isset($holiday['posted_at']) ? date('M d, Y', strtotime($holiday['posted_at'])) : 'N/A' ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal<?= $holiday['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $holiday['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel<?= $holiday['id'] ?>">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this holiday?
                        <input type="hidden" name="delete_holiday_id" value="<?= $holiday['id'] ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    }
} else {
    echo '<p>No active holidays found.</p>';
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

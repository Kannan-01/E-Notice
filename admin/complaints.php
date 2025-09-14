<?php
session_start();
include '../db/connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$toastMessage = '';
$toastType = '';

// Handle status update POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complaint_id'], $_POST['status'])) {
    $complaint_id = (int)$_POST['complaint_id'];
    $status = $_POST['status'];

    $allowed_status = ['Pending', 'Resolved'];
    if (in_array($status, $allowed_status)) {
        $sql = "UPDATE complaints SET status='$status' WHERE id='$complaint_id'";
        if (mysqli_query($conn, $sql)) {
            $toastMessage = "Complaint updated to '$status' successfully.";
            $toastType = "success";
        } else {
            $toastMessage = "Failed to update complaint.";
            $toastType = "danger";
        }
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . "?toast=" . urlencode($toastMessage) . "&type=" . $toastType);
    exit();
}

// Handle toast from redirect
if (isset($_GET['toast'])) {
    $toastMessage = $_GET['toast'];
    $toastType = $_GET['type'] ?? 'success';
}

// Fetch only Pending complaints
$sql = "SELECT c.*, u.name AS user_name FROM complaints c
        JOIN users u ON c.user_id = u.id
        WHERE c.status = 'Pending'
        ORDER BY c.created_at DESC";
$complaintsResult = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'complaints';
            require './common/sidebar.php';
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container my-4">
                    <h3 class="mb-4 fw-bold">View <span class="text-warning">Complaints</span></h3>
                    <?php if ($complaintsResult && mysqli_num_rows($complaintsResult) > 0): ?>
                        <?php while ($complaint = mysqli_fetch_assoc($complaintsResult)): ?>
                            <div class="card shadow-sm border-0 rounded-4 mb-4" style="box-shadow: 0 8px 16px rgba(0,0,0,0.1);">
                                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-semibold mb-1"><?= htmlspecialchars($complaint['title']); ?></h5>
                                        <h6 class="card-subtitle text-muted mb-2" style="font-size: 0.9rem;">
                                            Submitted by: <?= htmlspecialchars($complaint['user_name']); ?> | Dept: <?= htmlspecialchars($complaint['department']); ?> | <small><?= date('Y-m-d', strtotime($complaint['created_at'])); ?></small>
                                        </h6>
                                        <p class="card-text text-secondary mb-0" style="line-height: 1.5;">
                                            <?= nl2br(htmlspecialchars($complaint['description'])); ?>
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <div class="d-flex gap-1">
                                            <form method="POST" class="m-0 p-0" style="display:inline-block;">
                                                <input type="hidden" name="complaint_id" value="<?= $complaint['id']; ?>" />
                                                <input type="hidden" name="status" value="Resolved" />
                                                <button type="submit" class="btn bg-transparent p-1" title="Mark as Resolved">
                                                    <i class="bi bi-check2-circle text-success fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <small class="text-muted fw-semibold">Status:
                                                <span class="text-primary">
                                                    <?= htmlspecialchars($complaint['status']); ?>
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No pending complaints.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <?php if (!empty($toastMessage)): ?>
            <div class="toast align-items-center text-bg-<?= $toastType ?> border-0 show"
                role="alert" data-bs-delay="2000" data-bs-autohide="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= htmlspecialchars($toastMessage); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // auto show toast
        const toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(toastEl => new bootstrap.Toast(toastEl).show())
    </script>
</body>

</html>
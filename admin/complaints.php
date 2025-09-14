<?php
session_start();
include '../db/connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle status update POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complaint_id'], $_POST['status'])) {
    $complaint_id = (int)$_POST['complaint_id'];
    $status = $_POST['status'];

    $allowed_status = ['Pending', 'In Progress', 'Resolved', 'Rejected'];
    if (in_array($status, $allowed_status)) {
        $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $complaint_id);
        $stmt->execute();
        $stmt->close();
    }
    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch complaints
$sql = "SELECT c.*, u.name AS user_name FROM complaints c
        JOIN users u ON c.user_id = u.id
        ORDER BY c.created_at DESC";
$complaintsResult = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Complaints Management - E-Notice</title>
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
                <h3 class="mb-4 fw-bold">Complaints</h3>
                <?php if ($complaintsResult && $complaintsResult->num_rows > 0): ?>
                    <?php while ($complaint = $complaintsResult->fetch_assoc()): ?>
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
                                        <form method="POST" class="m-0 p-0" style="display:inline-block;">
                                            <input type="hidden" name="complaint_id" value="<?= $complaint['id']; ?>" />
                                            <input type="hidden" name="status" value="In Progress" />
                                            <button type="submit" class="btn bg-transparent p-1" title="Mark In Progress">
                                                <i class="bi bi-hourglass-split text-warning fs-5"></i>
                                            </button>
                                        </form>
                                        <form method="POST" class="m-0 p-0" style="display:inline-block;">
                                            <input type="hidden" name="complaint_id" value="<?= $complaint['id']; ?>" />
                                            <input type="hidden" name="status" value="Rejected" />
                                            <button type="submit" class="btn bg-transparent p-1" title="Reject Complaint">
                                                <i class="bi bi-x-circle text-danger fs-5"></i>
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
                    <p>No complaints found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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

// Fetch all complaints
$sql = "SELECT c.*, u.name AS user_name FROM complaints c
        JOIN users u ON c.user_id = u.id
        ORDER BY FIELD(c.status, 'Pending', 'Resolved'), c.created_at DESC";
$complaintsResult = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice | Complaints</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css" />

    <style>
        body {
            background-color: #f8fafc;
        }
        .page-title {
            font-weight: 700;
            color: #1a1a1a;
        }
        .accent {
            color: #ffb300;
        }
        .complaint-card {
            border: none;
            border-radius: 1rem;
            background: #fff;
            transition: all 0.25s ease-in-out;
        }
      
        .complaint-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .status-badge {
            font-weight: 600;
            font-size: 0.85rem;
        }
        .status-badge.pending {
            color: #0d6efd;
        }
        .status-badge.resolved {
            color: #198754;
        }
        .no-data {
            text-align: center;
            color: #999;
            padding: 60px 0;
            font-size: 1.1rem;
        }
        .btn-status {
            border: none;
            background: transparent;
            transition: all 0.2s;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php
        $currentPage = 'complaints';
        require './common/sidebar.php';
        ?>

        <!-- Main Content -->
        <div class="col-lg-9 py-5 px-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="page-title mb-0">Manage <span class="accent">Complaints</span></h3>
                </div>

                <?php if ($complaintsResult && mysqli_num_rows($complaintsResult) > 0): ?>
                    <?php while ($complaint = mysqli_fetch_assoc($complaintsResult)): ?>
                        <div class="complaint-card p-4 mb-3 shadow-sm">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <div>
                                    <h5 class="fw-semibold mb-2 text-dark">
                                        <i class="bi bi-chat-dots text-warning me-1"></i>
                                        <?= htmlspecialchars($complaint['title']); ?>
                                    </h5>
                                    <div class="complaint-meta mb-2">
                                        <i class="bi bi-person"></i> <?= htmlspecialchars($complaint['user_name']); ?> |
                                        <i class="bi bi-building"></i> <?= htmlspecialchars($complaint['department']); ?> |
                                        <i class="bi bi-calendar3"></i> <?= date('Y-m-d', strtotime($complaint['created_at'])); ?>
                                    </div>
                                    <p class="text-secondary mb-0"><?= nl2br(htmlspecialchars($complaint['description'])); ?></p>
                                </div>

                                <div class="text-center">
                                    <?php if ($complaint['status'] === 'Pending'): ?>
                                        <form method="POST" class="m-0 p-0">
                                            <input type="hidden" name="complaint_id" value="<?= $complaint['id']; ?>">
                                            <input type="hidden" name="status" value="Resolved">
                                            <button type="submit" class="btn-status" title="Mark as Resolved">
                                                <i class="bi bi-check2-circle text-success fs-4"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <span class="status-badge <?= strtolower($complaint['status']); ?>">
                                            <?= htmlspecialchars($complaint['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-data">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <p class="mt-3">No complaints found</p>
                    </div>
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
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());
</script>
</body>
</html>

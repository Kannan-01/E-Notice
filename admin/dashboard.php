<?php
session_start();
include '../db/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Check if user is admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    // Redirect non-admins to user dashboard (or logout)
    header("Location: ../user/dashboard.php");
    exit();
}

// Total users excluding admins
$sqlTotalUsers = "SELECT COUNT(*) as total FROM users WHERE role != 'admin'";
$result = $conn->query($sqlTotalUsers);
$totalUsers = $result->fetch_assoc()['total'] ?? 0;

// Pending approvals
$sqlPending = "SELECT COUNT(*) as pending FROM users WHERE status = 'pending' AND role != 'admin'";
$result = $conn->query($sqlPending);
$pendingApprovals = $result->fetch_assoc()['pending'] ?? 0;

// Notices published
$sqlNotices = "SELECT COUNT(*) as total_notices FROM notices";
$result = $conn->query($sqlNotices);
$totalNotices = $result->fetch_assoc()['total_notices'] ?? 0;

// Recent user activities
$sqlActivities = "SELECT name, status, updated_at FROM users 
                  WHERE status IN ('approved', 'rejected') AND role != 'admin' 
                  ORDER BY updated_at DESC 
                  LIMIT 5";
$result = $conn->query($sqlActivities);
$recentActivities = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentActivities[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Approvals E-Notice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'dashboard';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container-fluid">
                    <h2 class="fw-bold mb-4">
                        <span class="text-dark">Dashboard</span>
                        <span class="accent">Overview</span>
                    </h2>

                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="card dashCard shadow-sm border-0 rounded-4 p-4">
                                <h5 class="text-muted">Total Users</h5>
                                <h2 class="accent fw-bold"><?= $totalUsers ?></h2>
                                <p class="text-success">+12% since last month</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashCard shadow-sm border-0 rounded-4 p-4">
                                <h5 class="text-muted">Pending Approvals</h5>
                                <h2 class="accent fw-bold"><?= $pendingApprovals ?></h2>
                                <p class="text-warning">Needs your attention</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashCard shadow-sm border-0 rounded-4 p-4">
                                <h5 class="text-muted">Notices Published</h5>
                                <h2 class="accent fw-bold"><?= $totalNotices ?></h2>
                                <p class="text-success">+5 new this week</p>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Recent User Activities</h4>
                    <div class="table-responsive bg-white shadow rounded-4 p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($recentActivities) > 0): ?>
                                    <?php foreach ($recentActivities as $activity): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($activity['name']) ?></td>
                                            <td><?= htmlspecialchars(ucfirst($activity['status'])) ?></td>
                                            <td><?= date('M d, Y h:i A', strtotime($activity['updated_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No recent activities found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
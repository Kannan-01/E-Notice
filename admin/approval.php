<?php

session_start();
include '../db/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


function sendApprovalEmail($toEmail, $toName)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';            // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'enoticekmm@gmail.com';  // Your email
        $mail->Password = 'erhi bhlg qnkf lkbb';     // Your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('enoticekmm@gmail.com', 'E-Notice Board');
        $mail->addAddress($toEmail, $toName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Account Has Been Approved - E-Notice Board';

        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width:600px; margin:auto; border:1px solid #ddd; border-radius:8px; overflow:hidden;">
            <div style="background-color:#f8b739; color:#fff; padding:20px; text-align:center;">
                <h1 style="margin:0; font-size:24px;">Account Approved 🎉</h1>
            </div>
            <div style="padding:30px; color:#333;">
                <p>Dear <strong>' . htmlspecialchars($toName) . '</strong>,</p>
                <p style="font-size:16px; line-height:1.5;">
                    We are pleased to inform you that your account on <strong>E-Notice Board</strong> has been successfully <span style="color:#31ce7b; font-weight:600;">approved</span> by the administrator.
                </p>
                <p style="font-size:16px; line-height:1.5;">
                    You can now log in and enjoy full access to all features and notifications relevant to your profile.
                </p>
                <div style="text-align:center; margin: 30px 0;">
                    <a href="http://localhost/e-notice/auth/login.php" style="background:#f8b739; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; font-weight:bold; border-radius:5px; display:inline-block;">
                        Login to Your Account
                    </a>
                </div>
                <p style="font-size:14px; color:#666;">
                    If you did not request this account or believe this message was sent in error, please contact our support team immediately.
                </p>
                <p style="font-size:14px; color:#999; margin-top:40px; border-top:1px solid #ddd; padding-top:10px;">
                    &copy; ' . date('Y') . ' E-Notice Board. All rights reserved.
                </p>
            </div>
        </div>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('PHPMailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}

// Handle approval or rejection requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $action = $_POST['action'];
    $user_id = intval($_POST['user_id']);

    if (in_array($action, ['approve', 'reject'])) {
        $new_status = $action === 'approve' ? 'approved' : 'rejected';

        // Update user status in DB
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $new_status, $user_id);
        $stmt->execute();
        $stmt->close();

        // Send approval email ONLY on approval
        if ($new_status === 'approved') {
            // Fetch user's name and email for mailing
            $stmt2 = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
            $stmt2->bind_param('i', $user_id);
            $stmt2->execute();
            $stmt2->bind_result($userName, $userEmail);
            $stmt2->fetch();
            $stmt2->close();

            sendApprovalEmail($userEmail, $userName);
        }
    }
    // Redirect to avoid form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch users with all three statuses: pending, approved, rejected (excluding admins)
$sql = "SELECT u.id, u.name, u.email, u.role, u.status, 
        s.student_id, t.employee_id,
        COALESCE(s.department, t.department) as department
        FROM users u
        LEFT JOIN students s ON u.id = s.user_id
        LEFT JOIN teachers t ON u.id = t.user_id
        WHERE u.status IN ('pending', 'approved', 'rejected') AND u.role != 'admin'
        ORDER BY FIELD(u.status, 'pending', 'approved', 'rejected'), u.name";

$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Add identifier key for display
foreach ($users as &$user) {
    if ($user['role'] === 'student') {
        $user['identifier'] = $user['student_id'];
    } else {
        $user['identifier'] = $user['employee_id'];
    }
}
unset($user);

$conn->close();
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
            $currentPage = 'approval';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold text-dark">User <span class="text-warning">Approvals</span></h3>
                    <div>
                        <!-- <button class="btn btn-outline-dark shadow-none"><i class="bi bi-search"></i></button> -->
                    </div>
                </div>
                <div class="table-responsive bg-white shadow rounded-3 p-4">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Role</th>
                                <th scope="col">Department</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <span class="profile-icon"><i class="bi bi-person"></i></span>
                                        <span>
                                            <span class="fw-bold"><?= htmlspecialchars($user['name']) ?></span>
                                            <div class="text-muted" style="font-size: 0.94em;">
                                                <?= $user['role'] === 'student' ? 'Student ID: ' : 'Teacher ID: ' ?>
                                                <?= htmlspecialchars($user['identifier'] ?? '') ?>
                                            </div>
                                        </span>
                                    </td>
                                    <td><span class="accent"><?= ucfirst($user['role']) ?></span></td>
                                    <td><?= htmlspecialchars($user['department']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><span class="status-badge status-<?= htmlspecialchars($user['status']) ?>">
                                            <?= ucfirst($user['status']) ?>
                                        </span></td>
                                    <td>
                                        <?php if ($user['status'] === 'pending'): ?>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>" />
                                                <input type="hidden" name="action" value="approve" />
                                                <button type="submit" class="btn-approve btn btn-sm">Approve</button>
                                            </form>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>" />
                                                <input type="hidden" name="action" value="reject" />
                                                <button type="submit" class="btn-reject btn btn-sm">Reject</button>
                                            </form>
                                        <?php else: ?>
                                            <em class="text-muted">—</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($users) === 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();
include '../db/connection.php';

$passSuccess = $_SESSION['passSuccess'] ?? "";
$passError = $_SESSION['passError'] ?? "";

// Clear flash messages so they don’t persist on refresh
unset($_SESSION['passSuccess'], $_SESSION['passError']);

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
$avatarError = $avatarSuccess = "";

// Fetch required fields including avatar
$query = "SELECT name, email, role, avatar FROM users WHERE id = '$admin_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['avatar'])) {
    if ($_FILES['avatar']['error'] === 0) {
        $imageName = basename($_FILES['avatar']['name']);
        $avatarPath = "uploads/" . time() . "_" . $imageName;
        $targetFile = "../" . $avatarPath;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                // delete old avatar if exists
                $oldAvatar = $admin['avatar'];
                if (!empty($oldAvatar) && file_exists("../" . $oldAvatar)) {
                    unlink("../" . $oldAvatar);
                }

                mysqli_query($conn, "UPDATE users SET avatar='$avatarPath' WHERE id='$admin_id'");
                $admin['avatar'] = $avatarPath;

                $avatarSuccess = "Profile picture updated successfully.";
            } else {
                $avatarError = "Failed to upload profile picture.";
            }
        } else {
            $avatarError = "Invalid file type. Allowed: JPG, PNG, GIF.";
        }
    }
}

// Handle avatar delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_avatar'])) {
    if (!empty($admin['avatar']) && file_exists("../" . $admin['avatar'])) {
        unlink("../" . $admin['avatar']);
    }
    mysqli_query($conn, "UPDATE users SET avatar=NULL WHERE id='$admin_id'");
    $admin['avatar'] = null;
    $avatarSuccess = "Profile picture deleted.";
}

// Handle password update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!empty($currentPassword) && !empty($newPassword) && $newPassword === $confirmPassword) {
        $sql = "SELECT password FROM users WHERE id = '$admin_id' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($currentPassword, $row['password'])) {
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                if (mysqli_query($conn, "UPDATE users SET password='$newHashedPassword' WHERE id='$admin_id'")) {
                    // ✅ Store success message in session (flash message)
                    $_SESSION['passSuccess'] = "Password updated successfully.";
                } else {
                    $_SESSION['passError'] = "Error updating password. Try again.";
                }
            } else {
                $_SESSION['passError'] = "Current password is incorrect.";
            }
        }
    } else {
        $_SESSION['passError'] = "New passwords do not match or fields are empty.";
    }

    // ✅ Redirect to clear POST data & form fields
    header("Location: settings.php"); 
    exit();
}

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
            $currentPage = 'settings';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="mx-auto" style="max-width: 900px;">
                    <h3 class="fw-bold mb-4">Account <span class="text-warning">Settings</span></h3>
                    <div class="row g-4">
                        <!-- Left Menu -->
                        <div class="col-lg-4">
                            <div class="list-group mb-4 shadow-sm" id="settings-tabs">
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="profile-tab">
                                    <i class="bi bi-person-lines-fill me-2"></i> Profile Info
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="password-tab">
                                    <i class="bi bi-lock me-2"></i> Password
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center text-danger" id="logout-btn">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </button>
                            </div>
                        </div>
                        <!-- Tab Content -->
                        <div class="col-lg-8">

                            <?php require 'profile.php'; ?>

                            <?php require 'password.php'; ?>

                        </div>
                    </div>

                    <!-- Logout Modal -->
                    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to log out?
                                </div>
                                <div class="modal-footer">
                                    <a href="../auth/logout.php" class="btn btn-danger">Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        // Tabs toggle logic
                        document.querySelectorAll('#settings-tabs button').forEach(tab => {
                            tab.addEventListener('click', function() {
                                document.querySelectorAll('#settings-tabs .list-group-item').forEach(item => item.classList.remove('active'));
                                this.classList.add('active');
                                const target = this.getAttribute('data-target');
                                document.querySelectorAll('.settings-section').forEach(sec => sec.style.display = 'none');
                                document.getElementById(target).style.display = 'block';
                            });
                        });
                        // Logout modal show
                        document.getElementById('logout-btn').addEventListener('click', function() {
                            new bootstrap.Modal(document.getElementById('logoutModal')).show();
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Bootstrap Toast Container (Password Only) -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <?php if (!empty($passSuccess)) : ?>
                <div class="toast align-items-center text-bg-success border-0" role="alert"
                    data-bs-delay="2000" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= htmlspecialchars($passSuccess) ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            <?php elseif (!empty($passError)) : ?>
                <div class="toast align-items-center text-bg-danger border-0" role="alert"
                    data-bs-delay="2000" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= htmlspecialchars($passError) ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($passSuccess) || !empty($passError)) : ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                    toastElList.forEach(function(toastEl) {
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    });
                });
            </script>
        <?php endif; ?>


</body>

</html>
<?php
session_start();
include '../db/connection.php'; // MySQLi connection ($conn)

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to fetch user and role-specific info
function fetchUserData($conn, $user_id)
{
    $userData = [];

    $sqlUser = "SELECT id, name, email, avatar, role, status FROM users WHERE id = '$user_id'";
    $resultUser = mysqli_query($conn, $sqlUser);

    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $user = mysqli_fetch_assoc($resultUser);

        $specific_id = '';
        $contact = '';
        $department = '';

        if ($user['role'] === 'student') {
            $sqlStudent = "SELECT student_id, contact, department FROM students WHERE user_id = '$user_id'";
            $resultStudent = mysqli_query($conn, $sqlStudent);
            if ($resultStudent && mysqli_num_rows($resultStudent) > 0) {
                $student = mysqli_fetch_assoc($resultStudent);
                $specific_id = $student['student_id'];
                $contact = $student['contact'];
                $department = $student['department'];
            }
        } elseif ($user['role'] === 'teacher') {
            $sqlTeacher = "SELECT employee_id, contact, department FROM teachers WHERE user_id = '$user_id'";
            $resultTeacher = mysqli_query($conn, $sqlTeacher);
            if ($resultTeacher && mysqli_num_rows($resultTeacher) > 0) {
                $teacher = mysqli_fetch_assoc($resultTeacher);
                $specific_id = $teacher['employee_id'];
                $contact = $teacher['contact'];
                $department = $teacher['department'];
            }
        }

        $userData = [
            'user' => $user,
            'specific_id' => $specific_id,
            'contact' => $contact,
            'department' => $department
        ];
    } else {
        die("User data not found.");
    }

    return $userData;
}

// Fetch fresh user data
$data = fetchUserData($conn, $user_id);
$user = $data['user'];
$specific_id = $data['specific_id'];
$contact = $data['contact'];
$department = $data['department'];

/* ======================
   Handle Avatar Upload/Delete
   ====================== */
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
                $oldAvatar = $user['avatar'];
                if (!empty($oldAvatar) && file_exists("../" . $oldAvatar)) {
                    unlink("../" . $oldAvatar);
                }

                mysqli_query($conn, "UPDATE users SET avatar='$avatarPath' WHERE id='$user_id'");
                $user['avatar'] = $avatarPath;
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_avatar'])) {
    if (!empty($user['avatar']) && file_exists("../" . $user['avatar'])) {
        unlink("../" . $user['avatar']);
    }
    mysqli_query($conn, "UPDATE users SET avatar=NULL WHERE id='$user_id'");
    $user['avatar'] = null;
}

/* ======================
   Handle Profile Info Update
   ====================== */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contactNew = trim($_POST['contact']);
    $departmentNew = trim($_POST['department']);

    if (!empty($name) && !empty($email)) {
        $sqlUpdateUser = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
        $updatedUser = mysqli_query($conn, $sqlUpdateUser);

        if ($updatedUser) {
            if ($_POST['role'] === 'student') {
                $sqlUpdateStudent = "UPDATE students SET contact='$contactNew', department='$departmentNew' WHERE user_id='$user_id'";
                $updatedSpecific = mysqli_query($conn, $sqlUpdateStudent);
            } elseif ($_POST['role'] === 'teacher') {
                $sqlUpdateTeacher = "UPDATE teachers SET contact='$contactNew', department='$departmentNew' WHERE user_id='$user_id'";
                $updatedSpecific = mysqli_query($conn, $sqlUpdateTeacher);
            } else {
                $updatedSpecific = true;
            }

            if ($updatedSpecific) {
                // 🔄 Re-fetch fresh updated user data
                $data = fetchUserData($conn, $user_id);
                $user = $data['user'];
                $specific_id = $data['specific_id'];
                $contact = $data['contact'];
                $department = $data['department'];

                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var toastElement = document.getElementById('liveToast');
                        if (toastElement) {
                            var toast = new bootstrap.Toast(toastElement);
                            toast.show();
                        }
                    });
                </script>";
            }
        }
    }
}


/* ======================
   Handle Notification Settings
   ====================== */
$sqlNotify = "SELECT email_notify FROM users WHERE id = '$user_id'";
$resultNotify = mysqli_query($conn, $sqlNotify);
$email_notify = 1; // default
if ($resultNotify && mysqli_num_rows($resultNotify) > 0) {
    $row = mysqli_fetch_assoc($resultNotify);
    $email_notify = $row['email_notify'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_notifications'])) {
    $new_notify = isset($_POST['email_notify']) ? 1 : 0;
    mysqli_query($conn, "UPDATE users SET email_notify = $new_notify WHERE id = '$user_id'");
    $email_notify = $new_notify;
}

/* ======================
   Handle Password Change
   ====================== */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!empty($currentPassword) && !empty($newPassword) && $newPassword === $confirmPassword) {
        $sql = "SELECT password FROM users WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($currentPassword, $row['password'])) {
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users SET password='$newHashedPassword' WHERE id='$user_id'");
                $passSuccess = "Password updated successfully.";
            } else {
                $passError = "Current password is incorrect.";
            }
        }
    } else {
        $passError = "Please fill correctly.";
    }
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
                    <h3 class="fw-bold mb-4">Account Settings</h3>
                    <div class="row g-4">
                        <!-- Left Menu -->
                        <div class="col-lg-4">
                            <div class="list-group mb-4 shadow-sm" id="settings-tabs">
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="profile-tab">
                                    <i class="bi bi-person-lines-fill me-2 "></i> Profile Info
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="notification-tab">
                                    <i class="bi bi-bell me-2"></i> Notification Settings
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

                            <?php
                            require 'profile.php'
                            ?>

                            <?php
                            require 'notification.php'
                            ?>

                            <?php
                            require 'password.php'
                            ?>

                        </div>
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
    <!-- Toast container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Profile updated successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


    <!-- Toast container  -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
        <div id="passwordToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= htmlspecialchars($passError) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="passwordSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= htmlspecialchars($passSuccess) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($passError)): ?>
                var errorToastEl = document.getElementById('passwordToast');
                if (errorToastEl) {
                    var errorToast = new bootstrap.Toast(errorToastEl);
                    errorToast.show();
                }
            <?php endif; ?>
            <?php if (!empty($passSuccess)): ?>
                var successToastEl = document.getElementById('passwordSuccessToast');
                if (successToastEl) {
                    var successToast = new bootstrap.Toast(successToastEl);
                    successToast.show();
                }
            <?php endif; ?>
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
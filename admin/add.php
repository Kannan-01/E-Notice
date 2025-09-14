<?php
session_start();
include '../db/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$toastMessage = '';
$toastIsError = false;

/* ----------------- NOTICES ----------------- */
// Create notices table if not exists
$createNoticesTable = "
CREATE TABLE IF NOT EXISTS notices (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  description TEXT COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  department VARCHAR(100) COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  target ENUM('student', 'teacher', 'all') COLLATE utf8mb4_0900_ai_ci DEFAULT 'all',
  valid_from DATE DEFAULT NULL,
  valid_until DATE DEFAULT NULL,
  status ENUM('active', 'inactive') COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  posted_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
";
mysqli_query($conn, $createNoticesTable);

// Save notice
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_notice'])) {
    $title       = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $department  = $_POST['department'] ?? 'All';
    $target      = $_POST['target'] ?? 'all';
    $valid_from  = $_POST['valid_from'] ?? null;
    $valid_until = $_POST['valid_until'] ?? null;
    $status      = 'active';
    $posted_at   = date('Y-m-d H:i:s');

    $sql = "INSERT INTO notices 
            (title, description, department, target, valid_from, valid_until, status, posted_at)
            VALUES (
                '$title',
                '$description',
                '$department',
                '$target',
                " . ($valid_from ? "'$valid_from'" : "NULL") . ",
                " . ($valid_until ? "'$valid_until'" : "NULL") . ",
                '$status',
                '$posted_at'
            )";

    if (mysqli_query($conn, $sql)) {
        $toastMessage = "Notice saved successfully.";
        $toastIsError = false;
    } else {
        $toastMessage = "Error saving notice: " . mysqli_error($conn);
        $toastIsError = true;
    }
}

/* ----------------- HOLIDAYS ----------------- */
// Create holidays table if not exists
$createHolidayTable = "
CREATE TABLE IF NOT EXISTS holidays (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  holiday_date DATE DEFAULT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  department VARCHAR(100) NOT NULL,
  target ENUM('students','teachers','all') NOT NULL DEFAULT 'all',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
mysqli_query($conn, $createHolidayTable);

// Save holiday
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['announce'])) {
    $title       = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $department  = $_POST['department'] ?? 'All';
    $target      = $_POST['target'] ?? 'all';

    $holiday_date = !empty($_POST['holiday_date']) ? "'" . $_POST['holiday_date'] . "'" : "NULL";
    $start_date   = !empty($_POST['start_date']) ? "'" . $_POST['start_date'] . "'" : "NULL";
    $end_date     = !empty($_POST['end_date']) ? "'" . $_POST['end_date'] . "'" : "NULL";

    $sql = "
      INSERT INTO holidays (title, description, holiday_date, start_date, end_date, department, target, status) 
      VALUES ('$title', '$description', $holiday_date, $start_date, $end_date, '$department', '$target', 'active')
    ";

    if (mysqli_query($conn, $sql)) {
        $toastMessage = "Holiday announced successfully.";
        $toastIsError = false;
    } else {
        $toastMessage = "Error saving holiday: " . mysqli_error($conn);
        $toastIsError = true;
    }
}

/* ----------------- EXAMS ----------------- */
// Create exams table if not exists
$createExamTable = "
CREATE TABLE IF NOT EXISTS exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_title VARCHAR(255),
    exam_type VARCHAR(100),
    department VARCHAR(100),
    location VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
mysqli_query($conn, $createExamTable);

// Create subjects table if not exists
$createSubjectTable = "
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_id INT,
    subject_name VARCHAR(255),
    exam_date DATE,
    session VARCHAR(50),
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
mysqli_query($conn, $createSubjectTable);


// Save exam
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announce_exam'])) {
    mysqli_begin_transaction($conn);
    try {
        $exam_title  = $_POST['exam_title'] ?? '';
        $exam_type   = $_POST['exam_type'] ?? '';
        $department  = $_POST['exam_department'] ?? 'All';
        $location    = $_POST['exam_location'] ?? '';

        $insertExamSql = "INSERT INTO exams (exam_title, exam_type, department, location, created_at)
                          VALUES ('$exam_title', '$exam_type', '$department', '$location', NOW())";

        if (!mysqli_query($conn, $insertExamSql)) {
            throw new Exception("Error inserting exam: " . mysqli_error($conn));
        }

        $exam_id = mysqli_insert_id($conn);

        $subject_names    = $_POST['subject_name'] ?? [];
        $subject_dates    = $_POST['subject_date'] ?? [];
        $subject_sessions = $_POST['subject_session'] ?? [];

        if (count($subject_names) !== count($subject_dates) || count($subject_names) !== count($subject_sessions)) {
            throw new Exception("Mismatched subjects input.");
        }

        for ($i = 0; $i < count($subject_names); $i++) {
            $sub_name    = $subject_names[$i] ?? '';
            $sub_date    = $subject_dates[$i] ?? null;
            $sub_session = $subject_sessions[$i] ?? '';

            $insertSubjectSql = "INSERT INTO subjects (exam_id, subject_name, exam_date, session)
                                 VALUES ($exam_id, '$sub_name', " . ($sub_date ? "'$sub_date'" : "NULL") . ", '$sub_session')";

            if (!mysqli_query($conn, $insertSubjectSql)) {
                throw new Exception("Error inserting subject: " . mysqli_error($conn));
            }
        }

        mysqli_commit($conn);
        $toastMessage = "Exam announced successfully.";
        $toastIsError = false;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $toastMessage = "Failed to announce exam: " . $e->getMessage();
        $toastIsError = true;
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
    <script src="./assets/js/noticeValidation.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'add';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="mx-auto" style="max-width: 900px;">
                    <h3 class="fw-bold mb-4">Add a <span class="text-warning">Notification</span></h3>
                    <div class="row g-4">
                        <!-- Left Menu -->
                        <div class="col-lg-4">
                            <div class="list-group mb-4 shadow-sm" id="settings-tabs">
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="notice-tab">
                                    <i class="bi bi-file-text me-2"></i> Notice
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="holiday-tab">
                                    <i class="bi bi-calendar2-event me-2"></i> Holiday
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="exam-tab">
                                    <i class="bi bi-clipboard-check me-2"></i> Exam
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-target="events-tab">
                                    <i class="bi bi-broadcast me-2"></i> Events
                                </button>
                            </div>
                        </div>
                        <!-- Tab Content -->
                        <div class="col-lg-8">

                            <?php
                            require 'notices.php'
                            ?>

                            <?php
                            require 'holidays.php'
                            ?>

                            <?php
                            require 'exams.php'
                            ?>

                            <?php
                            require 'events.php'
                            ?>

                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    document.querySelectorAll('#settings-tabs button').forEach(tab => {
                        tab.addEventListener('click', function() {
                            // Remove active class on all buttons
                            document.querySelectorAll('#settings-tabs .list-group-item').forEach(item => item.classList.remove('active'));

                            // Set active on clicked tab
                            this.classList.add('active');

                            // Hide all tab contents
                            document.querySelectorAll('.settings-section').forEach(sec => sec.style.display = 'none');

                            // Show targeted tab content
                            const target = this.getAttribute('data-target');
                            const targetEl = document.getElementById(target);
                            if (targetEl) {
                                targetEl.style.display = 'block';
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div id="toastNotification" class="toast align-items-center text-bg-<?php echo $toastIsError ? 'danger' : 'success'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo htmlspecialchars($toastMessage); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showToast(message, isError) {
            const toastEl = document.getElementById('toastNotification');
            if (isError) {
                toastEl.classList.remove('text-bg-success');
                toastEl.classList.add('text-bg-danger');
            } else {
                toastEl.classList.remove('text-bg-danger');
                toastEl.classList.add('text-bg-success');
            }
            toastEl.querySelector('.toast-body').textContent = message;
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // Show toast after page load if message present
        document.addEventListener('DOMContentLoaded', () => {
            const msg = <?php echo json_encode($toastMessage); ?>;
            if (msg) {
                const isError = <?php echo json_encode($toastIsError); ?>;
                showToast(msg, isError);
            }
        });
    </script>
</body>

</html>
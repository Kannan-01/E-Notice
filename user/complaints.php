<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../db/connection.php';

// Create complaints table if not exists
$createTableSQL = "
CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    status ENUM('Pending','In Progress','Resolved','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
$conn->query($createTableSQL);

$toastMessage = '';
$toastIsError = false;

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // fetch department based on role
    $dept = 'Unknown';
    $roleQ = $conn->query("SELECT role FROM users WHERE id = $userId LIMIT 1");
    if ($roleQ && $roleQ->num_rows > 0) {
        $role = $roleQ->fetch_assoc()['role'];
        if ($role === 'student') {
            $dQ = $conn->query("SELECT department FROM students WHERE user_id = $userId LIMIT 1");
            $dept = ($dQ && $dQ->num_rows > 0) ? $dQ->fetch_assoc()['department'] : 'Unknown';
        } elseif ($role === 'teacher') {
            $dQ = $conn->query("SELECT department FROM teachers WHERE user_id = $userId LIMIT 1");
            $dept = ($dQ && $dQ->num_rows > 0) ? $dQ->fetch_assoc()['department'] : 'Unknown';
        } else {
            $dept = 'Admin';
        }
    }

    if (!empty($title) && !empty($description) && !empty($category)) {
        $sql = "INSERT INTO complaints (user_id, title, description, category, department) 
                VALUES ('$userId', '$title', '$description', '$category', '$dept')";
        if ($conn->query($sql)) {
            // Redirect so form does not resubmit
            header("Location: complaints.php?success=1");
            exit();
        } else {
            $toastMessage = "Error: " . $conn->error;
            $toastIsError = true;
        }
    } else {
        $toastMessage = "Please fill in all required fields.";
        $toastIsError = true;
    }
}

// Show success message if redirected
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $toastMessage = "Complaint submitted successfully!";
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
            <!-- sidebar -->
            <?php
            $currentPage = 'feedback';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container" style="max-width: 720px;">
                    <!-- Page Heading -->
                    <h2 class="fw-bold mb-4">Complaints & Suggestions</h2>

                    <div class="cards shadow-sm rounded-4 p-4 bg-white">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs border-0 mb-4" id="feedbackTabs" style="--bs-nav-tabs-border-width: 0;">
                            <li class="nav-item"> <button class="nav-link active fw-semibold" id="overview-tab" type="button" style="background:#fffbe6; color: #c89110; border-radius: 8px 8px 0 0;">Complaints</button> </li>
                        </ul>
                        <form method="POST" id="feedback-form">
                            <div>
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" name="title" class="form-control mb-3"
                                    placeholder="Briefly describe your complaint" required>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Category</label>
                                <select class="form-select mb-3" name="category" required>
                                    <option value="" disabled selected>Select category</option>
                                    <option>Facility Issue</option>
                                    <option>Academic</option>
                                    <option>Staff/Faculty</option>
                                    <option>Hostel</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-bold">Describe the issue</label>
                                <textarea class="form-control mb-3" name="description" rows="4"
                                    placeholder="e.g. Projector not working in Lab 2" required></textarea>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="reset" class="btn btn-outline-secondary me-2">Clear</button>
                                <button type="submit"
                                    class="btn btn-warning px-5 py-2 fw-bold text-white">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <?php if (!empty($toastMessage)) : ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div class="toast align-items-center text-white <?php echo $toastIsError ? 'bg-danger' : 'bg-success'; ?> border-0"
                role="alert" data-bs-autohide="true" data-bs-delay="2000">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $toastMessage; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'))
            toastElList.map(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl)
                toast.show()
            })
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
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
    status ENUM('Pending','Resolved') DEFAULT 'Pending',
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

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $toastMessage = "Complaint submitted successfully!";
}
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

        .form-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
        }


        .form-control,
        .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            transition: 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ffb300;
            box-shadow: 0 0 0 0.15rem rgba(255, 179, 0, 0.25);
        }

        .btn-warning {
            background-color: #ffb300;
            border: none;
            transition: 0.2s;
        }

        .btn-warning:hover {
            background-color: #e0a200;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
        }

        .toast {
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            font-weight: 500;
        }

        .toast.bg-success {
            background: linear-gradient(135deg, #28a745, #5fd070);
        }

        .toast.bg-danger {
            background: linear-gradient(135deg, #dc3545, #f06a7e);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'feedback';
            require './common/sidebar.php';
            ?>

            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container" style="max-width: 720px;">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="page-title mb-0">
                            Submit a <span class="accent">Complaint</span>
                        </h2>
                    </div>

                    <div class="form-card p-4">
                        <form method="POST" id="complaint-form">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Brief title of your issue" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="" disabled selected>Select category</option>
                                    <option>Facility Issue</option>
                                    <option>Academic</option>
                                    <option>Staff/Faculty</option>
                                    <option>Hostel</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Describe your issue in detail" required></textarea>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="reset" class="btn btn-outline-secondary me-2 px-4">Clear</button>
                                <button type="submit" class="btn btn-warning text-white px-5 fw-semibold">Submit</button>
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
            <div class="toast align-items-center text-white <?php echo $toastIsError ? 'bg-danger' : 'bg-success'; ?> border-0 show"
                role="alert" data-bs-autohide="true" data-bs-delay="2000">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $toastMessage; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
</body>

</html>

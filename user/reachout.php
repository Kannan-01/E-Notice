<?php
session_start();
include '../db/connection.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userRole = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reach Out | E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .contact-card {
            max-width: 700px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        h2 span {
            color: #ffc107;
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title h2 {
            font-weight: 700;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php
        $currentPage = 'reachout';
        require './common/sidebar.php';
        ?>

        <!-- Main Panel -->
        <div class="col-lg-9 py-5 px-4">
            <div class="container my-4">
                
                <!-- Centered Title -->
                <div class="page-title">
                    <h2 class="fw-bold mb-3">
                        <span>Reach Out</span> to Us
                    </h2>
                    <p class="text-muted">We’re here to listen — send us your queries or feedback below.</p>
                </div>

                <!-- Contact Form -->
                <div class="contact-card">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description" rows="5" placeholder="Write your message here..." required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning fw-bold text-white px-5">
                                <i class="bi bi-send-fill me-1"></i>Send Mail
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const subject = encodeURIComponent(document.getElementById('subject').value.trim());
    const body = encodeURIComponent(document.getElementById('description').value.trim());

    if (!subject || !body) {
        alert("Please fill in both fields before sending.");
        return;
    }

    // Open Gmail compose in new tab
    const gmailLink = `https://mail.google.com/mail/?view=cm&fs=1&to=enoticekmm@gmail.com&su=${subject}&body=${body}`;
    window.open(gmailLink, '_blank');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

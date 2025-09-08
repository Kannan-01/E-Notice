<!doctype html>
<html lang="en">

<head>
    <title>dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/e7761c5b02.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        <?php
        $currentPage = 'exam';
        require './common/sidebar.php';
        ?>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <?php require './common/header.php' ?>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3">
                    <li class="breadcrumb-item fs-5 fw-bold"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item fs-5 fw-bold active" aria-current="page">Publish Exam Notification</li>
                </ol>
            </nav>

            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-lg-10 col-sm-12">
                        <form method="post" enctype="multipart/form-data">

                            <!-- Exam Title -->
                            <div class="mb-3">
                                <label for="exam_title" class="form-label">Exam Title</label>
                                <input type="text" class="form-control shadow-none" id="exam_title" name="exam_title" placeholder="Enter the exam title" required />
                            </div>

                            <!-- Exam Type -->
                            <div class="mb-3">
                                <label for="exam_type" class="form-label">Exam Type / Category</label>
                                <select class="form-select shadow-none" id="exam_type" name="exam_type" required>
                                    <option value="" disabled selected>Select exam type</option>
                                    <option value="Internal">Internal</option>
                                    <option value="Model">Model</option>
                                    <option value="Semester">Semester</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select shadow-none" id="department" name="department" required>
                                    <option value="" disabled selected>Select department</option>
                                    <option value="Commerce">Commerce</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Fashion Design">Fashion Design</option>
                                    <option value="Business Administration">Business Administration</option>
                                    <option value="Psychology">Psychology</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="English">English</option>
                                    <option value="Social Work">Social Work</option>
                                </select>
                            </div>

                            <!-- Subject Rows with Date & Session -->
                            <label class="form-label">Subjects with Schedule</label>
                            <div id="subjectsWrapper">
                                <div class="row g-2 subject-row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject[]" class="form-control shadow-none" placeholder="Subject Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="subject_date[]" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Session</label>
                                        <select class="form-select shadow-none" name="subject_session[]" required>
                                            <option value="" disabled selected>Select session</option>
                                            <option value="FN">Forenoon (9:30 AM - 12:30 PM)</option>
                                            <option value="AN">Afternoon (2:00 PM - 5:00 PM)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        <button type="button" class="btn btn-success addRow mt-auto"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="mb-3 mt-3">
                                <label for="description" class="form-label">Exam Instructions / Notes</label>
                                <textarea class="form-control shadow-none" id="description" name="description" rows="4" placeholder="E.g., Bring ID card, hall ticket, etc."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="announce" class="btn text-white form-control" style="background-color:#f8b739;">
                                Announce Exam
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Dynamic Subject Row Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const wrapper = document.getElementById("subjectsWrapper");

            wrapper.addEventListener("click", function(e) {
                const target = e.target.closest("button");
                if (!target) return;

                if (target.classList.contains("addRow")) {
                    const newRow = wrapper.querySelector(".subject-row").cloneNode(true);
                    newRow.querySelectorAll("input").forEach(input => input.value = "");
                    newRow.querySelectorAll("select").forEach(select => select.selectedIndex = 0);
                    const newBtn = newRow.querySelector("button");
                    newBtn.classList.remove("btn-success", "addRow");
                    newBtn.classList.add("btn-danger", "removeRow");
                    newBtn.innerHTML = '<i class="fas fa-minus"></i>';
                    wrapper.appendChild(newRow);
                } else if (target.classList.contains("removeRow")) {
                    target.closest(".subject-row").remove();
                }
            });
        });
    </script>
</body>

</html>
<?php
include '../db/connection.php';

if (isset($_POST["announce"])) {
    // Create main table if not exists
    $createExamTable = "
        CREATE TABLE IF NOT EXISTS exams (
            id INT AUTO_INCREMENT PRIMARY KEY,
            exam_title VARCHAR(255),
            exam_type VARCHAR(100),
            session VARCHAR(10),
            department VARCHAR(100),
            description TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ";

    // Create subjects table if not exists
    $createSubjectTable = "
        CREATE TABLE IF NOT EXISTS subjects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            exam_id INT,
            subject_name VARCHAR(255),
            exam_date DATE,
            session VARCHAR(10),
            FOREIGN KEY (exam_id) REFERENCES exam_notifications(id) ON DELETE CASCADE
        );
    ";

    mysqli_query($conn, $createExamTable);
    mysqli_query($conn, $createSubjectTable);

    // Capture input
    $exam_title  = $_POST['exam_title'];
    $exam_type   = $_POST['exam_type'];
    $session     = $_POST['session'];
    $department  = $_POST['department'];
    $description = $_POST['description'];

    // Insert into exam_notifications
    $insertExam = "
        INSERT INTO exams (exam_title, exam_type, session, department, description)
        VALUES ('$exam_title', '$exam_type', '$session', '$department', '$description')
    ";

    if (mysqli_query($conn, $insertExam)) {
        $exam_id = mysqli_insert_id($conn);

        // Insert each subject with date and session (FN/AN)
        foreach ($_POST['subject'] as $index => $subject_name) {
            $subject_date  = $_POST['subject_date'][$index];
            $subject_time  = $_POST['subject_time'][$index];

            $insertSubject = "
                INSERT INTO subjects (exam_id, subject_name, exam_date, session)
                VALUES ('$exam_id', '$subject_name', '$subject_date', '$subject_time')
            ";

            mysqli_query($conn, $insertSubject);
        }

        echo "<script>alert('Exam notification published successfully'); window.location.href='exam.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
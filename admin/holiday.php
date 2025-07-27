<!doctype html>
<html lang="en">

<head>
    <title>Holiday Announcement</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e7761c5b02.js" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <?php
        $currentPage = 'holiday';
        require './common/sidebar.php';
        ?>

        <div id="content" class="p-4 p-md-5">
            <?php require './common/header.php'; ?>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item fs-3 fw-bold"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Announce Holiday</li>
                </ol>
            </nav>

            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <form method="post">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Holiday Title</label>
                                <input type="text" class="form-control shadow-none" id="title" name="title" placeholder="e.g. Pongal Holiday" required />
                            </div>

                            <!-- Holiday Type -->
                            <div class="mb-3">
                                <label for="holiday_type" class="form-label">Holiday Type</label>
                                <select class="form-select shadow-none" id="holiday_type" name="holiday_type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="Public">Public</option>
                                    <option value="Festival">Festival</option>
                                    <option value="Institutional">Institutional</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Toggle Switch for Multi-Day -->
                            <div class="form-check form-switch mb-3 ms-3">
                                <input class="form-check-input shadow-none" type="checkbox" id="multiDayToggle" />
                                <label class="form-check-label" for="multiDayToggle">Multi-Day Holiday?</label>
                            </div>

                            <!-- Single-Day Date -->
                            <div class="mb-3" id="singleDayDiv">
                                <label for="holiday_date" class="form-label">Holiday Date</label>
                                <input type="date" class="form-control shadow-none" id="holiday_date" name="holiday_date" />
                            </div>

                            <!-- Multi-Day Date Range -->
                            <div class="row" id="multiDayDiv" style="display: none;">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">From Date</label>
                                    <input type="date" class="form-control shadow-none" id="start_date" name="start_date" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">To Date</label>
                                    <input type="date" class="form-control shadow-none" id="end_date" name="end_date" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description / Reason</label>
                                <textarea class="form-control shadow-none" id="description" name="description" rows="4" placeholder="Enter reason or note for the holiday..." required></textarea>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select shadow-none" id="department" name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="All">All</option>
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

                            <!-- Submit -->
                            <button type="submit" name="announce" class="btn text-white form-control" style="background-color:#f8b739;">
                                Announce Holiday
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

    <script>
        const toggle = document.getElementById("multiDayToggle");
        const singleDayDiv = document.getElementById("singleDayDiv");
        const multiDayDiv = document.getElementById("multiDayDiv");

        toggle.addEventListener("change", function() {
            if (toggle.checked) {
                singleDayDiv.style.display = "none";
                multiDayDiv.style.display = "flex";
                // Make range fields required, remove required from single
                document.getElementById("holiday_date").required = false;
                document.getElementById("start_date").required = true;
                document.getElementById("end_date").required = true;
            } else {
                singleDayDiv.style.display = "block";
                multiDayDiv.style.display = "none";
                document.getElementById("holiday_date").required = true;
                document.getElementById("start_date").required = false;
                document.getElementById("end_date").required = false;
            }
        });
    </script>
</body>

</html>
<?php
include '../db/connection.php'; // Updated path to connection file

if (isset($_POST["announce"])) {

    // Get POST data
    $title = $_POST['title'];
    $type = $_POST['holiday_type'];
    $description = $_POST['description'];
    $department = $_POST['department'];

    $isMultiDay = !empty($_POST['start_date']) && !empty($_POST['end_date']);

    if ($isMultiDay) {
        $holiday_date = "NULL";
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    } else {
        $holiday_date = $_POST['holiday_date'];
        $start_date = "NULL";
        $end_date = "NULL";
    }

    // Create table if not exists
    $createTable = "CREATE TABLE IF NOT EXISTS holiday (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        holiday_type VARCHAR(100),
        holiday_date DATE,
        start_date DATE,
        end_date DATE,
        description TEXT,
        department VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $createTable);

    // Insert query (no sanitization)
    $query = "INSERT INTO holiday (title, holiday_type, holiday_date, start_date, end_date, description, department)
    VALUES (
        '$title',
        '$type',
        " . ($holiday_date === "NULL" ? "NULL" : "'$holiday_date'") . ",
        " . ($start_date === "NULL" ? "NULL" : "'$start_date'") . ",
        " . ($end_date === "NULL" ? "NULL" : "'$end_date'") . ",
        '$description',
        '$department'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Holiday announced successfully.'); window.location.href='holiday.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); history.back();</script>";
    }

    mysqli_close($conn);
}
?>

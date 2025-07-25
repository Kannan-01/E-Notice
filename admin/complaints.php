<!doctype html>
<html lang="en">

<head>
    <title>dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../noti.ico" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e7761c5b02.js" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/style.css" />

    <style>
        .card {
            margin-bottom: 20px;
            border-left: 5px solid #6c757d;

        }

        .badge-complaint {
            background-color: #dc3545;
        }

        .badge-suggestion {
            background-color: #0d6efd;
        }
    </style>

</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <!-- sidebar -->

        <!-- sidebar -->
        <?php
        $currentPage = 'complaints';
        require './common/sidebar.php' ?>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <?php require './common/header.php' ?>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item fs-3 fw-bold"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Library</li>
                </ol>
            </nav>



            <!-- Dummy Complaint Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Classroom Projector Not Working</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Submitted by: John Doe | Dept: Computer Science | Date: 2025-07-19</h6>
                    <p class="card-text">The projector in CS Lab 2 hasn't been working for the past week. Kindly look into it.</p>
                    <span class="badge badge-complaint text-white">Complaint</span>
                </div>
            </div>

            <!-- Dummy Suggestion Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add More Charging Points in Library</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Submitted by: Meera S | Dept: Commerce | Date: 2025-07-18</h6>
                    <p class="card-text">It would be helpful if we had more charging outlets in the library for laptops and phones.</p>
                    <span class="badge badge-suggestion text-white">Suggestion</span>
                </div>
            </div>

            <!-- Add more entries as needed -->

        </div>

    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
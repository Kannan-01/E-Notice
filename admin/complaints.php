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

        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url('/e-notice/uploads/user.jpg');"></a>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="#">Add Notice</a>
                    </li>
                    <li>
                        <a href="view.php">View Notice</a>
                    </li>
                    <li>
                        <a href="exam.php">Post Exam Notification</a>
                    </li>
                    <li>
                        <a href="holiday.php">Announce Holiday</a>
                    </li>
                    <li class="active">
                        <a href="complaints.php">Complaints & Suggestions</a>
                    </li>
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Log out
                        </a>
                    </li>
                </ul>
                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> |
                        All rights reserved
                    </p>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title" id="exampleModalLabel">Are you sure you want to <br>log out?</h6>
                    </div>

                    <div class="modal-footer border-0 justify-content-end pt-0">
                        <a href="../index.php" class="btn btn-warning text-white btn-sm">Log Out</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Welcome, Admin</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

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
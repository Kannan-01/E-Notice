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

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- sidebar -->
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url('/e-notice/uploads/user.jpg');"></a>
                <ul class="list-unstyled components mb-5">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li class="active"><a href="#">Add Notice</a></li>
                    <li><a href="view.php">View Notice</a></li>
                    <li><a href="exam.php">Post Exam Notification</a></li>
                    <li><a href="holiday.php">Announce Holiday</a></li>
                    <li><a href="complaints.php">Complaints & Suggestions</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Log out</a></li>
                </ul>
                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> | All rights reserved
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

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
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
                    <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Add Notice</li>
                </ol>
            </nav>

            <div class="container mt-5 mb-5">
                <div class="row">
                    <!-- Left column -->
                    <div class="col-lg-8 col-sm-12">
                        <form action="add_notice.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control shadow-none" id="title" name="title" placeholder="Enter your title here" required />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control shadow-none" id="description" name="description" rows="4" placeholder="Give a brief description."></textarea>
                                <div class="form-text">Give a brief description.</div>
                            </div>

                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select shadow-none" id="department" name="department" required>
                                    <option value="" disabled selected>Select your department</option>
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

                            <div class="mb-3">
                                <label for="uploadImg" class="form-label">Upload Image (Optional)</label>
                                <input type="file" class="form-control shadow-none" id="uploadImg" name="uploadImg" />
                            </div>

                            <button type="submit" class="btn text-white form-control" style="background-color:#f8b739;">
                                Post your notice
                            </button>
                        </form>
                    </div>

                    <!-- Right column -->
                    <!-- <div class="col-lg-4 col-sm-12 col-md-12 d-flex justify-content-center align-items-center">
                        <label for="uploadImg" class="m-0">
                            <img id="imgPreview" src="https://images.pexels.com/photos/28216688/pexels-photo-28216688.png" alt="Click to upload" width="250" class="rounded responsive" style="cursor:pointer; object-fit:cover;" />
                        </label>
                    </div> -->
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
</body>

</html>

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

</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <!-- sidebar -->
        <?php
        $currentPage = 'exam';
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

            <div class="container mt-5 mb-5">
                <div class="row">

                    <div class="col-lg-8 col-sm-12">
                        <form action="#" method="post">

                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input
                                            type="text"
                                            class="form-control shadow-none"
                                            id="title"
                                            name="title"
                                            placeholder="Enter your title here"
                                            required />
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="holiday_date" class="form-label">Holiday Date</label>
                                <input type="date" class="form-control shadow-none" id="holiday_date" name="holiday_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Reason / Description</label>
                                <textarea
                                    class="form-control shadow-none"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Reason for holiday..."></textarea>
                                <div class="form-text">
                                    Give a brief description.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Department</label>
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

                            <button
                                type="submit"
                                class="btn text-white form-control"
                                style="background-color:#f8b739;">
                                Announce Holiday !
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
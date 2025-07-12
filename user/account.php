<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Notice</title>
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <!-- font awesome -->
    <script
        src="https://kit.fontawesome.com/e7761c5b02.js"
        crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/layout.css">

</head>

<body>
    <div class="wrapper d-flex align-items-stretch">

        <?php require '../common/sidebar.php' ?>
        <div id="content" class="p-4 p-md-5">
            <?php require '../common/header.php' ?>
            <div class="container">

                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light">
                        <li class="breadcrumb-item fs-3 fw-bold"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Account</li>
                    </ol>
                </nav>

                <div class="row">
                    <div
                        class="col-sm-12 col-lg-6 d-flex justify-content-center align-items-center flex-column">
                        <!-- profile image area -->
                        <label>
                            <input type="file" style="display: none" />
                            <div>
                                <img
                                width="150"
                                height="150"
                                class="rounded"
                                    src="../uploads/user.jpg"
                                    alt="Profile Image" />
                            </div>
                        </label>

                        <!-- name and password -->
                        <h1 class="fw-bolder mt-4 text-capitalize">
                            John <span class="text-dark">Doe</span>
                        </h1>
                        <div >
                            <button
                                class="btn border-0 text-decoration-underline"
                                data-bs-toggle="modal"
                                data-bs-target="#passModal">
                                Change Password
                            </button>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <!-- name -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Legal name:</div>
                                        <div class="small text-uppercase">John Doe</div>
                                    </div>
                                    <div>
                                        <button
                                            class="btn-link text-dark border-0 bg-white small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#nameModal">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item mt-2">
                                <!-- email -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Email address:</div>
                                        <div class="small">john.doe@example.com</div>
                                    </div>
                                    <div>
                                        <button
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#emailModal"
                                            class="btn-link text-dark border-0 bg-white small">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item mt-2">
                                <!-- phone number -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Phone number:</div>
                                        <div class="small">+91 9876543210</div>
                                    </div>
                                    <div>
                                        <button
                                            data-bs-toggle="modal"
                                            data-bs-target="#mobileModal"
                                            class="btn-link text-dark border-0 bg-white small">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item mt-2">
                                <!-- government id -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Government ID:</div>
                                        <div class="small">Uploaded</div>
                                    </div>
                                    <div>
                                        <button
                                            class="btn-link text-dark border-0 bg-white small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#proofModal">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item mt-2">
                                <!-- address -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Address:</div>
                                        <div class="small">123 Street, City, Country</div>
                                    </div>
                                    <div>
                                        <button
                                            class="btn-link text-dark border-0 bg-white small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addressModal">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item mt-2">
                                <!-- emergency number -->
                                <div class="d-flex justify-content-between p-2">
                                    <div>
                                        <div>Emergency Number:</div>
                                        <div class="small">+91 9988776655</div>
                                    </div>
                                    <div>
                                        <button
                                            class="btn-link text-dark border-0 bg-white small"
                                            data-bs-toggle="modal"
                                            data-bs-target="#emergencyModal">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>
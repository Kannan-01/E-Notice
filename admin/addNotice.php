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

        <?php
        $currentPage = 'addNotice';
        require './common/sidebar.php' ?>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <?php require './common/header.php' ?>

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
                        <form method="post" enctype="multipart/form-data">
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
                                <label for="target" class="form-label">Target Audience</label>
                                <select class="form-select shadow-none" id="target" name="target" required>
                                    <option value="Students" selected>Students</option>
                                    <option value="Teachers">Teachers</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="uploadImg" class="form-label">Upload Image (Optional)</label>
                                <input type="file" class="form-control shadow-none" id="uploadImg" name="uploadImg" />
                            </div>

                            <button type="submit" class="btn text-white form-control" style="background-color:#f8b739;" name="publish">
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
<?php
if (isset($_POST["publish"])) {
    include '../db/connection.php';

    // Create 'notices' table if it doesn't exist
    $table = "CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    department VARCHAR(100),
    target VARCHAR(50),  -- <== new field
    image VARCHAR(255),
    posted_at DATETIME
)";

    mysqli_query($conn, $table); // EXECUTE the table creation

    // Collect form data directly (no sanitization as per your preference)
    $title = $_POST['title'];
    $description = $_POST['description'];
    $department = $_POST['department'];
    $target = $_POST['target'];



    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['uploadImg']) && $_FILES['uploadImg']['error'] === 0) {
        $imageName = basename($_FILES['uploadImg']['name']);
        $imagePath = "uploads/" . time() . "_" . $imageName;
        $targetFile = "../" . $imagePath;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (!move_uploaded_file($_FILES['uploadImg']['tmp_name'], $targetFile)) {
                $imagePath = ''; // Reset on failure
            }
        }
    }

    // Insert into database
    $insert = "INSERT INTO notices (title, description, department, target, image, posted_at)
           VALUES ('$title', '$description', '$department', '$target', '$imagePath', NOW())";


    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Notice added successfully!'); window.location.href = 'view.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
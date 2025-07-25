<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Notice</title>
    <link rel="icon" type="image/x-icon" href="noti.ico" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Lexend&family=Work+Sans&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e7761c5b02.js" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="./assets/css/style.css" />

</head>

<body>
    <!-- Login Container -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="w-100" style="max-width: 400px;">
            <h1 style="font-size: 22px" class="text-center mb-4">
                <span class="text-dark fw-bolder">Welcome to </span>
                <span class="fw-bolder text-warning">E-Notice</span>
            </h1>
            <form method="post">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control shadow-none" placeholder="Email address" name="emailInput" />
                    <label for="emailInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control shadow-none" placeholder="Password" name="passwordInput" />
                    <label for="passwordInput">Password</label>
                </div>
                <div class="d-grid">
                    <button class="btn rounded text-white" style="background-color:#f8b739;" type="submit" name="login" value="login">
                        Login
                    </button>
                </div>
                <div class="text-center mt-4">
                    <p>
                        New user?
                        <a style="cursor: pointer" class="text-decoration-none text-warning" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="text-center">Sign Up</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h1 style="font-size: 22px">
                        <span class="text-dark">Welcome to </span>
                        <span class="fw-bolder text-warning">E-Notice</span>
                    </h1>
                    <form method="post">
                        <!-- First name -->
                        <div class="form-floating">
                            <input type="text" class="form-control shadow-none" name="fname" placeholder="First name" required />
                            <label>First name</label>
                        </div>

                        <!-- Last name -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control shadow-none" name="lname" placeholder="Last name" required />
                            <label>Last name</label>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control shadow-none" name="email" placeholder="Email address" required />
                            <label>Email address</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control shadow-none" name="password" placeholder="Password" required />
                            <label>Password</label>
                        </div>

                        <!-- Department -->
                        <div class="form-floating mb-3">
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
                            <label for="department">Select Department</label>
                        </div>


                        <!-- Role -->
                        <div class="form-floating mb-4">
                            <select class="form-select shadow-none" id="role" name="role" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select>
                            <label for="role">Select Role</label>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button class="btn rounded text-white" style="background-color:#f8b739;" type="submit" name="register" value="register">
                                Sign up
                            </button>
                        </div>
                        <div class="text-center mt-4">
                            <p>
                                Already registered?
                                <a style="color: #f8b739; cursor: pointer" class="text-decoration-none" data-bs-dismiss="modal">Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
include './db/connection.php';

if (isset($_POST["login"])) {

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Select database
    mysqli_select_db($conn, "enotice");

    $email = $_POST["emailInput"];
    $password = $_POST["passwordInput"];

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user["password"])) {

            session_start();
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {
                echo "<script>alert('Login successful!'); window.location.href='./admin/dashboard.php';</script>";
            } else {
                echo "<script>alert('Login successful!'); window.location.href='./user/home.php';</script>";
            }

            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }

    mysqli_close($conn);
}


// login

// register
if (isset($_POST["register"])) {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {

        // Create users table
        $table = "CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100) UNIQUE,
            password VARCHAR(255),
            department VARCHAR(100),
            role ENUM('admin','student','teacher') DEFAULT 'student',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if (!mysqli_query($conn, $table)) {
            echo "Error creating table: " . mysqli_error($conn);
        }

        // Collect data
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $name = $fname . ' ' . $lname;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $department = $_POST['department'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // Insert into users table
        $ins = "INSERT INTO users (name, email, password,department, role) VALUES ('$name', '$email', '$hashedPassword','$department','$role')";
        if (mysqli_query($conn, $ins)) {
            $_POST['fname'] = '';
            $_POST['lname'] = '';
            $_POST['email'] = '';
            $_POST['password'] = '';
            $_POST['role'] = '';
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>
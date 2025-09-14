<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign Up Form by Colorlib</title>

  <!-- Google font-->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
    rel="stylesheet" />
  <!-- Bootstrap -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />

  <!-- Main css -->
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
  <div class="main">
    <div class="container">
      <div class="sign-up-content">
        <form method="POST" class="signup-form">
          <h1 style="font-size: 22px" class="mb-3">
            <span class="text-dark fw-bolder">Welcome to </span>
            <span class="fw-bolder text-warning">E-Notice</span>
          </h1>
          <div class="form-radio">
            <input
              type="radio"
              name="role"
              value="student"
              id="student"
              checked />
            <label for="student">Student</label>
            <input type="radio" name="role" value="teacher" id="teacher" />
            <label for="teacher">Teacher</label>
          </div>

          <!-- Student Fields -->
          <div id="student-fields">
            <div class="form-textbox">
              <label for="student_id">Student ID</label><input type="text" name="student_id" id="student_id" />
            </div>
          </div>

          <!-- Teacher Fields -->
          <div id="teacher-fields" style="display: none">
            <div class="form-textbox">
              <label for="employee_id">Employee ID</label><input type="text" name="employee_id" id="employee_id" />
            </div>
          </div>

          <div class="form-textbox">
            <label for="name">Full name</label>
            <input type="text" name="name" id="name" />
          </div>
          <div class="form-textbox">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" />
          </div>
          <div class="form-textbox">
            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass" />
          </div>

          <!-- Common Fields -->
          <div class="form-textbox">
            <label for="contact">Contact</label><input type="text" name="contact" id="contact" />
          </div>

          <!-- Department -->
          <div class="form-floating form-selectbox mb-3">
            <label class="">Department</label>
            <select class="form-select shadow-none border-0" id="department" name="department" required>
              <option value="" disabled selected></option>
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

          <div class="form-textbox dbox">
            <input
              type="submit"
              name="submit"
              id="submit"
              class="submit"
              value="Create account" />
          </div>
        </form>

        <p class="loginhere mt-3">
          Already have an account ?<a href="login.php" class="loginhere-link">
            Log in</a>
        </p>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="./assets/vendor/jquery/jquery.min.js"></script>
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/validation.js"></script>
</body>
<!-- Bootstrap JS -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous"></script>

</html>

<?php
include '../db/connection.php';

function renderToast($message, $bgClass = 'bg-danger')
{
  // Outputs Bootstrap toast HTML and JS to show it on page load
  echo '
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
      <div id="liveToast" class="toast ' . $bgClass . ' text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body">
            ' . htmlspecialchars($message) . '
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var toastEl = document.getElementById("liveToast");
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
      });
    </script>';
}

if (isset($_POST["submit"])) {
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Create tables if not exist
  $table_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    role ENUM('student','teacher','admin') NOT NULL DEFAULT 'student',
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    email_notify TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

  $table_students = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    contact VARCHAR(15),
    department VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

  $table_teachers = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    contact VARCHAR(15),
    department VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";


  mysqli_query($conn, $table_users);
  mysqli_query($conn, $table_students);
  mysqli_query($conn, $table_teachers);

  // Collect form data
  $role = $_POST['role'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['pass'];
  $contact = $_POST['contact'];
  $department = $_POST['department'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Check email duplicate
  $check_email_sql = "SELECT id FROM users WHERE email = '$email'";
  $check_email_result = mysqli_query($conn, $check_email_sql);

  if (mysqli_num_rows($check_email_result) > 0) {
    renderToast('This email is already registered. Please use a different email.', 'bg-danger');
  } else {
    $duplicate = false;

    // Check student or employee ID duplicate
    if ($role === 'student') {
      $student_id = $_POST['student_id'];
      $check_studentid_sql = "SELECT id FROM students WHERE student_id = '$student_id'";
      $check_studentid_result = mysqli_query($conn, $check_studentid_sql);
      if (mysqli_num_rows($check_studentid_result) > 0) {
        renderToast('This student ID is already registered. Please Login.', 'bg-danger');
        $duplicate = true;
      }
    } elseif ($role === 'teacher') {
      $employee_id = $_POST['employee_id'];
      $check_employeeid_sql = "SELECT id FROM teachers WHERE employee_id = '$employee_id'";
      $check_employeeid_result = mysqli_query($conn, $check_employeeid_sql);
      if (mysqli_num_rows($check_employeeid_result) > 0) {
        renderToast('This employee ID is already registered. Please Login.', 'bg-danger');
        $duplicate = true;
      }
    }

    if (!$duplicate) {
      // Insert user
      $sql_user = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', '$role')";
      if (mysqli_query($conn, $sql_user)) {
        $user_id = mysqli_insert_id($conn);

        if ($role === 'student') {
          $sql_student = "INSERT INTO students (user_id, student_id, contact, department) VALUES ($user_id, '$student_id', '$contact', '$department')";
          mysqli_query($conn, $sql_student);
        } elseif ($role === 'teacher') {
          $sql_teacher = "INSERT INTO teachers (user_id, employee_id, contact, department) VALUES ($user_id, '$employee_id', '$contact', '$department')";
          mysqli_query($conn, $sql_teacher);
        }

        // Show success toast and redirect after short delay
        echo '
              <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
                <div id="successToast" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                  <div class="d-flex">
                    <div class="toast-body">
                      Account created successfully. Waiting for admin approval.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                </div>
              </div>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  var toastEl = document.getElementById("successToast");
                  var toast = new bootstrap.Toast(toastEl);
                  toast.show();
                  toastEl.addEventListener("hidden.bs.toast", function () {
                    window.location.href = "login.php";
                  });
                });
              </script>';
        $_POST = array();
      } else {
        renderToast('Error: ' . mysqli_error($conn), 'bg-danger');
      }
    }
  }
  mysqli_close($conn);
}
?>
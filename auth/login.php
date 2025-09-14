<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form - E-Notice</title>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Custom CSS (Style below or in separate style.css) -->
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
  <div class="main">
    <div class="container">
      <div class="sign-up-content">
        <form method="POST" class="signup-form">
          <h1 style="font-size: 22px" class="mb-3">
            <span class="text-dark fw-bolder">Welcome to</span>
            <span class="fw-bolder text-warning">E-Notice</span>
          </h1>
          <div class="form-textbox mb-3">
            <label for="login-email">Email</label>
            <input type="email" name="emailInput" id="login-email" required />
          </div>
          <div class="form-textbox">
            <label for="login-pass">Password</label>
            <input type="password" name="passwordInput" id="login-pass" required />
          </div>
          <div class="form-textbox dbox">
            <input type="submit" name="login" id="login-submit" class="submit" value="Login" />
          </div>
        </form>
        <p class="loginhere mt-3">
          Don't have an account?
          <a href="signup.php" class="loginhere-link">Sign up</a>
        </p>
      </div>
    </div>
  </div>
  <!-- JS files -->
  <script src="./assets/vendor/jquery/jquery.min.js"></script>
  <script src="./assets/js/main.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php
session_start(); // Always start session at the top

include '../db/connection.php';

function renderToast($message, $bgClass = 'bg-danger') {
    echo '
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
      <div id="liveToast" class="toast ' . $bgClass . ' text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="d-flex">
          <div class="toast-body">' . htmlspecialchars($message) . '</div>
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

if (isset($_POST["login"])) {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_select_db($conn, "enotice");
    $email = $_POST["emailInput"];
    $password = $_POST["passwordInput"];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($user = mysqli_fetch_assoc($result)) {
        if ($user["status"] !== "approved") {
            renderToast('Your account is not approved by admin yet.', 'bg-warning text-dark');
        } else if (password_verify($password, $user["password"])) {

            // Store user session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            // Success toast + redirect
            echo '
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
              <div id="successToast" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
                <div class="d-flex">
                  <div class="toast-body">
                    Login successful!
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
                toastEl.addEventListener("hidden.bs.toast", function () {';

            if ($user["role"] === "admin") {
                echo 'window.location.href = "../admin/dashboard.php";';
            } else {
                echo 'window.location.href = "../user/notice.php";';
            }

            echo '});
              });
            </script>';
            exit();
        } else {
            renderToast('Incorrect password.', 'bg-danger');
        }
    } else {
        renderToast('User not found.', 'bg-danger');
    }

    mysqli_close($conn);
}
?>

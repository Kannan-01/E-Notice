<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      overflow-x: hidden;
    }
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background: #343a40;
      color: white;
      padding-top: 60px;
    }
    .sidebar a {
      color: white;
      padding: 15px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
    .navbar {
      margin-left: 250px;
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-center">Admin Panel</h4>
  <a href="#">🏠 Dashboard</a>
  <a href="#">📌 Add Notice</a>
  <a href="#">🗂️ View Notices</a>
  <a href="#">📝 Post Exam Notification</a>
  <a href="#">📅 Announce Holiday</a>
  <a href="#">💬 Complaints & Suggestions</a>
  <a href="#">🚪 Logout</a>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand navbar-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">E-Notice Board - Admin</span>
    <div class="d-flex">
      <span class="me-3 text-muted">Welcome, Admin</span>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="main-content">
  <h2 class="mb-4">Dashboard</h2>

  <!-- Summary Cards -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Notices</h5>
          <p class="card-text fs-4">12</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Students</h5>
          <p class="card-text fs-4">240</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h5 class="card-title">Teachers</h5>
          <p class="card-text fs-4">25</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Feedback</h5>
          <p class="card-text fs-4">8</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Notices -->
  <div class="card mb-4">
    <div class="card-header bg-light">📌 Recent Notices</div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>Seminar on AI</strong> <span class="text-muted float-end">05 Jul 2025</span></li>
      <li class="list-group-item"><strong>Lab Manual Submission</strong> <span class="text-muted float-end">03 Jul 2025</span></li>
      <li class="list-group-item"><strong>Project Review</strong> <span class="text-muted float-end">30 Jun 2025</span></li>
      <li class="list-group-item"><strong>Library Due</strong> <span class="text-muted float-end">29 Jun 2025</span></li>
      <li class="list-group-item"><strong>Orientation Program</strong> <span class="text-muted float-end">27 Jun 2025</span></li>
    </ul>
  </div>

  <!-- Upcoming Exams -->
  <div class="card mb-4">
    <div class="card-header bg-light">📝 Upcoming Exams</div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Data Structures – <span class="text-muted float-end">10 Jul 2025</span></li>
      <li class="list-group-item">DBMS – <span class="text-muted float-end">12 Jul 2025</span></li>
      <li class="list-group-item">Operating Systems – <span class="text-muted float-end">14 Jul 2025</span></li>
    </ul>
  </div>

  <!-- Latest Feedback -->
  <div class="card mb-4">
    <div class="card-header bg-light">💬 Latest Feedback</div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>Arjun</strong> - Complaint: "Labs are too short." <span class="text-muted float-end">05 Jul</span></li>
      <li class="list-group-item"><strong>Meera</strong> - Suggestion: "Add previous year papers." <span class="text-muted float-end">04 Jul</span></li>
      <li class="list-group-item"><strong>Ravi</strong> - Complaint: "Exam hall was too noisy." <span class="text-muted float-end">03 Jul</span></li>
    </ul>
  </div>

  <!-- Quick Action Buttons -->
  <div class="mt-4">
    <a href="#" class="btn btn-primary me-2">➕ Add New Notice</a>
    <a href="#" class="btn btn-info me-2">📅 Post Exam Notification</a>
    <a href="#" class="btn btn-warning">📢 Announce Holiday</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

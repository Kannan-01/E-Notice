<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Complaints & Suggestions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .card {
      margin-bottom: 20px;
      border-left: 5px solid #0d6efd;
    }
    .badge-complaint {
      background-color: #dc3545;
    }
    .badge-suggestion {
      background-color: #0d6efd;
    }
    .filter-bar {
      margin-bottom: 25px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h3 class="mb-4 text-center text-primary">
    Complaints & Suggestions
  </h3>

  <!-- Filter and Search -->
  <div class="row filter-bar align-items-center">
    <div class="col-md-6 mb-2">
      <input type="text" class="form-control" id="searchInput" placeholder="Search by keyword or name">
    </div>
    <div class="col-md-6 mb-2">
      <select class="form-select" id="departmentFilter">
        <option value="">Filter by Department</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Commerce">Commerce</option>
        <option value="Mathematics">Mathematics</option>
        <option value="English">English</option>
      </select>
    </div>
  </div>

  <!-- Complaints & Suggestions Cards -->
  <div id="complaintList">
    <!-- Card 1 -->
    <div class="card complaint-item" data-dept="Computer Science">
      <div class="card-body">
        <h5 class="card-title">Projector Not Working</h5>
        <h6 class="card-subtitle mb-2 text-muted">
          Submitted by: John Doe | Dept: Computer Science | Date: 2025-07-19
        </h6>
        <p>The projector in CS Lab 2 hasn't been working for a week. Please check.</p>
        <span class="badge badge-complaint text-white">Complaint</span>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="card complaint-item" data-dept="Commerce">
      <div class="card-body">
        <h5 class="card-title">Add Charging Points</h5>
        <h6 class="card-subtitle mb-2 text-muted">
          Submitted by: Meera S | Dept: Commerce | Date: 2025-07-18
        </h6>
        <p>More charging outlets in the library would help with laptops and mobile devices.</p>
        <span class="badge badge-suggestion text-white">Suggestion</span>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Filter -->
<script>
  const searchInput = document.getElementById('searchInput');
  const departmentFilter = document.getElementById('departmentFilter');
  const complaintItems = document.querySelectorAll('.complaint-item');

  function filterCards() {
    const searchText = searchInput.value.toLowerCase();
    const selectedDept = departmentFilter.value;

    complaintItems.forEach(item => {
      const text = item.textContent.toLowerCase();
      const dept = item.getAttribute('data-dept');

      const matchSearch = text.includes(searchText);
      const matchDept = !selectedDept || dept === selectedDept;

      item.style.display = matchSearch && matchDept ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterCards);
  departmentFilter.addEventListener('change', filterCards);
</script>

</body>
</html>

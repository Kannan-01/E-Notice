<div id="holiday-tab" class="settings-section" style="display:none;">
  <form id="holidayForm" method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;" onsubmit="return validateHolidayForm();">
    <h5 class="fw-bold mb-4">Announce A <span class="text-warning">Holiday</span></h5>
    <div class="row g-4 justify-content-between">
      <div class="col-md-12">
        <!-- Holiday Title -->
        <div class="mb-3">
          <label for="title" class="form-label">Holiday Title</label>
          <input type="text" class="form-control" id="title" name="title" required placeholder="e.g. Onam Holiday" />
        </div>

        <!-- description -->
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Holiday description" required></textarea>
        </div>

        <!-- Multi-Day Toggle -->
        <div class="form-check form-switch mb-3 ms-1">
          <input class="form-check-input" type="checkbox" id="multiDayToggle" />
          <label class="form-check-label" for="multiDayToggle">Multi-Day Holiday?</label>
        </div>

        <!-- Single-Day Date -->
        <div class="mb-3" id="singleDayDiv">
          <label for="holiday_date" class="form-label">Holiday Date</label>
          <input type="date" class="form-control" id="holiday_date" name="holiday_date" />
        </div>

        <!-- Multi-Day Date Range -->
        <div class="row" id="multiDayDiv" style="display:none;">
          <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">From Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">To Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" />
          </div>
        </div>

        <!-- Department -->
        <div class="mb-3">
          <label for="department" class="form-label">Department</label>
          <select class="form-select" id="department" name="department" required>
            <option value="" disabled selected>Select Department</option>
            <option value="All">All</option>
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
      </div>
    </div>

    <!-- target -->
    <div class="mb-3">
      <label for="target" class="form-label">Target Audience</label>
      <select class="form-select" id="target" name="target" required>
        <option value="students">Students</option>
        <option value="teachers">Teachers</option>
        <option value="all" selected>All</option>
      </select>
    </div>

    <div class="mt-4 text-end">
      <button type="submit" name="announce" class="btn btn-warning px-5 py-2 fw-bold text-white">Announce Holiday</button>
    </div>
  </form>
</div>

<script>
  // UI toggle logic for multi-day holidays
  const toggle = document.getElementById("multiDayToggle");
  const singleDayDiv = document.getElementById("singleDayDiv");
  const multiDayDiv = document.getElementById("multiDayDiv");

  toggle.addEventListener("change", function() {
    if (toggle.checked) {
      singleDayDiv.style.display = "none";
      multiDayDiv.style.display = "flex";
      document.getElementById("holiday_date").required = false;
      document.getElementById("start_date").required = true;
      document.getElementById("end_date").required = true;
    } else {
      singleDayDiv.style.display = "block";
      multiDayDiv.style.display = "none";
      document.getElementById("holiday_date").required = true;
      document.getElementById("start_date").required = false;
      document.getElementById("end_date").required = false;
    }
  });

  // Simple validation scaffold (customize as needed)
  function validateHolidayForm() {
    // Example: check required fields, add custom alerts
    return true;
  }
</script>
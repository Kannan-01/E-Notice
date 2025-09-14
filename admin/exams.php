<div id="exam-tab" class="settings-section" style="display:none;">
  <form id="examForm" method="post" enctype="multipart/form-data" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
    <h5 class="fw-bold mb-4">Announce <span class="text-warning">Exam</span></h5>
    <div class="row g-4 justify-content-between">
      <div class="col-md-12">
        <!-- Exam Title -->
        <div class="mb-3">
          <label for="exam_title" class="form-label">Exam Title</label>
          <input type="text" class="form-control" id="exam_title" name="exam_title" placeholder="Enter the exam title" required />
        </div>

        <!-- Exam Type -->
        <div class="mb-3">
          <label for="exam_type" class="form-label">Exam Type / Category</label>
          <select class="form-select" id="exam_type" name="exam_type" required>
            <option value="" disabled selected>Select exam type</option>
            <option value="Internal">Internal</option>
            <option value="Model">Model</option>
            <option value="Semester">Semester</option>
          </select>
        </div>

        <!-- Department -->
        <div class="mb-3">
          <label for="exam_department" class="form-label">Department</label>
          <select class="form-select" id="exam_department" name="exam_department" required>
            <option value="" disabled selected>Select department</option>
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

        <!-- Location (Classroom No) -->
        <div class="mb-3">
          <label for="exam_location" class="form-label">Location (Classroom No)</label>
          <input type="text" class="form-control" id="exam_location" name="exam_location" placeholder="Enter classroom number or location" required />
        </div>

        <!-- Subjects with Schedule -->
        <label class="form-label">Subjects with Schedule</label>
        <div id="subjectsWrapper">
          <div class="row g-2 subject-row mb-3 align-items-end">
            <div class="col-md-4">
              <label class="form-label">Subject</label>
              <input type="text" name="subject_name[]" class="form-control" placeholder="Subject Name" required />
            </div>
            <div class="col-md-3">
              <label class="form-label">Date</label>
              <input type="date" name="subject_date[]" class="form-control" required />
            </div>
            <div class="col-md-3">
              <label class="form-label">Session</label>
              <select class="form-select" name="subject_session[]" required>
                <option value="" disabled selected>Select session</option>
                <option value="9:00 AM - 12:00 PM">Forenoon (9:00 AM - 12:00 PM)</option>
                <option value="1:00 PM - 4:00 PM">Afternoon (1:00 PM - 4:00 PM)</option>
              </select>
            </div>
            <div class="col-md-2 d-flex">
              <button type="button" class="btn addSubjectRow mt-auto" title="Add Subject">
                <i class="bi bi-plus text-warning"></i>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- Submit Button -->
    <div class="mt-4 text-end">
      <button type="submit" name="announce_exam" class="btn btn-warning px-5 py-2 fw-bold text-white">
        Announce Exam
      </button>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const subjectsWrapper = document.getElementById('subjectsWrapper');

  subjectsWrapper.addEventListener('click', function (e) {
    if (e.target.closest('.addSubjectRow')) {
      // Clone first subject row
      const firstRow = subjectsWrapper.querySelector('.subject-row');
      const newRow = firstRow.cloneNode(true);

      // Clear inputs in new row
      newRow.querySelectorAll('input, select').forEach(el => {
        el.value = '';
        if (el.tagName === 'SELECT') {
          el.selectedIndex = 0;
        }
      });

      // Append new row
      subjectsWrapper.appendChild(newRow);
    }
  });
});
</script>

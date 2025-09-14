<div id="notice-tab" class="settings-section" style="display:block;">
  <form id="noticeForm" method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;" onsubmit="return validateNoticeForm();">
    <h5 class="fw-bold mb-4">Add A <span class="text-warning" >Notice</span></h5>
    <div class="row g-4 justify-content-between">
      <div class="col-md-12">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" required placeholder="Enter notice title" />
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter notice description" required></textarea>
        </div>

        <div class="mb-3">
          <label for="department" class="form-label">Department</label>
          <select class="form-select" id="department" name="department" required>
            <option value="" disabled selected>Select department</option>
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

        <div class="mb-3 d-flex gap-3">
          <div class="flex-fill">
            <label for="valid_from" class="form-label">Valid From</label>
            <input type="date" class="form-control" id="valid_from" name="valid_from" required />
          </div>

          <div class="flex-fill">
            <label for="valid_until" class="form-label">Valid Until</label>
            <input type="date" class="form-control" id="valid_until" name="valid_until" required />
          </div>
        </div>

        <div class="mb-3">
          <label for="target" class="form-label">Target Audience</label>
          <select class="form-select" id="target" name="target" required>
            <option value="students">Students</option>
            <option value="teachers">Teachers</option>
            <option value="all" selected>All</option>
          </select>
        </div>

      </div>
    </div>

    <div class="mt-4 text-end">
      <button type="submit" name="save_notice" class="btn btn-warning px-5 py-2 fw-bold text-white">Announce Notice</button>
    </div>
  </form>
</div>
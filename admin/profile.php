<div id="notice-tab" class="settings-section">
  <form method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
    <h5 class="fw-bold mb-4">Create / Edit General Notice</h5>
    <div class="row g-3 justify-content-between">
      <div class="col-md-12">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" required placeholder="Enter notice title">
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter notice description" required></textarea>
        </div>

        <div class="mb-3">
          <label for="department" class="form-label">Department</label>
          <input type="text" class="form-control" id="department" name="department" placeholder="Department name or 'All'">
        </div>

        <div class="mb-3">
          <label for="target" class="form-label">Target Audience</label>
          <select class="form-select" id="target" name="target" required>
            <option value="" disabled selected>Select target audience</option>
            <option value="students">Students</option>
            <option value="teachers">Teachers</option>
            <option value="all">All</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="date_posted" class="form-label">Date of Posting</label>
          <input type="date" class="form-control" id="date_posted" name="date_posted" required>
        </div>

        <div class="mb-3">
          <label for="valid_from" class="form-label">Valid From</label>
          <input type="date" class="form-control" id="valid_from" name="valid_from" required>
        </div>

        <div class="mb-3">
          <label for="valid_until" class="form-label">Valid Until</label>
          <input type="date" class="form-control" id="valid_until" name="valid_until" required>
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button type="submit" name="save_notice" class="btn btn-approve px-5 py-2 fw-bold">Save Notice</button>
    </div>
  </form>
</div>

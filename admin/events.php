<div id="events-tab" class="settings-section" style="display:none;">
  <form id="eventForm" method="post" enctype="multipart/form-data" class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
    <h5 class="fw-bold mb-4">Announce <span class="text-warning">Event</span></h5>
    <div class="row g-4 justify-content-between">
      <div class="col-md-12">

        <!-- Event Title -->
        <div class="mb-3">
          <label for="event_title" class="form-label">Event Title</label>
          <input type="text" class="form-control" id="event_title" name="event_title" placeholder="Enter the event title" required />
        </div>

        <!-- Event Description -->
        <div class="mb-3">
          <label for="event_description" class="form-label">Description</label>
          <textarea class="form-control" id="event_description" name="event_description" rows="4" placeholder="Enter event description" required></textarea>
        </div>

        <!-- Event Date & Time -->
        <div class="row g-3">
          <div class="col-md-6">
            <label for="event_date" class="form-label">Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required />
          </div>
          <div class="col-md-6">
            <label for="event_time" class="form-label">Time</label>
            <input type="time" class="form-control" id="event_time" name="event_time" required />
          </div>
        </div>

        <!-- Venue -->
        <div class="mb-3 mt-3">
          <label for="event_venue" class="form-label">Venue</label>
          <input type="text" class="form-control" id="event_venue" name="event_venue" placeholder="Enter venue or hall name" required />
        </div>

        <!-- Organized By -->
        <div class="mb-3">
          <label for="event_organized_by" class="form-label">Organized By</label>
          <input type="text" class="form-control" id="event_organized_by" name="event_organized_by" placeholder="Department, Club, or Union" required />
        </div>

        <!-- Target Audience -->
        <div class="mb-3">
          <label for="event_target" class="form-label">Target Audience</label>
          <select class="form-select" id="event_target" name="event_target" required>
            <option value="" disabled selected>Select target audience</option>
            <option value="All">All</option>
            <option value="Students">Students</option>
            <option value="Teachers">Teachers</option>
          </select>
        </div>

        <!-- Department -->
        <div class="mb-3">
          <label for="event_department" class="form-label">Department</label>
          <select class="form-select" id="event_department" name="event_department" required>
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

        <!-- Event Poster / Banner Upload -->
        <div class="mb-3">
          <label for="event_poster" class="form-label">Event Poster / Banner</label>
          <input type="file" class="form-control" id="event_poster" name="event_poster" accept="image/*" />
        </div>

      </div>
    </div>

    <!-- Submit Button -->
    <div class="mt-4 text-end">
      <button type="submit" name="announce_event" class="btn btn-warning px-5 py-2 fw-bold text-white">
        Announce Event
      </button>
    </div>
  </form>
</div>

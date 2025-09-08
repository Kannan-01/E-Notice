<div id="password-tab" class="settings-section" style="display:none;">
    <form method="post" class="bg-white p-4 rounded-4 shadow-sm">
        <h5 class="fw-bold mb-4">Change Password</h5>
        <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" id="currentPassword" name="currentPassword" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" id="newPassword" name="newPassword" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" />
        </div>
        <div class="text-end">
            <button class="btn btn-approve px-5 py-2 fw-bold" type="submit" name="update_password">Update Password</button>
        </div>
    </form>
</div>
<div id="notification-tab" class="settings-section" style="display:none;">
    <form method="POST" class="bg-white p-4 rounded-4 shadow-sm">
        <h5 class="fw-bold mb-4">Notification Settings</h5>
        <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notify" value="1" <?= ($email_notify ?? 1) ? 'checked' : '' ?> />
            <label class="form-check-label" for="emailNotifications">
                Email Notifications
            </label>
        </div>
        <div class="text-end">
            <button name="save_notifications" class="btn btn-approve px-5 py-2 fw-bold" type="submit">Save Settings</button>
        </div>
    </form>
</div>
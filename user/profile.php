<div id="profile-tab" class="settings-section">

    <div class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
        <h5 class="fw-bold mb-4">Edit your profile</h5>
        <div class="row g-3 justify-content-between">

            <!-- Profile Update Form (left side) -->
            <div class="col-md-8">
                <form method="POST">
                    <div class="mb-3">
                        <label for="specificId" class="form-label">
                            <?= $user['role'] === 'student' ? 'Student ID' : ($user['role'] === 'teacher' ? 'Teacher ID' : 'User ID') ?>
                        </label>
                        <input type="text" class="form-control" id="specificId" 
                               value="<?= htmlspecialchars($specific_id) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact" name="contact" 
                               value="<?= htmlspecialchars($contact ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" 
                               value="<?= htmlspecialchars($department ?? '') ?>" readonly>
                        <input type="hidden" name="role" value="<?= htmlspecialchars($user['role'] ?? '') ?>">
                    </div>
                    <div class="mt-4 text-start">
                        <button type="submit" name="update_profile" class="btn btn-approve px-5 py-2 fw-bold">
                            Save change
                        </button>
                    </div>
                </form>
            </div>

            <!-- Avatar Form (right side, independent) -->
            <div class="col-md-4 d-flex flex-column align-items-center">
                <form method="POST" enctype="multipart/form-data" id="avatarForm" class="w-100 text-center">
                    <label for="avatarInput" class="d-flex flex-column align-items-center mb-2" style="cursor: pointer;">
                        <img id="avatarPreview"
                            src="<?= !empty($user['avatar']) ? '../' . htmlspecialchars($user['avatar']) : 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png' ?>"
                            alt="Avatar"
                            class="border mb-2"
                            style="width: 110px; height: 110px; border-radius: 18px; object-fit: cover;" />

                        <button type="button" class="btn btn-outline-warning w-100 fw-semibold d-flex align-items-center justify-content-center" style="pointer-events:none;">
                            <i class="bi bi-camera-fill me-2"></i>Change avatar
                        </button>
                    </label>

                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;">

                    <button class="btn btn-link text-danger w-100 fw-semibold" style="text-decoration:none;" 
                            name="delete_avatar" type="submit">
                        Delete avatar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('avatarInput').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('avatarForm').submit();
    }
});
</script>

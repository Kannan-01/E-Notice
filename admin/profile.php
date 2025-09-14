<div id="profile-tab" class="settings-section">
    <div class="bg-white p-4 rounded-4 shadow-sm" style="position:relative;">
        <h5 class="fw-bold mb-4">Admin <span class="text-warning">Profile</span></h5>
        <div class="row g-3 justify-content-between">

            <!-- Admin Info -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control"
                        value="<?= htmlspecialchars($admin['name'] ?? '') ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control"
                        value="<?= htmlspecialchars($admin['email'] ?? '') ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control"
                        value="<?= htmlspecialchars($admin['role'] ?? '') ?>" readonly>
                </div>
            </div>

            <!-- Avatar Form (right side, independent) -->
            <div class="col-md-4 d-flex flex-column align-items-center">
                <form method="POST" enctype="multipart/form-data" class="w-100 text-center">
                    <label for="avatarInput" class="d-flex flex-column align-items-center mb-2" style="cursor: pointer;">
                        <img id="avatarPreview"
                            src="<?= !empty($admin['avatar']) ? '../' . htmlspecialchars($admin['avatar']) : 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png' ?>"
                            alt="Avatar"
                            class="border mb-2"
                            style="width: 110px; height: 110px; border-radius: 18px; object-fit: cover;" />
                        <button type="button" class="btn btn-outline-warning w-100 fw-semibold d-flex align-items-center justify-content-center" style="pointer-events:none;">
                            <i class="bi bi-camera-fill me-2"></i>Change avatar
                        </button>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;">
                    <button class="btn btn-link text-danger w-100 fw-semibold" style="text-decoration:none;" name="delete_avatar" type="submit">
                        Delete avatar
                    </button>
                </form>
            </div>

            <script>
                document.getElementById('avatarInput').addEventListener('change', function() {
                    if (this.files.length > 0) {
                        this.closest("form").submit();
                    }
                });
            </script>


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
            <!-- Sidebar -->
            <div class="col-lg-3 sidebar px-4 py-4">
              <div class="brand-title mb-4">
                <span class="accent">E-Notice</span> Admin
              </div>
              <nav>
                <a href="dashboard.php" class="menu-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
                  <i class="bi bi-speedometer me-2"></i> Dashboard
                </a>

                <a href="approval.php" class="menu-link <?php echo ($currentPage == 'approval') ? 'active' : ''; ?>">
                  <i class="bi bi-people me-2"></i> Users
                </a>

                <a href="add.php" class="menu-link <?php echo ($currentPage == 'add') ? 'active' : ''; ?>">
                  <i class="bi bi-send me-2"></i> Publish
                </a>

                <a href="view-notices.php" class="menu-link <?php echo ($currentPage == 'view-notice') ? 'active' : ''; ?>">
                  <i class="bi bi-megaphone me-2"></i> Notices
                </a>

                <a href="view-holidays.php" class="menu-link <?php echo ($currentPage == 'view-holidays') ? 'active' : ''; ?>">
                  <i class="bi bi-calendar-event me-2"></i> Holidays
                </a>

                <a href="complaints.php" class="menu-link <?php echo ($currentPage == 'complaints') ? 'active' : ''; ?>">
                  <i class="bi bi-exclamation-triangle me-2"></i> Complaints
                </a>

                <a href="settings.php" class="menu-link <?php echo ($currentPage == 'settings') ? 'active' : ''; ?>">
                  <i class="bi bi-gear me-2"></i> Settings
                </a>

              </nav>
              <?php
              $user_id = $_SESSION['user_id'];
              $userResult = mysqli_query($conn, "SELECT avatar FROM users WHERE id = '$user_id' LIMIT 1");
              $userData = mysqli_fetch_assoc($userResult);
              $avatarPath = !empty($userData['avatar']) ? "../" . $userData['avatar'] : "https://cdn-icons-png.flaticon.com/512/847/847969.png"; // default placeholder
              ?>

              <div class="d-flex align-items-center p-3 mt-auto rounded-3 bg-light">
                <div class="flex-grow-1">
                  <div class="small text-secondary">Signed in as</div>
                  <div class="fw-semibold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User Name') ?></div>
                </div>
                <img src="<?= htmlspecialchars($avatarPath) ?>"
                  alt="Profile"
                  class="rounded-circle ms-3"
                  style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #ddd;">
              </div>


            </div>
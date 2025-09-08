            <!-- Sidebar -->
            <div class="col-lg-3 sidebar px-4 py-4">
                <div class="brand-title mb-4">
                    <span class="accent">E-Notice</span> Admin
                </div>
                <nav>
                    <a href="dashboard.php" class="menu-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>""><i class=" bi bi-layout-text-sidebar"></i> Dashboard</a>
                    <a href="approval.php" class="menu-link <?php echo ($currentPage == 'approval') ? 'active' : ''; ?>"><i class="bi bi-person-badge me-2"></i> User Approval</a>
                    <a href="#" class="menu-link <?php echo ($currentPage == 'notice') ? 'active' : ''; ?>"><i class="bi bi-envelope-open"></i> Notices</a>
                    <a href="#" class="menu-link <?php echo ($currentPage == 'settings') ? 'active' : ''; ?>"><i class="bi bi-gear"></i> Settings</a>
                </nav>
                <div class="d-flex align-items-center p-3 mt-auto rounded-3 bg-light">
                    <div class="flex-grow-1">
                        <div class="small text-secondary">Signed in as</div>
                        <div class="fw-semibold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User Name') ?></div>
                    </div>
                    <i class="bi bi-person-circle fs-4 text-secondary"></i>
                </div>
                <div class="mt-5 pt-4 border-top">
                    <span class="menu-link"><i class="bi bi-question-circle"></i> Help Center</span>
                </div>
            </div>
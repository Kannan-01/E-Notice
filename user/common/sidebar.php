            <!-- Sidebar -->
            <div class="col-lg-3 sidebar px-4 py-4">
                <div class="brand-title mb-4">
                    <span class="accent">E-Notice</span> User
                </div>
                <nav>
                    <a href="notice.php" class="menu-link <?php echo ($currentPage == 'notice') ? 'active' : ''; ?>"><i class="bi bi-envelope-open"></i> Notices</a>
                    <a href="holiday.php" class="menu-link <?php echo ($currentPage == 'holiday') ? 'active' : ''; ?>">
                        <i class="bi bi-calendar-event"></i> Holidays
                    </a>
                    <a href="exam.php" class="menu-link <?php echo ($currentPage == 'exam') ? 'active' : ''; ?>"> <i class="bi bi-journal-text"></i> Exams </a>
                    <a href="complaints.php" class="menu-link <?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>"><i class="bi bi-chat-dots"></i> Complaints </a>
                    <a href="settings.php" class="menu-link <?php echo ($currentPage == 'settings') ? 'active' : ''; ?>"><i class="bi bi-gear"></i> Settings</a>
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
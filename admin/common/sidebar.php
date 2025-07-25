        <!-- sidebar -->
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url('/e-notice/uploads/user.jpg');"></a>
                <ul class="list-unstyled components mb-5">
                    <li class="<?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>"><a href="dashboard.php">Dashboard</a></li>
                    <li class="<?php echo ($currentPage == 'addNotice') ? 'active' : ''; ?>"><a href="addNotice.php">Add Notice</a></li>
                    <li class="<?php echo ($currentPage == 'view') ? 'active' : ''; ?>"><a href="view.php">View Notice</a></li>
                    <li class="<?php echo ($currentPage == 'exam') ? 'active' : ''; ?>"><a href="exam.php">Post Exam Notification</a></li>
                    <li class="<?php echo ($currentPage == 'holiday') ? 'active' : ''; ?>"><a href="holiday.php">Announce Holiday</a></li>
                    <li class="<?php echo ($currentPage == 'complaints') ? 'active' : ''; ?>"><a href="complaints.php">Complaints & Suggestions</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Log out</a></li>
                </ul>
                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> | All rights reserved
                    </p>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title" id="exampleModalLabel">Are you sure you want to <br>log out?</h6>
                    </div>
                    <div class="modal-footer border-0 justify-content-end pt-0">
                        <a href="../index.php" class="btn btn-warning text-white btn-sm">Log Out</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
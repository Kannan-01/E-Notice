        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url('/e-notice/uploads/user.jpg');"></a>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">Exams</a>
                    </li>
                    <li>
                        <a href="#">Holidays</a>
                    </li>
                    <li>
                        <a href="#">Feedback</a>
                    </li>
                    <li>
                        <a href="../user/account.php">Account</a>
                    </li>
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Log out
                        </a>
                    </li>
                </ul>

                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> |
                        All rights reserved
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
                        <a href="index.php" class="btn btn-warning text-white btn-sm">Log Out</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!doctype html>
<html lang="en">

<head>
    <title>dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../noti.ico" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e7761c5b02.js" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/style.css" />

    <style>
        body {
            background: #f5f7fa;
        }

        .card {
            border-radius: 12px;
        }

        .table thead th {
            background: #f0f2f5;
            font-weight: 600;
        }

        .modal-img {
            max-height: 260px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>

</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <!-- sidebar -->

        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url('/e-notice/uploads/user.jpg');"></a>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="addNotice.php">Add Notice</a>
                    </li>
                    <li class="active">
                        <a href="view.php">View Notice</a>
                    </li>
                    <li>
                        <a href="exam.php">Post Exam Notification</a>
                    </li>
                    <li>
                        <a href="holiday.php">Announce Holiday</a>
                    </li>
                    <li>
                        <a href="#">Complaints & Suggestions</a>
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
                        <a href="../index.php" class="btn btn-warning text-white btn-sm">Log Out</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Welcome, Admin</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item fs-3 fw-bold"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Library</li>
                </ol>
            </nav>  

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                <h2 class="mb-0">All Notices</h2>
                <div class="d-flex gap-2">
                    <!-- Search -->
                    <input class="form-control" id="searchInput" type="text" placeholder="Search notices…" />

                    <!-- Department Filter -->
                    <select class="form-select" id="deptFilter">
                        <option value="">All Depts</option>
                        <option>CSE</option>
                        <option>BCA</option>
                        <option>BCOM</option>
                        <option>BA</option>
                    </select>
                </div>
            </div>
            <!-- Notice Table -->
            <div class="card p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="noticeTable">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Department</th>
                                <th scope="col">Posted&nbsp;On</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dummy Rows -->
                            <tr>
                                <td>Seminar on AI</td>
                                <td>CSE</td>
                                <td>13 Jul 2025</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary viewBtn"
                                        data-bs-title="Seminar on AI"
                                        data-bs-body="Join us for an expert talk on Generative AI trends."
                                        data-bs-img="https://via.placeholder.com/600x260.png?text=AI+Seminar">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Lab Manual Submission</td>
                                <td>BCA</td>
                                <td>10 Jul 2025</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary viewBtn"
                                        data-bs-title="Lab Manual Submission"
                                        data-bs-body="Submit your manuals to the lab‑in‑charge by 12 PM."
                                        data-bs-img="">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Exam Schedule – Semester IV</td>
                                <td>BCOM</td>
                                <td>08 Jul 2025</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary viewBtn"
                                        data-bs-title="Exam Schedule – Semester IV"
                                        data-bs-body="Download the attached PDF for the full timetable."
                                        data-bs-img="https://via.placeholder.com/600x260.png?text=Exam+Timetable">View</button>
                                </td>
                            </tr>
                            <!-- /Dummy Rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notice Modal -->
        <div class="modal fade" id="noticeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImg" class="w-100 mb-3 d-none modal-img" alt="">
                        <p id="modalBody" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modal logic
        const noticeModal = new bootstrap.Modal(document.getElementById('noticeModal'));
        document.querySelectorAll('.viewBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('modalTitle').textContent = btn.dataset.bsTitle;
                document.getElementById('modalBody').textContent = btn.dataset.bsBody;
                const imgEl = document.getElementById('modalImg');
                if (btn.dataset.bsImg) {
                    imgEl.src = btn.dataset.bsImg;
                    imgEl.classList.remove('d-none');
                } else {
                    imgEl.classList.add('d-none');
                }
                noticeModal.show();
            });
        });

        // Simple search & filter (client‑side demo only)
        const searchInput = document.getElementById('searchInput');
        const deptFilter = document.getElementById('deptFilter');

        function filterTable() {
            const term = searchInput.value.toLowerCase();
            const dept = deptFilter.value;
            document.querySelectorAll('#noticeTable tbody tr').forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
                const rowDept = row.cells[1].textContent;
                const matches = title.includes(term) && (dept === '' || rowDept === dept);
                row.style.display = matches ? '' : 'none';
            });
        }
        searchInput.addEventListener('input', filterTable);
        deptFilter.addEventListener('change', filterTable);
    </script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
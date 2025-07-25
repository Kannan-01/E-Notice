<?php
include '../db/connection.php';

// Fetch all notices ordered by latest first
$query = "SELECT * FROM notices ORDER BY posted_at DESC";
$result = mysqli_query($conn, $query);
?>

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
        <?php
        $currentPage = 'view';
        require './common/sidebar.php' ?>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
            <?php require './common/header.php' ?>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item fs-3 fw-bold"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item fs-3 fw-bold active" aria-current="page">Library</li>
                </ol>
            </nav>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                <h2 class="mb-0">All Notices</h2>
                <div class="d-flex gap-2">
                    <input class="form-control" id="searchInput" type="text" placeholder="Search notices…" />
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
                                <th>Title</th>
                                <th>Department</th>
                                <th>Posted&nbsp;On</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= htmlspecialchars($row['department']) ?></td>
                                        <td><?= date("d M Y", strtotime($row['posted_at'])) ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary viewBtn"
                                                data-bs-title="<?= htmlspecialchars($row['title']) ?>"
                                                data-bs-body="<?= nl2br(htmlspecialchars($row['description'])) ?>"
                                                data-bs-img="<?= !empty($row['image']) ? '../' . $row['image'] : '' ?>">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No notices found.</td>
                                </tr>
                            <?php endif; ?>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        // Modal handling
        document.querySelectorAll(".viewBtn").forEach(btn => {
            btn.addEventListener("click", function() {
                const title = this.getAttribute("data-bs-title");
                const body = this.getAttribute("data-bs-body");
                const img = this.getAttribute("data-bs-img");

                document.getElementById("modalTitle").textContent = title;
                document.getElementById("modalBody").innerHTML = body;

                const modalImg = document.getElementById("modalImg");
                if (img) {
                    modalImg.src = img;
                    modalImg.classList.remove("d-none");
                } else {
                    modalImg.classList.add("d-none");
                }

                const modal = new bootstrap.Modal(document.getElementById("noticeModal"));
                modal.show();
            });
        });

        // Filter & Search
        const searchInput = document.getElementById("searchInput");
        const deptFilter = document.getElementById("deptFilter");
        const rows = document.querySelectorAll("#noticeTable tbody tr");

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const dept = deptFilter.value;

            rows.forEach(row => {
                const title = row.children[0].textContent.toLowerCase();
                const department = row.children[1].textContent;

                const matchSearch = title.includes(search);
                const matchDept = !dept || department === dept;

                row.style.display = (matchSearch && matchDept) ? "" : "none";
            });
        }

        searchInput.addEventListener("input", filterTable);
        deptFilter.addEventListener("change", filterTable);
    </script>

</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</html>
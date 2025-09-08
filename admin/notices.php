<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Approvals E-Notice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/admin.css">
    <style>
        form {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgb(247 183 0 / 0.15);
            margin-bottom: 3rem;
        }

        label {
            font-weight: 600;
            color: #222;
            margin-bottom: 0.5rem;
        }

        input,
        select,
        textarea {
            border-radius: 8px !important;
            border: 2px solid #ddd !important;
            padding: 0.7rem 1.2rem !important;
            background: #fefefe !important;
            transition: 0.35s ease border-color, 0.35s ease box-shadow;
            font-size: 1rem !important;
            box-shadow: none !important;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #f7b700 !important;
            box-shadow: 0 0 10px rgb(247 183 0 / 0.4) !important;
            outline: none !important;
        }

        textarea {
            resize: vertical !important;
        }

        .btn-approve {
            background-color: #f7b700 !important;
            border: none !important;
            color: #000 !important;
            font-weight: 700 !important;
            font-size: 1.1rem !important;
            padding: 0.7rem 1.5rem !important;
            border-radius: 50px !important;
            box-shadow: 0 6px 14px rgba(247, 183, 0, 0.45);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-approve:hover,
        .btn-approve:focus {
            background-color: #cfa205 !important;
            box-shadow: 0 10px 20px rgba(207, 162, 5, 0.6);
            color: #fff !important;
            outline: none !important;
        }
        .col-lg-9.py-5.px-4 {
  max-width: 720px;
  margin-left: auto;
  margin-right: auto;
}
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 sidebar px-4 py-4">
                <div class="brand-title mb-4">
                    <span class="accent">E-Notice</span> Admin
                </div>
                <nav>
                    <a href="#" class="menu-link active"><i class="bi bi-layout-text-sidebar"></i> Dashboard</a>
                    <a href="approval.php" class="menu-link"><i class="bi bi-person-badge me-2"></i> User Approval</a>
                    <a href="#" class="menu-link"><i class="bi bi-envelope-open"></i> Notices</a>
                    <a href="#" class="menu-link"><i class="bi bi-gear"></i> Settings</a>
                </nav>
                <div class="mt-5 pt-4 border-top">
                    <span class="menu-link"><i class="bi bi-question-circle"></i> Help Center</span>
                </div>
            </div>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container mt-5 mb-5">
                    <h2 class="fw-bold mb-4">
                        <span class="text-dark">Add New</span>
                        <span class="accent">Notice</span>
                    </h2>

                    <div class="mb-4">
                        <label for="noticeType" class="form-label fw-semibold">Choose Notice Type</label>
                        <select id="noticeType" class="form-select shadow-none" required>
                            <option value="" selected disabled>Select Notice Type</option>
                            <option value="notice">Notice / Banner</option>
                            <option value="holiday">Holiday Notice</option>
                            <option value="exam">Exam Notice</option>
                        </select>
                    </div>

                    <!-- Notice / Banner Form -->
                    <form id="noticeForm" method="post" enctype="multipart/form-data" style="display:none;">
                        <div class="mb-3">
                            <label for="titleNotice" class="form-label">Title</label>
                            <input type="text" id="titleNotice" name="title" class="form-control shadow-none" placeholder="Enter your title here" required />
                        </div>
                        <div class="mb-3">
                            <label for="descriptionNotice" class="form-label">Description</label>
                            <textarea id="descriptionNotice" name="description" rows="4" class="form-control shadow-none" placeholder="Give a brief description."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="departmentNotice" class="form-label">Department</label>
                            <select id="departmentNotice" name="department" class="form-select shadow-none" required>
                                <option value="" disabled selected>Select your department</option>
                                <option value="All">All</option>
                                <option>Commerce</option>
                                <option>Computer Science</option>
                                <option>Fashion Design</option>
                                <option>Business Administration</option>
                                <option>Psychology</option>
                                <option>Mathematics</option>
                                <option>English</option>
                                <option>Social Work</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="targetNotice" class="form-label">Target Audience</label>
                            <select id="targetNotice" name="target" class="form-select shadow-none" required>
                                <option value="Students" selected>Students</option>
                                <option value="Teachers">Teachers</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="uploadImg" class="form-label">Upload Image (Optional)</label>
                            <input type="file" class="form-control shadow-none" id="uploadImg" name="uploadImg" />
                        </div>
                        <button type="submit" name="publish_notice" class="btn btn-approve form-control fw-semibold text-black">
                            Post your notice
                        </button>
                    </form>

                    <!-- Holiday Form -->
                    <form id="holidayForm" method="post" style="display:none;">
                        <div class="mb-3">
                            <label for="holidayTitle" class="form-label">Holiday Title</label>
                            <input type="text" id="holidayTitle" name="holiday_title" class="form-control shadow-none" placeholder="e.g. Pongal Holiday" required />
                        </div>
                        <div class="mb-3">
                            <label for="holidayType" class="form-label">Holiday Type</label>
                            <select id="holidayType" name="holiday_type" class="form-select shadow-none" required>
                                <option value="" disabled selected>Select Type</option>
                                <option>Public</option>
                                <option>Festival</option>
                                <option>Institutional</option>
                                <option>Weather Related</option>
                                <option>Administrative</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-check form-switch mb-3 ms-3">
                            <input class="form-check-input shadow-none" type="checkbox" id="multiDayToggle" />
                            <label class="form-check-label" for="multiDayToggle">Multi-Day Holiday?</label>
                        </div>
                        <div class="mb-3" id="singleDayDiv">
                            <label for="holidayDate" class="form-label">Holiday Date</label>
                            <input type="date" id="holidayDate" name="holiday_date" class="form-control shadow-none" />
                        </div>
                        <div class="row" id="multiDayDiv" style="display:none;">
                            <div class="col-md-6 mb-3">
                                <label for="startDate" class="form-label">From Date</label>
                                <input type="date" id="startDate" name="start_date" class="form-control shadow-none" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endDate" class="form-label">To Date</label>
                                <input type="date" id="endDate" name="end_date" class="form-control shadow-none" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descriptionHoliday" class="form-label">Description / Reason</label>
                            <textarea id="descriptionHoliday" name="description" rows="4" class="form-control shadow-none" placeholder="Enter reason or note for the holiday..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="departmentHoliday" class="form-label">Department</label>
                            <select id="departmentHoliday" name="department" class="form-select shadow-none" required>
                                <option value="" disabled selected>Select Department</option>
                                <option value="All">All</option>
                                <option>Commerce</option>
                                <option>Computer Science</option>
                                <option>Fashion Design</option>
                                <option>Business Administration</option>
                                <option>Psychology</option>
                                <option>Mathematics</option>
                                <option>English</option>
                                <option>Social Work</option>
                            </select>
                        </div>
                        <button type="submit" name="publish_holiday" class="btn btn-approve form-control fw-semibold text-black">
                            Announce Holiday
                        </button>
                    </form>

                    <!-- Exam Form -->
                    <form id="examForm" method="post" enctype="multipart/form-data" style="display:none;">
                        <div class="mb-3">
                            <label for="examTitle" class="form-label">Exam Title</label>
                            <input type="text" id="examTitle" name="exam_title" class="form-control shadow-none" placeholder="Enter the exam title" required />
                        </div>
                        <div class="mb-3">
                            <label for="examType" class="form-label">Exam Type / Category</label>
                            <select id="examType" name="exam_type" class="form-select shadow-none" required>
                                <option value="" disabled selected>Select exam type</option>
                                <option>Internal</option>
                                <option>Model</option>
                                <option>Semester</option>
                                <option>Practical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="departmentExam" class="form-label">Department</label>
                            <select id="departmentExam" name="department" class="form-select shadow-none" required>
                                <option value="" disabled selected>Select department</option>
                                <option>Commerce</option>
                                <option>Computer Science</option>
                                <option>Fashion Design</option>
                                <option>Business Administration</option>
                                <option>Psychology</option>
                                <option>Mathematics</option>
                                <option>English</option>
                                <option>Social Work</option>
                            </select>
                        </div>
                        <label class="form-label">Subjects with Schedule</label>
                        <div id="subjectsWrapper">
                            <div class="row g-2 subject-row mb-3 align-items-end">
                                <div class="col-md-4">
                                    <input type="text" name="subject[]" class="form-control shadow-none" placeholder="Subject Name" required />
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="subject_date[]" class="form-control shadow-none" required />
                                </div>
                                <div class="col-md-3">
                                    <select name="subject_session[]" class="form-select shadow-none" required>
                                        <option value="" disabled selected>Select session</option>
                                        <option value="FN">Forenoon (9:30 AM - 12:30 PM)</option>
                                        <option value="AN">Afternoon (2:00 PM - 5:00 PM)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex">
                                    <button type="button" class="btn btn-approve addRow"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descriptionExam" class="form-label">Instructions / Notes</label>
                            <textarea id="descriptionExam" name="description" rows="4" class="form-control shadow-none"
                                placeholder="E.g., Bring ID card, hall ticket, etc."></textarea>
                        </div>
                        <button type="submit" name="announce_exam" class="btn btn-approve form-control fw-semibold text-black">
                            Announce Exam
                        </button>
                    </form>
                </div>

                <script>
                    const noticeType = document.getElementById('noticeType');
                    const noticeForm = document.getElementById('noticeForm');
                    const holidayForm = document.getElementById('holidayForm');
                    const examForm = document.getElementById('examForm');

                    noticeType.addEventListener('change', () => {
                        noticeForm.style.display = 'none';
                        holidayForm.style.display = 'none';
                        examForm.style.display = 'none';

                        switch (noticeType.value) {
                            case 'notice':
                                noticeForm.style.display = 'block';
                                break;
                            case 'holiday':
                                holidayForm.style.display = 'block';
                                break;
                            case 'exam':
                                examForm.style.display = 'block';
                                break;
                        }
                    });

                    // Multi-day holiday toggle logic
                    const multiDayToggle = document.getElementById('multiDayToggle');
                    const singleDayDiv = document.getElementById('singleDayDiv');
                    const multiDayDiv = document.getElementById('multiDayDiv');

                    multiDayToggle.addEventListener('change', () => {
                        if (multiDayToggle.checked) {
                            singleDayDiv.style.display = 'none';
                            multiDayDiv.style.display = 'flex';
                        } else {
                            singleDayDiv.style.display = 'block';
                            multiDayDiv.style.display = 'none';
                        }
                    });

                    // Add row button for exam subjects
                    document.getElementById('subjectsWrapper').addEventListener('click', e => {
                        if (e.target.closest('.addRow')) {
                            const wrapper = document.getElementById('subjectsWrapper');
                            const row = e.target.closest('.subject-row');
                            const clone = row.cloneNode(true);
                            clone.querySelectorAll('input').forEach(input => input.value = '');
                            clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                            wrapper.appendChild(clone);
                        }
                    });
                </script>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
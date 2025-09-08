<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../admin/assets/admin.css">
    <style>
        body {
            background: #f7f8fa;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-grid .cal-day,
        .calendar-grid .cal-header {
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 500;
            user-select: none;
        }

        .calendar-grid .cal-header {
            color: #6c757d;
            font-size: 1rem;
            cursor: default;
            background: transparent;
        }

        .calendar-grid .cal-day {
            background: #f8f9fa;
            color: #343a40;
            cursor: pointer;
        }

        .calendar-grid .cal-day.today {
            border: 2px solid #fbbf24;
            font-weight: 700;
            cursor: default;
        }

        .calendar-grid .cal-day.exam-date {
            background: #fff3cd;
            border: 2px solid #ffc107;
            color: #856404;
            font-weight: 600;
            transition: background-color 0.2s, color 0.2s;
        }

        .calendar-grid .cal-day.exam-date:hover {
            background: #ffc107;
            color: #212529;
        }

        .calendar-grid .cal-day.selected {
            background: #ffc107;
            color: #212529;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            $currentPage = 'exam';
            require './common/sidebar.php'
            ?>
            <!-- Main Panel -->
            <div class="col-lg-9 py-5 px-4">
                <div class="container py-4">
                    <div class="row bg-white shadow-sm rounded-4" style="min-height: 480px;">
                        <!-- Calendar Left -->
                        <div class="col-md-7 border-end p-4">
                            <h5 class="mb-3">Select Date</h5>
                            <div class="d-flex align-items-center mb-3">
                                <button class="btn btn-outline-none btn-sm me-2" onclick="changeMonth(-1)" type="button">
                                    <i class="bi bi-chevron-left text-dark"></i>
                                </button>
                                <span id="monthLabel" class="fw-semibold fs-5"></span>
                                <button class="btn btn-outline-none btn-sm ms-2" onclick="changeMonth(1)" type="button">
                                    <i class="bi bi-chevron-right text-dark"></i>
                                </button>

                            </div>
                            <div id="calendarGrid" class="calendar-grid"></div>
                        </div>

                        <!-- Details Right -->
                        <div class="col-md-5 p-4" id="examDetailsPane">
                            <h4 class="fw-bold mb-3" id="examTitle">Select an exam date</h4>
                            <div id="examDetailContent" class="text-secondary fs-6">
                                <p>Click a highlighted date on the calendar to view exam details here.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    const calendarGrid = document.getElementById('calendarGrid');
                    const monthLabel = document.getElementById('monthLabel');
                    const examTitle = document.getElementById('examTitle');
                    const examDetailContent = document.getElementById('examDetailContent');

                    const examData = {
                        '2025-09-11': {
                            title: "Midterm - Mathematics",
                            agenda: "Algebra, Calculus, Probability",
                            duration: "2 hrs",
                            session: "10:00 AM - 12:00 PM",
                            location: "Room 204, Main Block"
                        },
                        '2025-09-13': {
                            title: "English Literature Exam",
                            agenda: "Modern Poetry, Drama",
                            duration: "1.5 hrs",
                            session: "9:00 AM - 10:30 AM",
                            location: "Room 110"
                        }
                    };

                    let today = new Date();
                    let viewMonth = today.getMonth();
                    let viewYear = today.getFullYear();

                    function renderCalendar(month, year) {
                        calendarGrid.innerHTML = '';
                        const weekday = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                        weekday.forEach(day =>
                            calendarGrid.innerHTML += `<div class="cal-header">${day}</div>`
                        );

                        const firstDay = new Date(year, month, 1).getDay();
                        const daysInMonth = new Date(year, month + 1, 0).getDate();

                        for (let i = 0; i < firstDay; i++) {
                            calendarGrid.innerHTML += `<div></div>`;
                        }

                        for (let d = 1; d <= daysInMonth; d++) {
                            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                            let classes = 'cal-day';
                            const isoDateToday = getISODate(new Date());
                            if (dateStr === isoDateToday) classes += " today";
                            if (examData[dateStr]) classes += " exam-date";
                            calendarGrid.innerHTML += `<div class="${classes}" data-date="${dateStr}">${d}</div>`;
                        }

                        monthLabel.textContent = new Date(year, month).toLocaleString('default', {
                            month: 'long',
                            year: 'numeric'
                        });

                        document.querySelectorAll('.cal-day.exam-date').forEach(cell => {
                            cell.onclick = function() {
                                document.querySelectorAll('.cal-day').forEach(c => c.classList.remove('selected'));
                                this.classList.add('selected');
                                showExamDetail(this.dataset.date);
                            };
                        });
                    }

                    function showExamDetail(dateStr) {
                        const exam = examData[dateStr];
                        if (!exam) {
                            examTitle.textContent = "No Exams";
                            examDetailContent.innerHTML = "<p>No exams scheduled for this date.</p>";
                            return;
                        }
                        examTitle.textContent = exam.title;
                        examDetailContent.innerHTML = `
        <div><strong>Agenda:</strong> ${exam.agenda}</div>
        <div><strong>Duration:</strong> ${exam.duration}</div>
        <div><strong>Session:</strong> ${exam.session}</div>
        <div><strong>Location:</strong> ${exam.location}</div>
      `;
                    }

                    function getISODate(date) {
                        return date.toISOString().split('T')[0];
                    }

                    function changeMonth(step) {
                        viewMonth += step;
                        if (viewMonth > 11) {
                            viewMonth = 0;
                            viewYear++;
                        } else if (viewMonth < 0) {
                            viewMonth = 11;
                            viewYear--;
                        }
                        renderCalendar(viewMonth, viewYear);
                    }

                    renderCalendar(viewMonth, viewYear);
                </script>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</body>

</html>
<?php
include '../db/connection.php';

// Auto-update subjects: set inactive if date < today
$today = date('Y-m-d');
mysqli_query($conn, "UPDATE subjects SET status='inactive' WHERE exam_date < '$today' AND status='active'");

// Fetch only active subjects
$sql = "SELECT 
            e.id as exam_id,
            e.exam_title,
            e.exam_type,
            e.department,
            e.location,
            s.subject_name,
            s.exam_date,
            s.session
        FROM exams e
        INNER JOIN subjects s ON e.id = s.exam_id
        WHERE s.status = 'active'";

$result = mysqli_query($conn, $sql);

$examData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dateKey = $row['exam_date'];
    if (!isset($examData[$dateKey])) {
        $examData[$dateKey] = [];
    }
    $examData[$dateKey][] = [
        "title" => $row['exam_title'],
        "type" => $row['exam_type'],
        "department" => $row['department'],
        "subject" => $row['subject_name'],
        "session" => $row['session'],
        "location" => $row['location']
    ];
}

header('Content-Type: application/json');
echo json_encode($examData);
?>

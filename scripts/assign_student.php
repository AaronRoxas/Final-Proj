<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Check if the student is already assigned to the course
    $checkStmt = $conn->prepare("SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?");
    $checkStmt->bind_param("is", $student_id, $course_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Student is already assigned to the course
        header("Location: ../dashboard.php?error=course_already_assigned");
    } else {
        // Insert the student's course assignment in the database
        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("is", $student_id, $course_id);

        if ($stmt->execute()) {
            header("Location: ../dashboard.php?message=student_assigned");
        } else {
            header("Location: ../dashboard.php?error=student_assign_failed");
        }
        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

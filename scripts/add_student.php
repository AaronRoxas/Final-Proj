<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $student_id = $_POST['student_id'];
    $student_number = $_POST['student_number'];
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("INSERT INTO students (student_id, user_name, student_number, course_id, user_role) VALUES (?, ?, ?, ?, 's')");
    $stmt->bind_param("isss", $student_id, $student_name, $student_number, $course_id);

    if ($stmt->execute()) {
        header("Location: teacher-dashboard.php?message=student_added");
    } else {
        header("Location: teacher-dashboard.php?error=student_add_failed");
    }
    $stmt->close();
    $conn->close();
}
?>

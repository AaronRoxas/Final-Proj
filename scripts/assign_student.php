<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_SESSION['user_id'];
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Check if the course is managed by the logged-in teacher
    $stmt = $conn->prepare("SELECT course_id FROM courses WHERE course_id = ? AND teacher_id = ?");
    $stmt->bind_param("si", $course_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The course is managed by the logged-in teacher, proceed with assignment
        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)
                                ON DUPLICATE KEY UPDATE course_id = VALUES(course_id)");
        $stmt->bind_param("is", $student_id, $course_id);
        if ($stmt->execute()) {
            header("Location: ../dashboard.php?message=student_assigned");
        } else {
            header("Location: ../dashboard.php?error=assignment_failed");
        }
    } else {
        // The course is not managed by the logged-in teacher
        header("Location: ../dashboard.php?error=not_authorized");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../dashboard.php");
}
?>

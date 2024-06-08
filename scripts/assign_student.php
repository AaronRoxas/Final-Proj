<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id']) && isset($_POST['student_id'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $teacher_id = $_SESSION['user_id']; // Assuming you store teacher_id in session

    // Validate that the course is managed by the logged-in teacher
    $stmt = $conn->prepare("SELECT course_id FROM courses WHERE course_id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $course_id, $teacher_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Course is managed by the teacher, proceed with the assignment
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $student_id, $course_id);
        if ($stmt->execute()) {
            header("Location: ../dashboard.php?message=course_assigned");
        } else {
            header("Location: ../dashboard.php?error=assignment_failed");
        }
        $stmt->close();
    } else {
        // Course is not managed by the teacher
        header("Location: ../dashboard.php?error=invalid_course");
    }
    $stmt->close();
} else {
    header("Location: ../dashboard.php?error=invalid_request");
}
$conn->close();
?>

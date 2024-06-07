<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Get the actual course ID from the course name
        $stmt = $conn->prepare("SELECT course_id FROM courses WHERE course_name = ?");
        $stmt->bind_param("s", $course_id);
        $stmt->execute();
        $stmt->bind_result($actual_course_id);
        $stmt->fetch();
        $stmt->close();

        // Delete from student_courses
        $stmt = $conn->prepare("DELETE FROM student_courses WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("is", $student_id, $actual_course_id);
        $stmt->execute();
        $stmt->close();

        // Delete from grades
        $stmt = $conn->prepare("DELETE FROM grades WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("is", $student_id, $actual_course_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();
        $_SESSION["remove_success"] = true;
        header("Location: ../dashboard.php?message=course_removed");
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        header("Location: ../dashboard.php?error=course_remove_failed");
    }

    $conn->close();
}
?>

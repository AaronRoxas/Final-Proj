<?php
include "db_conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];

    // Delete from student_courses and grades where the course_id matches
    $stmt = $conn->prepare("DELETE FROM student_courses WHERE course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM grades WHERE course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $stmt->close();

    // Delete the course
    $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
    $stmt->bind_param("s", $course_id);

    if ($stmt->execute()) {
        $_SESSION["remove_success"] = true;
        header("Location: ../dashboard.php?message=course_removed");
    } else {
        echo "Error deleting course: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<?php
require "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $course_id = $_POST['course_id'];
    $teacher_id = $_SESSION['user_id'];
    $_SESSION['course_id'] = $course_id;
    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, teacher_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $course_id, $course_name, $teacher_id);

    $checkStmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
    $checkStmt->bind_param("s", $course_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        header("Location: ../dashboard.php?error=course_already_exists");
    }

    else if ($stmt->execute()) {
        header("Location: ../dashboard.php?message=course_added");
    } else {
        header("Location: ../dashboard.php?error=course_add_failed");
    }

    $stmt->close();
    $conn->close();
}
?>
<?php
include "db_conn.php";
session_start();

if (isset($_POST['student_id']) && isset($_POST['course_id']) && isset($_POST['prelim_grade']) && isset($_POST['midterm_grade']) && isset($_POST['final_grade'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $prelim_grade = $_POST['prelim_grade'];
    $midterm_grade = $_POST['midterm_grade'];
    $final_grade = $_POST['final_grade'];

    // Check if the grade for this student and course already exists
    $check_stmt = $conn->prepare("SELECT * FROM grades WHERE student_id = ? AND course_id = ?");
    $check_stmt->bind_param("is", $student_id, $course_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // If the grade exists, update it
        $stmt = $conn->prepare("UPDATE grades SET prelim_grade = ?, midterm_grade = ?, final_grade = ? WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("dddis", $prelim_grade, $midterm_grade, $final_grade, $student_id, $course_id);
    } else {
        // If the grade does not exist, insert a new record
        $stmt = $conn->prepare("INSERT INTO grades (student_id, course_id, prelim_grade, midterm_grade, final_grade) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issdd", $student_id, $course_id, $prelim_grade, $midterm_grade, $final_grade);
    }

    if ($stmt->execute()) {
        header("Location: ../dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "All fields are required.";
}
?>

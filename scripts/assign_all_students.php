<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $_SESSION['course_id'] = $course_id;

    // Fetch all students
    $studentsResult = $conn->query("SELECT student_id FROM students");

    if ($studentsResult->num_rows > 0) {
        // Prepare the insert statement once
        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");

        // Iterate through all students and assign them to the course
        while ($student = $studentsResult->fetch_assoc()) {
            $student_id = $student['student_id'];

            // Check if the student is already assigned to the course
            $checkStmt = $conn->prepare("SELECT * FROM student_courses WHERE student_id = ? AND course_id = ?");
            $checkStmt->bind_param("is", $student_id, $course_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows == 0) {
                // Student is not assigned to the course, proceed to insert
                $stmt->bind_param("is", $student_id, $course_id);
                $stmt->execute();
            }

            $checkStmt->close();
        }

        $stmt->close();
        header("Location: ../dashboard.php?message=all_students_assigned");
    } else {
        header("Location: ../dashboard.php?error=no_students_found");
    }

    $conn->close();
}
?>

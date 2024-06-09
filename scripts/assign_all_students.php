<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $teacher_id = $_SESSION['user_id'];

    // Check if the course is managed by the logged-in teacher
    $stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ? AND teacher_id = ?");
    $stmt->bind_param("si", $course_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch all students
        $stmt = $conn->prepare("SELECT student_id FROM students");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $all_students_assigned = true;
            while ($row = $result->fetch_assoc()) {
                $student_id = $row['student_id'];
                // Assign each student to the course only if not already assigned
                $stmt_assign = $conn->prepare("INSERT INTO student_courses (student_id, course_id) 
                                               SELECT ?, ? FROM DUAL 
                                               WHERE NOT EXISTS (
                                                   SELECT 1 FROM student_courses 
                                                   WHERE student_id = ? AND course_id = ?
                                               )");
                $stmt_assign->bind_param("isis", $student_id, $course_id, $student_id, $course_id);
                if (!$stmt_assign->execute()) {
                    $all_students_assigned = false;
                }
                $stmt_assign->close();
            }

            if ($all_students_assigned) {
                header("Location: ../dashboard.php?message=all_students_assigned");
            } else {
                header("Location: ../dashboard.php?error=some_students_not_assigned");
            }
        } else {
            header("Location: ../dashboard.php?error=no_students_found");
        }
        $stmt->close();
    } else {
        header("Location: ../dashboard.php?error=not_authorized");
    }
    $conn->close();
}
?>

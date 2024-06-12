<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $prelim_grade = $_POST['prelim_grade'];
    $midterm_grade = $_POST['midterm_grade'];
    $final_grade = $_POST['final_grade'];
    // Calculate the overall grade (example: average of the grades)
    $overall_grade = ($prelim_grade + $midterm_grade + $final_grade) / 3;

    $teacher_id = $_SESSION['user_id'];

    // Check if the student is enrolled in the selected course and the course is managed by the logged-in teacher
    $checker = "SELECT 1 FROM student_courses sc
                JOIN courses c ON sc.course_id = c.course_id
                WHERE sc.student_id = ? AND sc.course_id = ? AND c.teacher_id = ?";
    $stmt = $conn->prepare($checker);
    $stmt->bind_param("isi", $student_id, $course_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Insert or update the grade
        $stmt = $conn->prepare("INSERT INTO grades (student_id, course_id, prelim_grade, midterm_grade, final_grade, overall_grade)
                                VALUES (?, ?, ?, ?, ?, ?)
                                ON DUPLICATE KEY UPDATE 
                                prelim_grade = VALUES(prelim_grade), 
                                midterm_grade = VALUES(midterm_grade), 
                                final_grade = VALUES(final_grade), 
                                overall_grade = VALUES(overall_grade)");
        $stmt->bind_param("isdddd", $student_id, $course_id, $prelim_grade, $midterm_grade, $final_grade, $overall_grade);

        if ($stmt->execute()) {
            header("Location: ../dashboard.php?message=grade_updated");
        } else {
            header("Location: ../dashboard.php?error=grade_update_failed");
        }
        $stmt->close();
    } else {
        header("Location: ../dashboard.php?error=course_not_assigned");
    }

    $conn->close();
}
?>

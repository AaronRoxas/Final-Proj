<?php
include "db_conn.php";
if (isset($_POST['student_id'], $_POST['course_id'], $_POST['prelim_grade'], $_POST['midterm_grade'], $_POST['final_grade'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $prelim_grade = $_POST['prelim_grade'];
    $midterm_grade = $_POST['midterm_grade'];
    $final_grade = $_POST['final_grade'];
    $overall_grade = ($prelim_grade + $midterm_grade + $final_grade) / 3;
    // Insert or update grades
    $sql = "INSERT INTO grades (student_id, course_id, prelim_grade, midterm_grade, final_grade, overall_grade) VALUES (?, ?, ?, ?, ?,?)
            ON DUPLICATE KEY UPDATE prelim_grade=VALUES(prelim_grade), midterm_grade=VALUES(midterm_grade), final_grade=VALUES(final_grade)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issddd", $student_id, $course_id, $prelim_grade, $midterm_grade, $final_grade, $overall_grade);

    if ($stmt->execute()) {
        echo "Grades added/updated successfully.";
        header("Location: ../dashboard.php");
    } else {
        echo "Error adding/updating grades: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

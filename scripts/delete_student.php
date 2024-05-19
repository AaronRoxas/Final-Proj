<?php
  include "db_conn.php";
  // Check if the form is submitted
  if (isset($_POST['submit'])) {
    // Get the student ID and course ID from the form
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Perform the deletion query
    $sql = "DELETE FROM student_courses WHERE student_id = ? AND course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $student_id, $course_id);

    if ($stmt->execute()) {
        echo "Course removed from student successfully.";
        header("Location: ../dashboard.php");
    } else {
        echo "Error removing course from student: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
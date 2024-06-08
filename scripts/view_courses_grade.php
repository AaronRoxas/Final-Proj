<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Fetch grades from the database for the selected course
    $stmt = $conn->prepare("SELECT s.user_name, c.course_name, g.prelim_grade, g.midterm_grade, g.final_grade, g.overall_grade 
                            FROM grades g 
                            JOIN students s ON g.student_id = s.student_id 
                            JOIN courses c ON g.course_id = c.course_id
                            WHERE g.course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the grades in the session
    $_SESSION['grades'] = [];
    while ($row = $result->fetch_assoc()) {
        
        $_SESSION['grades'][] = $row;
    }
    
    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
}

$conn->close();
?>

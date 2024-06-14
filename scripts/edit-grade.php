<?php
include 'db_conn.php'; // adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grade_id'], $_POST['prelim_grade'], $_POST['midterm_grade'], $_POST['final_grade'])) {
        $grade_id = $_POST['grade_id'];
        $prelim_grade = $_POST['prelim_grade'];
        $midterm_grade = $_POST['midterm_grade'];
        $final_grade = $_POST['final_grade'];
        $overall_grade = ($prelim_grade + $midterm_grade + $final_grade) / 3;

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE grades SET prelim_grade = ?, midterm_grade = ?, final_grade = ?, overall_grade = ? WHERE grade_id = ?");
        $stmt->bind_param("iiiii", $prelim_grade, $midterm_grade, $final_grade, $overall_grade, $grade_id);

        if ($stmt->execute()) {
            // Redirect back to the dashboard with a success message
            header('Location: ../dashboard.php?section=grade&message=grade_updated');
        } else {
            // Show an error message
            echo "Error updating grade.";
        }
        $stmt->close();
    }
}
?>

<?php
include 'db_conn.php'; // include your database connection

if (isset($_POST['grade_id'])) {
    $grade_id = $_POST['grade_id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM grades WHERE grade_id = ?");
    $stmt->bind_param("i", $grade_id);

    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header('Location: ../dashboard.php?message=grade_removed');
    } 
    $stmt->close();
}
?>

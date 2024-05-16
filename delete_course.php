<?php
  include "db_conn.php";
  if (isset($_POST['course_name'])) {
    $course_name = $_POST['course_name'];
    
    // Prepare the SQL delete statement
    $stmt = $conn->prepare("DELETE FROM courses WHERE course_name = ?");
    $stmt->bind_param("s", $course_name);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=course_deleted");
    } else {
        header("Location: dashboard.php?error=course_delete_failed");
    }
    $stmt->close();
    $conn->close();
  } else {
    header("Location: dashboard.php?error=invalid_request");
  }

?>
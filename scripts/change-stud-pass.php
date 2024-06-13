<?php
include "db_conn.php";
include "functions.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new passwords match
    if (isset($current_password) && isset($new_password) && isset($confirm_password)) {
        if ($new_password !== $confirm_password) {
            header("Location: ../change-settings-stud.php?error=pass_mismatch");
            exit();
        } else {
            // Fetch the current password hash from the database
            $stmt = $conn->prepare("SELECT user_password FROM students WHERE student_id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Verify the current password
            if (!verifyPass($current_password, $row['user_password'])) {
                header("Location: ../change-settings-stud.php?error=incorrect_pass");
                exit();
            }

            // Update the password in the database
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
            $stmt = $conn->prepare("UPDATE students SET user_password = ? WHERE student_id = ?");
            $stmt->bind_param("si", $new_password_hashed, $_SESSION['user_id']);

            if ($stmt->execute()) {
                header("Location: ../student-dashboard.php?message=pass_changed");
            } else {
                echo "Error changing password: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

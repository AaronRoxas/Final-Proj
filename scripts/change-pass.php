<?php
include "db_conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    // Check if the new passwords match
    if ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
        exit();
    }

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT user_password FROM teachers WHERE teacher_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verify the current password
    if ($current_password == $row['user_password']) {
        
        header("Location: ../change-settings.php?error=incorrect_pass");
        exit();
    }

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE teachers SET user_password = ? WHERE teacher_id = ?");
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        echo "Password changed successfully.";
        header("Location: ../dashboard.php");
    } else {
        echo "Error changing password: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

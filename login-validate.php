<?php
include "db_conn.php";
include "functions.php";

// Check if the 'email' key exists in the $_POST array
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass = validate($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT username, user_email, user_pass FROM user_info WHERE user_email=? AND user_pass=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Directly compare the user input with the database values
        if ($row['user_email'] === $email && $row['user_pass'] === $pass) {
            session_start();
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_email'] = $row['user_email'];
            header("Location: dashboard.php");
            exit();
        }
    }
}
// Redirect back to login.php with an error message
header("Location: login.php?error=info_mismatch");
exit();
?>

<?php 
include "db_conn.php";
include "functions.php";
session_start(); // Start the session

// Check if the 'email' key exists in the $_POST array
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass = validate($_POST['password']);
    
    // Check in the students table
    $stmt = $conn->prepare("SELECT user_name, email, user_password, student_id FROM students WHERE email=? AND user_password=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result_students = $stmt->get_result();

    // Check in the teachers table
    $stmt = $conn->prepare("SELECT user_name, email, user_password, teacher_id FROM teachers WHERE email=? AND user_password=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result_teachers = $stmt->get_result();

    if ($result_students->num_rows === 1 || $result_teachers->num_rows === 1) {
        $row = $result_students->num_rows === 1 ? $result_students->fetch_assoc() : $result_teachers->fetch_assoc();

        // Directly compare the user input with the database values
        if ($row['email'] === $email && $row['user_password'] === $pass) {
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $result_students->num_rows === 1 ? "s" : "t";

            if($_SESSION['user_role'] === "s"){
                $_SESSION['user_id'] = $row['student_id'];
                header('Location: ../student-dashboard.php');
                exit();
            }
            elseif($_SESSION['user_role'] === "t"){
                $_SESSION['user_id'] = $row['teacher_id'];
                header('Location: ../dashboard.php');
                exit();
            }
        }
    }
}
// Redirect back to login.php with an error message
header("Location: ../login.php?error=info_mismatch");
exit();
?>
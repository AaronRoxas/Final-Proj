<?php
include "functions.php";
include "db_conn.php";

$user_fName = $_POST["lname"];
$user_lName = $_POST["fname"];
$user_Email = $_POST["email"];
$user_Pass = $_POST["password"];
$user_Role = $_POST["role"];
$_SESSION["role"] = $user_Role;
$passVerification = $_POST["confirmPass"];
$studID = 0;
$teacherID = 0;

$sql = "SELECT 's' AS role FROM students WHERE email='$user_Email'
        UNION
        SELECT 't' AS role FROM teachers WHERE email='$user_Email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    header('Location:../registration.php?error=user_exists');
    exit;
}

// Check if password is at least 8 characters long
if (strlen($user_Pass) < 8 || strlen($passVerification) < 8) {
    header("Location: ../registration.php?error=password_too_short");
    exit;
}

// Check if password and confirmation match
if (verifyPass($user_Pass, $passVerification)) {
    // SQL query to insert user information into the database
    if (isset($user_Role)) {
        if ($user_Role == "t") {
            $teacherID = rand(9000, 10000);
            $sql = "INSERT INTO teachers (teacher_id, user_fName, user_lName, user_name, email, user_password, user_role)
                    VALUES ('$teacherID', '$user_fName', '$user_lName', CONCAT('$user_fName', ' ', '$user_lName'), '$user_Email', '$user_Pass', '$user_Role')";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                $registered = true;
                // Redirect to the dashboard page
                header('Location:../login.php?userCreated=true');
            } else {
                // Display error message if the query fails
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            // Close database connection
            $teacherID = 0;
            mysqli_close($conn);
            exit();
        } else if ($user_Role == "s") {
            $studID = rand(2000, 5000);
            $sql = "INSERT INTO students (student_id, user_fName, user_lName, user_name, email, user_password, user_role)
                    VALUES ('$studID', '$user_fName', '$user_lName', CONCAT('$user_fName', ' ', '$user_lName'), '$user_Email', '$user_Pass', '$user_Role')";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                $registered = true;
                // Redirect to the dashboard page
                header('Location:../login.php?userCreated=true');
            } else {
                // Display error message if the query fails
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            // Close database connection
            $studID = 0;
            mysqli_close($conn);
            exit();
        }
    }
} else {
    // Redirect back to the registration page with an error message
    header('Location:../registration.php?error=password_mismatch');
    exit;
}
?>

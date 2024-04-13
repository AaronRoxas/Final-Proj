<?php
$user_Email = $_POST["email"]; 
$user_Pass = $_POST["password"]; 
$serverName = "localhost"; 
$username = "root";
$password = "0121"; 
$dbname = "user_record"; 
$conn = mysqli_connect($serverName, $username, $password, $dbname); // Connect to the database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // If connection fails, stop script execution and show error message
}

function loginValidation($conn, $user_Email, $user_Pass)
{
    $sql1 = "SELECT * FROM user_info WHERE user_email = '$user_Email' AND user_pass = '$user_Pass'"; // SQL query to check if the user exists and the password is correct
    $result = mysqli_query($conn, $sql1); // Execute the query
    if ($result && mysqli_num_rows($result) > 0) { // If query is successful and returns at least one row (user exists and password is correct)
        echo "Logged In!"; // Display "Logged In!" message
        header('Location: dashboard.php'); // Redirect user to dashboard.php
        exit(); // Stop further script execution
    } else {
        header('Location: login.php?error=info_mismatch'); // If user does not exist or password is incorrect, redirect user to login.php with error message
        exit(); // Stop further script execution
    }
}

if (isset($user_Email, $user_Pass)) { // If both email and password are set (not null)
    loginValidation($conn, $user_Email, $user_Pass); // Call the loginValidation function to validate user login
}

mysqli_close($conn); // Close the database connection
?>

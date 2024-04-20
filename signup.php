<?php
$user_Name = $_POST["username"];
$user_Email = $_POST["email"];
$user_Pass = $_POST["password"];
$passVerification = $_POST["confirmPass"];
$serverName = "localhost";
$username = "root";
$password = "0121";
$dbname = "user_record";
$conn = mysqli_connect($serverName,$username,$password,$dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Function to verify if the password matches the confirmation
function verifyPass($user_Pass, $passVerification){
    return $user_Pass == $passVerification;
}

$sql = "SELECT * FROM user_info WHERE user_email='$user_Email'";
$result = mysqli_query($conn, $sql);
if($result && mysqli_num_rows($result) > 0){
    header('Location:registration.php?error=user_exists');
    exit;
}


// Check if password and confirmation match
if(verifyPass($user_Pass,$passVerification)){

    
    // SQL query to insert user information into the database
    $sql = "INSERT into user_info (username,user_email,user_pass,confirm_Pass)
            VALUES ('$user_Name','$user_Email','$user_Pass','$passVerification')";
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        $registered = true;
        // Redirect to the dashboard page
        header('Location:dashboard.php');
    } else {
        // Display error message if the query fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    // Close database connection
    mysqli_close($conn);
} else {
    // Redirect back to the registration page with an error message
    header('Location:registration.php?error=password_mismatch');
    exit; // Stop further execution of script
}
?>

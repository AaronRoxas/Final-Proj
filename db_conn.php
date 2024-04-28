<?php
$sname= "localhost";
$uname= "root";
$password = "0121";
$db_name = "user_record";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}
?>
<?php
include("db_conn.php");
$sql = $conn->prepare( "SELECT user_name , user_password from students where user_name =?, user_password=?");
$sql->bind_param("ss",$student['user_name'],$student['user_password']);

if($sql->execute() ) {
    $stmt = $conn->prepare('UPDATE students');
}
?>
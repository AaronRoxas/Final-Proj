<?php session_start();
include "db_conn.php";
  function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    function verifyPass($user_Pass, $passVerification){
      return $user_Pass == $passVerification;
  }
?>
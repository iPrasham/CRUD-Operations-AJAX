<?php 
 $servername = "localhost";
 $username = "prasham";
 $password = "12345678";
 $dbname = "users";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if($conn->connect_error){ 
  die("Connection failed: ".$conn->connect_error);
 }

 //echo "Connected successfully";
?>

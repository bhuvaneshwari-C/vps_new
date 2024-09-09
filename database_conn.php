<?php
 
 $servername="localhost";
 $db_username="root";
 $db_password="password";
 $dbname = "vps_pumps_corporation";

 $conn = new mysqli($servername, $db_username, $db_password, $dbname);

 if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
 }
 
 ?>
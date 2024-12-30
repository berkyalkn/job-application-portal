<?php

$servername = "localhost"; 
$username = "abc";    
$password = "abc";  
$dbname = "group1"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
}
?>


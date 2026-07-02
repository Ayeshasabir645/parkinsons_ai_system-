<?php
$host   = "localhost";
$db     = "parkinsons_db";   
$user   = "root";             
$pass   = "";                 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("❌ Connection Failed: " . mysqli_connect_error());
}
?>

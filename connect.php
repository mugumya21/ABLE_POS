<?php
// // Database configuration
// $db_host = "localhost";
// $db_username = "paradiseagents_root";
// $db_password = "V.1901200229@MUNI";
// $db_name = "paradiseagents_db";

// // Create database connection
// $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }


// for the one in the server db below code



// Database configuration for local xampp server
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "hostsales";

// Create database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>

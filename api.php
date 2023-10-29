<?php
// Start session
session_start();

// Database configuration
$db_host = "localhost";
$db_username = "paradiseagents_root";
$db_password = "V.1901200229@MUNI";
$db_name = "paradiseagents_db";

// Create database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the raw POST data
$data = file_get_contents("php://input");

// Decode JSON data
$request = json_decode($data, true);

// Check if 'action' key exists in the request
if (isset($request['action'])) {
    $action = $request['action'];

    if ($action === "login") {
        // Handle login action
        if (isset($request['username']) && isset($request['password'])) {
            $login = mysqli_real_escape_string($conn, $request['username']);
            $password = mysqli_real_escape_string($conn, $request['password']);

            $query = "SELECT * FROM user WHERE username='$login' AND password='$password'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                // Login successful
                $response = array(
                    "status" => "success",
                    "message" => "Login successful"
                );
            } else {
                // Login failed
                $response = array(
                    "status" => "error",
                    "message" => "Invalid username or password"
                );
            }
        } else {
            // Invalid request parameters
            $response = array(
                "status" => "error",
                "message" => "Invalid request parameters"
            );
        }
    } elseif ($action === "signup") {
        // Handle signup action
        if (isset($request['username']) && isset($request['password']) && isset($request['name'])) {
            $username = mysqli_real_escape_string($conn, $request['username']);
            $password = mysqli_real_escape_string($conn, $request['password']);
            $name = mysqli_real_escape_string($conn, $request['name']);

            // Insert new user into the database
            $insert_query = "INSERT INTO user (username, password, name) VALUES ('$username', '$password', '$name')";
            if (mysqli_query($conn, $insert_query)) {
                // Signup successful
                $response = array(
                    "status" => "success",
                    "message" => "Signup successful"
                );
            } else {
                // Signup failed
                $response = array(
                    "status" => "error",
                    "message" => "Signup failed"
                );
            }
        } else {
            // Invalid request parameters
            $response = array(
                "status" => "error",
                "message" => "Invalid request parameters"
            );
        }
    } else {
        // Invalid action
        $response = array(
            "status" => "error",
            "message" => "Invalid action"
        );
    }
} else {
    // No action provided
    $response = array(
        "status" => "error",
        "message" => "No action provided"
    );
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

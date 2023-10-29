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
if (isset($request['action']) && $request['action'] === "customer") {
    // Handle customer action
    // Query to fetch customer data
    $customerQuery = "SELECT customer_id, customer_name, address, contact FROM customer";
    $customerResult = mysqli_query($conn, $customerQuery);

    if ($customerResult && mysqli_num_rows($customerResult) > 0) {
        $customers = array();
        while ($row = mysqli_fetch_assoc($customerResult)) {
            $customers[] = $row;
        }
        $response = array(
            "status" => "success",
            "message" => "Customers data fetched successfully",
            "customers" => $customers
        );
    } else {
        // No customers found
        $response = array(
            "status" => "error",
            "message" => "No customers found"
        );
    }
} else {
    // Invalid or no action provided
    $response = array(
        "status" => "error",
        "message" => "Invalid action or no action provided"
    );
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

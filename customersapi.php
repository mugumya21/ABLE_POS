<?php
// Start session
session_start();

// Database configuration
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

// Get the raw POST data
$data = file_get_contents("php://input");

// Decode JSON data
$request = json_decode($data, true);

// Check if 'action' key exists in the request
if (isset($request['action']) && $request['action'] === "patient") {
    // Handle patient action
    // Query to fetch patient data
    $patientQuery = "SELECT patient_id, patient_name, address, contact FROM patient";
    $patientResult = mysqli_query($conn, $patientQuery);

    if ($patientResult && mysqli_num_rows($patientResult) > 0) {
        $patients = array();
        while ($row = mysqli_fetch_assoc($patientResult)) {
            $patients[] = $row;
        }
        $response = array(
            "status" => "success",
            "message" => "Patients data fetched successfully",
            "patients" => $patients
        );
    } else {
        // No patient found
        $response = array(
            "status" => "error",
            "message" => "No patients found"
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

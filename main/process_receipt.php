<?php
// Include your database connection script
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostsales";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartData = json_decode($_POST["cartData"], true);
    $patientName = $_POST["patientName"];
    $paymentMode = $_POST["paymentMode"];

    // Calculate the total amount based on the cart data
    $totalAmount = 0;
    foreach ($cartData as $item) {
        $totalAmount += $item["total"];
    }

    // Insert receipt data into the 'receipts' table
    $insertReceiptQuery = "INSERT INTO receipts (patient_name, payment_mode, total_amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertReceiptQuery);
    $stmt->bind_param("ssd", $patientName, $paymentMode, $totalAmount);

    if ($stmt->execute()) {
        // Receipt data successfully inserted
        echo "success";
    } else {
        // If an error occurs, provide an error message
        echo "Database error: " . $stmt->error;
    }
}

$conn->close();
?>

<?php
// Configuration - Include your database connection script
include('../connect.php');

// New data
$id = $_POST['memi'];
$customer_name = $_POST['customer_name'];
$dr_amount = $_POST['dr_amount'];
$cr_amount = $_POST['cr_amount'];
$details = $_POST['details'];

// Prepare the SQL query
$sql = "UPDATE customersledger 
        SET customer_name=?, dr_amount=?, cr_amount=?, details=?
        WHERE customersledger_id=?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('ssssi', $customer_name, $dr_amount, $cr_amount, $details, $id);

// Execute the query
if ($stmt->execute()) {
    // Redirect to customersledger.php if the update was successful
    header("location: customersledger.php");
} else {
    // Handle the case where the update failed
    echo "Update failed: " . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

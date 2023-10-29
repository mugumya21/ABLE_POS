<?php
// Configuration - Include your database connection script
include('../connect.php');

// New data
$id = $_POST['memi'];
$name = $_POST['name'];
$address = $_POST['address'];
$contact = $_POST['contact'];


// Prepare the SQL query
$sql = "UPDATE customer 
        SET customer_name=?, address=?, contact=?
		WHERE customer_id=?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('sssi', $name, $address, $contact, $id);

// Execute the query
if ($stmt->execute()) {
    // Redirect to customer.php if the update was successful
    header("location: customer.php");
} else {
    // Handle the case where the update failed
    echo "Update failed: " . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

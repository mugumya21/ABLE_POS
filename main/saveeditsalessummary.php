<?php
// Configuration - Include your database connection script
include('../connect.php');

// New data
$id = $_POST['memi'];
$sales_type = $_POST['sales_type'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$comment = $_POST['comment'];

// Prepare the SQL query
$sql = "UPDATE salessummary 
        SET sales_type=?, date=?, amount=?, comment=?
        WHERE salessummary_id=?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('ssssi', $sales_type, $date, $amount, $comment, $id);

// Execute the query
if ($stmt->execute()) {
    // Redirect to customersledger.php if the update was successful
    header("location: salessummary.php");
} else {
    // Handle the case where the update failed
    echo "Update failed: " . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

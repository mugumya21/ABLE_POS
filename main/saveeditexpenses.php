<?php
// Configuration - Include your database connection script
include('../connect.php');

// New data
$id = $_POST['memi'];
$expense_type = $_POST['expense_type'];
$date = $_POST['date'];
$amount_spent = $_POST['amount_spent'];
$comment = $_POST['comment'];

// Prepare the SQL query
$sql = "UPDATE expenses 
        SET expense_type=?, date=?, amount_spent=?, comment=?
        WHERE expenses_id=?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param('ssssi', $expense_type, $date, $amount, $comment, $id);

// Execute the query
if ($stmt->execute()) {
    // Redirect to customersledger.php if the update was successful
    header("location: expenses.php");
} else {
    // Handle the case where the update failed
    echo "Update failed: " . $conn->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

<?php
session_start();
include('../connect.php');

$sales_type = $_POST['sales_type'];
$dateFromForm = $_POST['date'];
$amount = $_POST['amount'];
$comment = $_POST['comment'];

// Verify that the sales type, date, and amount are not empty
if (empty($sales_type) || empty($dateFromForm) || empty($amount)) {
    $_SESSION['error_message'] = "Sales type, date, amount are required fields.";
    header("location: salessummary.php");
    exit();
}

// Format the date to 'YYYY-MM-DD' format
$formattedDate = date('Y-m-d', strtotime($dateFromForm));

// Begin a transaction
$conn->begin_transaction();

try {
    // Calculate the total amount from existing records in salessummary
    $getExistingRecordsQuery = "SELECT SUM(amount) as total_amount FROM salessummary WHERE date = ?";
    $getExistingRecordsStmt = $conn->prepare($getExistingRecordsQuery);
    $getExistingRecordsStmt->bind_param("s", $formattedDate); // Bind the formatted date parameter
    $getExistingRecordsStmt->execute();
    $getExistingRecordsStmt->bind_result($totalAmount);
    $getExistingRecordsStmt->fetch();
    $getExistingRecordsStmt->close();

    // Handle the case where there are no existing records (totalAmount is NULL)
    if ($totalAmount === null) {
        $totalAmount = 0;
    }

    // Update the amount in cashathand table
    $updatedAmount = $totalAmount + $amount; // Calculate total amount including the new record
    $updateCashAtHandQuery = "UPDATE cashathand SET amount = ?";
    $updateCashAtHandStmt = $conn->prepare($updateCashAtHandQuery);
    $updateCashAtHandStmt->bind_param("d", $updatedAmount);

    if (!$updateCashAtHandStmt->execute()) {
        throw new Exception("Failed to update cashathand table: " . $conn->error);
    }
    $updateCashAtHandStmt->close();

    // Insert the sales record into the salessummary table
    $insertSalesQuery = "INSERT INTO salessummary (sales_type, date, amount, comment) VALUES (?, ?, ?, ?)";
    $insertSalesStmt = $conn->prepare($insertSalesQuery);
    $insertSalesStmt->bind_param("ssds", $sales_type, $formattedDate, $amount, $comment);

    if (!$insertSalesStmt->execute()) {
        throw new Exception("Failed to insert sales record: " . $conn->error);
    }
    $insertSalesStmt->close();

    // Commit the transaction
    $conn->commit();

    header("location: salessummary.php"); // Replace with the appropriate success page URL
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    $_SESSION['error_message'] = "Error: " . $e->getMessage();
    header("location: salessummary.php"); // Replace with the appropriate error page URL
    exit();
} finally {
    // Close the connection
    $conn->close();
}
?>

<?php
session_start();
include('../connect.php');
$accountType = $_POST['account_type'];
$accountName = $_POST['account_name'];

// Determine the table based on the account type
$tableName = ($accountType === 'Cash') ? 'salessummary' : 'bankaccounts';

// query
$sql = "INSERT INTO $tableName (account_name) VALUES (?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("s", $accountName) && $q->execute()) {
    header("location: cashaccounts.php");
} else {
    die("Execute failed: " . $q->error);
}
?>

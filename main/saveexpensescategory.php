<?php
session_start();
include('../connect.php');
$a = $_POST['expense_type'];


// query
$sql = "INSERT INTO expensescategory (expense_type) VALUES (?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("s", $a) && $q->execute()) {
    header("location: expenses.php");
} else {
    die("Execute failed: " . $q->error);
}
?>

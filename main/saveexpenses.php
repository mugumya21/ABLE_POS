<?php
session_start();
include('../connect.php');
$a = $_POST['amount_spent'];
$b = $_POST['comment'];
$c = $_POST['date'];
$d= $_POST['expense_type'];

// query
$sql = "INSERT INTO expenses (amount_spent, comment, date, expense_type) VALUES (?, ?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("ssss", $a, $b, $c, $d) && $q->execute()) {
    header("location: expenses.php");
} else {
    die("Execute failed: " . $q->error);
}
?>

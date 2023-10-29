<?php
session_start();
include('../connect.php');
$a = $_POST['customer_name'];
$b = $_POST['date'];
$c = $_POST['dr_amount'];
$d = $_POST['cr_amount'];
$e = $_POST['details'];


// query
$sql = "INSERT INTO customersledger (customer_name, date, dr_amount, cr_amount, details) VALUES (?, ?, ?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("sssss", $a, $b, $c, $d, $e) && $q->execute()) {
    header("location: customersledger.php");
} else {
    die("Execute failed: " . $q->error);
}
?>


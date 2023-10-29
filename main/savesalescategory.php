<?php
session_start();
include('../connect.php');
$a = $_POST['sales_type'];


// query
$sql = "INSERT INTO salescategory (sales_type) VALUES (?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("s", $a) && $q->execute()) {
    header("location: salessummary.php");
} else {
    die("Execute failed: " . $q->error);
}
?>

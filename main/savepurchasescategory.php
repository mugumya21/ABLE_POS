<?php
session_start();
include('../connect.php');
$a = $_POST['purchases_type'];


// query
$sql = "INSERT INTO purchasescategory (purchases_type) VALUES (?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("s", $a) && $q->execute()) {
    header("location: purchaseslist.php");
} else {
    die("Execute failed: " . $q->error);
}
?>
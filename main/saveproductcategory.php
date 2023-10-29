<?php
session_start();
include('../connect.php');
$a = $_POST['product_type'];


// query
$sql = "INSERT INTO productcategory (product_type) VALUES (?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("s", $a) && $q->execute()) {
    header("location: products.php");
} else {
    die("Execute failed: " . $q->error);
}
?>
